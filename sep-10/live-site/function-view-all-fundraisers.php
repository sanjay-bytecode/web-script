<?php
function current_fundraiser()
{

	global $wpdb;

	$get_fund_data = $wpdb->get_results("SELECT f_id FROM wp_post_relationships where f_end_date >= CURDATE() AND status = 1");
	$count_fund = count($get_fund_data);
	foreach ($get_fund_data as $key_1 => $get_fund_id) 
	{
		$fud_arry_ids[] = $get_fund_id->f_id;
	}
	?>
	<h4 class="all_fundraisers_curr_compaigns">Current Campaigns <span>(<?php echo $count_fund; ?>)</span></h4>
	<input type="hidden" id="count_fund" value="<?php echo $count_fund ;?>">
	<input type="hidden" id="compaigns" value="current">
	<input type="hidden" id="fund_scroll_event" value="default">
	<div class="orignal-all-fund-post">
		<div class="row campaign-list post-listing">
			<?php
			$args= null;
			$args = array( 'post_type' => 'fundraiser', 'post__in' => $fud_arry_ids , 'posts_per_page' => -1,'post_status' =>'publish');
			$loop = new WP_Query( $args );
			$loop_count = count($loop);
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

						<div class="col-md-4 col-sm-4 hello-all-fund fundraisers_listing_view">
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
											<!-- <div class="shareaholic-canvas" data-app="share_buttons" data-app-id-name="index_above_content"></div> -->
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
					?>

					<div class="load-more-post"></div>
					<div class='alert alert-danger fs-error-fund fs-error-fund-part no-more-post'>
						<div class='row campaign-list'>
							<span style='color:red;'>No more current campaigns available.</span>
						</div>
					</div>

				</div>

		</div>
		<div style="clear:both"></div>
		<div class="loader" style="display:none;text-align:center">								
			<img class="img-loader" src="<?php bloginfo('template_directory');?>/images/ajax-loader.gif">
		</div>
		<style>
		.no-more-post {display:none;}
		</style>
		<?php
	}

	function past_fundraiser()
	{
		global $wpdb;
		$get_fund_data = $wpdb->get_results("SELECT f_id FROM wp_post_relationships where f_end_date < CURDATE() AND status = 1");
		$count_fund = count($get_fund_data);
		foreach ($get_fund_data as $key_1 => $get_fund_id) 
		{
			$fud_arry_ids[] = $get_fund_id->f_id;
		}
		?>
		<h4 class="all_fundraisers_curr_compaigns">Past Campaigns <span>(<?php echo $count_fund; ?>)</span></h4>
		<input type="hidden" id="count_pastfund" value="<?php echo $count_fund ;?>">	
		<div class="orignal-all-fund-post">
			<div class="row campaign-list post-listing">
				<?php
				$args= null;
				$args = array( 'post_type' => 'fundraiser', 'post__in' => $fud_arry_ids , 'posts_per_page' => -1,'post_status' =>'publish');
				$loop = new WP_Query( $args );
				$loop_count = count($loop);
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

							<div class="col-md-4 col-sm-4 hello-past-fund fundraisers_listing_view">
								<div class="campaign-loop">
									<figure><a href="<?php echo get_permalink($post_id); ?>"><img src="<?php echo $feature_image_app; ?>"></a>
										<?php $tax_deductible = get_post_meta( $post_id, 'tax_deductible', true ); 
										if($tax_deductible == true)
										{
											echo"<span class='tex_benefit'>"; echo "Tax Benefit";echo "</span>";
										}
										?>
									</figure>
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
											<!-- <div class="shareaholic-canvas" data-app="share_buttons" data-app-id-name="index_above_content"></div> -->
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
						echo "<div class='alert alert-danger fs-error-fund fs-error-fund-part'><div class='row campaign-list'><span style='color:red;'>There are no past campaigns available.</span></div></div>";
					}
					?>
					<div class="load-more-pastpost"></div>
					<div class='alert alert-danger fs-error-fund fs-error-fund-part no-more-pastpost'>
						<div class='row campaign-list'>	
							<span style='color:red;'>No more past campaigns available.</span>
						</div>
					</div>
				</div>
			

		</div>
		<div style="clear:both"></div>
		<div class="loader" style="display:none;text-align:center">								
			<img class="img-loader" src="<?php bloginfo('template_directory');?>/images/ajax-loader.gif">
		</div>
		<style>
		.no-more-pastpost {display:none;}
		</style>
		<?php
	}
	?>