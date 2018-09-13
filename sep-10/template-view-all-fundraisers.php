<?php
/* Template Name: Create All Fundraiser */

get_header();

$context = Timber::get_context();
$context['post'] = new Timber\Post();
$context['categories'] = Timber::get_terms('fund_cate');

//$context['all_fund_post'] = all_fundraiser();

$context['count_posts'] = new TimberFunctionWrapper('all_fundraiser');
$context['fund_post'] = Timber::get_posts($args = array( 'post_type' => 'fundraiser','post_status' =>'publish'));
$context['reat_post'] = Timber::get_posts($args = array( 'post_type' => 'retailer','post_status' =>'publish'));
/*$context['count_posts'] = all_fundraiser();*/

Timber::render('template-view-all-fundraisers.twig', $context);
?>
 <script type="text/javascript" src="<?php bloginfo('template_directory');?>/js/load-more.js"></script>
<?php 
get_footer();

?>