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
?>
<?php if(!$teaser): ?>
  <div class="row">
    <div class="content portfolio col-sm-12 col-md-12">
      <?php if(isset($content['field_images']) && count(element_children($content['field_images']))): ?>
        <div class="slider progressive-slider page-slider load bottom-padding">
          <div class="container">
            <div class="row">
              <div class="sliders-box">

                <?php foreach(element_children($content['field_images']) as $i): ; ?>
                  <div>
                    <div class="col-sm-12 col-md-12">
                      <div class="slid row">
                        <div class="col-sm-12 col-md-12">
                          <?php print render($content['field_images'][$i]); ?>
                        </div>
                        <div class="slid-content col-sm-4 col-md-4">
                          <h1 class="title"><?php print render($content['field_slider_title']); ?></h1>
                          <p class="descriptions"><?php print render($content['field_slider_body']); ?></p>
                          <?php print render($content['field_slider_link']); ?>
                        </div>
                        </div>
                    </div>
                    <div class="clearfix"></div>
                  </div>
                <?php endforeach; ?>

              </div><!-- .sliders-box -->
          
              <div class="slider-nav col-sm-4 col-md-4">
                <div class="nav-box">
                  <a class="next" href="#">
                  <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" width="9px" height="16px" viewBox="0 0 9 16" enable-background="new 0 0 9 16" xml:space="preserve">
                    <polygon fill-rule="evenodd" clip-rule="evenodd" fill="#838383" points="1,0.001 0,1.001 7,8 0,14.999 1,15.999 9,8 "></polygon>
                  </svg>
                  </a>
                  <a class="prev" href="#">
                  <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" width="9px" height="16px" viewBox="0 0 9 16" enable-background="new 0 0 9 16" xml:space="preserve">
                    <polygon fill-rule="evenodd" clip-rule="evenodd" fill="#838383" points="8,15.999 9,14.999 2,8 9,1.001 8,0.001 0,8 "></polygon>
                  </svg>
                  </a>
                  <div class="pagination switches"></div> 
                </div>
              </div>
            </div>
          </div>
        </div><!-- .progressive-slider -->
      <?php endif; ?>

      <div class="row">
        <div class="portfolio-tags bottom-padding col-sm-4 col-md-4">
          <?php hide($content['field_images']); hide($content['body']); hide($content['comments']); hide($content['links']); ?>
          <?php foreach(element_children($content) as $i) {
            if(!isset($content[$i]['#printed']) || !$content[$i]['#printed']) {
              $content[$i]['#prefix'] = '<p>';
              $content[$i]['#suffix'] = '</p>';
            }
          };?>
          <?php print render($content); ?>
        </div>
        
        <div class="bottom-padding col-sm-8 col-md-8">
          <?php print render($content['body']) . render($content['links']); ?>
        </div>
      </div>
      <?php print render($content['comments']); ?>
          
      <div class="clearfix"></div>
    </div>
  </div>
<?php else: ?>
  <article class="<?php print $classes; ?> post" <?php print $attributes; ?>>
    <?php print render($title_prefix); ?>
    <h2 class="entry-title"><a href="<?php print url('node/' . $node->nid); ?>"><?php print $title; ?></a></h2>
    <?php print render($title_suffix); ?>
    <div class="entry-content">
      <?php hide($content['field_category']); hide($content['links']); hide($content['comments']); ?>  
      <?php print render($content); ?>
    </div>
    
    <div class="entry-meta">
      <?php if($display_submitted): ?>
        <?php print $name; ?>,
        <span class="time"><?php print date('d.m.Y', $node->created); ?></span>
        <span class="separator">|</span>
      <?php endif; ?>
      <?php if(isset($content['field_category'])): ?>
        <span class="meta"><?php print t('Posted in'); ?> <?php print render($content['field_category']); ?></span>
      <?php endif; ?>
      <?php if($display_submitted): ?>
        <span class="comments-link pull-right">
          <a href="<?php print url('node/' . $node->nid); ?>"><?php print $node->comment_count . ' ' . t('comment') . ($node->comment_count  ? 's' : '');?></a>
        </span>
      <?php endif; ?>
    </div>
  </article>
<?php endif; ?>