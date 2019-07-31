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
global $projects_categories;
?>
<div class="container">
  <div class="portfolio">

    <div class="btn-group filter-buttons filter-list white clearfix">
      <button type="button" class="dropdown-toggle" data-toggle="dropdown">
        <?php print t('All items'); ?><span class="caret"></span>
      </button>
      <ul class="dropdown-menu" role="menu">
        <li><a href="#" data-filter="*" class="active"><?php print t('All items'); ?></a></li>
        <?php  foreach($projects_categories as $id => $category): ?>
          <li><a href="#" data-filter=".<?php print $id; ?>"><?php print $category; ?></a></li>
        <?php endforeach; ?>
      </ul>
    </div><!-- .filter-buttons -->

    <div class="row filter-elements">
      <?php foreach ($rows as $row_number => $columns): ?>
        <?php foreach ($columns as $column_number => $item): ?>
          <?php print $item; ?>
        <?php endforeach; ?>
      <?php endforeach; ?>
    </div>

  </div>
</div>