<?php

/**
 * @file
 * Default simple view template to display a list of rows.
 *
 * @ingroup views_templates
 */
?>
<div class="banner-set banner-set-mini banner-set-no-pagination load">
  <div class="container">
    <div class="banners">
      <?php foreach ($rows as $id => $row): ?>
        <?php print $row; ?>
      <?php endforeach; ?>
    </div><!-- .banners -->
    <div class="clearfix"></div>
  </div>
  <div class="nav-box">
    <div class="container">
      <a class="prev" href="#"><span class="glyphicon glyphicon-arrow-left"></span></a>
      <div class="pagination switches"></div>
      <a class="next" href="#"><span class="glyphicon glyphicon-arrow-right"></span></a>  
    </div>
  </div>
</div><!-- .banner-set -->