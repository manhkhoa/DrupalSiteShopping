<?php

/**
 * @file
 * Default simple view template to display a list of rows.
 *
 * @ingroup views_templates
 */
?>
<div class="slider progressive-slider load">
  <div class="container">
    <div class="row">
      <div class="sliders-box">
        <?php if (!empty($title)): ?>
          <h3><?php print $title; ?></h3>
        <?php endif; ?>
        <?php foreach ($rows as $id => $row): ?>
          <div>
            <?php print $row; ?>
          </div>
        <?php endforeach; ?>
      </div>
      <div class="slider-nav col-sm-4 col-md-4">
        <div class="nav-box">
          <a class="next" href="#">
          <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" width="9px" height="16px" viewBox="0 0 9 16" enable-background="new 0 0 9 16" xml:space="preserve">
            <polygon fill-rule="evenodd" clip-rule="evenodd" fill="#838383" points="1,0.001 0,1.001 7,8 0,14.999 1,15.999 9,8 "></polygon>
          </svg>
          </a>
          <a class="prev" href="#">
          <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" width="9px" height="16px" viewBox="0 0 9 16" enable-background="new 0 0 9 16" xml:space="preserve">
            <polygon fill-rule="evenodd" clip-rule="evenodd" fill="#838383" points="8,15.999 9,14.999 2,8 9,1.001 8,0.001 0,8 "></polygon>
          </svg>
          </a>
          <div class="pagination switches"></div> 
        </div>
      </div>
    </div>
  </div>
</div><!-- .progressive-slider -->