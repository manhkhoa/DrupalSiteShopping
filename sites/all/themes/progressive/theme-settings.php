<?php
/**
 * Implements hook_form_FORM_ID_alter().
 *
 * @param $form
 *   The form.
 * @param $form_state
 *   The form state.
 */
function progressive_form_system_theme_settings_alter(&$form, &$form_state) {
  drupal_add_css(drupal_get_path('theme', 'progressive') . '/css/theme-settings.css');
  $form['options'] = array(
    '#type' => 'vertical_tabs',
    '#default_tab' => 'main',
    '#weight' => '-10',
    '#title' => t('Progressive Theme settings'),
  );

  if(module_exists('nikadevs_cms')) {
    $form['options']['nd_layout_builder'] = nikadevs_cms_layout_builder();
  }
  else {
    drupal_set_message('Enable NikaDevs CMS module to use layout builder.');
  }

  $form['options']['main'] = array(
    '#type' => 'fieldset',
    '#title' => t('Main settings'),
  );
  $skins = array('elements', 'home', 'pages', 'shop-5', 'shop-6', 'shop-8', 'shop');
  $form['options']['main']['skin'] = array(
    '#type' => 'radios',
    '#title' => t('Skin'),
    '#options' => array_combine($skins, $skins),
    '#default_value' => theme_get_setting('skin'),
    '#attributes' => array('class' => array('color-radios')),
  );
  $form['options']['main']['retina'] = array(
    '#type' => 'checkbox',
    '#title' => t('Enable Retina Script'),
    '#default_value' => theme_get_setting('retina'),
    '#description'   => t("Only for retina displays and for manually added images. The script will check if the same image with suffix @2x exists and will show it."),
  );
  $form['options']['main']['boxed'] = array(
    '#type' => 'checkbox',
    '#title' => t('Boxed view'),
    '#default_value' => theme_get_setting('boxed'),
  );
  $form['options']['main']['mobile_menu_toggle'] = array(
    '#type' => 'checkbox',
    '#title' => t('Easy mobile main menu dropdown toggle'),
    '#description' => t('If not checked then dropdown menu will be showed only if the user clicked on the + sign.'),
    '#default_value' => theme_get_setting('mobile_menu_toggle'),
  );

  $form['options']['main']['header_top_menu'] = array(
    '#type' => 'checkbox',
    '#title' => t('Header Top Menu'),
    '#default_value' => theme_get_setting('header_top_menu'),
  );
  $form['options']['main']['header_top_menu_wrap'] = array(
    '#type' => 'container',
    '#states' => array(
      'visible' => array(
        ':input[name="header_top_menu"]' => array('checked' => TRUE),
      )
    )
  );
  $form['options']['main']['header_top_menu_wrap']['header_top_fixed'] = array(
    '#type' => 'checkbox',
    '#title' => t('Header Top Fixed Position'),
    '#default_value' => theme_get_setting('header_top_fixed'),
  );
  $form['options']['main']['header_top_menu_wrap']['language'] = array(
    '#type' => 'checkbox',
    '#title' => t('Language Block'),
    '#default_value' => theme_get_setting('language'),
    '#prefix' => '<div class = "row"><div class = "col-sm-2">'
  );
  $form['options']['main']['header_top_menu_wrap']['account_login'] = array(
    '#type' => 'checkbox',
    '#title' => t('My Account & Login'),
    '#default_value' => theme_get_setting('account_login'),
    '#prefix' => '</div><div class = "col-sm-2">'
  );
  $form['options']['main']['header_top_menu_wrap']['wishlist'] = array(
    '#type' => 'checkbox',
    '#title' => t('Wishlist'),
    '#default_value' => theme_get_setting('wishlist'),
    '#prefix' => '</div><div class = "col-sm-2">'
  );
  $form['options']['main']['header_top_menu_wrap']['comparelist'] = array(
    '#type' => 'checkbox',
    '#title' => t('Compare list'),
    '#default_value' => theme_get_setting('comparelist'),
    '#prefix' => '</div><div class = "col-sm-2">'
  );
  $form['options']['main']['header_top_menu_wrap']['cart_checkout'] = array(
    '#type' => 'checkbox',
    '#title' => t('Cart & Checkout'),
    '#default_value' => theme_get_setting('cart_checkout'),
    '#prefix' => '</div><div class = "col-sm-2">',
    '#suffix' => '</div></div>'
  );
  $form['options']['main']['shop_link'] = array(
    '#type' => 'textfield',
    '#title' => t('Shop Link'),
    '#default_value' => theme_get_setting('shop_link'),
  );
  $form['options']['main']['shop_link_list'] = array(
    '#type' => 'textfield',
    '#title' => t('Shop Link, style List'),
    '#default_value' => theme_get_setting('shop_link_list'),
  );
  $form['options']['main']['phones'] = array(
    '#type' => 'textfield',
    '#title' => t('Main phone'),
    '#default_value' => theme_get_setting('phones'),
  );


  $form['options']['settings_404'] = array(
    '#type' => 'fieldset',
    '#title' => t('Page not Found'),
  );
  $form['options']['settings_404']['page_404'] = array(
    '#type' => 'select',
    '#title' => t('Page 404'),
    '#default_value' => theme_get_setting('page_404'),
    '#options' => array(
      1 => t('404 in Circle'),
      2 => t('404 in Circle with text'),
      3 => t('Background page')
    ),
    '#description'   => t("Type of the 'Page not Found'"),
  );
  $page_404_content = theme_get_setting('page_404_content');
  $form['options']['settings_404']['container'] = array(
    '#type' => 'container',
    '#states' => array(
      'visible' => array(
        ':input[name="page_404"]' => array('value' => 2),
      )
    )
  );
  $form['options']['settings_404']['container']['page_404_content'] = array(
    '#type' => 'text_format',
    '#title' => t('Page 404 Content'),
    '#format' => isset($page_404_content['format']) ? $page_404_content['format'] : NULL,
    '#default_value' => isset($page_404_content['value']) ? $page_404_content['value'] : '',
  );

  $form['options']['maintenance'] = array(
    '#type' => 'fieldset',
    '#title' => t('Maintenance Page'),
  );
  $form['options']['maintenance']['maintenance_type'] = array(
    '#type' => 'select',
    '#title' => t('Maintenance page type'),
    '#default_value' => theme_get_setting('maintenance_type'),
    '#options' => array(
      t('Comming Soon') => t('Comming Soon'),
      t('Under Construction') => t('Under Construction'),
    )
  );
  $form['options']['maintenance']['container_construction'] = array(
    '#type' => 'container',
    '#states' => array(
      'visible' => array(
        ':input[name="maintenance_type"]' => array('value' => t('Under Construction')),
      )
    )
  );
  $under_construction_content = theme_get_setting('under_construction_content');
  $form['options']['maintenance']['container_construction']['under_construction_content'] = array(
    '#type' => 'text_format',
    '#title' => t('Under Construction Content'),
    '#format' => isset($under_construction_content['format']) ? $under_construction_content['format'] : $under_construction_content,
    '#default_value' => isset($under_construction_content['value']) ? $under_construction_content['value'] : 'html',
  );
  $under_construction_left = theme_get_setting('under_construction_left');
  $form['options']['maintenance']['container_construction']['under_construction_left'] = array(
    '#type' => 'text_format',
    '#title' => t('Under Construction Left Content'),
    '#format' => isset($under_construction_left['format']) ? $under_construction_left['format'] : NULL,
    '#default_value' => isset($under_construction_left['value']) ? $under_construction_left['value'] : '',
  );
  $form['options']['maintenance']['container_construction']['under_construction_phones'] = array(
    '#type' => 'textarea',
    '#rows' => 2,
    '#title' => t('Under Construction Phones'),
    '#default_value' => theme_get_setting('under_construction_phones'),
  );
  $form['options']['maintenance']['container_construction']['under_construction_address'] = array(
    '#type' => 'textarea',
    '#title' => t('Under Construction Address'),
    '#rows' => 2,
    '#default_value' => theme_get_setting('under_construction_address'),
  );
  $under_construction_bottom = theme_get_setting('under_construction_bottom');
  $form['options']['maintenance']['container_construction']['under_construction_bottom'] = array(
    '#type' => 'text_format',
    '#title' => t('Under Construction Bottom'),
    '#format' => isset($under_construction_bottom['format']) ? $under_construction_bottom['format'] : NULL,
    '#default_value' => isset($under_construction_bottom['value']) ? $under_construction_bottom['value'] : '',
  );
  // Coming Soon with Timer
  $form['options']['maintenance']['container_coming_soon'] = array(
    '#type' => 'container',
    '#states' => array(
      'visible' => array(
        ':input[name="maintenance_type"]' => array('value' => t('Comming Soon')),
      )
    )
  );
  $form['options']['maintenance']['container_coming_soon']['coming_soon_timer'] = array(
    '#type' => 'textfield',
    '#title' => t('Countdown time'),
    '#description' => t('Any time format, for example: 2014/12/29 10:00:00'),
    '#default_value' => theme_get_setting('coming_soon_timer'),
    '#states' => array(
      'visible' => array(
        ':input[name="maintenance_type"]' => array('value' => t('Comming Soon')),
      )
    )
  );
  $coming_soon_content = theme_get_setting('coming_soon_content');
  $form['options']['maintenance']['container_coming_soon']['coming_soon_content'] = array(
    '#type' => 'text_format',
    '#title' => t('Coming Soon Content'),
    '#format' => isset($coming_soon_content['format']) ? $coming_soon_content['format'] : NULL,
    '#default_value' => isset($coming_soon_content['value']) ? $coming_soon_content['value'] : '',
  );
  $coming_soon_bottom = theme_get_setting('coming_soon_bottom');
  $form['options']['maintenance']['container_coming_soon']['coming_soon_bottom'] = array(
    '#type' => 'text_format',
    '#title' => t('Coming Soon Bottom'),
    '#format' => isset($coming_soon_bottom['format']) ? $coming_soon_bottom['format'] : NULL,
    '#default_value' => isset($coming_soon_bottom['value']) ? $coming_soon_bottom['value'] : '',
  );

  $form['#submit'][] = 'progressive_settings_submit';
}

/**
 * Save settings data.
 */
function progressive_settings_submit($form, &$form_state) {
  $page_404 = $form_state['input']['page_404'] == 3 ? 'page-404-bg' : 'page-404';
  variable_set('site_404', $page_404);
}