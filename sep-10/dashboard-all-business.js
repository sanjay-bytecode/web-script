jQuery(document).ready(function()
{	
		
 	var url = window.location.origin;
		var admin_url ="/rif-admin/admin-ajax.php";
		var ajaxUrl = url+admin_url;

		page=1; ppp = 9; 
		set_offset = 9;	

		var button = $('.post-listing');
		var loading = false;	
		var scrollHandling = {
			allow: true,
			reallow: function() {
			scrollHandling.allow = true;
			},
			delay: 400 //(milliseconds) adjust to the highest acceptable value
		};
		$(window).scroll(function()
		{
				
			business_scroll_event = $("#scrol_event").val();
					
			if(business_scroll_event =="all_business")
			{
				//alert('dsjhds');
				requet_action = "all_business";
				count_business = $("#count_allbusiness").val();
				search_value = '';
				loader = $(".loader-allbusiness");
				load_div = $(".loadmore-allbusiness");
				no_post_div = $(".nomore-allbusiness");
			}
			else if(business_scroll_event =="search_business")
			{
				requet_action = "search_business";
				count_business = $("#count_searchbusiness").val();
				search_value = $('#search_ret_names').val();
				loader = $(".loader-searchbusiness");
				load_div = $(".loadmore-searchbusiness");
				no_post_div = $(".nomore-searchbusiness");
			}
			/*** pending fundraiser **/
			if(set_offset < count_business) 
			{
				if( ! loading && scrollHandling.allow ) 
				{						
					scrollHandling.allow = false;
					setTimeout(scrollHandling.reallow, scrollHandling.delay);
					var offset = $(button).offset().top - $(window).scrollTop();
					if( 2000 > offset ) 
					{
						loading = true;	
						loader.show();					
						$.ajax({
						url :ajaxUrl ,
						type : 'post',
						data : {
							action : requet_action,
							offset_p:(page*ppp) ,
							ppp:ppp,
							search_by:search_value,							
						},
						success : function( response ) 
						{
							page++;	
							set_offset = page*ppp ;													
							load_div.before(response);											
							loading = false;
							loader.hide();
						
						}
					 })
					}
				}
			}
			 else
			{
				loader.hide();			
				if(count_business != 0)
				{
					$(".block").hide();
					no_post_div.show();				
				}			
				
			}
			
		});
		
});