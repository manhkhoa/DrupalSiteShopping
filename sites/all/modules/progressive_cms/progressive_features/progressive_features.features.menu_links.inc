<?php
/**
 * @file
 * progressive_features.features.menu_links.inc
 */

/**
 * Implements hook_menu_default_menu_links().
 */
function progressive_features_menu_default_menu_links() {
  $menu_links = array();

  // Exported menu link: main-menu_catalog-grid:shop.
  $menu_links['main-menu_catalog-grid:shop'] = array(
    'menu_name' => 'main-menu',
    'link_path' => 'shop',
    'router_path' => 'shop',
    'link_title' => 'Catalog (Grid)',
    'options' => array(
      'identifier' => 'main-menu_catalog-grid:shop',
    ),
    'module' => 'system',
    'hidden' => 0,
    'external' => 0,
    'has_children' => 0,
    'expanded' => 0,
    'weight' => -50,
    'customized' => 1,
    'parent_identifier' => 'main-menu_shop:shop',
  );
  // Exported menu link: main-menu_catalog-list:shop-list.
  $menu_links['main-menu_catalog-list:shop-list'] = array(
    'menu_name' => 'main-menu',
    'link_path' => 'shop-list',
    'router_path' => 'shop-list',
    'link_title' => 'Catalog (List)',
    'options' => array(
      'identifier' => 'main-menu_catalog-list:shop-list',
    ),
    'module' => 'system',
    'hidden' => 0,
    'external' => 0,
    'has_children' => 0,
    'expanded' => 0,
    'weight' => -49,
    'customized' => 1,
    'parent_identifier' => 'main-menu_shop:shop',
  );
  // Exported menu link: main-menu_compare-products:product-compare.
  $menu_links['main-menu_compare-products:product-compare'] = array(
    'menu_name' => 'main-menu',
    'link_path' => 'product-compare',
    'router_path' => 'product-compare',
    'link_title' => 'Compare Products',
    'options' => array(
      'identifier' => 'main-menu_compare-products:product-compare',
    ),
    'module' => 'system',
    'hidden' => 0,
    'external' => 0,
    'has_children' => 0,
    'expanded' => 0,
    'weight' => -42,
    'customized' => 1,
    'parent_identifier' => 'main-menu_shop:shop',
  );
  // Exported menu link: main-menu_shop:shop.
  $menu_links['main-menu_shop:shop'] = array(
    'menu_name' => 'main-menu',
    'link_path' => 'shop',
    'router_path' => 'shop',
    'link_title' => 'Shop',
    'options' => array(
      'attributes' => array(
        'title' => '',
      ),
      'identifier' => 'main-menu_shop:shop',
    ),
    'module' => 'menu',
    'hidden' => 0,
    'external' => 0,
    'has_children' => 1,
    'expanded' => 1,
    'weight' => -48,
    'customized' => 1,
  );
  // Exported menu link: main-menu_wishlist:shop/wishlist.
  $menu_links['main-menu_wishlist:shop/wishlist'] = array(
    'menu_name' => 'main-menu',
    'link_path' => 'shop/wishlist',
    'router_path' => 'shop/wishlist',
    'link_title' => 'Wishlist',
    'options' => array(
      'attributes' => array(
        'title' => '',
      ),
      'identifier' => 'main-menu_wishlist:shop/wishlist',
    ),
    'module' => 'system',
    'hidden' => 0,
    'external' => 0,
    'has_children' => 0,
    'expanded' => 0,
    'weight' => -43,
    'customized' => 1,
    'parent_identifier' => 'main-menu_shop:shop',
  );

  // Translatables
  // Included for use with string extractors like potx.
  t('Catalog (Grid)');
  t('Catalog (List)');
  t('Compare Products');
  t('Shop');
  t('Wishlist');

  return $menu_links;
}
