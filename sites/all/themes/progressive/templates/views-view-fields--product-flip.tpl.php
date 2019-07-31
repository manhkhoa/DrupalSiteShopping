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
$path = $fields['path']->content ? $fields['path']->content : url('node/' . $fields['nid']->content);
?>
<div class="default">
  <a href="<?php print $path ?>" class="product-image">
    <?php if($fields['field_corner_text']->content): ?>
      <span class="sale corner-<?php print strtolower($fields['field_corner_text']->content); ?>"><span><?php print $fields['field_corner_text']->content; ?></span></span>
    <?php endif; ?>
    <?php print $fields['uc_product_image']->content; ?>
  </a>
  <div class="product-description">
    <div class="vertical">
      <h3 class="product-name">
        <a href="<?php print $path ?>"><?php print $fields['title']->content; ?></a>
      </h3>
      <div class="price"><?php print $fields['sell_price']->content; ?></div> 
    </div>
  </div>
</div>
<div class="product-hover">
  <h3 class="product-name">
    <a href="<?php print $path ?>"><?php print $fields['title']->content; ?></a>
  </h3>
  <div class="price"><?php print $fields['sell_price']->content; ?></div>
  <a href="<?php print $path ?>" class="product-image">
    <?php print !empty($fields['uc_product_image_1']->content) ? $fields['uc_product_image_1']->content : $fields['uc_product_image']->content; ?>
  </a>
  <?php print $fields['field_specifications']->content; ?>
  <div class="actions">
    <div class = "hidden-form">
      <?php print isset($fields['buyitnowbutton']) ? $fields['buyitnowbutton']->content : ''; ?>
      <?php print isset($fields['addtocartlink']) ? $fields['addtocartlink']->content : ''; ?>
    </div>
    <span>
      <a href="#" class="add-cart js-active-link">
        <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" width="16px" height="16px" viewBox="0 0 16 16" enable-background="new 0 0 16 16" xml:space="preserve">
        <g>
          <path fill="#1e1e1e" d="M15.001,4h-0.57l-3.707-3.707c-0.391-0.391-1.023-0.391-1.414,0c-0.391,0.391-0.391,1.023,0,1.414L11.603,4
          H4.43l2.293-2.293c0.391-0.391,0.391-1.023,0-1.414s-1.023-0.391-1.414,0L1.602,4H1C0.448,4,0,4.448,0,5s0.448,1,1,1
          c0,2.69,0,7.23,0,8c0,1.104,0.896,2,2,2h10c1.104,0,2-0.896,2-2c0-0.77,0-5.31,0-8c0.553,0,1-0.448,1-1S15.554,4,15.001,4z
          M13.001,14H3V6h10V14z"></path>
          <path fill="#1e1e1e" d="M11.001,13c0.553,0,1-0.447,1-1V8c0-0.553-0.447-1-1-1s-1,0.447-1,1v4C10.001,12.553,10.448,13,11.001,13z"></path>
          <path fill="#1e1e1e" d="M8,13c0.553,0,1-0.447,1-1V8c0-0.553-0.448-1-1-1S7,7.447,7,8v4C7,12.553,7.448,13,8,13z"></path>
          <path fill="#1e1e1e" d="M5,13c0.553,0,1-0.447,1-1V8c0-0.553-0.447-1-1-1S4,7.447,4,8v4C4,12.553,4.448,13,5,13z"></path>
        </g>
        </svg>
      </a>
    </span>
    <?php print flag_create_link('wishlist', $fields['nid']->content); ?>
    <?php print flag_create_link('compare', $fields['nid']->content); ?>
  </div><!-- .actions -->
</div><!-- .product-hover -->