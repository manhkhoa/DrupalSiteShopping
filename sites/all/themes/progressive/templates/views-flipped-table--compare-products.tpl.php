<?php
/**
 * @file views-flipped-table.tpl.php
 * Template to display a view as a table with rows and columns flipped.
 *
 * - $title : The title of this group of rows.  May be empty.
 * - $header: An array of header labels keyed by field id.
 * - $fields: An array of CSS IDs to use for each field id.
 * - $classes: A class or classes to apply to the table, based on settings.
 * - $row_classes: An array of classes to apply to each row, indexed by row
 *   number. This matches the index in $rows.
 * - $rows: The original array of row items. Each row is an array of content.
 *   $rows are keyed by row number, fields within rows are keyed by field ID.
 * - $rows_flipped: An array of row items, with the original data flipped.
 *   $rows_flipped are keyed by field name, each item within a row is keyed
 *   by the original row number.
 * - $row_classes_flipped: An array of classes to apply to each flipped row,
 *   indexed by the field name.
 * - $first_row_header: boolean indicating the first row is a table header.
 *
 * @ingroup views_templates
 */
?>
<table id = "compare-table" class="<?php print $classes; ?> table table-bordered">
  <?php if (!empty($title)) : ?>
    <caption><?php print $title; ?></caption>
  <?php endif; ?>

  <?php if ($first_row_header) : ?>
    <?php $field_names = array_keys($rows_flipped);
          $field_name = reset($field_names); ?>
    <thead>
      <tr class = "remove">
        <td></td>
        <?php foreach ($rows_flipped[$field_name] as $index => $item) : ?>
          <td class = "data-index-<?php print $index; ?>">
            <a href="<?php print url('progressive/remove-unflag/compare/' . $rows_flipped['nid'][$index]); ?>" data-index = "<?php print $index; ?>" class="product-remove">
              <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" width="16px" height="16px" viewBox="0 0 16 16" enable-background="new 0 0 16 16" xml:space="preserve">
                <g>
                <path fill="#7f7f7f" d="M6,13c0.553,0,1-0.447,1-1V7c0-0.553-0.447-1-1-1S5,6.447,5,7v5C5,12.553,5.447,13,6,13z"></path>
                <path fill="#7f7f7f" d="M10,13c0.553,0,1-0.447,1-1V7c0-0.553-0.447-1-1-1S9,6.447,9,7v5C9,12.553,9.447,13,10,13z"></path>
                <path fill="#7f7f7f" d="M14,3h-1V1c0-0.552-0.447-1-1-1H4C3.448,0,3,0.448,3,1v2H2C1.447,3,1,3.447,1,4s0.447,1,1,1
                c0,0.273,0,8.727,0,9c0,1.104,0.896,2,2,2h8c1.104,0,2-0.896,2-2c0-0.273,0-8.727,0-9c0.553,0,1-0.447,1-1S14.553,3,14,3z M5,2h6v1
                H5V2z M12,14H4V5h8V14z"></path>
                </g>
              </svg>
            </a>
          </td>
        <?php endforeach; ?>
      </tr>
      <tr>
        <th class="first <?php print($header_classes[$field_name]); ?>">
          <?php print $header[$field_name] ?>
        </th>
        <?php foreach ($rows_flipped[$field_name] as $index => $item) : ?>
          <th class="data-index-<?php print $index; ?> <?php print($field_classes[$field_name][$index]); ?>">
            <?php print $item; ?>
          </th>
        <?php endforeach; ?>
      </tr>
    </thead>
    <?php array_shift($rows_flipped); ?>
  <?php endif;?>
  <tbody>
    <?php foreach ($rows_flipped as $field_name => $row) : if(in_array($field_name, array('field_old_price', 'nid'))) continue; ?>
      <tr class="<?php print $row_classes_flipped[$field_name]; ?>">
        <td class="first <?php print($header_classes[$field_name]); ?>">
          <strong><?php echo $header[$field_name]; ?></strong>
        </td>
        <?php foreach ($row as $index => $item): ?>
          <td class="data-index-<?php print $index; ?> <?php print($field_classes[$field_name][$index]) . ($field_name == 'sell_price' ? ' cell-align-center' : ''); ?>">
            <?php print $field_name == 'sell_price' ? $rows_flipped['field_old_price'][$index] : ''; echo $item; ?>
          </td>
        <?php endforeach; ?>
      </tr>
    <?php endforeach; ?>
    <tr class = "remove remove-bottom">
      <td></td>
      <?php foreach ($rows_flipped[$field_name] as $index => $item) : ?>
        <td class = "data-index-<?php print $index; ?>">
          <a href="<?php print url('progressive/remove-unflag/compare/' . $rows_flipped['nid'][$index]); ?>" data-index = "<?php print $index; ?>" class="product-remove">
            <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" width="16px" height="16px" viewBox="0 0 16 16" enable-background="new 0 0 16 16" xml:space="preserve">
              <g>
              <path fill="#7f7f7f" d="M6,13c0.553,0,1-0.447,1-1V7c0-0.553-0.447-1-1-1S5,6.447,5,7v5C5,12.553,5.447,13,6,13z"></path>
              <path fill="#7f7f7f" d="M10,13c0.553,0,1-0.447,1-1V7c0-0.553-0.447-1-1-1S9,6.447,9,7v5C9,12.553,9.447,13,10,13z"></path>
              <path fill="#7f7f7f" d="M14,3h-1V1c0-0.552-0.447-1-1-1H4C3.448,0,3,0.448,3,1v2H2C1.447,3,1,3.447,1,4s0.447,1,1,1
              c0,0.273,0,8.727,0,9c0,1.104,0.896,2,2,2h8c1.104,0,2-0.896,2-2c0-0.273,0-8.727,0-9c0.553,0,1-0.447,1-1S14.553,3,14,3z M5,2h6v1
              H5V2z M12,14H4V5h8V14z"></path>
              </g>
            </svg>
          </a>
        </td>
      <?php endforeach; ?>
    </tr>
  </tbody>
</table>

