<?php 
/* Template Name: Author Pending Event */

get_header('author');

$user = wp_get_current_user();
$user_id =  $user->ID;
$username =  $user->user_nicename;

global $wpdb;

?>
<div class="container new_class">
<div class="row">
<div class="div_box">
<div class="second_divbox">

   <?php if(is_user_logged_in()) { ?>
<div class="col-md-12 col-sm-12 col-xs-12 four_btn">

<div class="info_about">
<h2>Pending Fundraising Campaigns</h2>
</div> 

      <div>

        <!-- ============================ --> 
        <div id="panding_acco" class="main">
          <div class="accordions">
            <div class="accordion-section post-listing">
			<?php 
				global $paged; global $args;
			   $paged = ( get_query_var( 'paged' ) ) ? get_query_var( 'paged' ) : 1;
			   $args = null;
			
			   $query_args = array( 'post_type' => 'fundraiser', 'posts_per_page' => -1,'post_status' =>'draft','paged' => $paged,'author' => $user_id);
			   $post_loop = new WP_Query($query_args);
			   $count_pendingcomp = $post_loop->post_count;
			?>
			 <input type="hidden" id="count_pendingcomp" value="<?php echo $count_pendingcomp ;?>">
			
              <a class="accordion-section-title" href="#accordion-1">Pending Fundraising Campaigns</a>
              <div id="accordion-1" class="accordion-section-content">
                <div class="border_acc1">

		  <?php 
		  
			
          $args = array( 'post_type' => 'fundraiser', 'posts_per_page' => 9,'post_status' =>'draft','paged' => $paged,'author' => $user_id);

                  $loop = new WP_Query($args);
                  if( $loop->have_posts()){

                    while ( $loop->have_posts() ) : $loop->the_post();
                      ?>

                      <?php
                      $pending_ids = get_the_ID();

                      $new_query2 = $wpdb->get_results("SELECT * FROM wp_post_relationships where f_id = $pending_ids");
                      foreach ($new_query2 as $key => $new_qry2)
                      {
                       $rr_id2 = $new_qry2->r_id;
                       $post_slug2 = get_post_field( 'post_name', $rr_id2 );
                     }
                      ?>


                      <div class="col-md-4 col-sm-6 post_list pending_list hello-pend">
                        <figure>
                          <div class="post_border">
                            <div class="thumb_image">
                              <div class="blanks">

                                <?php 

                                $pending_ids = get_the_ID();
                                $prnding_url1 = get_the_post_thumbnail_url($pending_ids); 


                                if($prnding_url1){
                                  echo'<img class="img-responsive innerimages" src="'.$prnding_url1.'">';
                                }
                                else{
                                  echo'<img class="img-responsive innerimages" src="'.site_url().'/wp-content/uploads/2017/09/dummy_img.jpg">'; } ?>
                                </div>
                              </div>
                              <div class="com_div">
                                <div class="col-sm-12 col-md-12 post_titl1">
                                  <?php $trimtitle = get_the_title(); $shorttitle = wp_trim_words( $trimtitle, $num_words = 3, $more = '… ' );
                                  echo '<h4 class="title_event">' . '<a class="post_titles" href="' . get_permalink() . '" >' . ucfirst($shorttitle) . '</a></h4>'; ?>
                                </div>
                                <div class="col-sm-12 col-md-12 post_titl">
                                  <?php echo '<p>'; echo wp_trim_words( get_the_content(), '3', '...' );  echo'</p>';?>
                                  <p class="hvrnone"><span>Status:</span> Pending <p/>
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
                                    <li><a href="<?php echo home_url();?>/fundraiser/?p=<?php echo the_ID();?>"  data-toggle="tooltip" title="View!"><i class="fa fa-eye" aria-hidden="true"></i></a></li>
                                    <li><a href="<?php echo home_url();?>/edit-events/?edit_id=<?php echo the_ID();?>" data-toggle="tooltip2" title="Edit!"  ><i class="fas fa-pencil-alt"></i></a></li>
                                    <li><a type="button" data-toggle="modal" title="Delete!" data-target="#myModal33_pend<?php the_ID();?>" ><i class="fas fa-trash-alt"></i></a></li>
                                  </ul>
                                </figcaption>


                                <?php 
                              }
                            }
                            ?>
                            <!-- popup for delete -->
                            <div class="modal fade" id="myModal33_pend<?php the_ID();?>" role="dialog">
                              <div class="modal-dialog delete_modal">

                                <!-- Modal content-->
                                <div class="modal-content">
                                  <div class="modal-header">    
                                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                                    <h4 class="modal-title">Delete this pending campaign!</h4>
                                  </div>

                                  <div class="modal-body">
                                    <h3>Are you sure you want to delete this pending campaign? </h3>
                                    <!-- <h4>This <u> cannot </u> be undone</h4> -->
                                    <form action="" method="post" class="form_delete" id="del<?php the_ID();?>">
                                      <ul class="list-inline list-unstyled">
                                        <li><button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button></li>
                                        <li><a href='<?php echo site_url();?>/pending-event/?del_id111=<?php echo the_ID();?>'><button type="button" class="btn btn-default" name="delete_else1">Delete</button></a></li>
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
                    else
                    {
                      echo "<div class='alert alert-warning fs-error-fund'><span style='color:red;'> No available fundraising campaigns </span></div>";
                    } ?>



                    <?php if(isset($_GET['del_id111']))
                    {
                      $else_del_id2 = $_GET['del_id111'];
                      wp_delete_post($else_del_id2);
					global $wpdb;
					$del = $wpdb->query('DELETE FROM wp_post_relationships where f_id ="'.$else_del_id2.'"');
                      header("location:".site_url()."/pending-event/");
                    }

                   ?>
				   <div class="load-more-pend-comp"></div>
				   <div style="clear:both"></div>
					<div class="loader" style="display:none;text-align:center">								
						<img class="img-loader" src="<?php bloginfo('template_directory');?>/images/ajax-loader.gif">
					</div>

					<div class='alert alert-danger fs-error-fund fs-error-fund-part no-pend-fund' style="display:none">
						<div>
							<span style='color:red;'>No more pending fundraising compaigns.</span>
						</div>
					</div>
					
                  </div>




                </div><!--end .accordion-section-content-->
				
				
              </div><!--end .accordion-section-->

			  
              <div class="accordion-section post-listing">
			  
			<?php 
				global $paged; global $args;
			   $paged = ( get_query_var( 'paged' ) ) ? get_query_var( 'paged' ) : 1;
			   $req_args = null;
			
			   $query_args_your  = array( 'post_type' => 'fundraiser', 'posts_per_page' => -1,'post_status' =>'none','paged' => $paged,'author' =>  $user->ID);
			   $post_loop_your = new WP_Query($query_args_your);
			   $count_fundraisercomp = $post_loop_your->post_count;
			?>
			
                <a class="accordion-section-title" href="#accordion-2">Your Fundraiser Campaign Requests</a>
                <div id="accordion-2" class="accordion-section-content">
                  <div class="border_acc">
					
                    <?php
                 
                    $req_args  = array( 'post_type' => 'fundraiser', 'posts_per_page' => 9,'post_status' =>'none','paged' => $paged,'author' =>  $user->ID);
                    $req_loop = new WP_Query($req_args);
                    if( $req_loop->have_posts()){
                     while ( $req_loop->have_posts() ) : $req_loop->the_post();
                      ?>

                      <?php

                      $fundraiser_id2 = $post->ID;

                      global $wpdb;
                      if($fundraiser_id2 != '')
                      {
						  $new_query2 = $wpdb->get_results("SELECT * FROM wp_post_relationships where f_id = $fundraiser_id2");
						  
						  $user_count = $wpdb->get_var( "SELECT COUNT(*) FROM wp_post_relationships where f_id = $fundraiser_id2" );
						  
					  }
					  foreach ($new_query2 as $key => $new_qry2)
                      {
                       $rr_id2 = $new_qry2->r_id;
                       $post_slug2 = get_post_field( 'post_name', $rr_id2 );
                     }
                      if(isset($rr_id2) && !empty($rr_id2) && !empty($fundraiser_id2))
                     {

                     $test_qery2 = $wpdb->get_results("SELECT * FROM wp_post_relationships where r_id=$rr_id2 AND f_id=$fundraiser_id2");

                     foreach ($test_qery2 as $key => $new_qq22)
                     {
                      $test_qery22 = $new_qq22->r_name;

                      $post_slugslice = stripslashes(stripslashes(stripslashes($test_qery22)));
                      $post_slugsnew = str_replace('\"', '', $post_slugslice);
                      $test_qery2211 = $new_qq22->status;
                      ?>

                      <?php
                      if($test_qery2211 == 'none' || $test_qery2211== '0'){



    //$res_image = get_field('feature_image_1',$fundraiser_id2);
                        $res_imageurl =  get_the_post_thumbnail_url($fundraiser_id2);

                        ?>
                        <div class="col-md-4 col-sm-6 post_list pending_list hello-request">
                          <figure>
                            <div class="post_border">
                              <div class="thumb_image">
                                <div class="blanks">
                                  <?php if($res_imageurl){
                                    echo'<img class="img-responsive innerimages" src="'.$res_imageurl.'">';
                                  }
                                  else{
                                    echo'<img class="img-responsive innerimages" src="'.site_url().'/wp-content/uploads/2017/09/dummy_img.jpg">'; } ?>
                                  </div>
                                </div>

                                <div class="com_div">
                                  <div class="col-sm-12 col-md-12 post_titl1">
                                    <?php $trimtitle = get_the_title(); $shorttitle = wp_trim_words( $trimtitle, $num_words = 3, $more = '… ' );
                                    echo '<h4 class="title_event">' . '<a class="post_titles" href="' . get_permalink() . '" >' . ucfirst($shorttitle) . '</a></h4>'; ?>
                                  </div>

                                  <div class="col-sm-12 col-md-12 post_titl">
                                    <?php echo '<p>'; echo wp_trim_words( get_the_content(), '3', '...' );  echo'</p>';?>
                                    <p class="hvrnone"><span>Request Sent To:</span>  <a href="<?php site_url()?>/retailer/<?php echo $post_slug2;?>"><?php echo wp_trim_words($post_slugsnew, '3', '...');?></a></p>

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
                                    <li><a href="<?php echo home_url();?>/fundraiser/?p=<?php echo the_ID();?>"  data-toggle="tooltip" title="View!"><i class="fa fa-eye" aria-hidden="true"></i></a></li>
                                    <li><a href="<?php echo home_url();?>/edit-events/?edit_id=<?php echo the_ID();?>" data-toggle="tooltip2" title="Edit!" ><i class="fas fa-pencil-alt"></i></a></li>
                                    <li><a type="button" data-toggle="modal" title="Delete!" data-target="#myModal33_req<?php the_ID();?>" ><i class="fas fa-trash-alt"></i></a></li>
                                  </ul>

                                </figcaption>
                                <?php 
                              }
                            }
                            ?>

                            <!-- popup for delete -->
                            <div class="modal fade" id="myModal33_req<?php the_ID();?>" role="dialog">
                              <div class="modal-dialog delete_modal">

                                <!-- Modal content-->
                                <div class="modal-content">

                                  <div class="modal-header">    
                                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                                    <h4 class="modal-title">Delete your fundraiser campaign request!</h4>
                                  </div>


                                  <div class="modal-body">
                                    <h3>Are you sure you want to delete this fundraiser campaign Request?</h3>
                                    <!-- <h4>This <u> cannot </u> be undone</h4> -->
                                    <form action="" method="post" class="form_delete" id="del<?php the_ID();?>">
                                      <ul class="list-inline list-unstyled">
                                        <li><button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button></li>
                                        <li><a href='<?php echo site_url();?>/pending-event/?del_idres=<?php echo the_ID();?>'><button type="button" class="btn btn-default" name="delete_else1">Delete</button></a></li>
                                      </ul>
                                    </form> 
                                  </div>


                                </div>

                              </div>
                            </div>  



                          </figure>
                        </div>
                        <?Php } }?>

                        <?php
                      }
                    endwhile;
                    wp_reset_query();
					
					?>
					<input type="hidden" id="count_fundraisercomp" value="<?php echo $user_count ;?>">
					<?php 
                  } ?>



                  <?php if(isset($_GET['del_idres']))
                  {
                    $else_del_res = $_GET['del_idres'];
                    wp_delete_post($else_del_res);
      global $wpdb;
      $del = $wpdb->query('DELETE FROM wp_post_relationships where f_id =  "'.$else_del_res.'"');
                    header("location:".site_url()."/pending-event/");
                  }
                  ?>

				<div class="load-more-compaigns your-fundraiser"></div>
				<div style="clear:both"></div>
				<div class="your-loader" style="display:none;text-align:center">								
					<img class="img-loader" src="<?php bloginfo('template_directory');?>/images/ajax-loader.gif">
				</div>

				<div class='alert alert-danger fs-error-fund fs-error-fund-part nomore-your-fundraiser' style="display:none">
					<div>
						<span style='color:red;'>No more fundraiser campaign request available.</span>
					</div>
				</div>
				
                </div>
              </div><!--end .accordion-section-content-->
			 
            </div><!--end .accordion-section-->

            <div class="accordion-section post-listing">
			  
			<?php 
				global $paged; global $args;
			   $paged = ( get_query_var( 'paged' ) ) ? get_query_var( 'paged' ) : 1;
			   $req_args = null;
			
			   $query_args  = array( 'post_type' => 'fundraiser', 'posts_per_page' => -1,'post_status' =>'none','author' => $user->ID);
			   $post_loop = new WP_Query($query_args);
			   $count_rejectedfundraiser = $post_loop->post_count;
			?>
			 
              <a class="accordion-section-title" href="#accordion-3">Your Rejected Fundraiser Campaigns</a>
              <div id="accordion-3" class="accordion-section-content">
                <div class="border_acc">
                  <?php
                  $res_args  = array( 'post_type' => 'fundraiser', 'posts_per_page' => 9,'post_status' =>'none','author' => $user->ID);
                  $res_loop = new WP_Query($res_args);
                  if( $res_loop->have_posts()){
                    while ( $res_loop->have_posts() ) : $res_loop->the_post();
                      $fundraiser_id22 = $post->ID;
                      if(isset($fundraiser_id22) && !empty($fundraiser_id22))

                     { 
					 $new_query_dis = $wpdb->get_results("SELECT * FROM wp_post_relationships where status = 2 AND f_id = $fundraiser_id22");
                      $count = count($new_query_dis);
					?>
					
					<?php
                      foreach ($new_query_dis as $key => $dis_status)
                      {

                        $dis_post_fund_id = $dis_status->f_id;
                        $dis_post_name    = $dis_status->f_name;
                        $post_slug = get_post_field( 'post_name', $dis_post_fund_id );
                        $dis_f_img_url =  get_the_post_thumbnail_url($dis_post_fund_id);
                        ?>
                        <div class="col-md-4 col-sm-6 post_list pending_list hello-disapproved">
                          <figure>

                            <div class="post_border">
                              <div class="thumb_image">
                                <div class="blanks">
                                  <?php if($dis_f_img_url){
                                    echo'<img class="img-responsive innerimages" src="'.$dis_f_img_url.'">';
                                  }
                                  else{
                                    echo'<img class="img-responsive innerimages" src="'.site_url().'/wp-content/uploads/2017/09/dummy_img.jpg">'; } ?>
                                  </div>
                                </div>
                                <div class="com_div">

                                  <div class="col-sm-12 col-md-12 post_titl1">
                                    <?php $trimtitle = $dis_post_name; $shorttitle = wp_trim_words( $trimtitle, $num_words = 3, $more = '… ' );
                                    echo '<h4 class="title_event"><a href ="'.site_url().'/?post_type=fundraiser&p='.$dis_post_fund_id.'&preview=true">'.$shorttitle.'</a><h4>';


                                    ?>
                                  </div>
                                  <div class="col-sm-12 col-md-12 post_titl">
                                    <?php echo '<p>'; echo wp_trim_words( get_the_content(), '3', '...' );  echo'</p>';?>
                                  </div>
                                </div>
                              </div>

                              <?php 
                              if(is_user_logged_in())
                              { 
                                if($current_user->ID == $user->ID)
                                {

                                  ?>
                                  <figcaption>
                                    <ul class="list-inline list-unstyled hvrbtn">
                                      <li><a href="<?php echo home_url();?>/fundraiser/?p=<?php echo the_ID();?>"  data-toggle="tooltip" title="View!"><i class="fa fa-eye" aria-hidden="true"></i></a></li>
                                      <li><a href="<?php echo home_url();?>/edit-events/?edit_id=<?php echo $dis_post_fund_id;?>" data-toggle="tooltip2" title="Edit!"  ><i class="fas fa-pencil-alt"></i></a></li>
                                      <li><a type="button" data-toggle="modal" title="Delete!" data-target="#myModal33_dis<?php echo $dis_post_fund_id;?>" ><i class="fas fa-trash-alt"></i></a></li>
                                    </ul> 

                                  </figcaption>

                                  <!-- popup for delete -->
                                  <div class="modal fade" id="myModal33_dis<?php echo $dis_post_fund_id;;?>" role="dialog">
                                    <div class="modal-dialog delete_modal">

                                      <!-- Modal content-->
                                      <div class="modal-content">



                                       <div class="modal-header">                           

                                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                                        <h4 class="modal-title">Delete a Rejected fundraiser campaign!</h4>
                                      </div>

                                      <div class="modal-body">
                                        <h3>Are you sure you want to delete your rejected campaign request?</h3>
                                        <!-- <h4>This <u> cannot </u> be undone</h4> -->
                                        <form action="" method="post" class="form_delete" id="del<?php the_ID();?>">
                                          <ul class="list-inline list-unstyled">
                                            <li><button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button></li>
                                            <li><a href='<?php echo site_url();?>/pending-event/?del_id_dis=<?php echo $dis_post_fund_id;?>'><button type="button" class="btn btn-default" name="delete_else1">Delete</button></a></li>
                                          </ul>
                                        </form> 
                                      </div>


                                    </div>

                                  </div>
                                </div> 


                                <?php 

                              } }  }
                              ?>


                            </figure>
                          </div>

                          <?php 
                        } 

                      endwhile;
                      wp_reset_query();
					  ?>
					  <input type="hidden" id="count_rejectedfundraiser" value="<?php echo $count ;?>">
                    <?php }


                    else{
                      echo "<div class='alert alert-warning fs-error-fund'><span style='color:red;'> No rejected fundraiser campaigns to list </span></div>";
                    } ?>




                           <?php if(isset($_GET['del_id_dis']))
                              {

                                $else_del_id2 = $_GET['del_id_dis'];
                                wp_delete_post($else_del_id2);
								  global $wpdb;
								  $del = $wpdb->query('DELETE FROM wp_post_relationships where f_id =  "'.$else_del_id2.'"');
                                header("location:".site_url()."/pending-event/");
                              }


                    ?>


					<div class="load-more-compaigns rejected-fundraiser"></div>
				
					
                  </div>
				  	<div style="clear:both"></div>
					<div class="rejected-loader" style="display:none;text-align:center">								
						<img class="img-loader" src="<?php bloginfo('template_directory');?>/images/ajax-loader.gif">
					</div>

					<div class='alert alert-danger fs-error-fund fs-error-fund-part no-rejected-fund' style="display:none">
						<div>
							<span style='color:red;'>No more rejected fundraiser campaigns available.</span>
						</div>
					</div>
					
					
                </div><!--end .accordion-section-content-->
				
              </div><!--end .accordion-section-->
			  
            </div><!--end .accordion-->      
          </div>
</div>


<!-- =============End accordion=============== -->


<?php } else { ?>
<div class="alert alert-warning alert_not_login">
  <h3> Please login to view this page.</h3>
</div>
<?php } ?>


</div>
</div>
</div>
</div>
</div>
<script type="text/javascript" src="<?php bloginfo('template_directory');?>/js/dashboard-load-more.js"></script>

<?php get_footer('author');?>