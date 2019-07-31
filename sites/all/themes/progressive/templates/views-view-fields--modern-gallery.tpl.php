<?php

/**
 * @file
 * Default simple view template to all the fields as a row.
 *
 * - $view: The view in use.
 * - $fields: an array of $field objects. Each one contains:
 *   - $field->content: The output of the field.
 *   - $field->raw: The raw data for the field, if it exists. This is NOT output safe.
 *   - $field->class: The safe class id to use.
 *   - $field->handler: The Views field handler object controlling this field. Do not use
 *     var_export to dump this object, as it can't handle the recursion.
 *   - $field->inline: Whether or not the field should be inline.
 *   - $field->inline_html: either div or span based on the above flag.
 *   - $field->wrapper_prefix: A complete wrapper containing the inline_html to use.
 *   - $field->wrapper_suffix: The closing tag for the wrapper.
 *   - $field->separator: an optional separator that may appear before a field.
 *   - $field->label: The wrap label text to use.
 *   - $field->label_html: The full HTML of the label to use including
 *     configured element type.
 * - $row: The raw result object from the query, with all data it fetched.
 *
 * @ingroup views_templates
 */
$links = '';
$class = '';
$id =  $view->vid . '-' . $fields['nid']->content . '-' . $fields['fid']->content;
$settings = variable_get('progressive_modern_gallery', array());
$columns = isset($settings[$id]) ? $settings[$id] : 3;
if(user_access('use nikadevs cms')) {
  $class = 'contextual-links-region ';
  $links = array('<a href = "#1">1 column</a>', '<a href = "#2">2 columns</a>', '<a href = "#3">3 columns</a>');
  $links = '<div class="contextual-links-wrapper">' . theme('item_list', array('items' => $links, 'attributes' => array('data-id' => $id,'class' => array('contextual-links', 'modern-gallery-action')))) . '</div>';
}
?>
<div class="<?php print $class; ?>images-box col-sm-<?php print $columns; ?> col-md-<?php print $columns; ?>">
  <?php print $links;?>
  <a class="gallery-images" rel="fancybox" href="<?php print file_create_url($fields['uri']->content); ?>">
    <?php print theme('image_style', array('style_name' => 'gallery_item_870x624', 'path' => $fields['uri']->content)); ?>
    <span class="bg-images"><i class="fa fa-search"></i></span>
  </a>
</div>