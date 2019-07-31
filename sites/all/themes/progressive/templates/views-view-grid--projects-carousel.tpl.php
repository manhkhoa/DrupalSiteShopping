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
<div class="carousel-box load overflow" data-carousel-pagination="true" data-carousel-nav="false" data-carousel-autoplay="true" data-duration = "500">
  <div class="clearfix"></div>

  <div class="row">
    <div class="carousel no-responsive">
      <?php foreach ($rows as $row_number => $columns): ?>
        <?php foreach ($columns as $column_number => $item): ?>
          <?php print $item; ?>
        <?php endforeach; ?>
      <?php endforeach; ?>
    </div>
  </div>
  <div>
    <div class="pagination switches"></div>
  </div>
</div>