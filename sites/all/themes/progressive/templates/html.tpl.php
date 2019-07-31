<?php if(in_array($_GET['q'], array('node/64', 'node/65')) && strpos($_SERVER['HTTP_HOST'], 'nikadevs') !== FALSE) { include('maintenance-page.tpl.php'); exit(); } ?>
<!DOCTYPE html>
<html  lang="<?php print $language->language; ?>" dir="<?php print $language->dir; ?>"<?php print $rdf_namespaces; ?>>
<head>
  <?php print $head; ?>

  <title><?php print $head_title; ?></title>
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta class="viewport" name="viewport" content="width=device-width, initial-scale=1.0">

  <?php print $styles; ?>

  <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
    <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <link rel='stylesheet' href="<?php print base_path() . path_to_theme(); ?>/css/ie/ie8.css">
  <![endif]-->

</head>
<body class="fixed-header <?php print $classes; ?>"<?php print $attributes; ?>>

  <?php print $page_top; ?>
  <?php print $page; ?>
  <?php print $scripts; ?>
  <?php print $page_bottom; ?>

  <?php if(strpos($_SERVER['HTTP_HOST'], 'nikadevs') !== FALSE): ?>
    <link rel="stylesheet" href="<?php print base_path() . path_to_theme(); ?>/css/customizer/<?php print theme_get_setting('skin'); ?>-pages-customizer.css">
    <div class="style-switcher visible-md visible-lg" id="style-switcher">
      <h3 class="show">Style Switcher <a href="#"><i class="fa fa-cog"></i></a></h3>
      <div class="style-switcher-body">
      <h4>Colors</h4>
        <ul class="styles-switcher-colors">
          <li><a href="#" class="color-elements" data-color = "elements"></a></li>
          <li><a href="#" class="color-home" data-color = "home"></a></li>
          <li><a href="#" class="color-pages" data-color = "pages"></a></li>
          <li><a href="#" class="color-shop-5" data-color = "shop-5"></a></li>
          <li><a href="#" class="color-shop-6" data-color = "shop-6"></a></li>
          <li><a href="#" class="color-shop-8" data-color = "shop-8"></a></li>
          <li><a href="#" class="color-shop" data-color = "shop"></a></li>
        </ul>
        <h4>Layout</h4>
        <ul class="style-switcher-layout buttons-switcher">
          <li><a href="#" class="layout-boxed">Boxed</a></li>
          <li><a href="#" class="layout-wide active">Wide</a></li>
        </ul>
        <h4>Language Direction</h4>
        <ul class="style-switcher-rtl buttons-switcher">
          <li><a href="#" class="layout-ltr active">LTR</a></li>
          <li><a href="#" class="layout-rtl">RTL</a></li>
        </ul>
      </div>
    </div>
    <link rel="stylesheet" href="<?php print base_path() . path_to_theme(); ?>/css/style-switcher.css">
    <script src="<?php print base_path() . path_to_theme(); ?>/js/style-switcher.js"></script>
  <?php endif; ?>

</body>
</html>