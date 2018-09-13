<?php 
/* Template Name: Author Approved Event*/

get_header('author');

$user = wp_get_current_user();
$user_id =  $user->ID;
$username =  $user->display_name;
 
global $paged; global $args;
$paged = ( get_query_var( 'paged' ) ) ? get_query_var( 'paged' ) : 1;
$args= null;
$args = array( 'post_type' => 'fundraiser', 'posts_per_page' => 9,'post_status' =>'publish','paged' => $paged,'author' => $user_id);


$query_args = array( 'post_type' => 'fundraiser', 'posts_per_page' => -1,'post_status' =>'publish','paged' => $paged,'author' => $user_id);
$post_loop = new WP_Query($query_args);
$count_approvevent = $post_loop->post_count;

?>

<!-- Approved fundraisers page start here -->

<div class="container new_class">
	<div class="row">
		<div class="div_box">
			<div class="second_divbox">
        <?php if(is_user_logged_in()) { ?>
        <div class="col-md-12 col-sm-12 col-xs-12 four_btn post-listing">
         <div class="info_about">
          <h2>Approved Fundraiser Campaigns</h2>
        </div>
			<input type="hidden" id="count_approvevent" value="<?php echo $count_approvevent ;?>">
        <?php
		
		$loop = new WP_Query( $args );
        if( $loop->have_posts())
        {
          while ( $loop->have_posts() ) : $loop->the_post();
            ?>
            <?php
            $feature_image_app = get_the_post_thumbnail_url($POST_ID);
            ?>
            <div class="col-md-4 col-sm-6 post_list">
             <figure>

              <div class="post_border">
                <div class="thumb_image">
                  <div class="blanks">
                    <?php if($feature_image_app){
                      echo'<img class="img-responsive innerimages" src="'.$feature_image_app.'">';
                    }
                    else{
                      echo'<img class="img-responsive innerimages" src="'.site_url().'/wp-content/uploads/2017/09/dummy_img.jpg">'; } ?>
                    </div>
                  </div>
                  <div class="com_div">
                    <div class="col-sm-12 col-md-12 post_titl1">
                      <?php $trimtitle = get_the_title(); $shorttitle = wp_trim_words( $trimtitle, $num_words = 3, $more = '… ' );
                      echo '<h4>' . '<a class="post_titles" href="' . get_permalink() . '" >' . ucfirst($shorttitle) . '</a></h4>';?>
                    </div>
                    <div class="col-sm-12 col-md-12 post_titl">
                      <?php echo '<p class="aaa">'; echo wp_trim_words( get_the_content(), '3', '..' );  echo'</p>';?>
                      <h5 class="hvrnone">
                        <?php

                       $fundraiser_id = get_the_ID();
                        global $wpdb;
                        $aproved_query = $wpdb->get_results("SELECT * FROM wp_post_relationships where f_id=$fundraiser_id");
                        $count = count($aproved_query);
                        foreach ($aproved_query as $key => $new_approved)
                        {
                          $rr_id11 = $new_approved->r_id;
                          $post_slug11 = get_post_field( 'post_name', $rr_id11 );
                        }
                        
                        $approved_new_qry = $wpdb->get_results("SELECT * FROM wp_post_relationships where r_id = $rr_id11 AND f_id = $fundraiser_id");
                         // echo $count = count($approved_new_qry);

                        foreach ($approved_new_qry as $key => $newquery11)
                        {
                          $r_new11 = $newquery11->r_name;
                          $r_neww22 = $newquery11->f_auth_name;
                          $outh_id = $newquery11->rr_author_id;
                          $auth_name= get_the_author_meta('first_name', $outh_id).' '.get_the_author_meta('last_name', $outh_id);
                          ?>
                          <?php echo ucfirst($auth_name);?>
                          <?php  }
                          
                          ?>
                        </h5>
                      </div>
                    </div>
                  </div>
                  <?php
                  if(is_user_logged_in())
                  {  
                   if($current_user->ID == $user->ID || (in_array("administrator", $user->roles)) || (in_array("editor", $user->roles)))
                   { 
                    ?>
                    <figcaption>
                      <ul class="list-inline list-unstyled hvrbtn">
                        <li><a href="<?php echo get_permalink(); ?>"  data-toggle="tooltip" title="View!"><i class="fa fa-eye" aria-hidden="true"></i></a></li>
                        <li><a href="<?php echo home_url();?>/edit-events/?edit_id=<?php echo the_ID();?>" data-toggle="tooltip2" title="Edit!"  ><i class="fas fa-pencil-alt"></i></a></li>

                        <?php if (get_post_status(get_the_ID()) != "publish") { ?>
                        <li><a type="button" data-toggle="modal" title="Delete!" data-target="#myModal33_fund<?php echo the_ID();?>" ><i class="fas fa-trash-alt"></i></a></li>
                        <?php } ?>

                      </ul>
                    </figcaption>
                    <?php } } ?>

                    <div class="modal fade" id="myModal33_fund<?php echo the_ID();?>" role="dialog">
                      <div class="modal-dialog delete_modal">

                        <!-- Modal content-->
                        <div class="modal-content">
                          <div class="modal-header">
                           
                            <h4 class="modal-title">Delete your Fundraiser Campaign!</h4>
                             <button type="button" class="close" data-dismiss="modal">&times;</button>
                          </div>
                          <div class="modal-body">
                            <h3>Are you sure you want to delete your Fundraiser Campaign?</h3>
                            <!-- <h4>This <u> cannot </u> be undone</h4> -->
                            <form action="" method="post" class="form_delete">
                              <ul class="list-inline list-unstyled">
                                <li><button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button></li>
                                <li><a href='<?php echo site_url();?>/approved-event/?del_id1=<?php echo the_ID();?>'><button type="button" class="btn btn-default" name="delete_else1">Delete</button></a></li>

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
              echo "<div class='alert alert-danger fs-error-fund'><span style='color:red;'> No Campaigns to list. <a href='".site_url()."/create-fundraising-event-page'>Click </a> here to create a Fundraiser Campaign.</div>";
            } ?>

            


            <?php if(isset($_GET['del_id1'])){
              $else_del_id1 = $_GET['del_id1'];
              wp_delete_post($else_del_id1);
              global $wpdb;
              $del = $wpdb->query('DELETE FROM wp_post_relationships where f_id =  "'.$else_del_id1.'"');
              header("location:".site_url()."/approved-event/");
            }

            ?>
         <div class="loadmore-approvedevent"></div>
          </div>
		  <div style="clear:both"></div>
			<div class="loader-approvedevent" style="display:none;text-align:center">								
				<img class="img-loader" src="<?php bloginfo('template_directory');?>/images/ajax-loader.gif">
			</div>

			<div class='alert alert-danger fs-error-fund fs-error-fund-part nomore-approvedevent' style="display:none">
				<div>
					<span style='color:red;'>No more compaigns available.</span>
				</div>
			</div>

<?php } else { ?>
<div class="alert alert-warning alert_not_login">
  <h3> Please register and login to view this page.</h3>
</div>
<?php } ?>
        </div>
      </div>
    </div>
  </div>
<script type="text/javascript" src="<?php bloginfo('template_directory');?>/js/dashboard-approved-event.js"></script>
<!-- Approved fundraisers page end here -->
<?php get_footer('author');?>