<?php

/**
 * @file
 * Default simple view template to display a rows in a grid.
 *
 * - $rows contains a nested array of rows. Each row contains an array of
 *   columns.
 *
 * @ingroup views_templates
 */
?>
<?php foreach ($rows as $row_number => $columns): ?>
  <?php foreach ($columns as $column_number => $item): ?>
    <?php print $item; ?>
  <?php endforeach; ?>
<?php endforeach; ?>