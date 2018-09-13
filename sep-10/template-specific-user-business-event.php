<?php
/* Template Name: All Business */
get_header('author'); 

$user = wp_get_current_user();
$user_id =  $user->ID;
?>

<!-- Specific user business event page start here -->

<div class="container new_class">
  <div class="row">
    <div class="div_box">
      <div class="second_divbox">

            <?php if(is_user_logged_in()) { ?>
<?php //include('author-sidebar.php'); ?>
<div class="col-md-12 col-sm-12 col-xs-12 four_btn">
  <div class="info_about">
    <h2>Your Businesses</h2>
  </div>

<div class="tab-pane" id="tab_default_7">


<?php 
$post_type = 'retailer';
$user_post_count = count_user_posts( $user_id , $post_type );
if($user_post_count > 6)
{
?>
<div class="search_ret loader_serach1">
<div id="search12"> 
 <input id="search_ret_names" name="search_ret_names" class="form-control input-lg" placeholder="Search for a Business Partner">
 <!-- <input type="button" id="serach_retas" class="btn btn-default" value="Go"> -->
</div>
<div class="loader12">
 <div id="dvLoading1" style="display:none;"></div>
</div>
</div>
<?php 
}
?>

<div class="post-listing">
<?php
global $paged; global $args;
$paged = ( get_query_var( 'paged' ) ) ? get_query_var( 'paged' ) : 1;
$args = null;
$args = array( 'post_type' => 'retailer', 'posts_per_page' => 9,'post_status' =>'publish','paged' => $paged,'author' =>   $user->ID);

$query_args = array( 'post_type' => 'retailer', 'posts_per_page' => -1,'post_status' =>'publish','paged' => $paged,'author' =>   $user->ID);
$post_loop = new WP_Query($query_args);
$count_allbusiness = $post_loop->post_count;
?>
<input type="hidden" id="scrol_event" value="all_business">
<input type="hidden" id="count_allbusiness" value="<?php echo $count_allbusiness ;?>">
<?php
$loop = new WP_Query( $args );
if( $loop->have_posts()){
while ( $loop->have_posts() ) : $loop->the_post();
  ?>
  <div class="col-md-4 col-sm-6 post_list nnew_post">
    <figure>
      <div class="post_border">
        <div class="thumb_image">
          <div class="blanks">
            <?php

            //$feature_image_1 = get_field('feature_image_1',$post->ID);
            $feature_image1 =  get_the_post_thumbnail_url($post->ID);
            ?>


            <?php if($feature_image1){
              echo'<img class="img-responsive innerimages" src="'.$feature_image1.'">';
            }
            else{
              echo'<img class="img-responsive innerimages" src="'.site_url().'/wp-content/uploads/2017/09/dummy_img.jpg">'; } ?>
            </div>
          </div>
          <div class="com_div">
            <div class="col-sm-12 col-md-12 post_titl1">

              <?php $trimtitle = get_the_title(); $shorttitle = wp_trim_words( $trimtitle, $num_words = 3, $more = '… ' );
              echo '<h4 class="title_event">' . '<a class="post_titles" href="' . get_permalink() . '" >' . ucfirst($shorttitle) . '</a></h4>';?>
            </div>
            <div class="col-sm-12 col-md-12 post_titl">
              <?php echo '<p>'; echo wp_trim_words( get_the_content(), '4', '...' );  echo'</p>';?>
              <?php $retailer_id1 = $post->ID; 
              ?>
            </div>
          </div>
        </div>
        <?php 
        if(is_user_logged_in())
        { 
          if($current_user->ID == $user->ID || (in_array("administrator", $user_roles)) || (in_array("editor", $user_roles)))
          {
            ?>
            <figcaption>
              <ul class="list-inline list-unstyled hvrbtn">
                <li><a href="<?php echo get_permalink(); ?>"  data-toggle="tooltip" title="View!"><i class="fa fa-eye" aria-hidden="true"></i></a></li>
                <li><a href="<?php echo home_url();?>/edit-business-event?ids=<?php the_ID(); ?>" data-toggle="tooltip2" title="Edit!"  ><i class="fas fa-pencil-alt"></i></a></li>
                <!-- <li><a type="button" data-toggle="modal" title="Delete!" data-target="#myModal33_bus<?php //echo the_ID();?>" ><i class="fas fa-trash-alt"></i></a></li> -->
              </ul>

            </figcaption>

            <?php } } ?>
            <!-- popup for delete -->
            <div class="modal fade" id="myModal33_bus<?php echo the_ID();?>" role="dialog">
              <div class="modal-dialog delete_modal">

                <!-- Modal content-->
                <div class="modal-content">
                  <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Delete your business listing</h4>
                  </div>

                  <div class="modal-body">
                    <h3>Are you sure you want to delete this Business Partner Listing? </h3>
                    <!-- <h4>This <u> cannot </u> be undone</h4> -->
                    <form action="" method="post" class="form_delete" id="">
                      <ul class="list-inline list-unstyled">
                        <li><button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button></li>
                        <li><a href='<?php echo site_url();?>/all-business/?del_id=<?php echo the_ID();?>'><button type="button" class="btn btn-default" name="delete_else1">Delete</button></a></li>
                      </ul>
                    </form> 
                  </div>


                </div>

              </div>
            </div>  
          </figure>
        </div>

        <?php 
      endwhile;
      wp_reset_query();
    }
    else{
      echo "<div class='alert alert-danger fs-error-fund lost_div'><span style='color:red;'> You have not set up any Business Partner Listings. <a href='".site_url()."/create-fundraising-host-page'>Click </a> here to create a new Business Partner listing.</span></div>";
    } ?>

    

    <?php if(isset($_GET['del_id'])){
      $else_del_id = $_GET['del_id'];
      wp_delete_post($else_del_id);
      global $wpdb;
      $del = $wpdb->query('DELETE FROM wp_post_relationships where r_id =  "'.$else_del_id.'"');
      $del_coupon = $wpdb->query('DELETE FROM wp_donation where retailer_id =  "'.$else_del_id.'"');

      header("location:".site_url()."/all-business/");
    }
    ?>
	<div class="loadmore-allbusiness"></div>
	
	
  </div>
	<div style="clear:both"></div>
	<div class="loader-allbusiness" style="display:none;text-align:center">								
		<img class="img-loader" src="<?php bloginfo('template_directory');?>/images/ajax-loader.gif">
	</div>

	<div class='alert alert-danger fs-error-fund fs-error-fund-part nomore-allbusiness' style="display:none">
		<div>
			<span style='color:red;'>No more business available.</span>
		</div>
	</div>
	
  <div id="show_posts"></div>

            
</div>

 </div>

    <?php } else { ?>
<div class="alert alert-danger alert_not_login">
  <h3>  Please register and login to view this page.</h3>
</div>
<?php } ?>
 
</div>
</div>
</div>
</div>

<!-- Specific user business event page end here -->
<script type="text/javascript" src="<?php bloginfo('template_directory');?>/js/dashboard-all-business.js"></script>
<?php
get_footer('author');
?>