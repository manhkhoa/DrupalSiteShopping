<!DOCTYPE html>
<!--[if IE 7]>                  <html class="ie7 no-js" lang="<?php print $language->language; ?>" dir="<?php print $language->dir; ?>">     <![endif]-->
<!--[if lte IE 8]>              <html class="ie8 no-js" lang="<?php print $language->language; ?>" dir="<?php print $language->dir; ?>">     <![endif]-->
<!--[if (gte IE 9)|!(IE)]><!--> <html class="not-ie no-js" lang="<?php print $language->language; ?>" dir="<?php print $language->dir; ?>">  <!--<![endif]-->
<?php 
  // In case then we show maintenance page in demo view
  if(!isset($site_name)) {
    template_preprocess_page($variables);
    extract($variables);
  }
  $css = nikadevs_cms_preprocess_html($variables);
?>
<head>

  <?php print $head; ?>

  <title><?php print $head_title; ?></title>
  <meta name="author" content="http://themeforest.net/user/NikaDevs">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">

  <!-- Mobile Specific Metas
  ================================================== -->
  <meta name="viewport" content="width=device-width,initial-scale=1.0,maximum-scale=1.0,user-scalable=0">

  <?php print $styles; ?>

</head>
<?php if((theme_get_setting('maintenance_type') == t('Under Construction') || drupal_get_path_alias($_GET['q']) == 'content/under-construction') &&  drupal_get_path_alias($_GET['q']) != 'content/coming-soon') {
  include_once('maintenance-page-under-contruction.tpl.php');
  exit();
}?>
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
          <div class="count-down-box col-sm-8 col-md-8">
            <div id="count-down" data-time = "<?php print date('Y/m/d H:i:s', strtotime(theme_get_setting('coming_soon_timer')));?>"></div>
          </div>
        
          <div class="coming-text col-sm-4 col-md-4">
            <?php
              $coming_soon_content = theme_get_setting('coming_soon_content');
              print check_markup($coming_soon_content['value'], $coming_soon_content['format']);
            ?>
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
    Drupal.settings.theme_path = "<?php print drupal_get_path('theme', 'progressive'); ?>";
  </script>
<!-- Javascript Files
  ================================================== -->
  <script src="<?php print base_path() . drupal_get_path('theme', 'progressive'); ?>/js/jquery-1.11.0.min.js"></script>
  <script src="<?php print base_path() . drupal_get_path('theme', 'progressive'); ?>/js/bootstrap.min.js"></script>
  <script src="<?php print base_path() . drupal_get_path('theme', 'progressive'); ?>/js/country.js"></script>
  <script src="<?php print base_path() . drupal_get_path('theme', 'progressive'); ?>/js/main.js"></script>

</body>
</html>
