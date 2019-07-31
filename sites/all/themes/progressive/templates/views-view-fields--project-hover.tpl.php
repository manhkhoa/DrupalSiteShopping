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
global $projects_categories;
$categories = array();
if($fields['field_category']->content) {
  foreach(explode('/', $fields['field_category']->content) as $category) {
  	$category_id = preg_replace('/[^a-zA-Z0-9\']/', '-', $category);
  	$projects_categories[$category_id] = $category;
  	$categories[] = $category_id;
  }
}
// Match Column numbers to Bootsrap class
$columns_classes = array(1 => 12, 2 => 6, 3 => 4, 4 => 3, 6 => 2, 12 => 1);
$bootsrap_class = isset($columns_classes[$view->style_plugin->options['columns']]) ? $columns_classes[$view->style_plugin->options['columns']] : 3;
?>
<div class="work-element <?php print implode(' ', $categories); ?> col-sm-3 col-xs-12 col-md-<?php print $bootsrap_class; ?>">
  <a href="<?php print $fields['path']->content; ?>" class="work">
    <?php print $fields['field_images']->content; ?>
    <span class="shadow"></span>
    <div class="bg-hover"></div>
    <div class="work-title">
      <?php print $fields['title']->content; ?>
      <div class="description"><?php print truncate_utf8(str_replace('/', ' / ', $fields['field_category']->content), 30, FALSE, TRUE); ?></div>
    </div>
  </a>
</div><!-- .work-element -->