<?php $layout = _nikadevs_cms_get_active_layout();
$one_page = isset($layout['settings']['one_page']) && $layout['settings']['one_page'] ? 1 : 0; ?>
<?php if(theme_get_setting('header_top_menu') && !$one_page): global $user; ?>
  <div id="top-box">
    <div class="container">
    <div class="row">
      <div class="col-xs-9 col-sm-5">

        <?php if(theme_get_setting('language') && module_exists('locale') && drupal_multilingual()):
          global $language;
        ?>
          <div class="btn-group language btn-select">
            <a class="btn dropdown-toggle btn-default" role="button" data-toggle="dropdown" href="#">
              <span class="hidden-xs"><?php print t('Language'); ?></span><span class="visible-xs"><?php print t('Lang');?></span><!-- 
              -->: <?php print $language->name; ?>
              <span class="caret"></span>
            </a>
            <?php
              $path = drupal_is_front_page() ? '<front>' : $_GET['q'];
              $links = language_negotiation_get_switch_links('language', $path);
              if(isset($links->links)) {
                foreach($links->links as $i => $link) {
                  $links->links[$i]['attributes']['lang'] = $links->links[$i]['attributes']['xml:lang'];
                }
                $variables = array('links' => $links->links, 'attributes' => array('class' => array('dropdown-menu')));
                print theme('links__locale_block', $variables);
              }
            ?>
          </div>
        <?php endif; ?>
      </div>
      
      <div class="col-xs-3 col-sm-7">
      <div class="navbar navbar-inverse top-navbar top-navbar-right" role="navigation">
        <button type="button" class="navbar-toggle btn-navbar collapsed" data-toggle="collapse" data-target=".top-navbar .navbar-collapse">
          <span class="icon-bar"></span>
          <span class="icon-bar"></span>
          <span class="icon-bar"></span>
        </button>

        <nav class="collapse collapsing navbar-collapse" style="width: auto;">
          <ul class="nav navbar-nav navbar-right">
            <?php if(theme_get_setting('account_login') && $user->uid): ?>
              <li><?php print l(t('My Account'), 'user'); ?></li>
            <?php endif; ?>
            <?php if(module_exists('flag')):
              $flags = flag_get_user_flags('node');
              if(theme_get_setting('comparelist')): ?>
                <li>
                  <a href="<?php print url('product-compare'); ?>">
                    <i class="fa fa-exchange"></i> <?php print t('Compare List'); ?><span class = "flag-counter flag-count-compare count"><?php print !isset($flags['compare']) ? 0 : count($flags['compare']); ?></span>
                  </a>
                </li>
              <?php endif;
              if(theme_get_setting('wishlist')): ?>
                <li>
                  <a href="<?php print url('shop/wishlist'); ?>">
                    <i class="fa fa-heart"></i> <?php print t('My Wishlist'); ?><span class = "flag-counter flag-count-wishlist count"><?php print !isset($flags['wishlist']) ? 0 : count($flags['wishlist']); ?></span>
                  </a>
                </li>
              <?php endif; ?>
            <?php endif; ?>            
            <?php if(theme_get_setting('cart_checkout') && module_exists('uc_cart')): ?>
              <li><?php print l(t('My Cart <span class = "count cart-count">%number</span>', array('%number' => count(uc_cart_get_contents()))), 'cart', array('html' => TRUE)); ?></li>
              <li><?php print l(t('Checkout'), 'cart/checkout'); ?></li>
            <?php endif; ?>
            <?php if(theme_get_setting('account_login') && !$user->uid): ?>
              <li><?php print l(t('Log In  <i class="fa fa-lock after"></i>'), 'user/login', array('html' => TRUE)); ?></li>
            <?php endif; ?>
            <?php if(theme_get_setting('account_login') && $user->uid): ?>
              <li><?php print l(t('Log Out  <i class="fa fa-unlock after"></i>'), 'user/logout', array('html' => TRUE)); ?></li>
            <?php endif; ?>
          </ul>
        </nav>
      </div>
      </div>
    </div>
    </div>
  </div>
<?php endif; ?>

<header class="header<?php print theme_get_setting('header_top_menu') && !$one_page ? '' : ' header-two'; ?>">
  <div class = "header-wrapper">
    <div class="container">
      <div class="row">
        <div class="col-xs-6 col-md-2 col-lg-2 logo-box">
        <div class="logo">
          <a href="<?php print url('<front>'); ?>">
           <img src="<?php print theme_get_setting('logo'); ?>" class="logo-img" alt="">
          </a>
        </div>
        </div><!-- .logo-box -->
        
        <div class="col-xs-6 col-md-10 col-lg-10 right-box">
        <div class="right-box-wrapper">
          <div class="header-icons">
            <div class="search-header hidden-600">
              <a href="#">
              <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" width="16px" height="16px" viewBox="0 0 16 16" enable-background="new 0 0 16 16" xml:space="preserve">
                <path d="M12.001,10l-0.5,0.5l-0.79-0.79c0.806-1.021,1.29-2.308,1.29-3.71c0-3.313-2.687-6-6-6C2.687,0,0,2.687,0,6
                s2.687,6,6,6c1.402,0,2.688-0.484,3.71-1.29l0.79,0.79l-0.5,0.5l4,4l2-2L12.001,10z M6,10c-2.206,0-4-1.794-4-4s1.794-4,4-4
                s4,1.794,4,4S8.206,10,6,10z"></path>
                <!--<img src="<?php print base_path() . path_to_theme(); ?>/img/png-icons/search-icon.png" alt="" width="16" height="16" style="vertical-align: top;">-->
              </svg>
              </a>
            </div>
            <div class="phone-header hidden-600">
              <a href="#">
              <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" width="16px" height="16px" viewBox="0 0 16 16" enable-background="new 0 0 16 16" xml:space="preserve">
                <path d="M11.001,0H5C3.896,0,3,0.896,3,2c0,0.273,0,11.727,0,12c0,1.104,0.896,2,2,2h6c1.104,0,2-0.896,2-2
                c0-0.273,0-11.727,0-12C13.001,0.896,12.105,0,11.001,0z M8,15c-0.552,0-1-0.447-1-1s0.448-1,1-1s1,0.447,1,1S8.553,15,8,15z
                M11.001,12H5V2h6V12z"></path>
                <!--<img src="<?php print base_path() . path_to_theme(); ?>/img/png-icons/phone-icon.png" alt="" width="16" height="16" style="vertical-align: top;">-->
              </svg>
              </a>
            </div>
            <?php
              if(module_exists('flag')) {
                $flags = flag_get_user_flags('node');?>
                <?php if(theme_get_setting('comparelist')): ?>
                  <div class="compare-header flag-status-compare" <?php print !isset($flags['compare']) ? 'style="display:none"' : ''; ?>>
                    <a href="<?php print url('product-compare'); ?>">
                      <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" width="16px" height="16px" viewBox="0 0 16 16" enable-background="new 0 0 16 16" xml:space="preserve">
                        <path fill="#1e1e1e" d="M16,3.063L13,0v2H1C0.447,2,0,2.447,0,3s0.447,1,1,1h12v2L16,3.063z"></path>
                        <path fill="#1e1e1e" d="M16,13.063L13,10v2H1c-0.553,0-1,0.447-1,1s0.447,1,1,1h12v2L16,13.063z"></path>
                        <path fill="#1e1e1e" d="M15,7H3V5L0,7.938L3,11V9h12c0.553,0,1-0.447,1-1S15.553,7,15,7z"></path>
                      </svg>
                      <span class = "flag-counter flag-count-compare"><?php print !isset($flags['compare']) ? 0 : count($flags['compare']); ?></span>
                    </a>
                  </div>
                <?php endif; ?>
                <?php if(theme_get_setting('wishlist')): ?>
                <div class="wishlist-header flag-status-wishlist" <?php print !isset($flags['wishlist']) ? 'style="display:none"' : ''; ?>>
                  <a href="<?php print url('shop/wishlist'); ?>">
                    <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" width="16px" height="16px" viewBox="0 0 16 16" enable-background="new 0 0 16 16" xml:space="preserve">
                      <path fill="#1e1e1e" d="M11.335,0C10.026,0,8.848,0.541,8,1.407C7.153,0.541,5.975,0,4.667,0C2.088,0,0,2.09,0,4.667C0,12,8,16,8,16
                      s8-4,8-11.333C16.001,2.09,13.913,0,11.335,0z M8,13.684C6.134,12.49,2,9.321,2,4.667C2,3.196,3.197,2,4.667,2C6,2,8,4,8,4
                      s2-2,3.334-2c1.47,0,2.666,1.196,2.666,2.667C14.001,9.321,9.867,12.49,8,13.684z"></path>
                    </svg>
                    <span class = "flag-counter flag-count-wishlist"><?php print !isset($flags['wishlist']) ? 0 :count($flags['wishlist']); ?></span>
                  </a>
                </div>
                <?php endif; ?>
            <?php } ?>
            <?php if(module_exists('uc_cart')): ?>
            <div class="btn-group cart-header">
              <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                <div class="icon">
                  <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" width="16px" height="16px" viewBox="0 0 16 16" enable-background="new 0 0 16 16" xml:space="preserve">
                  <g>
                    <path d="M15.001,4h-0.57l-3.707-3.707c-0.391-0.391-1.023-0.391-1.414,0c-0.391,0.391-0.391,1.023,0,1.414L11.603,4
                    H4.43l2.293-2.293c0.391-0.391,0.391-1.023,0-1.414s-1.023-0.391-1.414,0L1.602,4H1C0.448,4,0,4.448,0,5s0.448,1,1,1
                    c0,2.69,0,7.23,0,8c0,1.104,0.896,2,2,2h10c1.104,0,2-0.896,2-2c0-0.77,0-5.31,0-8c0.553,0,1-0.448,1-1S15.554,4,15.001,4z
                    M13.001,14H3V6h10V14z"></path>
                    <path d="M11.001,13c0.553,0,1-0.447,1-1V8c0-0.553-0.447-1-1-1s-1,0.447-1,1v4C10.001,12.553,10.448,13,11.001,13z"></path>
                    <path d="M8,13c0.553,0,1-0.447,1-1V8c0-0.553-0.448-1-1-1S7,7.447,7,8v4C7,12.553,7.448,13,8,13z"></path>
                    <path d="M5,13c0.553,0,1-0.447,1-1V8c0-0.553-0.447-1-1-1S4,7.447,4,8v4C4,12.553,4.448,13,5,13z"></path>
                   </g>
                  </svg>
                </div>
                <?php print t('Cart'); ?> <span class = "cart-count"><?php print count(uc_cart_get_contents()); ?></span>
              </a>
              <?php print theme('progressive_cms_cart_block'); ?>
            </div><!-- .cart-header -->
            <?php endif; ?>
          </div><!-- .header-icons -->
          
          <div class="primary">
          <div class="navbar navbar-default" role="navigation">
            <button type="button" class="navbar-toggle btn-navbar collapsed" data-toggle="collapse" data-target=".primary .navbar-collapse">
              <span class="text"><?php print t('Menu'); ?></span>
              <span class="icon-bar"></span>
              <span class="icon-bar"></span>
              <span class="icon-bar"></span>
            </button>
      
            <nav class="collapse collapsing navbar-collapse">
              <ul class="nav navbar-nav navbar-center">
                <?php
                  if($one_page) {
                    foreach($layout['rows'] as $row):
                      $path = '#' . preg_replace('/[^\p{L}\p{N}]/u', '-', $row['name']);
                      if(isset($row['settings']['dropdown_links']) && $row['settings']['dropdown_links']) { ?>
                        <li class="parent">
                          <a class = "scroll" href = "<?php print $path; ?>"><?php print t($row['name']); ?></a>
                          <ul class="sub"> 
                          <?php
                            foreach ($row['settings'] as $key => $value):
                              if(strpos($key, 'menu_link_url') !== FALSE) {
                                $i = str_replace('menu_link_url_', '', $key);
                                $path = strpos($row['settings']['menu_link_url_' . $i], '#') === FALSE ? url($row['settings']['menu_link_url_' . $i]) : $row['settings']['menu_link_url_' . $i];
                                $class = strpos($row['settings']['menu_link_url_' . $i], '#') === 0 ? 'class = "scroll"' : '';
                                print '<li><a href="' . $path . '" ' . $class .'>' . t($row['settings']['menu_link_' . $i]) . '</a></li>';
                              }
                            endforeach;
                          ?>
                          </ul>
                        </li>
                      <?php }
                      elseif(!isset($row['settings']['hide_menu']) || !$row['settings']['hide_menu']) {
                        $path = '#' .  preg_replace('/[^\p{L}\p{N}]/u', '-', $row['name']);
                        print '<li><a href = "' . $path . '"  class = "scroll">' . t($row['name']) . '</a></li>';
                      }
                    endforeach;
                  }
                  elseif(module_exists('tb_megamenu')) {
                    print theme('tb_megamenu', array('menu_name' => variable_get('menu_main_links_source', 'main-menu')));
                  }
                  else {
                    $main_menu_tree = module_exists('i18n_menu') ? i18n_menu_translated_tree(variable_get('menu_main_links_source', 'main-menu')) : menu_tree(variable_get('menu_main_links_source', 'main-menu'));
                    print drupal_render($main_menu_tree);
                  }
                ?>
              </ul>
            </nav>
          </div>
          </div><!-- .primary -->
        </div>
        </div>
        
        <div class="phone-active col-sm-9 col-md-9">
          <a href="#" class="close"><span><?php print t('close'); ?></span>×</a>
          <?php $phone = explode("\n", theme_get_setting('phones')); ?>
          <span class="title"><?php print t('Call Us'); ?></span> <strong><?php print is_array($phone) ? array_shift($phone) : ''; ?></strong>
        </div>
        <div class="search-active col-sm-9 col-md-9">
          <a href="#" class="close"><span><?php print t('close'); ?></span>×</a>
          <?php
            $search_form_box = module_invoke('search', 'block_view');
            print render($search_form_box);
          ?>
        </div>
      </div><!--.row -->
    </div>
  </div>
</header><!-- .header -->