<?php $items = uc_cart_get_contents();
  $sign_after = variable_get('uc_sign_after_amount', FALSE);
  $currency = variable_get('uc_currency_sign', '$');
  $prefix = $sign_after ? '' : $currency; 
  $suffix = $sign_after ? $currency : '';
?>
<div class="dropdown-menu">
  <?php if(empty($items)) : ?>
    <strong><?php print t('Your shopping cart is empty.'); ?></strong>
  <?php else: ?>  
    <strong><?php print t('Recently added item(s)'); ?></strong>
    <ul class="list-unstyled">
      <?php foreach($items as $item): ?>
        <li>
          <?php $image = _get_node_field($item, 'uc_product_image'); ?>
          <?php if(isset($image[0])): ?>
            <?php print l(theme('image_style', array('style_name' => 'product_70x70', 'path' => $image[0]['uri'])), $item->nid, array('attributes' => array('class' => array('product-image')), 'html' => TRUE)); ?>
          <?php endif; ?>
          <a href="<?php print url('progressive/remove-from-cart/' . $item->nid . '/' . $item->cart_item_id); ?>" class="product-remove">
            <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" width="16px" height="16px" viewBox="0 0 16 16" enable-background="new 0 0 16 16" xml:space="preserve">
            <g>
              <path d="M6,13c0.553,0,1-0.447,1-1V7c0-0.553-0.447-1-1-1S5,6.447,5,7v5C5,12.553,5.447,13,6,13z"></path>
              <path d="M10,13c0.553,0,1-0.447,1-1V7c0-0.553-0.447-1-1-1S9,6.447,9,7v5C9,12.553,9.447,13,10,13z"></path>
              <path d="M14,3h-1V1c0-0.552-0.447-1-1-1H4C3.448,0,3,0.448,3,1v2H2C1.447,3,1,3.447,1,4s0.447,1,1,1
              c0,0.273,0,8.727,0,9c0,1.104,0.896,2,2,2h8c1.104,0,2-0.896,2-2c0-0.273,0-8.727,0-9c0.553,0,1-0.447,1-1S14.553,3,14,3z M5,2h6v1
              H5V2z M12,14H4V5h8V14z"></path>
            </g>
            </svg>
          </a><!-- .product-remove -->
          <h4 class="product-name"><?php print l($item->title, 'node/' . $item->nid); ?></h4>
          <div class="product-price"><span class = "qty-block"><?php print $item->qty; ?> x </span><span class="price"><?php print $prefix . number_format($item->sell_price, 2) . $suffix; ?></span></div>
          <div class="clearfix"></div>
        </li>
      <?php endforeach;?>
    </ul>
    <div class="cart-button">
      <?php print l(t('View Cart'), 'cart', array('attributes' => array('class' => array('btn', 'btn-default')))); ?>
      <?php print l(t('Checkout'), 'cart/checkout', array('attributes' => array('class' => array('btn', 'btn-default')))); ?>
    </div>
  <?php endif; ?>
</div>