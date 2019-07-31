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
global $counter;
$counter = isset($counter) ? $counter + 1 : 1; 
$class = '';
$links = '';
$id =  $view->vid . '-' . $fields['nid']->content;
$settings = variable_get('progressive_cms_blog_timeline', array());
$setting = isset($settings[$id]) ? $settings[$id] : array('id' => $id);
if(user_access('use nikadevs cms')) {
  $class = 'contextual-links-region ';
  $form = drupal_get_form('progressive_cms_blog_timeline_form', $setting);
  $links = array(render($form));
  $links = '<div class="contextual-links-wrapper">' . theme('item_list', array('items' => $links, 'attributes' => array('class' => array('contextual-links', 'contextual-form')))) . '</div>';
}
$bg = isset($setting['tranparent_bg']) && $setting['tranparent_bg'] ? 'border border-' : 'bg bg-';
?>
<article class = "post views-row<?php print isset($setting['no_padding']) && $setting['no_padding'] ? ' no-padding' : ''; ?>">
  <div class="timeline-time">
    <time datetime="<?php print date('Y-m-d', strtotime($fields['created']->content)); ?>"><?php print $fields['created']->content; ?></time>
  </div>

  <div class="timeline-icon <?php print isset($setting['color']) ? 'bg-' . $setting['color'] : ''; ?>">
    <div class="livicon" data-n="<?php print isset($setting['livicon']) ? $setting['livicon'] : ''; ?>" data-c="#fff" data-hc="0" data-s="22"></div>
  </div>

  <div class="<?php print $class; ?>timeline-content <?php print isset($setting['color']) ? $bg . $setting['color'] : ''; ?> appear-animation" data-appear-animation="<?php print $counter % 2 ? 'fadeInLeft' : 'fadeInRight'; ?>">
    <?php print $links; ?>
    
    <h2 class="entry-title" <?php print isset($setting['title']) && $setting['title'] ? '' : ' style = "display:none;"'; ?>>
      <?php print $fields['title']->content; ?>
    </h2>

    <div class="entry-content">
      <?php print $fields['body']->content; ?>
    </div>
  </div>
</article>