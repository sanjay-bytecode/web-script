<?php
add_action('wp_ajax_nopriv_search_approved_and_live_campaign', 'search_approved_and_live_campaign');
add_action('wp_ajax_search_approved_and_live_campaign', 'search_approved_and_live_campaign');
function search_approved_and_live_campaign()
{

	global $wpdb;

	$get_fund_data = $wpdb->get_results("SELECT f_id FROM wp_post_relationships where f_end_date > CURRENT_TIMESTAMP AND status = 1"); 

	$count_fund = count($get_fund_data);

	foreach ($get_fund_data as $key_1 => $get_fund_id) 
	{
		$fud_arry_ids[] = $get_fund_id->f_id;
	}
	?>
	<section class="campaign-sec">
		<div class="ballon"><img src="<?php bloginfo('template_directory');?>/images/ballon.png"></div>
		<div class="orignal-all-fund-post">
			<div class="row campaign-list camp_listing ">
				<?php
				$args= null;
				$args = array( 'post_type' => 'fundraiser', 'post__in' => $fud_arry_ids , 'posts_per_page' => -1,'post_status' =>'publish');
				$loop = new WP_Query( $args );

				$loop_count = count($loop);
				?>
				<h4 class="all_fundraisers_curr_compaigns"><strong><?php echo $count_fund; ?></strong>  -  Current Campaigns</h4>
				<?php
				if($count_fund != 0) {

					if( $loop->have_posts())
					{
						while ( $loop->have_posts() ) : $loop->the_post();

						//post id 
							$post_id =  get_the_ID();

							$trimtitle = get_the_title();				
							$shorttitle = wp_trim_words( $trimtitle, $num_words = 7, $more = '… ' );
							$content =  get_the_content();

							$r_id = $wpdb->get_results("SELECT * FROM wp_post_relationships where f_id = $post_id");

							foreach ($r_id as $key => $lo_url) 
							{
								$rtlr_id = $lo_url->r_id;
								$post_author_id = $lo_url->f_auth_id;
								$event_auth_name = $lo_url->f_auth_name;
								$f_post_id = $lo_url->f_id;
								$rrr_author_id = $lo_url->rr_author_id;
							}

							$feature_image_app = get_the_post_thumbnail_url($post_id);

						//get fundraiser event amount
			//$event_amt = get_field('amount', $post_id);	

							$event_amount = get_field('amount',$post_id);
							$event_amt = str_replace( ',', '', $event_amount );		

						//sql query for get donated amount
							$dnt_amts = $wpdb->get_results("SELECT donation_amt FROM wp_donation where fund_ent_id = ".$post_id." ");

							$count = count($dnt_amts);

							$amt_donation = array();
							foreach ($dnt_amts as $key => $get_donation) 
							{
								$amt_donation[] = $get_donation->donation_amt;
								$amts = str_replace(',', '', $amt_donation);
							}
						//return print_r($amts);
							if($count != 0)
							{ 
								$g_amt = array_sum($amts);
							}
							else
							{ 
								$g_amt = "0";
							}

		    // code for get the days and time left for an event	

							$current_date = date("Y/m/d");
							$expire_date  = get_post_meta( $post_id, 'event_expire_date', true);
							$exp_time = get_post_meta( $post_id, 'end_time', true);

	    //difference between post date and current date
							$date_diff = strtotime($expire_date) - strtotime($current_date);

        //calculate the days left
							$days = floor(($date_diff - $years * 365*60*60*24 - $months*30*60*60*24)/ (60*60*24));

							$timestamp = time();
							$date_time = date("H:i a", $timestamp); 
							@$t1 = $exp_time - $date_time;

		//Day and time left

							if($days == 0)
							{
								if($t1 > 0){
									$timme_rimaning = "Time";
									$left_date = $t1." Hours";

								}else{
								//$timme_rimaning = "Days Left to Donate";
									$left_date = "EXPIRED";
								}

							}elseif($days == -1 || $days < -1)
							{
								$timme_rimaning = "Days Left to Donate";
								$left_date = "EXPIRED";
							}
							elseif($days > 0)
							{
								$timme_rimaning = "Days Left to Donate";
								$left_date = $days." Days";
							}

            //percentage amount calculate

							$amount_percentage = ($g_amt * 100) / $event_amt;

			//$amount_percentage = ($g_amt / 100) * $event_amt;

					//$amount_percentage = ($g_amt * 100) / $event_amt;
							$amount_percentage = round($amount_percentage, 1);

							?>

							<div class="col-md-4 col-sm-4 show-all fundraisers_listing_view">
								<div class="campaign-loop">
									<figure><a href="<?php echo get_permalink($post_id); ?>"><img src="<?php echo $feature_image_app; ?>"></a></figure>
									<figcaption>
										<h4><a href="<?php echo get_permalink($post_id); ?>"><?php echo ucfirst($shorttitle);  ?></a></h4>
										<span><?php echo wp_trim_words($content, '10', '..' ); ?></span>
										<p><strong>$<?php echo $g_amt; ?></strong>  of  <strong>$<?php echo $event_amt; ?></strong> Goal </p>
										<p>
											<?php
											$createdate = get_post_meta( $post_id, 'date_approvel', true );
											if($createdate)
											{
												?>
												<span class="all_fund_date_created">Date Created </span>  
												<?php			
												echo $date_create = date( "M d, Y", strtotime( $createdate )); 
											}
											?>
										</p>
										<div class="progress"><div class="progress-inside" style="width:<?php if($amount_percentage <= 100) { echo $amount_percentage; } else { echo 100; } ?>%"></div></div>
										<ul class="progress-list">
											<li><?php if($amount_percentage <= 100) { echo $amount_percentage; } else { echo 100; } ?>%
												<span>Funded</span></li>
												<li>$<?php echo number_format($g_amt);?>
													<span>Donated</span>
												</li>
												<li><?php echo $left_date; ?>
													<?php if($left_date != 'EXPIRED') { ?><span>Time Left</span><?php } else { ?>
													<span style="visibility: hidden;">Time Left</span><?php } ?>
												</li>
											</ul>
											<form method="post" action="<?php echo site_url()?>/raiseit-donate">
												<input type="hidden" name="raiseit_amt" value="<?php echo $event_amt;?>">
												<input type="hidden" name="retail_post_id" value="<?php echo $rtlr_id; ?>">
												<input type="hidden" name="retailer_author" value="<?php echo $rrr_author_id; ?>">
												<input type="hidden" name="fund_author_id" value="<?php echo $post_author_id; ?>">
												<input type="hidden" name="fund_name" value="<?php echo $trimtitle; ?>">
												<input type="hidden" name="event_auth_name" value="<?php echo $event_auth_name;?>">
												<input type="hidden" name="ff_id" value="<?php echo $post_id;  ?>">
												<input type="hidden" name="event_e_date" value="<?php echo $expire_date; ?>">
												<input type="submit" class="btn donation-fund-btn" name="direct_dontaion" value="Donate Now">
											</form>
											<div class="shareaholic-canvas" data-app="share_buttons" data-app-id-name="index_below_content"></div>
										</figcaption>
									</div>
								</div>
								<?php
								
							endwhile;
							wp_reset_query();
						}

					}

					else {
						echo "<div class='alert alert-danger fs-error-fund fs-error-fund-part'><div class='row campaign-list'><span style='color:red;'>There are no current campaigns available.</span></div></div>";
					}


					?>	
				</div>

			</div>
		</section>
		<?php
		die();
	}

	add_action('wp_ajax_nopriv_fundpost_filter_by_most_funded', 'fundpost_filter_by_most_funded');
	add_action('wp_ajax_fundpost_filter_by_most_funded', 'fundpost_filter_by_most_funded');

	function fundpost_filter_by_most_funded()
	{
		global $wpdb;
	//$args = array( 'post_type' => 'fundraiser', 'posts_per_page' => 9,'post_status' =>'publish', 'meta_key' => 'most_fund',	'orderby' => 'meta_value_num','order' => 'DESC');

		$args = array(
			'post_type' => 'fundraiser',
			'posts_per_page' => 9,
			'post_status' =>'publish',
			'meta_query' => array(
				array(
					'key' => 'most_fund',
					'value' => '0',
					'compare' => '!=',
				),
			),
			'orderby' => 'meta_value_num',
			'order' => 'DESC'
		);

		$loop = new WP_Query( $args );

		//$post_query = array( 'post_type' => 'fundraiser', 'posts_per_page' => -1,'post_status' =>'publish', 'meta_key' => 'most_fund',	'orderby' => 'meta_value_num','order' => 'DESC');
		$post_query = array(
			'post_type' => 'fundraiser',
			'posts_per_page' => -1,
			'post_status' =>'publish',
			'meta_query' => array(
				array(
					'key' => 'most_fund',
					'value' => '0',
					'compare' => '!=',
				),
			),
			'orderby' => 'meta_value_num',
			'order' => 'DESC'
		);


		$post_loop = new WP_Query( $post_query );
		$count_mostfund = $post_loop->post_count;

		?>
		<div class="row campaign-list post-listing">
			<input type="hidden" id="count_mostfund" value="<?php echo $count_mostfund ;?>">
			<?php
			if( $loop->have_posts())
			{
				while ( $loop->have_posts() ) : $loop->the_post();
					$post_id =  get_the_ID();
					$trimtitle = get_the_title();				
					$shorttitle = wp_trim_words( $trimtitle, $num_words = 7, $more = '… ' );
					$content =  get_the_content();
					$event_amount = get_field('amount',$post_id);

					$event_amt = str_replace( ',', '', $event_amount );
					$feature_image_app = get_the_post_thumbnail_url($post_id);

					$r_id = $wpdb->get_results("SELECT * FROM wp_post_relationships where f_id = $post_id");

					foreach ($r_id as $key => $lo_url) 
					{
						/*$llogo_url = $lo_url->retailer_logo;*/
						$rtlr_id = $lo_url->r_id;
						$post_author_id = $lo_url->f_auth_id;
						$event_auth_name = $lo_url->f_auth_name;
						$f_post_id = $lo_url->f_id;
						$rrr_author_id = $lo_url->rr_author_id;
						/*$donnor_id = $lo_url->donor_id ;*/
					} 

					$dnt_amts = $wpdb->get_results("SELECT donation_amt,donation_time FROM wp_donation where fund_ent_id = ".$post_id." ");
					$count = count($dnt_amts);

					$amt_donation = array();
					$last_donation = array();
					foreach ($dnt_amts as $key => $get_donation) 
					{
						$amt_donation[] = $get_donation->donation_amt;
						$amts = str_replace(',', '', $amt_donation);
						$last_donation = $get_donation->donation_time;
					}
					if($count != 0)
					{  
						$g_amt = @array_sum($amts);
					}
					else
					{
						$g_amt = "0";
					}

		// code for get the days and time left for an event	
					$current_date = date("Y/m/d");
					$expire_date  = get_post_meta( $post_id, 'event_expire_date', true);
					$exp_time = get_post_meta( $post_id, 'end_time', true);
	    //difference between post date and current date
					$date_diff = strtotime($expire_date) - strtotime($current_date);
        //calculate the days left
					$days = floor(($date_diff - $years * 365*60*60*24 - $months*30*60*60*24)/ (60*60*24));
					$timestamp = time();
					$date_time = date("H:i a", $timestamp); 
					@$t1 = $exp_time - $date_time;
		//Day and time left

					if($days == 0)
					{
						if($t1 > 0)
						{
							$timme_rimaning = "Time";
							$left_date = $t1." Hours";

						}
						else
						{
				//$timme_rimaning = "Days Left to Donate";
							$left_date = "EXPIRED";
						}

					}elseif($days == -1 || $days < -1)
					{
						$timme_rimaning = "Days Left to Donate";
						$left_date = "EXPIRED";
					}
					elseif($days > 0)
					{
						$timme_rimaning = "Days Left to Donate";
						$left_date = $days." Days";
					}
        //percentage amount calculate
					$amount_percentage = ($g_amt * 100) / $event_amt;

						//$amount_percentage = ($g_amt * 100) / $event_amt;
					$amount_percentage = round($amount_percentage, 1);

					?>
					<!-- loop data for show event info -->
					<div class="col-md-4 col-sm-4 show-all-fund fundraisers_listing_view">
						<div class="campaign-loop">
							<figure><a href="<?php echo get_permalink($post_id); ?>"><img src="<?php echo $feature_image_app; ?>"></a><?php $tax_deductible = get_post_meta( $post_id, 'tax_deductible', true ); 

							if($tax_deductible == true)
							{
								echo"<span class='tex_benefit'>"; echo "Tax Benefit";echo "</span>";
							}
							?></figure>
							<figcaption>
								<?php
								$tags = wp_get_object_terms($post_id, $taxonomy = 'fund_cate');
								echo "<div class='tag-after'><ul>";
								foreach ($tags as $key => $get_name)
								{
									echo "<li class='".$get_name->slug."'>"; echo $get_name->name; echo "</li>";
								}
								echo "</ul></div>"
								?>
								<h4><a href="<?php echo get_permalink($post_id); ?>"><?php echo ucfirst($shorttitle);  ?></a></h4>
								<span><?php echo wp_trim_words($content, '10', '..' ); ?></span>
								<p><strong>$<?php echo $g_amt; ?></strong>  of  <strong>$<?php echo $event_amt; ?></strong> Goal </p>
								<p>
									<?php
									$createdate = get_post_meta( $post_id, 'date_approvel', true );
									if($createdate)
									{
										?>
										<span class="all_fund_date_created">Date Created </span>  
										<?php   
										echo $date_create = date( "M d, Y", strtotime( $createdate )); 
									}
									?>
								</p>
								<p class="dontion-left"><?php
								if($count !=0) 
								{
									$date1 = time();
									$date2 = strtotime($last_donation);
									$diff = $date1 - $date2;
				//$years = floor($diff / (365*60*60*24));
				//$months = floor(($diff - $years * 365*60*60*24) / (30*60*60*24));
				//$days = floor(($diff - $years * 365*60*60*24 - $months*30*60*60*24)/ (60*60*24));
									$days = floor($diff / (60 * 60 * 24));
									$week = floor($days/7);
									$months = floor(($diff - $years * 365*60*60*24) / (30*60*60*24));
									$years = floor($diff / (365*60*60*24));
				//$week = floor($days/7);
									if($days == 1)
									{
										$s_days = "day";
									}
									else
									{
										$s_days = "days";
									}

									if($week == 1)
									{
										$s_week = "week";
									}
									else
									{
										$s_week = "weeks";
									}
									if($months == 1)
									{
										$s_month = "month";
									}
									else
									{
										$s_month = "months";
									}
									if($years ==  1)
									{
										$s_year = "year";
									}
									else
									{
										$s_year = "years";
									}
									if($days == 0 && $week == 0)
									{
										$show_date = "Last donation today";
									}

									else if(($days > 0 && $days <= 7 ) && $week == 0)
									{
										$show_date = "Last donation ". $days.' '. $s_days . " ago";
									}
									else if(($week > 0 && $week <= 4 ) && $months == 0)
									{
										$show_date = "Last donation ". $week.' '. $s_week . " ago";
									}

									else if(($months > 0 && $months <= 12 ) && $years == 0)
									{
										$show_date = "Last donation ". $months.' '. $s_month . " ago";
									}
									else
									{
										$show_date = "Last donation ". $years.' '. $s_year . " ago";
									}

									echo $show_date;
								}
								?></p>

								<div class="progress"><div class="progress-inside" style="width:<?php if($amount_percentage <= 100) { echo $amount_percentage; } else { echo 100; } ?>%"></div></div>
								<ul class="progress-list">
									<li><?php if($amount_percentage <= 100) { echo $amount_percentage; } else { echo 100; } ?>%
										<span>Funded</span></li>
										<li>$<?php echo number_format($g_amt);?>
											<span>Donated</span>
										</li>
										<li><?php echo $left_date; ?>
											<?php if($left_date != 'EXPIRED') { ?><span>Time Left</span><?php } else { ?>
											<span style="visibility: hidden;">Time Left</span><?php } ?>
										</li>
									</ul>

									<form method="post" action="<?php echo site_url()?>/raiseit-donate">
										<input type="hidden" name="raiseit_amt" value="<?php echo $event_amt;?>">
										<input type="hidden" name="retail_post_id" value="<?php echo $rtlr_id; ?>">
										<input type="hidden" name="retailer_author" value="<?php echo $rrr_author_id; ?>">
										<input type="hidden" name="fund_author_id" value="<?php echo $post_author_id; ?>">
										<input type="hidden" name="fund_name" value="<?php echo $trimtitle; ?>">
										<input type="hidden" name="event_auth_name" value="<?php echo $event_auth_name;?>">
										<input type="hidden" name="ff_id" value="<?php echo $post_id;  ?>">
										<input type="hidden" name="event_e_date" value="<?php echo $expire_date; ?>">
										<input type="submit" class="btn donation-fund-btn" name="direct_dontaion" value="Donate Now">
									</form>
									<div class="shareaholic-canvas" data-app="share_buttons" data-app-id-name="index_below_content"></div>
								</figcaption>
							</div>
						</div>

						<?php
					endwhile;
					wp_reset_query();
				}
				else
				{
					echo "<div class='alert alert-danger fs-error-fund fs-error-most-fund'><div class='row campaign-list'><span style='color:red;'>There are no any most funded campaigns available.</span></div></div>";
				}

				?>
				<div class="load-most-funded"></div>			
			</div>
			<div style="clear:both"></div>
			<div class="loader" style="display:none;text-align:center">								
				<img class="img-loader" src="<?php bloginfo('template_directory');?>/images/ajax-loader.gif">
			</div>

			<div class='alert alert-danger fs-error-fund fs-error-fund-part nomost-fund' style="display:none">
				<div class='row campaign-list'>
					<span style='color:red;'>No more most funded campaigns available.</span>
				</div>
			</div>

			<?php die(); 

		}


		/*********   window scroll load function    *******/

		function more_post_ajax(){	

			global $wpdb;
			$paged = (get_query_var('paged')) ? get_query_var('paged') : 1;

			$offset = $_POST["offset_p"];
			$ppp = $_POST["ppp"];
			header("Content-Type: text/html");

			$args = array( 'post_type' => 'retailer', 'posts_per_page' => $ppp,'offset' => $offset,'paged' => $paged,'post_status' =>'publish');

			$loop = new WP_Query($args);

			if($loop->have_posts()){
		//echo "gud job";die;
				while ($loop->have_posts()) : $loop->the_post(); 
       //the_content();
					$post_id =  get_the_ID();
					$trimtitle = get_the_title();				
					$shorttitle = wp_trim_words( $trimtitle, $num_words = 7, $more = '… ' );
					$content =  get_the_content();
					$feature_image_app = get_the_post_thumbnail_url($post_id);	
					$ret_address = get_field('bus_address',$post_id);
					$ret_city = get_field('r_city',$post_id);
					$ret_state = get_field('r_state',$post_id);
					$ret_zipcode = get_field('user_zip',$post_id);
					$ret_country = get_field('buis_country',$post_id);
					?>
					<div class="col-md-4 col-sm-4 fundraisers_listing_view">
						<div class="campaign-loop ret-listing">
							<figure><a href="<?php echo get_permalink($post_id); ?>">
								<?php if(isset($feature_image_app) && !empty($feature_image_app)) { ?>
								<img src="<?php echo $feature_image_app; ?>">
								<?php } else { ?>
								<img class="img-responsive" src="<?php bloginfo('template_directory');?>/images/images-thumb-coming-soon.png">
								<?php } ?>
							</a>
							<?php $unclaimed = get_post_meta( $post_id, 'import_status', true ); 
							if($unclaimed == 'unclaimed')
							{
								echo"<span class='tex_benefit'>"; echo "Unclaimed";echo "</span>";
							}
							?>
						</figure>
						<figcaption>
							<h4><a href="<?php echo get_permalink($post_id); ?>"><?php echo ucfirst($shorttitle);  ?></a></h4>
							<span><?php echo wp_trim_words($content, '7', '..' ); ?></span>

							<p><strong>Address : </strong><?php echo $ret_address ?></p>
							<p><?php echo $ret_city.', '.$ret_state.', '.$ret_zipcode ?></p>
							<p><?php echo $ret_country ?></p>
							
							<?php

							$get_post_query_1 = $wpdb->get_results("SELECT f_id FROM wp_post_relationships where r_id = $post_id AND f_end_date >= CURDATE() AND status= 1");

							$fund_post_count = count($get_post_query_1);
							if($fund_post_count != '' && $fund_post_count <= 4 )
							{
								echo "<span class='current-fund-title'>Our current fundraiser campaign</span>";
								echo "<div class='current-fund-img'>";
								echo "<ul>";
								foreach ($get_post_query_1 as $key_1 => $get_value_1)
								{
									$fund_post_id = $get_value_1->f_id;
									$fund_url = get_the_post_thumbnail_url($fund_post_id,'thumbnail');
									echo "<li><a target='_blank' href='".get_permalink($fund_post_id)."'><img src=".$fund_url."></a></li>";
								}
								echo "</ul></div>";
							}

							elseif($fund_post_count >= 4)
							{
								echo "<div class='hide-overloay-img'>";
								echo "<span class='current-fund-title'>Our current fundraiser campaign</span>";
								echo "<div class='current-fund-img'><ul class='owl-carousel owl-theme'>";
								foreach ($get_post_query_1 as $key_1 => $get_value_1)
								{
									$fund_post_id = $get_value_1->f_id;
									$fund_url = get_the_post_thumbnail_url($fund_post_id,'thumbnail');
									echo "<li class='item'><a target='_blank' href='".get_permalink($fund_post_id)."'><img src=".$fund_url."></a></li>";
								}
								echo "</ul></div></div>";
							}
							else
							{
									//echo "<p>No current fundraiser campaign.</p>";
							}
							?>
							<div class="shareaholic-canvas" data-app="share_buttons" data-app-id-name="index_below_content"></div>
						</figcaption>
					</div>
				</div>


				<?php 
			endwhile;  
			wp_reset_query();
		}
		else {
			echo "<div class='alert alert-danger fs-error-fund fs-error-fund-part'><div class='row campaign-list'><span style='color:red;'>There are no current campaigns available.</span></div></div>";
		}
		die();
	}

	add_action('wp_ajax_nopriv_more_post_ajax', 'more_post_ajax'); 
	add_action('wp_ajax_more_post_ajax', 'more_post_ajax');

	/*********** load more post by search name *******************/
	add_action('wp_ajax_nopriv_more_post_byname', 'more_post_byname'); 
	add_action('wp_ajax_more_post_byname', 'more_post_byname');

	function more_post_byname()
	{
		global $wpdb;
		global $paged; global $args;
		$paged = ( get_query_var( 'paged' ) ) ? get_query_var( 'paged' ) : 1;
		$args= null;

		$offset = $_POST["offset_p"];
		$ppp = $_POST["ppp"];
		header("Content-Type: text/html");

		if(isset($_POST['search_by']) && !empty($_POST['search_by']))
		{
			$ret_name = esc_sql($_POST['search_by']);
		}

		$args = array( 'post_type' => 'retailer', 's' => $ret_name, 'posts_per_page' => $ppp, 'offset' => $offset, 'post_status' =>'publish','paged' => $paged);


		$loop = new WP_Query( $args );


		?>
		<div class="row campaign-list">

			<?php

			if( $loop->have_posts())
			{
				while ( $loop->have_posts() ) : $loop->the_post();
					$post_id =  get_the_ID();
					$trimtitle = get_the_title();				
					$shorttitle = wp_trim_words( $trimtitle, $num_words = 7, $more = '… ' );
					$content =  get_the_content();

					$feature_image_app = get_the_post_thumbnail_url($post_id);

					$get_data = $wpdb->get_row("SELECT * FROM wp_post_relationships where r_id = $post_id");

					foreach ($get_data as $key => $rel_details) 
					{
						/*$llogo_url = $lo_url->retailer_logo;*/
						$rtlr_id = $rel_details->r_id;
						$post_author_id = $rel_details->f_auth_id;
						$event_auth_name = $rel_details->f_auth_name;
						$f_post_id = $rel_details->f_id;
						$rrr_author_id = $rel_details->rr_author_id;
						/*$donnor_id = $lo_url->donor_id ;*/
					}

					$ret_address = get_field('bus_address',$post_id);
					$ret_city = get_field('r_city',$post_id);
					$ret_state = get_field('r_state',$post_id);
					$ret_zipcode = get_field('user_zip',$post_id);
					$ret_country = get_field('buis_country',$post_id);

					?>
					<!-- loop data for show event info -->
					<div class="col-md-4 col-sm-4 show-all-ret-name fundraisers_listing_view">
						<div class="campaign-loop ret-listing">
							<figure><a href="<?php echo get_permalink($post_id); ?>"><img src="<?php echo $feature_image_app; ?>"></a>
								<?php $unclaimed = get_post_meta( $post_id, 'import_status', true ); 
								if($unclaimed == 'unclaimed')
								{
									echo"<span class='tex_benefit'>"; echo "Unclaimed";echo "</span>";
								}
								?>
							</figure>
							<figcaption>
								<h4><a href="<?php echo get_permalink($post_id); ?>"><?php echo ucfirst($shorttitle);  ?></a></h4>
								<span><?php echo wp_trim_words($content, '5', '..' ); ?></span>

								<p><?php echo 'Address : '.$ret_address ?></p>
								<p><?php echo $ret_city.', '.$ret_state.', '.$ret_zipcode ?></p>
								<p><?php echo $ret_country ?></p>

								<div class="shareaholic-canvas" data-app="share_buttons" data-app-id-name="index_below_content"></div>

							</figcaption>
						</div>
					</div>

					<?php
				endwhile;
				wp_reset_query();

				?>

			</div>



			<?php
		}

		else
		{
			echo "<div class='alert alert-danger fs-error-fund fs-error-fund-part'><div class='row campaign-list'><span style='color:red;'>There are no business sponsor available by this name.</span></div></div>";
		}

		die();

	}


	/*********** load more post by zip search *******************/
	add_action('wp_ajax_nopriv_more_post_byzip', 'more_post_byzip'); 
	add_action('wp_ajax_more_post_byzip', 'more_post_byzip');

	function more_post_byzip()
	{
		global $wpdb;
		global $paged; global $args;
		$paged = ( get_query_var( 'paged' ) ) ? get_query_var( 'paged' ) : 1;
		$args= null;

		$offset = $_POST["offset_p"];
		$ppp = $_POST["ppp"];
		header("Content-Type: text/html");

		if(isset($_POST['search_by']) && !empty($_POST['search_by']))
		{
			$ret_zipcode = esc_sql($_POST['search_by']);
		}


		$args = array( 'post_type' => 'retailer',  'posts_per_page' => $ppp, 'offset' => $offset, 'post_status' =>'publish','paged' => $paged, 'meta_query'=>
			array(

				array(
					'key' => 'user_zip',
					'value'  => $ret_zipcode,
					'compare' => 'LIKE'
				)));

		$loop = new WP_Query( $args );


		?>
		<div class="row campaign-list">

			<?php

			if( $loop->have_posts())
			{
				while ( $loop->have_posts() ) : $loop->the_post();
					$post_id =  get_the_ID();
					$trimtitle = get_the_title();				
					$shorttitle = wp_trim_words( $trimtitle, $num_words = 7, $more = '… ' );
					$content =  get_the_content();

					$feature_image_app = get_the_post_thumbnail_url($post_id);

					$get_data = $wpdb->get_row("SELECT * FROM wp_post_relationships where r_id = $post_id");

					foreach ($get_data as $key => $rel_details) 
					{
						/*$llogo_url = $lo_url->retailer_logo;*/
						$rtlr_id = $rel_details->r_id;
						$post_author_id = $rel_details->f_auth_id;
						$event_auth_name = $rel_details->f_auth_name;
						$f_post_id = $rel_details->f_id;
						$rrr_author_id = $rel_details->rr_author_id;
						/*$donnor_id = $lo_url->donor_id ;*/
					}

					$ret_address = get_field('bus_address',$post_id);
					$ret_city = get_field('r_city',$post_id);
					$ret_state = get_field('r_state',$post_id);
					$ret_zipcode = get_field('user_zip',$post_id);
					$ret_country = get_field('buis_country',$post_id);

					?>
					<!-- loop data for show event info -->
					<div class="col-md-4 col-sm-4 show-all-ret-zip fundraisers_listing_view">
						<div class="campaign-loop ret-listing">
							<figure><a href="<?php echo get_permalink($post_id); ?>"><img src="<?php echo $feature_image_app; ?>"></a>
								<?php $unclaimed = get_post_meta( $post_id, 'import_status', true ); 
								if($unclaimed == 'unclaimed')
								{
									echo"<span class='tex_benefit'>"; echo "Unclaimed";echo "</span>";
								}
								?>
							</figure>
							<figcaption>
								<h4><a href="<?php echo get_permalink($post_id); ?>"><?php echo ucfirst($shorttitle);  ?></a></h4>
								<span><?php echo wp_trim_words($content, '5', '..' ); ?></span>

								<p><?php echo 'Address : '.$ret_address ?></p>
								<p><?php echo $ret_city.', '.$ret_state.', '.$ret_zipcode ?></p>
								<p><?php echo $ret_country ?></p>

								<div class="shareaholic-canvas" data-app="share_buttons" data-app-id-name="index_below_content"></div>

							</figcaption>
						</div>
					</div>

					<?php
				endwhile;
				wp_reset_query();

				?>


				<?php
			}

			else
			{
				echo "<div class='alert alert-danger fs-error-fund fs-error-fund-part'><div class='row campaign-list'><span style='color:red;'>There are no business sponsor available by this name.</span></div></div>";
			} ?>
		</div>

		<?php 
		die();

	}


	/*********** load more post by search city*******************/
	add_action('wp_ajax_nopriv_more_post_bycity', 'more_post_bycity'); 
	add_action('wp_ajax_more_post_bycity', 'more_post_bycity');

	function more_post_bycity()
	{
		global $wpdb;
		global $paged; global $args;
		$paged = ( get_query_var( 'paged' ) ) ? get_query_var( 'paged' ) : 1;
		$args= null;

		$offset = $_POST["offset_p"];
		$ppp = $_POST["ppp"];
		header("Content-Type: text/html");

		if(isset($_POST['search_by']) && !empty($_POST['search_by']))
		{
			$ret_city = esc_sql($_POST['search_by']);
		}


		$args = array( 'post_type' => 'retailer',  'posts_per_page' => $ppp, 'offset' => $offset, 'post_status' =>'publish','paged' => $paged, 'meta_query'=>
			array(

				array(
					'key' => 'r_city',
					'value'  => $ret_city,
					'compare' => 'LIKE'
				)));

		$loop = new WP_Query( $args );


		?>
		<div class="row campaign-list">

			<?php

			if( $loop->have_posts())
			{
				while ( $loop->have_posts() ) : $loop->the_post();
					$post_id =  get_the_ID();
					$trimtitle = get_the_title();				
					$shorttitle = wp_trim_words( $trimtitle, $num_words = 7, $more = '… ' );
					$content =  get_the_content();

					$feature_image_app = get_the_post_thumbnail_url($post_id);

					$get_data = $wpdb->get_row("SELECT * FROM wp_post_relationships where r_id = $post_id");

					foreach ($get_data as $key => $rel_details) 
					{
						/*$llogo_url = $lo_url->retailer_logo;*/
						$rtlr_id = $rel_details->r_id;
						$post_author_id = $rel_details->f_auth_id;
						$event_auth_name = $rel_details->f_auth_name;
						$f_post_id = $rel_details->f_id;
						$rrr_author_id = $rel_details->rr_author_id;
						/*$donnor_id = $lo_url->donor_id ;*/
					}

					$ret_address = get_field('bus_address',$post_id);
					$ret_city = get_field('r_city',$post_id);
					$ret_state = get_field('r_state',$post_id);
					$ret_zipcode = get_field('user_zip',$post_id);
					$ret_country = get_field('buis_country',$post_id);

					?>
					<!-- loop data for show event info -->
					<div class="col-md-4 col-sm-4 show-all-ret-zip fundraisers_listing_view">
						<div class="campaign-loop ret-listing">
							<figure><a href="<?php echo get_permalink($post_id); ?>"><img src="<?php echo $feature_image_app; ?>"></a>
								<?php $unclaimed = get_post_meta( $post_id, 'import_status', true ); 
								if($unclaimed == 'unclaimed')
								{
									echo"<span class='tex_benefit'>"; echo "Unclaimed";echo "</span>";
								}
								?>
							</figure>
							<figcaption>
								<h4><a href="<?php echo get_permalink($post_id); ?>"><?php echo ucfirst($shorttitle);  ?></a></h4>
								<span><?php echo wp_trim_words($content, '5', '..' ); ?></span>

								<p><?php echo 'Address : '.$ret_address ?></p>
								<p><?php echo $ret_city.', '.$ret_state.', '.$ret_zipcode ?></p>
								<p><?php echo $ret_country ?></p>

								<div class="shareaholic-canvas" data-app="share_buttons" data-app-id-name="index_below_content"></div>

							</figcaption>
						</div>
					</div>

					<?php
				endwhile;
				wp_reset_query();

				?>


				<?php
			}

			else
			{
				echo "<div class='alert alert-danger fs-error-fund fs-error-fund-part'><div class='row campaign-list'><span style='color:red;'>There are no business sponsor available by this name.</span></div></div>";
			} ?>
		</div>

		<?php 
		die();

	}
	/*********   window scroll load function  all fundraiser  *******/
	add_action('wp_ajax_nopriv_more_post_allfundraiser', 'more_post_allfundraiser'); 
	add_action('wp_ajax_more_post_allfundraiser', 'more_post_allfundraiser');

	function more_post_allfundraiser(){	



		global $wpdb;
		$paged = (get_query_var('paged')) ? get_query_var('paged') : 1;

		$offset = $_POST["offset_p"];
		$ppp = $_POST["ppp"];
		header("Content-Type: text/html");

		$get_fund_data = $wpdb->get_results("SELECT f_id FROM wp_post_relationships where f_end_date >= CURDATE() AND status = 1");
		$count_fund = count($get_fund_data);
		foreach ($get_fund_data as $key_1 => $get_fund_id) 
		{
			$fud_arry_ids[] = $get_fund_id->f_id;
		}

		$args= null;
		$args = array( 'post_type' => 'fundraiser','posts_per_page' => $ppp,'offset' => $offset,'paged' => $paged, 'post__in' => $fud_arry_ids , 'post_status' =>'publish');
		$loop = new WP_Query( $args );

		if($count_fund != 0) {

			if( $loop->have_posts())
			{
				while ( $loop->have_posts() ) : $loop->the_post();

				//post id 
					$post_id =  get_the_ID();

					$trimtitle = get_the_title();				
					$shorttitle = wp_trim_words( $trimtitle, $num_words = 7, $more = '… ' );
					$content =  get_the_content();

					$r_id = $wpdb->get_results("SELECT * FROM wp_post_relationships where f_id = $post_id");

					foreach ($r_id as $key => $lo_url) 
					{
						$rtlr_id = $lo_url->r_id;
						$post_author_id = $lo_url->f_auth_id;
						$event_auth_name = $lo_url->f_auth_name;
						$f_post_id = $lo_url->f_id;
						$rrr_author_id = $lo_url->rr_author_id;
					}
					$feature_image_app = get_the_post_thumbnail_url($post_id);	
					$event_amount = get_field('amount',$post_id);
					$event_amt = str_replace( ',', '', $event_amount );		
				//sql query for get donated amount
					$dnt_amts = $wpdb->get_results("SELECT donation_amt,donation_time FROM wp_donation where fund_ent_id = ".$post_id." ");

					$count = count($dnt_amts);

					$amt_donation = array();
					$last_donation = array();
					foreach ($dnt_amts as $key => $get_donation) 
					{
						$amt_donation[] = $get_donation->donation_amt;
						$amts = str_replace(',', '', $amt_donation);
						$last_donation = $get_donation->donation_time;
					}
				//return print_r($amts);
					if($count != 0)
					{ 
						$g_amt = array_sum($amts);
					}
					else
					{ 
						$g_amt = "0";
					}
				// code for get the days and time left for an event	
					$current_date = date("Y/m/d");
					$expire_date  = get_post_meta( $post_id, 'event_expire_date', true);
					$exp_time = get_post_meta( $post_id, 'end_time', true);

				//difference between post date and current date
					$date_diff = strtotime($expire_date) - strtotime($current_date);

				//calculate the days left
					$days = floor(($date_diff - $years * 365*60*60*24 - $months*30*60*60*24)/ (60*60*24));

					$timestamp = time();
					$date_time = date("H:i a", $timestamp); 
					@$t1 = $exp_time - $date_time;

				//Day and time left
					if($days == 0)
					{
						if($t1 > 0){
							$timme_rimaning = "Time";
							$left_date = $t1." Hours";

						}else{
						//$timme_rimaning = "Days Left to Donate";
							$left_date = "EXPIRED";
						}

					}elseif($days == -1 || $days < -1)
					{
						$timme_rimaning = "Days Left to Donate";
						$left_date = "EXPIRED";
					}
					elseif($days > 0)
					{
						$timme_rimaning = "Days Left to Donate";
						$left_date = $days." Days";
					}
					$amount_percentage = ($g_amt * 100) / $event_amt;
					//$amount_percentage = ($g_amt * 100) / $event_amt;
					$amount_percentage = round($amount_percentage, 1);
					?>

					<div class="col-md-4 col-sm-4 fundraisers_listing_view">
						<div class="campaign-loop">
							<figure><a href="<?php echo get_permalink($post_id); ?>"><img src="<?php echo $feature_image_app; ?>"></a>
								<?php $tax_deductible = get_post_meta( $post_id, 'tax_deductible', true ); 

								if($tax_deductible == true)
								{
									echo"<span class='tex_benefit'>"; echo "Tax Benefit";echo "</span>";
								}
								?></figure>
								<figcaption>
									<?php
									$tags = wp_get_object_terms($post_id, $taxonomy = 'fund_cate');
									echo "<div class='tag-after'><ul>";
									foreach ($tags as $key => $get_name)
									{
										echo "<li class='".$get_name->slug."'>"; echo $get_name->name; echo "</li>";
									}
									echo "</ul></div>"
									?>
									<h4><a href="<?php echo get_permalink($post_id); ?>"><?php echo ucfirst($shorttitle);  ?></a></h4>
									<span><?php echo wp_trim_words($content, '10', '..' ); ?></span>
									<p><strong>$<?php echo $g_amt; ?></strong>  of  <strong>$<?php echo $event_amt; ?></strong> Goal </p>
									<p>
										<?php
										$createdate = get_post_meta( $post_id, 'date_approvel', true );
										if($createdate)
										{
											?>
											<span class="all_fund_date_created">Date Created </span>  
											<?php			
											echo $date_create = date( "M d, Y", strtotime( $createdate )); 
										}
										?>
									</p>
									<p class="dontion-left">
										<?php
										if($count !=0) 
										{
											$date1 = time();
											$date2 = strtotime($last_donation);
											$diff = $date1 - $date2;
				//$years = floor($diff / (365*60*60*24));
				//$months = floor(($diff - $years * 365*60*60*24) / (30*60*60*24));
				//$days = floor(($diff - $years * 365*60*60*24 - $months*30*60*60*24)/ (60*60*24));
											$days = floor($diff / (60 * 60 * 24));
											$week = floor($days/7);
											$months = floor(($diff - $years * 365*60*60*24) / (30*60*60*24));
											$years = floor($diff / (365*60*60*24));
				//$week = floor($days/7);
											if($days == 1)
											{
												$s_days = "day";
											}
											else
											{
												$s_days = "days";
											}

											if($week == 1)
											{
												$s_week = "week";
											}
											else
											{
												$s_week = "weeks";
											}
											if($months == 1)
											{
												$s_month = "month";
											}
											else
											{
												$s_month = "months";
											}
											if($years ==  1)
											{
												$s_year = "year";
											}
											else
											{
												$s_year = "years";
											}
											if($days == 0 && $week == 0)
											{
												$show_date = "Last donation today";
											}

											else if(($days > 0 && $days <= 7 ) && $week == 0)
											{
												$show_date = "Last donation ". $days.' '. $s_days . " ago";
											}
											else if(($week > 0 && $week <= 4 ) && $months == 0)
											{
												$show_date = "Last donation ". $week.' '. $s_week . " ago";
											}

											else if(($months > 0 && $months <= 12 ) && $years == 0)
											{
												$show_date = "Last donation ". $months.' '. $s_month . " ago";
											}
											else
											{
												$show_date = "Last donation ". $years.' '. $s_year . " ago";
											}

											echo $show_date;
										}
										?>
									</p>
									<div class="progress"><div class="progress-inside" style="width:<?php if($amount_percentage <= 100) { echo $amount_percentage; } else { echo 100; } ?>%"></div></div>
									<ul class="progress-list">
										<li><?php if($amount_percentage <= 100) { echo $amount_percentage; } else { echo 100; } ?>%
											<span>Funded</span></li>
											<li>$<?php echo number_format($g_amt);?>
												<span>Donated</span>
											</li>
											<li><?php echo $left_date; ?>
												<?php if($left_date != 'EXPIRED') { ?><span>Time Left</span><?php } else { ?>
												<span style="visibility: hidden;">Time Left</span><?php } ?>
											</li>
										</ul>
										<form method="post" action="<?php echo site_url()?>/raiseit-donate">
											<input type="hidden" name="raiseit_amt" value="<?php echo $event_amt;?>">
											<input type="hidden" name="retail_post_id" value="<?php echo $rtlr_id; ?>">
											<input type="hidden" name="retailer_author" value="<?php echo $rrr_author_id; ?>">
											<input type="hidden" name="fund_author_id" value="<?php echo $post_author_id; ?>">
											<input type="hidden" name="fund_name" value="<?php echo $trimtitle; ?>">
											<input type="hidden" name="event_auth_name" value="<?php echo $event_auth_name;?>">
											<input type="hidden" name="ff_id" value="<?php echo $post_id;  ?>">
											<input type="hidden" name="event_e_date" value="<?php echo $expire_date; ?>">
											<input type="submit" class="btn donation-fund-btn" name="direct_dontaion" value="Donate Now">
										</form>
										<?php echo do_shortcode ('[shareaholic app="share_buttons" id_name="index_below_content"]'); ?></div>
									</figcaption>
								</div>
							</div>
							<?php

						endwhile;
						wp_reset_query();
					}
				}
				else {
					echo "<div class='alert alert-danger fs-error-fund fs-error-fund-part'><div class='row campaign-list'><span style='color:red;'>There are no current campaigns available.</span></div></div>";
				}

				die();
			}

			add_action('wp_ajax_nopriv_more_post_pastfundraiser', 'more_post_pastfundraiser'); 
			add_action('wp_ajax_more_post_pastfundraiser', 'more_post_pastfundraiser');

			function more_post_pastfundraiser(){	



				global $wpdb;
				$paged = (get_query_var('paged')) ? get_query_var('paged') : 1;

				$offset = $_POST["offset_p"];
				$ppp = $_POST["ppp"];
				header("Content-Type: text/html");

				$get_fund_data = $wpdb->get_results("SELECT f_id FROM wp_post_relationships where f_end_date < CURDATE() AND status = 1");
				$count_fund = count($get_fund_data);
				foreach ($get_fund_data as $key_1 => $get_fund_id) 
				{
					$fud_arry_ids[] = $get_fund_id->f_id;
				}

				$args= null;
				$args = array( 'post_type' => 'fundraiser','posts_per_page' => $ppp,'offset' => $offset,'paged' => $paged, 'post__in' => $fud_arry_ids , 'post_status' =>'publish');
				$loop = new WP_Query( $args );

				if($count_fund != 0) {



					if( $loop->have_posts())
					{
						while ( $loop->have_posts() ) : $loop->the_post();

						//post id 
							$post_id =  get_the_ID();

							$trimtitle = get_the_title();				
							$shorttitle = wp_trim_words( $trimtitle, $num_words = 7, $more = '… ' );
							$content =  get_the_content();

							$r_id = $wpdb->get_results("SELECT * FROM wp_post_relationships where f_id = $post_id");

							foreach ($r_id as $key => $lo_url) 
							{
								$rtlr_id = $lo_url->r_id;
								$post_author_id = $lo_url->f_auth_id;
								$event_auth_name = $lo_url->f_auth_name;
								$f_post_id = $lo_url->f_id;
								$rrr_author_id = $lo_url->rr_author_id;
							}
							$feature_image_app = get_the_post_thumbnail_url($post_id);	
							$event_amount = get_field('amount',$post_id);
							$event_amt = str_replace( ',', '', $event_amount );		
						//sql query for get donated amount
							$dnt_amts = $wpdb->get_results("SELECT donation_amt,donation_time FROM wp_donation where fund_ent_id = ".$post_id." ");

							$count = count($dnt_amts);

							$amt_donation = array();
							$last_donation = array();
							foreach ($dnt_amts as $key => $get_donation) 
							{
								$amt_donation[] = $get_donation->donation_amt;
								$amts = str_replace(',', '', $amt_donation);
								$last_donation = $get_donation->donation_time;
							}
						//return print_r($amts);
							if($count != 0)
							{ 
								$g_amt = array_sum($amts);
							}
							else
							{ 
								$g_amt = "0";
							}
						// code for get the days and time left for an event	
							$current_date = date("Y/m/d");
							$expire_date  = get_post_meta( $post_id, 'event_expire_date', true);
							$exp_time = get_post_meta( $post_id, 'end_time', true);

						//difference between post date and current date
							$date_diff = strtotime($expire_date) - strtotime($current_date);

						//calculate the days left
							$days = floor(($date_diff - $years * 365*60*60*24 - $months*30*60*60*24)/ (60*60*24));

							$timestamp = time();
							$date_time = date("H:i a", $timestamp); 
							@$t1 = $exp_time - $date_time;

						//Day and time left
							if($days == 0)
							{
								if($t1 > 0){
									$timme_rimaning = "Time";
									$left_date = $t1." Hours";

								}else{
						//$timme_rimaning = "Days Left to Donate";
									$left_date = "EXPIRED";
								}

							}elseif($days == -1 || $days < -1)
							{
								$timme_rimaning = "Days Left to Donate";
								$left_date = "EXPIRED";
							}
							elseif($days > 0)
							{
								$timme_rimaning = "Days Left to Donate";
								$left_date = $days." Days";
							}
							$amount_percentage = ($g_amt * 100) / $event_amt;
						//$amount_percentage = ($g_amt * 100) / $event_amt;
							$amount_percentage = round($amount_percentage, 1);
							?>

							<div class="col-md-4 col-sm-4 fundraisers_listing_view">
								<div class="campaign-loop">
									<figure><a href="<?php echo get_permalink($post_id); ?>"><img src="<?php echo $feature_image_app; ?>"></a>
										<?php $tax_deductible = get_post_meta( $post_id, 'tax_deductible', true ); 

										if($tax_deductible == true)
										{
											echo"<span class='tex_benefit'>"; echo "Tax Benefit";echo "</span>";
										}
										?></figure>
										<figcaption>
											<?php
											$tags = wp_get_object_terms($post_id, $taxonomy = 'fund_cate');
											echo "<div class='tag-after'><ul>";
											foreach ($tags as $key => $get_name)
											{
												echo "<li class='".$get_name->slug."'>"; echo $get_name->name; echo "</li>";
											}
											echo "</ul></div>"
											?>
											<h4><a href="<?php echo get_permalink($post_id); ?>"><?php echo ucfirst($shorttitle);  ?></a></h4>
											<span><?php echo wp_trim_words($content, '10', '..' ); ?></span>
											<p><strong>$<?php echo $g_amt; ?></strong>  of  <strong>$<?php echo $event_amt; ?></strong> Goal </p>
											<p>
												<?php
												$createdate = get_post_meta( $post_id, 'date_approvel', true );
												if($createdate)
												{
													?>
													<span class="all_fund_date_created">Date Created </span>  
													<?php			
													echo $date_create = date( "M d, Y", strtotime( $createdate )); 
												}
												?>
											</p>
											<p class="dontion-left">
												<?php
												if($count !=0) 
												{
													$date1 = time();
													$date2 = strtotime($last_donation);
													$diff = $date1 - $date2;
				//$years = floor($diff / (365*60*60*24));
				//$months = floor(($diff - $years * 365*60*60*24) / (30*60*60*24));
				//$days = floor(($diff - $years * 365*60*60*24 - $months*30*60*60*24)/ (60*60*24));
													$days = floor($diff / (60 * 60 * 24));
													$week = floor($days/7);
													$months = floor(($diff - $years * 365*60*60*24) / (30*60*60*24));
													$years = floor($diff / (365*60*60*24));
				//$week = floor($days/7);
													if($days == 1)
													{
														$s_days = "day";
													}
													else
													{
														$s_days = "days";
													}

													if($week == 1)
													{
														$s_week = "week";
													}
													else
													{
														$s_week = "weeks";
													}
													if($months == 1)
													{
														$s_month = "month";
													}
													else
													{
														$s_month = "months";
													}
													if($years ==  1)
													{
														$s_year = "year";
													}
													else
													{
														$s_year = "years";
													}
													if($days == 0 && $week == 0)
													{
														$show_date = "Last donation today";
													}

													else if(($days > 0 && $days <= 7 ) && $week == 0)
													{
														$show_date = "Last donation ". $days.' '. $s_days . " ago";
													}
													else if(($week > 0 && $week <= 4 ) && $months == 0)
													{
														$show_date = "Last donation ". $week.' '. $s_week . " ago";
													}

													else if(($months > 0 && $months <= 12 ) && $years == 0)
													{
														$show_date = "Last donation ". $months.' '. $s_month . " ago";
													}
													else
													{
														$show_date = "Last donation ". $years.' '. $s_year . " ago";
													}

													echo $show_date;
												}
												?>
											</p>
											<div class="progress"><div class="progress-inside" style="width:<?php if($amount_percentage <= 100) { echo $amount_percentage; } else { echo 100; } ?>%"></div></div>
											<ul class="progress-list">
												<li><?php if($amount_percentage <= 100) { echo $amount_percentage; } else { echo 100; } ?>%
													<span>Funded</span></li>
													<li>$<?php echo number_format($g_amt);?>
														<span>Donated</span>
													</li>
													<li><?php echo $left_date; ?>
														<?php if($left_date != 'EXPIRED') { ?><span>Time Left</span><?php } else { ?>
														<span style="visibility: hidden;">Time Left</span><?php } ?>
													</li>
												</ul>
												<form method="post" action="<?php echo site_url()?>/raiseit-donate">
													<input type="hidden" name="raiseit_amt" value="<?php echo $event_amt;?>">
													<input type="hidden" name="retail_post_id" value="<?php echo $rtlr_id; ?>">
													<input type="hidden" name="retailer_author" value="<?php echo $rrr_author_id; ?>">
													<input type="hidden" name="fund_author_id" value="<?php echo $post_author_id; ?>">
													<input type="hidden" name="fund_name" value="<?php echo $trimtitle; ?>">
													<input type="hidden" name="event_auth_name" value="<?php echo $event_auth_name;?>">
													<input type="hidden" name="ff_id" value="<?php echo $post_id;  ?>">
													<input type="hidden" name="event_e_date" value="<?php echo $expire_date; ?>">
													<input type="submit" class="btn donation-fund-btn" name="direct_dontaion" value="Donate Now">
												</form>
												<?php echo do_shortcode ('[shareaholic app="share_buttons" id_name="index_below_content"]'); ?>
											</figcaption>
										</div>
									</div>
									<?php

								endwhile;
								wp_reset_query();
							}
						}
						else {
							echo "<div class='alert alert-danger fs-error-fund fs-error-fund-part'><div class='row campaign-list'><span style='color:red;'>There are no current campaigns available.</span></div></div>";
						}

						die();
					}


					/*********** load more post by search name *******************/
					add_action('wp_ajax_nopriv_fund_post_byname', 'fund_post_byname'); 
					add_action('wp_ajax_fund_post_byname', 'fund_post_byname');

					function fund_post_byname()
					{
						global $wpdb;
						global $paged; global $args;
						$paged = (get_query_var('paged')) ? get_query_var('paged') : 1;

						$offset = $_POST["offset_p"];
						$ppp = $_POST["ppp"];
						header("Content-Type: text/html");

						if(isset($_POST['search_by']) && !empty($_POST['search_by']))
						{
							$fund_name = esc_sql($_POST['search_by']);
						}

						$args = array( 'post_type' => 'fundraiser', 's' => $fund_name, 'posts_per_page' => $ppp,'offset' => $offset,'post_status' =>'publish','paged' => $paged);
						$loop = new WP_Query( $args );

						?>

						<?php
						if( $loop->have_posts())
						{
							while ( $loop->have_posts() ) : $loop->the_post();
								$post_id =  get_the_ID();
								$trimtitle = get_the_title();				
								$shorttitle = wp_trim_words( $trimtitle, $num_words = 7, $more = '… ' );
								$content =  get_the_content();
								$event_amount = get_field('amount',$post_id);

								$event_amt = str_replace( ',', '', $event_amount );



								$feature_image_app = get_the_post_thumbnail_url($post_id);

								$r_id = $wpdb->get_results("SELECT * FROM wp_post_relationships where f_id = $post_id");

								foreach ($r_id as $key => $lo_url) 
								{
									$rtlr_id = $lo_url->r_id;
									$post_author_id = $lo_url->f_auth_id;
									$event_auth_name = $lo_url->f_auth_name;
									$f_post_id = $lo_url->f_id;
									$rrr_author_id = $lo_url->rr_author_id;
								} 

								$dnt_amts = $wpdb->get_results("SELECT donation_amt,donation_time FROM wp_donation where fund_ent_id = ".$post_id." ");

								$count = count($dnt_amts);

								$amt_donation = array();
								$last_donation = array();
								foreach ($dnt_amts as $key => $get_donation) 
								{
									$amt_donation[] = $get_donation->donation_amt;
									$amts = str_replace(',', '', $amt_donation);
									$last_donation = $get_donation->donation_time;
								}
								if($count != 0)
								{  
									$g_amt = @array_sum($amts);
								}
								else
								{
									$g_amt = "0";
								}

		// code for get the days and time left for an event	
								$current_date = date("Y/m/d");
								$expire_date  = get_post_meta( $post_id, 'event_expire_date', true);
								$exp_time = get_post_meta( $post_id, 'end_time', true);
	    //difference between post date and current date
								$date_diff = strtotime($expire_date) - strtotime($current_date);
        //calculate the days left
								$days = floor(($date_diff - $years * 365*60*60*24 - $months*30*60*60*24)/ (60*60*24));
								$timestamp = time();
								$date_time = date("H:i a", $timestamp); 
								@$t1 = $exp_time - $date_time;
		//Day and time left

								if($days == 0)
								{
									if($t1 > 0)
									{
										$timme_rimaning = "Time";
										$left_date = $t1." Hours";

									}
									else
									{
				//$timme_rimaning = "Days Left to Donate";
										$left_date = "EXPIRED";
									}

								}elseif($days == -1 || $days < -1)
								{
									$timme_rimaning = "Days Left to Donate";
									$left_date = "EXPIRED";
								}
								elseif($days > 0)
								{
									$timme_rimaning = "Days Left to Donate";
									$left_date = $days." Days";
								}
        //percentage amount calculate
								$amount_percentage = ($g_amt * 100) / $event_amt;

					//$amount_percentage = ($g_amt * 100) / $event_amt;
								$amount_percentage = round($amount_percentage, 1);

								?>
								<!-- loop data for show event info -->
								<div class="col-md-4 col-sm-4 show-all-name fundraisers_listing_view">
									<div class="campaign-loop">
										<figure><a href="<?php echo get_permalink($post_id); ?>"><img src="<?php echo $feature_image_app; ?>"></a><?php $tax_deductible = get_post_meta( $post_id, 'tax_deductible', true ); 

										if($tax_deductible == true)
										{
											echo"<span class='tex_benefit'>"; echo "Tax Benefit";echo "</span>";
										}
										?></figure>
										<figcaption>
											<?php
											$tags = wp_get_object_terms($post_id, $taxonomy = 'fund_cate');
											echo "<div class='tag-after'><ul>";
											foreach ($tags as $key => $get_name)
											{
												echo "<li class='".$get_name->slug."'>"; echo $get_name->name; echo "</li>";
											}
											echo "</ul></div>"
											?>
											<h4><a href="<?php echo get_permalink($post_id); ?>"><?php echo ucfirst($shorttitle);  ?></a></h4>
											<span><?php echo wp_trim_words($content, '5', '..' ); ?></span>
											<p><strong>$<?php echo $g_amt; ?></strong>  of  <strong>$<?php echo $event_amt; ?></strong> Goal </p>
											<p>
												<?php
												$createdate = get_post_meta( $post_id, 'date_approvel', true );
												if($createdate)
												{
													?>
													<span class="all_fund_date_created">Date Created </span>  
													<?php   
													echo $date_create = date( "M d, Y", strtotime( $createdate )); 
												}
												?>
											</p>
											<p class="dontion-left"><?php
											if($count !=0) 
											{
												$date1 = time();
												$date2 = strtotime($last_donation);
												$diff = $date1 - $date2;
				//$years = floor($diff / (365*60*60*24));
				//$months = floor(($diff - $years * 365*60*60*24) / (30*60*60*24));
				//$days = floor(($diff - $years * 365*60*60*24 - $months*30*60*60*24)/ (60*60*24));
												$days = floor($diff / (60 * 60 * 24));
												$week = floor($days/7);
												$months = floor(($diff - $years * 365*60*60*24) / (30*60*60*24));
												$years = floor($diff / (365*60*60*24));
				//$week = floor($days/7);
												if($days == 1)
												{
													$s_days = "day";
												}
												else
												{
													$s_days = "days";
												}

												if($week == 1)
												{
													$s_week = "week";
												}
												else
												{
													$s_week = "weeks";
												}
												if($months == 1)
												{
													$s_month = "month";
												}
												else
												{
													$s_month = "months";
												}
												if($years ==  1)
												{
													$s_year = "year";
												}
												else
												{
													$s_year = "years";
												}
												if($days == 0 && $week == 0)
												{
													$show_date = "Last donation today";
												}

												else if(($days > 0 && $days <= 7 ) && $week == 0)
												{
													$show_date = "Last donation ". $days.' '. $s_days . " ago";
												}
												else if(($week > 0 && $week <= 4 ) && $months == 0)
												{
													$show_date = "Last donation ". $week.' '. $s_week . " ago";
												}

												else if(($months > 0 && $months <= 12 ) && $years == 0)
												{
													$show_date = "Last donation ". $months.' '. $s_month . " ago";
												}
												else
												{
													$show_date = "Last donation ". $years.' '. $s_year . " ago";
												}

												echo $show_date;
											}
											?></p>
											<div class="progress"><div class="progress-inside" style="width:<?php if($amount_percentage <= 100) { echo $amount_percentage; } else { echo 100; } ?>%"></div></div>
											<ul class="progress-list">
												<li><?php if($amount_percentage <= 100) { echo $amount_percentage; } else { echo 100; } ?>%
													<span>Funded</span></li>
													<li>$<?php echo number_format($g_amt);?>
														<span>Donated</span>
													</li>
													<li><?php echo $left_date; ?>
														<?php if($left_date != 'EXPIRED') { ?><span>Time Left</span><?php } else { ?>
														<span style="visibility: hidden;">Time Left</span><?php } ?>
													</li>
												</ul>

												<form method="post" action="<?php echo site_url()?>/raiseit-donate">
													<input type="hidden" name="raiseit_amt" value="<?php echo $event_amt;?>">
													<input type="hidden" name="retail_post_id" value="<?php echo $rtlr_id; ?>">
													<input type="hidden" name="retailer_author" value="<?php echo $rrr_author_id; ?>">
													<input type="hidden" name="fund_author_id" value="<?php echo $post_author_id; ?>">
													<input type="hidden" name="fund_name" value="<?php echo $trimtitle; ?>">
													<input type="hidden" name="event_auth_name" value="<?php echo $event_auth_name;?>">
													<input type="hidden" name="ff_id" value="<?php echo $post_id;  ?>">
													<input type="hidden" name="event_e_date" value="<?php echo $expire_date; ?>">
													<input type="submit" class="btn donation-fund-btn" name="direct_donation" value="Donate Now">
												</form>
												<?php echo do_shortcode ('[shareaholic app="share_buttons" id_name="index_below_content"]'); ?>

											</figcaption>
										</div>
									</div>

									<?php
								endwhile;
								wp_reset_query();

								?>

								<?php
							}

							else
							{
								echo "<div class='alert alert-danger fs-error-fund fs-error-fund-part'><div class='row campaign-list'><span style='color:red;'>There are no campaigns available by this name.</span></div></div>";
							}

							die();

						}

						/*********** load more fund by cate *******************/
						add_action('wp_ajax_nopriv_fund_post_bycate', 'fund_post_bycate'); 
						add_action('wp_ajax_fund_post_bycate', 'fund_post_bycate');

						function fund_post_bycate()
						{
							global $wpdb;
							global $paged; global $args;
							$paged = (get_query_var('paged')) ? get_query_var('paged') : 1;

							$offset = $_POST["offset_p"];
							$ppp = $_POST["ppp"];
							header("Content-Type: text/html");

							if(isset($_POST['search_by']) && !empty($_POST['search_by']))
							{
								$fund_cate = esc_sql($_POST['search_by']);
							}


							$args =array(
								'post_type' => 'fundraiser',
								'posts_per_page' => $ppp, 
								'offset' => $offset, 
								'post_status' =>'publish',
								'paged' => $paged,
								'tax_query' => array(
									array(
										'taxonomy' => 'fund_cate',
            'field' => 'term_id', //can be set to ID
            'terms' => $fund_cate //if field is ID you can reference by cat/term number
        )
								)
							);


							$loop = new WP_Query( $args );

							?>

							<?php
							if( $loop->have_posts())
							{
								while ( $loop->have_posts() ) : $loop->the_post();
									$post_id =  get_the_ID();
									$trimtitle = get_the_title();				
									$shorttitle = wp_trim_words( $trimtitle, $num_words = 7, $more = '… ' );
									$content =  get_the_content();
									/*	$event_amt = get_field('amount', $post_id);*/
									$event_amount = get_field('amount',$post_id);
									$event_amt = str_replace( ',', '', $event_amount );
									$feature_image_app = get_the_post_thumbnail_url($post_id); 

									$r_id = $wpdb->get_results("SELECT * FROM wp_post_relationships where f_id = $post_id");

									foreach ($r_id as $key => $lo_url) 
									{
										/*$llogo_url = $lo_url->retailer_logo;*/
										$rtlr_id = $lo_url->r_id;
										$post_author_id = $lo_url->f_auth_id;
										$event_auth_name = $lo_url->f_auth_name;
										$f_post_id = $lo_url->f_id;
										$rrr_author_id = $lo_url->rr_author_id;
										/*$donnor_id = $lo_url->donor_id ;*/
									}

									$dnt_amts = $wpdb->get_results("SELECT donation_amt,donation_time FROM wp_donation where fund_ent_id = ".$post_id." ");
									$count = count($dnt_amts);

									$amt_donation = array();
									$last_donation = array();
									foreach ($dnt_amts as $key => $get_donation) 
									{
										$amt_donation[] = $get_donation->donation_amt;
										$amts = str_replace(',', '', $amt_donation);
										$last_donation = $get_donation->donation_time;
									}
									if($count != 0)
									{  
										$g_amt = @array_sum($amts);
									}
									else
									{
										$g_amt = "0";
									}

		// code for get the days and time left for an event	
									$current_date = date("Y/m/d");
									$expire_date  = get_post_meta( $post_id, 'event_expire_date', true);
									$exp_time = get_post_meta( $post_id, 'end_time', true);
	    //difference between post date and current date
									$date_diff = strtotime($expire_date) - strtotime($current_date);
        //calculate the days left
									$days = floor(($date_diff - $years * 365*60*60*24 - $months*30*60*60*24)/ (60*60*24));
									$timestamp = time();
									$date_time = date("H:i a", $timestamp); 
									@$t1 = $exp_time - $date_time;
		//Day and time left

									if($days == 0)
									{
										if($t1 > 0)
										{
											$timme_rimaning = "Time";
											$left_date = $t1." Hours";

										}
										else
										{
				//$timme_rimaning = "Days Left to Donate";
											$left_date = "EXPIRED";
										}

									}elseif($days == -1 || $days < -1)
									{
										$timme_rimaning = "Days Left to Donate";
										$left_date = "EXPIRED";
									}
									elseif($days > 0)
									{
										$timme_rimaning = "Days Left to Donate";
										$left_date = $days." Days";
									}
        //percentage amount calculate
									$amount_percentage = ($g_amt * 100) / $event_amt;

				//$amount_percentage = ($g_amt * 100) / $event_amt;
									$amount_percentage = round($amount_percentage, 1);

									?>
									<!-- loop data for show event info -->
									<div class="col-md-4 col-sm-4 fundraisers_listing_view">
										<div class="campaign-loop">
											<figure><a href="<?php echo get_permalink($post_id); ?>"><img src="<?php echo $feature_image_app; ?>"><?php $tax_deductible = get_post_meta( $post_id, 'tax_deductible', true ); 

											if($tax_deductible == true)
											{
												echo"<span class='tex_benefit'>"; echo "Tax Benefit";echo "</span>";
											}
											?></a></figure>
											<figcaption>
												<?php
												$tags = wp_get_object_terms($post_id, $taxonomy = 'fund_cate');
												echo "<div class='tag-after'><ul>";
												foreach ($tags as $key => $get_name)
												{
													echo "<li class='".$get_name->slug."'>"; echo $get_name->name; echo "</li>";
												}
												echo "</ul></div>"
												?>
												<h4><a href="<?php echo get_permalink($post_id); ?>"><?php echo ucfirst($shorttitle);  ?></a></h4>
												<span><?php echo wp_trim_words($content, '5', '..' ); ?></span>
												<p><strong>$<?php echo $g_amt; ?></strong>  of  <strong>$<?php echo $event_amt; ?></strong> Goal </p>
												<p>
													<?php
													$createdate = get_post_meta( $post_id, 'date_approvel', true );
													if($createdate)
													{
														?>
														<span class="all_fund_date_created">Date Created </span>  
														<?php   
														echo $date_create = date( "M d, Y", strtotime( $createdate )); 
													}
													?>
												</p>
												<p class="dontion-left"><?php
												if($count !=0) 
												{
													$date1 = time();
													$date2 = strtotime($last_donation);
													$diff = $date1 - $date2;
				//$years = floor($diff / (365*60*60*24));
				//$months = floor(($diff - $years * 365*60*60*24) / (30*60*60*24));
				//$days = floor(($diff - $years * 365*60*60*24 - $months*30*60*60*24)/ (60*60*24));
													$days = floor($diff / (60 * 60 * 24));
													$week = floor($days/7);
													$months = floor(($diff - $years * 365*60*60*24) / (30*60*60*24));
													$years = floor($diff / (365*60*60*24));
				//$week = floor($days/7);
													if($days == 1)
													{
														$s_days = "day";
													}
													else
													{
														$s_days = "days";
													}

													if($week == 1)
													{
														$s_week = "week";
													}
													else
													{
														$s_week = "weeks";
													}
													if($months == 1)
													{
														$s_month = "month";
													}
													else
													{
														$s_month = "months";
													}
													if($years ==  1)
													{
														$s_year = "year";
													}
													else
													{
														$s_year = "years";
													}
													if($days == 0 && $week == 0)
													{
														$show_date = "Last donation today";
													}

													else if(($days > 0 && $days <= 7 ) && $week == 0)
													{
														$show_date = "Last donation ". $days.' '. $s_days . " ago";
													}
													else if(($week > 0 && $week <= 4 ) && $months == 0)
													{
														$show_date = "Last donation ". $week.' '. $s_week . " ago";
													}

													else if(($months > 0 && $months <= 12 ) && $years == 0)
													{
														$show_date = "Last donation ". $months.' '. $s_month . " ago";
													}
													else
													{
														$show_date = "Last donation ". $years.' '. $s_year . " ago";
													}

													echo $show_date;
												}
												?></p>		
												<div class="progress"><div class="progress-inside" style="width:<?php if($amount_percentage <= 100) { echo $amount_percentage; } else { echo 100; } ?>%"></div></div>
												<ul class="progress-list">
													<li><?php if($amount_percentage <= 100) { echo $amount_percentage; } else { echo 100; } ?>%
														<span>Funded</span></li>
														<li>$<?php echo number_format($g_amt);?>
															<span>Donated</span>
														</li>
														<li><?php echo $left_date; ?>
															<?php if($left_date != 'EXPIRED') { ?><span>Time Left</span><?php } else { ?>
															<span style="visibility: hidden;">Time Left</span><?php } ?>
														</li>
													</ul>

													<form method="post" action="<?php echo site_url()?>/raiseit-donate">
														<input type="hidden" name="raiseit_amt" value="<?php echo $event_amt;?>">
														<input type="hidden" name="retail_post_id" value="<?php echo $rtlr_id; ?>">
														<input type="hidden" name="retailer_author" value="<?php echo $rrr_author_id; ?>">
														<input type="hidden" name="fund_author_id" value="<?php echo $post_author_id; ?>">
														<input type="hidden" name="fund_name" value="<?php echo $trimtitle; ?>">
														<input type="hidden" name="event_auth_name" value="<?php echo $event_auth_name;?>">
														<input type="hidden" name="ff_id" value="<?php echo $post_id;  ?>">
														<input type="hidden" name="event_e_date" value="<?php echo $expire_date; ?>">
														<input type="submit" class="btn donation-fund-btn" name="direct_dontaion" value="Donate Now">
													</form>
													<?php echo do_shortcode ('[shareaholic app="share_buttons" id_name="index_below_content"]'); ?>

												</figcaption>
											</div>
										</div>

										<?php
									endwhile;
									wp_reset_query();

									?>

									<?php
								}

								else
								{
									echo "<div class='alert alert-danger fs-error-fund fs-error-fund-cat'><div class='row campaign-list'><span style='color:red;'>There are no campaigns available by this name.</span></div></div>";
								}

								die();

							}


							/*********** load more fund by zip *******************/
							add_action('wp_ajax_nopriv_fund_post_byzip', 'fund_post_byzip'); 
							add_action('wp_ajax_fund_post_byzip', 'fund_post_byzip');

							function fund_post_byzip()
							{
								global $wpdb;
								global $paged; global $args;
								$paged = (get_query_var('paged')) ? get_query_var('paged') : 1;

								$offset = $_POST["offset_p"];
								$ppp = $_POST["ppp"];
								header("Content-Type: text/html");

								if(isset($_POST['search_by']) && !empty($_POST['search_by']))
								{
									$reat_id = esc_sql($_POST['search_by']);
								}	

								$args = array(
									'post_type' => 'fundraiser',
									'post_status' =>'publish',
									'posts_per_page' => $ppp,
									'offset' => $offset,
									'paged' => $paged,
									'meta_query' => array(
										'relation' => 'OR',
										array(
											'key' => 'fund_city',
											'value' => sanitize_text_field( $reat_id ),
											'compare' => 'LIKE'
										),
										array(
											'key' => 'fund_zip',
											'value' => sanitize_text_field( $reat_id ),
											'compare' => 'LIKE'
										)
									)
								);
								$loop = new WP_Query($args);

								?>

								<?php
								if( $loop->have_posts())
								{
									while ( $loop->have_posts() ) : $loop->the_post();
										$post_id =  get_the_ID();
										$trimtitle = get_the_title();				
										$shorttitle = wp_trim_words( $trimtitle, $num_words = 7, $more = '… ' );
										$content =  get_the_content();
										$event_amount = get_field('amount',$post_id);

										$event_amt = str_replace( ',', '', $event_amount );
										$feature_image_app = get_the_post_thumbnail_url($post_id);

										$r_id = $wpdb->get_results("SELECT * FROM wp_post_relationships where f_id = $post_id");

										foreach ($r_id as $key => $lo_url) 
										{
											$rtlr_id = $lo_url->r_id;
											$post_author_id = $lo_url->f_auth_id;
											$event_auth_name = $lo_url->f_auth_name;
											$f_post_id = $lo_url->f_id;
											$rrr_author_id = $lo_url->rr_author_id;
										} 
										$dnt_amts = $wpdb->get_results("SELECT donation_amt,donation_time FROM wp_donation where fund_ent_id = ".$post_id." ");
										$count = count($dnt_amts);
										$amt_donation = array();
										$last_donation = array();
										foreach ($dnt_amts as $key => $get_donation) 
										{
											$amt_donation[] = $get_donation->donation_amt;
											$amts = str_replace(',', '', $amt_donation);
											$last_donation = $get_donation->donation_time;
										}
										if($count != 0)
										{  
											$g_amt = @array_sum($amts);
										}
										else
										{
											$g_amt = "0";
										}
										$current_date = date("Y/m/d");
										$expire_date  = get_post_meta( $post_id, 'event_expire_date', true);
										$exp_time = get_post_meta( $post_id, 'end_time', true);
										$date_diff = strtotime($expire_date) - strtotime($current_date);
										$days = floor(($date_diff - $years * 365*60*60*24 - $months*30*60*60*24)/ (60*60*24));
										$timestamp = time();
										$date_time = date("H:i a", $timestamp); 
										@$t1 = $exp_time - $date_time;

										if($days == 0)
										{
											if($t1 > 0)
											{
												$timme_rimaning = "Time";
												$left_date = $t1." Hours";

											}
											else
											{
				//$timme_rimaning = "Days Left to Donate";
												$left_date = "EXPIRED";
											}

										}

										elseif($days == -1 || $days < -1)
										{
											$timme_rimaning = "Days Left to Donate";
											$left_date = "EXPIRED";
										}
										elseif($days > 0)
										{
											$timme_rimaning = "Days Left to Donate";
											$left_date = $days." Days";
										}
										$amount_percentage = ($g_amt * 100) / $event_amt;
										$amount_percentage = round($amount_percentage, 1);
										?>
										<div class="col-md-4 col-sm-4 show-all-location fundraisers_listing_view">
											<div class="campaign-loop">
												<figure><a href="<?php echo get_permalink($post_id); ?>"><img src="<?php echo $feature_image_app; ?>"></a><?php $tax_deductible = get_post_meta( $post_id, 'tax_deductible', true ); 

												if($tax_deductible == true)
												{
													echo"<span class='tex_benefit'>"; echo "Tax Benefit";echo "</span>";
												}
												?></figure>
												<figcaption>
													<?php
													$tags = wp_get_object_terms($post_id, $taxonomy = 'fund_cate');
													echo "<div class='tag-after'><ul>";
													foreach ($tags as $key => $get_name)
													{
														echo "<li class='".$get_name->slug."'>"; echo $get_name->name; echo "</li>";
													}
													echo "</ul></div>"
													?>
													<h4><a href="<?php echo get_permalink($post_id); ?>"><?php echo ucfirst($shorttitle);  ?></a></h4>
													<span><?php echo wp_trim_words($content, '5', '..' ); ?></span>
													<p><strong>$<?php echo $g_amt; ?></strong>  of  <strong>$<?php echo $event_amt; ?></strong> Goal </p>
													<p>
														<?php
														$createdate = get_post_meta( $post_id, 'date_approvel', true );
														if($createdate)
														{
															?>
															<span class="all_fund_date_created">Date Created </span>  
															<?php   
															echo $date_create = date( "M d, Y", strtotime( $createdate )); 
														}
														?>
													</p>
													<p class="dontion-left"><?php
													if($count !=0) 
													{
														$date1 = time();
														$date2 = strtotime($last_donation);
														$diff = $date1 - $date2;
				//$years = floor($diff / (365*60*60*24));
				//$months = floor(($diff - $years * 365*60*60*24) / (30*60*60*24));
				//$days = floor(($diff - $years * 365*60*60*24 - $months*30*60*60*24)/ (60*60*24));
														$days = floor($diff / (60 * 60 * 24));
														$week = floor($days/7);
														$months = floor(($diff - $years * 365*60*60*24) / (30*60*60*24));
														$years = floor($diff / (365*60*60*24));
				//$week = floor($days/7);
														if($days == 1)
														{
															$s_days = "day";
														}
														else
														{
															$s_days = "days";
														}

														if($week == 1)
														{
															$s_week = "week";
														}
														else
														{
															$s_week = "weeks";
														}
														if($months == 1)
														{
															$s_month = "month";
														}
														else
														{
															$s_month = "months";
														}
														if($years ==  1)
														{
															$s_year = "year";
														}
														else
														{
															$s_year = "years";
														}
														if($days == 0 && $week == 0)
														{
															$show_date = "Last donation today";
														}

														else if(($days > 0 && $days <= 7 ) && $week == 0)
														{
															$show_date = "Last donation ". $days.' '. $s_days . " ago";
														}
														else if(($week > 0 && $week <= 4 ) && $months == 0)
														{
															$show_date = "Last donation ". $week.' '. $s_week . " ago";
														}

														else if(($months > 0 && $months <= 12 ) && $years == 0)
														{
															$show_date = "Last donation ". $months.' '. $s_month . " ago";
														}
														else
														{
															$show_date = "Last donation ". $years.' '. $s_year . " ago";
														}

														echo $show_date;
													}
													?>
												</p>
												<div class="progress"><div class="progress-inside" style="width:<?php if($amount_percentage <= 100) { echo $amount_percentage; } else { echo 100; } ?>%"></div></div>
												<ul class="progress-list">
													<li><?php if($amount_percentage <= 100) { echo $amount_percentage; } else { echo 100; } ?>%
														<span>Funded</span></li>
														<li>$<?php echo number_format($g_amt);?>
															<span>Donated</span>
														</li>
														<li><?php echo $left_date; ?>
															<?php if($left_date != 'EXPIRED') { ?><span>Time Left</span><?php } else { ?>
															<span style="visibility: hidden;">Time Left</span><?php } ?>
														</li>
													</ul>

													<form method="post" action="<?php echo site_url()?>/raiseit-donate">
														<input type="hidden" name="raiseit_amt" value="<?php echo $event_amt;?>">
														<input type="hidden" name="retail_post_id" value="<?php echo $rtlr_id; ?>">
														<input type="hidden" name="retailer_author" value="<?php echo $rrr_author_id; ?>">
														<input type="hidden" name="fund_author_id" value="<?php echo $post_author_id; ?>">
														<input type="hidden" name="fund_name" value="<?php echo $trimtitle; ?>">
														<input type="hidden" name="event_auth_name" value="<?php echo $event_auth_name;?>">
														<input type="hidden" name="ff_id" value="<?php echo $post_id;  ?>">
														<input type="hidden" name="event_e_date" value="<?php echo $expire_date; ?>">
														<input type="submit" class="btn donation-fund-btn" name="direct_dontaion" value="Donate Now">
													</form>
													<?php echo do_shortcode ('[shareaholic app="share_buttons" id_name="index_below_content"]'); ?>

												</figcaption>
											</div>
										</div>

										<?php
									endwhile;
									wp_reset_query();
								}

								else
								{
									echo "<div class='alert alert-danger fs-error-fund fs-error-fund-part'><div class='row campaign-list'><span style='color:red;'>There are no campaigns available by this name.</span></div></div>";
								}

								die();

							}

							/*********** load most funded *******************/
							add_action('wp_ajax_nopriv_most_funded', 'most_funded'); 
							add_action('wp_ajax_most_funded', 'most_funded');

							function most_funded()
							{
								global $wpdb;
								global $paged; global $args;
								$paged = (get_query_var('paged')) ? get_query_var('paged') : 1;

								$offset = $_POST["offset_p"];
								$ppp = $_POST["ppp"];
								header("Content-Type: text/html");



								$args = array( 'post_type' => 'fundraiser', 'posts_per_page' => $ppp,'offset' => $offset,'paged' => $paged,'post_status' =>'publish', 'meta_key' => 'most_fund',	'orderby' => 'meta_value_num','order' => 'DESC');

								$loop = new WP_Query($args);

								?>

								<?php
								if( $loop->have_posts())
								{

									while ( $loop->have_posts() ) : $loop->the_post();
										$post_id =  get_the_ID();
										$trimtitle = get_the_title();				
										$shorttitle = wp_trim_words( $trimtitle, $num_words = 7, $more = '… ' );
										$content =  get_the_content();
										$event_amount = get_field('amount',$post_id);

										$event_amt = str_replace( ',', '', $event_amount );
										$feature_image_app = get_the_post_thumbnail_url($post_id);

										$r_id = $wpdb->get_results("SELECT * FROM wp_post_relationships where f_id = $post_id");

										foreach ($r_id as $key => $lo_url) 
										{
											/*$llogo_url = $lo_url->retailer_logo;*/
											$rtlr_id = $lo_url->r_id;
											$post_author_id = $lo_url->f_auth_id;
											$event_auth_name = $lo_url->f_auth_name;
											$f_post_id = $lo_url->f_id;
											$rrr_author_id = $lo_url->rr_author_id;
											/*$donnor_id = $lo_url->donor_id ;*/
										} 

										$dnt_amts = $wpdb->get_results("SELECT donation_amt,donation_time FROM wp_donation where fund_ent_id = ".$post_id." ");
										$count = count($dnt_amts);

										$amt_donation = array();
										$last_donation = array();
										foreach ($dnt_amts as $key => $get_donation) 
										{
											$amt_donation[] = $get_donation->donation_amt;
											$amts = str_replace(',', '', $amt_donation);
											$last_donation = $get_donation->donation_time;
										}
										if($count != 0)
										{  
											$g_amt = @array_sum($amts);
										}
										else
										{
											$g_amt = "0";
										}

		// code for get the days and time left for an event	
										$current_date = date("Y/m/d");
										$expire_date  = get_post_meta( $post_id, 'event_expire_date', true);
										$exp_time = get_post_meta( $post_id, 'end_time', true);
	    //difference between post date and current date
										$date_diff = strtotime($expire_date) - strtotime($current_date);
        //calculate the days left
										$days = floor(($date_diff - $years * 365*60*60*24 - $months*30*60*60*24)/ (60*60*24));
										$timestamp = time();
										$date_time = date("H:i a", $timestamp); 
										@$t1 = $exp_time - $date_time;
		//Day and time left

										if($days == 0)
										{
											if($t1 > 0)
											{
												$timme_rimaning = "Time";
												$left_date = $t1." Hours";

											}
											else
											{
				//$timme_rimaning = "Days Left to Donate";
												$left_date = "EXPIRED";
											}

										}elseif($days == -1 || $days < -1)
										{
											$timme_rimaning = "Days Left to Donate";
											$left_date = "EXPIRED";
										}
										elseif($days > 0)
										{
											$timme_rimaning = "Days Left to Donate";
											$left_date = $days." Days";
										}
        //percentage amount calculate
										$amount_percentage = ($g_amt * 100) / $event_amt;

						//$amount_percentage = ($g_amt * 100) / $event_amt;
										$amount_percentage = round($amount_percentage, 1);

										?>
										<!-- loop data for show event info -->
										<div class="col-md-4 col-sm-4 show-all-fund fundraisers_listing_view">
											<div class="campaign-loop">
												<figure><a href="<?php echo get_permalink($post_id); ?>"><img src="<?php echo $feature_image_app; ?>"></a><?php $tax_deductible = get_post_meta( $post_id, 'tax_deductible', true ); 

												if($tax_deductible == true)
												{
													echo"<span class='tex_benefit'>"; echo "Tax Benefit";echo "</span>";
												}
												?></figure>
												<figcaption>
													<?php
													$tags = wp_get_object_terms($post_id, $taxonomy = 'fund_cate');
													echo "<div class='tag-after'><ul>";
													foreach ($tags as $key => $get_name)
													{
														echo "<li class='".$get_name->slug."'>"; echo $get_name->name; echo "</li>";
													}
													echo "</ul></div>"
													?>
													<h4><a href="<?php echo get_permalink($post_id); ?>"><?php echo ucfirst($shorttitle);  ?></a></h4>
													<span><?php echo wp_trim_words($content, '10', '..' ); ?></span>
													<p><strong>$<?php echo $g_amt; ?></strong>  of  <strong>$<?php echo $event_amt; ?></strong> Goal </p>
													<p>
														<?php
														$createdate = get_post_meta( $post_id, 'date_approvel', true );
														if($createdate)
														{
															?>
															<span class="all_fund_date_created">Date Created </span>  
															<?php   
															echo $date_create = date( "M d, Y", strtotime( $createdate )); 
														}
														?>
													</p>
													<p class="dontion-left"><?php
													if($count !=0) 
													{
														$date1 = time();
														$date2 = strtotime($last_donation);
														$diff = $date1 - $date2;
				//$years = floor($diff / (365*60*60*24));
				//$months = floor(($diff - $years * 365*60*60*24) / (30*60*60*24));
				//$days = floor(($diff - $years * 365*60*60*24 - $months*30*60*60*24)/ (60*60*24));
														$days = floor($diff / (60 * 60 * 24));
														$week = floor($days/7);
														$months = floor(($diff - $years * 365*60*60*24) / (30*60*60*24));
														$years = floor($diff / (365*60*60*24));
				//$week = floor($days/7);
														if($days == 1)
														{
															$s_days = "day";
														}
														else
														{
															$s_days = "days";
														}

														if($week == 1)
														{
															$s_week = "week";
														}
														else
														{
															$s_week = "weeks";
														}
														if($months == 1)
														{
															$s_month = "month";
														}
														else
														{
															$s_month = "months";
														}
														if($years ==  1)
														{
															$s_year = "year";
														}
														else
														{
															$s_year = "years";
														}
														if($days == 0 && $week == 0)
														{
															$show_date = "Last donation today";
														}

														else if(($days > 0 && $days <= 7 ) && $week == 0)
														{
															$show_date = "Last donation ". $days.' '. $s_days . " ago";
														}
														else if(($week > 0 && $week <= 4 ) && $months == 0)
														{
															$show_date = "Last donation ". $week.' '. $s_week . " ago";
														}

														else if(($months > 0 && $months <= 12 ) && $years == 0)
														{
															$show_date = "Last donation ". $months.' '. $s_month . " ago";
														}
														else
														{
															$show_date = "Last donation ". $years.' '. $s_year . " ago";
														}

														echo $show_date;
													}
													?></p>

													<div class="progress"><div class="progress-inside" style="width:<?php if($amount_percentage <= 100) { echo $amount_percentage; } else { echo 100; } ?>%"></div></div>
													<ul class="progress-list">
														<li><?php if($amount_percentage <= 100) { echo $amount_percentage; } else { echo 100; } ?>%
															<span>Funded</span></li>
															<li>$<?php echo number_format($g_amt);?>
																<span>Donated</span>
															</li>
															<li><?php echo $left_date; ?>
																<?php if($left_date != 'EXPIRED') { ?><span>Time Left</span><?php } else { ?>
																<span style="visibility: hidden;">Time Left</span><?php } ?>
															</li>
														</ul>

														<form method="post" action="<?php echo site_url()?>/raiseit-donate">
															<input type="hidden" name="raiseit_amt" value="<?php echo $event_amt;?>">
															<input type="hidden" name="retail_post_id" value="<?php echo $rtlr_id; ?>">
															<input type="hidden" name="retailer_author" value="<?php echo $rrr_author_id; ?>">
															<input type="hidden" name="fund_author_id" value="<?php echo $post_author_id; ?>">
															<input type="hidden" name="fund_name" value="<?php echo $trimtitle; ?>">
															<input type="hidden" name="event_auth_name" value="<?php echo $event_auth_name;?>">
															<input type="hidden" name="ff_id" value="<?php echo $post_id;  ?>">
															<input type="hidden" name="event_e_date" value="<?php echo $expire_date; ?>">
															<input type="submit" class="btn donation-fund-btn" name="direct_dontaion" value="Donate Now">
														</form>
														<?php echo do_shortcode ('[shareaholic app="share_buttons" id_name="index_below_content"]'); ?>
													</figcaption>
												</div>
											</div>

											<?php
										endwhile;
										wp_reset_query();
									}

									else
									{
										echo "<div class='alert alert-danger fs-error-fund fs-error-most-fund'><div class='row campaign-list'><span style='color:red;'>There are no any most funded campaigns available.</span></div></div>";
									}

									die();

								}
								?>