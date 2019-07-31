<?php
  $classes .= $submenu ? ' parent' : '';
  $href = strpos($item['link']['href'], "_anchor_") !== false ? str_replace("http://_anchor_", '#', $item['link']['href']) : url($item['link']['href'], $item['link']['options']);
  $href = str_replace('/#', '#', $href);
?>
<li class="<?php print $classes;?>">
  <a href="<?php print in_array($item['link']['href'], array('<nolink>')) ? "#" : $href;?>" class="<?php print implode(" ", $a_classes);?>">
    <?php if(!empty($item_config['xicon'])) : ?>
      <i class="fa <?php print $item_config['xicon'];?>"></i>
    <?php endif;?>    
    <?php print t($item['link']['title']);?>
    <?php if(!empty($item_config['caption'])) : ?>
      <?php print t($item_config['caption']);?>
    <?php endif;?>
  </a>
  <?php print $submenu ? $submenu : "";?>
</li>
