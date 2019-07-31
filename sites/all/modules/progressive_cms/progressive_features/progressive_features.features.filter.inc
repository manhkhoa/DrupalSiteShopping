<?php
/**
 * @file
 * progressive_features.features.filter.inc
 */

/**
 * Implements hook_filter_default_formats().
 */
function progressive_features_filter_default_formats() {
  $formats = array();

  // Exported format: CKEditor.
  $formats['ckeditor'] = array(
    'format' => 'ckeditor',
    'name' => 'CKEditor',
    'cache' => 1,
    'status' => 1,
    'weight' => -8,
    'filters' => array(
      'filter_autop' => array(
        'weight' => 0,
        'status' => 1,
        'settings' => array(),
      ),
      'filter_url' => array(
        'weight' => 0,
        'status' => 1,
        'settings' => array(
          'filter_url_length' => 72,
        ),
      ),
    ),
  );

  // Exported format: Dynamic Shortcodes.
  $formats['dynamic_shortcodes'] = array(
    'format' => 'dynamic_shortcodes',
    'name' => 'Dynamic Shortcodes',
    'cache' => 0,
    'status' => 1,
    'weight' => -7,
    'filters' => array(
      'shortcode_dynamic' => array(
        'weight' => 0,
        'status' => 1,
        'settings' => array(
          'quote' => 1,
          'testimonial' => 1,
          'progress' => 1,
          'spacer' => 1,
          'container' => 1,
          'row' => 1,
          'col' => 1,
          'message' => 1,
          'button' => 1,
          'service_box' => 1,
          'social_box' => 1,
          'pricing_table' => 1,
          'pricing_table_row' => 1,
          'view' => 1,
          'block' => 1,
          'node' => 1,
          'quicklinks' => 1,
          'video' => 1,
          'contact' => 1,
          'slider' => 1,
          'slider_item' => 1,
          'sequence' => 1,
          'sequence_item' => 1,
          'accordions' => 1,
          'accordion' => 1,
          'image' => 1,
          'gmap' => 1,
          'tabs' => 1,
          'tab' => 1,
          'hr' => 1,
          'title' => 1,
          'sitemap' => 1,
          'html' => 1,
          'chart' => 1,
          'styledcontainer' => 1,
          'icon' => 1,
          'textrotation' => 1,
        ),
      ),
    ),
  );

  // Exported format: Shortcodes.
  $formats['html'] = array(
    'format' => 'html',
    'name' => 'Shortcodes',
    'cache' => 1,
    'status' => 1,
    'weight' => -10,
    'filters' => array(
      'shortcode' => array(
        'weight' => 0,
        'status' => 1,
        'settings' => array(
          'quote' => 1,
          'testimonial' => 1,
          'progress' => 1,
          'spacer' => 1,
          'container' => 1,
          'row' => 1,
          'col' => 1,
          'message' => 1,
          'button' => 1,
          'service_box' => 1,
          'social_box' => 1,
          'pricing_table' => 1,
          'pricing_table_row' => 1,
          'view' => 0,
          'block' => 0,
          'node' => 0,
          'quicklinks' => 0,
          'video' => 1,
          'contact' => 0,
          'slider' => 1,
          'slider_item' => 1,
          'sequence' => 1,
          'sequence_item' => 1,
          'accordions' => 1,
          'accordion' => 1,
          'image' => 1,
          'gmap' => 1,
          'tabs' => 1,
          'tab' => 1,
          'hr' => 1,
          'title' => 1,
          'sitemap' => 1,
          'html' => 1,
          'chart' => 1,
          'styledcontainer' => 1,
          'icon' => 1,
          'textrotation' => 1,
        ),
      ),
    ),
  );

  return $formats;
}
