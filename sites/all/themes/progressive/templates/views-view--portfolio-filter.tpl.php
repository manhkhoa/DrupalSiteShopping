<?php

/**
 * @file
 * Main view template.
 *
 * Variables available:
 * - $classes_array: An array of classes determined in
 *   template_preprocess_views_view(). Default classes are:
 *     .view
 *     .view-[css_name]
 *     .view-id-[view_name]
 *     .view-display-id-[display_name]
 *     .view-dom-id-[dom_id]
 * - $classes: A string version of $classes_array for use in the class attribute
 * - $css_name: A css-safe version of the view name.
 * - $css_class: The user-specified classes names, if any
 * - $header: The view header
 * - $footer: The view footer
 * - $rows: The results of the view query, if any
 * - $empty: The empty text to display if the view is empty
 * - $pager: The pager next/prev links to display, if any
 * - $exposed: Exposed widget form/info to display
 * - $feed_icon: Feed icon to display, if any
 * - $more: A link to view more, if any
 *
 * @ingroup views_templates
 */
global $projects_categories;
?>

<div class="<?php print $classes; ?> view-portfolio-filter">
  <?php print render($title_prefix); ?>
  <?php if ($title): ?>
    <?php print $title; ?>
  <?php endif; ?>
  <?php print render($title_suffix); ?>
  <?php if ($header): ?>
    <div class="view-header">
      <?php print $header; ?>
    </div>
  <?php endif; ?>

  <?php if ($exposed): ?>
    <div class="view-filters">
      <?php print $exposed; ?>
    </div>
  <?php endif; ?>

  <?php if ($attachment_before): ?>
    <div class="attachment attachment-before">
      <?php print $attachment_before; ?>
    </div>
  <?php endif; ?>

  <div class="content portfolio">
    <div class="row">
      <div class="col-sm-12 col-md-8">
        <?php if(!empty($projects_categories)): ?>
          <div class="btn-group filter-buttons filter-list">
            <button type="button" class="dropdown-toggle" data-toggle="dropdown">
              <?php print t('All items'); ?><span class="caret"></span>
            </button>
            <ul class="dropdown-menu" role="menu">
              <li><a href="#" data-filter="*" class="active"><?php print t('All items'); ?></a></li>
              <?php  foreach($projects_categories as $id => $category): ?>
                <li><a href="#" data-filter=".<?php print $id; ?>"><?php print $category; ?></a></li>
              <?php endforeach; ?>
            </ul>
            <div class="clearfix"></div>
          </div><!-- .filter-buttons -->
        <?php endif; ?>
      </div>

      <div class="col-sm-6 col-md-4 year-regulator">
        <div class="label"><?php print t('Year:'); ?></div>
        <div class="layout-slider">
          <input id="filter" type="slider" name="year" value="2000;2013" class="form-control">
        </div>
      </div><!-- .price-regulator -->
    </div>

    <div class="row filter-elements">
      <?php print $rows; ?>
    </div>
  </div>
  <?php if (isset($empty)): ?>
    <div class="view-empty">
      <?php print $empty; ?>
    </div>
  <?php endif; ?>

  <?php if ($footer): ?>
    <div class="view-footer-pager hidden">
      <?php print $footer; ?>
    </div>
  <?php endif; ?>

  <?php if ($pager): ?>
    <?php print $pager; ?>
  <?php endif; ?>

  <?php if ($attachment_after): ?>
    <div class="attachment attachment-after">
      <?php print $attachment_after; ?>
    </div>
  <?php endif; ?>

  <?php if ($more): ?>
    <?php print $more; ?>
  <?php endif; ?>

  <?php if ($footer): ?>
    <div class="view-footer">
      <?php print $footer; ?>
    </div>
  <?php endif; ?>

  <?php if ($feed_icon): ?>
    <div class="feed-icon">
      <?php print $feed_icon; ?>
    </div>
  <?php endif; ?>

</div><?php /* class view */ ?>
