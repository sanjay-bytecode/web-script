<?php
/*********   window scroll load function  pending_fundraiser  *******/
add_action('wp_ajax_nopriv_pending_fundraiser', 'pending_fundraiser'); 
add_action('wp_ajax_pending_fundraiser', 'pending_fundraiser');

function pending_fundraiser()
{
		
		global $wpdb;
		$user = wp_get_current_user();
		$user_id =  $user->ID;
		$username =  $user->user_nicename;

		global $paged; global $args;
		$paged = ( get_query_var( 'paged' ) ) ? get_query_var( 'paged' ) : 1;
		$args = null;
		$offset = $_POST["offset_p"];
		$ppp = $_POST["ppp"];
		
		$args = array( 'post_type' => 'fundraiser', 'posts_per_page' => $ppp,'offset' => $offset,'post_status' =>'draft','paged' => $paged,'author' => $user_id);

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


			  <div class="col-md-4 col-sm-6 post_list post-listing">
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
			} 

		
die();
}

/*********   window scroll load compaign  your_fundraiser  *******/
add_action('wp_ajax_nopriv_your_fundraiser', 'your_fundraiser'); 
add_action('wp_ajax_your_fundraiser', 'your_fundraiser');

function your_fundraiser()
{
		
		global $wpdb;
		$user = wp_get_current_user();
		$user_id =  $user->ID;
		$username =  $user->user_nicename;

		global $paged; global $args;
		$paged = ( get_query_var( 'paged' ) ) ? get_query_var( 'paged' ) : 1;
		$args = null;
		$offset = $_POST["offset_p"];
		$ppp = $_POST["ppp"];
		
		$args = array( 'post_type' => 'fundraiser', 'posts_per_page' => $ppp,'offset' => $offset,'post_status' =>'none','paged' => $paged,'author' => $user_id);
		
		  $loop = new WP_Query($args);
		  if( $loop->have_posts()){
			 while ( $req_loop->have_posts() ) : $req_loop->the_post();
			  ?>

			  <?php

			  $fundraiser_id2 = $post->ID;

			  global $wpdb;
			  if($fundraiser_id2 != '')
			  {$new_query2 = $wpdb->get_results("SELECT * FROM wp_post_relationships where f_id = $fundraiser_id2");}
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
                        <div class="col-md-4 col-sm-6 post_list pending_list">
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
			}
			
			else
			{
			  echo "<div class='alert alert-warning fs-error-fund'><span style='color:red;'> No available fundraising campaigns </span></div>";
			} 

		
die();

}



/*********   window scroll load compaign  your_fundraiser  *******/
add_action('wp_ajax_nopriv_rejected_fundraiser', 'rejected_fundraiser'); 
add_action('wp_ajax_rejected_fundraiser', 'rejected_fundraiser');

function rejected_fundraiser()
{
		
		global $wpdb;
		$user = wp_get_current_user();
		$user_id =  $user->ID;
		$username =  $user->user_nicename;

		global $paged; global $args;
		$paged = ( get_query_var( 'paged' ) ) ? get_query_var( 'paged' ) : 1;
		$args = null;
		$offset = $_POST["offset_p"];
		$ppp = $_POST["ppp"];
		
		$args = array( 'post_type' => 'fundraiser', 'posts_per_page' => $ppp,'offset' => $offset,'post_status' =>'none','paged' => $paged,'author' => $user_id);
		
		
		  $loop = new WP_Query($args);
		  if( $loop->have_posts()){
                    while ( $res_loop->have_posts() ) : $res_loop->the_post();
                      $fundraiser_id22 = $post->ID;
                      if(isset($fundraiser_id22) && !empty($fundraiser_id22))

                     { $new_query_dis = $wpdb->get_results("SELECT * FROM wp_post_relationships where status = 2 AND f_id = $fundraiser_id22");
                      $count = count($new_query_dis);

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
			}
			else
			{
			   echo "<div class='alert alert-warning fs-error-fund'><span style='color:red;'> No rejected fundraiser campaigns to list </span></div>";
			} 

		
die();

}



/*********   window scroll load all business *******/
add_action('wp_ajax_nopriv_all_business', 'all_business'); 
add_action('wp_ajax_all_business', 'all_business');

function all_business()
{
		
		global $wpdb;
		$user = wp_get_current_user();
		$user_id =  $user->ID;
		$username =  $user->user_nicename;

		global $paged; global $args;
		$paged = ( get_query_var( 'paged' ) ) ? get_query_var( 'paged' ) : 1;
		$args = null;
		$offset = $_POST["offset_p"];
		$ppp = $_POST["ppp"];
		
		$args = array( 'post_type' => 'retailer', 'posts_per_page' => $ppp,'offset' => $offset,'post_status' =>'none','paged' => $paged,'author' => $user_id);
				
		  $loop = new WP_Query($args);
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

		
die();

}

/*********   window scroll load search business *******/
add_action('wp_ajax_nopriv_search_business', 'search_business'); 
add_action('wp_ajax_search_business', 'search_business');

function search_business()
{
		
		global $wpdb;
		$user = wp_get_current_user();
		$user_id =  $user->ID;
		$username =  $user->user_nicename;

		global $paged; global $args;
		$paged = ( get_query_var( 'paged' ) ) ? get_query_var( 'paged' ) : 1;
		$args = null;
		$offset = $_POST["offset_p"];
		$ppp = $_POST["ppp"];
		$search = $_POST["search_by"];
		
		
		$args = array( 'post_type' => 'retailer', 's' =>$search, 'posts_per_page' => $ppp,'offset' => $offset,'post_status' =>'publish','paged' => $paged,'author' => $user_id);
		
		  $loop = new WP_Query($args);
		  if( $loop->have_posts()){
		  while ( $loop->have_posts() ) : $loop->the_post();
			?>
		  <div class="col-md-4 col-sm-4 post_list">
				<figure>
					<div class="post_border">
						<div class="thumb_image">
							<div class="blanks">


								<?php

								$feature_image1 =  get_the_post_thumbnail_url($post->ID); 
								if($feature_image1){
									echo'<img class="img-responsive innerimages" src="'.$feature_image1.'">';
								}
								else{
									echo'<img class="img-responsive innerimages" src="'.site_url().'/wp-content/uploads/2017/09/dummy_img.jpg">'; } ?>
								</div>
							</div>
							<div class="com_div">
								<div class="col-sm-12 col-md-12 post_titl1">

									<?php $trimtitle = get_the_title(); $shorttitle = wp_trim_words( $trimtitle, $num_words = 7, $more = '… ' );
									echo '<h4>' . '<a class="post_titles" href="' . get_permalink() . '" target="_blank">' . ucfirst($shorttitle) . '</a></h4>';?>
								</div>
								<div class="col-sm-12 col-md-12 post_titl">
									<?php echo '<p>'; echo wp_trim_words( get_the_content(), '5', '...' );  echo'</p>';?>
									<?php $retailer_id1 = $post->ID; 
									?>
								</div>
							</div>
						</div>
						<?php 
						if(is_user_logged_in())
						{ 
							if($current_user->ID == $user_ret_ids)
							{

								?>
								<figcaption>
									<ul class="list-inline list-unstyled hvrbtn">
										<li><a href="<?php echo get_permalink(); ?>" target="_blank" data-toggle="tooltip" title="View!"><i class="fa fa-eye" aria-hidden="true"></i></a></li>
										<li><a href="<?php echo home_url();?>/wp-admin/post.php?post=<?php the_ID(); ?>&action=edit" data-toggle="tooltip2" title="Edit!" ><i class="fa fa-pencil" aria-hidden="true"></i></a></li>
										<li><a type="button" data-toggle="modal" title="Delete!" data-target="#myModal33else<?php the_ID();?>" ><i class="fa fa-trash-o" aria-hidden="true"></i></a></li>
									</ul>
									<!-- popup for delete -->
									<div class="modal fade" id="myModal33else<?php the_ID();?>" role="dialog">
										<div class="modal-dialog delete_modal">

											<!-- Modal content-->
											<div class="modal-content">


												<div class="modal-body">
													<?php if($user_type == fundraiser) { ?>
													<h3>Are you sure you want to delete this Fundraiser Campaign?</h3>
													<?php } else if($user_type == retailer){ ?>
													<h3>Are you sure you want to delete this Business Partner? </h3>
													<?php } ?>
													<!-- <h4>This <u> cannot </u> be undone</h4> -->
													<form action="" method="post" class="form_delete" id="del<?php the_ID();?>">
														<ul class="list-inline list-unstyled">
															<li><button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button></li>
															<li><a href='<?php echo site_url();?>/user/<?php echo $username; ?>/?del_id=<?php echo the_ID();?>'><button type="button" class="btn btn-default" name="delete_else1">Delete</button></a></li>
														</ul>
													</form> 
												</div>


											</div>

										</div>
									</div>  

								</figcaption>

								<?php } } ?>

							</figure>
				</div>

        <?php 
      endwhile;
      wp_reset_query();
    }

		
die();

}


/*********   window scroll load search business *******/
add_action('wp_ajax_nopriv_approved_event', 'approved_event'); 
add_action('wp_ajax_approved_event', 'approved_event');

function approved_event()
{
		
		global $wpdb;
		$user = wp_get_current_user();
		$user_id =  $user->ID;
		$username =  $user->user_nicename;

		global $paged; global $args;
		$paged = ( get_query_var( 'paged' ) ) ? get_query_var( 'paged' ) : 1;
		$args = null;
		$offset = $_POST["offset_p"];
		$ppp = $_POST["ppp"];
		$search = $_POST["search_by"];
				
		$args = array( 'post_type' => 'fundraiser', 'posts_per_page' => $ppp,'offset' => $offset,'post_status' =>'publish','paged' => $paged,'author' => $user_id);

		
		  $loop = new WP_Query($args);
		  if( $loop->have_posts()){
		  while ( $loop->have_posts() ) : $loop->the_post();
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

		
die();

}