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
// Image path
$image = _get_node_field($row, 'field_field_image');
$path = isset($image[0]) ? $image[0]['raw']['uri'] : '';
?>
<div class="default">
  <div class="image">
    <?php print theme('image_style', array('style_name' => 'product_270x270', 'path' => $path)); ?>
  </div>
  <div class="description">
  <div class="vertical">
    <?php print $fields['title']->content; ?>
    <?php print $fields['field_position']->content; ?>
  </div>
  </div>
</div>
<div class="employee-hover">
  <?php print $fields['title']->content; ?>
  <?php print $fields['field_position']->content; ?>
  <div class="image">
    <?php print theme('image_style', array('style_name' => 'team_60x60', 'path' => $path)); ?>
  </div>
  <div>
    <?php print $fields['body']->content; ?>
    <?php if(isset($fields['field_email'])): ?>
      <div class="contact"><b><?php print t('Email'); ?>: </b><?php print $fields['field_email']->content; ?></div>
    <?php endif; ?>
    <?php if(isset($fields['field_phone'])): ?>
      <div class="contact"><b><?php print t('Phone'); ?>: </b><?php print $fields['field_phone']->content; ?></div>
    <?php endif; ?>
  </div>
  <?php print $fields['field_social_icons']->content; ?>
</div><!-- .employee-hover -->