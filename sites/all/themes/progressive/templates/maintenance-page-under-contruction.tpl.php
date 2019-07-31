<body class="maintenance-page <?php print $classes; ?>" <?php print $attributes;?> style = "<?php print $css; ?>">

  <div class="page-box">

    <header class="header header-three">
      <div class="container">
        <div class="row">
          <div class="logo-box col-sm-12 col-md-12">
            <div class="logo">
              <a href="<?php print $front_page; ?>">
               <img src="<?php print $logo; ?>" class="logo-img" alt="">
              </a>
            </div>
          </div>
        </div><!--.row -->
      </div>
    </header><!-- .header -->

    <section id="main">
      <div class="container">
        <div class="row">
          <div class="text-center col-sm-12 col-md-12">
            <?php
              $under_construction_content = theme_get_setting('under_construction_content');
              print check_markup($under_construction_content['value'], $under_construction_content['format']);
            ?>
            <br><hr><br>
          </div>
        
          <div class="coming-text col-sm-12 col-md-4">
            <?php
              $under_construction_left = theme_get_setting('under_construction_left');
              print check_markup($under_construction_left['value'], $under_construction_left['format']);
            ?>
          </div>
        
          <div class="col-sm-12 col-md-8 under-contact">
            <div class="row">
              <div class="phone col-sm-6 col-md-6">
                <div class="footer-icon">
                  <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" width="16px" height="16px" viewBox="0 0 16 16" enable-background="new 0 0 16 16" xml:space="preserve">
                  <path fill="#1e1e1e" d="M11.001,0H5C3.896,0,3,0.896,3,2c0,0.273,0,11.727,0,12c0,1.104,0.896,2,2,2h6c1.104,0,2-0.896,2-2
                   c0-0.273,0-11.727,0-12C13.001,0.896,12.105,0,11.001,0z M8,15c-0.552,0-1-0.447-1-1s0.448-1,1-1s1,0.447,1,1S8.553,15,8,15z
                    M11.001,12H5V2h6V12z"></path>
                  </svg>
                </div>
                <?php print nl2br(theme_get_setting('under_construction_phones')); ?>
              </div>
              <div class="address col-sm-6 col-md-6">
                <div class="footer-icon">
                  <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" width="16px" height="16px" viewBox="0 0 16 16" enable-background="new 0 0 16 16" xml:space="preserve">
                  <g>
                    <g>
                    <path fill="#1e1e1e" d="M8,16c-0.256,0-0.512-0.098-0.707-0.293C7.077,15.491,2,10.364,2,6c0-3.309,2.691-6,6-6
                      c3.309,0,6,2.691,6,6c0,4.364-5.077,9.491-5.293,9.707C8.512,15.902,8.256,16,8,16z M8,2C5.795,2,4,3.794,4,6
                      c0,2.496,2.459,5.799,4,7.536c1.541-1.737,4-5.04,4-7.536C12.001,3.794,10.206,2,8,2z"></path>
                    </g>
                    <g>
                    <circle fill="#1e1e1e" cx="8.001" cy="6" r="2"></circle>
                    </g>
                  </g>
                  </svg>
                </div>
                <?php print nl2br(theme_get_setting('under_construction_address')); ?>
              </div>
            </div>
          </div>
        </div>
      </div><!-- .container -->
    </section><!-- #main -->

  </div><!-- .page-box -->

  <footer id="footer" class="footer-two">
    <div class="footer-top">
      <div class="container">
        <div class="row">
          <div class="social col-sm-12 col-md-12">
            <?php
              $coming_soon_bottom = theme_get_setting('coming_soon_bottom');
              print check_markup($coming_soon_bottom['value'], $coming_soon_bottom['format']);
            ?>
          </div>
        </div>
      </div>
    </div><!-- .footer-top -->
  </footer>
  <script type="text/javascript">
    Drupal = {}; Drupal.settings = {};
    Drupal.settings.basePath = "<?php print base_path();?>";
    Drupal.settings.theme_path = "<?php print drupal_get_path('theme', 'progressive');?>";
  </script>
<!-- Javascript Files
  ================================================== -->
  <script src="<?php print base_path() . drupal_get_path('theme', 'progressive'); ?>/js/jquery-1.11.0.min.js"></script>
  <script src="<?php print base_path() . drupal_get_path('theme', 'progressive'); ?>/js/bootstrap.min.js"></script>
  <script src="<?php print base_path() . drupal_get_path('theme', 'progressive'); ?>/js/country.js"></script>
  <script src="<?php print base_path() . drupal_get_path('theme', 'progressive'); ?>/js/main.js"></script>

</body>
</html>
