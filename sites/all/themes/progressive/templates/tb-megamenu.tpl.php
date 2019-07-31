<?php if($menu_name == variable_get('menu_main_links_source', 'main-menu')): ?>
  <?php print $content;?>
<?php else: ?>
  <div class="header">
    <div class="secondary-megamenu primary <?php print $menu_name; ?>">
      <div class="navbar navbar-default" role="navigation">
        <button type="button" class="navbar-toggle btn-navbar collapsed" data-toggle="collapse" data-target=".<?php print $menu_name; ?> .navbar-collapse">
          <span class="text"><?php print t('Menu'); ?></span>
          <span class="icon-bar"></span>
          <span class="icon-bar"></span>
          <span class="icon-bar"></span>
        </button>

        <nav class="collapse collapsing navbar-collapse">
          <ul class="nav navbar-nav navbar-center">
            <?php print $content;?>
          </ul>
        </nav>
      </div>
    </div>
  </div>
<?php endif; ?>