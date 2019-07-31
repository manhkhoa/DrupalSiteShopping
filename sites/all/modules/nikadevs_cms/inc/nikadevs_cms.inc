<?php 

function _nikadevs_render_block($module, $delta) {
  $block = block_load($module, $delta);
  return isset($block->theme) ? _block_get_renderable_array(_block_render_blocks(array($block))) : array();
}

function _nikadevs_cms_get_active_layout() {
  $layout = &drupal_static(__FUNCTION__);
  if (!isset($layout)) {
    $current_theme = variable_get('theme_default', 'none');
    $layouts = variable_get('nikadevs_cms_layout_' . $current_theme, array());
    $active_layout = 'layout-default';
    foreach($layouts as $layout_key => $layout) {
      if(!empty($layout['pages'])) {
        $pages = drupal_strtolower($layout['pages']);
        // Convert the Drupal path to lowercase
        $path = drupal_strtolower(drupal_get_path_alias($_GET['q']));
        // Compare the lowercase internal and lowercase path alias (if any).
        $page_match = drupal_match_path($path, $pages);
        if ($path != $_GET['q']) {
          $page_match = $page_match || drupal_match_path($_GET['q'], $pages);
        }
        // If match found - use this layout
        if($page_match) {
          $active_layout = $layout_key;
          break;
        }
      }
    }
    
    if(!isset($layouts[$active_layout])) {
      return array();
    }
    $layout = $layouts[$active_layout];
    unset($layout['rows']['id-0']);
    foreach($layout['rows'] as $key => $row) {
      // If selected "Use row from Default Layout"
      if(isset($layout['rows'][$key]['settings']['use_default']) && $layout['rows'][$key]['settings']['use_default']) {
        foreach($layouts['layout-default']['rows'] as $default_key => $default_row) {
          if($row['name'] == $default_row['name']) {
            // Update Region Settings
            $layout['rows'][$key] = $default_row;
            // Remove regions for current Row
            foreach($layout['regions'] as $key_region => $region){
              if($region['row_id'] == $key) {
                unset($layout['regions'][$key_region]);
              }
            }
            // Add Regions from 'Default' Layout
            foreach($layouts['layout-default']['regions'] as $key_region => $region){
              if($region['row_id'] == $default_key) {
                $region['row_id'] = $key;
                $layout['regions'][$key_region] = $region;
              }
            }
            break;
          }
        }
      }
      // Process "Paddings" settings
      $paddings = array('padding_left', 'padding_right', 'padding_top', 'padding_bottom');
      foreach($paddings as $padding) {
        if(isset($layout['rows'][$key]['settings'][$padding]) && is_numeric($layout['rows'][$key]['settings'][$padding])) {
          $layout['rows'][$key]['wrap']['attributes']['style'] = isset($layout['rows'][$key]['wrap']['attributes']['style']) ? $layout['rows'][$key]['wrap']['attributes']['style'] : '';
          $layout['rows'][$key]['wrap']['attributes']['style'] .= str_replace('_', '-', $padding) . ': ' . $layout['rows'][$key]['settings'][$padding] . 'px; ';
        }
      }
      $layout['rows'][$key]['wrap']['attributes']['class'] = array('nd-region');
      // Made ID value is SEO friendly
      $layout['rows'][$key]['id'] = $layout['rows'][$key]['attributes']['id'];
      $layout['rows'][$key]['attributes']['id'] = preg_replace('/[^\p{L}\p{N}]/u', '-', $layout['rows'][$key]['name']);
      if(isset($layout['rows'][$key]['settings']['class'])) {
        $layout['rows'][$key]['wrap']['attributes']['class'][] = $layout['rows'][$key]['settings']['class'];
      }
      $layout['rows'][$key]['settings']['prefix'] = isset($layout['rows'][$key]['settings']['prefix']) ? $layout['rows'][$key]['settings']['prefix'] : '';
      $layout['rows'][$key]['settings']['suffix'] = isset($layout['rows'][$key]['settings']['suffix']) ? $layout['rows'][$key]['settings']['suffix'] : '';
      // Process Background settings
      if (isset($row['settings']['bg_image_type']) && $row['settings']['bg_image_type'] == 'image' && isset($row['settings']['bg_image_fid']) && $row['settings']['bg_image_fid'] && ($file = file_load($row['settings']['bg_image_fid']))) {
        $bg_image = '<div class="fwb-bg ' . (isset($row['settings']['bg_image_parallax']) && $row['settings']['bg_image_parallax'] ? 'fwb-parallax' : '') . ' fwb-fixed" style = "background-image: url(\'' . file_create_url($file->uri) . '\');" data-stellar-background-ratio="0.5" data-stellar-vertical-offset="200">
        ' . (isset($row['settings']['bg_image_overlay']) && $row['settings']['bg_image_overlay'] ? '<div class="overlay"></div>' : '') . '
        </div>';
        $layout['rows'][$key]['settings']['prefix'] .= $bg_image;
        $layout['rows'][$key]['wrap']['attributes']['class'][] = 'full-width-box';
        drupal_add_js(drupal_get_path('module', 'nikadevs_cms') . '/js/jquery.stellar.min.js');
        drupal_add_css(drupal_get_path('module', 'nikadevs_cms') . '/css/jquery.stellar.css');
      }
      // Process Video Background
      elseif (isset($row['settings']['bg_image_type']) && $row['settings']['bg_image_type'] == 'video' && $row['settings']['bg_video']) {
        $bg_video = '<div id = "wrap-' . $layout['rows'][$key]['attributes']['id'] . '" data-stellar-background-ratio = "0.7">
          <a id="video" class="player" data-property="{videoURL: \'' . $row['settings']['bg_video'] . '\', containment:\'#wrap-' . $layout['rows'][$key]['attributes']['id'] . '\', showControls:true, autoPlay:true, loop:true, mute:true, startAt:0, opacity:1, addRaster:false, quality:\'default\'}"></a>';
        $layout['rows'][$key]['settings']['prefix'] .= $bg_video;
        $layout['rows'][$key]['settings']['prefix'] .= isset($row['settings']['bg_video_overlay']) && $row['settings']['bg_video_overlay'] ? '<div class="overlay"></div>' : '';
        $layout['rows'][$key]['settings']['suffix'] .= '</div>';
        $layout['rows'][$key]['wrap']['attributes']['class'][] = 'full-width-box';
        drupal_add_js(drupal_get_path('module', 'nikadevs_cms') . '/js/jquery.mb.YTPlayer.js');
        drupal_add_css(drupal_get_path('module', 'nikadevs_cms') . '/css/YTPlayer.css');
      }
      if(isset($row['settings']['row_container']) && $row['settings']['row_container']) {
        $layout['rows'][$key]['settings']['prefix'] .= '<div class = "container">';
        $layout['rows'][$key]['settings']['suffix'] .= '</div>';
      }
    }
  }
  return $layout;
}

function _nikadevs_cms_active_layout($vars) {
  $layout = &drupal_static(__FUNCTION__);
  if (isset($layout)) {
    return $layout;
  }
  $layout = _nikadevs_cms_get_active_layout();
  // Fill out Layout with content
  foreach($layout['regions'] as $key => $region) {
    if($region['row_id'] == 'id-0') {
      unset($layout['regions'][$key]);
    }
    else {
      if (isset($region['settings']['animation']) && !empty($region['settings']['animation'])) {
        $layout['regions'][$key]['attributes']['data-animation'] = $region['settings']['animation'];
      }
      if (isset($region['settings']['delay']) && !empty($region['settings']['delay'])) {
        $layout['regions'][$key]['attributes']['data-animation-delay'] = $region['settings']['delay'];
      }
      // Process "Paddings" settings
      $paddings = array('padding_left', 'padding_right', 'padding_top', 'padding_bottom');
      foreach($paddings as $padding) {
        if(isset($region['settings'][$padding]) && is_numeric($region['settings'][$padding])) {
          $layout['regions'][$key]['attributes']['style'] = isset($layout['regions'][$key]['attributes']['style']) ? $layout['regions'][$key]['attributes']['style'] : '';
          $layout['regions'][$key]['attributes']['style'] .= str_replace('_', '-', $padding) . ': ' . $region['settings'][$padding] . 'px; ';
        }
      }
      $layout['regions'][$key]['attributes']['class'][] = isset($region['settings']['class']) ? $region['settings']['class'] : '';
      $layout['regions'][$key]['settings']['tag'] = isset($region['settings']['tag']) ? ($region['settings']['tag'] == 'none' ? '' : $region['settings']['tag']) : 'div';
      if (isset($region['settings']['block_id'])) {
        list($module, $delta) = explode('|', $region['settings']['block_id']);
        $render = _nikadevs_render_block($module, $delta);
        $layout['regions'][$key]['content'] = render($render);
      }
      else {
        $layout['regions'][$key]['content'] = isset($vars['page'][$key]) ? render($vars['page'][$key]) : '';
      }
    }
  }
  return $layout;
}

/**
* Parse user link into correct url
*/
function nikadevs_parse_url($link = '') {
  $href = !empty($link) ? $link : '#';
  if(strpos($href, '#') === FALSE) {
    $url = drupal_parse_url($href);
    $href = url($url['path'], $url);
  }
  return $href;
}