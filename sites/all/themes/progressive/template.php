<?php

function _count_comments($val) {
  return isset($val['#comment']);
}

function _print_views_fields($fields, $exceptions) {
  //global $one; if(!$one) { dpm($fields); $one = 1; }

  foreach ($fields as $field_name => $field) {
    if (!in_array($field_name, $exceptions)) {
      print $field->content;
    }
  }
}

/**
 * Implementation of hook_preprocess_html().
 */
function progressive_preprocess_html(&$variables) {
  global $language;
  $css_customizer = theme_get_setting('skin') . '-pages-customizer.css';
  drupal_add_css(drupal_get_path('theme', 'progressive') . '/css/customizer/' . $css_customizer, array('group' => CSS_THEME));
  drupal_add_css(drupal_get_path('theme', 'progressive_sub') . '/css/custom.css', array('group' => CSS_THEME));
  if($language->dir == 'rtl') {
    drupal_add_css(drupal_get_path('theme', 'progressive') . '/css/drupal-rtl.css', array('group' => CSS_THEME));
  }
  drupal_add_js(array(
    'theme_path' => drupal_get_path('theme', 'progressive'),
    'basePath' => base_path(),
    'progressive' => array(
      'mobile_menu_toggle' => theme_get_setting('mobile_menu_toggle')
    ),
    'ubercart_currency' => variable_get('uc_currency_sign')
  ), 'setting');
  // Page 404
  if(arg(0) == 'page-404-bg') {
    $variables['classes_array'][] = 'page-404-promo';
  }
  // Login Page
  global $user;
  if (arg(0) == 'user' && (in_array(arg(1), array('register', 'password', 'login')) || (arg(1) == '' && !$user->uid))) {
    $variables['classes_array'][] = 'page-login-promo';
  }
  if(theme_get_setting('boxed') || ($_GET['q'] == 'node/107' && strpos($_SERVER['HTTP_HOST'], 'nikadevs') !== FALSE)) {
    $variables['classes_array'][] = 'boxed';
  }
  $layout = _nikadevs_cms_get_active_layout();
  $one_page = isset($layout['settings']['one_page']) && $layout['settings']['one_page'] ? 1 : 0; 
  if(theme_get_setting('header_top_menu') && !in_array($_GET['q'], array('user/login', 'user/register', 'user/password')) && !$one_page) {
    $variables['classes_array'][] = 'hidden-top';
  }
  if(theme_get_setting('header_top_fixed')) {
    $variables['classes_array'][] = 'fixed-top';
  }
  if($one_page) {
    $variables['classes_array'][] = 'one-page';
  }
}

/**
 * Implementation of hook_preprocess_page().
 */
function progressive_preprocess_page(&$vars, $hook) {
  global $user;
  if (arg(0) == 'user' && (arg(1) == 'register' || arg(1) == 'password' || (arg(1) == '' && !$user->uid))) {
    $vars['theme_hook_suggestions'][] = 'page__user__login';
  }
}

/**
 * Implementation of hook_preprocess_page().
 */
function progressive_preprocess_block(&$variables) {
  if(strpos($variables['block']->delta, 'latest_posts') === 0) {
    $variables['title_prefix']['read_more']['#markup'] = '<a href="' . url('blog') . '" class="btn btn-default">' . t('All posts') . ' <i class="icon-arrow-right icon-white"></i></a>';
  }
}

/**
 * Overrides theme_menu_tree().
 */
function progressive_menu_tree__main_menu(&$variables) {
  return $variables['tree'];
}

/**
 * Implementation of hook_css_alter().
 */
function progressive_css_alter(&$css) {
  // Disable standart css from ubercart
  unset($css[drupal_get_path('module', 'system') . '/system.menus.css']);
  unset($css[drupal_get_path('module', 'system') . '/system.theme.css']);
  unset($css[drupal_get_path('module', 'search') . '/search.css']);
  unset($css[drupal_get_path('module', 'uc_cart') . '/uc_cart.css']);
  unset($css[drupal_get_path('module', 'uc_product') . '/uc_product.css']);
}

function progressive_menu_link(array $variables) {
  $element = $variables['element'];
  $sub_menu = '';

  if ($element['#below']) {
    $element['#attributes']['class'][] = 'parent';
    unset($element['#below']['#theme_wrappers']);
    $sub_menu = '<ul class = "sub">' . drupal_render($element['#below']) . '</ul>';
  }
  $output = l($element['#title'], $element['#href'], $element['#localized_options']);
  if (($element['#href'] == $_GET['q'] || ($element['#href'] == '<front>' && drupal_is_front_page())) && (empty($element['#localized_options']['language']))) {
    $element['#attributes']['class'][] = 'active';
  }
  return '<li' . drupal_attributes($element['#attributes']) . '>' . $output . $sub_menu . "</li>\n";
}

/**
 * Implementation of hook_js_alter()
 */
function progressive_js_alter(&$javascript) {
  if(isset($javascript['misc/jquery.js'])) {
    $javascript['misc/jquery.js']['data'] = drupal_get_path('theme', 'progressive') . '/js/jquery-1.11.0.min.js';
  }
}

/**
 * Update status messages
*/
function progressive_status_messages($variables) {
  $display = $variables['display'];
  $output = '';

  $status_heading = array(
    'status' => t('Status message'),
    'error' => t('Error message'),
    'warning' => t('Warning message'),
  );
  $types = array(
    'status' => 'success',
    'error' => 'danger',
    'warning' => 'warning',
  );
  foreach (drupal_get_messages($display) as $type => $messages) {
    $output .= "<div class=\"alert alert-dismissable alert-" . $types[$type] . "\">\n<button type='button' class='close' data-dismiss='alert'>×</button>";
    if (!empty($status_heading[$type])) {
      $output .= '<h2 class="element-invisible">' . $status_heading[$type] . "</h2>\n";
    }
    if (count($messages) > 1) {
      $output .= " <ul>\n";
      foreach ($messages as $message) {
        $output .= '  <li>' . $message . "</li>\n";
      }
      $output .= " </ul>\n";
    }
    else {
      $output .= $messages[0];
    }
    $output .= "</div>\n";
  }
  return $output;
}

/**
 * Overrides theme_item_list().
 */
function progressive_item_list($vars) {
  if (isset($vars['attributes']['class']) && is_array($vars['attributes']['class']) && in_array('pager', $vars['attributes']['class'])) {
    foreach($vars['items'] as $i => $item) {
      if(in_array('pager-current', $item['class'])) {
        $vars['items'][$i]['data'] = '<span>' . $item['data'] . '</span>';
        $vars['items'][$i]['class'][] = 'active';
      }
    }
    $styles = array(1 => 'pagination', 2 => 'pagination pagination-lg', 3 => 'pagination', 4 => 'pagination pagination-sm');
    $vars['attributes']['class'][] = $styles[theme_get_setting('pager') ? theme_get_setting('pager') : 1];
    return '<div class="pagination-box">' . theme_item_list($vars) . '</div>';
  }
  return theme_item_list($vars);
}

function progressive_pager_link($variables) {
  $text = $variables['text'];
  $page_new = $variables['page_new'];
  $element = $variables['element'];
  $parameters = $variables['parameters'];
  $attributes = $variables['attributes'];

  $page = isset($_GET['page']) ? $_GET['page'] : '';
  if ($new_page = implode(',', pager_load_array($page_new[$element], $element, explode(',', $page)))) {
    $parameters['page'] = $new_page;
  }

  $query = array();
  if (count($parameters)) {
    $query = drupal_get_query_parameters($parameters, array());
  }
  if ($query_pager = pager_get_query_parameters()) {
    $query = array_merge($query, $query_pager);
  }

  // Set each pager link title
  if (!isset($attributes['title'])) {
    static $titles = NULL;
    if (!isset($titles)) {
      $titles = array(
        t('«') => t('Go to first page'),
        t('‹') => t('Go to previous page'),
        t('›') => t('Go to next page'),
        t('»') => t('Go to last page'),
      );
    }
    if (isset($titles[$text])) {
      $attributes['title'] = $titles[$text];
    }
    elseif (is_numeric($text)) {
      $attributes['title'] = t('Go to page @number', array('@number' => $text));
    }
  }
  $replace_titles = array(
    t('« first') => '<i class="fa fa-angle-double-left"></i>',
    t('‹ previous') => '<i class="fa fa-angle-left"></i>',
    t('next ›') => '<i class="fa fa-angle-right"></i>',
    t('last »') => '<i class="fa fa-angle-double-right"></i>',
  );
  $text = isset($replace_titles[$text]) ? $replace_titles[$text] : check_plain($text);

  $attributes['href'] = url($_GET['q'], array('query' => $query));
  return '<a' . drupal_attributes($attributes) . '>' . $text . '</a>';
}

/**
 * Overrides theme_form_element_label().
 */
function progressive_form_element_label(&$variables) {
  $element = $variables['element'];
  $skip = (isset($element['#type']) && ('checkbox' === $element['#type'] || 'radio' === $element['#type']));
  if ((!isset($element['#title']) || $element['#title'] === '' && !$skip) && empty($element['#required'])) {
    return '';
  }
  $required = !empty($element['#required']) ? theme('form_required_marker', array('element' => $element)) : '';
  $title = filter_xss_admin($element['#title']);
  $attributes = array();
  if ($element['#title_display'] == 'after' && !$skip) {
    $attributes['class'][] = $element['#type'];
  }
  elseif ($element['#title_display'] == 'invisible') {
    $attributes['class'][] = 'element-invisible';
  }
  if (!empty($element['#id'])) {
    $attributes['for'] = $element['#id'];
  }
  $output = '';
  if (isset($variables['#children'])) {
    $output .= $variables['#children'];
  }
  $output .= t('!title !required', array('!title' => $title, '!required' => $required));
  return ' <label' . drupal_attributes($attributes) . '>' . $output . "</label>\n";
}


/**
 * Implements theme_form_element().
 */
function progressive_form_element(&$variables) {
  $element = &$variables['element'];
  $is_checkbox = FALSE;
  $is_radio = FALSE;
  $element += array(
    '#title_display' => 'before',
  );
  if (isset($element['#markup']) && !empty($element['#id'])) {
    $attributes['id'] = $element['#id'];
  }
  if (isset($element['#parents']) && form_get_error($element)) {
    $attributes['class'][] = 'error';
  }
  if (!empty($element['#type'])) {
    $attributes['class'][] = 'form-type-' . strtr($element['#type'], '_', '-');
  }
  if (!empty($element['#name'])) {
    $attributes['class'][] = 'form-item-' . strtr($element['#name'], array(
        ' ' => '-',
        '_' => '-',
        '[' => '-',
        ']' => '',
      ));
  }
  if (!empty($element['#attributes']['disabled'])) {
    $attributes['class'][] = 'form-disabled';
  }
  if (!empty($element['#autocomplete_path']) && drupal_valid_path($element['#autocomplete_path'])) {
    $attributes['class'][] = 'form-autocomplete';
  }
  $attributes['class'][] = 'form-item';
  if (isset($element['#type'])) {
    if ($element['#type'] == "radio") {
      $attributes['class'][] = 'radio';
      $is_radio = TRUE;
    }
    elseif ($element['#type'] == "checkbox") {
      $attributes['class'][] = 'checkbox';
      $is_checkbox = TRUE;
    }
    else {
      $attributes['class'][] = 'form-group';
    }
  }
  $output = '<div' . drupal_attributes($attributes) . '>' . "\n";
  if (!isset($element['#title'])) {
    $element['#title_display'] = 'none';
  }
  $prefix = '';
  $suffix = '';
  if (isset($element['#field_prefix']) || isset($element['#field_suffix'])) {
    if (!empty($element['#input_group'])) {
      $prefix .= '<div class="input-group">';
      $prefix .= isset($element['#field_prefix']) ? '<span class="input-group-addon">' . $element['#field_prefix'] . '</span>' : '';
      $suffix .= isset($element['#field_suffix']) ? '<span class="input-group-addon">' . $element['#field_suffix'] . '</span>' : '';
      $suffix .= '</div>';
    }
    else {
      $prefix .= isset($element['#field_prefix']) ? $element['#field_prefix'] : '';
      $suffix .= isset($element['#field_suffix']) ? $element['#field_suffix'] : '';
    }
  }
  switch ($element['#title_display']) {
    case 'before':
    case 'invisible':
      $output .= ' ' . theme('form_element_label', $variables) . ' ' . $prefix . $element['#children'] . $suffix . "\n";
      break;

    case 'after':
      if ($is_radio || $is_checkbox) {
        $output .= ' ' . $prefix . $element['#children'] . $suffix;
      }
      else {
        $variables['#children'] = ' ' . $prefix . $element['#children'] . $suffix;
      }
      $output .= ' ' . theme('form_element_label', $variables) . "\n";
      break;
    case 'none':
    case 'attribute':
      $output .= ' ' . $prefix . $element['#children'] . $suffix . "\n";
      break;
  }
  if (isset($element['#description'])) {
    $output .= '<p class="help-block">' . $element['#description'] . "</p>\n";
  }
  $output .= "</div>\n";
  return $output;
}


/**
 *  Implements theme_textfield().
 */
function progressive_textfield($variables) {
  $element = $variables['element'];
  $element['#attributes']['type'] = 'text';
  element_set_attributes($element, array(
    'id',
    'name',
    'value',
    'size',
    'maxlength',
  ));
  _form_set_class($element, array('form-text', 'form-control'));
  $output = '<input' . drupal_attributes($element['#attributes']) . ' />';
  $extra = '';
  if ($element['#autocomplete_path'] && drupal_valid_path($element['#autocomplete_path'])) {
    drupal_add_library('system', 'drupal.autocomplete');
    $element['#attributes']['class'][] = 'form-autocomplete';
    $attributes = array();
    $attributes['type'] = 'hidden';
    $attributes['id'] = $element['#attributes']['id'] . '-autocomplete';
    $attributes['value'] = url($element['#autocomplete_path'], array('absolute' => TRUE));
    $attributes['disabled'] = 'disabled';
    $attributes['class'][] = 'autocomplete';
    $output = '<div class="input-group">' . $output . '<span class="input-group-addon"><i class = "fa fa-refresh"></i></span></div>';
    $extra = '<input' . drupal_attributes($attributes) . ' />';
  }
  return $output . $extra;
}

/**
 *  Implements theme_textfield().
 */
function progressive_textarea($variables) {
  _form_set_class($variables['element'], array('form-control'));
  return theme_textarea($variables);
}

/**
 * Theme function to render an email component.
 */
function progressive_webform_email($variables) {
  _form_set_class($variables['element'], array('form-control'));
  return theme_webform_email($variables);
}

/**
 *  Implements theme_select().
 */
function progressive_select($variables) {
  _form_set_class($variables['element'], array('form-control'));
  return theme_select($variables);  
}

/**
 * Implements hook_preprocess_button().
 */
function progressive_preprocess_button(&$vars) {
  $vars['element']['#attributes']['class'][] = 'btn';
}

/**
 * Implements hook_element_info_alter().
 */
function progressive_element_info_alter(&$elements) {
  foreach ($elements as &$element) {
    $element['#process'][] = '_progressive_process_element';
    if (!empty($element['#input'])) {
      $element['#process'][] = '_progressive_process_input';
    }
  }
}


function _progressive_process_element(&$element, &$form_state) {
  if (!empty($element['#attributes']['class']) && is_array($element['#attributes']['class'])) {
    if (in_array('container-inline', $element['#attributes']['class'])) {
      $element['#attributes']['class'][] = 'form-inline';
    }
    if (in_array('form-wrapper', $element['#attributes']['class'])) {
      $element['#attributes']['class'][] = 'form-group';
    }
  }
  return $element;
}


function _progressive_process_input(&$element, &$form_state) {
  $types = array(
    'textarea',
    'textfield',
    'webform_email',
    'webform_number',
    'select',
    'password',
    'password_confirm',
  );
  if (!empty($element['#type']) && (in_array($element['#type'], $types) || ($element['#type'] === 'file' && empty($element['#managed_file'])))) {
    $element['#attributes']['class'][] = 'form-control';
  }
  return $element;
}

function progressive_username($variables) {
  if (isset($variables['link_path'])) {
    // We have a link path, so we should generate a link using l().
    // Additional classes may be added as array elements like
    $variables['link_options']['attributes']['class'][] = 'author-name';
    $output = l($variables['name'] . $variables['extra'], $variables['link_path'], $variables['link_options']);
  }
  else {
    $variables['attributes_array']['class'][] = 'author-name';
    $output = '<span' . drupal_attributes($variables['attributes_array']) . '>' . $variables['name'] . $variables['extra'] . '</span>';
  }
  return $output;
}

/**
 * Implements theme_field()
 *
 * Make field items a comma separated unordered list
 */
function progressive_field($variables) {
  $output = '';
  $output .= $variables['label_hidden'] ? '' : ('<b>' . $variables['label'] . '<span class = "colon">:</span> </b>');
  // Render the items as a comma separated inline list
  for ($i = 0; $i < count($variables['items']); $i++) {
    if(!isset($variables['items'][$i]['#printed']) || (isset($variables['items'][$i]['#printed']) && !$variables['items'][$i]['#printed'])) {
      $output .= drupal_render($variables['items'][$i]) . (($i == count($variables['items']) - 1) ? '' : ', ');
    }
  }
  // Render the top-level DIV.
  $output = '<div class="' . $variables ['classes'] . '"' . $variables ['attributes'] . '>' . $output . '</div>';
  return $output;
}

/**
 * Implements theme_field()
 */
function progressive_field__field_specifications($variables) {
  $output = '';
  if(count($variables['items'])) {
    $output .= '<ul>';
    for ($i = 0; $i < count($variables['items']); $i++) {
      $output .= '<li>' . drupal_render($variables['items'][$i]) . '</li>';
    }
    $output .= '</ul>';
  }
  return $output;
}

/**
 * Implements theme_field()
 */
function progressive_field__field_social_icons($variables) {
  $output = '';
  if(count($variables['items'])) {
    $output .= '<div class = "social">';
    for ($i = 0; $i < count($variables['items']); $i++) {
      //dpm($variables);
      $output .= '<div class = "item"><a class="sbtnf sbtnf-rounded color color-hover ' . $variables['items'][$i]['#element']['title'] . '" href="' . $variables['items'][$i]['#element']['url'] . '" target = "_blank"></a></div>';
    }
    $output .= '</div>';
  }
  return $output;
}

/**
 * Implements theme_field()
 */
function progressive_field__field_old_price($variables) {
  $output = '';
  $sign_after = variable_get('uc_sign_after_amount', FALSE);
  $currency = variable_get('uc_currency_sign', '$');
  if(count($variables['items'])) {
    for ($i = 0; $i < count($variables['items']); $i++) {
      $prefix = $sign_after ? '' : $currency; 
      $suffix = $sign_after ? $currency : '';
      $output .= '<span class="price-old">' . $prefix . $variables['items'][$i]['#markup'] . $suffix . '</span>';
    }
  }
  return $output;
}

/**
 * Implements theme_field()
 */
function progressive_field__sell_price($variables) {
  $output = '';
  $sign_after = variable_get('uc_sign_after_amount', FALSE);
  $currency = variable_get('uc_currency_sign', '$');
  if(count($variables['items'])) {
    for ($i = 0; $i < count($variables['items']); $i++) {
      $prefix = $sign_after ? '' : $currency; 
      $suffix = $sign_after ? $currency : '';
      $output .= '<span class="price-old">' . $prefix . $variables['items'][$i]['#markup'] . $suffix . '</span>';
    }
  }
  return $output;
}

/**
 * Implements theme_field()
 */
function progressive_field__fivestar($variables) {
  $output = '';
  if(count($variables['items'])) {
    for ($i = 0; $i < count($variables['items']); $i++) {
      $variables['items'][$i]['#theme_wrappers'] = array();
      $output .= render($variables['items'][$i]);
    }
  }
  return $output;
}


function progressive_fivestar_static($variables) {
  $rating  = $variables['rating'];
  $output = '<div class="rating-box">
    <div style="width: ' . $rating . '%" class="rating">
      <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" width="73px" height="12px" viewBox="0 0 73 12" enable-background="new 0 0 73 12" xml:space="preserve">
        <polygon fill-rule="evenodd" clip-rule="evenodd" fill="#1e1e1e" points="6.5,0 8,5 13,5 9,7.7 10,12 6.5,9.2 3,12 4,7.7 0,5 5,5"></polygon>
        <polygon fill-rule="evenodd" clip-rule="evenodd" fill="#1e1e1e" points="66.5,0 68,5 73,5 69,7.7 70,12 66.5,9.2 63,12 64,7.7 60,5 65,5 "></polygon>
        <polygon fill-rule="evenodd" clip-rule="evenodd" fill="#1e1e1e" points="21.5,0 23,5 28,5 24,7.7 25,12 21.5,9.2 18,12 19,7.7 15,5 20,5 "></polygon>
        <polygon fill-rule="evenodd" clip-rule="evenodd" fill="#1e1e1e" points="51.5,0 53,5 58,5 54,7.7 55,12 51.5,9.2 48,12 49,7.7 45,5 50,5 "></polygon>
        <polygon fill-rule="evenodd" clip-rule="evenodd" fill="#1e1e1e" points="36.5,0 38,5 43,5 39,7.7 40,12 36.5,9.2 33,12 34,7.7 30,5 35,5 "></polygon>
      </svg>
    </div>
  </div>';
  return $output;
}

function progressive_preprocess_table(&$variables) {
  if (isset($variables['attributes']['class']) && is_string($variables['attributes']['class'])) {
   // Convert classes to an array.
   $variables['attributes']['class'] = explode(' ', $variables['attributes']['class']);
  }
  $variables['attributes']['class'][] = 'table';
  $variables['attributes']['class'][] = 'table-striped';
}