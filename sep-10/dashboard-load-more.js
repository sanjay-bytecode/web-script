jQuery(document).ready(function()
{	
		var url = window.location.origin;
		var admin_url ="/rif-admin/admin-ajax.php";
		var ajaxUrl = url+admin_url;

		page=1; ppp = 9;
		page_yr=1; 
		page_rj=1; 
		set_offset = 9;	
		set_offset_yr = 9;	
		set_offset_rj = 9;	
		
		//$('.post-listing').append( '<span class="load-more"></span>' );
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
			
		total_pendcamp = $("#count_pendingcomp").val();		
		total_yourfund = $("#count_fundraisercomp").val();		
		total_rejectfund = $("#count_rejectedfundraiser").val();
		
		/*** pending fundraiser **/
		if(set_offset < total_pendcamp) 
		{
			if( ! loading && scrollHandling.allow ) 
			{						
				scrollHandling.allow = false;
				setTimeout(scrollHandling.reallow, scrollHandling.delay);
				var offset = $(button).offset().top - $(window).scrollTop();
				if( 2000 > offset ) 
				{
					loading = true;	
					$(".loader").show();					
					$.ajax({
					url :ajaxUrl ,
					type : 'post',
					data : {
						action : 'pending_fundraiser',
						offset_p:(page*ppp) ,
					    ppp:ppp,			
					},
					success : function( response ) 
					{
						page++;	
						set_offset = page*ppp ;													
						$(".load-more-pend-comp").before(response);											
						loading = false;
					
					}
				 })
			    }
			}
		}
		 else
		{
			$(".loader").hide();			
			if(total_pendcamp != 0)
			{
				$(".block").hide();
				$(".no-pend-fund").show();				
			}			
			
		}
		
		
		/*** your fundraiser***/
		if(set_offset_yr < total_yourfund) 
		{
			if( ! loading && scrollHandling.allow ) 
			{						
				scrollHandling.allow = false;
				setTimeout(scrollHandling.reallow, scrollHandling.delay);
				var offset = $(button).offset().top - $(window).scrollTop();
				if( 2000 > offset ) 
				{
					loading = true;	
					$(".your-loader").show();					
					$.ajax({
					url :ajaxUrl ,
					type : 'post',
					data : {
						action : 'your_fundraiser',
						offset_p:(page_yr*ppp) ,
					    ppp:ppp,			
					},
					success : function( response ) 
					{
						page_yr++;	
						set_offset_yr = page_yr*ppp ;													
						$(".your-fundraiser").before(response);											
						loading = false;
						$(".your-loader").hide();	
					
					}
				 })
			    }
			}
		}
		 else
		{
			$(".your-loader").hide();			
			if(total_yourfund != 0)
			{
				$(".block").hide();
				$(".nomore-your-fundraiser").show();				
			}			
			
		}
		
		/**** rejected fundraiser **/
		if(set_offset_rj < total_rejectfund) 
		{	
			if( ! loading && scrollHandling.allow ) 
			{						
				scrollHandling.allow = false;
				setTimeout(scrollHandling.reallow, scrollHandling.delay);
				var offset = $(button).offset().top - $(window).scrollTop();
				if( 2000 > offset ) 
				{
					loading = true;	
					$(".rejected-loader").show();					
					$.ajax({
					url :ajaxUrl ,
					type : 'post',
					data : {
						action : 'rejected_fundraiser',
						offset_p:(page_rj*ppp) ,
					    ppp:ppp,			
					},
					success : function( response ) 
					{
						page_rj++;	
						set_offset_rj = page_rj*ppp ;													
						$(".rejected-fundraiser").before(response);											
						loading = false;
					
					}
				 })
			    }
			}
		}
		 else
		{
			$(".rejected-loader").hide();			
			/* if(total_rejectfund != 0)
			{
				$(".block").hide();
				$(".no-rejected-fund").show();				
			}			
			 */
			 $(".no-rejected-fund").show();
		}
		
	});	
 	
});