<?php
/**
 * @file
 * Default theme implementation to display a node.
 *
 * Available variables:
 * - $title: the (sanitized) title of the node.
 * - $content: An array of node items. Use render($content) to print them all, or
 *   print a subset such as render($content['field_example']). Use
 *   hide($content['field_example']) to temporarily suppress the printing of a
 *   given element.
 * - $user_picture: The node author's picture from user-picture.tpl.php.
 * - $date: Formatted creation date. Preprocess functions can reformat it by
 *   calling format_date() with the desired parameters on the $created variable.
 * - $name: Themed username of node author output from theme_username().
 * - $node_url: Direct url of the current node.
 * - $terms: the themed list of taxonomy term links output from theme_links().
 * - $display_submitted: whether submission information should be displayed.
 * - $classes: String of classes that can be used to style contextually through
 *   CSS. It can be manipulated through the variable $classes_array from
 *   preprocess functions. The default values can be one or more of the following:
 *   - node: The current template type, i.e., "theming hook".
 *   - node-[type]: The current node type. For example, if the node is a
 *     "Blog entry" it would result in "node-blog". Note that the machine
 *     name will often be in a short form of the human readable label.
 *   - node-teaser: Nodes in teaser form.
 *   - node-preview: Nodes in preview mode.
 *   The following are controlled through the node publishing options.
 *   - node-promoted: Nodes promoted to the front page.
 *   - node-sticky: Nodes ordered above other non-sticky nodes in teaser listings.
 *   - node-unpublished: Unpublished nodes visible only to administrators.
 * - $title_prefix (array): An array containing additional output populated by
 *   modules, intended to be displayed in front of the main title tag that
 *   appears in the template.
 * - $title_suffix (array): An array containing additional output populated by
 *   modules, intended to be displayed after the main title tag that appears in
 *   the template.
 *
 * Other variables:
 * - $node: Full node object. Contains data that may not be safe.
 * - $type: Node type, i.e. story, page, blog, etc.
 * - $comment_count: Number of comments attached to the node.
 * - $uid: User ID of the node author.
 * - $created: Time the node was published formatted in Unix timestamp.
 * - $classes_array: Array of html class attribute values. It is flattened
 *   into a string within the variable $classes.
 * - $zebra: Outputs either "even" or "odd". Useful for zebra striping in
 *   teaser listings.
 * - $id: Position of the node. Increments each time it's output.
 *
 * Node status variables:
 * - $view_mode: View mode, e.g. 'full', 'teaser'...
 * - $teaser: Flag for the teaser state (shortcut for $view_mode == 'teaser').
 * - $page: Flag for the full page state.
 * - $promote: Flag for front page promotion state.
 * - $sticky: Flags for sticky post setting.
 * - $status: Flag for published status.
 * - $comment: State of comment settings for the node.
 * - $readmore: Flags true if the teaser content of the node cannot hold the
 *   main body content.
 * - $is_front: Flags true when presented in the front page.
 * - $logged_in: Flags true when the current user is a logged-in member.
 * - $is_admin: Flags true when the current user is an administrator.
 *
 * Field variables: for each field instance attached to the node a corresponding
 * variable is defined, e.g. $node->body becomes $body. When needing to access
 * a field's raw values, developers/themers are strongly encouraged to use these
 * variables. Otherwise they will have to explicitly specify the desired field
 * language, e.g. $node->body['en'], thus overriding any language negotiation
 * rule that was previously applied.
 *
 * @see template_preprocess()
 * @see template_preprocess_node()
 * @see template_process()
 */
if($view_mode == 'full') :
  $fields = array('field_corner_text');
  foreach($fields as $field) {
    $$field = _get_node_field($node, $field);
  }
  $comments_array = isset($content['comments']['comments']) ? array_filter($content['comments']['comments'], '_count_comments') : array();
  hide($content['body']); hide($content['comments']); hide($content['links']['comment']); hide($content['field_corner_text']); hide($content['add_to_cart']);
?>
<article class="content product-page">
  <div class="row">
    <div class="col-sm-5 col-md-5">
    <div class="image-box">
      <?php if($field_corner_text[0]['safe_value']): ?>
        <span class="sale <?php print strtolower($field_corner_text[0]['safe_value']); ?>"><span><?php print $field_corner_text[0]['safe_value']; ?></span></span>
      <?php endif; ?>
      <?php if($content['uc_product_image'] && isset($content['uc_product_image'][0]['#item'])): ?>
        <div class="general-img">
          <?php $content['uc_product_image'][0]['attributes']['data-zoom-image'] = file_create_url($content['uc_product_image'][0]['#item']['uri']); ?>
          <?php print render($content['uc_product_image'][0]); ?>
        </div><!-- .general-img -->
      <?php endif; ?>
      <div class="thumblist-box load">
        <a href="#" class="prev">
          <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" width="9px" height="16px" viewBox="0 0 9 16" enable-background="new 0 0 9 16" xml:space="preserve">
          <polygon fill-rule="evenodd" clip-rule="evenodd" fill="#fcfcfc" points="8,15.999 9,14.999 2,8 9,1.001 8,0.001 0,8 "></polygon>
          </svg>
        </a>
        <a href="#" class="next">
          <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" width="9px" height="16px" viewBox="0 0 9 16" enable-background="new 0 0 9 16" xml:space="preserve">
          <polygon fill-rule="evenodd" clip-rule="evenodd" fill="#fcfcfc" points="1,0.001 0,1.001 7,8 0,14.999 1,15.999 9,8 "></polygon>
          </svg>
        </a>
        
        <div id="thumblist" class="thumblist">
          <?php foreach(element_children($content['uc_product_image']) as $key): if(!isset($content['uc_product_image'][$key]['#item'])) {continue;} $content['uc_product_image'][$key]['#image_style'] = 'product_100x100';?>
            <a href="#" data-image="<?php print image_style_url('product_470x470', $content['uc_product_image'][$key]['#item']['uri']); ?>" data-zoom-image="<?php print file_create_url($content['uc_product_image'][$key]['#item']['uri']); ?>">
              <?php print render($content['uc_product_image'][$key]); ?>
            </a>
          <?php endforeach; ?>
        </div><!-- #thumblist -->
      </div><!-- .thumblist -->
    </div>
    </div>
    
    <div class="col-sm-7 col-md-7">
      <div class="reviews-box">
        <?php print render($content['field_rating']); ?>
        <span class = "review-count"><?php print count($comments_array) . ' ' . t('review(s)');?></span>
        <span class="separator">|</span>
        <a href="#reviews" class="add-review"><?php print t('Add your review'); ?></a>
      </div>
      
      <div class="description">
        <?php print render($content['field_short_description']); ?>
      </div>
      
      <div class="price-box">
        <?php print render($content['field_old_price']); ?>
        <span class="price display-price uc-product-node id"><?php $content['sell_price']['#title'] = ''; print render($content['sell_price']); ?></span>
      </div>
      
      <?php print render($content); ?>
      <?php print render($content['add_to_cart']); ?>
      
      <div class="actions">
        <?php print flag_create_link('wishlist', $node->nid); ?>
        <?php print flag_create_link('compare', $node->nid); ?>
      </div><!-- .actions -->
    </div>
  </div>

    <div class="product-tab">
      <ul class="nav nav-tabs">
        <li class="active"><a href="#description"><?php print $content['body']['#title']; ?></a></li>
        <li><a href="#reviews"><?php print t('Reviews'); ?></a></li>
      </ul><!-- .nav-tabs --> 
      <div class="tab-content">
        <div class="tab-pane active" id="description">
          <?php print render($content['body']); ?>
        </div>
        <div class="tab-pane" id="reviews">
          <?php print render($content['comments']); ?>
        </div>
      </div>
    </div>
</article>
<?php else : ?>
  <?php if (!$page): ?>
    <article id="node-<?php print $node->nid; ?>" class="<?php print $classes; ?> clearfix"<?php print $attributes; ?>>
  <?php endif; ?>
    <h2 class = "hidden"><?php print $title; ?></h2>
    <?php print render($title_prefix) . render($title_suffix); ?>

    <?php if ($display_submitted): ?>
      <span class="submitted"><?php print $submitted; ?></span>
    <?php endif; ?>

    <div class="content clearfix <?php print $classes_array['1']; ?>"<?php print $content_attributes; ?>>
      <?php
        // Hide comments, tags, and links now so that we can render them later.
        hide($content['comments']);
        hide($content['links']['comment']);
        print render($content);
      ?>
    </div>

    <?php if (!empty($content['links'])): ?>
      <footer>
        <?php print render($content['links']); ?>
      </footer>
    <?php endif; ?>

    <?php print render($content['comments']); ?>
  <?php if (!$page): ?>
    </article> <!-- /.node -->
  <?php endif; ?>
<?php endif; ?>