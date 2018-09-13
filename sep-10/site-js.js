	jQuery(document).ready(function()
{
	$("#cutsom_user_pass").keyup(function(){
		var cutsom_user_pass_eye = $("#cutsom_user_pass").val();
		if(cutsom_user_pass_eye == '')
		{
			$("#show-hide-eyes").hide(500);
		}
		else
		{
			$("#show-hide-eyes").show(500);
		}
	});


	$(".hide-show-bar-search").click(function()
	{
		$(".show-search-mobile").slideToggle();
	});


	$(".toggle-password").click(function() {
		$(this).toggleClass("show-hide-eyes show-hide-eyes-slesh");
		var input = $($(this).attr("toggle"));
		if (input.attr("type") == "password") {
			input.attr("type", "text");
		} else {
			input.attr("type", "password");
		}
	});
	$(".clear_all_search").click(function()
	{
		$(".all-campaign-list").show();
		$(".category-filter-fund-post").hide();
		$(".location-filter-fund-post").hide();
		$(".location-most-fund-post").hide();
		$(".fs-error-fund-part").hide();
		$(".fs-error-fund-cat").hide();
		$("#fund_serach_by_name").val('');
		$("#select_loction").val('');
		$("#new_select_category").val('');
		$("#most_funded").val('');
		$("#mob_fund_serach_by_name").val('');
		$("#mob_new_select_category").val('');
		$("#mob_select_loction").val('');
		$("#mob_most_funded").val('');
		$(".clear-search").hide();
	});


	$(".clear-search-reat").click(function()
	{
		$(".all_fund_data").show();
		$(".name-filter-ret-post").hide();
		$(".zipcode-filter-ret-post").hide();
		$(".city-filter-ret-post").hide();
		$(".fs-error-fund-part").hide();
		$(".fs-error-fund-cat").hide();
		$("#ret_search_by_name").val('');
		$("#mob_ret_search_by_name").val('');
		$("#ret_search_by_zipcode").val('');
		$("#mob_ret_search_by_zipcode").val('');
		$("#ret_search_by_city").val('');
		$("#mob_ret_search_by_city").val('');
		$(".clear-search-reat").hide();
		$('#scroll_event').val("default");
		location.reload();		
		
	});


	$( ".footer-bottom" ).scroll();

	$(".zzz").click(function(){
		$('#edit_fundraiser_image').modal({
			backdrop: 'static'
		});
	});

	$(".fund_logo").click(function(){
		$('#edit_fundraiser_logo').modal({
			backdrop: 'static'
		});
	});

	$(".yyy").click(function(){
		$('#edit_business_image').modal({
			backdrop: 'static'
		});
	});

	$(".aaa").click(function(){
		$('#edit_business_logo').modal({
			backdrop: 'static'
		});
	});

	$("a.howit").click(function(e){
		e.preventDefault();
		$(".toggle").hide();
		var toShow = $(this).attr('href');
		$(toShow).show();
	}); 

	$(".playVid").click(function()
	{
		$('.event-fundimg').hide();
		$('.event-fundvedio').show();
	});
	$(".backtoimg").click(function()
	{
		$('.event-fundimg').show();
		$('.event-fundvedio').hide();
	});



	$('#add_phone_number').modal({
		backdrop: 'static'
	});


	$('#add_phone_number_btn_sub').click(function(event)
	{
		var url = window.location.origin;
		var admin_url ="/wp-admin/admin-ajax.php";
		var ajaxUrl = url+admin_url;
		var user = "/user/";
		var user_url  = url+user;


		event.preventDefault();

		var uID     =   $('#social_media_user_id').val();
		//var uphone  =   $('#add_phone_number_users').val();
		var c_code2  = $(".flag-container .selected-dial-code").text();

		var ph_no2 = $("#add_phone_number_users").val();

		var uphone = c_code2+" "+ph_no2;

		if(uphone == '')
		{
			document.getElementById("add_phone_number_users").style.borderColor = "#E34234"; 
			$('.add_phone_number_error').html('<span style="color:red;"> Please enter your phone number </span>');
			$('.add_phone_number_error').show();  
			return false;

		}else{

			event.preventDefault();

			$('.add_phone_number_error').hide();

			var url=ajaxUrl;

			$.ajax({

				url :url,
				type : 'post',
				data : {
					action : 'add_user_phone_number',
					uid: uID,
					uphone: encodeURIComponent(uphone)
				},         
				beforeSend: function() 
				{
					$('#add_phone_number #dvLoadingsingup').show();                          
				},
				success: function(responseq) 
				{
            //alert(responseq);
            if(responseq==1)
            {
            	$('#add_phone_number #dvLoadingsingup').hide();
            	$('#add_phone_number .add_phone_number_users').show();

            	setTimeout(function()
            	{
            		$.LoadingOverlay("show", {
            			image       : "",
            			fontawesome : "fas fa-spinner fa-spin"
            		});

            		$('#add_phone_number').modal('hide');

            		$('#social_media_users').modal({
            			backdrop: 'static'
            		}); 

            		$.LoadingOverlay("hide");
            	}, 2000);           
            }  
        }
    });       

		}                  
	});

	$("#social_media_users_btn_sub").click(function(event)
	{   

		var url = window.location.origin;
		var admin_url ="/wp-admin/admin-ajax.php";
		var ajaxUrl = url+admin_url;
		var user = "/user/";
		var user_url  = url+user;
		event.preventDefault(); 
		$('#social_media_users .auth-error-social_media_users1').hide();

		var auth_code = $("#auth_code_login_social_media_users").val();

		var user_id = $("#social_media_user_id").val();

		if(auth_code == '')
		{
			document.getElementById("auth_code_login_social_media_users").style.borderColor = "#E34234"; 
			$('.auth-error-social_media_users').show();  
			$('.auth-error-social_media_users1').hide(); 
			$('#social_media_users #dvLoadingsingup').hide();      

			return false;

		}else{

			$('.auth-error-social_media_users').hide();

			var purl = ajaxUrl;

			$.ajax({

				url :purl,
				type : 'post',
				data : {
					action : 'authenticate_social_user_',
					uid: user_id,
					auth_code: auth_code
				},         
				beforeSend: function() 
				{
					$('#social_media_users #dvLoadingsingup').show();                          
				},
				success: function(responseq) 
				{
            //alert(responseq);
            if(responseq==1)
            {
            	$('#social_media_users #dvLoadingsingup').hide();
            	$('#social_media_users .auth-success-social_media_users').show();
            	$('#social_media_users .auth-error-social_media_users1').hide();

            	setTimeout(function()
            	{
            		$.LoadingOverlay("show", {
            			image       : "",
            			fontawesome : "fas fa-spinner fa-spin"
            		});

            		$('#social_media_users').modal('hide');
            		window.location.href =url;
                  //$.LoadingOverlay("hide");
              }, 2000);

            }
            else if(responseq==2)
            {
            	$('#social_media_users #dvLoadingsingup').hide();
            	$('#social_media_users .auth-error-social_media_users1').show();              
            }       
        }
    });                 
		}  
	});



	$(".send_thanks_btn_popup").click(function()
	{
		$('#thank_modal').modal('show');
		var d_email = $(this).attr("data-demail");
		var d_name = $(this).attr("data-fname");
		var d_phone = $(this).attr("data-dphone");

		$("#donor_name").val(d_name);
		$("#donor_email").val(d_email);
		$("#ddonor_phone").val(d_phone);
	});

	$(".send_thanks_btn_popup_host").click(function()
	{
		$('#thank_modal_host').modal('show');
		var host_d_email = $(this).attr("data-host-demail");
		var host_d_name = $(this).attr("data-host-fname");
		var host_d_phone = $(this).attr("data-host-dphone");

		$("#host_donor_name").val(host_d_name);
		$("#host_donor_email").val(host_d_email);
		$("#host_ddonor_phone").val(host_d_phone);
	});

	$(".send_thanks_btn").click(function()
	{
		var url = window.location.origin;
		var admin_url ="/wp-admin/admin-ajax.php";
		var ajaxUrl = url+admin_url;
		var user = "/user/";
		var user_url  = url+user;

		var d_email = $(this).attr("data-demail");
		var d_phone = $(this).attr("data-dphone");	
		var d_name = $(this).attr("data-fname");

		setTimeout(function()
		{
			$.LoadingOverlay("show", {
				image       : "",
				fontawesome : "fas fa-spinner fa-spin"
			});
			$.ajax({
				url :ajaxUrl,
				type : 'post',
				dataType: 'json',
				data : {
					action : 'say_thanks_message',
					d_email : d_email,
					d_phone : d_phone,
					d_name : d_name

				},
				success : function( response ) 
				{

					if(response == 1)
					{
						$.LoadingOverlay("hide");
						$('#thank_modal').modal('show');
					}
				}
			});
		}, 2000);
		//$.LoadingOverlay("hide");
	});

	$("#ug_submit_button").click(function () 
	{ 
		var ug_photo = $("#ug_photo").val();
		var add_message = $("#add_message").val();
		var v_url = $("#videourl").val();

		var v1 = $('#ug_photo').is(':disabled');
		var v2 = $('#videourl').is(':disabled');

		if(ug_photo == '' && !v1)
		{
			$('.upload-error').html('<span style="color:red;"> An Image File is Required </span>');
			$('.upload-error').show(); 
			return false;
		}

		else
		{
			$('.upload-error').hide(); 
			return true;
		}  

		if(v_url == '' && !v2)
		{
			$('.upload-error').html('<span style="color:red;"> An Image File is Required </span>');
			$('.upload-error').show(); 
			return false;
		}


		else
		{
			$('.upload-error').hide(); 
			return true;
		}

		if(add_message == '')
		{
			$('.upload-error').html('<span style="color:red;"> A Message is Required </span>');
			$('.upload-error').show(); 
			return false;
		}
		else
		{
			$('.upload-error').hide(); 
			

			$("#uploadvideo").submit(function() {
				setTimeout(function() 
				{
					$.LoadingOverlay("show", {
						image       : "",
						fontawesome : "fas fa-spinner fa-spin"
					});               
				}, 100);
			});

			return true;
		}

	});

	$("#email_subs").click(function()
	{
		var url = window.location.origin;
		var admin_url ="/wp-admin/admin-ajax.php";
		var ajaxUrl = url+admin_url;
		var email = $("#sub_email").val();
		var email_post_id = $("#email_post_id").val();
		if ($.trim(email).length == 0) 
		{
			document.getElementById("sub_email").style.borderColor = "#E34234";
			$('.fs-error').html('<span style="color:red;"> Please Enter Your Email </span>');
			$('.fs-error').show();
			$('.fs-success').hide();
			return false;  

		}else{ 

			document.getElementById("sub_email").style.borderColor = "#006600";  

		}
		/*********** Validating Email *************/

		var emailval = $('#sub_email').val();

		var mailformat = /^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/;  

    // Checking Empty Fields

    var vemail = mailformat.test(emailval)
    if ($.trim(emailval).length == 0 || vemail==false) 
    {
    	$('.fs-error').html('<span style="color:red;"> Invalid Email </span>');

    	document.getElementById("sub_email").style.borderColor = "#E34234";

    	$('.fs-error').show();
    	$('.fs-success').hide();

    	return false;
    }
    else{
    	document.getElementById("sub_email").style.borderColor = "#006600";  
    	$('.fs-error').hide();

    	$.ajax({
    		url :ajaxUrl ,
    		type : 'post',
    		dataType: 'json',
    		data : {
    			action : 'subscribe_email_fund_post',
    			email: email,
    			email_post_id: email_post_id
    		},
    		success : function(response) 
    		{
    			if(response ==1 )
    			{
    				$('.fs-success').html('<span style="color:red;"> You have successfully subscribed </span>');
    				$('.fs-success').show();
    			}
    			if(response == 2 )
    			{
    				$('.fs-error').html('<span style="color:red;"> Email already used in our platform </span>');
    				$('.fs-error').show();
    			}

    		}
    	});

    }

});
	/*$('ul.accordian').accordion();	*/
// carousel slider
var $item = $('.carousel .item'); 
var $wHeight ='450px';
$item.eq(0).addClass('active');
$item.height($wHeight); 
$item.addClass('full-screen');

$('.carousel img').each(function() {

	var $src = $(this).attr('src');

	var $color = $(this).attr('data-color');

	$(this).parent().css({

		'background-image' : 'url(' + $src + ')',

		'background-color' : $color

	});

	$(this).remove();

});
$('.carousel').carousel({
	interval: 6000,
	pause: "false"
});	


$('#piereg_login_form #pie_register li .fieldset label').text(function () {
	return $(this).text().replace("Username", "Email or Username"); 
});

$('#piereg_lostpasswordform #user_login').after('<i class="fa fa-check forget_tick" id="red-check1" aria-hidden="true"></i>');

$('#piereg_lostpasswordform #user_login').before('<i class="fa fa-user forget_user-one" aria-hidden="true"></i>');

$('#piereg_lostpasswordform #user_login').attr('placeholder','Email or Username');

$('.wp_front_login #user_login').attr('placeholder','Email or Username');
$('.wp_front_login #user_pass').attr('placeholder','Password');

$('.wp_front_login #user_login').after('<i class="fa fa-check tick-two" id="red-check" aria-hidden="true"></i>');
$('.wp_front_login #user_pass').after('<i class="fa fa-check tick-two" id="error-red" aria-hidden="true"></i>');

$('.wp_front_login #user_login').before('<i class="fa fa-user user-one" aria-hidden="true"></i>');
$('.wp_front_login #user_pass').before('<i class="fa fa-key user-one" aria-hidden="true"></i>');



$('#myModal #pie_register li .fieldset label').text(function () {
	return $(this).text().replace("Username", "Email or Username"); 
});


$('#f_event_date_new').datepicker({
	Format: 'mm-dd-yyyy',
	autoclose:true,
	orientation: 'auto',
	startDate: new Date(),
}).on('changeDate',function(e){
	$('#f_event_e__date_new').datepicker('setStartDate',e.date)
});

$('#f_event_e__date_new').datepicker({
	Format: 'mm-dd-yyyy',
	autoclose:true,
	orientation: 'auto',
}).on('changeDate',function(e){
	$('#f_event_date_new').datepicker('setEndDate',e.date)
});

$('input.timepicker').timepicker();

$("#myModal #cutsom-wp-submit").click(function(event)
{
	var surl = window.location.origin;
	var admin_url ="/rif-admin/admin-ajax.php";
	var ajaxUrl = surl+admin_url;
	var user = "/user/";
	var user_url  = surl+user;

	event.preventDefault();
	var cc     = window.location.href;
	var ulogin =   $('#cutsom_user_login').val();
	var upass  =   $('#cutsom_user_pass').val();

	if ($.trim(ulogin).length == 0) 
	{
		document.getElementById("cutsom_user_login").style.borderColor = "#E34234";
		$("#red-check").addClass('red-tick');
		$("#red-check").removeClass('green-tick'); 

		$('.error-login1').html('<span style="color:red;"> Please Enter Your Email or Username </span>');
		$('.error-login1').show();
		$('.legend_txt').hide();
		return false; 
	}
	else
	{ 
		document.getElementById("cutsom_user_login").style.borderColor = "#006600";
		$("#red-check").addClass('green-tick');
		$("#red-check").removeClass('red-tick');   
	}

	/*********** Validating Email *************/

/*	var emailval = $('#cutsom_user_login').val();
	var mailformat = /^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/;  
    // Checking Empty Fields
    var vemail = mailformat.test(emailval)
    if ($.trim(emailval).length == 0 || vemail==false) 
    {
    	$('.error-login1').html('<span style="color:red;"> Invalid Email </span>');
    	document.getElementById("cutsom_user_login").style.borderColor = "#E34234";
    	$("#red-check").addClass('red-tick');
    	$("#red-check").removeClass('green-tick'); 

$('.error-login1').show();
$('.legend_txt').hide();
return false;
}
else
{
	document.getElementById("cutsom_user_login").style.borderColor = "#006600";
	$("#red-check").addClass('green-tick');
	$("#red-check").removeClass('red-tick'); 

$('.error-login1').hide();
    //return true;
}*/

if ($.trim(upass).length == 0) 
{
	document.getElementById("cutsom_user_pass").style.borderColor = "#E34234";
	$("#error-red").addClass('red-tick');
	$("#error-red").removeClass('green-tick'); 
/*	document.getElementById("error-red").style.backgroundColor = "#E34234";
document.getElementById("error-red").style.color = "#fff"; */
$('.error-login1').html('<span style="color:red;"> Please Enter Your Password </span>');
$('.error-login1').show();
$('.legend_txt').hide();
return false; 
}
else
{ 
	document.getElementById("cutsom_user_pass").style.borderColor = "#006600";
	$("#error-red").addClass('green-tick');
	$("#error-red").removeClass('red-tick'); 
/*	document.getElementById("error-red").style.backgroundColor = "#27AE60";
document.getElementById("error-red").style.color = "#fff";  */

$.ajax({
	url : ajaxUrl,
	type : 'post',
	dataType: 'json',
	data : {
		action : 'check_user_login',
		user_login: ulogin,
		user_pass : upass    
	},
	beforeSend: function() 
	{
		$('.error-left .error-login1').hide();
		$('.error-left .error-login').hide();
		$('#myModal .error-left #dvLoading').show();  			
	},


	success : function( response ) 
	{
		if (response == 1) 
		{
			$('.error-login1').html('<span style="color:red;"> Invalid Password. </span>');
			document.getElementById("cutsom_user_pass").style.borderColor = "#E34234";
			document.getElementById("cutsom_user_login").style.borderColor = "#E34234";
			$("#error-red").addClass('red-tick');
			$("#red-check").addClass('red-tick'); 
			$("#error-red").removeClass('green-tick');
			$("#red-check").removeClass('green-tick'); 

/*				document.getElementById("error-red").style.backgroundColor = "#E34234";
				document.getElementById("error-red").style.color = "#fff"; 
				document.getElementById("red-check").style.backgroundColor = "#E34234";*/
				$('.error-login1').show();
				$('#myModal .error-left #dvLoading').hide();
			}
			else if(response == 7)
			{ 

				$('.error-login1').html('<span style="color:red;"> Email or Username does not exist. </span>');
				document.getElementById("cutsom_user_login").style.borderColor = "#E34234";  
				$('.error-login1').show();
				$('#myModal .error-left #dvLoading').hide();

			}  
			else if (response == 2) 
			{    
				$('.error-login').html('<span style="color:green;"> Login successfull...redirecting</span>');
				$('.error-login1').hide();
				$('.error-login').show();
				$('#myModal .error-left #dvLoading').hide();
              // Hide it after 5 seconds
              setTimeout(function()
              {
              	$.LoadingOverlay("show", {
              		image       : "",
              		fontawesome : "fas fa-spinner fa-spin"
              	});
              	$('#myModal').modal('hide');
              	window.location= user_url;
              }, 1000);
          }
          else if (response == 3)
          {
          	$('.error-login').html('<span style="color:green;"> Login successfull...redirecting</span>');
          	$('.error-login1').hide();
          	$('.error-login').show();
          	$('#myModal .error-left #dvLoading').hide();
          	setTimeout(function()
          	{
          		$.LoadingOverlay("show", {
          			image       : "",
          			fontawesome : "fas fa-spinner fa-spin"
          		});
          		$('#myModal').modal('hide');  
          		window.location.href = user_url;
                //window.location.href = 'https://dev.raiseitfast.com/wp-admin';  				
          		//window.location.href = cc;                
          	}, 1000);
          }
          else if (response == 4)
          {
          	$('.error-login').html('<span style="color:green;"> Login successfull...redirecting</span>');
          	$('.error-login1').hide();
          	$('.error-login').show();
          	$('#myModal .error-left #dvLoading').hide();

              // Hide it after 5 seconds
              setTimeout(function()
              {
              	$.LoadingOverlay("show", {
              		image       : "",
              		fontawesome : "fas fa-spinner fa-spin"
              	});
              	$('#myModal').modal('hide');
              	window.location.href = cc;
              }, 1000);
          }
          else if (response == 5)
          {
          	$('.error-login').html('<span style="color:green;"> Login successfull...redirecting</span>');
          	$('.error-login1').hide();
          	$('.error-login').show();
          	$('#myModal .error-left #dvLoading').hide();

              // Hide it after 5 seconds
              setTimeout(function()
              {
              	$.LoadingOverlay("show", {
              		image       : "",
              		fontawesome : "fas fa-spinner fa-spin"
              	});
              	$('#myModal').modal('hide');
              	//window.location.href = "<?php echo site_url('/user/')?>";
              	window.location=user_url;
              }, 1000);
          }
          else
          {
          	$('#myModal').modal('hide');
          	$('#overlay-act-aftrlogin').modal({
          		backdrop: 'static'
          	});
          	$('#auth-code-aftr-log-in #n_user_id_aftrlogin').val(response);
          }
      }
  });
}
});

//Login Form AjAx Process Code End Here

$(".signup-back").click(function()
{

	$(".if_existing_user").show();
	if($(".facebook-login").attr('vis')=='show') return;
	$(".facebook-login").slideDown(300);
	$(".sing-up-form").animate({height:'-=1000'},1000)  
	$(".sing-up-form").css('opacity','0');
	$(".facebook-login").attr('vis','show');
	$(".sing-up-form").css('opacity','0');
	$(".sing-up-form").css('height','-1px');
	$(".sing-up-form").attr('vis','hide');
	$(".facebook-login").css('opacity','1');
	$(".facebook-login").css('height','auto');
	$("#msform").hide();
});

$(".sing-up-form").hide();

$(".btn1").click(function(){
	if($(".sing-up-form").attr('vis')=='show') return;
	$(".sing-up-form").slideDown(300);
	$(".facebook-login").animate({height:'-=300'},1000)
	$(".facebook-login").css('opacity','0');
	$(".sing-up-form").attr('vis','show');
	$(".facebook-login").attr('vis','hide');
	$(".facebook-login").css('height','0');
	$(".sing-up-form").css('opacity','1');
	$(".sing-up-form").css('height','auto');
	$(".if_existing_user").hide();
	$("#msform").show();
	document.getElementById('my_text').innerHTML = '(After your successful registration, you will receive an email and text message with your authentication code. Use that code to authenticate your account with Raise It Fast.)';

});

$(".donate_btn_clk_login_show").click(function(){
	$('#myModal2').modal('hide');
	$('#myModal').modal('show');
});

//Sign up process Start here

$("#singup-process").click(function(event)
{
	var clientname = $('#clientname').val();

	var lastname = $('#lastname').val();

	var email =   $('#uemail').val();

	var c_code  = $(".flag-container .selected-dial-code").text();

	var ph_no = $("#uphone").val();

	var phone = c_code+" "+ph_no;

	var url = window.location.origin;
	var admin_url ="/rif-admin/admin-ajax.php";
	var ajaxUrl = url+admin_url;
	var user = "/user/";
	var user_url  = url+user;

	if ($.trim(clientname).length == 0) 
	{
		document.getElementById("clientname").style.borderColor = "#E34234";

		$('.fs-error').html('<span style="color:red;"> Please Enter Your First Name </span>');

		$('.fs-error').show();

		return false;

	}else{ 

		document.getElementById("clientname").style.borderColor = "#006600";
	}

	var numbers = /[^A-Za-z_\s]/;

	if (numbers.test(clientname))
	{
		document.getElementById("clientname").style.borderColor = "#E34234";   

		$('.fs-error').html('<span style="color:red;"> Please Only Enter Letters For Your First Name </span>');

		$('.fs-error').show(); 

		return false;

	}else{
		document.getElementById("clientname").style.borderColor = "#006600";

		$('.fs-error').hide();
	}

	if ($.trim(lastname).length == 0) 
	{
		document.getElementById("lastname").style.borderColor = "#E34234";

		$('.fs-error').html('<span style="color:red;"> Please Enter Your Last Name </span>');

		$('.fs-error').show();

		return false;

	}else{ 

		document.getElementById("lastname").style.borderColor = "#006600";   
	}

	if (numbers.test(lastname)) 
	{
		document.getElementById("lastname").style.borderColor = "#E34234";   

		$('.fs-error').html('<span style="color:red;"> Please Enter Only Letters For Your Last Name </span>');

		$('.fs-error').show(); 

		return false;
	}
	else{

		document.getElementById("lastname").style.borderColor = "#006600";

		$('.fs-error').hide();

		/*$('.fs-success').show();*/
	}

	if ($.trim(email).length == 0) 
	{
		document.getElementById("uemail").style.borderColor = "#E34234";

		$('.fs-error').html('<span style="color:red;"> Please Enter Your Email </span>');

		$('.fs-error').show();

		$('.fs-success').hide();

		return false;  

	}else{ 

		document.getElementById("uemail").style.borderColor = "#006600";
		$('.fs-success').hide();   
	}

	/*********** Validating Email *************/

	var emailval = $('#uemail').val();

	var mailformat = /^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/;  

    // Checking Empty Fields

    var vemail = mailformat.test(emailval)

    if ($.trim(emailval).length == 0 || vemail==false) 
    {
    	$('.fs-error').html('<span style="color:red;"> Invalid Email Address </span>');

    	document.getElementById("uemail").style.borderColor = "#E34234";

    	$('.fs-error').show();

    	return false;
    }
    else{

    	document.getElementById("uemail").style.borderColor = "#006600";  

    	$('.fs-error').hide();

    	$('.fs-success').hide();

    //return true;
}

if ($.trim(ph_no).length == 0) 
{
	document.getElementById("uphone").style.borderColor = "#E34234";

	$('.fs-error').html('<span style="color:red;"> Please Enter Your Phone Number </span>');

	$('.fs-error').show();

	$('.fs-success').hide();
	return false; 

}else{ 

	document.getElementById("uphone").style.borderColor = "#006600";

	$('.fs-success').hide();    

	document.getElementById("uphone").style.borderColor = "#006600";
	event.preventDefault();

	$('.fs-error').hide();
	var clientname = $('#clientname').val();
	var lastname = $('#lastname').val();
	var email   = $('#uemail').val();
    	//var phone   = $('#uphone').val();
    	$.ajax({
    		url :ajaxUrl ,
    		type : 'post',
    		/*		dataType: 'json',*/
    		data : {
    			action : 'new_check_user_signup',
    			first_name: clientname,
    			last_name: lastname,
    			user_email: email,
    			user_phone: encodeURIComponent(phone),
    		},

    		beforeSend: function() 
    		{
    			$('#msform .fs-error').hide();
    			$('#msform #dvLoadingsingup').show();  			
    		},

    		success : function(response) 

    		{
    			var str = response;
    			var arr = str.split("-");
    			var error_resp = arr[0];
    			var user_id = arr[1];

    			if (response == 2) 
    			{    
    				document.getElementById("uemail").style.borderColor = "#E34234";
    				$('.fs-error').html('<span style="color:red;"> This Email Address is Already Registered </span>');
    				$('.fs-error').show();
    				$('#msform #dvLoadingsingup').hide(); 
    			}
    			else if(error_resp == 9)
    			{
    				$('.fs-error').hide(); 
    				$('#msform #dvLoadingsingup').hide();            
    				$('.fs-success').show();
    				$('.fs-success').html('<span style="color:green;">Confirmation: your registration was successful. </span><p class="invalid_phone_num_text"><b>NOTE:-</b> Your phone number appears to be nvalid. You can update your phone number after authenticate your account and logging in to your account.</p>'); 
    				setTimeout(function()
    				{
    					$.LoadingOverlay("show", {
    						image       : "",
    						fontawesome : "fas fa-spinner fa-spin"
    					});
    					$('#myModal2').modal('hide');
    					$.LoadingOverlay("hide");
    					$('#overlay-act-signup-succ').modal({
    						backdrop: 'static'
    					}); 
    				}, 5000);
    				$('#n_user_id').val(user_id);
    			}
    			else
    			{
    				$('.fs-error').hide(); 
    				$('#msform #dvLoadingsingup').hide();            
    				$('.fs-success').show();
    				$('.fs-success').html('<span style="color:green;">Confirmation: your registraion was successful. </span>'); 
    				setTimeout(function()
    				{
    					$.LoadingOverlay("show", {
    						image       : "",
    						fontawesome : "fas fa-spinner fa-spin"
    					});
    					$('#myModal2').modal('hide');
    					$.LoadingOverlay("hide");
    					$('#overlay-act-signup-succ').modal({
    						backdrop: 'static'
    					}); 
    				}, 3000);
    				$('#n_user_id').val(response);
    			}
    		}
    	});
    }
});
//Sign up process End here

//Auth Code Process Start here

$("#auth-code-sel-log-in").click(function(event)
{
	var cc          = window.location.href;
	var auth_code   = $('#auth_code').val();
	var u_id        = $('#n_user_id').val();
	var url        = window.location.origin;
	var admin_url ="/rif-admin/admin-ajax.php";
	var ajaxUrl = url+admin_url;
	var user = "/user/";
	var user_url  = url+user;

	if ($.trim(auth_code).length == 0) 
	{
		document.getElementById("auth_code").style.borderColor = "#E34234";
		$('.auth-error-login1').show();
		$('.auth-error-login').hide();
		return false;
	}else{
		event.preventDefault();             
		document.getElementById("auth_code").style.borderColor = "#006600";
		$.ajax({
			url :ajaxUrl,
			type : 'post',
			dataType: 'json',
			data : {
				action : 'check_auth_code',
				auth_code : auth_code,
				u_id      : u_id
			},
			beforeSend: function() 
			{
				$('.auth-error-login').hide();
				$('.auth-error-login1').hide();  
				$('#overlay-act-signup-succ #dvLoading').show();            
			},
			success : function( response ) 
			{
                 //proceed auto login
                 if(response == 1)

                 {
                 	$('#overlay-act-signup-succ #dvLoading').hide();
                 	//$('.auth-success-aftrsignupp').show();
                 	$('#overlay-act-signup-succ .auth-success-aftrsignupp').show();
                 	setTimeout(function() 
                 	{
                 		$.LoadingOverlay("show", {
                 			image       : "",
                 			fontawesome : "fas fa-spinner fa-spin"
                 		});
                 		$('#overlay-act-signup-succ').modal('hide');  
                 		$.LoadingOverlay("hide");
                 		window.location.href = user_url;

                 	}, 3000); 

                 }else{
                //alert('Auth Code Did not matched!');
                $('.auth-error-login').show();
                $('.auth-error-login1').hide();
                $('.auth-success-aftrsignupp').hide();
                $('#overlay-act-signup-succ #dvLoading').hide();   
            }   
        }
    });
	}
});  

//***************Auth Code Process Ends here************//

//******************Authenticate User After Login Code Start Here****************//

$("#auth-code-aftr-log-in").submit(function(event)
{
      //alert('fsfsd');
      var cc          = window.location.href;
      var auth_code   = $('#auth_code_login').val();
      var u_id        = $('#n_user_id_aftrlogin').val();
      var url = window.location.origin;
      var admin_url ="/rif-admin/admin-ajax.php";
      var ajaxUrl = url+admin_url;
      var user = "/user/";
      var user_url  = url+user;

       //alert(u_id);
       if ($.trim(auth_code).length == 0) 
       {
       	document.getElementById("auth_code_login").style.borderColor = "#E34234";
       	$('.auth-error-aftrlogin').show();
       	$('.auth-error-afterlogin1').hide();
       	return false;
       }else{
       	event.preventDefault();           
       	document.getElementById("auth_code_login").style.borderColor = "#006600";
       	$.ajax({
       		url :ajaxUrl ,
       		type : 'post',
       		dataType: 'json',
       		data : {
       			action : 'check_auth_code_aftr_login',
       			auth_code : auth_code,
       			u_id      : u_id
       		},
       		beforeSend: function() 
       		{ 
       			$('#overlay-act-aftrlogin #dvLoading').show();            
       		},
       		success : function( response ) 
       		{
       			if(response == 1)
       			{
       				$('.auth-success-aftrlogin').show();
       				$('.auth-error-afterlogin1').hide();
       				$('.auth-error-aftrlogin').hide(); 
       				$('#overlay-act-aftrlogin #dvLoading').hide(); 

              // Hide it after 5 seconds
              setTimeout(function()
              {
              	$.LoadingOverlay("show", {
              		image       : "",
              		fontawesome : "fas fa-spinner fa-spin"
              	});
              	window.location.href = user_url;
                //$.LoadingOverlay("hide");

            }, 3000);
          }
          else
          {
                //alert('Auth Code Did not match!');
                $('.auth-error-afterlogin1').show();

                $('.auth-error-aftrlogin').hide();

                $('.auth-success-aftrlogin').hide();

                $('.alert-info').hide();

                $('#overlay-act-aftrlogin #dvLoading').hide();  
            }              
        }
    });
       }
   }); 

//***************Authenticate User After Login End here*********************//


//$(document).ready(function(){

	$("#myModal").appendTo("body");
	$("#myModal2").appendTo("body");
	$("#myModal12").appendTo("body");
	
	$("#search-id").keyup(function(){

		var cate_name = $("#search-id").val();
		var url = window.location.origin;
		var admin_url ="/rif-admin/admin-ajax.php";
		var ajaxUrl = url+admin_url;
		if(cate_name != "")
		{
			$.ajax({
				url : ajaxUrl,
				type : 'post',
				data : {
					action : 'search_post_data',
					cate_names : cate_name
				},

				beforeSend: function() 
				{
					$('.hide-spin').hide();
					$('.show-spin').show();                           
				},

				success : function( response ) 
				{ 
					if (response == 1) {
						$(".fs-error-fund").show();
						$(".ballon").hide();						
					}
					else {
						$('.show-spin').hide();
						$("#cat_shows_result").html(response);
						$("#cat_shows_result").addClass("get_data");
						$("#cat_shows_result").show();
						$('.hide-spin').show();
					}
				}
			});
		}
		else
		{
			$("#cat_shows_result").hide();
		}
	});



// search for fundraiser page start here 


// search by category

$("#new_select_category").change(function(){

	var url = window.location.origin;
	var admin_url ="/rif-admin/admin-ajax.php";
	var ajaxUrl = url+admin_url;
	var select_cat = $("#new_select_category").val();

	if(select_cat == "")
	{
		$(".all-campaign-list").show();
		$(".category-filter-fund-post").hide();
		$(".location-filter-fund-post").hide();
		$(".fs-error-fund-cat").hide();
		$(".fs-error-fund-part").hide();
			//$(".clear-search").hide();


			//var get_fund_s_cat = $("#new_select_category").val();
			var get_fund_select_loction = $("#select_loction").val();
			var get_fund_most_funded = $("#most_funded").val();
			var search_name = $('#fund_serach_by_name').val();


			if(search_name=='' && get_fund_select_loction=='' && get_fund_most_funded=='')
			{
				$(".clear-search").hide();
			}
			else
			{
				$(".clear-search").show();
			}

		}
		else
		{
			$.ajax({
				url : ajaxUrl,
				type : 'post',
				data : {
					action : 'fundpost_filter_by_category',
					select_cats : select_cat

				},

				beforeSend: function() 
				{
					$('.campaigns-overley').show();                          
				},

				success : function( response ) 
				{
					if(response == 1)
					{
						$(".fs-error-fund-cat").show();
						$(".fs-error-fund-part").hide();
						$(".ballon").hide();
						$(".all-campaign-list").hide();
						$(".fundname-filter-fund-post").hide();
						$(".location-filter-fund-post").hide();
						$(".category-filter-fund-post").hide();
						$(".get_current_fund_campaign").hide();
						$(".location-most-fund-post").hide();
						$('.campaigns-overley').hide();
						$(".clear-search").show();  
						$(".fs-error-fund-part").hide();    
					}
					else
					{
					//alert(response);
					$(".all-campaign-list").hide();
					$(".fs-error-fund-cat").hide();
					$(".ballon").show();
					$(".category-filter-fund-post").html(response);
					$(".category-filter-fund-post").show();
					$(".location-filter-fund-post").hide();
					$(".fundname-filter-fund-post").hide();
					$(".get_current_fund_campaign").hide();
					$('.campaigns-overley').hide();  
					$(".clear-search").show();   
					$(".fs-error-fund-part").hide();  
					$('#fund_scroll_event').val("fund_by_cate"); 
					}
			}
		});
		}
	});

//  search by category for mobile

$("#mob_new_select_category").change(function(){

	var url = window.location.origin;
	var admin_url ="/rif-admin/admin-ajax.php";
	var ajaxUrl = url+admin_url;
	var select_cat_mob = $("#mob_new_select_category").val();

	if(select_cat_mob == "")
	{
		$(".all-campaign-list").show();
		$(".category-filter-fund-post").hide();
		$(".location-filter-fund-post").hide();
		$(".fs-error-fund-cat").hide();
		$(".fs-error-fund-part").hide();
		//$(".clear-search").hide();


		//var select_cat_mob = $("#mob_new_select_category").val();
		var search_name_mob = $('#mob_fund_serach_by_name').val();
		var select_ret_id_mob = $("#mob_select_loction").val();
		var select_fund_mob = $("#mob_most_funded").val();

		if ( search_name_mob == "" && select_ret_id_mob == "" && select_fund_mob == "" ) {
			$(".clear-search").hide();
		} else {
			$(".clear-search").show();
		}

	}
	else
	{
		$.ajax({
			url : ajaxUrl,
			type : 'post',
			data : {
				action : 'fundpost_filter_by_category',
				select_cats : select_cat_mob

			},

			beforeSend: function() 
			{
				$('.campaigns-overley').show();                          
			},

			success : function( response ) 
			{
				if(response == 1)
				{
					$(".fs-error-fund-cat").show();
					$(".fs-error-fund-part").hide();
					$(".ballon").hide();
					$(".all-campaign-list").hide();
					$(".fundname-filter-fund-post").hide();
					$(".location-filter-fund-post").hide();
					$(".category-filter-fund-post").hide();
					$(".get_current_fund_campaign").hide();
					$(".location-most-fund-post").hide();
					$('.campaigns-overley').hide();
					$(".clear-search").show();  
					$(".fs-error-fund-part").hide();    
				}
				else
				{
				//alert(response);
				$(".all-campaign-list").hide();
				$(".fs-error-fund-cat").hide();
				$(".ballon").show();
				$(".category-filter-fund-post").html(response);
				$(".category-filter-fund-post").show();
				$(".location-filter-fund-post").hide();
				$(".fundname-filter-fund-post").hide();
				$(".get_current_fund_campaign").hide();
				$('.campaigns-overley').hide();  
				$(".clear-search").show();   
				$(".fs-error-fund-part").hide();  
				$('#fund_scroll_event').val("fund_by_cate"); 
								
				}
		}
	});
	}
});



//search by name  

$('#fund_serach_by_name').keyup(function()
{
	var search_name = $('#fund_serach_by_name').val();
	var url = window.location.origin;
	var admin_url ="/rif-admin/admin-ajax.php";
	var ajaxUrl = url+admin_url;

	if(search_name != '')
	{
		$.ajax({
			url : ajaxUrl,
			type : 'post',
			data : {
				action : 'fundpost_filter_by_fun_name',
				search_names : search_name
			},

			beforeSend: function() 
			{
				$('.after-spin').show();    
				$('.before-spin').hide();                         
			},
			success : function( response ) 
			{
				if(response == 1)
				{
					$(".fs-error-fund").show();
					$(".ballon").hide();
					$(".all-campaign-list").hide();
					$(".get_current_fund_campaign").hide();
					$('.after-spin').hide();    
					$('.before-spin').show();  
					$(".clear-search").show();
				}
				else
				{
					//alert(response);
					$(".clear-search").show();
					$(".all-campaign-list").hide();
					$(".fundname-filter-fund-post").show();
					$(".fs-error-fund").hide();
					$(".ballon").show();
					$(".fundname-filter-fund-post").html(response);
					$(".category-filter-fund-post").hide();
					$(".location-filter-fund-post").hide();
					$(".get_current_fund_campaign").hide();
					//$('.campaigns-overley').hide(); 
					$('.after-spin').hide();    
					$('.before-spin').show();  
					$('#fund_scroll_event').val("fundsearch_by_name"); 	
				}
			}
		});
	}
	else
	{
		var get_fund_s_cat = $("#new_select_category").val();
		var get_fund_select_loction = $("#select_loction").val();
		var get_fund_most_funded = $("#most_funded").val();
		$(".all-campaign-list").show();
		$(".ballon").show();
		$(".fundname-filter-fund-post").hide();
		$(".fs-error-fund").hide();
		$(".category-filter-fund-post").hide();
		$(".location-filter-fund-post").hide();
		//$(".clear-search").hide();
		$('.after-spin').hide();    
		$('.before-spin').show(); 

		if(get_fund_s_cat=='' && get_fund_select_loction=='' && get_fund_most_funded=='')
		{
			$(".clear-search").hide();
		}
		else
		{
			$(".clear-search").show();
		}

	}
});

// search by name for mobile =================

$('#mob_fund_serach_by_name').keyup(function()
{
	var search_name_mob = $('#mob_fund_serach_by_name').val();
	var url = window.location.origin;
	var admin_url ="/rif-admin/admin-ajax.php";
	var ajaxUrl = url+admin_url;

	if(search_name_mob != '')
	{
		$.ajax({
			url : ajaxUrl,
			type : 'post',
			data : {
				action : 'fundpost_filter_by_fun_name',
				search_names : search_name_mob
			},

			beforeSend: function() 
			{
				$('.after-spin').show();    
				$('.before-spin').hide();                         
			},
			success : function( response ) 
			{
				if(response == 1)
				{
					$(".fs-error-fund").show();
					$(".ballon").hide();
					$(".all-campaign-list").hide();
					$(".get_current_fund_campaign").hide();
					$('.after-spin').hide();    
					$('.before-spin').show();  
					$(".clear-search").show();
				}
				else
				{
					//alert(response);
					$(".clear-search").show();
					$(".all-campaign-list").hide();
					$(".fundname-filter-fund-post").show();
					$(".fs-error-fund").hide();
					$(".ballon").show();
					$(".fundname-filter-fund-post").html(response);
					$(".category-filter-fund-post").hide();
					$(".location-filter-fund-post").hide();
					$(".get_current_fund_campaign").hide();
					//$('.campaigns-overley').hide(); 
					$('.after-spin').hide();    
					$('.before-spin').show();  
					$('#fund_scroll_event').val("fundsearch_by_name"); 	
				}
			}
		});
	}
	else
	{
		$(".all-campaign-list").show();
		$(".ballon").show();
		$(".fundname-filter-fund-post").hide();
		$(".fs-error-fund").hide();
		$(".category-filter-fund-post").hide();
		$(".location-filter-fund-post").hide();
		//$(".clear-search").hide();
		$('.after-spin').hide();    
		$('.before-spin').show(); 



		var select_cat_mob = $("#mob_new_select_category").val();
		//var search_name_mob = $('#mob_fund_serach_by_name').val();
		var select_ret_id_mob = $("#mob_select_loction").val();
		var select_fund_mob = $("#mob_most_funded").val();

		if ( select_cat_mob == "" && select_ret_id_mob == "" && select_fund_mob == "" ) {
			$(".clear-search").hide();
		} else {
			$(".clear-search").show();
		}

	}
});


//search by partner

$("#select_loction").keyup(function(){

	var select_ret_id = $("#select_loction").val();
	var url = window.location.origin;
	var admin_url ="/rif-admin/admin-ajax.php";
	var ajaxUrl = url+admin_url;



	if(select_ret_id == "")
	{
		$(".all-campaign-list").show();
		$(".category-filter-fund-post").hide();
		$(".location-filter-fund-post").hide();
		$(".fundname-filter-fund-post").hide();
		$(".fs-error-fund-part").hide();
		$(".fs-error-fund-cat").hide();
		//$(".clear-search").hide();


		var get_fund_s_cat = $("#new_select_category").val();
		//var get_fund_select_loction = $("#select_loction").val();
		var get_fund_most_funded = $("#most_funded").val();
		var search_name = $('#fund_serach_by_name').val();


		if(search_name=='' && get_fund_s_cat=='' && get_fund_most_funded=='')
		{
			$(".clear-search").hide();
		}
		else
		{
			$(".clear-search").show();
		}

	}
	else
	{
		$.ajax({
			url : ajaxUrl,
			type : 'post',
			data : {
				action : 'fundpost_filter_by_loaction',
				select_ret_ids : select_ret_id

			},

			beforeSend: function() 
			{
					$(".before-srch").hide();
					$('.after-srch').show();                          
			},

			success : function( response ) 
			{
				if(response == 1)
				{
					$(".fs-error-fund-part").show();
					$(".fs-error-fund-cat").hide();
					$(".ballon").hide();
					$(".all-campaign-list").hide();
					$(".category-filter-fund-post").hide();
					$(".fundname-filter-fund-post").hide();
					$(".location-filter-fund-post").hide();
					$(".get_current_fund_campaign").hide();	
					$(".location-most-fund-post").hide();	
					$(".before-srch").show();
					$('.after-srch').hide(); 
					$(".clear-search").show();			
				}
				else
				{
					//alert(response);
					$(".all-campaign-list").hide();
					$(".fs-error-fund-part").hide();
					$(".ballon").show();
					$(".location-filter-fund-post").html(response);
					$(".location-filter-fund-post").show();
					$(".category-filter-fund-post").hide();
					$(".fundname-filter-fund-post").hide();
					$(".get_current_fund_campaign").hide();
					$(".before-srch").show();
					$('.after-srch').hide();  
					$(".clear-search").show();
					$('#fund_scroll_event').val("fundsearch_by_zip");
				}
			}
		});
	}
});

//search by partner for mobile

$("#mob_select_loction").change(function(){

	var select_ret_id_mob = $("#mob_select_loction").val();
	var url = window.location.origin;
	var admin_url ="/rif-admin/admin-ajax.php";
	var ajaxUrl = url+admin_url;



	if(select_ret_id_mob == "")
	{
		$(".all-campaign-list").show();
		$(".category-filter-fund-post").hide();
		$(".location-filter-fund-post").hide();
		$(".fundname-filter-fund-post").hide();
		$(".fs-error-fund-part").hide();
		$(".fs-error-fund-cat").hide();
		//$(".clear-search").hide();


		var select_cat_mob = $("#mob_new_select_category").val();
		var search_name_mob = $('#mob_fund_serach_by_name').val();
		//var select_ret_id_mob = $("#mob_select_loction").val();
		var select_fund_mob = $("#mob_most_funded").val();

		if ( select_cat_mob == "" && search_name_mob == "" && select_fund_mob == "" ) {
			$(".clear-search").hide();
		} else {
			$(".clear-search").show();
		}

	}
	else
	{
		$.ajax({
			url : ajaxUrl,
			type : 'post',
			data : {
				action : 'fundpost_filter_by_loaction',
				select_ret_ids : select_ret_id_mob

			},

			beforeSend: function() 
			{
				$('.campaigns-overley').show();                          
			},

			success : function( response ) 
			{
				if(response == 1)
				{
					$(".fs-error-fund-part").show();
					$(".fs-error-fund-cat").hide();
					$(".ballon").hide();
					$(".all-campaign-list").hide();
					$(".category-filter-fund-post").hide();
					$(".fundname-filter-fund-post").hide();
					$(".location-filter-fund-post").hide();
					$(".get_current_fund_campaign").hide();	
					$(".location-most-fund-post").hide();	
					$('.campaigns-overley').hide();  
					$(".clear-search").show();			
				}
				else
				{
					//alert(response);
					$(".all-campaign-list").hide();
					$(".fs-error-fund-part").hide();
					$(".ballon").show();
					$(".location-filter-fund-post").html(response);
					$(".location-filter-fund-post").show();
					$(".category-filter-fund-post").hide();
					$(".fundname-filter-fund-post").hide();
					$(".get_current_fund_campaign").hide();
					$('.campaigns-overley').hide();  
					$(".clear-search").show();
					$('#fund_scroll_event').val("fundsearch_by_zip");
				}
			}
		});
	}
});


//  search by most funded

$("#most_funded").change(function()
{
	var url = window.location.origin;
	var admin_url ="/rif-admin/admin-ajax.php";
	var ajaxUrl = url+admin_url;

	var select_cat = $("#most_funded").val();

	if(select_cat == "")
	{
		$(".all-campaign-list").show();
		$(".category-filter-fund-post").hide();
		$(".location-filter-fund-post").hide();
		$(".location-most-fund-post").hide();
		$(".fs-error-fund-part").hide();
		//$(".clear-search").hide();


		var get_fund_s_cat = $("#new_select_category").val();
		var get_fund_select_loction = $("#select_loction").val();
		//var get_fund_most_funded = $("#most_funded").val();
		var search_name = $('#fund_serach_by_name').val();


		if(search_name=='' && get_fund_s_cat=='' && get_fund_select_loction=='')
		{
			$(".clear-search").hide();
		}
		else
		{
			$(".clear-search").show();
		}

	}
	else
	{
		$.ajax({
			url : ajaxUrl,
			type : 'post',
			data : {
				action : 'fundpost_filter_by_most_funded'
			},
			beforeSend: function() 
			{
				$('.campaigns-overley').show();                          
			},

			success : function( response ) 
			{

				$(".all-campaign-list").hide();
				$(".fs-error-fund").hide();
				$(".ballon").show();
				$(".location-most-fund-post").html(response);
				$(".category-filter-fund-post").hide();
				$(".location-filter-fund-post").hide();
				$(".fundname-filter-fund-post").hide();	
				$(".location-most-fund-post").show();	
				$(".get_current_fund_campaign").hide();
				$('.campaigns-overley').hide();
				$(".clear-search").show(); 
				$('#fund_scroll_event').val("mostfund");
			}
		});	
	}
});


//  search by most funded for mobile

$("#mob_most_funded").change(function()
{
	var url = window.location.origin;
	var admin_url ="/rif-admin/admin-ajax.php";
	var ajaxUrl = url+admin_url;

	var select_cat_mob = $("#mob_most_funded").val();

	if(select_cat_mob == "")
	{
		$(".all-campaign-list").show();
		$(".category-filter-fund-post").hide();
		$(".location-filter-fund-post").hide();
		$(".location-most-fund-post").hide();
		$(".fs-error-fund-part").hide();
		//$(".clear-search").hide();

		var select_cat_mob = $("#mob_new_select_category").val();
		var search_name_mob = $('#mob_fund_serach_by_name').val();
		var select_ret_id_mob = $("#mob_select_loction").val();
		//var select_fund_mob = $("#mob_most_funded").val();

		if ( select_cat_mob == "" && search_name_mob == "" && select_ret_id_mob == "" ) {
			$(".clear-search").hide();
		} else {
			$(".clear-search").show();
		}
	}
	else
	{
		$.ajax({
			url : ajaxUrl,
			type : 'post',
			data : {
				action : 'fundpost_filter_by_most_funded'
			},
			beforeSend: function() 
			{
				$('.campaigns-overley').show();                          
			},

			success : function( response ) 
			{

				$(".all-campaign-list").hide();
				$(".fs-error-fund").hide();
				$(".ballon").show();
				$(".location-most-fund-post").html(response);
				$(".category-filter-fund-post").hide();
				$(".location-filter-fund-post").hide();
				$(".fundname-filter-fund-post").hide();	
				$(".location-most-fund-post").show();	
				$(".get_current_fund_campaign").hide();
				$('.campaigns-overley').hide();
				$(".clear-search").show(); 
				$('#fund_scroll_event').val("mostfund");
				
			}
		});	
	}
});


// search for reatiler

$('#ret_search_by_name').keyup(function()
{
	var search_name_ret = $('#ret_search_by_name').val();
	var url = window.location.origin;
	var admin_url ="/rif-admin/admin-ajax.php";
	var ajaxUrl = url+admin_url;

	if(search_name_ret != '')
	{
		$.ajax({
			url : ajaxUrl,
			type : 'post',
			data : {
				action : 'retpost_filter_by_name',
				ret_search_names : search_name_ret
			},

			beforeSend: function() 
			{
				$('.after-spin').show();    
				$('.before-spin').hide();                         
			},
			success : function( response ) 
			{
				if(response == 1)
				{
					$(".fs-error-fund").show();
					$(".ballon").hide();
					$(".all_fund_data").hide();
					$(".get_current_fund_campaign").hide();
					$('.after-spin').hide();    
					$('.before-spin').show();  
					$(".clear-search-reat").show();
				}
				else
				{
					//alert(response);
					$(".clear-search-reat").show();
					$(".all_fund_data").hide();
					$(".name-filter-ret-post").show();
					$(".fs-error-fund").hide();
					$(".ballon").show();
					$(".name-filter-ret-post").html(response);
					$(".zipcode-filter-ret-post").hide();
					$(".city-filter-ret-post").hide();
					$(".get_current_fund_campaign").hide();
					$('.after-spin').hide();    
					$('.before-spin').show();  
					$('#scroll_event').val("search_by_name");  

					
				}
			}
		});
	}
	else
	{
		$(".all_fund_data").show();
		$(".name-filter-ret-post").hide();
		$(".fs-error-fund").hide();
		$(".zipcode-filter-ret-post").hide();
		$(".city-filter-ret-post").hide();
		$('.after-spin').hide();    
		$('.before-spin').show(); 

		var get_ret_search_by_zipcode = $("#ret_search_by_zipcode").val();
		var get_ret_search_by_city = $("#ret_search_by_city").val();

		if(get_ret_search_by_zipcode =='' && get_ret_search_by_city == '')
		{
			$(".clear-search-reat").hide();
		}
		else
		{
			$(".clear-search-reat").show();
		}

	}
});

// mobile search by city 

$('#mob_ret_search_by_name').keyup(function()
{
	var search_name_ret = $('#mob_ret_search_by_name').val();
	var url = window.location.origin;
	var admin_url ="/rif-admin/admin-ajax.php";
	var ajaxUrl = url+admin_url;

	if(search_name_ret != '')
	{
		$.ajax({
			url : ajaxUrl,
			type : 'post',
			data : {
				action : 'retpost_filter_by_name',
				ret_search_names : search_name_ret
			},

			beforeSend: function() 
			{
				$('.after-spin').show();    
				$('.before-spin').hide();                         
			},
			success : function( response ) 
			{
				if(response == 1)
				{
					$(".fs-error-fund").show();
					$(".ballon").hide();
					$(".all_fund_data").hide();
					$(".get_current_fund_campaign").hide();
					$('.after-spin').hide();    
					$('.before-spin').show();  
					$(".clear-search-reat").show();
				}
				else
				{
					//alert(response);
					$(".clear-search-reat").show();
					$(".all_fund_data").hide();
					$(".name-filter-ret-post").show();
					$(".fs-error-fund").hide();
					$(".ballon").show();
					$(".name-filter-ret-post").html(response);
					$(".zipcode-filter-ret-post").hide();
					$(".city-filter-ret-post").hide();
					$(".get_current_fund_campaign").hide();
					$('.after-spin').hide();    
					$('.before-spin').show();  
					$('#scroll_event').val("search_by_name");
					
				}
			}
		});
	}
	else
	{
		$(".all_fund_data").show();
		$(".name-filter-ret-post").hide();
		$(".fs-error-fund").hide();
		$(".zipcode-filter-ret-post").hide();
		$(".city-filter-ret-post").hide();
		$('.after-spin').hide();    
		$('.before-spin').show(); 

		var get_ret_search_by_zipcode = $("#mob_ret_search_by_zipcode").val();
		var get_ret_search_by_city = $("#mob_ret_search_by_city").val();

		if(get_ret_search_by_zipcode =='' && get_ret_search_by_city == '')
		{
			$(".clear-search-reat").hide();
		}
		else
		{
			$(".clear-search-reat").show();
		}

	}
});


//retailer search by zipcode
$('#ret_search_by_zipcode').keyup(function()
{
	var search_zipcode_ret = $('#ret_search_by_zipcode').val();
	var url1 = window.location.origin;
	var admin_url1 ="/rif-admin/admin-ajax.php";
	var ajaxUrl1 = url1+admin_url1;
	var min_leng = 1;

	if(search_zipcode_ret.length >= min_leng)
	{
		$.ajax({
			url : ajaxUrl1,
			type : 'post',
			data : {
				action : 'retpost_filter_by_zipcode',
				ret_search_zipcodes : search_zipcode_ret
			},

			beforeSend: function() 
			{
				$('.after-spin-zip').show();    
				$('.before-spin-zip').hide();                         
			},
			success : function( response ) 
			{
				if(response == 1)
				{
					$(".fs-error-fund").show();
					$(".ballon").hide();
					$(".all_fund_data").hide();
					$(".get_current_fund_campaign").hide();
					$('.after-spin-zip').hide();    
					$('.before-spin-zip').show();  
					$(".clear-search-reat").show();
				}
				else
				{
					//alert(response);
					$(".clear-search-reat").show();
					$(".all_fund_data").hide();
					$(".zipcode-filter-ret-post").show();
					$(".fs-error-fund").hide();
					$(".ballon").show();
					$(".zipcode-filter-ret-post").html(response);
					$(".name-filter-ret-post").hide();
					$(".city-filter-ret-post").hide();
					$(".get_current_fund_campaign").hide();
					//$('.campaigns-overley').hide(); 
					$('.after-spin-zip').hide();    
					$('.before-spin-zip').show();  
					$('#scroll_event').val("search_by_zip");
					
				}

			}
		});
	}
	else
	{
		$(".all_fund_data").show();
		$(".name-filter-ret-post").hide();
		$(".fs-error-fund").hide();
		$(".zipcode-filter-ret-post").hide();
		$(".city-filter-ret-post").hide();
		$('.after-spin-zip').hide();    
		$('.before-spin-zip').show();

		var get_ret_search_by_name = $("#ret_search_by_name").val();
		var get_ret_search_by_city = $("#ret_search_by_city").val();

		if(get_ret_search_by_name =='' && get_ret_search_by_city == '')
		{
			$(".clear-search-reat").hide();
		}
		else
		{
			$(".clear-search-reat").show();
		}


	}
});


//search reatiler mobile zipcode

$('#mob_ret_search_by_zipcode').keyup(function()
{
	var search_zipcode_ret = $('#mob_ret_search_by_zipcode').val();
	var url1 = window.location.origin;
	var admin_url1 ="/rif-admin/admin-ajax.php";
	var ajaxUrl1 = url1+admin_url1;
	var min_leng = 1;

	if(search_zipcode_ret.length >= min_leng)
	{
		$.ajax({
			url : ajaxUrl1,
			type : 'post',
			data : {
				action : 'retpost_filter_by_zipcode',
				ret_search_zipcodes : search_zipcode_ret
			},

			beforeSend: function() 
			{
				$('.after-spin-zip').show();    
				$('.before-spin-zip').hide();                         
			},
			success : function( response ) 
			{
				if(response == 1)
				{
					$(".fs-error-fund").show();
					$(".ballon").hide();
					$(".all_fund_data").hide();
					$(".get_current_fund_campaign").hide();
					$('.after-spin-zip').hide();    
					$('.before-spin-zip').show();  
					$(".clear-search-reat").show();
				}
				else
				{
					//alert(response);
					$(".clear-search-reat").show();
					$(".all_fund_data").hide();
					$(".zipcode-filter-ret-post").show();
					$(".fs-error-fund").hide();
					$(".ballon").show();
					$(".zipcode-filter-ret-post").html(response);
					$(".name-filter-ret-post").hide();
					$(".city-filter-ret-post").hide();
					$(".get_current_fund_campaign").hide();
					//$('.campaigns-overley').hide(); 
					$('.after-spin-zip').hide();    
					$('.before-spin-zip').show();  
					$('#scroll_event').val("search_by_zip");
					
				}

			}
		});
	}
	else
	{
		$(".all_fund_data").show();
		$(".name-filter-ret-post").hide();
		$(".fs-error-fund").hide();
		$(".zipcode-filter-ret-post").hide();
		$(".city-filter-ret-post").hide();
		$('.after-spin-zip').hide();    
		$('.before-spin-zip').show();

		var get_ret_search_by_name = $("#mob_ret_search_by_name").val();
		var get_ret_search_by_city = $("#mob_ret_search_by_city").val();

		if(get_ret_search_by_name =='' && get_ret_search_by_city == '')
		{
			$(".clear-search-reat").hide();
		}
		else
		{
			$(".clear-search-reat").show();
		}


	}
});


//retailer search by city

$('#ret_search_by_city').keyup(function()
{
	var search_city_ret = $('#ret_search_by_city').val();
	var url2 = window.location.origin;
	var admin_url2 ="/rif-admin/admin-ajax.php";
	var ajaxUrl2 = url2+admin_url2;
	//var min_leng = 5;

	if(search_city_ret != '')
	{
		$.ajax({
			url : ajaxUrl2,
			type : 'post',
			data : {
				action : 'retpost_filter_by_city',
				search_city_ret : search_city_ret
			},

			beforeSend: function() 
			{
				$('.after-spin-city').show();    
				$('.before-spin-city').hide();                         
			},
			success : function( response ) 
			{
				if(response == 1)
				{
					$(".fs-error-fund").show();
					$(".ballon").hide();
					$(".all_fund_data").hide();
					$(".get_current_fund_campaign").hide();
					$('.after-spin-city').hide();    
					$('.before-spin-city').show();  
					$(".clear-search-reat").show();
				}
				else
				{
					//alert(response);
					$(".clear-search-reat").show();
					$(".all_fund_data").hide();
					$(".city-filter-ret-post").show();
					$(".fs-error-fund").hide();
					$(".ballon").show();
					$(".city-filter-ret-post").html(response);
					$(".name-filter-ret-post").hide();
					$(".zipcode-filter-ret-post").hide();
					$(".get_current_fund_campaign").hide();
					$('.after-spin-city').hide();    
					$('.before-spin-city').show(); 
					$('#scroll_event').val("search_by_city");  					
			
				}

			}
		});
	}
	else
	{
		$(".all_fund_data").show();
		$(".name-filter-ret-post").hide();
		$(".fs-error-fund").hide();
		$(".zipcode-filter-ret-post").hide();
		$(".city-filter-ret-post").hide();
		$('.after-spin-city').hide();    
		$('.before-spin-city').show();

		var get_ret_search_by_name = $("#ret_search_by_name").val();
		var get_ret_search_by_zipcode = $("#ret_search_by_zipcode").val();

		if(get_ret_search_by_name =='' && get_ret_search_by_zipcode == '')
		{
			$(".clear-search-reat").hide();
		}
		else
		{
			$(".clear-search-reat").show();
		}

	}
});


//retailer search by mobile city

$('#mob_ret_search_by_city').keyup(function()
{
	var search_city_ret = $('#mob_ret_search_by_city').val();
	var url2 = window.location.origin;
	var admin_url2 ="/rif-admin/admin-ajax.php";
	var ajaxUrl2 = url2+admin_url2;
	//var min_leng = 5;

	if(search_city_ret != '')
	{
		$.ajax({
			url : ajaxUrl2,
			type : 'post',
			data : {
				action : 'retpost_filter_by_city',
				search_city_ret : search_city_ret
			},

			beforeSend: function() 
			{
				$('.after-spin-city').show();    
				$('.before-spin-city').hide();                         
			},
			success : function( response ) 
			{
				if(response == 1)
				{
					$(".fs-error-fund").show();
					$(".ballon").hide();
					$(".all_fund_data").hide();
					$(".get_current_fund_campaign").hide();
					$('.after-spin-city').hide();    
					$('.before-spin-city').show();  
					$(".clear-search-reat").show();
				}
				else
				{
					//alert(response);
					$(".clear-search-reat").show();
					$(".all_fund_data").hide();
					$(".city-filter-ret-post").show();
					$(".fs-error-fund").hide();
					$(".ballon").show();
					$(".city-filter-ret-post").html(response);
					$(".name-filter-ret-post").hide();
					$(".zipcode-filter-ret-post").hide();
					$(".get_current_fund_campaign").hide();
					//$('.campaigns-overley').hide(); 
					$('.after-spin-city').hide();    
					$('.before-spin-city').show();  
					$('#scroll_event').val("search_by_city"); 
					
				}

			}
		});
	}
	else
	{
		$(".all_fund_data").show();
		$(".name-filter-ret-post").hide();
		$(".fs-error-fund").hide();
		$(".zipcode-filter-ret-post").hide();
		$(".city-filter-ret-post").hide();
		$('.after-spin-city').hide();    
		$('.before-spin-city').show();

		var get_ret_search_by_name = $("#mob_ret_search_by_name").val();
		var get_ret_search_by_zipcode = $("#mob_ret_search_by_zipcode").val();

		if(get_ret_search_by_name =='' && get_ret_search_by_zipcode == '')
		{
			$(".clear-search-reat").hide();
		}
		else
		{
			$(".clear-search-reat").show();
		}

	}
});


//  search for fundraiser page ends here

var business_minlength = 5;
$('#search-input_1').keyup(function(){

	var zip_code = $('#search-input_1').val();
	var url = window.location.origin;
	var admin_url ="/rif-admin/admin-ajax.php";
	var ajaxUrl = url+admin_url;


	$("#search #input-loder").show();
	if (zip_code.length >= business_minlength   ) 
	{		
		$.ajax({
			url :ajaxUrl,
			type : 'post',
			dataType: 'html',
			data : {
				action : 'author_search_retaile',
				zip_codes : zip_code  
			},
			beforeSend: function() 
			{
				jQuery('.search_height #dvLoading').show();    
			},
			success : function( response ) 
			{
			//alert(response);
			$(".new_class #show_results").html(response); 
			$(".search_height").addClass("fieldset_44");
			$(".search_height #dvLoading").hide();

		}
	});		
	}
});

function close_accordion_section() {
	$('.accordions .accordion-section-title').removeClass('active');
	$('.accordions .accordion-section-content').slideUp(300).removeClass('open');
}

$('.accordion-section-title').click(function(e) {
// Grab current anchor value
var currentAttrValue = $(this).attr('href');

if($(e.target).is('.active')) 
{
	close_accordion_section();
}else {
	close_accordion_section();

  // Add active class to section title
  $(this).addClass('active');
  // Open up the hidden content panel
  $('.accordions ' + currentAttrValue).slideDown(300).addClass('open'); 
}
e.preventDefault();
});

$(window).on('load', function () {
	jQuery(".myevent .dropdown-menuw.nested_events li a").filter(function(){
		return this.href == location.href.replace(/#.*/, "");
	}).parent().addClass("active");
	if (jQuery('.myevent .dropdown-menuw.nested_events li ').hasClass('active')) {   
		$(".myevent .nested_events").css("display","block"); 
		$(".myevent .bell-remove").css("display","none");
	}
	jQuery(".myevents .dropdown-menuw.nested_events li a").filter(function(){
		return this.href == location.href.replace(/#.*/, "");
	}).parent().addClass("active");
	if (jQuery('.myevents .dropdown-menuw.nested_events li ').hasClass('active')) {  
		$(".myevents .nested_events").css("display","block");
		$(".myevents .bell-remove").css("display","none");

	}
	jQuery(".hide a").filter(function(){
		return this.href == location.href.replace(/#.*/, "");
	}).parent().addClass("active");
	if (jQuery('.hide ').hasClass('active')) {  
		$(".hide").css("display","block"); 
	}
	$(".accordion-section .accordion-section-content").css("display","none"); 
});

$('input[name="status"]').change(function()
{
	if($(this).is(':checked') && $(this).val() == 'disapprove') 
	{
		$('#edit').modal('show');
		var chnage_time_req    = $(this).val();
		var email = $(this).attr("data-email");
		var e_id = $(this).attr("data-id");
		var r_id = $(this).attr("data-rid");
		var e_title = $(this).attr("data-title");
		var f_auth_name = $(this).attr("data-fauthname");

		$('#email').val(email);
		$('#e_id').val(e_id);
		$('#r_id').val(r_id);
		$('#e_title').val(e_title);
		$('#f_auth_name').val(f_auth_name);
		$('#chnage_time_req').val(chnage_time_req);
		$("td span").removeClass('myvalue');
		$(this).closest('td').next('td').find('span').addClass('myvalue');
	}
	else if($(this).is(':checked') && $(this).val() == 'approve') 
	{
		$('#accept_deny').modal('show');
		var appr_val    = $(this).val();
		var rid_new     = $(this).attr("data-rid_new");
		var f_id_new    = $(this).attr("data-f_id_new");
		var f_email_new = $(this).attr("data-f_email_new");
		var f_title_new = $(this).attr("data-f_title_new");
		var f_auth_name_new = $(this).attr("f_auth_name_new");

		$('#accept_deny #get_reat_id').val(rid_new);
		$('#accept_deny #get_fund_id').val(f_id_new);
		$('#rid_new').val(rid_new);
		$('#f_id_new').val(f_id_new);
		$('#f_email_new').val(f_email_new);
		$('#f_title_new').val(f_title_new);
		$('#f_auth_name_new').val(f_auth_name_new);
		$('#app_disapp_val').val(appr_val);
		$("td span").removeClass('myvalue');
		$(this).closest('td').next('td').find('span').addClass('myvalue');
		$(this).closest('td').next('td').next('td').find('input.approve_disapprove').addClass('diiss');
	}
	else if($(this).is(':checked') && $(this).val() == 'disapp') 
	{
		$('#dissaproved_event').modal('show');

		var disapp_val   = $(this).val();
		var rid_new2     = $(this).attr("data-rid_new2");
		var f_id_new2    = $(this).attr("data-f_id_new");
		var f_email_new2 = $(this).attr("data-f_email_new");
		var f_title_new2 = $(this).attr("data-f_title_new");
		var f_auth_name_new2 = $(this).attr("f_auth_name_new");

		$('#rid_new').val(rid_new2);
		$('#f_id_new').val(f_id_new2);
		$('#f_email_new').val(f_email_new2);
		$('#f_title_new').val(f_title_new2);
		$('#f_auth_name_new').val(f_auth_name_new2);
		$('#app_disapp_val').val(disapp_val);
		$("td span").removeClass('myvalue');
		$(this).closest('td').next('td').find('span').addClass('myvalue');
	}

	var divid = $(this).closest("div").attr('id');
	$('#divid').val(divid);
});

$('input[name="min_discount"]').change(function() 
{
	if($(this).is(':checked') && $(this).val() == 'min_value_select') 
	{
		$('#select_min_discount').prop('disabled',false);
		$('.slide_toggle_div').slideToggle();
	}
	else
	{
		$('#select_min_discount').prop('disabled',true);
		$('.slide_toggle_div').slideToggle();
	}
});


function isNumber(evt) {
	evt = (evt) ? evt : window.event;
	var charCode = (evt.which) ? evt.which : evt.keyCode;
	if (charCode > 31 && (charCode < 48 || charCode > 57)) {
		return false;
	}
	return true;
}

//********************darkroom js for fundraiser image*******************//

$(document).ready(function(){
	$("#f_fund_images").on("change", function() {
		$("#upload-image-loder").show();
		$("[for=file]").html(this.files[0].name);
		$("#target_fund_img_new").attr("src", URL.createObjectURL(this.files[0]));

		var dkrm = new Darkroom('#target_fund_img_new', {

      // Plugins options
      plugins: {
        //save: false,
        crop: {
          quickCropKey: 67, //key "c"
          minHeight: 50,
          minWidth: 50,
          ratio: 4/3
      },
      save: {

      	callback: function() {
             this.darkroom.selfDestroy(); // Turn off the bar and cleanup
             var newImage = dkrm.canvas.toDataURL();
             $("#fund_image_new").val(newImage);
             $("#new_target_fund_img").attr("src", newImage);
             $( "#new_target_fund_img" ).addClass( "broder_show_cls" );
             $("#btn-example-file-reset").show();
             $("#add_event_fund_image").attr("src", newImage);
             $("#add_preview_image").show();
             $("#add_fundraiser_image").modal('hide');
         }
     },
 },
      // Post initialize script
      initialize: function() {
      	$("#upload-image-loder").hide();
      	var cropPlugin = this.plugins['crop'];
         //cropPlugin.selectZone(170, 25, 300, 300);
       // cropPlugin.requireFocus();
   }
});
	});
	$('#btn-example-file-reset').on('click', function(e) {
		$('#new_target_fund_img').attr('src', '');
		$( "#new_target_fund_img" ).removeClass( "broder_show_cls" );
		$('#btn-example-file-reset').hide();
		var $el = $('#f_fund_images');
		$el.wrap('<form>').closest('form').get(0).reset();
		$el.unwrap();
		return myFunction();
	});
	function myFunction() {
		var x = document.createElement("IMG");
		x.setAttribute("id", "target_fund_img_new");
		document.body.appendChild(x);
		document.getElementById('add_target').append(x);
	}  
}); 

// Business event image

$(document).ready(function(){

	$("#r_buis_image_1_new_1").on("change", function() {
		$(".upload-image-loders").show();
		$("[for=file]").html(this.files[0].name);
		$("#target_bus_img").attr("src", URL.createObjectURL(this.files[0]));
		var dkrm = new Darkroom('#target_bus_img', {

      // Plugins options
      plugins: {
        //save: false,
        crop: { 
          quickCropKey: 67, //key "c"
          minHeight: 50,
          minWidth: 50,
          ratio: 4/3
      },
      save: {
      	callback: function() {
               this.darkroom.selfDestroy(); // Turn off the bar and cleanup
               var newImage = dkrm.canvas.toDataURL();

               $("#ret_image").val(newImage);
               $("#new_target_bus_img").attr("src", newImage);
               $( "#new_target_bus_img" ).addClass( "broder_show_cls" );
               $("#btn-example-file-reset1").show();
               $("#add_event_bus_image").attr("src", newImage);
               $("#add_business_image").modal('hide');
               $("#add_bus_preview_image").show();
           }
       },
   },
      // Post initialize script
      initialize: function() {
      	$(".upload-image-loders").hide();
      	var cropPlugin = this.plugins['crop'];
         //cropPlugin.selectZone(170, 25, 300, 300);
       // cropPlugin.requireFocus();
   }
});
	});
	$('#btn-example-file-reset1').on('click', function(e) {
		$('#new_target_bus_img').attr('src', '');
		$( "#new_target_bus_img" ).removeClass( "broder_show_cls" );
		$('#btn-example-file-reset1').hide();
		var $el = $('#r_buis_image_1_new_1');
		$el.wrap('<form>').closest('form').get(0).reset();
		$el.unwrap();
		return myFunction_new();
	});
	function myFunction_new() {
		var xx = document.createElement("IMG");
		xx.setAttribute("id", "target_bus_img");
		document.body.appendChild(xx);
		document.getElementById('add_target1').append(xx);
	} 
}); 
//Business logo 
$(document).ready(function(){
	$("#r_buis_logo_image_new_1").on("change", function() {
		$(".upload-image-loders").show();
		$("[for=file]").html(this.files[0].name);
		$("#target_bus_logo").attr("src", URL.createObjectURL(this.files[0]));
		var dkrm = new Darkroom('#target_bus_logo', {

      // Plugins options
      plugins: {
        //save: false,
        crop: {
          quickCropKey: 67, //key "c"
          minHeight: 50,
          minWidth: 50,
          ratio: 4/3
      },
      save: {
      	callback: function() {
             this.darkroom.selfDestroy(); // Turn off the bar and cleanup
             var newImage = dkrm.canvas.toDataURL();
             $("#btn-example-file-reset2").show();
             $("#ret_logo").val(newImage);
             $("#new_target_logo").attr("src", newImage);
             $("#new_target_logo" ).addClass( "broder_show_cls" );
             jQuery("#add_event_bus_logo").attr("src", newImage);
             jQuery("#add_bus_preview_logo").show();
             jQuery("#add_business_logo").modal('hide');

         }
     },
 },
      // Post initialize script
      initialize: function() {
      	$(".upload-image-loders").hide();
      	var cropPlugin = this.plugins['crop'];
      }
  });
	});
	$('#btn-example-file-reset2').on('click', function(e) {
		$('#new_target_logo').attr('src', '');
		$("#new_target_logo" ).removeClass( "broder_show_cls" );
		$('#btn-example-file-reset2').hide();
		var $el = $('#r_buis_logo_image_new_1');
		$el.wrap('<form>').closest('form').get(0).reset();
		$el.unwrap();
		return myFunction_new1();

	});

	function myFunction_new1() {
		var x = document.createElement("IMG");
		x.setAttribute("id", "target_bus_logo");
		document.body.appendChild(x);
		document.getElementById('add_target2').append(x);
	} 

	$("#discount_text_coupen_10").keyup(function(){

		var text1 = $("#discount_text_coupen_10").val();
		document.getElementById('discount_selct_text_new').value = text1;
	});
	$("#discount_text_coupen_20").keyup(function(Text){
		var text2 = $("#discount_text_coupen_20").val();
		document.getElementById('discount_selct_text_new').value = text2;
	});
	$("#discount_text_coupen_30").keyup(function(Text){
		var text3 = $("#discount_text_coupen_30").val();
		document.getElementById('discount_selct_text_new').value = text3;
	});
	$("#discount_text_coupen_40").keyup(function(Text){
		var text4 = $("#discount_text_coupen_40").val();
		document.getElementById('discount_selct_text_new').value = text4;
	});
	$("#discount_text_coupen_50").keyup(function(Text){
		var text5 = $("#discount_text_coupen_50").val();
		document.getElementById('discount_selct_text_new').value = text5;
	});
	$("#free_coupen").keyup(function(Text){
		var text6 = $("#free_coupen").val();
		document.getElementById('discount_selct_text_new').value = text6;
	});
	$("#custom_coupen").keyup(function(Text){
		var text7 = $("#custom_coupen").val();
		document.getElementById('discount_selct_text_new').value = text7;
	});

	function makeid() {

		var text = "";

		var possible = "ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";

		for (var i = 0; i < 8; i++)

			text += possible.charAt(Math.floor(Math.random() * possible.length));
		return text;
	}

	var cc_10 =  $('#discount_text_coupen_10').val();

	var cc_20 =  $('#discount_text_coupen_20').val();

	var cc_30 =  $('#discount_text_coupen_30').val();

	var cc_40 =  $('#discount_text_coupen_40').val();

	var cc_50 =  $('#discount_text_coupen_50').val();

	var free_coupon  =  $('#free_coupen').val();

	var custom_coupen = $('#custom_coupen').val(); 

	if(cc_10=='')
	{
		$('#discount_text_coupen_10').prop('disabled',true);
	}else {

		$('#discount_text_coupen_10').prop('disabled',false);
	}

	if(cc_20=='')
	{
		$('#discount_text_coupen_20').prop('disabled',true);
	}else { 

		$('#discount_text_coupen_20').prop('disabled',false);
	}

	if(cc_30=='')
	{
		$('#discount_text_coupen_30').prop('disabled',true);

	}else{

		$('#discount_text_coupen_30').prop('disabled',false);
	} 

	if(cc_40=='')
	{
		$('#discount_text_coupen_40').prop('disabled',true);

	}else{

		$('#discount_text_coupen_40').prop('disabled',false);
	}

	if(cc_50=='')
	{
		$('#discount_text_coupen_50').prop('disabled',true);

	}else{

	}

	if(free_coupon=='')
	{
		$('#free_coupen').prop('disabled',true);
	}
	else{

		$('#free_coupen').prop('disabled',false);
	}

	if(custom_coupen=='')
	{
		$('#custom_coupen').prop('disabled',true);
	}
	else{

		$('#custom_coupen').prop('disabled',false);
	}

	$("input[name='discount']").on('change', function() {
		var codeVal = $('input[name=discount]:checked').val();

		if(codeVal) 
		{
			var cc = makeid();

			$('#coupen_code').val(cc);

			$('#coupen_code_new').val(cc);

			$('#discount_selct').val(codeVal);

			if(codeVal == 'coupen_10')
			{

      $('#discount_text_coupen_10').prop('disabled',false);
      $('#min_discount_10').prop('disabled',false);
      
      $('#min_discount_20').prop('disabled',true);
      $('#min_discount_30').prop('disabled',true);
      $('#min_discount_40').prop('disabled',true);
      $('#min_discount_50').prop('disabled',true);
      $('#min_discount_free').prop('disabled',true);
      $('#min_discount_custon').prop('disabled',true);
      document.getElementById('discount_selct_text_new').value = "";

      $('#tbd_coupen').prop('disabled',true);

      $('#discount_text_coupen_20').prop('disabled',true);

      $('#discount_text_coupen_30').prop('disabled',true);

      $('#discount_text_coupen_40').prop('disabled',true);

      $('#discount_text_coupen_50').prop('disabled',true);

      $('#free_coupen').prop('disabled',true);

      $('#custom_coupen').prop('disabled',true);

      $('#extra_benefit').prop('disabled',true);

      document.getElementById('discount_text_coupen_20').value = "";
      document.getElementById('discount_text_coupen_30').value = "";
      document.getElementById('discount_text_coupen_40').value = "";
      document.getElementById('discount_text_coupen_50').value = "";
      document.getElementById('free_coupen').value = "";
      document.getElementById('custom_coupen').value = "";
      $("#discount_text_coupen_10").focus();

  }

  else if(codeVal == 'coupen_20'){

  	$('#discount_text_coupen_20').prop('disabled',false);
  	$('#min_discount_20').prop('disabled',false);

  	$('#min_discount_10').prop('disabled',true);
  	$('#min_discount_30').prop('disabled',true);
  	$('#min_discount_40').prop('disabled',true);
  	$('#min_discount_50').prop('disabled',true);
  	$('#min_discount_free').prop('disabled',true);
  	$('#min_discount_custon').prop('disabled',true);
  	document.getElementById('discount_selct_text_new').value = "";

  	 $('#tbd_coupen').prop('disabled',true);

  	$('#discount_text_coupen_10').prop('disabled',true);

  	$('#discount_text_coupen_30').prop('disabled',true);

  	$('#discount_text_coupen_40').prop('disabled',true);

  	$('#discount_text_coupen_50').prop('disabled',true);

  	$('#free_coupen').prop('disabled',true);

  	$('#custom_coupen').prop('disabled',true);

  	$('#extra_benefit').prop('disabled',true);

  	document.getElementById('discount_text_coupen_10').value = "";
  	document.getElementById('discount_text_coupen_30').value = "";
  	document.getElementById('discount_text_coupen_40').value = "";
  	document.getElementById('discount_text_coupen_50').value = "";
  	document.getElementById('free_coupen').value = "";
  	document.getElementById('custom_coupen').value = "";
  	document.getElementById('extra_benefit').value = "";
  	$("#discount_text_coupen_20").focus();

  }

  else if(codeVal == 'coupen_30'){

  	$('#discount_text_coupen_30').prop('disabled',false);
  	$('#min_discount_30').prop('disabled',false);

  	$('#min_discount_10').prop('disabled',true);
  	$('#min_discount_20').prop('disabled',true);
  	$('#min_discount_40').prop('disabled',true);
  	$('#min_discount_50').prop('disabled',true);
  	$('#min_discount_free').prop('disabled',true);
  	$('#min_discount_custon').prop('disabled',true);
  	document.getElementById('discount_selct_text_new').value = "";

  	 $('#tbd_coupen').prop('disabled',true);

  	$('#discount_text_coupen_10').prop('disabled',true);

  	$('#discount_text_coupen_20').prop('disabled',true);

  	$('#discount_text_coupen_40').prop('disabled',true);

  	$('#discount_text_coupen_50').prop('disabled',true);

  	$('#select_min_discount').prop('disabled',true);
  	$('#free_coupen').prop('disabled',true);

  	$('#custom_coupen').prop('disabled',true);

  	$('#extra_benefit').prop('disabled',true);

  	document.getElementById('discount_text_coupen_20').value = "";
  	document.getElementById('discount_text_coupen_10').value = "";
  	document.getElementById('discount_text_coupen_40').value = "";
  	document.getElementById('discount_text_coupen_50').value = "";
  	document.getElementById('free_coupen').value = "";
  	document.getElementById('custom_coupen').value = "";
  	document.getElementById('extra_benefit').value = "";
  	$("#discount_text_coupen_30").focus();
  }

  else if(codeVal == 'coupen_40'){

  	$('#discount_text_coupen_40').prop('disabled',false);
  	$('#min_discount_40').prop('disabled',false);

  	$('#min_discount_10').prop('disabled',true);
  	$('#min_discount_20').prop('disabled',true);
  	$('#min_discount_30').prop('disabled',true);
  	$('#min_discount_50').prop('disabled',true);
  	$('#min_discount_free').prop('disabled',true);
  	$('#min_discount_custon').prop('disabled',true);  
  	document.getElementById('discount_selct_text_new').value = "";

  	 $('#tbd_coupen').prop('disabled',true);

  	$('#discount_text_coupen_10').prop('disabled',true);

  	$('#discount_text_coupen_20').prop('disabled',true);

  	$('#discount_text_coupen_30').prop('disabled',true);

  	$('#discount_text_coupen_50').prop('disabled',true);


  	$('#free_coupen').prop('disabled',true);

  	$('#custom_coupen').prop('disabled',true);

  	$('#extra_benefit').prop('disabled',true);

  	document.getElementById('discount_text_coupen_20').value = "";
  	document.getElementById('discount_text_coupen_30').value = "";
  	document.getElementById('discount_text_coupen_10').value = "";
  	document.getElementById('discount_text_coupen_50').value = "";
  	document.getElementById('free_coupen').value = "";
  	document.getElementById('custom_coupen').value = "";
  	document.getElementById('extra_benefit').value = "";

  	$("#discount_text_coupen_40").focus();

  }
  else if(codeVal == 'coupen_50'){

  	$('#discount_text_coupen_50').prop('disabled',false);
  	$('#min_discount_50').prop('disabled',false);

  	$('#min_discount_10').prop('disabled',true);
  	$('#min_discount_20').prop('disabled',true);
  	$('#min_discount_30').prop('disabled',true);
  	$('#min_discount_40').prop('disabled',true);
  	$('#min_discount_free').prop('disabled',true);
  	$('#min_discount_custon').prop('disabled',true);
  	document.getElementById('discount_selct_text_new').value = "";

    $('#tbd_coupen').prop('disabled',true);

  	$('#discount_text_coupen_10').prop('disabled',true);

  	$('#discount_text_coupen_20').prop('disabled',true);

  	$('#discount_text_coupen_30').prop('disabled',true);

  	$('#discount_text_coupen_40').prop('disabled',true);

  	$('#free_coupen').prop('disabled',true);

  	$('#custom_coupen').prop('disabled',true);

  	$('#extra_benefit').prop('disabled',true);


  	document.getElementById('discount_text_coupen_20').value = "";
  	document.getElementById('discount_text_coupen_30').value = "";
  	document.getElementById('discount_text_coupen_40').value = "";
  	document.getElementById('discount_text_coupen_10').value = "";
  	document.getElementById('free_coupen').value = "";
  	document.getElementById('custom_coupen').value = "";
  	document.getElementById('extra_benefit').value = "";
  	$("#discount_text_coupen_50").focus();

  }
  else if(codeVal == 'free_coupon'){

  	$('#free_coupen').prop('disabled',false);
  	$('#min_discount_free').prop('disabled',false);

  	$('#min_discount_10').prop('disabled',true);
  	$('#min_discount_20').prop('disabled',true);
  	$('#min_discount_30').prop('disabled',true);
  	$('#min_discount_40').prop('disabled',true);
  	$('#min_discount_50').prop('disabled',true);
  	$('#min_discount_custon').prop('disabled',true);
  	document.getElementById('discount_selct_text_new').value = "";

  	 $('#tbd_coupen').prop('disabled',true);

  	$('#discount_text_coupen_50').prop('disabled',true);

  	$('#discount_text_coupen_10').prop('disabled',true);

  	$('#discount_text_coupen_20').prop('disabled',true);

  	$('#discount_text_coupen_30').prop('disabled',true);

  	$('#discount_text_coupen_40').prop('disabled',true);

  	$('#custom_coupen').prop('disabled',true);

  	$('#extra_benefit').prop('disabled',true);

  	document.getElementById('discount_text_coupen_20').value = "";
  	document.getElementById('discount_text_coupen_30').value = "";
  	document.getElementById('discount_text_coupen_40').value = "";
  	document.getElementById('discount_text_coupen_50').value = "";
  	document.getElementById('discount_text_coupen_10').value = "";
  	document.getElementById('custom_coupen').value = "";
  	document.getElementById('extra_benefit').value = "";
  	$("#free_coupen").focus();

  }

  else if(codeVal == 'custom_coupon'){

  	$('#custom_coupen').prop('disabled',false);
  	$('#min_discount_custon').prop('disabled',false);

  	$('#min_discount_10').prop('disabled',true);
  	$('#min_discount_20').prop('disabled',true);
  	$('#min_discount_30').prop('disabled',true);
  	$('#min_discount_40').prop('disabled',true);
  	$('#min_discount_50').prop('disabled',true);
  	$('#min_discount_free').prop('disabled',true);
  	document.getElementById('discount_selct_text_new').value = "";

  	 $('#tbd_coupen').prop('disabled',true); 

  	$('#discount_text_coupen_50').prop('disabled',true);

  	$('#discount_text_coupen_10').prop('disabled',true);

  	$('#discount_text_coupen_20').prop('disabled',true);

  	$('#discount_text_coupen_30').prop('disabled',true);

  	$('#discount_text_coupen_40').prop('disabled',true);

  	$('#free_coupen').prop('disabled',true);

  	$('#extra_benefit').prop('disabled',false);

  	document.getElementById('discount_text_coupen_20').value = "";
  	document.getElementById('discount_text_coupen_30').value = "";
  	document.getElementById('discount_text_coupen_40').value = "";
  	document.getElementById('discount_text_coupen_50').value = "";
  	document.getElementById('discount_text_coupen_10').value = "";
  	document.getElementById('free_coupen').value = "";
  	$("#extra_benefit").focus();

  }

else if(codeVal == 'tbd')
{
	  $('#discount_selct_text_new').val("To Be Determined");
	  $('#discount_text_coupen_10').prop('disabled',true);
      $('#min_discount_10').prop('disabled',true);
      $('#min_discount_20').prop('disabled',true);
      $('#min_discount_30').prop('disabled',true);
      $('#min_discount_40').prop('disabled',true);
      $('#min_discount_50').prop('disabled',true);
      $('#min_discount_free').prop('disabled',true);
      $('#min_discount_custon').prop('disabled',true);
      //document.getElementById('discount_selct_text_new').value = "";

      $('#discount_text_coupen_20').prop('disabled',true);

      $('#discount_text_coupen_30').prop('disabled',true);

      $('#discount_text_coupen_40').prop('disabled',true);

      $('#discount_text_coupen_50').prop('disabled',true);

      $('#free_coupen').prop('disabled',true);

      $('#custom_coupen').prop('disabled',true);

      $('#extra_benefit').prop('disabled',true);

      document.getElementById('discount_text_coupen_10').value = "";
      document.getElementById('discount_text_coupen_20').value = "";
      document.getElementById('discount_text_coupen_30').value = "";
      document.getElementById('discount_text_coupen_40').value = "";
      document.getElementById('discount_text_coupen_50').value = "";
      document.getElementById('free_coupen').value = "";
      document.getElementById('custom_coupen').value = "";
      //$("#tbd_coupen").focus();
}


}
});

$(".btn-act").click(function(event){

	var coupen_code  = $("#coupen_code_new").val();

	var discount_selct_text_new  = $("#discount_selct_text_new").val();

	var discount_disable = $("#discount_selct_text_new").is(":disabled");

	var extra_benefit = $("#extra_benefit").val();

	var disabled = $("#extra_benefit").is(":disabled");

	var rr_id_new = $("#get_reat_id").val();

	var ff_id_new = $("#get_fund_id").val();

	var select_min_discount_disable = $("#select_min_discount").is(":disabled");

	var select_min_discount = $("#select_min_discount").val();

	var url = window.location.origin;
	var admin_url ="/rif-admin/admin-ajax.php";
	var ajaxUrl = url+admin_url;

	var ret_data ="/return-data/";
	var ret_uurl = url+ret_data;

	if(coupen_code == '')
	{
		document.getElementById("coupen_code_new").style.borderColor = "#E34234"; 
		jQuery('#app_form .show_error').html('<span style="color:red;"> Propose a Giveaway Voucher For Campaign Donors </span>');
		jQuery('#app_form .show_error').show();  
		return false;   
	}
	else
	{ 
		document.getElementById("coupen_code_new").style.borderColor = "#006600";  
	} 
	if(!disabled)
	{
		if(extra_benefit == '')
		{
			document.getElementById("extra_benefit").style.borderColor = "#E34234"; 
			jQuery('#app_form .show_error').html('<span style="color:red;"> Please input a Giveaway discount, ex: $5 OFF.</span>');
			jQuery('#app_form .show_error').show();  
			return false;   
		}
		else
		{ 
			document.getElementById("extra_benefit").style.borderColor = "#006600";  
		} 
	}

	if(!discount_disable)
	{
		if(discount_selct_text_new == '')
		{
			document.getElementById("discount_selct_text_new").style.borderColor = "#E34234"; 
			jQuery('.show_error').html('<span style="color:red;"> Please list the products for which you want to provide a discount.  Ex. Clothing item, food etc.</span>');
			jQuery('#app_form .show_error').show();  
			return false;   
		}
		else
		{ 
			document.getElementById("discount_selct_text_new").style.borderColor = "#006600"; 	

			if(select_min_discount == '' && !select_min_discount_disable)
			{
				document.getElementById("select_min_discount").style.borderColor = "#E34234"; 
				jQuery('#app_form .show_error').html('<span style="color:red;"> Please enter a minimum donation amount </span>');
				jQuery('#app_form .show_error').show();  
				return false;   
			}
			else
			{ 
				document.getElementById("select_min_discount").style.borderColor = "#006600";

				event.preventDefault();

				var coupen_code  = $("#coupen_code_new").val();

				var discount_selct_text_new  = $("#discount_selct_text_new").val();

				var extra_benefit = $("#extra_benefit").val();

				var rr_id_new = $("#get_reat_id").val();

				var ff_id_new = $("#get_fund_id").val();

				var discount_selct = $("#discount_selct").val();

				if(!select_min_discount_disable)
				{
					var select_min_discount = $("#select_min_discount").val();
				}

				$.ajax({
					url :ajaxUrl,
					type : 'post',
					data: {
						action: 'accept_fundraiser_request',
        //Approve Data

        coupen_code : coupen_code, 

        discount_selct_text_new : discount_selct_text_new,

        extra_benefit : extra_benefit,

        discount_selct : discount_selct,

        rr_id_new : rr_id_new,

        select_min_discount : select_min_discount,

        ff_id_new : ff_id_new       
    },

    beforeSend: function() 
    {
    	setTimeout(function()
    	{
    		jQuery.LoadingOverlay("show", {
    			image       : "",
    			fontawesome : "fas fa-spinner fa-spin"
    		});
    		jQuery.LoadingOverlay("hide");

    	}, 1000); 
    },   

    success: function(response) 
    {
        //alert(response);  
        
        var str = response;
        var arr = str.split("-");
        
        var rid = arr[0];
        
        var fid = arr[1];

        jQuery(".myvalue").load(ret_uurl,{r_id: rid, f_id: fid});
        jQuery('#accept_deny').modal('hide');       
    }
});
			}
		}
	}
});

$("#dis_app_form").submit(function(event)
{
	var x = document.getElementsByClassName("e_s_time");
	var xx = document.getElementsByClassName("e_e_time");

	var e_s_date = $('#e_s_date').val();
	var e_s_time = $('.e_s_time').val();
	var e_e_date = $('#e_e_date').val();
	var e_e_time = $('.e_e_time').val();

	var url = window.location.origin;
	var admin_url ="/rif-admin/admin-ajax.php";
	var ajaxUrl = url+admin_url;
	var return_data = "/return-data/";
	var ret_url = url+return_data;

	if ($.trim(e_s_date).length == 0) 
	{
		document.getElementById("e_s_date").style.borderColor = "#E34234";
		$('.alert-danger').html('<span style="color:red;"><strong>Error:</strong> Please propose an start date for the Business Giveaway Voucher.  </span>');
		$('.alert-danger').show();
		return false;
	}else{    
		document.getElementById("e_s_date").style.borderColor = "#006600";    
	}

	if ($.trim(e_s_time).length == 0) 
	{

		x[0].style.borderColor = "#E34234";
		$('.alert-danger').html('<span style="color:red;"><strong>Error:</strong> Please propose a start time for the Business Giveaway Voucher.  </span>');
		$('.alert-danger').show();
		return false;
	}else{    
		x[0].style.borderColor = "#006600";
		document.getElementById('e_s_time2').value = e_s_time;     
	}

	if ($.trim(e_e_date).length == 0) 
	{
		document.getElementById("e_e_date").style.borderColor = "#E34234";
		$('.alert-danger').html('<span style="color:red;"><strong>Error:</strong> Please propose an Expiration Date for the Business Giveaway Voucher </span>');
		$('.alert-danger').show();
		return false;
	}else{    
		document.getElementById("e_e_date").style.borderColor = "#006600";    
	}

	if ($.trim(e_e_time).length == 0) 
	{
		xx[0].style.borderColor = "#E34234";
		$('.alert-danger').html('<span style="color:red;"><strong>Error:</strong> Please propose and End Time for the Business Giveaway Voucher </span>');
		$('.alert-danger').show();
		return false;

	}else{    
		xx[0].style.borderColor = "#006600";
		document.getElementById('e_e_time2').value = e_e_time;
  //return true;  

  event.preventDefault();
  
  var email    = $('#email').val();
  var e_id     = $('#e_id').val();
  var r_id     = $('#r_id').val();
  var e_title  = $('#e_title').val();
  var f_auth_name = $('#f_auth_name').val();
  
  var e_s_date    = $('#e_s_date').val();
  var e_s_time    = $('#e_s_time').val();
  var e_e_date    = $('#e_e_date').val();
  var e_e_time    = $('#e_e_time').val();
  var comment     = $('#comment').val();
  
  var url=ajaxUrl;     
  $.ajax({
  	url :url ,
  	type : 'post',
      //dataType: 'json',
      data : {
      	action      : 'change_time_req_event',
        //Approve Data
        email : email,
        e_id  : e_id,
        r_id  : r_id,
        e_title : e_title,
        f_auth_name : f_auth_name,
        
        e_s_date : e_s_date,
        e_s_time : e_s_time,
        e_e_date : e_e_date,
        e_e_time : e_e_time,
        comment  : comment       
    },

    beforeSend: function() 
    {
    	jQuery('#msform #dvLoading').show(); 

    	setTimeout(function()
    	{
    		jQuery.LoadingOverlay("show", {
    			image       : "",
    			fontawesome : "fas fa-spinner fa-spin"
    		});
    		jQuery.LoadingOverlay("hide");

    	}, 1000);    
    },
    success : function(response) 
    {
        //alert(response);  
        var str = response;
        var arr = str.split("-");
        var rid = arr[0];
        var fid = arr[1];
        $(".myvalue").load(ret_url,{r_id: rid, f_id: fid});
        $('#edit').modal('hide');
    }
});
}

});

//***********Code to search for deny an event start here ***************//
$('#search-input_deny').keyup(function(){
	var minlength_deny = 5;
	var zip_code = $('#search-input_deny').val();
	var url = window.location.origin;
	var admin_url ="/rif-admin/admin-ajax.php";
	var ajaxUrl = url+admin_url;

	if (zip_code.length >= minlength_deny ) 
	{
		var ajaxUrl=admin_url;

		$.ajax({
			url :ajaxUrl,
			type : 'post',
			dataType: 'html',
			data : {
				action : 'author_search_retaile',
				zip_codes : zip_code  
			},
			beforeSend: function() 
			{
				jQuery('#serach-input-loder').show();    
			},
			success : function( posts ) 
			{
			//alert(response);
			jQuery('#serach-input-loder').hide();
			setTimeout(function()
			{
				$("#deny_show_results").html(posts); 
				$(".denayserach_reat").addClass("fieldset_44");
			}, 1000); 
		}
	});	
	}
});

$("#dissaproved_event .approve_disapprove").click(function(e)
{ 
	e.preventDefault();

	var r_id_new        = $('#rid_new').val();
	var f_id_new        = $('#f_id_new').val();
	var f_email_new     = $('#f_email_new').val();
	var f_title_new     = $('#f_title_new').val();
	var f_auth_name_new = $('#f_auth_name_new').val();

	var url = window.location.origin;
	var admin_url ="/rif-admin/admin-ajax.php";
	var ajaxUrl = url+admin_url;
	var return_data = "/return-data/";
	var ret_url = url+return_data;

	var divid = $('#divid').val();
	var app_disapp_val = $('#app_disapp_val').val();

	var url=admin_url;     
	$.ajax({
		url :url ,
		type : 'post',
      //dataType: 'json',
      data : {
      	action      : 'approve_disapprove_event',
        //Approve Data
        r_id_new    : r_id_new,
        f_id_new    : f_id_new,
        f_email_new : f_email_new,
        f_title_new : f_title_new,
        f_auth_name_new : f_auth_name_new,
        
        //*****Get Div id and select button values*******//
        divid : divid,
        app_disapp_val :app_disapp_val  
    },

    beforeSend: function() 
    {
    	setTimeout(function()
    	{
    		jQuery.LoadingOverlay("show", {
    			image       : "",
    			fontawesome : "fas fa-spinner fa-spin"
    		});
    		jQuery.LoadingOverlay("hide");
    	}, 1000);  
    },

    success : function(response) 
    {
    	var str = response;
    	var arr = str.split("-");
    	var rid = arr[0];
    	var fid = arr[1];
    	$(".myvalue").load(ret_url,{r_id: rid, f_id: fid});
    	$('#dissaproved_event').modal('hide');

    }
});
});

$('input[name="donor_signup"]').change(function() 
{
	var url = window.location.origin;
	var admin_url ="/rif-admin/admin-ajax.php";
	var ajaxUrl = url+admin_url;

	if($(this).is(':checked') && $(this).val() == 'true') 
	{
		var email = $('#email').val();

		var url=ajaxUrl;

		$.ajax({
			url :url ,
			type : 'post',
			dataType: 'json',
			data : {
				action : 'donor_new_signup',
				user_email: email
			},

			beforeSend: function() 
			{  
			},
			success : function(response) 
			{                 
				if (response == 2) 
				{
					document.getElementById("email").style.borderColor = "#E34234";
					$('.error-email-name').html('<span style="color:red;"> Email is already used. </span>');
					$('.error-email-name').show();
					$("#email").focus();
					$('#donor_loading').hide();
				}
				else if(response == 11)
				{
					$('.user_register_filed').slideDown();
					$('#donr_show_pass').val('true');
				}
			}
		});
	}
	else
	{
		$('.user_register_filed').slideUp();
		$('#donr_show_pass').val('');
		$('.error-email-name').hide();
		document.getElementById("email").style.borderColor = "#006600";
	}
});

$("#donation_dd").keyup(function(){

	var donation_amount = $("#donation_dd").val();
	$("#bnt_amt").html(donation_amount);
});
}); 

jQuery(document).ready(function()
{
	$("#edit_fundraiser_image_logo").on("change", function() {
		$(".upload-image-loders").show();
		$("[for=file]").html(this.files[0].name);
		$("#target_fundraiser_logoimg").attr("src", URL.createObjectURL(this.files[0]));
		var dkrm = new Darkroom('#target_fundraiser_logoimg', {

			//backgroundColor: '#fff',

      // Plugins options
      plugins: {
        //save: false,
        crop: {
          quickCropKey: 67, //key "c"
          minHeight: 50,
          minWidth: 50,
          ratio: 4/3
      },
      save: {
      	callback: function() {
             this.darkroom.selfDestroy(); // Turn off the bar and cleanup
             var newImage = dkrm.canvas.toDataURL();
             $("#logofundevent_image").val(newImage);
             $("#new_target_fundraiser_logoimg").attr("src", newImage);
             $("#reset1-fundlogo").show();
             jQuery("#fundeventPreviewimg").attr("src", newImage);
             $("#new_target_fundraiser_logoimg" ).addClass( "broder_show_cls" );
       //jQuery("#event_logo_upload").modal('hide');
       jQuery("#fundevent_preview_logo").show();
   }
},
},
initialize: function() {
	$(".upload-image-loders").hide();
	var cropPlugin = this.plugins['crop'];
}
});
	});

	$('#reset1-fundlogo').on('click', function(e) {
		$('#new_target_fundraiser_logoimg').attr('src', '');
		$('#fundeventPreviewimg').attr('src', '');
		$("#new_target_fundraiser_logoimg" ).removeClass( "broder_show_cls" );
		$('#reset1-fundlogo').hide();
		$("#fundevent_preview_logo").hide();
		var $el = $('#edit_fundraiser_image_logo');
		$el.wrap('<form>').closest('form').get(0).reset();
		$el.unwrap();
		return myFunction_new();
	});
	function myFunction_new() {
		var xx = document.createElement("IMG");
		xx.setAttribute("id", "target_fundraiser_logoimg");
		document.body.appendChild(xx);
		document.getElementById('addfundeventlogo_target1').append(xx);
	}
}); 


$(document).ready(function()
{
	$("#edit_retailer_image_logo").on("change", function() {
		$(".upload-image-loders").show();
		$("[for=file]").html(this.files[0].name);
		$("#target_retailer_logoimg").attr("src", URL.createObjectURL(this.files[0]));
		var dkrm = new Darkroom('#target_retailer_logoimg', {

			//backgroundColor: '#fff',
      // Plugins options
      plugins: {
        //save: false,
        crop: {
          quickCropKey: 67, //key "c"
          minHeight: 50,
          minWidth: 50,
          ratio: 4/3
      },
      save: {
      	callback: function() {
             this.darkroom.selfDestroy(); // Turn off the bar and cleanup
             var newImage = dkrm.canvas.toDataURL();
             //varThatStoresYourImageData = newImage;
       //var profile_img = jQuery('#get_p_image_bus').val(); 
       //alert(profile1);
       $("#logoretevent_image").val(newImage);
       $("#new_target_retailer_logoimg").attr("src", newImage);
       $("#new_target_retailer_logoimg" ).addClass( "broder_show_cls" );
       $("#reset1-retlogo").show();
       $("#reteventPreviewimg").attr("src", newImage);
       $("#retevent_preview_logo").show();
   }
},
},
      // Post initialize script
      initialize: function() {
      	$(".upload-image-loders").hide();
      	var cropPlugin = this.plugins['crop'];
         //cropPlugin.selectZone(170, 25, 300, 300);
       // cropPlugin.requireFocus();
   }
});
	});
	$('#reset1-retlogo').on('click', function(e) {
		$('#new_target_retailer_logoimg').attr('src', '');
		$("#new_target_retailer_logoimg" ).removeClass( "broder_show_cls" );
		$('#reteventPreviewimg').attr('src', '');
		$('#reset1-retlogo').hide();
		$("#retevent_preview_logo").hide();
		var $el = $('#edit_retailer_image_logo');
		$el.wrap('<form>').closest('form').get(0).reset();
		$el.unwrap();
		return myFunction_new_ret();
	});

	function myFunction_new_ret() {
		var xx = document.createElement("IMG");
		xx.setAttribute("id", "target_retailer_logoimg");
		document.body.appendChild(xx);
		document.getElementById('addreteventlogo_target1').append(xx);
	}
}); 

jQuery(document).ready(function(){
	jQuery("#edit_image_11").on("change", function() {
		jQuery(".upload-image-loders").show();
		$("[for=file]").html(this.files[0].name);
		$("#target_edit_event_imgs").attr("src", URL.createObjectURL(this.files[0]));
		var dkrm = new Darkroom('#target_edit_event_imgs', {

      // Plugins options
      plugins: {
        //save: false,
        crop: {
          quickCropKey: 67, //key "c"
          minHeight: 50,
          minWidth: 50,
          ratio: 4/3
      },
      save: {
      	callback: function() {
             this.darkroom.selfDestroy(); // Turn off the bar and cleanup
             var newImage = dkrm.canvas.toDataURL();
             $("#edit_image_events").val(newImage);
             $("#new_edit_target_img_events").attr("src", newImage);
             $( "#new_edit_target_img_events" ).addClass( "broder_show_cls" );
             $("#edit-event-img").show();          
             $("#show_edit_target_img_events").attr("src", newImage);
             $("#preview_img").show();
             jQuery('#edit_fundraiser_image').modal('hide');
         }
     },
 },
      // Post initialize script
      initialize: function() {
      	jQuery(".upload-image-loders").hide();
      	var cropPlugin = this.plugins['crop'];
      }
  });

	});
	$('#edit-event-img').on('click', function(e) {
		$('#new_edit_target_img_events').attr('src', '');
		$( "#new_edit_target_img_events" ).removeClass( "broder_show_cls" );
		$('#edit-event-img').hide();
		var $el = $('#edit_image_11');
		$el.wrap('<form>').closest('form').get(0).reset();
		$el.unwrap();
		return myFunction_edit_fund_images();
	});
	function myFunction_edit_fund_images() {
		var newx = document.createElement("IMG");
		newx.setAttribute("id", "target_edit_event_imgs");
		document.body.appendChild(newx);
		document.getElementById('edit_add_target_imgs').append(newx);
	} 
}); 

jQuery(document).ready(function(){
	jQuery("#edit_logo_11").on("change", function() {
		jQuery(".upload-image-loders").show();
		$("[for=file]").html(this.files[0].name);
		$("#target_edit_event_logo").attr("src", URL.createObjectURL(this.files[0]));
		var dkrm = new Darkroom('#target_edit_event_logo', {

      // Plugins options
      plugins: {
        //save: false,
        crop: {
          quickCropKey: 67, //key "c"
          minHeight: 50,
          minWidth: 50,
          ratio: 4/3
      },
      save: {
      	callback: function() {
             this.darkroom.selfDestroy(); // Turn off the bar and cleanup
             var newImage = dkrm.canvas.toDataURL();
             $("#edit_logo_events").val(newImage);
             $("#new_edit_target_logo_events").attr("src", newImage);
             $( "#new_edit_target_logo_events" ).addClass( "broder_show_cls" );
             $("#edit-event-logo").show();          
             $("#show_edit_target_logo_events").attr("src", newImage);
             $("#preview_logo").show();
             jQuery('#edit_fundraiser_logo').modal('hide');
         }
     },
 },
      // Post initialize script
      initialize: function() {
      	jQuery(".upload-image-loders").hide();
      	var cropPlugin = this.plugins['crop'];
         //cropPlugin.selectZone(170, 25, 300, 300);
       // cropPlugin.requireFocus();
   }
});
	});
	$('#edit-event-logo').on('click', function(e) {
		$('#new_edit_target_logo_events').attr('src', '');
		$( "#new_edit_target_logo_events" ).removeClass( "broder_show_cls" );
		$('#edit-event-logo').hide();
		var $el = $('#edit_logo_11');
		$el.wrap('<form>').closest('form').get(0).reset();
		$el.unwrap();
		return myFunction_edit_fund_images();
	});
	function myFunction_edit_fund_images() {
		var newx = document.createElement("IMG");
		newx.setAttribute("id", "target_edit_event_logo");
		document.body.appendChild(newx);
		document.getElementById('edit_add_target_logo').append(newx);
	} 
}); 

$(document).ready(function(){
	$("#edit_images_1").on("change", function() {
		$(".upload-image-loders").show();
		$("[for=file]").html(this.files[0].name);
		$("#target_edit_bus_img").attr("src", URL.createObjectURL(this.files[0]));
		var dkrm = new Darkroom('#target_edit_bus_img', {

      // Plugins options
      plugins: {
        //save: false,
        crop: {
          quickCropKey: 67, //key "c"
          minHeight: 50,
          minWidth: 50,
          ratio: 4/3
      },
      save: {
      	callback: function() {
             this.darkroom.selfDestroy(); // Turn off the bar and cleanup
             var newImage = dkrm.canvas.toDataURL();
             //varThatStoresYourImageData = newImage;

             $("#edit_image_val").val(newImage);
             $("#new_edit_target_img").attr("src", newImage);
             $( "#new_edit_target_img" ).addClass( "broder_show_cls" );
             $("#edit-btn-example-file-reset").show();
             $('#edit_event_bus_image').attr("src", newImage);
             $('#edit_bus_preview_image').show();
             $('#edit_business_image').modal('hide');
             $("#edit_bus_event_bus_image").attr("src", newImage);
         }
     },
 },
      // Post initialize script
      initialize: function() {
      	$(".upload-image-loders").hide();
      	var cropPlugin = this.plugins['crop'];
         //cropPlugin.selectZone(170, 25, 300, 300);
       // cropPlugin.requireFocus();
   }
});
	});
	$('#edit-btn-example-file-reset').on('click', function(e) {
		$('#new_edit_target_img').attr('src', '');
		$( "#new_edit_target_img" ).removeClass( "broder_show_cls" );
		$('#edit-btn-example-file-reset').hide();
		var $el = $('#edit_images_1');
		$el.wrap('<form>').closest('form').get(0).reset();
		$el.unwrap();
		return myFunction_edit_bus_1();
	});
	function myFunction_edit_bus_1() {
		var xx = document.createElement("IMG");
		xx.setAttribute("id", "target_edit_bus_img");
		document.body.appendChild(xx);
		document.getElementById('edit_add_target').append(xx);
	} 
}); 

$(document).ready(function(){
	$("#busness_logo").on("change", function() {
		$(".upload-image-loders").show();
		$("[for=file]").html(this.files[0].name);
		$("#target_edit_bus_logo").attr("src", URL.createObjectURL(this.files[0]));
		var dkrm = new Darkroom('#target_edit_bus_logo', {

			ratio: 4/3,
        // Plugins options
        plugins: {
          //save: false,
          crop: {
          	quickCropKey: 67,
          	minHeight: 50,
          	minWidth: 50,
          	ratio: 4/3
          },
          save: {
          	callback: function() {
               this.darkroom.selfDestroy(); // Turn off the bar and cleanup
               var newImage = dkrm.canvas.toDataURL();
               $("#edit_image_val_logo").val(newImage);
               $("#new_edit_target_logo").attr("src", newImage);
               $( "#new_edit_target_logo" ).addClass( "broder_show_cls" );
               $("#edit-logo-btn-example-file-reset").show();
               $('#edit_bus_preview_logo').show();
               $('#edit_event_bus_logo').attr("src", newImage);
               $('#edit_business_logo').modal('hide');
               $("#edit_bus_event_bus_logo").attr("src", newImage);
           }
       },
   },
        // Post initialize script
        initialize: function() {
        	$(".upload-image-loders").hide();
        	var cropPlugin = this.plugins['crop'];
        }
    });
	});

	$('#edit-logo-btn-example-file-reset').on('click', function(e) {
		$('#new_edit_target_logo').attr('src', '');
		$( "#new_edit_target_logo" ).removeClass( "broder_show_cls" );
		$('#edit-logo-btn-example-file-reset').hide();
		var $el = $('#busness_logo');
		$el.wrap('<form>').closest('form').get(0).reset();
		$el.unwrap();
		return myFunction_edit_bus_logoo();
	});
	function myFunction_edit_bus_logoo() {
		var xxslogo = document.createElement("IMG");
		xxslogo.setAttribute("id", "target_edit_bus_logo");
		document.body.appendChild(xxslogo);
		document.getElementById('edit_add_target_logo').append(xxslogo);
	} 
}); 


$('#piereg_lostpasswordform #wp-submit').click( function(event) 
{ 
	var url = window.location.origin;
	var admin_url ="/rif-admin/admin-ajax.php";
	var ajaxUrl = url+admin_url;

	var email1 = $("#piereg_lostpasswordform #user_login").val();
	if (email1 == "")
	{
		$(".error-login-sin1").show();
		$('#piereg_lostpasswordform #user_login').css('border-color','#E34234');
		$('#piereg_lostpasswordform #red-check1').addClass('red-tick');
		return false;
	} 
	else
	{
		$(".error-login-sin1").hide();
		$('#piereg_lostpasswordform #red-check1').addClass('green-tick');
		$('#piereg_lostpasswordform #red-check1').removeClass('red-tick');
	}
	
	event.preventDefault();

	var email1 = $("#piereg_lostpasswordform #user_login").val();
	$.LoadingOverlay("show", {image       : "",
		fontawesome : "fas fa-spinner fa-spin"
	});

	var url=ajaxUrl;
	
	$.ajax({
		url :url ,type : 'post',
		data : {action : 'forget_password',user_login: email1,},
		success : function( response ) 
		{
			$(".piereg_warning").html(response);
			$.LoadingOverlay("hide");
		}
	});
});

$(document).ready(function()
{
	var uri = window.origin ;

	var uri2 = "/wp-content/themes/raiseit/js/utils.js";

	var uri3 = uri+uri2;

	$('#uphone, #donor_phone, #add_phone_number_users, #buis_phone_new, #chn_contact, #r_phone').on('keypress', function(e) {

		var key = e.charCode || e.keyCode || 0;
		var phone = $(this);
		if (phone.val().length === 0) {
			phone.val(phone.val() + '(');
		}

		if (key !== 8 && key !== 9) {
			if (phone.val().length === 4) {
				phone.val(phone.val() + ')');
			}
			if (phone.val().length === 5) {
				phone.val(phone.val() + ' ');
			}
			if (phone.val().length === 9) {
				phone.val(phone.val() + '-');
			}
			if (phone.val().length >= 14) {
				phone.val(phone.val().slice(0, 13));
			}
		}

		return (key == 8 ||
			key == 9 ||
			key == 46 ||
			(key >= 48 && key <= 57) ||
			(key >= 96 && key <= 105));
	})

	jQuery("#uphone, #donor_phone, #add_phone_number_users, #buis_phone_new, #chn_contact, #r_phone").intlTelInput(
	{



// typing digits after a valid number will be added to the extension part of the number
allowExtensions: false,

// automatically format the number according to the selected country
autoFormat: true,

// if there is just a dial code in the input: remove it on blur, and re-add it on focus
autoHideDialCode: true,

// add or remove input placeholder with an example number for the selected country
autoPlaceholder: true,

// default country
//defaultCountry: "",

// geoIp lookup function
//geoIpLookup: null,

// don't insert international dial codes
nationalMode: false,

// number type to use for placeholders
//numberType: "MOBILE",

// display only these countries
//onlyCountries: [],

// the countries at the top of the list. defaults to united states and united kingdom
preferredCountries: [ "us", "in" ],
separateDialCode: true,

// specify the path to the libphonenumber script to enable validation/formatting
//utilsScript: ""

initialCountry: "auto",
geoIpLookup: function(callback) {
	$.get('https://ipinfo.io', function() {}, "jsonp").always(function(resp) {
		var countryCode = (resp && resp.country) ? resp.country : "";

   //alert(countryCode);
   callback(countryCode);
});
},

utilsScript: uri3

});
});

$(document).ready(function()
{
	$('#search_ret_names').keyup(function()
	{
		var url = window.location.origin;
		var admin_url ="/rif-admin/admin-ajax.php";
		var ajaxUrl = url+admin_url;	
		
		var zip_code11 = $('#search_ret_names').val();

		if ( zip_code11 != '' ) 
		{
			var retailer_names = $('#search_ret_names').val();

			$('#search12 #input-loder').show();

			$.ajax({
				url :ajaxUrl,
				type : 'post',
				dataType: 'html',
				data : {
					action:"search_reat_post",
					search_ret_namess : retailer_names,    
				},
				success : function(posts)
				{
					$("#show_posts").html(posts);
					$("#show_posts").show();
					$("#tab_default_7 .nnew_post").hide();
					$("#tab_default_7 .lost_div").hide();
					$('#search12 #input-loder').hide();
					$(".load-more").css("display", "none");
					$("#scrol_event").val('search_business');
					$(".nomore-allbusiness").hide();
				}
			});
		}
		else
		{
			$("#tab_default_7 .nnew_post").show();
			$("#tab_default_7 .lost_div").hide();
			$(".fs-error-fund").hide();
			$("#show_posts").hide();
			$(".load-more").css("display", "none");
		}
	});
});

$(document).ready(function(){
	$('input[name="new_status"]').change(function() 
	{
		if($(this).is(':checked') && $(this).val() == 'deny') 
		{
			$('#deny_request').modal('show');
		}
	});

	$('input[name="discount_coupon_edit"]').click(function() 
	{
		var new_fid = $(this).attr("data-fid");
		var new_rid = $(this).attr("data-rid");
		$("#get_fund_id").val(new_fid);
		$("#get_reat_id").val(new_rid);
		$('#edit_accept_deny').modal('show');
	});

	$('input[name="accept_date_time"]').change(function() 
	{
		if($(this).is(':checked') && $(this).val() == 'propose_accept') 
		{
			$('#accpet_proposal').modal('show');
			var newreat_id = $(this).attr("data-r_id");
			var newfund_id = $(this).attr("data-f_id");
			var start_date = $(this).attr("data-start_date");
			var end_date   = $(this).attr("data-end_date");
			var start_time = $(this).attr("data-start_time");
			var end_time   = $(this).attr("data-end_time");

			$("#propose_r_id").val(newreat_id);
			$("#propose_f_id").val(newfund_id);

			$("#propose_start_date").val(start_date);
			$("#propose_end_date").val(end_date);

			$("#propose_start_time").val(start_time);
			$("#propose_end_time").val(end_time);             
		}
	});
	$('input[name="accept_date_time"]').change(function() 
	{
		if($(this).is(':checked') && $(this).val() == 'change_newdate_time') 
		{
			$('#send_new_proposal').modal('show');  
			var newreat_id = $(this).attr("data-r_id");
			var newfund_id = $(this).attr("data-f_id"); 

			$("#send_r_id").val(newreat_id);
			$("#send_f_id").val(newfund_id);
		}
	});

	$("#send_new_proposal_btn").click(function()
	{
		var e_s_date = $('#f_e_s_date').val();
		var e_s_time = $('#f_e_s_time').val();
		var e_e_date = $('#f_e_e_date').val();
		var e_e_time = $('#f_e_e_time').val();

		if ($.trim(e_s_date).length == 0) 
		{
			document.getElementById("f_e_s_date").style.borderColor = "#E34234";
			jQuery('.alert-danger').html('<span style="color:red;"><strong>Error:</strong> Please propose a start date for the Business Giveaway Voucher.  </span>');
			jQuery('.alert-danger').show();
			return false;
		}
		else
		{    
			document.getElementById("f_e_s_date").style.borderColor = "#006600";    
		}

		if ($.trim(e_s_time).length == 0) 
		{
			document.getElementById("f_e_s_time").style.borderColor = "#E34234";
			jQuery('.alert-danger').html('<span style="color:red;"><strong>Error:</strong> Please propose a start time for the Business Giveaway Voucher. </span>');
			jQuery('.alert-danger').show();
			return false;
		}
		else
		{    
			document.getElementById("f_e_s_time").style.borderColor = "#006600"; 
		}

		if ($.trim(e_e_date).length == 0) 
		{
			document.getElementById("f_e_e_date").style.borderColor = "#E34234";
			jQuery('.alert-danger').html('<span style="color:red;"><strong>Error:</strong> Please propose an end date for the Business Giveaway Voucher.  </span>');
			jQuery('.alert-danger').show();
			return false;
		}
		else
		{    
			document.getElementById("f_e_e_date").style.borderColor = "#006600";    
		}

		if ($.trim(e_e_time).length == 0) 
		{
			document.getElementById("f_e_s_time").style.borderColor = "#E34234";
			jQuery('.alert-danger').html('<span style="color:red;"><strong>Error:</strong> Please propose an end time for the Business Giveaway Voucher.  </span>');
			jQuery('.alert-danger').show();
			return false;

		}
		else
		{
			document.getElementById("f_e_s_time").style.borderColor = "#006600"; 
		}

	});

	/**************Login from wp admin or Login Page Start here********************/

	$(".wp_front_login #piereg_login_form #wp-submit").on( "click",function(event)
	{

		event.preventDefault();
		var cc     = window.location.href;
		var ulogin =   $('.wp_front_login #piereg_login_form #user_login').val();
		var upass  =   $('.wp_front_login #piereg_login_form #user_pass').val();

		var url = window.location.origin;
		var admin_url ="/rif-admin/admin-ajax.php";
		var ajaxUrl = url+admin_url;

		var user = "/user/";
		var user_url  = url+user;
		
		if ($.trim(ulogin).length == 0) 
		{
			$('.wp_front_login #piereg_login_form #user_login').css('border-color','#E34234');
			$('.wp_front_login #piereg_login_form #red-check').addClass('red-tick');
			$('.wp_front_login #piereg_login_form #red-check').removeClass('green-tick');
			$('.wp_front_login .login-fs-danger').html('<span style="color:red;"> Please Enter Your Email or Username. </span>');
			$('.wp_front_login .login-fs-danger').show();
			return false; 
		}
		else{ 

			$('.wp_front_login #piereg_login_form #user_login').css('border-color','#006600');
			$('.wp_front_login #piereg_login_form #red-check').addClass('green-tick');
			$('.wp_front_login #piereg_login_form #red-check').removeClass('red-tick');
		}    

		/*********** Validating Email *************/

/*		var emailval = $('.wp_front_login #user_login').val();
		var mailformat = /^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/;  
    // Checking Empty Fields
    var vemail = mailformat.test(emailval)
    if ($.trim(emailval).length == 0 || vemail==false) 
    {
    	$('.wp_front_login .login-fs-waring').html('<span style="color:red;"> Invalid Email Address. </span>'); 
    	$('.wp_front_login #piereg_login_form #user_login').css('border-color','#E34234');
    	$('.wp_front_login #piereg_login_form #red-check').addClass('red-tick');
    	$('.wp_front_login #piereg_login_form #red-check').removeClass('green-tick');
    	$('.wp_front_login .login-fs-danger').show();
    	return false;
    }
    else{
    	$('.wp_front_login #piereg_login_form #user_login').css('border-color','#006600');
    	$('.wp_front_login #piereg_login_form #red-check').addClass('green-tick');
    	$('.wp_front_login #piereg_login_form #red-check').removeClass('red-tick');
    	$('.wp_front_login .login-fs-danger').hide();
    //return true;
}*/

if ($.trim(upass).length == 0) 
{
	$('.wp_front_login #piereg_login_form #user_pass').css('border-color','#E34234');

	$('.wp_front_login #piereg_login_form #error-red').addClass('red-tick');
	$('.wp_front_login #piereg_login_form #error-red').removeClass('green-tick');
	$('.wp_front_login .login-fs-danger').html('<span style="color:red;"> Please Enter Your Password. </span>');
	$('.wp_front_login .login-fs-danger').show();
	return false; 
}else{ 
	$('.wp_front_login #piereg_login_form #user_pass').css('border-color','#006600');
	$('.wp_front_login #piereg_login_form #error-red').addClass('green-tick');
	$('.wp_front_login #piereg_login_form #error-red').removeClass('red-tick');

	var urla=ajaxUrl;
	$.ajax({
		url :urla ,
		type : 'post',
		dataType: 'json',
		data : {
			action : 'check_user_login',
			user_login: ulogin,
			user_pass : upass,  
		},

		beforeSend: function() 
		{
			$('.wp_front_login #dvLoading').show();    
		},
		success : function( response ) 
		{
			if (response == 1) 
			{

				$('.wp_front_login .login-fs-danger').html('<span style="color:red;"> Invalid Password. </span>');
				$('.wp_front_login #piereg_login_form #user_login').css('border-color','#E34234');
				$('.wp_front_login #piereg_login_form #user_pass').css('border-color','#E34234');
				$('.wp_front_login #piereg_login_form #error-red').addClass('red-tick');
				$('.wp_front_login #piereg_login_form #red-check').addClass('red-tick');
				$('.wp_front_login #piereg_login_form #error-red').removeClass('green-tick');
				$('.wp_front_login #piereg_login_form #red-check').removeClass('green-tick');

				$('.wp_front_login .login-fs-danger').show();
				$('.wp_front_login #dvLoading').hide();

			}
			else if(response == 7)
			{ 

				$('.wp_front_login .login-fs-danger').html('<span style="color:red;"> Email or Username does not exist. </span>');
				document.getElementById("user_login").style.borderColor = "#E34234";  
				$('.wp_front_login .login-fs-danger').show();
				$('.wp_front_login #dvLoading').hide();

			}
			else if (response == 2)
			{    

				$('.wp_front_login .login-fs-success').html('<span style="color:green;"> Login successfull...redirecting.</span>');
				$('.wp_front_login .login-fs-danger').hide();
				$('.wp_front_login .login-fs-success').show();
				$('.wp_front_login #dvLoading').hide();

              // Hide it after 5 seconds
              setTimeout(function()
              {
              	$.LoadingOverlay("show", {
              		image       : "",
              		fontawesome : "fas fa-spinner fa-spin"
              	});

              	window.location.href = url+"/user/";
              	$.LoadingOverlay("hide");
              }, 1000);
              
              
          }else if (response == 3)
          {
          	$('.wp_front_login .login-fs-success').html('<span style="color:green;"> Login successfull...redirecting.</span>');
          	$('.wp_front_login .login-fs-danger').hide();
          	$('.wp_front_login .login-fs-success').show();
          	$('.wp_front_login #dvLoading').hide();

          	setTimeout(function()
          	{
          		$.LoadingOverlay("show", {
          			image       : "",
          			fontawesome : "fas fa-spinner fa-spin"
          		});
          		window.location.href = url+"/user/";
          		//window.location.href = cc;
          		$.LoadingOverlay("hide");
          	}, 1000);

          }
          else if (response == 4)
          {
          	$('.wp_front_login .login-fs-success').html('<span style="color:green;"> Login successfull...redirecting.</span>');
          	$('.wp_front_login .login-fs-danger').hide();
          	$('.wp_front_login .login-fs-success').show();
          	$('.wp_front_login #dvLoading').hide();

              // Hide it after 5 seconds
              setTimeout(function()
              {
              	$.LoadingOverlay("show", {
              		image       : "",
              		fontawesome : "fas fa-spinner fa-spin"
              	});
              	window.location.href = cc;
              	$.LoadingOverlay("hide");
              }, 1000);
              
          }
          else if (response == 5)
          {
          	$('.wp_front_login .login-fs-success').html('<span style="color:green;"> Login successfull...redirecting.</span>');
          	$('.wp_front_login .login-fs-danger').hide();
          	$('.wp_front_login .login-fs-success').show();
          	$('.wp_front_login #dvLoading').hide();

              // Hide it after 5 seconds
              setTimeout(function()
              {
              	$.LoadingOverlay("show", {
              		image       : "",
              		fontawesome : "fas fa-spinner fa-spin"
              	});
              	window.location.href = url+"/user/";
              	$.LoadingOverlay("hide");
              }, 1000);
              
          }
          else
          {
          	$('.wp_front_login #dvLoading').hide();
          }

      }
  });
}
});

/**************Login from wp admin end here***************/

});

$(document).ready(function(){
	$("#edit_profile_image").on("change", function() {

		var url = window.location.origin;
		var admin_url ="/rif-admin/admin-ajax.php";
		var author_page = "/author-edit-info/";
		var ajaxUrl = url+admin_url;
		var a_url = url+author_page;

		$("[for=file]").html(this.files[0].name);
		$("#target").attr("src", URL.createObjectURL(this.files[0]));
		var dkrm = new Darkroom('#target', {
      // Size options
      minWidth: 100,
      minHeight: 100,
      maxWidth: 600,
      maxHeight: 500,
      ratio: 4/3,
      // Plugins options
      plugins: {
        //save: false,
        crop: {
          quickCropKey: 67, //key "c"
          minHeight: 50,
          minWidth: 50,
          ratio: 4/3
      },
      save: {
      	callback: function() {
             this.darkroom.selfDestroy(); // Turn off the bar and cleanup
             var newImage = dkrm.canvas.toDataURL();
             //varThatStoresYourImageData = newImage;
             var profile = jQuery('#get_p_image').val(); 
             if(profile == "profile") 
             {   
             	var url =ajaxUrl;
             	jQuery.ajax({
             		url : url,
             		type : 'post',

             		data : {
             			action : 'upload_profile_media',
             			imagedata: newImage

             		},
             		beforeSend: function() 
             		{
             			setTimeout(function()
             			{
             				$.LoadingOverlay("show", {
             					image       : "",
             					fontawesome : "fas fa-spinner fa-spin"
             				});
             			}, 500);
             		},
             		success : function(response) 
             		{
             			setTimeout(function()
             			{
             				$.LoadingOverlay("show", {
             					image       : "",
             					fontawesome : "fas fa-spinner fa-spin"
             				});
                  //

                  window.location.href = a_url;
                  $.LoadingOverlay("hide");
				  //$("#edit_profile_popup").modal('hide');
				}, 3000);      
             		} 

             	});
             }

         }
     },
 },
      // Post initialize script
      initialize: function() {
      	var cropPlugin = this.plugins['crop'];
         //cropPlugin.selectZone(170, 25, 300, 300);
       // cropPlugin.requireFocus();
   }
});
	});
});

$(document).ready(function() 
{
	$('input[name="change_datatime"]').change(function() 
	{
		if($(this).is(':checked') && $(this).val() == 'approve') 
		{
			var fund_id = $(this).attr("data-f_id_new");
			var reat_id = $(this).attr("data-rid_new");
			var fund_auth_namee = $(this).attr("f_auth_name_new");
			var fund_auth_email = $(this).attr("data-f_email_new");

			$("#chnage_reat_id").val(reat_id);
			$("#chnage_fund_id").val(fund_id);
			$("#chnage_fund_auth_name").val(fund_auth_namee);
			$("#chnage_fund_auth_email").val(fund_auth_email);
		}
	});

	$("#dis_app_form").submit(function(event)
	{

		var url = window.location.origin;
		var admin_url ="/rif-admin/admin-ajax.php";
		var ajaxUrl = url+admin_url;

		var ret_data ="/return-data/";
		var ret_uurl = url+ret_data;

		var x = document.getElementsByClassName("e_s_time");
		var xx = document.getElementsByClassName("e_e_time");

		var e_s_date = $('#e_s_date').val();
		var e_s_time = $('.e_s_time').val();
		var e_e_date = $('#e_e_date').val();
		var e_e_time = $('.e_e_time').val();

		if ($.trim(e_s_date).length == 0) 
		{
			document.getElementById("e_s_date").style.borderColor = "#E34234";
			$('.alert-danger').html('<span style="color:red;"><strong>Error:</strong> Please propose a Start date for the Business Giveaway Voucher. </span>');
			$('.alert-danger').show();
			return false;
		}else{    
			document.getElementById("e_s_date").style.borderColor = "#006600";    
		}

		if ($.trim(e_s_time).length == 0) 
		{

			x[0].style.borderColor = "#E34234";
			$('.alert-danger').html('<span style="color:red;"><strong>Error:</strong> Please propose a start time for the Business Giveaway Voucher </span>');
			$('.alert-danger').show();
			return false;
		}else{    
			x[0].style.borderColor = "#006600";
			document.getElementById('e_s_time2').value = e_s_time;     
		}

		if ($.trim(e_e_date).length == 0) 
		{
			document.getElementById("e_e_date").style.borderColor = "#E34234";
			$('.alert-danger').html('<span style="color:red;"><strong>Error:</strong> Please propose an Expiration Date for the Business Giveaway Voucher </span>');
			$('.alert-danger').show();
			return false;
		}else{    
			document.getElementById("e_e_date").style.borderColor = "#006600";    
		}

		if ($.trim(e_e_time).length == 0) 
		{
			xx[0].style.borderColor = "#E34234";
			$('.alert-danger').html('<span style="color:red;"><strong>Error:</strong> Please propose and Expiration Time for the Business Giveaway Voucher. </span>');
			$('.alert-danger').show();
			return false;

		}else{    
			xx[0].style.borderColor = "#006600";
			document.getElementById('e_e_time2').value = e_e_time;
  //return true;  

  event.preventDefault();
  
  var email    = $('#email').val();
  var e_id     = $('#e_id').val();
  var r_id     = $('#r_id').val();
  var e_title  = $('#e_title').val();
  var f_auth_name = $('#f_auth_name').val();
  
  var e_s_date    = $('#e_s_date').val();
  var e_s_time    = $('#e_s_time').val();
  var e_e_date    = $('#e_e_date').val();
  var e_e_time    = $('#e_e_time').val();
  var comment     = $('#comment').val();
  
  var url=ajaxUrl;     
  $.ajax({
  	url :url ,
  	type : 'post',
      //dataType: 'json',
      data : {
      	action  : 'change_time_req_event',
        //Approve Data
        email : email,
        e_id  : e_id,
        r_id  : r_id,
        e_title : e_title,
        f_auth_name : f_auth_name,
        
        e_s_date : e_s_date,
        e_s_time : e_s_time,
        e_e_date : e_e_date,
        e_e_time : e_e_time,
        comment  : comment   
    },

    beforeSend: function() 
    {
    	$('#msform #dvLoading').show(); 

    	setTimeout(function()
    	{
    		$.LoadingOverlay("show", {
    			image       : "",
    			fontawesome : "fas fa-spinner fa-spin"
    		});

    		$.LoadingOverlay("hide");

    	}, 1000);  

    },

    success : function(response) 
    {
    	var str = response;
    	var arr = str.split("-");

    	var rid = arr[0];

    	var fid = arr[1];

    	$(".myvalue").load(ret_uurl,{r_id: rid, f_id: fid});
    	$('#edit').modal('hide');

    }
});

}

});

	$(':input[name="save_accpect"]').prop('disabled', true);
	$('input[name=new_status]').change(function() {
		if ($(this).prop('checked')) {
			$(':input[name="save_accpect"]').prop('disabled', false);
		}

	});

	$('.edit_submit').click(function(){

				   //alert('gsd');
				   var fvet_name = $("#fvet_name").val();
				   var f_fund_description = $("#f_fund_description").val();
				   var e_fund_city = $("#e_fund_city").val();
				   var e_findzip = $("#e_findzip").val();
				   var select_done = $("#select_done").val();
				   var edit_fund_amt = $("#edit_fund_amt").val();

				   if(fvet_name==""){
				   	$('#fvet_name').attr('style', "border:#FF0000 1px solid;"); 
				   	$('#fvet_name').focus();
				   	$('#fvet_name').select();
				   	return false;                 

				   }else{ 

				   	$('#fvet_name').attr('style', "border:#006600 1px solid;");  
				   	$("#edit_event").submit(function() {
				   		setTimeout(function() 
				   		{
				   			$.LoadingOverlay("show", {
				   				image       : "",
				   				fontawesome : "fas fa-spinner fa-spin"
				   			});               
				   		}, 100);
				   	});
				   }

                   //=======================
                   if(f_fund_description==""){
                   	$('#f_fund_description').attr('style', "border:#FF0000 1px solid;"); 
                   	$('#f_fund_description').focus();
                   	$('#f_fund_description').select();
                   	return false;                 

                   }else{ 

                   	$('#f_fund_description').attr('style', "border:#006600 1px solid;");  
                   	$("#edit_event").submit(function() {
                   		setTimeout(function() 
                   		{
                   			$.LoadingOverlay("show", {
                   				image       : "",
                   				fontawesome : "fas fa-spinner fa-spin"
                   			});               
                   		}, 100);
                   	});
                   }

                       //=========City========//
                       if(e_fund_city==""){
                       	$('#e_fund_city').attr('style', "border:#FF0000 1px solid;"); 
                       	$('#e_fund_city').focus();
                       	$('#e_fund_city').select();
                       	return false;                 

                       }else{ 

                       	$('#e_fund_city').attr('style', "border:#006600 1px solid;");  
                       	$("#edit_event").submit(function() {
                       		setTimeout(function() 
                       		{
                       			$.LoadingOverlay("show", {
                       				image       : "",
                       				fontawesome : "fas fa-spinner fa-spin"
                       			});               
                       		}, 100);
                       	});
                       }
                   //===============================//

                   //=========Zip========//
                   if(e_findzip==""){
                   	$('#e_findzip').attr('style', "border:#FF0000 1px solid;"); 
                   	$('#e_findzip').focus();
                   	$('#e_findzip').select();
                   	return false;                 

                   }else{ 

                   	$('#e_findzip').attr('style', "border:#006600 1px solid;");  
                   	$("#edit_event").submit(function() {
                   		setTimeout(function() 
                   		{
                   			$.LoadingOverlay("show", {
                   				image       : "",
                   				fontawesome : "fas fa-spinner fa-spin"
                   			});               
                   		}, 100);
                   	});
                   }
                   //===============================//

                   //=========Event Category========//
                   if(select_done==""){
                   	//$('#select_done').attr('style', "border:#FF0000 1px solid;"); 
                    $(".select-campaign-category").show(); 
                   	$('.select-campaign-category').focus();
                   	//$('#select_done').select();

                   	return false;                 

                   }else{ 
                   	$(".select-campaign-category").hide();
                   	//$('#select_done').attr('style', "border:#006600 1px solid;");  
                   	$("#edit_event").submit(function() {
                   		setTimeout(function() 
                   		{
                   			$.LoadingOverlay("show", {
                   				image       : "",
                   				fontawesome : "fas fa-spinner fa-spin"
                   			});               
                   		}, 100);
                   	});
                   }
                   //===============================//

                   //=========Event Category========//
                   if(edit_fund_amt==""){
                   	$('#edit_fund_amt').attr('style', "border:#FF0000 1px solid;"); 
                   	$('#edit_fund_amt').focus();
                   	$('#edit_fund_amt').select();
                   	return false;                 

                   }else{ 

                   	$('#edit_fund_amt').attr('style', "border:#006600 1px solid;");  
                   	$("#edit_event").submit(function() {
                   		setTimeout(function() 
                   		{
                   			$.LoadingOverlay("show", {
                   				image       : "",
                   				fontawesome : "fas fa-spinner fa-spin"
                   			});               
                   		}, 100);
                   	});
                   }
                   //===============================//
               });

$('.edt_sub').click(function(){
                   //alert();
                   var busn_name = $("#busn_name").val();
                   var f_fund_description = $("#f_fund_description").val();                   
                   var r_buis_address = $("#r_buis_address").val();
                   var buis_citys = $("#buis_citys").val();
                   var r_zip = $("#r_zip").val();
                   var r_phone = $("#r_phone").val();
                   var r_waddress = $("#r_waddress").val();

                   if(busn_name==""){
                   	$('#busn_name').attr('style', "border:#FF0000 1px solid;"); 
                   	$('#busn_name').focus();
                   	$('#busn_name').select();
                   	return false;                 

                   }else{ 

                   	$('#busn_name').attr('style', "border:#006600 1px solid;");  
                   	$('#edit_bus_event').submit(function() {
                   		setTimeout(function() 
                   		{
                   			$.LoadingOverlay("show", {
                   				image       : "",
                   				fontawesome : "fas fa-spinner fa-spin"
                   			});               
                   		}, 100);
                   	});
                   }
                   
                   //=======================//

                   if(f_fund_description==""){
                   	$('#f_fund_description').attr('style', "border:#FF0000 1px solid;"); 
                   	$('#f_fund_description').focus();
                   	$('#f_fund_description').select();
                   	return false;                 

                   }else{ 

                   	$('#f_fund_description').attr('style', "border:#006600 1px solid;");  
                   	$('#edit_bus_event').submit(function() {
                   		setTimeout(function() 
                   		{
                   			$.LoadingOverlay("show", {
                   				image       : "",
                   				fontawesome : "fas fa-spinner fa-spin"
                   			});               
                   		}, 100);
                   	});
                   }
                       //=========Address========//
                       if(r_buis_address==""){
                       	$('#r_buis_address').attr('style', "border:#FF0000 1px solid;"); 
                       	$('#r_buis_address').focus();
                       	$('#r_buis_address').select();
                       	return false;                 

                       }else{ 

                       	$('#r_buis_address').attr('style', "border:#006600 1px solid;");  
                       	$('#edit_bus_event').submit(function() {
                       		setTimeout(function() 
                       		{
                       			$.LoadingOverlay("show", {
                       				image       : "",
                       				fontawesome : "fas fa-spinner fa-spin"
                       			});               
                       		}, 100);
                       	});
                       }
                   //===============================//
                       //=========City========//
                       if(buis_citys==""){
                       	$('#buis_citys').attr('style', "border:#FF0000 1px solid;"); 
                       	$('#buis_citys').focus();
                       	$('#buis_citys').select();
                       	return false;                 

                       }else{ 

                       	$('#buis_citys').attr('style', "border:#006600 1px solid;");  
                       	$('#edit_bus_event').submit(function() {
                       		setTimeout(function() 
                       		{
                       			$.LoadingOverlay("show", {
                       				image       : "",
                       				fontawesome : "fas fa-spinner fa-spin"
                       			});               
                       		}, 100);
                       	});
                       }
                   //===============================//

                   //=========Zip========//
                   if(r_zip==""){
                   	$('#r_zip').attr('style', "border:#FF0000 1px solid;"); 
                   	$('#r_zip').focus();
                   	$('#r_zip').select();
                   	return false;                 

                   }else{ 

                   	$('#r_zip').attr('style', "border:#006600 1px solid;");  
                   	$('#edit_bus_event').submit(function() {
                   		setTimeout(function() 
                   		{
                   			$.LoadingOverlay("show", {
                   				image       : "",
                   				fontawesome : "fas fa-spinner fa-spin"
                   			});               
                   		}, 100);
                   	});
                   }
                   //===============================//

                   //=========Phone========//
                   if(r_phone==""){
                   	$('#r_phone').attr('style', "border:#FF0000 1px solid;"); 
                   	$('#r_phone').focus();
                   	$('#r_phone').select();
                   	return false;                 

                   }else{ 

                   	$('#r_phone').attr('style', "border:#006600 1px solid;");  
                   	$('#edit_bus_event').submit(function() {
                   		setTimeout(function() 
                   		{
                   			$.LoadingOverlay("show", {
                   				image       : "",
                   				fontawesome : "fas fa-spinner fa-spin"
                   			});               
                   		}, 100);
                   	});
                   }
                   //===============================//

                   //=========web address========//
                   if(r_waddress==""){
                   	$('#r_waddress').attr('style', "border:#FF0000 1px solid;"); 
                   	$('#r_waddress').focus();
                   	$('#r_waddress').select();
                   	return false;                 

                   }else{ 

                   	$('#r_waddress').attr('style', "border:#006600 1px solid;");  
                   	$('#edit_bus_event').submit(function() {
                   		setTimeout(function() 
                   		{
                   			$.LoadingOverlay("show", {
                   				image       : "",
                   				fontawesome : "fas fa-spinner fa-spin"
                   			});               
                   		}, 100);
                   	});
                   }
                   //===============================//
               });

    // NEED TO BE UPDATED if new versions are affected
    var ua = navigator.userAgent,
    scrollTopPosition,
    iOS = /iPad|iPhone|iPod/.test(ua),
    iOS11 = /OS 11_0_1|OS 11_0_2|OS 11_0_3|OS 11_1|OS 11_1_1|OS 11_1_2|OS 11_2|OS 11_2_1/.test(ua);

    // ios 11 bug caret position
    if ( iOS || iOS11 ) {
        // Add CSS class to body

    //alert('checking');
    $("body").addClass("iosBugFixCaret");
    $('input[type=text]').addClass('textbox');
    $('input[type=password]').addClass('textbox');
    $('input[type=textarea]').addClass('textbox');
    $('input[type=email]').addClass('textbox');
    $('input[type=tel]').addClass('textbox');
    $('input[type=select]').addClass('textbox');

    $(".textbox").click(function(){

    	$(".textbox").css({"border-color": "#ccc", 
    		"border-width":"1px", 
    		"border-style":"solid"});

    	scrollTopPosition = $(document).scrollTop();        
    }); 
}

$("#pippin_password_submit").click(function(event){

	var pippin_user_pass         = jQuery('#pippin_user_pass').val();
	var pippin_user_pass_confirm = jQuery('#pippin_user_pass_confirm').val();

	if ($.trim(pippin_user_pass).length == 0) 
	{
		document.getElementById("pippin_user_pass").style.borderColor = "#E34234";
		jQuery('.fs-error').html('<span style="color:red;"> Please enter your password </span>');
		jQuery('.fs-error').show();
		return false; 
	}
	else{ 

		document.getElementById("pippin_user_pass").style.borderColor = "#006600";
		jQuery('.fs-error').hide();    
	}

	if ($.trim(pippin_user_pass_confirm).length == 0) 
	{
		document.getElementById("pippin_user_pass_confirm").style.borderColor = "#E34234";
		jQuery('.fs-error').html('<span style="color:red;"> Please confirm your password </span>');
		jQuery('.fs-error').show();
		return false; 
	}else{ 

		document.getElementById("pippin_user_pass_confirm").style.borderColor = "#006600";
		jQuery('.fs-error').hide();    
	}

	if (pippin_user_pass != pippin_user_pass_confirm || pippin_user_pass == '') 
	{
      //alert("Passwords Do not match");
      document.getElementById("pippin_user_pass").style.borderColor = "#E34234";
      document.getElementById("pippin_user_pass_confirm").style.borderColor = "#E34234";
      jQuery('.fs-error').html('<span style="color:red;"> Passwords do not match </span>');
      jQuery('.fs-error').show();
      return false;     
  }


  if(pippin_user_pass>25 || pippin_user_pass_confirm<6)
  {
  	document.getElementById("pippin_user_pass").style.borderColor = "#E34234";
  	document.getElementById("pippin_user_pass_confirm").style.borderColor = "#E34234";
  	jQuery('.fs-error').html('<span style="color:red;"> You must enter an alphanumeric password of at least 6 characters. </span>');
  	jQuery('.fs-error').show();
  	return false;  
  }

});

$("#balance_alert").click(function()
{
	alert("You are not able to delete a WePay account which has an outstanding balance or outstanding payments. ");
});


$(".edt_sub").click(function()
{
	var current_user = $("#current_user").val();
	var allowSubmit = false;
	var change_author = jQuery('#move_fund_event').val();
	var mailformat = /^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/;  
    // Checking Empty Fields
    if(change_author != '')
    {
    	var vemail = mailformat.test(change_author)
    	if ($.trim(change_author).length == 0 || vemail==false) 
    	{
    		jQuery('.fs-error').html('<span style="color:red;"> Email is invalid! </span>');
    		jQuery('.fs-error').show();
    		return false;
    	}
    	else if (change_author == current_user) 
    	{
    		jQuery('.fs-error').html("<span style='color:red;'> You can't move this Campaign to your account </span>");
    		jQuery('.fs-error').show();
    		return false;
    	}      
    	else
    	{
    		return true;
    	}
    }
});

$(".sbut").click(function()
{
	var current_user = $("#current_user").val();
	var allowSubmit = false;
	var change_author = jQuery('#move_fund_event').val();

	var mailformat = /^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/;  
    // Checking Empty Fields
    if(change_author != '')
    {
    	var vemail = mailformat.test(change_author)
    	if ($.trim(change_author).length == 0 || vemail==false) 
    	{
    		jQuery('.fs-error').html('<span style="color:red;"> Invalid Email Address </span>');
    		jQuery('.fs-error').show();
    		return false;
    	}
    	else if (change_author == current_user) 
    	{
    		jQuery('.fs-error').html("<span style='color:red;'> You can't move this Campaign to your account </span>");
    		jQuery('.fs-error').show();
    		return false;
    	}
    	else
    	{
    		return true;
    	}
    }
});

$("#ug_photo").keyup(function()
{
	var embed_url = $("#ug_photo").val();
	if(embed_url != '')
	{
		document.getElementById("videourl").disabled = true; 
	}
	else
	{
		document.getElementById("videourl").disabled = false; 
	}
});

$("#videourl").keyup(function()
{
	var static_url = $("#videourl").val();
	if(static_url != '')
	{
		document.getElementById("ug_photo").disabled = true; 
	}
	else
	{
		document.getElementById("ug_photo").disabled = false; 
	}
});
});

$(document).mouseup(function(e) 
{
	var container = $("#shows_result");
    // if the target of the click isn't the container nor a descendant of the container
    if (!container.is(e.target) && container.has(e.target).length === 0) 
    {
    	$("#search-id").val('');
    	container.hide();
    	$('#cat_shows_result').hide();
    }
    else
    {
    	$('#cat_shows_result').show();
    }
});

$(document).ready(function()
{
	$(window).on('load', function () {
		jQuery(".myevent .sidenav-second-level li a").filter(function(){
			return this.href == location.href.replace(/#.*/, "");
		}).parent().addClass("active");
		if (jQuery('.myevent .sidenav-second-level li ').hasClass('active')) { 
			$('.myevent').addClass('li-color');
			$(".myevent .sidenav-second-level").addClass('show');
		}
		jQuery(".myevents .sidenav-second-level li a").filter(function(){
			return this.href == location.href.replace(/#.*/, "");
		}).parent().addClass("active");
		if (jQuery('.myevents .sidenav-second-level li ').hasClass('active')) {
			$('.myevents').addClass('li-color-busin');    
			$(".myevents .sidenav-second-level").addClass('show');
		}
		jQuery(".account-item .sidenav-second-level li a").filter(function(){
			return this.href == location.href.replace(/#.*/, "");
		}).parent().addClass("active");
		if (jQuery('.account-item .sidenav-second-level li ').hasClass('active')) { 
			$('.account-item').addClass('li-color-acct');  
			$(".account-item .sidenav-second-level").addClass('show');
		}
		jQuery(".single-item a").filter(function(){
			return this.href == location.href.replace(/#.*/, "");
		}).parent().addClass("active");
		if (jQuery('.single-item ').hasClass('active')) {  
			$(".single-item").css("display","block"); 
		}
	});

	$('.myevent').click(function()
	{
		$(".myevents .sidenav-second-level").removeClass('show');
		$(".account-item .sidenav-second-level").removeClass('show');
	});

	$('.myevents').click(function()
	{
		$(".myevent .sidenav-second-level").removeClass('show');
		$(".account-item .sidenav-second-level").removeClass('show');
	});
	$('.account-item').click(function()
	{
		$(".myevent .sidenav-second-level").removeClass('show');
		$(".myevents .sidenav-second-level").removeClass('show');
	});
	$('.single-item').click(function()
	{
		$(".myevent .sidenav-second-level").removeClass('show');
		$(".myevents .sidenav-second-level").removeClass('show');
		$(".account-item .sidenav-second-level").removeClass('show');
	});

});


$(document).ready(function(){
	$(".multi_image_host").on("change", function() {

		$("#r_buis_multiple_upload").attr( "disabled", "disabled" );
		var url = window.location.origin;
		var admin_url ="/rif-admin/admin-ajax.php";
		var author_page = "/author-edit-info/";
		var ajaxUrl = url+admin_url;
		var a_url = url+author_page;

		$("[for=file]").html(this.files[0].name);
		$("#target").attr("src", URL.createObjectURL(this.files[0]));
		var dkrm = new Darkroom('#target', {
      // Size options
      minWidth: 100,
      minHeight: 100,
      maxWidth: 600,
      maxHeight: 500,
      ratio: 4/3,
      // Plugins options
      plugins: {
        //save: false,
        crop: {
          quickCropKey: 67, //key "c"
          minHeight: 50,
          minWidth: 50,
          ratio: 4/3
      },
      save: {
      	callback: function() {
             this.darkroom.selfDestroy(); // Turn off the bar and cleanup
             var newImage = dkrm.canvas.toDataURL();
             var fd = new FormData();
             $("#r_buis_multiple_upload").removeAttr( "disabled" );
             var files_data = jQuery('.multi_image_host'); 
             var r_post_id = jQuery('#hidden_post_id').val();

             jQuery.each(jQuery(files_data), function(i, obj) {
             	jQuery.each(obj.files,function(j,file){
             		fd.append('files[' + j + ']', file);
             	})
             });

             fd.append('action', 'cvf_upload_files');
             fd.append('post_id', r_post_id); 
			 fd.append('base_64_image', newImage); 

             var url =ajaxUrl;
             jQuery.ajax({
             	url : url,
             	type : 'POST',
             	data: fd,
             	contentType: false,
             	processData: false,

             	beforeSend: function() 
             	{
             		setTimeout(function()
             		{
             			$(".postimg-update-spin").show();

             		}, 500);
             	},
             	success : function(response) 
             	{
             		$(".postimg-update-spin").hide();
             		jQuery('.upload-response').html(response);
             		jQuery("#if_have_image").val(newImage);
             		jQuery('.img-error').hide(); 
             		jQuery('.upload-form .target img').attr('src', '');
             		jQuery('.upload-form .target img').attr('id', 'target');
             		jQuery(".append-all-images").append("<li><img src='"+newImage+"'/></li>");
             		/*jQuery('.upload-image-next').removeAttr("disabled");*/
             	} 
             });
         }
     },
 },
      // Post initialize script
      initialize: function() {
      	var cropPlugin = this.plugins['crop'];
         //cropPlugin.selectZone(170, 25, 300, 300);
       // cropPlugin.requireFocus();
   }
});
	});
});

//*********business edit image upload********************//
$(document).ready(function(){
	$(".edit_bz_image_upload").on("change", function() {

		$("#r_buis_multiple_upload").attr( "disabled", "disabled" );
		var url = window.location.origin;
		var admin_url ="/rif-admin/admin-ajax.php";
		var author_page = "/author-edit-info/";
		var ajaxUrl = url+admin_url;
		var a_url = url+author_page;

		$("[for=file]").html(this.files[0].name);
		$("#target").attr("src", URL.createObjectURL(this.files[0]));
		var dkrm = new Darkroom('#target', {
      // Size options
      minWidth: 100,
      minHeight: 100,
      maxWidth: 600,
      maxHeight: 500,
      ratio: 4/3,
      // Plugins options
      plugins: {
        //save: false,
        crop: {
          quickCropKey: 67, //key "c"
          minHeight: 50,
          minWidth: 50,
          ratio: 4/3
      },
      save: {
      	callback: function() {
             this.darkroom.selfDestroy(); // Turn off the bar and cleanup
             var newImage = dkrm.canvas.toDataURL();
             var fd = new FormData();
             $("#r_buis_multiple_upload").removeAttr( "disabled" );
             var files_data = newImage; 
             var r_post_id = jQuery('#hidden_post_id').val();

             fd.append('action', 'buis_edit_upload_files');
             fd.append('post_id', r_post_id); 
             fd.append('files_data', newImage);

             var url =ajaxUrl;
             jQuery.ajax({
             	url : url,
             	type : 'post',

             	data : {
             		action : 'buis_edit_upload_files',
             		files_data: newImage,
             		post_id : r_post_id

             	},
             	beforeSend: function() 
             	{
             		setTimeout(function()
             		{
             			$(".postimg-update-spin").show();

             		}, 500);
             	},
             	success : function(response) 
             	{
             		$(".postimg-update-spin").hide();
             		//jQuery('.upload-response').html(response);
             		jQuery("#if_have_image").val(newImage);
             		jQuery('.img-error').hide(); 
             		jQuery('.upload-form .target img').attr('src', '');
             		jQuery('.upload-form .target img').attr('id', 'target');
             		location.reload();
             	} 
             });
         }
     },
 },
      // Post initialize script
      initialize: function() {
      	var cropPlugin = this.plugins['crop'];
         //cropPlugin.selectZone(170, 25, 300, 300);
       // cropPlugin.requireFocus();
   }
});
	});
});

//**************fundraiser multiple image upload**********************//

$(document).ready(function(){
	$(".fund_multi_image_host").on("change", function() {

		$("#r_buis_multiple_upload").attr( "disabled", "disabled" );
		$("#r_buis_multiple_upload").addClass( "disabled");
		var url = window.location.origin;
		var admin_url ="/rif-admin/admin-ajax.php";
		var author_page = "/author-edit-info/";
		var ajaxUrl = url+admin_url;
		var a_url = url+author_page;

		$("[for=file]").html(this.files[0].name);
		$("#target").attr("src", URL.createObjectURL(this.files[0]));
		var dkrm = new Darkroom('#target', {

      // Plugins options
      plugins: {
        //save: false,
        crop: {
          quickCropKey: 67, //key "c"
          minHeight: 50,
          minWidth: 50,
          ratio: 4/3
      },
      save: {
      	callback: function() {
             this.darkroom.selfDestroy(); // Turn off the bar and cleanup
             var newImage = dkrm.canvas.toDataURL();
             var fd = new FormData();
             $('.img-error').hide();
             var files_data = jQuery('.fund_multi_image_host'); 
             var r_post_id = jQuery('#hidden_post_ids').val();
             $("#r_buis_multiple_upload").removeAttr( "disabled");
             $("#r_buis_multiple_upload").removeClass( "disabled");
             jQuery.each(jQuery(files_data), function(i, obj) {
             	jQuery.each(obj.files,function(j,file){
             		fd.append('files[' + j + ']', file);
             	})
             });

             fd.append('action', 'fund_cvf_upload_files');
             fd.append('post_id', r_post_id); 
			 fd.append('base_64_image', newImage); 
			 fd.append('base_64_image', newImage); 
             var url =ajaxUrl;
             jQuery.ajax({
             	url : url,
             	type : 'POST',
             	data: fd,
             	contentType: false,
             	processData: false,

             	beforeSend: function() 
             	{
             		setTimeout(function()
             		{
             			$(".postimg-update-spin").show();

             		}, 500);
             	},
             	success : function(response) 
             	{
             		$(".postimg-update-spin").hide();
             		jQuery('.upload-response').html(response);
             		jQuery("#if_have_image").val(newImage);
             		jQuery('.img-error').hide(); 
             		jQuery('.add_fund_img .target img').attr('src', '');
             		jQuery('.add_fund_img .target img').attr('id', 'target');
             		jQuery(".append-all-images").append("<li><img src='"+newImage+"'/></li>");
             	} 
             });
         }
     },
 },
      // Post initialize script
      initialize: function() {
      	var cropPlugin = this.plugins['crop'];
         //cropPlugin.selectZone(170, 25, 300, 300);
       // cropPlugin.requireFocus();
   }
});
	});
});

$(document).ready(function(){
	var  cnt_msg  =  $(".fep_unread_message_count").text();
	if(cnt_msg == 0)
	{
		$('.msg-boxpanel').hide();
	}
	
	$("#new_business_logo_hostss").on("change", function() {
		$(".upload-image-loders").show();
		$("[for=file]").html(this.files[0].name);
		$("#target_bus_logo").attr("src", URL.createObjectURL(this.files[0]));
		var dkrm = new Darkroom('#target_bus_logo', {
      // Size options

     // backgroundColor: '#fff',
      // Plugins options
      plugins: {
        //save: false,
        crop: {
          quickCropKey: 67, //key "c"
          minHeight: 50,
          minWidth: 50,
          ratio: 4/3
      },
      save: {
      	callback: function() {
             this.darkroom.selfDestroy(); // Turn off the bar and cleanup
             var newImage = dkrm.canvas.toDataURL();
             $("#ret_logo").val(newImage);
             $("#add_event_busi_logo").attr("src", newImage);
             $("#add_busi_preview_logo").show();
             $(".show-logo-cross").show();
/*             $(".upload-form-logo .target img").attr('src', ' ');
$('.upload-form-logo .target img').attr('id', 'target_bus_logo'); */ 
}
},
},
      // Post initialize script
      initialize: function() {
      	$(".upload-image-loders").hide();
      	var cropPlugin = this.plugins['crop'];
         //cropPlugin.selectZone(170, 25, 300, 300);
       // cropPlugin.requireFocus();
   }
});
	});

$(".show-logo-cross").click(function()
{
	$("#add_event_busi_logo").attr('src', '');
	$(".upload-form-logo .target img").attr('src', '');
	$(".upload-form-logo .target img").attr('id', 'target_bus_logo');
	//$(".target img").show();
	$(".show-logo-cross").hide();
	$("#add_busi_preview_logo").hide();

});


});

$(".orignal_address").click(function()
{
	$(".orignal_address_show").show();
	$(".development_address_show").hide();

});

$(".development_addess").click(function()
{
	$(".development_address_show").show();
	$(".orignal_address_show").hide();
});


// Jquery for hide modal when click on keydown
$( document ).on( 'keydown', function ( e ) {
    if ( e.keyCode === 27 ) { // ESC
    	$(".modal").modal("hide");
    	$(".error-login1").hide();
    	$(".fs-error").hide();
    	$(".error-login-sin1").hide();
    	$(".error_change_time").hide();
    }
});

//code for change forget password text
$( "#myModal12 .alert-warning" ).replaceWith( "<p class='piereg_warning'>Please enter your email address. You will receive a link to create a new password via email.</p>" );

$( ".wp_front_login .piereg_login_wrapper .piereg_warning" ).replaceWith("<p class='piereg_warning'>Enter your new password below.</p>");

//hide msg after 5 second
$('.wp_front_login .piereg_login_wrapper .piereg_message').fadeIn('slow', function(){
	$('.wp_front_login .piereg_login_wrapper .piereg_message').delay(2000).fadeOut(); 
});

//change text when rest key mo longer exist
$(".wp_front_login .piereg_login_wrapper .piereg_login_error").replaceWith("<p class='piereg_login_error'><strong>Error</strong>: This Reset key is invalid or no longer exists. Please reset password again! <a data-dismiss='modal' data-toggle='modal' data-target='#myModal12'>Lost your password?</a></p>");

function validate() {
	if (document.getElementById('check_acc').checked) {
		$("#create_fundraiser_event_page .four_bar").show();
		$("#create_fundraiser_event_page .three_bar").hide();
		$("#create_fundraiser_event_page .next3").show();
		$("#create_fundraiser_event_page .next3").addClass( "newnext3" );
		$("#create_fundraiser_event_page .sub_check").hide();
	} 
	else 
	{
		$("#create_fundraiser_event_page .next3").hide();
		$("#create_fundraiser_event_page #find_sub1").show();
		$("#create_fundraiser_event_page .four_bar").hide();
		$("#create_fundraiser_event_page .three_bar").show();
	}
}

var check_acc_jkl = document.getElementById('check_acc');

if(check_acc_jkl)
{
	check_acc_jkl.addEventListener('change', validate);
}
//document.getElementById('check_acc').addEventListener('change', validate);

$( "#pass1" ).after( "<div data-toggle='tooltip' data-placement='top' title='Show/Hide Password' toggle='#pass1' class='show-hide-forget-pass1 toggle-password1' id='show-hide-for-pass1' style='display: none'></div>" );
$( "#pass2" ).after( "<div data-toggle='tooltip' data-placement='top' title='Show/Hide Password' toggle='#pass2' class='show-hide-forget-pass2 toggle-password2' id='show-hide-for-pass2' style='display: none'></div>" );


// ======================================================

$("#pass1").keyup(function(){
  //alert("fd");
  var cutsom_user_for_pass1 = $("#pass1").val();
  if(cutsom_user_for_pass1 == '')
  {
  	$("#show-hide-for-pass1").hide(500);
  }
  else
  {

  	$("#show-hide-for-pass1").show(500);
  }
});



$("#show-hide-for-pass1").click(function() {
	$(this).toggleClass("show-hide-forget-pass1 show-hide-forget-pass1-new");
	var input = $($(this).attr("toggle"));
	if (input.attr("type") == "password") {
		input.attr("type", "text");
	} else {
		input.attr("type", "password");
	}
});


$("#pass2").keyup(function(){
	var cutsom_user_for_pass2 = $("#pass2").val();
	if(cutsom_user_for_pass2 == '')
	{
		$("#show-hide-for-pass2").hide(500);
	}
	else
	{

		$("#show-hide-for-pass2").show(500);
	}
});


$("#show-hide-for-pass2").click(function() {
	$(this).toggleClass("show-hide-forget-pass2 show-hide-forget-pass2-conf");
	var input = $($(this).attr("toggle"));
	if (input.attr("type") == "password") {
		input.attr("type", "text");
	} else {
		input.attr("type", "password");
	}
});

 // =======================================================


 $("#pippin_user_pass").keyup(function(){
  //alert("fd");
  var cutsom_user_pass_eye = $("#pippin_user_pass").val();
  if(cutsom_user_pass_eye == '')
  {
  	$("#new-show-hide-eyes").hide(500);
  }
  else
  {

  	$("#new-show-hide-eyes").show(500);
  }
});



 $("#new-show-hide-eyes").click(function() {
 	$(this).toggleClass("new-show-hide-eyes new-show-hide-eyes-slesh");
 	var input = $($(this).attr("toggle"));
 	if (input.attr("type") == "password") {
 		input.attr("type", "text");
 	} else {
 		input.attr("type", "password");
 	}
 });

 $("#pippin_user_pass_confirm").keyup(function(){
 	var cutsom_user_pass_eye1 = $("#pippin_user_pass_confirm").val();
 	if(cutsom_user_pass_eye1 == '')
 	{
 		$("#conf-show-hide-eyes").hide(500);
 	}
 	else
 	{

 		$("#conf-show-hide-eyes").show(500);
 	}
 });

 $("#conf-show-hide-eyes").click(function() {
 	$(this).toggleClass("conf-show-hide-eyes conf-show-hide-eyes-slesh");
 	var input = $($(this).attr("toggle"));
 	if (input.attr("type") == "password") {
 		input.attr("type", "text");
 	} else {
 		input.attr("type", "password");
 	}
 });


});


jQuery(document).ready(function () { 
	$("#approve_fund").click(function(){
		var url = window.location.origin;
		var admin_url ="/rif-admin/admin-ajax.php";
		var ajaxUrl = url+admin_url;	

		var app_fund_id = $("#fid").val();
		var app_ret_id = $('#rid').val();
	});
});
jQuery('.accccpt_wepay input[type="checkbox"]').change(function() {
	if ($(this).is(":checked")) 
	{
		$("#accept_wepay_trnm").val("true");
	} 
	else
	{
		$("#accept_wepay_trnm").val("");
	}
});

jQuery('.accccpt_wepay input[type="checkbox"]').change(function() {
	if ($(this).is(":checked"))
	{
		$("#accept_first_wepay_trnm").val("true");
	} 
	else
	{
		$("#accept_first_wepay_trnm").val();
	}
});