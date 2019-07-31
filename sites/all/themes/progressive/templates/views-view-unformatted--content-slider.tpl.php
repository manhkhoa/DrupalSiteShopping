<?php

/**
 * @file
 * Default simple view template to display a list of rows.
 *
 * @ingroup views_templates
 */
?>
<div class="carousel-box load overflow" data-carousel-pagination="true" data-carousel-nav="false" data-carousel-one="true">
  <div class="carousel no-responsive">
    <?php foreach ($rows as $id => $row): ?>
      <div class="row">
        <?php print $row; ?>
      </div>
    <?php endforeach; ?>    
  </div>  
  <div class="clearfix pagination switches"></div>
</div>