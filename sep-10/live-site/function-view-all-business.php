<?php
function all_businesses()
{

	global $wpdb;

	$args= null;
	$args = array( 'post_type' => 'retailer', 'posts_per_page' => 9,'post_status' =>'publish');
	$loop = new WP_Query( $args );
	$count_posts = wp_count_posts( 'retailer' )->publish;

	?>
	<h4 class="all_fundraisers_curr_compaigns">Business Sponsor <span>(<?php echo $count_posts; ?>)</span></h4>
	<input type="hidden" id="post_count" value="<?php echo $count_posts ;?>">
	<input type="hidden" id="scroll_event" value="default">
	<div class="orignal-all-fund-post">
		<div class="row campaign-list post-listing">

			<?php
			if( $loop->have_posts())
			{
				while ( $loop->have_posts() ) : $loop->the_post();
					//post id 
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
							<?php echo do_shortcode ('[shareaholic app="share_buttons" id_name="index_below_content"]'); ?>
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
		?>
		<div class="load-more-post"></div>
		<div class='alert alert-danger fs-error-fund fs-error-fund-part no-more-post'><div class='row campaign-list'><span style='color:red;'>No more current campaigns available.</span></div></div>
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

?>