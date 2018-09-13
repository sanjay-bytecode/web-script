jQuery(document).ready(function()
{
	
		var url = window.location.origin;
		var admin_url ="/rif-admin/admin-ajax.php";
		var ajaxUrl = url+admin_url;

		page=1; ppp=9;
		set_offset = 9;	
		
		$('.post-listing').append( '<span class="load-more"></span>' );
		var button = $('.post-listing .load-more');
		var loading = false;	
		var scrollHandling = {
			allow: true,
			reallow: function() {
			scrollHandling.allow = true;
			},
			delay: 400 //(milliseconds) adjust to the highest acceptable value
		};
		$(window).scroll(function(){
				
		fund_scroll_event = $("#fund_scroll_event").val();
		total_pastpost ='';

		search_name_fund_val = $('#fund_serach_by_name').val();
		select_cate_fund_val = $('#new_select_category').val();		
		search_zip_fund_val = $('#select_loction').val();
		short_by_most_fund_val = $('#most_funded').val();
		
		search_name_fund_mob = $('#mob_fund_serach_by_name').val();
		select_cate_fund_mob = $('#mob_new_select_category').val();		
		search_zip_fund_mob = $('#mob_select_loction').val();
		short_by_most_fund_mob = $('#mob_most_funded').val();
		
		if(search_name_fund_mob =='')
		{
			search_name_fund = search_name_fund_val;
		}
		else {
			search_name_fund = search_name_fund_mob;
		}

		if(select_cate_fund_mob =='')
		{
			select_cate_fund = select_cate_fund_val;
		}
		else {
			select_cate_fund = select_cate_fund_mob;
		}
	
		if(search_zip_fund_mob =='')
		{
			search_zip_fund = search_zip_fund_val;
		}
		else {
			search_zip_fund = search_zip_fund_mob;
		}

		if(short_by_most_fund_mob =='')
		{
			short_by_most_fund = short_by_most_fund_val;
		}
		else {
			short_by_most_fund = short_by_most_fund_mob;
		}


		if(fund_scroll_event =="default")
		{
			requet_action = "more_post_allfundraiser";
			total_post = $("#count_fund").val();
			total_pastpost = $("#count_pastfund").val();
			search_value = '';
			load_div = $(".load-more-post");
			no_post_div = $(".no-more-post");
		}
		else if(fund_scroll_event =="fundsearch_by_name")
		{
			requet_action = "fund_post_byname";
			total_post = $("#count_fundbyname").val();
			search_value = search_name_fund;
			load_div = $(".load-more-fund-byname");
			no_post_div = $(".nofund-byname");
		}		
		else if(fund_scroll_event =="fund_by_cate")
		{
			requet_action = "fund_post_bycate";
			total_post = $("#count_fundbycate").val();
			search_value = select_cate_fund;
			load_div = $(".load-more-fund-bycate");
			no_post_div = $(".nofund-bycate");
		}

		else if(fund_scroll_event =="fundsearch_by_zip")
		{
			requet_action = "fund_post_byzip";
			total_post = $("#count_fundbyzip").val();
			search_value = search_zip_fund;
			load_div = $(".load-more-fund-byzip");
			no_post_div = $(".nofund-byzip");
		}
		else if(fund_scroll_event =="mostfund")
		{
			requet_action = "most_funded";
			total_post = $("#count_mostfund").val();
			search_value = short_by_most_fund;
			load_div = $(".load-most-funded");
			no_post_div = $(".nomost-fund");
		}
	
		if(set_offset < total_post) {
			//alert(total_post);
		if( ! loading && scrollHandling.allow ) {
						
			scrollHandling.allow = false;
			setTimeout(scrollHandling.reallow, scrollHandling.delay);
			var offset = $(button).offset().top - $(window).scrollTop();
			if( 2000 > offset ) {
				//alert('working');
				loading = true;
				$(".loader").show();
				$.post(ajaxUrl,{
				type: 'POST',
				search_by: search_value,
				action: requet_action,
				offset_p:(page*ppp) ,
				ppp:ppp,				
				}).success(function(posts){
					//alert('sucessful');
					page++;	
					set_offset = page*ppp ;						
						
					load_div.before(posts);					
					//$(".load-more-post").before(posts);;
					
					loading = false;
				})

			}
		}
	 }
	 else
	{
		//$(".loader").fadeOut("slow");
		$(".loader").hide();
		
		if(total_post != 0)
		{
			$(".block").hide();
			no_post_div.show();
			
		}
		
		
	}
	if(set_offset < total_pastpost) {
			//alert(total_post);
		if( ! loading && scrollHandling.allow ) {
						
			scrollHandling.allow = false;
			setTimeout(scrollHandling.reallow, scrollHandling.delay);
			var offset = $(button).offset().top - $(window).scrollTop();
			if( 2000 > offset ) {
				//alert('working');
				loading = true;
				$(".loader").show();
				$.post(ajaxUrl,{
				type: 'POST',
				action: 'more_post_pastfundraiser',
				offset_p:(page*ppp) ,
				ppp:ppp,				
				}).success(function(posts){
					//alert('sucessful');
					page++;	
					set_offset = page*ppp ;						
						
					$(".load-more-pastpost").before(posts);					
					//$(".load-more-post").before(posts);;
					
					loading = false;
				})

			}
		}
	 }
	 else
	{
		//$(".loader").fadeOut("slow");
		$(".loader").hide();
		
		if(total_pastpost != 0)
		{
			$(".block").hide();
			$(".no-more-pastpost").show();
			
		}
		
		
	}
	});	
 

	
});