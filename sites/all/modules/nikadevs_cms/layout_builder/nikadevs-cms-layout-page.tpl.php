<?php foreach($layout['rows'] as $id => $row):
  $tag = isset($row['settings']['tag']) && $row['settings']['tag'] != 'none' ? $row['settings']['tag'] : ''; ?>

  <?php if($tag): ?>
    <<?php print $tag;?> <?php print drupal_attributes($row['wrap']['attributes']); ?>>
  <?php endif; ?>

    <?php print isset($row['settings']['prefix']) && $row['settings']['prefix'] ? $row['settings']['prefix'] : ''; ?>   

      <div class = "container<?php print (isset($row['settings']['full_width']) && $row['settings']['full_width']) ? '-fluid' : ''; ?>">

        <div <?php print drupal_attributes($row['attributes']); ?>>     

          <?php foreach($layout['regions'] as $region_key => $region):?>

            <?php if($id == $region['row_id'] && !empty($region['content'])):?>
              <?php if($region['settings']['tag']): ?>
                <<?php print $region['settings']['tag']; ?> <?php print drupal_attributes($region['attributes']); ?>>
              <?php endif; ?>
                
                <?php print isset($region['settings']['prefix']) ? $region['settings']['prefix'] : ''; ?>
                <?php print $region['content']; ?>
                <?php print isset($region['settings']['suffix']) ? $region['settings']['suffix'] : ''; ?>

              <?php if($region['settings']['tag']): ?>
                </<?php print $region['settings']['tag']; ?>>
              <?php endif; ?>
            <?php endif; ?>
          
          <?php endforeach; ?>

        </div>

      </div>

    <?php print isset($row['settings']['suffix']) && $row['settings']['suffix'] ? $row['settings']['suffix'] : ''; ?>

  <?php if($tag): ?>
    </<?php print $tag;?>>
  <?php endif; ?>  

<?php endforeach; ?>