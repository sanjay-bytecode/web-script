<?php
/**
* Raiseit's functions and definitions
* @author Gaurav
* @package Raiseit
* @since Raiseit 1.0
*/
/**
* First, let's set the maximum content width based on the theme's design and stylesheet.

* This will limit the width of all uploaded images and embeds.
*/
require_once('lib/twilio-php-latest/Services/Twilio.php');

require 'wepay.php';


if ( ! class_exists( 'Timber' ) ) {
	add_action( 'admin_notices', function() {
		echo '<div class="error"><p>Timber not activated. Make sure you activate the plugin in <a href="' . esc_url( admin_url( 'plugins.php#timber' ) ) . '">' . esc_url( admin_url( 'plugins.php') ) . '</a></p></div>';
	});
	
	return;
}

Timber::$dirname = array('templates', 'views');
class StarterSite extends TimberSite {
	function __construct() {
		add_theme_support( 'post-formats' );
		add_theme_support( 'post-thumbnails' );
		add_theme_support( 'menus' );
		add_theme_support( 'html5', array( 'comment-list', 'comment-form', 'search-form', 'gallery', 'caption' ) );
		add_filter( 'timber_context', array( $this, 'add_to_context' ) );
		add_filter( 'get_twig', array( $this, 'add_to_twig' ) );
		add_action( 'init', array( $this, 'register_post_types' ) );
		add_action( 'init', array( $this, 'register_taxonomies' ) );
		parent::__construct();

	}
	function register_post_types() {
		//this is where you can register custom post types
	}
	function register_taxonomies() {
		//this is where you can register custom taxonomies
	}
	function add_to_context( $context ) {
		$context['foo'] = 'bar';
		$context['stuff'] = 'I am a value set in your functions.php file';
		$context['notes'] = 'These values are available everytime you call Timber::get_context();';
		$context['footer_option'] = get_fields('option');
		$context['menu'] = new TimberMenu();
		$context['site'] = $this;
		
		return $context;
	}
	function myfoo( $text ) {
		$text .= ' bar!';
		return $text;
	}
	function add_to_twig( $twig ) {
		/* this is where you can add your own functions to twig */
		$twig->addExtension( new Twig_Extension_StringLoader() );
		$twig->addFilter('myfoo', new Twig_SimpleFilter('myfoo', array($this, 'myfoo')));
		return $twig;
	}
}
new StarterSite();

require_once('wepay.php');


if ( ! function_exists( 'raiseit_setup' ) ) :
/**
* Sets up theme defaults and registers support for various WordPress features.
*
* Note that this function is hooked into the after_setup_theme hook, which runs
* before the init hook. The init hook is too late for some features, such as indicating
* support post thumbnails.
*/
function raiseit_setup() {
/**
* Make theme available for translation.
* Translations can be placed in the /languages/ directory.
*/
load_theme_textdomain( 'raiseitfast', get_template_directory() . '/languages' );
/**
* Add default posts and comments RSS feed links to <head>.
*/
add_theme_support( 'automatic-feed-links' );
/**
* Enable support for post thumbnails and featured images.
*/
add_theme_support( 'post-thumbnails' );
/**
* Add support for two custom navigation menus.
*/
register_nav_menus( array(
	'primary'   => __( 'Primary Menu', 'raiseitfast' ),
	'secondary' => __('Secondary Menu', 'raiseitfast' )
) );
/**
* Enable support for the following post formats:
* aside, gallery, quote, image, and video
*/
add_theme_support( 'post-formats', array ( 'aside', 'gallery', 'quote', 'image', 'video' ) );
}
endif; // raiseit_setup
add_action( 'after_setup_theme', 'raiseit_setup' );

/**
* JavaScript Detection.
*
* Adds a `js` class to the root `<html>` element when JavaScript is detected.
*
* @since Raiseit Fast 1.1
*/
function raiseit_javascript_detection() {
	echo "<script>(function(html){html.className = html.className.replace(/\bno-js\b/,'js')})(document.documentElement);</script>\n";

}
add_action( 'wp_head', 'raiseit_javascript_detection', 0 );


function wpdocs_dequeue_script() {
	wp_dequeue_script( 'pie_validation_js' );
}
add_action( 'wp_print_scripts', 'wpdocs_dequeue_script', 100 );



function enqueue_my_styles_scripts() 
{
// Add Genericons, used in the main stylesheet.

	wp_enqueue_style( 'genericons', get_template_directory_uri() . '/genericons/genericons.css', array(), '3.2', false );

	wp_enqueue_style( 'bootstrap-min', get_template_directory_uri() . '/css/bootstrap.min.css', array(), '3.2.2', false  );

	wp_enqueue_style( 'style-2-css', get_template_directory_uri() . '/css/style-2.css', array(), '3.2.2', false  );


	/*	wp_enqueue_style( 'style-3-css', get_template_directory_uri() . '/style3.css', array(), '3.2.2', false  );*/


	/*	wp_enqueue_style( 'jquery-ui.min', get_template_directory_uri() . '/css/jquery-ui.min.css', array(), '3.2.2', false  );*/

	wp_enqueue_style( 'raiseit-style', get_stylesheet_uri(), false  );

	wp_enqueue_style( 'darkroom-css', get_template_directory_uri() . '/css/darkroom.css', array(), '3.2.2', false  );

	wp_enqueue_style( 'bootstrap-select-css', get_template_directory_uri() . '/css/bootstrap-select.min.css
		', array(), '3.2.2', false  );

	wp_enqueue_style( 'bootstrap-datepicker-css', get_template_directory_uri() . '/css/bootstrap-datepicker.css
		', array(), '3.2.2', false  );

	wp_enqueue_style( 'timepicker-min-css', get_template_directory_uri() . '/css/timepicker.min.css
		', array(), '3.2.2', false  );
	
	/*wp_enqueue_style( 'page-css', get_template_directory_uri() . '/css/page.css', array(), '3.2.2', false  );*/

	wp_enqueue_style( 'intlTelInput-css', get_template_directory_uri() . '/css/intlTelInput.css', array(), '3.2.2', false  );

	/*	wp_enqueue_style( 'fontawesome', get_template_directory_uri() . '/css/fontawesome-all.min.css', array(), '3.2', false  );*/

}

add_action('wp_enqueue_scripts','enqueue_my_styles_scripts');

function my_enqueue() {

	//wp_enqueue_style( 'my-custom-change-pwd-css', plugins_url( '/css/change-pwd-style.css', _FILE_ ) );

	wp_register_style( 'namespace', 'https://dev.raiseitfast.com/wp-content/plugins/change-password/css/change-pwd-style.css' );
	wp_enqueue_style( 'namespace' );

/*		wp_enqueue_script('jQuery-min', 'https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js', '1.0.1', '', true );	

	wp_enqueue_script('bootstrap-min', get_template_directory_uri().'/js/bootstrap.min.js', '1.0.0','', true );

	wp_enqueue_script('jquery-ui-js', get_template_directory_uri().'/js/jquery-ui.js', '1.0.0', '', true );

	wp_enqueue_script('loadingoverlay-min-js', get_template_directory_uri().'/js/loadingoverlay.min.js', '1.0.1', '', true );	

	wp_enqueue_script('fabric-js', get_template_directory_uri().'/js/fabric.js', '1.0.0', '', true );

	wp_enqueue_script('darkroom-js', get_template_directory_uri().'/js/darkroom.js', '1.0.0', '', true );

	wp_enqueue_script('bootstrap-select-js', get_template_directory_uri().'/js/bootstrap-select.min.js', '1.0.0', '', true );



	wp_enqueue_script('site-js', get_template_directory_uri().'/js/site-js.js', '1.0', '', true );

	wp_enqueue_script('form-fieldset-js', get_template_directory_uri().'/js/form-fieldset.js', '1.0', '', true );

	wp_enqueue_script('easing-min-js', get_template_directory_uri().'/js/jquery.easing.min.js', '1.0.0', '', true );

	wp_enqueue_script('bootstrap-datepicker-js', get_template_directory_uri().'/js/bootstrap-datepicker.js', '1.0.0', '', true );

	wp_enqueue_script('timepicker-min-js', get_template_directory_uri().'/js/timepicker.min.js', '1.0.0', '', true );

	wp_enqueue_script('easytabs-min-js', get_template_directory_uri().'/js/jquery.easytabs.min.js','', true );*/

	wp_localize_script('site-js', 'ajax_var', array(

		'url' => admin_url('admin-ajax.php'),

		'nonce' => wp_create_nonce('ajaxnonce')

	));

}

add_action( 'wp_enqueue_scripts', 'my_enqueue' );

function theme_menu()
{
	return wp_nav_menu(array(

		'echo' => false,

		'menu'           => 'header-menu',

		'theme_location' => 'primary',

		'container'      => true,

		'menu_class'     => 'menu navbar-nav',

	));

}

function recent_locations()
{
	$args = array( 'post_type' => 'retailer','numberposts' => 3,'post_status' =>'publish');
	$recent_posts = wp_get_recent_posts($args);
	foreach( $recent_posts as $recent ){
		?>
		<li><a href='<?php echo get_permalink($recent["ID"]) ?>'><?php echo $recent["post_title"]; ?></a></li>

		<?php
	}
	wp_reset_query();
}


//function for footer menu name company

function menu_footer_company()
{
	return wp_nav_menu(array(

		'echo' => false,

		'menu'           => 'Footer menu',

		'theme_location' => 'primary',

		'container'      => true,

		'menu_class'     => 'menu',

	));

}

//function for footer menu name Individuals

function menu_Individuals()
{
	return wp_nav_menu(array(

		'echo' => false,

		'menu'           => 'Individuals',

		'theme_location' => 'primary',

		'container'      => true,

		'menu_class'     => 'menu',

	));

}


function menu_business_sponsors()
{
	return wp_nav_menu(array(

		'echo' => false,

		'menu'           => 'Business Sponsors',

		'theme_location' => 'primary',

		'container'      => true,

		'menu_class'     => 'menu',

	));

}

// Creates Banner Images Custom Post Type

function banner_images_init() {

	$args = array(

		'label' => 'Banner Image',

		'public' => true,

		'show_ui' => true,

		'capability_type' => 'post',

		'hierarchical' => false,

		'rewrite' => array('slug' => 'banner'),

		'query_var' => true,

		'menu_icon' => 'dashicons-format-gallery',

		'supports' => array(

			'title',      

			'thumbnail',

		)

	);

	register_post_type( 'banner', $args );

}
add_action( 'init', 'banner_images_init' );


add_filter('wp_user_redirections', 'wp_user_redirection');
function wp_user_redirection(){

	if(is_user_logged_in())
	{
		if(current_user_can('administrator'))
		{		  
			wp_redirect( home_url());	
			//show_admin_bar( true );  
			
		}else{
			
			$current_user = wp_get_current_user();		

			$username =  $current_user->user_nicename;		

			wp_redirect( home_url('/user/').$username);
			//show_admin_bar( false );
		}
	}
	else
	{	 
		wp_redirect( home_url());		
	} 
//return $data;
	die();
}

/****************************************Code starts here for user login************************************/

add_action('wp_ajax_nopriv_check_user_login', 'check_user_login');

add_action('wp_ajax_check_user_login', 'check_user_login');

function check_user_login()
{
	global $wpdb;

	$credentials=array();

	$user_login = $_POST['user_login'];

	$user_pass  = $_POST['user_pass'];

	$credentials['user_login'] = $user_login;

	$credentials['user_password'] = $user_pass;

	$credentials['remember'] = true;

	//$userdata = get_user_by('email', $credentials['user_login']);

	if (filter_var($user_login, FILTER_VALIDATE_EMAIL)) 
	{ 
		$user = get_user_by('email', $credentials['user_login']);
		
	} else {
		
		$user = get_user_by('login', $credentials['user_login']);
	}
	
	
    /*$options = get_option("c2c_allow_multiple_accounts");
	
	//print_r($options);
	
	foreach( $options as $emls)
	{
		//print_r($emls);
		
		echo $cnt = count($emls);
		
	  $user_email_check = $credentials['user_login'];
		
	  if(in_array($user_email_check,$emls))
	  {
		  echo 'Yes';
		  
	  }else{
		  
		  echo 'Noo';
	  }
		
	}
	
	die('_____________'); */
	
	if ($user && wp_check_password( $credentials['user_password'], $user->data->user_pass, $user->data->ID))
	{
		$creds = array('user_login' => $user->data->user_login, 'user_password' => $credentials['user_password']);
		
		$user_detail = $creds['user_login'];		
	}

	//$result   = wp_check_password($credentials['user_password'], $user->data->user_pass, $user->data->ID);
	
	$user_id = $user->data->ID;

	$user_role = get_userdata($user_id);

	$userRole = implode(', ', $user_role->roles);

	$code = get_user_meta( $user_id, 'acc_activate', true );

	$user_type = get_user_meta( $user_id, 'user_type', true );

	/*if( false == get_user_by( 'email', $user_login ) ) 
	{
		echo '7';
	}	
	else*/

		if(false == $user)
		{
		//Invalid Email or Username
			echo '7';
		}		
		elseif(!$user_detail)
		{
		// Wrong Password
			echo '1';
		}
		elseif(isset($user_id) && !empty($user_id) && $userRole == 'administrator')
   {   //admin login

   	auto_login( $user );		
   	echo '3';
   }
   elseif(isset($user_type) && $user_type == donor)
   {   //donor login

   	auto_login( $user );	
   	echo '4';
   }
   elseif(isset($code) && $code == '1')
   {
	//Login successfully
   	auto_login( $user );
   	echo '2';		
   } 
   elseif(isset($code) && $code == '0' )
{	//User account nit authenticated yet
	send_auth_code_at_login($user_id);
	echo $user_id;			
}
else{		

	auto_login( $user );		
	echo '5';	
}	
die(); 			
}
// Method to set user logged in
function auto_login( $user ) 
{
	if ( !is_user_logged_in() ) 
	{
		@$user_id = $user->data->ID;

		@$user_login = $user->data->user_login;	

		@do_action( 'wp_login', $user->data->user_login );

		@wp_set_current_user( $user_id, $user_login );

		@wp_set_auth_cookie( $user_id );
	} 
}
add_action( 'after_setup_theme', 'auto_login' );

// ********** Send email to user at login if account is not activated while getting login**************
function send_auth_code_at_login($user)
{
	$user_info = get_userdata($user);
	
	$user_login = $user_info->data->user_login;

	$user_email = $user_info->data->user_email;	

	$user_name  = $user_info->data->first_name;	

	$user_phone = get_user_meta( $user, 'user_phone', true );
	//$user_phone = urldecode($u_phone);

	$user_fname = get_user_meta( $user, 'first_name', true );

	$code = get_user_meta( $user, 'has_to_be_activated', true );

	$subject = 'Your New Authentication Code';


	$message1 = "<html><body style='background:#f3f3f3;padding:20px 0;'><table border='0' cellpadding='0' cellspacing='0' style='margin:auto; max-width: 520px;width:100%;font-family: Arial;padding:20px;background:#fff;'><tbody>";
	$message1 .="<tr><td style='font-size: 16px;'>Hello ".ucfirst($user_fname).",</td></tr><tr height=20></tr>";
	$message1 .="<tr><td style='font-size: 16px; line-height: 20px;'>Welcome to Raise it Fast!</td></tr><tr height=30></tr>";
	$message1 .="<tr><td style='font-size: 16px; line-height: 20px;'>Please use this code to authenticate your account with Raise it Fast. <span style='background: #aaaaaa none repeat scroll 0 0;height: 45px;text-align: center;width: 101px;'>".$code."</span></td></tr><tr height=20></tr>";
	$message1 .="<tr><td style='font-size: 16px; line-height: 20px;'>'If you have any questions or concerns don't hesitate to use our website chat function, call us, or email us by going to our help page at ".site_url('/contact-us/')." Or, you can simply reply to this email. '</td></tr><tr height=30></tr>"; 
	$message1 .="<tr><td style='font-size: 16px; margin-top: 20px;'>Thanks for becoming a part of the Raise It Fast community! </td></tr></tbody></table><table border='0' cellpadding='0' cellspacing='0' style='margin:20px auto 0; max-width: 520px;width:100%;'>"; 

	$message1 .="<tr><td style='color: #999999; font-size: 12px; text-align: center;'>1401 Lavaca St #503, Austin, TX 78701</td></tr><tr height=20></tr>"; 
	$message1 .="<tr><td style='color: #999999; font-size: 12px; text-align: center;'><a href=".site_url()." style='text-decoration:none; color: #999999;'>The Raise it Fast Team</a></td></tr>";    
	$message1 .="</table></body></html>";

	wp_mail($user_email, $subject, $message1);

//=========Send Auth Code Via Text message ==================//

	$account_sid = get_option('twilio_account_sid'); 
	$auth_token  = get_option('twilio_auth_token');       
    //require('lib/twilio-php-latest/Services/Twilio.php');
	$client = new Services_Twilio($account_sid, $auth_token);    
    //$from = '+12182265630';    
	$from        = get_option('twilio_phone_no');

	try
	{
		$client->account->messages->sendMessage( $from, $user_phone, "Hello $user_fname, Your Authentication code is $code");
	}
	catch (Exception $e)
	{ 

		echo "11-";
	}
} 
/*****************/////////New sign Up process////////////////*******************/

add_action('wp_ajax_nopriv_new_check_user_signup', 'new_check_user_signup');

add_action('wp_ajax_new_check_user_signup', 'new_check_user_signup');

function new_check_user_signup()
{

	$pass_seed = str_split('ABCDEFGHIJKLMNOPQRSTUVWXYZ'.'0123456789'.'abcdefghijklmnopqrstuvwxyz'); 

	shuffle($pass_seed);

	$pass_rand = '';

	foreach (array_rand($pass_seed, 8) as $pass_kk) $pass_rand .= $pass_seed[$pass_kk];

	$user_info   = get_userdata(1);

	$admin_name  = $user_info->user_login;

	$admin_email = $user_info->user_email;

	$seed = str_split('0123456789'); 

	shuffle($seed);

	$rand = '';

	foreach (array_rand($seed, 3) as $kk) $rand .= $seed[$kk];

	$user_firstname = esc_sql($_POST['first_name']);

	$user_lastname  = esc_sql($_POST['last_name']);

	$user_login     = strtolower($user_firstname).strtolower($user_lastname).$rand;

	$user_pass      = $pass_rand;

	$user_email     = esc_sql($_POST['user_email']);

	$u_phone     = $_POST['user_phone'];

	$user_phone = urldecode($u_phone);

	$full_name = $user_firstname.' '.$user_lastname;

	$info = array();

	$info['user_nicename'] = $info['nickname'] = $info['display_name'] = $info['user_login'] = sanitize_user($user_login) ;

	$info['user_pass']     = sanitize_text_field($user_pass);

	$info['user_email']    = sanitize_email( $user_email );

// Register the user

	$user_register = wp_insert_user( $info );

	update_user_meta( $user_register, 'first_name', $user_firstname );

	update_user_meta( $user_register, 'last_name', $user_lastname );

	update_user_meta( $user_register, 'user_phone', $user_phone );

//Check if any error while signing up

	if ( is_wp_error($user_register) )
	{	
		$error  = $user_register->get_error_codes()	;

		if(in_array('empty_user_login', $error))
		{
//***********Empty_user_login**************

			echo '0';

		}
		elseif(in_array('existing_user_login',$error))
		{
//**********Username is already registered**********

			echo '1';
		}
		elseif(in_array('existing_user_email',$error))
		{

//***********Email address is already registered***************

			echo '2';

		}else{

			echo '4';

		}

	}else{

//Sign Up Notifications For admin and User

		if($user_register && !is_wp_error( $user_register ))
		{
			$user = new WP_User($user_register);

			$user_login = stripslashes($user->user_login);

			$user_email = stripslashes($user->user_email);

// Email Notification For Admin

			@$header1 .= "MIME-Version: 1.0\n";

			@$header1 .= "Content-Type: text/html; charset=utf-8\n";

			@$headers1 .= "From:" . $admin_email; 

			$message = "<html><body style='background:#f3f3f3;padding:20px 0;'><table border='0' cellpadding='0' cellspacing='0' style='margin:auto; max-width: 520px;width:100%;font-family: Arial;padding:20px;background:#fff;'><tbody>";
			$message .="<tr><td style='font-size: 16px;'>Hello ".ucfirst($admin_name).",</td></tr><tr height=20></tr>";
			$message .="<tr><td style='font-size: 16px; line-height: 20px;'>New user registration on Raise it Fast.</td></tr><tr height=20></tr>";
			$message .="<tr><td style='font-size: 16px; line-height: 20px;'>Username: ".$user_firstname."</td></tr><tr height=20></tr>";
			$message .="<tr><td style='font-size: 16px; line-height: 20px;'>E-mail: ".$user_email."</td></tr><tr height=30></tr>"; 
			$message .="<tr><td style='font-size: 16px; margin-top: 20px;'>Thank you in advance! </td></tr></tbody></table><table border='0' cellpadding='0' cellspacing='0' style='margin:20px auto 0; max-width: 520px;width:100%;'>"; 

			$message .="<tr><td style='color: #999999; font-size: 12px; text-align: center;'>1401 Lavaca St #503, Austin, TX 78701</td></tr><tr height=20></tr>"; 
			$message .="<tr><td style='color: #999999; font-size: 12px; text-align: center;'><a href=".site_url()." style='text-decoration:none; color: #999999;'>The Raise it Fast Team</a></td></tr>";    
			$message .="</table></body></html>";

			$subject1 = "New User Registration";

			$subject1 = "=?utf-8?B?" . base64_encode($subject1) . "?=";				

//wp_mail(get_option('admin_email'), sprintf(__('[%s] New User Registration'), get_option('blogname')), $message);

			wp_mail($admin_email, $subject1, $message, $header1);

// Email Notification For Users

			$seed = str_split('ABCDEFGHIJKLMNOPQRSTUVWXYZ'.'0123456789'); 

			shuffle($seed);

			$rand = '';

			foreach (array_rand($seed, 5) as $k) $rand .= $seed[$k];

			add_user_meta( $user_register, 'has_to_be_activated', $rand, true );

			add_user_meta( $user_register, 'acc_activate', 0, true );

			@$header .= "MIME-Version: 1.0\n";

			$header .= "Content-Type: text/html; charset=utf-8\n";

			@$headers .= "From:" . $admin_email; 

			$message1 = "<html><body style='background:#f3f3f3;padding:20px 0;'><table border='0' cellpadding='0' cellspacing='0' style='margin:auto; max-width: 520px;width:100%;font-family: Arial;padding:20px;background:#fff;'><tbody>";
			$message1 .="<tr><td style='font-size: 16px;'>Hello ".ucfirst($user_firstname).",</td></tr><tr height=20></tr>";
			$message1 .="<tr><td style='font-size: 16px; line-height: 20px;'>Welcome to Raise it Fast!</td></tr><tr height=20></tr>";
			$message1 .="<tr><td style='font-size: 16px; line-height: 20px;'>".$change_title."</td></tr><tr height=20></tr>";
			$message1 .="<tr><td style='font-size: 16px; line-height: 20px;'>Your Account Password is :- <span style='background: #aaaaaa none repeat scroll 0 0;height: 45px;text-align: center;width: 101px; color: #fff; padding: 10px;'>".$user_pass."</span></td></tr><tr height=30></tr>";
			$message1 .="<tr><td style='font-size: 16px; line-height: 25px;'>Please use this code to authenticate your account. <span style='background: #aaaaaa none repeat scroll 0 0;height: 25px;text-align: center;width: 101px; color: #fff; padding: 10px;display:inline-block; vertical-align:top;margin-top:8px;'>".$rand."</span></td></tr><tr height=20></tr>";
			$message1 .="<tr><td style='font-size: 16px; line-height: 20px;'>If you have any questions or concerns don't hesitate to use our website chat function, call us, or email us by going to our help page at ".site_url('/contact-us/')." Or, you can simply reply to this email.</td></tr><tr height=30></tr>"; 
			$message1 .="<tr><td style='font-size: 16px; margin-top: 20px;'>Thank you for becoming a part of the Raise It Fast community! </td></tr></tbody></table><table border='0' cellpadding='0' cellspacing='0' style='margin:20px auto 0; max-width: 520px;width:100%;'>"; 

			$message1 .="<tr><td style='color: #999999; font-size: 12px; text-align: center;'>1401 Lavaca St #503, Austin, TX 78701</td></tr><tr height=20></tr>"; 
			$message1 .="<tr><td style='color: #999999; font-size: 12px; text-align: center;'><a href=".site_url()." style='text-decoration:none; color: #999999;'>The Raise it Fast Team</a></td></tr>";    
			$message1 .="</table></body></html>";

			$subject = "Welcome to Raise It Fast!";

			$subject = "=?utf-8?B?" . base64_encode($subject) . "?=";		

//$check = wp_mail($user_email, sprintf(__('[%s] Your Authentication Code'), get_option('blogname')), $message1);

			$check = wp_mail($user_email, $subject, $message1, $header);	

//=========Send Auth Code Via Text message ==================//    

			$account_sid = get_option('twilio_account_sid'); 
			$auth_token  = get_option('twilio_auth_token');       
			$client = new Services_Twilio($account_sid, $auth_token);    
/*			$from        = get_option('twilio_phone_no');
$client->account->messages->sendMessage( $from, $user_phone, "Hello $user_firstname, Your Authentication code is $rand and Your Password is $user_pass");*/

$from  = get_option('twilio_phone_no');

try
{
	$client->account->messages->sendMessage( $from, $user_phone, "Hello $user_firstname, Your Authentication code is $rand and Your Password is $user_pass");
	echo $user_register;
}
catch (Exception $e)
{ 
	$error_id = "9";
	/*echo "9"; - echo $user_register;*/
	echo $error_id.'-'.$user_register;
}


}			


}
die();
}

/************** /////////////////////Sign up Ajax Process Ends Here///////////////// ************/

function my_email_content_type() 
{
	return "text/html";
}

add_filter ("wp_mail_content_type", "my_email_content_type");

/********************* Check Auth Code **************************/

function check_auth_code()
{

// do_action( 'user_register', $user_id );

	$authcode  = esc_sql($_POST['auth_code']);

	$uid       = esc_sql($_POST['u_id']);
	$user_info = get_userdata($uid);

//echo '<pre>';

//print_r($user_info);

	$User_id    = $user_info->ID;
	$User_login = $user_info->user_login;
	$User_pass  = $user_info->user_pass;
	$User_email = $user_info->user_email;
	$auth_code = get_user_meta($uid, 'has_to_be_activated', true);
	if($auth_code ==  $authcode)
	{	
//auth_user_login($User_login, $User_pass, $User_email );
		wp_set_current_user($User_id, $User_login);
		wp_set_auth_cookie($User_id);
		do_action('wp_login', $User_login);
		update_user_meta( $User_id, 'acc_activate', 1 );
//wp_redirect( home_url('/user/').$User_login);

		echo '1';
	}else{
		echo '2';

	}  
	die();
}
function ajax_auth_init()

{	
	add_action('wp_ajax_nopriv_check_auth_code', 'check_auth_code');

	add_action('wp_ajax_check_auth_code', 'check_auth_code');	

	add_action( 'after_setup_theme', 'check_auth_code' );

}	
if (!is_user_logged_in()) {
	add_action('init', 'ajax_auth_init');
}	


add_filter('check_auth_after_login', 'check_auth_after_login');

function check_auth_after_login()

{

	if(is_user_logged_in() && !current_user_can('administrator') && !current_user_can('editor'))

	{
		$current_user = wp_get_current_user();
		$user_id = $current_user->ID;
		$user_email = $current_user->user_email;
		$user_firstname =  get_user_meta($user_id,'first_name', true);
		$user_phone   = get_user_meta($user_id,'user_phone', true);
		$acc_activate = get_user_meta($user_id,'acc_activate', true);
		$has_to_be_activated = get_user_meta($user_id,'has_to_be_activated', true);
		if(($user_phone =='' || $user_phone == $user_phone) && ($acc_activate == '' || $acc_activate == 0) && ($has_to_be_activated == '' || $has_to_be_activated == $has_to_be_activated))

		{
			$seed = str_split('ABCDEFGHIJKLMNOPQRSTUVWXYZ'.'0123456789'); 
			shuffle($seed);
			$rand = '';
			foreach (array_rand($seed, 5) as $k) $rand .= $seed[$k];
			update_user_meta( $user_id, 'has_to_be_activated', $rand, true );
			update_user_meta( $user_id, 'acc_activate', 0, true );
			?>
			<div class="modal fade add_phone_number" id="add_phone_number" style="display:none;">
				<div class="modal-dialog">
					<div class="modal-content">
						<div class="modal-header">
							<h4 class="modal-title">Welcome to Raise It Fast</h4>
						</div>
						<div class="modal-body">
							<div class="error-left">

								<div class="alert alert-success add_phone_number_users" style="display:none;">
									Congratulations, you have successfully added your phone number to your account.
								</div>
								<div class="alert alert-danger add_phone_number_error" style="display:none;"></div>

								<div id="dvLoadingsingup" style="display:none;"></div>
							</div>
							<h5 class="act-acc alert alert-info">It looks like your account is not authenticated with Raise It Fast.</h5>

							<p class="act-acc-p">An authentication code will be sent to your phone number and email, please add your phone number in the space below to autheticate your account with Raise It Fast. </p>
							<p> 
								<form name="add_phone_number" method="post" action="#" id="add_phone_number_form"> 
									<?php wp_nonce_field('ajax-login-nonce', 'security'); ?>
									<div class="auth-code-in">
										<input type="tel" name="add_phone_number_users" id="add_phone_number_users" class="form-control add_phone_number_usersw" placeholder="" onkeypress="return isNumber(event)">
										<input type="hidden" value="<?php echo $user_id;?>" id="social_media_user_id">
									</div>
									<div class="sub-opt-in">
										<input name="submit" class="submit action-button" value="Submit" type="submit"  id="add_phone_number_btn_sub">
									</div>
								</form>
							</p>
						</div>
					</div>
				</div>
			</div>

			<!-- *************** Authenication Code Form For Users registered using socail media********* -->

			<div class="modal fade social_media_users" id="social_media_users" style="display:none;">

				<div class="modal-dialog">

					<div class="modal-content">

						<div class="modal-header">



							<h4 class="modal-title">Welcome to Raise It Fast</h4>

						</div>

						<div class="modal-body">
							<div class="error-left">
								<div class="alert alert-success auth-success-social_media_users" style="display:none;">

									Congratulations, you have successfully authenticated your account with Raise It Fast.

								</div>
								<div class="alert alert-danger auth-error-social_media_users" style="display:none;">

									<strong>Error:</strong> Please enter the authentication code sent to your phone texting service and email address.

								</div>



								<div class="alert alert-danger auth-error-social_media_users1" style="display:none;">

									<strong>Error:</strong> Your authentication code didn't match, please re-check your email or text service for this code.

								</div>



								<div id="dvLoadingsingup" style="display:none;"></div>



							</div>

							<span class="act-acc-p">An authentication code has been sent to your email and phone, please check your email and insert your code below to authenticate your account with Raise It Fast. </span>



							<p> 

								<form name="social_media_users" method="post" action="#" id="social_media_users_auth_form"> 

									<?php wp_nonce_field('ajax-login-nonce', 'security'); ?>

									<div class="auth-code-in">

										<input name="auth_code_social_media_users" value="" type="text" class="auth-code form-control" id="auth_code_login_social_media_users" placeholder="Your Authentication Code">

										<input type="hidden" value="<?php echo $user_id;?>" id="social_media_user_id">
									</div>
									<div class="sub-opt-in">

										<input name="submit" class="submit action-button" value="Submit" type="submit"  id="social_media_users_btn_sub">

									</div>

								</form>

							</p>

						</div>

					</div>

				</div>

			</div>

			<?php	  

		}

	} 

}



/***************** Change Account type Check Code Ends HEre**************/



add_action('wp_ajax_nopriv_check_auth_code_aftr_login', 'check_auth_code_aftr_login');

add_action('wp_ajax_check_auth_code_aftr_login', 'check_auth_code_aftr_login');



function check_auth_code_aftr_login()

{

	$authcode  = esc_sql($_POST['auth_code']);

	$uid       = esc_sql($_POST['u_id']);



	$user_info = get_userdata($uid);



	$User_id    = $user_info->ID;

	$User_login = $user_info->user_login;

	$User_pass  = $user_info->user_pass;

	$User_email = $user_info->user_email;



	$auth_code = get_user_meta($uid, 'has_to_be_activated', true);



	if($auth_code ==  $authcode)

	{	

//auth_user_login($User_login, $User_pass, $User_email );



		update_user_meta( $User_id, 'acc_activate', 1 );

		wp_set_current_user($User_id, $User_login);

		wp_set_auth_cookie($User_id);

		do_action('wp_login', $User_login);	 

//wp_redirect( home_url('/user/').$User_login);



		echo '1';



	}else{

		echo '2';

	}

	die();



}	



/*******************//////////////// Custom Post Types Creation Code///////////////**************************/



function create_rasieit_taxonomies() {

	$labels = array(

		'name'              => _x( 'Retailer', 'retailer' ),

		'singular_name'     => _x( 'Retailer', 'retailer' ),

		'search_items'      => __( 'Search Retailer Events', 'retailer' ),

		'all_items'         => __( 'All Retailer Events', 'retailer' ),

		'parent_item'       => __( 'Parent Retailer', 'retailer' ),

		'parent_item_colon' => __( 'Parent Retailer:', 'retailer' ),

		'edit_item'         => __( 'Edit Retailer Event', 'retailer' ),

		'update_item'       => __( 'Update Retailer Event', 'retailer' ),

		'add_new_item'      => __( 'Add New Retailer Event', 'retailer' ),

		'new_item_name'     => __( 'New Retailer Name', 'retailer' ),

		'menu_name'         => __( 'Retailer', 'retailer' ),

	);

	$args = array(

		'hierarchical'      => false,

		'labels'            => $labels,

		'show_ui'           => true,

		'show_admin_column' => true,

		'query_var'         => true,

		'show_in_menu'      => true,

		'menu_position'     => 5,

		'menu_icon'         => 'dashicons-groups',

		'show_in_nav_menus' => true,

		'publicly_queryable'=> true,

		'exclude_from_search' => false,

		'has_archive'       => true,

		'query_var'         => true,

		'rewrite'           => array( 'slug' => 'retailer' ),

		'public'            => true,

		'supports'          => array( 'title', 'editor', 'thumbnail' ),

/* 'capability_type'     => array('retailer_post','retailer_posts'),

'map_meta_cap' => true,*/

); 

	register_post_type( 'retailer', $args );
}

add_action( 'init', 'create_rasieit_taxonomies' );


/*************Adding Author Column To Retailer Section ******************/


add_filter('manage_retailer_posts_columns', 'my_columns_head_only_retailer', 10);
add_action('manage_retailer_posts_custom_column', 'my_columns_content_only_retailer', 10, 2);

function my_columns_head_only_retailer($defaults) {
	$defaults['author_col'] = 'Author';
	return $defaults;
}
function my_columns_content_only_retailer($column_name, $post_ID) 
{
	if ($column_name == 'author_col') 
	{
		$author_id = get_post_field ('post_author', $post_ID);
		$display_name = get_the_author_meta( 'display_name' , $author_id ); 
		echo $display_name;
		
	}
}


//*************************custom post type fundraiser******************//

function create_fundraiser_rasieit_taxonomies() 

{	

	$labels = array(

		'name'              => _x( 'Fundraisers', 'fundraiser' ),

		'singular_name'     => _x( 'Fundraisers', 'fundraiser' ),

		'search_items'      => __( 'Search Fundraiser Events', 'fundraiser' ),

		'all_items'         => __( 'All Fundraiser Events', 'fundraiser' ),

		'parent_item'       => __( 'Parent Fundraiser', 'fundraiser' ),

		'parent_item_colon' => __( 'Parent Fundraiser:', 'fundraiser' ),

		'edit_item'         => __( 'Edit Fundraiser Event', 'fundraiser' ),

		'update_item'       => __( 'Update Fundraiser Event', 'fundraiser' ),

		'add_new_item'      => __( 'Add New Fundraiser Event', 'fundraiser' ),

		'new_item_name'     => __( 'New Fundraiser Name', 'fundraiser' ),

		'menu_name'         => __( 'Fundraiser', 'fundraiser' ),

	);

	$args = array(

		'hierarchical'      => true,

		'labels'            => $labels,

		'show_ui'           => true,

		'show_admin_column' => true,

		'query_var'         => true,

		'show_in_menu'      => true,

		'menu_position'     => 6,

		'menu_icon'         => 'dashicons-smiley',

		'show_in_nav_menus' => true,

		'publicly_queryable'=> true,

		'exclude_from_search' => false,

		'has_archive'       => true,

		'query_var'         => true,

		'rewrite'           => array( 'slug' => 'fundraiser' ),

		'public'            => true,

		'supports'          => array( 'title', 'editor', 'thumbnail'),

/*'capability_type'     => array('fundraiser_post','fundraiser_posts'),

'map_meta_cap' => true,*/

);

	register_post_type( 'fundraiser', $args );

// Add new taxonomy, NOT hierarchical (like tags)

	$labels = array(

		'name'                       => _x( 'Category', 'fund_cate' ),

		'singular_name'              => _x( 'Category', 'fund_cate' ),

		'search_items'               => __( 'Search Category', 'fund_cate' ),

		'popular_items'              => __( 'Popular Category', 'fund_cate' ),

		'all_items'                  => __( 'All Category', 'fund_cate' ),

		'parent_item'                => __( 'Raise Parent Category' ),

		'parent_item_colon'          => __( 'Raise Parent Category:' ),

		'edit_item'                  => __( 'Edit Category', 'fund_cate' ),

		'update_item'                => __( 'Update Category', 'fund_cate' ),

		'add_new_item'               => __( 'Add New Category', 'fund_cate' ),

		'new_item_name'              => __( 'New Category Name', 'fund_cate' ),

		'view_item'                  => __( 'View Page', 'fund_cate'  ),

		'separate_items_with_commas' => __( 'Separate Category with commas', 'fund_cate' ),

		'add_or_remove_items'        => __( 'Add or remove Category', 'fund_cate' ),

		'choose_from_most_used'      => __( 'Choose from the most used Category', 'fund_cate' ),

		'not_found'                  => __( 'No Category found.', 'fund_cate' ),

		'menu_name'                  => __( 'Categories', 'fund_cate' ),

	);

	$args = array(

		'hierarchical'          => true,

		'labels'                => $labels,

		'show_ui'               => true,

		'show_admin_column'     => true,

		'update_count_callback' => '_update_post_term_count',

		'query_var'             => true,

		'has_archive'           => true,

		'rewrite'               => array( 'slug' => 'fundraise-category', 'with_front' => true ),

	);

	register_taxonomy( 'fund_cate', 'fundraiser', $args );

	flush_rewrite_rules();	

}

add_action( 'init', 'create_fundraiser_rasieit_taxonomies' );



/**************** End Permission to Users to Access admin Menus ********************/
/*if( function_exists('acf_add_options_page') ) {

acf_add_options_page(array(
'page_title' 	=> 'Theme Settings',
'menu_title'	=> 'Theme Settings',
'menu_slug' 	=> 'theme-general-settings',
'capability'	=> 'edit_posts',
'redirect'		=> false
));
}
*/
function footer_content()
{

	$frontpage_id = get_option( 'page_on_front' );
	?>	
	<div class="col-md-4 col-sm-6 footer_search footer_view">
		<div class="fotter-sec fotter_sec_icon">
			<h1><?php echo get_field("footer_contact_title", $frontpage_id); ?></h1>
			<ul class="list-unstyled address1">
				<a><li class="location_footer_img">
					<img src ="<?php bloginfo('template_directory');?>/images/location_footer.png" class="img-responsive" style="object-fit: contain; height: auto; width: 13px;  display: inline-block; vertical-align: sub; margin-right: 5px;">
					<i class="fa fa-map-marker" aria-hidden="true"></i>
					<span><?php echo get_field("footer_address_deatl", $frontpage_id); ?></span>
				</li></a>
				<a><li class="phone_footer_img">
					<img src ="<?php bloginfo('template_directory');?>/images/phone_footer.png" class="img-responsive" style="object-fit: contain;  height: 15px; width: 15px; display: inline-block; margin-right: 5px; vertical-align: sub;">
					<i class="fa fa-phone" aria-hidden="true"></i>
					<span><?php echo get_field("phone_and_fax_no", $frontpage_id); ?></span>
				</li></a>
				<a><li class="email_footer_img">
					<img src ="<?php bloginfo('template_directory');?>/images/email_footer.png" class="img-responsive" style="object-fit: contain; height: auto; width: 15px;  display: inline-block; margin-right: 5px; vertical-align: sub;">
					<i class="fa fa-envelope-o" aria-hidden="true"></i>
					<span><?php echo get_field("footer_email", $frontpage_id); ?></span>
				</li></a>
				<a><li class="location_footer_img">
					<img src ="<?php bloginfo('template_directory');?>/images/location_footer.png" class="img-responsive" style="object-fit: contain; height: auto; width: 13px;  display: inline-block; margin-right: 5px; vertical-align: sub;">
					<i class="fa fa-map-marker" aria-hidden="true"></i>
					<span><?php echo get_field("development_location", $frontpage_id); ?></span>
				</li></a>
				<a><li class="phone_footer_img">
					<img src ="<?php bloginfo('template_directory');?>/images/phone_footer.png" class="img-responsive" style="object-fit: contain;  height: 15px; width: 15px; display: inline-block; margin-right: 5px; vertical-align: sub;">
					<i class="fa fa-phone" aria-hidden="true"></i><span><?php echo get_field("development_phone", $frontpage_id); ?></span>
				</li></a>
			</ul>
		</div>
	</div>
	<?php
}

add_action('footer_content', 'footer_content' );

//code for search category name

add_action('wp_ajax_nopriv_search_post_data', 'search_post_data');
add_action('wp_ajax_search_post_data', 'search_post_data');

function search_post_data()
{
	$cate_nam = esc_sql($_POST['cate_names']);
	global $wpdb;
	$paged = ( get_query_var( 'paged' ) ) ? get_query_var( 'paged' ) : 1;
	$get_cate = $wpdb->get_results("SELECT * FROM wp_posts WHERE post_title LIKE '".$cate_nam."%' LIMIT 5
		") ;

	$args = array('post_type'=>'fundraiser','post_status'=>'publish','posts_per_page' => 6, 'paged' => $paged, 'meta_query'=>
		array(
			'relation' => 'OR',
			array(
				'key' => 'fund_city',
				'value'  => $cate_nam,
				'compare' => 'LIKE'
			),
			array(
				'key' => 'fund_title',
				'value'  => $cate_nam,
				'compare' => 'LIKE'
			),
			array(
				'key' => 'fund_zip',
				'value'  => $cate_nam,
				'compare' => 'LIKE'
			)));



	$loop = new WP_Query($args);
	if ( $loop->have_posts() ) {
		echo '<div class="triangle_get"></div>';
		while( $loop->have_posts() ) : $loop->the_post();
			echo '<div class="show_data">';

			echo '<a href="'.get_permalink().'"><h1><i class="fa fa-chevron-right" aria-hidden="true"></i>
			'.get_the_title().'</h1></a><div class="search_thumb"><a href="'.get_permalink().'"><img src="'.get_the_post_thumbnail_url(get_the_ID(), 'small').'"></a></div>';
			echo '</div>';
		endwhile;
		wp_reset_query();
	} 
	else
	{
		echo "<div class='alert alert-danger fs-error-fund'><span style='color:#000;'> No results found!</span></div>";

	} ?>

	<?php die();
}


//*****************PAGINATION CODE ADDED BY GAURAV********************//

function pagination($pages = '', $range = 1)
{  
	$showitems = ($range * 2)+1;  

	global $paged;
	if(empty($paged)) $paged = 1;

	if($pages == '')
	{
		global $wp_query;
		$pages = $wp_query->max_num_pages;
		if(!$pages)
		{
			$pages = 1;
		}
	}   

	if(1 != $pages)
	{
		echo '<div class="col-md-12 col-sm-12 text-center fund_pagination">';
		echo '<nav aria-label="Page navigation">';
		echo '<ul class="pagination">';

         //if($paged > 2 && $paged > $range+1 && $showitems < $pages) echo "<a href='".get_pagenum_link(1)."'>&laquo; First</a>";
		if($paged > 1 && $showitems < $pages) 

			echo "<li><a href='".get_pagenum_link($paged - 1)."' aria-label=\"Previous\"><span aria-hidden=\"true\">«</span></a>";

		for ($i=1; $i <= $pages; $i++)
		{
			if (1 != $pages &&( !($i >= $paged+$range+1 || $i <= $paged-$range-1) || $pages <= $showitems ))
			{
				echo ($paged == $i)? "<li class=\"active-2\"><a>".$i."</a></li>":"<li><a href='".get_pagenum_link($i)."' class=\"inactive\">".$i."</a></li>";
			}
		}

		if ($paged < $pages && $showitems < $pages) echo "<li><a aria-label=\"Next\" href=\"".get_pagenum_link($paged + 1)."\"> <span aria-hidden=\"true\">»</span></a>";  


		echo '</ul>';
		echo '</nav>';
		echo "</div>\n";
	}
}


add_action('wp_ajax_nopriv_fundpost_filter_by_category', 'fundpost_filter_by_category');
add_action('wp_ajax_fundpost_filter_by_category', 'fundpost_filter_by_category');

function fundpost_filter_by_category()
{
	global $wpdb;
	global $paged; global $args;
	$paged = ( get_query_var( 'paged' ) ) ? get_query_var( 'paged' ) : 1;
	$args= null;
	$cat_id = $_POST['select_cats'];

	$args =array(
		'posts_per_page' => -1, 
		'post_type' => 'fundraiser',
		'post_status' =>'publish',
		'paged' => $paged,
		'tax_query' => array(
			array(
				'taxonomy' => 'fund_cate',
            'field' => 'term_id', //can be set to ID
            'terms' => $cat_id //if field is ID you can reference by cat/term number
        )
		)
	);
	$loop= new WP_Query( $args );
	
	$post_query =array(
		'posts_per_page' => -1, 
		'post_type' => 'fundraiser',
		'post_status' =>'publish',
		'paged' => $paged,
		'tax_query' => array(
			array(
				'taxonomy' => 'fund_cate',
            'field' => 'term_id', //can be set to ID
            'terms' => $cat_id //if field is ID you can reference by cat/term number
        )
		)
	);
	$post_loop = new WP_Query( $post_query );
	$count_fundbycate = $post_loop->post_count;



	?>
	<div class="row campaign-list post-listing">
		<input type="hidden" id="count_fundbycate" value="<?php echo $count_fundbycate ;?>">
	<?php
	if( $loop->have_posts())
	{
		?>
		
			<?php
			while ( $loop->have_posts() ) : $loop->the_post();
				$post_id =  get_the_ID();
				$trimtitle = get_the_title();				
				$shorttitle = wp_trim_words( $trimtitle, $num_words = 3, $more = '… ' );
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
								$date1 = date("Y-m-d");
								$date2 = $last_donation;
								$diff = abs(strtotime($date2) - strtotime($date1));
								$years = floor($diff / (365*60*60*24));
								$months = floor(($diff - $years * 365*60*60*24) / (30*60*60*24));
								$days = floor(($diff - $years * 365*60*60*24 - $months*30*60*60*24)/ (60*60*24));
								$week = floor($days/7);
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
								if($days == 0 && $week == 0)
								{
									$show_date = "Last donation today";
								}

								else if(($days > 0 && $days <= 7 ) && $week == 0)
								{
									$show_date = "Last donation ". $days.' '. $s_days . " ago";
								}
								else
								{
									$show_date = "Last donation ". $week.' '. $s_week . " ago";
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
								<?php echo do_shortcode('[shareaholic app="share_buttons" id="27918553"]'); ?>

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
		echo "<div class='alert alert-danger fs-error-fund fs-error-fund-cat'><div class='row campaign-list'><span style='color:red;'>There are no campaigns available in this Category.</span></div></div>";
	}

	?>
<div class="load-more-fund-bycate"></div>	
</div>
<div style="clear:both"></div>
<div class="loader" style="display:none;text-align:center">								
	<img class="img-loader" src="<?php bloginfo('template_directory');?>/images/ajax-loader.gif">
</div>

<div class='alert alert-danger fs-error-fund fs-error-fund-part nofund-bycate' style="display:none">
	<div class='row campaign-list'>
		<span style='color:red;'>No more campaigns available in this Category.</span>
	</div>
</div>
	<?php


	die();

}

add_action('wp_ajax_nopriv_fundpost_filter_by_fun_name', 'fundpost_filter_by_fun_name');
add_action('wp_ajax_fundpost_filter_by_fun_name', 'fundpost_filter_by_fun_name');

function fundpost_filter_by_fun_name()
{
	global $wpdb;
	global $paged; global $args;
	$paged = ( get_query_var( 'paged' ) ) ? get_query_var( 'paged' ) : 1;
	$args= null;

	if(isset($_POST['search_names']) && !empty($_POST['search_names']))

	{
		$fund_name = $_POST['search_names'];
	}
	//get fundraiser_post_id

	//$postid = $wpdb->get_var( "SELECT ID FROM $wpdb->posts WHERE post_title LIKE '".$fund_name."'");

	$args = array( 'post_type' => 'fundraiser', 's' => $fund_name, 'posts_per_page' => 9,'post_status' =>'publish','paged' => $paged);
	$loop = new WP_Query( $args );
	
	$post_query = array( 'post_type' => 'fundraiser', 's' => $fund_name, 'posts_per_page' => -1,'post_status' =>'publish','paged' => $paged);
	$post_loop = new WP_Query( $post_query );
	$count_fundbyname = $post_loop->post_count;
	?>
	<div class="row campaign-list post-listing">
	<input type="hidden" id="count_fundbyname" value="<?php echo $count_fundbyname ;?>">
		<?php
		if( $loop->have_posts())
		{
			while ( $loop->have_posts() ) : $loop->the_post();
				$post_id =  get_the_ID();
				$trimtitle = get_the_title();				
				$shorttitle = wp_trim_words( $trimtitle, $num_words = 3, $more = '… ' );
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
								$date1 = date("Y-m-d");
								$date2 = $last_donation;
								$diff = abs(strtotime($date2) - strtotime($date1));
								$years = floor($diff / (365*60*60*24));
								$months = floor(($diff - $years * 365*60*60*24) / (30*60*60*24));
								$days = floor(($diff - $years * 365*60*60*24 - $months*30*60*60*24)/ (60*60*24));
								$week = floor($days/7);
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
								if($days == 0 && $week == 0)
								{
									$show_date = "Last donation today";
								}

								else if(($days > 0 && $days <= 7 ) && $week == 0)
								{
									$show_date = "Last donation ". $days.' '. $s_days . " ago";
								}
								else
								{
									$show_date = "Last donation ". $week.' '. $s_week . " ago";
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
								<?php echo do_shortcode('[shareaholic app="share_buttons" id="27918553"]'); ?>

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

	?>
<div class="load-more-fund-byname"></div>
</div>
<div style="clear:both"></div>
<div class="loader" style="display:none;text-align:center">								
	<img class="img-loader" src="<?php bloginfo('template_directory');?>/images/ajax-loader.gif">
</div>

<div class='alert alert-danger fs-error-fund fs-error-fund-part nofund-byname' style="display:none">
	<div class='row campaign-list'>
		<span style='color:red;'>No more campaigns available by this name.</span>
	</div>
</div>
	<?php

	die();

}


add_action('wp_ajax_nopriv_fundpost_filter_by_loaction', 'fundpost_filter_by_loaction');
add_action('wp_ajax_fundpost_filter_by_loaction', 'fundpost_filter_by_loaction');

function fundpost_filter_by_loaction()
{
	global $wpdb;
	global $paged; global $args;
	$paged = ( get_query_var( 'paged' ) ) ? get_query_var( 'paged' ) : 1;
	$args= null;

	if(isset($_POST['select_ret_ids']) && !empty($_POST['select_ret_ids']))

	{
		$reat_id = $_POST['select_ret_ids'];
	}

	$query_args_meta = array(
		'posts_per_page' => 9,
		'post_type' => 'fundraiser',
		'post_status' =>'publish',
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
	$loop = new WP_Query($query_args_meta);
	
	$post_query = array(
		'posts_per_page' => -1,
		'post_type' => 'fundraiser',
		'post_status' =>'publish',
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
	$post_loop = new WP_Query( $post_query );
	$count_fundbyzip = $post_loop->post_count;
	?>
	<div class="row campaign-list post-listing">
	<input type="hidden" id="count_fundbyzip" value="<?php echo $count_fundbyzip ;?>">
		<?php
		if( $loop->have_posts())
		{
			?>
			
			<?php
			while ( $loop->have_posts() ) : $loop->the_post();
				$post_id =  get_the_ID();
				$trimtitle = get_the_title();				
				$shorttitle = wp_trim_words( $trimtitle, $num_words = 3, $more = '… ' );
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
				<div class="col-md-4 col-sm-4 fundraisers_listing_view">
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
								$date1 = date("Y-m-d");
								$date2 = $last_donation;
								$diff = abs(strtotime($date2) - strtotime($date1));
								$years = floor($diff / (365*60*60*24));
								$months = floor(($diff - $years * 365*60*60*24) / (30*60*60*24));
								$days = floor(($diff - $years * 365*60*60*24 - $months*30*60*60*24)/ (60*60*24));
								$week = floor($days/7);
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
								if($days == 0 && $week == 0)
								{
									$show_date = "Last donation today";
								}

								else if(($days > 0 && $days <= 7 ) && $week == 0)
								{
									$show_date = "Last donation ". $days.' '. $s_days . " ago";
								}
								else
								{
									$show_date = "Last donation ". $week.' '. $s_week . " ago";
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
							<?php echo do_shortcode('[shareaholic app="share_buttons" id="27918553"]'); ?>

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
			echo "<div class='alert alert-danger fs-error-fund fs-error-fund-zip'><div class='row campaign-list'><span style='color:red;'>There are no campaigns available in this Partner.</span></div></div>";
		}
		?>
<div class="load-more-fund-byzip"></div>		
</div>
<div style="clear:both"></div>
<div class="loader" style="display:none;text-align:center">								
	<img class="img-loader" src="<?php bloginfo('template_directory');?>/images/ajax-loader.gif">
</div>

<div class='alert alert-danger fs-error-fund fs-error-fund-part nofund-byzip' style="display:none">
	<div class='row campaign-list'>
		<span style='color:red;'>No more campaigns available in this Partner.</span>
	</div>
</div>
	<?php
	die();
}


// ==================== functions for business ====================


add_action('wp_ajax_nopriv_retpost_filter_by_name', 'retpost_filter_by_name');
add_action('wp_ajax_retpost_filter_by_name', 'retpost_filter_by_name');

function retpost_filter_by_name()
{
	
	global $wpdb;
	global $paged; global $args;
	$paged = ( get_query_var( 'paged' ) ) ? get_query_var( 'paged' ) : 1;
	$args= null;

	if(isset($_POST['ret_search_names']) && !empty($_POST['ret_search_names']))

	{
		$ret_name = esc_sql($_POST['ret_search_names']);
	}
	//get fundraiser_post_id

	$postid = $wpdb->get_var( "SELECT ID FROM $wpdb->posts WHERE post_title LIKE '".$ret_name."'");

	$args = array( 'post_type' => 'retailer', 's' => $ret_name, 'posts_per_page' => 9,'post_status' =>'publish','paged' => $paged);
	$loop = new WP_Query( $args );
	
	$post_query = array( 'post_type' => 'retailer', 's' => $ret_name, 'posts_per_page' => -1,'post_status' =>'publish','paged' => $paged);
	$post_loop = new WP_Query( $post_query );
	$count_byname = $post_loop->post_count;
	?>

	<?php

	?>
	<div class="row campaign-list post-listing">
					<input type="hidden" id="count_search_name" value="<?php echo $count_byname ;?>">
		<?php

		if( $loop->have_posts())
		{
			while ( $loop->have_posts() ) : $loop->the_post();
				$post_id =  get_the_ID();
				$trimtitle = get_the_title();				
				$shorttitle = wp_trim_words( $trimtitle, $num_words = 3, $more = '… ' );
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
							
							<?php echo do_shortcode('[shareaholic app="share_buttons" id="27918553"]'); ?> 

						</figcaption>
					</div>
				</div>

				<?php
			endwhile;
			wp_reset_query();

			?>

		

		<!--<div class="load-more">
			<div class="notification-ret-name comment-notification">
				<div class="alert alert-info not-avail-events">
					No More Listings to view.
				</div>
			</div>
			<a id="loadMore-ret-name">Load more</a>
		</div>-->

		<style>
		
		.hello{ display:none; }
		.notification-ret-name{ display: none; }
		.comment-notification { display: none; }
		.none{ display:none; }
	</style>


	<?php
}

else
{
	echo "<div class='alert alert-danger fs-error-fund fs-error-fund-part block'><div class='row campaign-list'><span style='color:red;'>There are no business sponsor available by this name.</span></div></div>";
}

?>
<div class="load-more-post-name"></div>
</div>

<div style="clear:both"></div>
<div class="loader" style="display:none;text-align:center">								
	<img class="img-loader" src="<?php bloginfo('template_directory');?>/images/ajax-loader.gif">
</div>

<div class='alert alert-danger fs-error-fund fs-error-fund-part nopost-name' style="display:none">
	<div class='row campaign-list'>
		<span style='color:red;'>No more business sponsor available by this name.</span>
	</div>
</div>
<?php


die();
}



add_action('wp_ajax_nopriv_retpost_filter_by_zipcode', 'retpost_filter_by_zipcode');
add_action('wp_ajax_retpost_filter_by_zipcode', 'retpost_filter_by_zipcode');

function retpost_filter_by_zipcode()
{

	global $wpdb;
	global $paged; global $args;
	$paged = ( get_query_var( 'paged' ) ) ? get_query_var( 'paged' ) : 1;
	$args= null;

	
	$ret_zipcode = esc_sql($_POST['ret_search_zipcodes']);
			
	$args = array( 'post_type' => 'retailer', 'posts_per_page' => 9,'post_status' =>'publish','paged' => $paged, 'meta_query'=>
		array(
			
			array(
				'key' => 'user_zip',
				'value'  => $ret_zipcode,
				'compare' => 'LIKE'
			)));

	$loop = new WP_Query($args);

	$post_query = array( 'post_type' => 'retailer', 'posts_per_page' => -1,'post_status' =>'publish','paged' => $paged, 'meta_query'=>
		array(
			
			array(
				'key' => 'user_zip',
				'value'  => $ret_zipcode,
				'compare' => 'LIKE'
			)));
			
	$post_loop = new WP_Query( $post_query );
	$count_byzip = $post_loop->post_count;
	?>
	<div class="row campaign-list post-listing">
		<input type="hidden" id="count_search_zip" value="<?php echo $count_byzip ;?>">
		<?php

		if( $loop->have_posts())
		{
			while ( $loop->have_posts() ) : $loop->the_post();
				$post_id =  get_the_ID();
				$trimtitle = get_the_title();				
				$shorttitle = wp_trim_words( $trimtitle, $num_words = 3, $more = '… ' );
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

							<?php echo do_shortcode('[shareaholic app="share_buttons" id="27918553"]'); ?>

						</figcaption>
					</div>
				</div>

				<?php


			endwhile;
			wp_reset_query();

			?>

		

		
		<style>
		
		.hello{ display:none; }
		.notification-ret-zip{ display: none; }
		.comment-notification { display: none; }
		</style>


	<?php
}

else
{
	echo "<div class='alert alert-danger fs-error-fund fs-error-fund-part block'><div class='row campaign-list'><span style='color:red;'>There are no business sponsor available for this zipcode.</span></div></div>";
}

?>
<div class="load-more-post-zip"></div>
</div>

<div style="clear:both"></div>
<div class="loader" style="display:none;text-align:center">								
	<img class="img-loader" src="<?php bloginfo('template_directory');?>/images/ajax-loader.gif">
</div>

<div class='alert alert-danger fs-error-fund fs-error-fund-part nopost-zip' style="display:none">
	<div class='row campaign-list'>
		<span style='color:red;'>No more business sponsor available for this zipcode.</span>
	</div>
</div>
<?php


die();
}


add_action('wp_ajax_nopriv_retpost_filter_by_city', 'retpost_filter_by_city');
add_action('wp_ajax_retpost_filter_by_city', 'retpost_filter_by_city');

function retpost_filter_by_city()
{

	global $wpdb;
	global $paged; global $args;
	$paged = ( get_query_var( 'paged' ) ) ? get_query_var( 'paged' ) : 1;
	$args= null;

	
	$ret_city = esc_sql($_POST['search_city_ret']);
	
	//get fundraiser_post_id

	$args = array( 'post_type' => 'retailer', 'posts_per_page' => 9,'post_status' =>'publish','paged' => $paged, 'meta_query'=>
		array(
			
			array(
				'key' => 'r_city',
				'value'  => $ret_city,
				'compare' => 'LIKE'
			)));

	$loop = new WP_Query($args);
		
	$post_query = array( 'post_type' => 'retailer', 'posts_per_page' => -1,'post_status' =>'publish','paged' => $paged, 'meta_query'=>
		array(
			
			array(
				'key' => 'r_city',
				'value'  => $ret_city,
				'compare' => 'LIKE'
			)));

	$post_loop = new WP_Query( $post_query );
	$count_bycity = $post_loop->post_count;
	
	

	?>
	<div class="row campaign-list">
		<input type="hidden" id="count_search_city" value="<?php echo $count_bycity ;?>">
		<?php

		if( $loop->have_posts())
		{
			while ( $loop->have_posts() ) : $loop->the_post();
				$post_id =  get_the_ID();
				$trimtitle = get_the_title();				
				$shorttitle = wp_trim_words( $trimtitle, $num_words = 3, $more = '… ' );
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
				<div class="col-md-4 col-sm-4 show-all-ret-city fundraisers_listing_view">
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

							<?php echo do_shortcode('[shareaholic app="share_buttons" id="27918553"]'); ?>

						</figcaption>
					</div>
				</div>

				<?php


			endwhile;
			wp_reset_query();

			?>

		

		

		<style>

		.hello{ display:none; }
		.notification-ret-city{ display: none; }
		.comment-notification { display: none; }
		</style>


	<?php
}

else
{
	echo "<div class='alert alert-danger fs-error-fund fs-error-fund-part block'><div class='row campaign-list'><span style='color:red;'>There are no business sponsor available for this City.</span></div></div>";
}

?>
<div class="load-more-post-city"></div>
</div>

<div style="clear:both"></div>
<div class="loader" style="display:none;text-align:center">								
	<img class="img-loader" src="<?php bloginfo('template_directory');?>/images/ajax-loader.gif">
</div>

<div class='alert alert-danger fs-error-fund fs-error-fund-part nopost-city' style="display:none">
	<div class='row campaign-list'>
		<span style='color:red;'>No more business sponsor available for this city.</span>
	</div>
</div>
<?php


die();
}

//============Code For Searching Zip code From Sign up process================//

add_action('wp_ajax_nopriv_zip_search_create_fund', 'zip_search_create_fund');
add_action('wp_ajax_zip_search_create_fund', 'zip_search_create_fund');

function zip_search_create_fund()
{
	global $wp_query;
	$zip_codes = esc_sql($_POST['zip_codes']);
/*   $args2 = array('post_type'=>'retailer','posts_per_page'=>-1,'meta_query'=>
array(array('key' => 'user_zip','value'  => $zip_codes,'compare'   => 'LIKE')));*/

$args2 = array('post_type'=>'retailer','posts_per_page'=>-1,'meta_query'=>
	array(
		'relation' => 'OR',
		array(
			'key' => 'user_zip',
			'value'  => $zip_codes,
		),
		array(
			'key' => 'r_city',
			'value'  => $zip_codes,
		)


	));

$query2 = new WP_Query( $args2 );
if($query2->have_posts())
{
	$i =1;

	echo "<div class='serach_select_business'><table class='table table-bordered'>";
	echo "<tbody>";
	while ($query2->have_posts()) : $query2->the_post();
		$unclaimed = get_post_meta( get_the_ID(), 'import_status', true );
		if($unclaimed == 'unclaimed') 
		{
			$unclaimed_text = "unclaimed";
		}
		?>

		<tr>
			<td><input class="chk_radio" type="radio" name="select_ret" value="<?php echo the_ID();?>" data-title="<?php echo the_title(); ?>" data-ret-auth-id="<?php echo $author_id = get_post_field ('post_author');?>" data-ret-name="<?php echo $display_name = get_the_author_meta( 'display_name' , $author_id ); ?>" >
			</td>
			<td><a class="post_titles" href="<?php echo get_permalink(); ?>" target="_blank"><?php echo wp_trim_words(get_the_title(), '5', '...');?> <?php if($unclaimed == 'unclaimed') { ?><span class="unclaimed_text" style="font-size: 10px;color: red;">(Unclaimed)</span><?php } ?></a></td>
		</tr>

		<?php
	endwhile;
	$i++;
	echo "</tbody>";
	echo "</table></div>";
	wp_reset_query();
	echo "<input type='hidden' name='get_value' value='hdd_chk'>";
	echo "<input class='hidden_true if' id='hidden_true_id' type='hidden' name='zip-code-srch' value='' />";
}
else{
	echo '<p>There is no Business Partner available for <b style="font-size:18px">'.$zip_codes.'</b>. Please try with another search.</p>';
	echo '<h3>Or</h3>';
	echo '<p>Send a message to our Raise It Fast team if you would like to receive notifications regarding fundraising campaigns hosted in your area.</p>';

	echo '<div class="form-group">';
	echo '<label style="margin-top: 4%;">Your message to Raise It Fast:</label>';
	echo '<textarea type="textarea" class="form-control" name="msg_to_raisit" rows="3" placeholder="Your Message Here..." id="msg_to_raisit"></textarea>';
	echo '<input type="hidden" name="send_zip" value="'.$zip_codes.'">';
	echo "<input class='hidden_true else' id='hidden_true_id' type='hidden' name='zip-code-srch' value='000' />";
	echo '</div>';

}   
die();
}


add_action('wp_ajax_nopriv_author_search_retaile', 'author_search_retaile');
add_action('wp_ajax_author_search_retaile', 'author_search_retaile');
function author_search_retaile()
{
	// Search data for railter

	global $wp_query;
	$zip  = esc_sql($_POST['zip_codes']);

	$args11 = array('post_type'=>'retailer','posts_per_page'=>-1,'meta_query'=>
		array(
			'relation' => 'OR',
			array(
				'key' => 'user_zip',
				'value' => $zip,
			),
			array(
				'key' => 'r_city',
				'value' => $zip,
			)

		));

	$query11 = new WP_Query( $args11 );
	if($query11->have_posts()){

		?>
		<div class="col-sm-12 col-md-12 business_search">

			<script>

				$('input[name="get_value"]').change(function() 
				{
   //var sd = $(this).val();
   
   var data_id = $(this).attr("data-id");
   
   var selId = $('select').filter(function(){ return $(this).data("selid")   == data_id }).attr("data-selid");

   $("#hid_reta_id").val(data_id);
   

 //alert(selId);
 
 if(data_id == selId)
 {

 	$("select").each(function(){
 		if($(this).data("selid") == data_id)
 		{ 
 			$(this).prop('disabled', false);
 			$(this).attr('id', 'selected_drop');
 		}else{

 			$(this).prop('disabled', true);
 			$(this).removeAttr('id', 'selected_drop');
 		}
 	});

 }

});

				function validateRadio() 
				{
					var radios = document.getElementsByName("get_value");

					if (!$("input[name='get_value']:checked").val()) {
						alert('Please select a Campaign!');
						return false;
					}else{

						return true;
					}

				}

				function validateselect()
				{
					if ($("#selected_drop").val() === "") {

						alert("Please select a campaign from the dropdown list");
						return false;
					}else{

						return true;
					}

				}

				function validate() {
					return validateRadio() && validateselect();
				}
			</script>

			<form class="form_search" id="serach_ret" name="search_form1111" action="" method="post" onsubmit="return validate()">
				<table class="search_table table-bordered">
					<tr>
						<th></th>
						<th>Business Partner Name</th>
						<th>Select your Campaign</th>
						<th></th>
					</tr>


					<?php

					$i=0;


					while ($query11->have_posts()) : $query11->the_post(); ?>

					<!-- get data from current user fundraiser -->

					<?php
					$unclaimed = get_post_meta( get_the_ID(), 'import_status', true );

					global $current_user;
					get_currentuserinfo(); 
					$f_auth_id    = $current_user->ID;
					$f_auth_name  = $current_user->user_firstname;
					$f_auth_email = $current_user->user_email;
					?>
					<!-- get data from current user fundraiser End -->

					<!-- <input type="hidden" name="reta_id" value="<?php echo $postid = get_the_ID();?>"> -->


					<!-- check and count r_d and f_id -->

					<?php
					global $wpdb;

					$r_id = $wpdb->get_row("SELECT * FROM wp_post_relationships where r_id=$postid and f_auth_id=$f_auth_id");
					$rid_count = count($r_id);
					?>

					<!-- check and count r_d and f_id end -->

					<tr>
						<td>
							<?php
							if($rid_count == 0)
							{
								?>

								<input type="radio" name="get_value" value="<?php echo the_title();?>" data-id=<?php echo $postid = get_the_ID();?>>
								<?php } else {?>
								<input type="radio" name="get_value" disabled />

								<?php } ?>
							</td>
							<td>
								<a href="<?php echo get_permalink() ;?>"><?php echo the_title(); if($unclaimed == 'unclaimed') { ?> <span class="unclaimed_text" style="font-size: 10px;color: red;">(Unclaimed)</span><?php } ?></a>

								<input type="hidden" name="r_author_id" value="<?php echo get_the_author_meta( 'ID' , $author_id ) ?>">
								<input type="hidden" name="retailer_autor_name" value="<?php the_author_meta( 'first_name' , $author_id ); ?> ">
							</td>
							<td><?php
							global $current_user;
							get_currentuserinfo();
							global $args;
							$post_type="fundraiser";
							$post_type_object = get_post_type_object($post_type);
							$label = $post_type_object->label;
							$posts = get_posts(array('author' =>  $current_user->ID,'post_type'=> $post_type, 'post_status'=> 'pending,draft', 'suppress_filters' => false, 'posts_per_page'=>-1));
							echo '<select  name="f_post_id" class="sel_event_list" disabled  data-selid='.$postid = get_the_ID().'>';
							echo '<option value ="">Please select your event</option>';
							foreach ($posts as $post) {
								echo '<option value="'.$post->ID.'">', $post->post_title, '</option>';
							}
							echo '</select>';

							?></td>
							<input type="hidden" name="fund_author_id" value="<?php echo $f_auth_id;?>">
							<input type="hidden" name="fund_author_name" value="<?php echo $f_auth_name;?>">
							<input type="hidden" name="fund_author_email" value="<?php echo $f_auth_email;?>">
							<td>
								<?php
								if($rid_count == 0)
								{
									?>

									<input type="submit" name="save_its" value="Raise It Fast" class="save_its"></td>
									<?php } else {?>
									<p class="save_its">Requested</p>
									<?php } ?>
								</tr>
								<?php
								$i++;
							endwhile;
							echo'<input type="hidden" id="hid_reta_id" name="reta_id" value="">';

							echo "</table>";
							echo "</form>";
							echo "</div>";
							wp_reset_query();

						}

						else 
						{
							echo '<div class="col-sm-12 col-md-12 no_reatiler_found">';
							echo '<form id="send_mail_raiseit" action="" method="post">';
							echo '<p style="color:#fff;">There is no Business Partner is available for <b style="font-size:18px">'.$zip.'</b>. Please try another search.</p>';
							echo '<h3 style="color:#fff;">Or</h3>';
							echo '<p style="color:#fff;">Send a message to Raise It Fast if you would like to receive notifications regarding fundraising campaigns in your area.</p>';

							echo '<div class="form-group">';
							echo '<label style="margin-top: 4%;color:#fff;">Your message to Raise It Fast:</label>';
							echo '<textarea type="text" class="form-control text_mail" name="msg_to_raisit" rows="3" placeholder="Your Message Here..." id="msg_to_raisit" required></textarea>';
							echo '<input type="hidden" name="send_zip" value="'.$zip.'">';
							echo '<input type="submit" name="send_mail" value="Submit" class="send_mail">';
							echo '</div>';
							echo '</form>';
							echo '</div>';

						}


						?>      

						<?php
						die();
					}

//function at Footer acf field option

					if( function_exists('acf_add_options_page') ) 
					{
						acf_add_options_page(array(
							'page_title' 	=> 'Email & Text Message Settings',
							'menu_title'	=> 'Email & Text Message Settings',
							'menu_slug' 	=> 'theme-general-settings',
							'capability'	=> 'edit_posts',
							'redirect'		=> false
						));

						acf_add_options_sub_page(array(
							'page_title' 	=> 'Admin Email Settings',
							'menu_title'	=> 'Admin Email Settings',
							'parent_slug'	=> 'theme-general-settings',
							'redirect'		=> false
						));

						acf_add_options_sub_page(array(
							'page_title' 	=> 'Donor Email Settings',
							'menu_title'	=> 'Donor Email Settings',
							'parent_slug'	=> 'theme-general-settings',
							'redirect'		=> false
						));

						acf_add_options_sub_page(array(
							'page_title' 	=> 'Fundraiser Page Settings',
							'menu_title'	=> 'Fundraiser Page Settings',
							'parent_slug'	=> 'theme-general-settings',
							'redirect'		=> false
						));

						acf_add_options_sub_page(array(
							'page_title' 	=> 'Fundraiser Accept Date & Time',
							'menu_title'	=> 'Fundraiser Accept Date & Time',
							'parent_slug'	=> 'theme-general-settings',
							'redirect'		=> false
						));

						acf_add_options_sub_page(array(
							'page_title' 	=> 'Footer Setting',
							'menu_title'	=> 'Footer Settings',
							'parent_slug'	=> 'theme-general-settings',
							'redirect'		=> false
						));

					}
					add_filter('wp_authenticate_user', function($user) 
					{
						if($user->ID !== 1)
						{
							if(get_user_meta($user->ID, 'acc_activate', true) == 1) 
							{
								return $user;

							}else{

								return new WP_Error( 'start', __( "Your account is not activated with Raise It Fast." ) );
							}
						}elseif($user->ID == 1){

							return $user;

		/*if(get_user_meta($user->ID, 'active', true) == 1) 
		{
			return $user;
				
		}*/

	}else{
		
		return $user;
	}
}, 10, 2);


//=================== Code to Approve/Reject Fundraiser Campaigns from Author Page====================//

					add_action('wp_ajax_nopriv_approve_disapprove_event', 'approve_disapprove_event');
					add_action('wp_ajax_approve_disapprove_event', 'approve_disapprove_event');

					function approve_disapprove_event()
					{
	//Getting Approve data
						$r_id_new    = $_POST['r_id_new'];
						$f_id_new    = $_POST['f_id_new'];
						$f_email_new = $_POST['f_email_new'];

						$f_title_new = stripslashes(stripslashes(stripslashes($_POST['f_title_new'])));

						$f_auth_name_new = $_POST['f_auth_name_new'];

	//Get divId and selected radio button values
						$divid    = $_POST['divid'];
						$app_disapp_val = $_POST['app_disapp_val'];

						

						$r_id    = $r_id_new;
						$f_id    = $f_id_new;
						$f_email = $f_email_new;
						$f_title   = $f_title_new;
						$f_auth_name   = $f_auth_name_new;


						$status = $app_disapp_val;

						$admin_email = get_option( 'admin_email' );

						if($status == 'disapp'){

							$status = '2';
						}

						// $auth = get_post($post_ID); // gets author from post
 					// 	$authid = $auth->post_author;

						$ret_author_id = get_post_field ('post_author', $r_id);
						$fund_author_id = get_post_field ('post_author', $f_id);

						global $wpdb;

						$Update = $wpdb->query("UPDATE wp_post_relationships SET status = '$status', notify_status = 'unseen' WHERE r_id = '$r_id' AND f_id = '$f_id' ");

						$tabletwo = $wpdb->prefix.'post_notification';

						$data_two = array(

							'fund_id' => $f_id,
							'reat_id' => $r_id,
							'fund_auth_id' => $fund_author_id,
							'ret_auth_id' => $ret_author_id,
							'notify_to_user' => 'busi-to-fund',
						);

						$fund_inserts_two = $wpdb->insert( $tabletwo, $data_two);

						$select_data = $wpdb->get_results("SELECT * FROM wp_post_relationships where status = '$status ' AND  r_id = '$r_id' AND f_id = '$f_id' ");

						foreach ($select_data as $key => $fund_id) {
							$fundraiser_id = $fund_id->f_auth_id;
							$fund_ids = $fund_id->f_id;
						}
						$post_slug = get_post_field( 'post_name', $fund_ids ); 
         //$author_id = $f_id->post_author; 
						$user_phone = get_user_meta( $fundraiser_id, 'user_phone', true);

						if($Update && $status == 2)
						{
							$pubs = 'draft';
							$post_updates = array( 'ID' => $f_id, 'post_status' => $pubs );
							wp_update_post($post_updates);
						}
						echo $r_id.'-'.$f_id;
        //}
						die();
					}
//=================== Code to Chnage Time Requested from Author Page====================//

					add_action('wp_ajax_nopriv_change_time_req_event', 'change_time_req_event');
					add_action('wp_ajax_change_time_req_event', 'change_time_req_event');

					function change_time_req_event()
					{

	//Getting Approve data
						$chnage_time_req = $_POST['chnage_time_req'];
	  //$status = $chnage_time_req;
						$status = '0';
	    //$s_date = $_POST['e_s_date'];
						$s_dates = date_create($_POST['e_s_date']);
						$s_date = date_format($s_dates,"Y/m/d");
						$s_time = $_POST['e_s_time'];
      //$e_date = $_POST['e_e_date'];
						$e_dates = date_create($_POST['e_e_date']);
						$e_date = date_format($e_dates,"Y/m/d");

						$e_time = $_POST['e_e_time'];

						$email  = $_POST['email'];
						$e_id   = $_POST['e_id'];
						$r_id   = $_POST['r_id'];
						/*      $e_title = $_POST['e_title'];*/
						$e_title = stripslashes(stripslashes(stripslashes($_POST['e_title'])));
						$f_auth_name = $_POST['f_auth_name'];
						$f_comment = stripslashes(stripslashes(stripslashes($_POST['comment'])));


						$admin_email = get_option( 'admin_email' );

						$ret_author_id = get_post_field ('post_author', $r_id);
						$fund_author_id = get_post_field ('post_author', $e_id);

          //Send Email For Event Rejection

						global $wpdb;
						$Update = $wpdb->query("UPDATE wp_post_relationships SET status = 0, notify_status = 'unseen' WHERE r_id = '$r_id' AND f_id = '$e_id' ");

						$tabletwo = $wpdb->prefix.'post_notification';

						$data_two = array(

							'fund_id' => $e_id,
							'reat_id' => $r_id,
							'fund_auth_id' => $fund_author_id,
							'ret_auth_id' => $ret_author_id,
							'notify_to_user' => 'busi-to-fund',
						);
						
						$fund_inserts_two = $wpdb->insert( $tabletwo, $data_two);

						$select_data = $wpdb->get_results("SELECT * FROM wp_post_relationships where status = 0 AND  r_id = '$r_id' AND f_id = '$e_id' ");


						$tablenames = $wpdb->prefix.'propose_date_time';

						$propose_datetime = array(
							'r_id' => $r_id,
							'f_id' => $e_id, 
							'start_date' => $s_date,
							'end_date' =>$e_date, 
							'start_time' => $s_time,
							'end_time' => $e_time,
							'status' => 'none',        
						);

						$fund_inserts = $wpdb->insert( $tablenames, $propose_datetime);

						foreach ($select_data as $key => $fund_idss) {
							$fundraiser_id_new = $fund_idss->f_auth_id;
							$fund_ids_new = $fund_idss->f_id;
						} 
						$post_slug_new = get_post_field( 'post_name', $fund_ids_new );
						$user_phone_new = get_user_meta( $fundraiser_id_new, 'user_phone', true);

						$status2 ="draft";
						$post_update = array( 'ID' => $e_id, 'post_status' => $status2 );
						wp_update_post($post_update); 
						$change_title = get_field('change_date_time_title', 'option');
						$change_sub_title = get_field('change_date_time_sub_title', 'option');
						$sms_noti_text = get_field('sms_notification_text', 'option');

            // write the email content for fundraiser
						@$header .= "MIME-Version: 1.0\n";
						$header .= "Content-Type: text/html; charset=utf-8\n";
						@$headers .= "From:" . $admin_email;

						$site_url =  site_url('/fundraiser/?p=');
						$combine = $site_url.$fund_ids_new;

//dev.raiseitfast.com/?post_type=fundraiser&p=3747&preview=true

						$message1 = "<html><body style='background:#f3f3f3;padding:20px 0;'><table border='0' cellpadding='0' cellspacing='0' style='margin:auto; max-width: 520px;width:100%;font-family: Arial;padding:20px;background:#fff;'><tbody>";
						$message1 .="<tr><td style='font-size: 16px;'>".sprintf(__('Hello')." %s ", ucfirst($f_auth_name)).",</td></tr><tr height=20></tr>";
						/*						$message1 .="<tr><td style='font-size: 16px; line-height: 20px;'>Your request for ".$e_title."  has been disapproved by your proposed business host.</td></tr><tr height=30></tr>";*/
						$message1 .="<tr><td style='font-size: 16px; line-height: 20px;'>".$change_title."</td></tr><tr height=20></tr>";
						//$message1 .="<tr><td style='font-size: 16px; line-height: 20px;'>".$change_sub_title."</td></tr><tr height=20></tr>";
						$message1 .="<tr><td style='font-size: 16px; line-height: 20px;'>Start Date :-".$s_date."</td></tr><tr height=20></tr>";
						$message1 .="<tr><td style='font-size: 16px; line-height: 20px;'>End Date :-".$e_date."</td></tr><tr height=20></tr>";
						$message1 .="<tr><td style='font-size: 16px; line-height: 20px;'>Start time :-".$s_time."</td></tr><tr height=20></tr>";
						$message1 .="<tr><td style='font-size: 16px; line-height: 20px;'>End time :-".$e_time."</td></tr><tr height=20></tr>";
						$message1 .="<tr><td style='font-size: 16px; line-height: 20px;'>Message :-".$f_comment."</td></tr><tr height=20></tr>";
						$message1 .="<tr><td style='font-size: 16px; line-height: 20px;'>Please log into your account area, go to My Fundraising Campaigns -> Change date & time, click on your fundraiser and click Approve or Change Date and Time if you want to make another suggestion for the dates the Business Partner’s giveaway should be valid.</td></tr><tr height=30></tr>";
						//$message1 .="<tr><td><a href=".site_url('/accept-change-date-time/')." style='background:#3498db; padding: 13px 25px; color: #fff; text-decoration: none; font-size: 15px; border-radius: 3px; font-weight: 600;'>Click here</a></td></tr><tr height=30></tr><tr height=20></tr>";
						$message1 .="<tr><td style='font-size: 16px; line-height: 20px;'>If you have any questions or concerns don't hesitate to use our website chat function, call us, or email us by going to our help page at ".site_url('/contact-us/')." Or, you can simply reply to this email. </td></tr><tr height=30></tr>";  
						$message1 .="<tr><td style='font-size: 16px; margin-top: 20px;'>Thank you in advance! </td></tr></tbody></table><table border='0' cellpadding='0' cellspacing='0' style='margin:20px auto 0; max-width: 520px;width:100%;'>"; 

						$message1 .="<tr><td style='color: #999999; font-size: 12px; text-align: center;'>1401 Lavaca St #503, Austin, TX 78701</td></tr><tr height=20></tr>"; 
						$message1 .="<tr><td style='color: #999999; font-size: 12px; text-align: center;'><a href=".site_url()." style='text-decoration:none; color: #999999;'>The Raise it Fast Team</a></td></tr>";    
						$message1 .="</table></body></html>";

						$subject = "A Business Partner wishes to make a change";
						$subject = "=?utf-8?B?" . base64_encode($subject) . "?=";

          // send the email to fundraiser
						$email1=wp_mail($email, $subject, $message1, $header);

						$account_sid = get_option('twilio_account_sid'); 
						$auth_token  = get_option('twilio_auth_token');        
						/*require('lib/twilio-php-latest/Services/Twilio.php');*/        
						$client = new Services_Twilio($account_sid, $auth_token);
                      //$from = '+18566198165';           
                      //$from = '+12182068385 ';            
						$from        = get_option('twilio_phone_no');                
						/*$from = '+12182265630';*/                
//$client->account->messages->sendMessage( $from, $user_phone_new, "Hi ".$f_auth_name." " .$sms_noti_text. " ".site_url('/fundraiser/').$post_slug_new." .");


						$client->account->messages->sendMessage( $from, $user_phone_new, "Hi ".$f_auth_name." " .$sms_noti_text. " ".site_url('/?post_type=fundraiser&p=').$fund_ids_new."&preview=true");
//https://dev.raiseitfast.com/?post_type=fundraiser&p=3747&preview=true


						echo $r_id.'-'.$e_id;


						die();
					}


//=================== Code to accept the fundriaser request  from Author Page====================//

					add_action('wp_ajax_nopriv_accept_fundraiser_request', 'accept_fundraiser_request');
					add_action('wp_ajax_accept_fundraiser_request', 'accept_fundraiser_request');

					function accept_fundraiser_request()
					{
						$select_min_discount = $_POST['select_min_discount'];
						$coupen_code = $_POST['coupen_code'];
						$discount_selct_text_new = $_POST['discount_selct_text_new'];
						$extra_benefit = $_POST['extra_benefit'];
						$discount_selct = $_POST['discount_selct'];
						if($discount_selct == 'coupen_10')
						{
							$discount = "10%";
						}
						if($discount_selct == 'coupen_20')
						{
							$discount = "20%";
						}

						if($discount_selct == 'coupen_30')
						{
							$discount = "30%";
						}

						if($discount_selct == 'coupen_40')
						{
							$discount = "40%";
						}

						if($discount_selct == 'coupen_50')
						{
							$discount = "50%";
						}

						if($discount_selct == 'free_coupon')
						{
							$discount = "Free";
						}

						if($discount_selct == 'custom_coupon')
						{
							$discount = $discount_selct_text_new;
						}


						$r_id = $_POST['rr_id_new'];

						$e_id = $_POST['ff_id_new'];

						if($_POST['extra_benefit'])
						{

							$extra_benefit = $_POST['extra_benefit'];
						}
						else
						{
							$extra_benefit = "none";
						}

						if($select_min_discount)
						{
							$save_min_discount = $select_min_discount;
						}
						else
						{
							$save_min_discount = "none";
						}

						$ret_author_id = get_post_field ('post_author', $r_id);
						$fund_author_id = get_post_field ('post_author', $e_id);


						global $wpdb;
						$status = '3';
						$Update = $wpdb->query("UPDATE wp_post_relationships SET status = '$status' , discount_selct = '$discount_selct' , coupen_code = '$coupen_code' , discount_selct_text = '$discount_selct_text_new' , extra_benefit = '$extra_benefit' , set_min_donation = '$save_min_discount', notify_status = 'unseen'  WHERE r_id = '$r_id' AND f_id = '$e_id' ");

						$tabletwo = $wpdb->prefix.'post_notification';

						$data_two = array(

							'fund_id' => $e_id,
							'reat_id' => $r_id,
							'fund_auth_id' => $fund_author_id,
							'ret_auth_id' => $ret_author_id,
							'notify_to_user' => 'busi-to-fund',
						);
						
						$fund_inserts_two = $wpdb->insert( $tabletwo, $data_two);

						$select_data = $wpdb->get_results("SELECT * FROM wp_post_relationships where status = '$status' AND  r_id = '$r_id' AND f_id = '$e_id' ");

						$post_slug = get_post_field( 'post_name', $e_id );

						foreach ($select_data as $key => $fund_id) {
							$fundraiser_id = $fund_id->f_auth_id;
							$fund_ids = $fund_id->f_id;
							$fund_auth_name = $fund_id->f_auth_name;
							$fund_auth_email = $fund_id->f_auth_email;
						}

						$phone = get_user_meta( $fundraiser_id, 'user_phone', false );



						$post_slug = get_post_field( 'post_name', $fund_ids ); 

						$user_info   = get_userdata(1);
						$admin_name  = $user_info->user_login;
						$admin_email = get_option( 'admin_email' );
						$approve_mail_text = get_field('approve_mail_text', 'option');
						$approve_sms_text = get_field('approve_sms_text', 'option');

						if(isset($Update) && !empty($Update))
						{

                    // write the email content for admin

							@$header4 .= "MIME-Version: 1.0\n";
							$header4 .= "Content-Type: text/html; charset=utf-8\n";
							@$headers4 .= "From:" . $admin_email;

							$sends_message = "<html><body style='background:#f3f3f3;padding:20px 0;'><table border='0' cellpadding='0' cellspacing='0' style='margin:auto; max-width: 520px;width:100%;font-family: Arial;padding:20px;background:#fff;'><tbody>";
							$sends_message .="<tr><td style='font-size: 16px;'>".sprintf(__('Hello')." %s ", ucfirst($fund_auth_name)).",</td></tr><tr height=20></tr>";
							$sends_message .="<tr><td style='font-size: 16px; line-height: 20px;'>".$approve_mail_text."</td></tr><tr height=30></tr>";
							$sends_message .="<tr><td><a href=".site_url('/accepts-denies-events/')." style='background:#3498db; padding: 13px 25px; color: #fff; text-decoration: none; font-size: 15px; border-radius: 3px; font-weight: 600;'>Click here</a></td></tr><tr height=30></tr>";
							$sends_message .="<tr><td style='font-size: 16px; line-height: 20px;'>If you have any questions or concerns don't hesitate to use our website chat function, call us, or email us by going to our help page at ".site_url('/contact-us/')." Or, you can simply reply to this email. </td></tr><tr height=30></tr>";  
							$sends_message .="<tr><td style='font-size: 16px; margin-top: 20px;'>Thank you in advance! </td></tr></tbody></table><table border='0' cellpadding='0' cellspacing='0' style='margin:20px auto 0; max-width: 520px;width:100%;'>"; 

							$sends_message .="<tr><td style='color: #999999; font-size: 12px; text-align: center;'>1401 Lavaca St #503, Austin, TX 78701</td></tr><tr height=20></tr>"; 
							$sends_message .="<tr><td style='color: #999999; font-size: 12px; text-align: center;'><a href=".site_url()." style='text-decoration:none; color: #999999;'>The Raise it Fast Team</a></td></tr>";    
							$sends_message .="</table></body></html>";


							$subject31 = "Raise It Notification";
							$subject31 = "=?utf-8?B?" . base64_encode($subject31) . "?=";

							$to_fund = $fund_auth_email;

                // send the email to reatiler
							$email3 = wp_mail($to_fund, $subject31, $sends_message, $header4);

							$account_sid = get_option('twilio_account_sid'); 
							$auth_token  = get_option('twilio_auth_token');             
							$client = new Services_Twilio($account_sid, $auth_token);

							$from        = get_option('twilio_phone_no');                
							$client->account->messages->sendMessage( $from, $phone, "Hi ".$fund_auth_name." ".$approve_sms_text." ".site_url("/accepts-denies-events")."");



						}

						echo $r_id.'-'.$e_id;


						die();
					}


					/************** /////////////////////Donation User signup start///////////////// ************/

					add_action('wp_ajax_nopriv_donor_new_signup', 'donor_new_signup');
					add_action('wp_ajax_donor_new_signup', 'donor_new_signup');

					function donor_new_signup()
					{
						$user_email = $_POST['user_email'];

						$fg = get_user_by( 'email', $user_email );

						$ID = $fg->ID;

						if($ID != '')
						{
							echo "2";
						}

						else
						{
							echo "11";
						}

						die();	
					}


					/* Search Business Partner Listing In Dashboard */	

					add_action('wp_ajax_nopriv_search_reat_post', 'search_reat_post');
					add_action('wp_ajax_search_reat_post', 'search_reat_post');

					function search_reat_post()
					{
						global $wpdb;
						global $current_user;
						get_currentuserinfo();

						$user_ret_ids = $current_user->ID;
						
						if(isset($_POST['search_ret_namess']) && !empty($_POST['search_ret_namess']))
						{

							$ret_names = $_POST['search_ret_namess'];
						}

							$postid = $wpdb->get_var( "SELECT ID FROM $wpdb->posts WHERE post_title LIKE '".$ret_names."'");

							global $paged4; global $args4;
							$paged4 = ( get_query_var( 'paged' ) ) ? get_query_var( 'paged' ) : 1;
							$args4 = null;
							$args4 = array( 'post_type' => 'retailer', 's' =>$ret_names, 'posts_per_page' => 9,'post_status' =>'publish','paged' => $paged4,'author' =>  $user_ret_ids);
							$loop4 = new WP_Query( $args4 );
							
							$query_args = array( 'post_type' => 'retailer', 's' =>$ret_names, 'posts_per_page' => -1,'post_status' =>'publish','paged' => $paged4,'author' =>  $user_ret_ids);
							$post_loop = new WP_Query($query_args);
							$count_searchbusiness = $post_loop->post_count;
							?>
						
							<div class="post-listing">
							<input type="hidden" id="count_searchbusiness" value="<?php echo $count_searchbusiness ;?>">
							<?php
							if( $loop4->have_posts()){
								while ( $loop4->have_posts() ) : $loop4->the_post();
									?>



									<div class="col-md-4 col-sm-4 post_list">
										<figure>
											<div class="post_border">
												<div class="thumb_image">
													<div class="blanks">


														<?php
	//$feature_image_1 = get_field('feature_image_1',$post->ID);
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
										else{
											echo "<div class='alert alert-danger fs-error-fund'><span style='color:red;'> There is no available business partner</span></div>";
										}
										?>
									<div class="loadmore-searchbusiness"></div>
									</div>
									<div style="clear:both"></div>
									<div class="loader-searchbusiness" style="display:none;text-align:center">								
										<img class="img-loader" src="<?php bloginfo('template_directory');?>/images/ajax-loader.gif">
									</div>

									<div class='alert alert-danger fs-error-fund fs-error-fund-part nomore-searchbusiness' style="display:none">
										<div>
											<span style='color:red;'>No more business available.</span>
										</div>
									</div>
	
									<?php
										if(isset($_GET['del_id'])){
											$else_del_id = $_GET['del_id'];
											wp_trash_post($else_del_id);
											header("location:".site_url()."/user/".$username);
										}
									
									 die();
								}	

								/*********** FORGET PASSWORD START CODE HERE***************/


								add_action('wp_ajax_nopriv_forget_password', 'forget_password');
								add_action('wp_ajax_forget_password', 'forget_password');

								function forget_password(){
									$user_email = $_POST['user_login'];
									$pie_register_base = new PieReg_Base();
									$forget_pass_mail_text = get_field('forget_mail_text', 'option');
									$forget_pass_sms_text = get_field('forget_sms_text', 'option');
	/*
		*	Sanitizing post data
	*/
		$pie_register_base->piereg_sanitize_post_data( ( (isset($_POST) && !empty($_POST))?$_POST : array() ) );
		$option = get_option('pie_register_2');
		if(isset($_POST['user_login']) and trim($_POST['user_login']) == ""){
			echo $error[] = '<strong>'.ucwords(__("error:","piereg")).'</strong> '.__('Invalid Username or Email, try again!','piereg');

		}
		else{
			global $wpdb,$wp_hasher;
			$error 		= array();
			$username = trim($_POST['user_login']);
			$user_exists = false;
			// First check by username
			if ( username_exists( $username ) ){
				$user_exists = true;
				$user = get_user_by('login', $username);
			}
			// Then, by e-mail address
			elseif( email_exists($username) ){
				$user_exists = true;
				$user = get_user_by_email($username);
			}
			else{
				echo	$error[] = '<strong>'.ucwords(__("error :","piereg")).'</strong> '.__('The Email address was not found, please try again','piereg');
			}
			if ($user_exists){
				
				$user_login = $user->user_login;
				$user_first_name = $user->first_name;
				$user_email = $user->user_email;
				$user_phone_forget = get_user_meta( $user->ID, 'user_phone', true);

				$allow = apply_filters( 'allow_password_reset', true, $user->ID );
				if($allow){
					//Generate something random for key...
					$key = wp_generate_password( 20, false );
					
					//let other plugins perform action on this hook
					do_action( 'retrieve_password_key', $user_login, $key );
					
					//Generate something random for a hash...
					if ( empty( $wp_hasher ) ) {
						require_once ABSPATH . 'wp-includes/class-phpass.php';
						$wp_hasher = new PasswordHash( 8, true );
					}
					
					//$hashed = $wp_hasher->HashPassword( $key );
					$hashed = time() . ':' . $wp_hasher->HashPassword( $key );
					
					// Now insert the new md5 key into the db
					$wpdb->update($wpdb->users, array('user_activation_key' => $hashed), array('user_login' => $user_login));

					
					$message_temp = "";
					if($option['user_formate_email_forgot_password_notification'] == "0"){
						$message_temp	= nl2br(strip_tags($option['user_message_email_forgot_password_notification']));
					}else{
						$message_temp	= $option['user_message_email_forgot_password_notification'];
					}
					
					$message		= $pie_register_base->filterEmail($message_temp,$user->user_login, '',$key );
					$from_name		= $option['user_from_name_forgot_password_notification'];
					$from_email		= $option['user_from_email_forgot_password_notification'];					
					$reply_email 	= $option['user_to_email_forgot_password_notification'];
					$subject 		= html_entity_decode($option['user_subject_email_forgot_password_notification'],ENT_COMPAT,"UTF-8");
					
					//Headers
					$headers  = 'MIME-Version: 1.0' . "\r\n";
					$headers .= 'Content-type: text/html; charset=UTF-8' . "\r\n";

					if(!empty($from_email) && filter_var($from_email,FILTER_VALIDATE_EMAIL))//Validating From
					$headers .= "From: ".$from_name." <".$from_email."> \r\n";
					if($reply_email){
						$headers .= "Reply-To: {$reply_email}\r\n";
						$headers .= "Return-Path: {$from_name}\r\n";
					}else{
						$headers .= "Reply-To: {$from_email}\r\n";
						$headers .= "Return-Path: {$from_email}\r\n";
					}

					$subject='Password Reset for Raise It Fast';


					$message = "<html><body style='background:#f3f3f3;padding:20px 0;'><table border='0' cellpadding='0' cellspacing='0' style='margin:auto; max-width: 520px;width:100%;font-family: Arial;padding:20px;background:#fff;'><tbody>";
					$message .="<tr><td style='font-size: 16px;'>".sprintf(__('Hello')." %s ", ucfirst($user_first_name)).",</td></tr><tr height=20></tr>";
					$message .="<tr><td style='font-size: 16px; line-height: 20px;'>".$forget_pass_mail_text."</td></tr><tr height=30></tr>";
					$message .="<tr><td><a href=".network_site_url("login/?action=rp&key=$key&login=" . rawurlencode($user_login), 'login') . "&redirect_to=".urlencode(get_option('siteurl'))." style='background:#3498db; padding: 13px 25px; color: #fff; text-decoration: none; font-size: 15px; border-radius: 3px; font-weight: 600;'>Click</a></td></tr><tr height=30></tr><tr height=20></tr>";
					$message .="<tr><td style='font-size: 16px; line-height: 20px;'>If you have any questions or concerns don't hesitate to use our website chat function, call us, or email us by going to our help page at ".site_url('/contact-us/')." Or, you can simply reply to this email.</td></tr><tr height=30></tr>"; 
					$message .="<tr><td style='font-size: 16px; margin-top: 20px;'>Thank you for being a part of the Raise It Fast community! </td></tr></tbody></table><table border='0' cellpadding='0' cellspacing='0' style='margin:20px auto 0; max-width: 520px;width:100%;'>"; 

					$message .="<tr><td style='color: #999999; font-size: 12px; text-align: center;'>1401 Lavaca St #503, Austin, TX 78701</td></tr><tr height=20></tr>"; 
					$message .="<tr><td style='color: #999999; font-size: 12px; text-align: center;'><a href=".site_url()." style='text-decoration:none; color: #999999;'>The Raise it Fast Team</a></td></tr>";    
					$message .="</table></body></html>";

					//send email meassage
					if (FALSE == wp_mail($user_email, $subject, $message,$headers)){
						echo	$error[] =  '<strong>'.ucwords(__("error :","piereg")).'</strong> '.__('The e-mail could not be sent.','piereg') . "<br />\n" . __('Possible reason: your host may have disabled the mail() function...','piereg') ;
					}
					
					unset($key);
					unset($hashed);
					unset($_POST['user_login']);
				}else{
					echo 	$error[] = apply_filters('piereg_password_reset_not_allowed_text',__("Password reset is not allowed for this user","piereg"));
				}

				if (count($error) == 0 )
				{
					echo $success =  '<p style="color:green;"><b>'.ucwords(__("success :","piereg")).'</b> '.apply_filters("piereg_message_will_be_sent_to_your_email",__('A message has been sent to your email address.</p>','piereg'));
				}	

				$account_sid = get_option('twilio_account_sid'); 
				$auth_token  = get_option('twilio_auth_token');   
				//require('lib/twilio-php-latest/Services/Twilio.php');        
				$client = new Services_Twilio($account_sid, $auth_token);           
				$from        = get_option('twilio_phone_no');               
				$client->account->messages->sendMessage( $from, $user_phone_forget, "Hi ".$user_first_name." , ".$forget_pass_sms_text."".network_site_url("login/?action=rp&key=$key&login=" . rawurlencode($user_login), 'login') . "&redirect_to=".urlencode(get_option('siteurl'))."  ");
				
			}
		}

		die();
	}

	/**************** FORGET PASSWORD END **************************/		


	
	add_action('wp_ajax_nopriv_upload_profile_media', 'upload_profile_media');
	add_action('wp_ajax_upload_profile_media', 'upload_profile_media');

	function upload_profile_media()
	{

		$current_user = wp_get_current_user();
		$user_register = get_current_user_id();
		$u_names = $current_user->user_nicename ;

		$postId =  $user_register;

		$image_parts = explode(";base64,", $_POST['imagedata']);

		$image_base64 = base64_decode($image_parts[1]);

		$directory = "/".date(Y)."/".date(m)."/";

		$wp_upload_dir = wp_upload_dir( null, false );

		$upload =  $wp_upload_dir['basedir'];

		$upload_dir = $upload.$directory;

		if (! is_dir($upload_dir)) {
			mkdir( $upload_dir, 0755 );
		}


//print_r($wp_upload_dir);


		$filename = "IMG_Prof_img".time().".png";

//$fileurl = $upload.'/'.$filename;

		$fileurl = $upload.$directory.$filename;

		$filetype = wp_check_filetype( basename( $fileurl), null );
 //print_r($filetype);

		file_put_contents($fileurl, $image_base64);

		$attachment = array(
			'guid' => $wp_upload_dir['url'] . '/' . basename( $fileurl ),
			'post_mime_type' => $filetype['type'],
			'post_title' => preg_replace('/\.[^.]+$/', '', basename($fileurl)),
			'post_content' => '',
			'post_status' => 'inherit'
		);

   //print_r($attachment);

  //echo "<br>file name :  $fileurl";

		$attach_id = wp_insert_attachment( $attachment, $fileurl ,$postId);

		require_once ABSPATH . 'wp-admin/includes/image.php';

		$attach_data = wp_generate_attachment_metadata( $attach_id, $fileurl );
		wp_update_attachment_metadata( $attach_id, $attach_data );

		update_user_meta($user_register, 'profile_user_image', $attach_id );
		update_user_meta($user_register, '_profile_user_image','field_59bfc32770468' );

 //set_post_thumbnail( $postId, $attach_id );

		die();
	}

	/*upload profile image end*/
	

	add_action('wp_ajax_nopriv_say_thanks_message', 'say_thanks_message');
	add_action('wp_ajax_say_thanks_message', 'say_thanks_message');

	function say_thanks_message()
	{

		$donor_email = $_POST['d_email'];
		$donor_phone = $_POST['d_phone'];
		$donor_name  = $_POST['d_name'];

		$message1 = "<html><body style='background:#f3f3f3;padding:20px 0;'><table border='0' cellpadding='0' cellspacing='0' style='margin:auto; max-width: 520px;width:100%;font-family: Arial;padding:20px;background:#fff;'><tbody>";
		$message1 .="<tr><td style='font-size: 16px;'>".sprintf(__('Hello')." %s ", ucfirst($donor_name)).",</td></tr><tr height=20></tr>";
		$message1 .="<tr><td style='font-size: 16px; line-height: 20px;'>Welcome to Raise it Fast!</td></tr><tr height=30></tr>";

		$message1 .="<tr><td style='font-size: 16px; line-height: 20px;'>Thank you for your support.</td></tr><tr height=20></tr>";

		$message1 .="<tr><td style='font-size: 16px; margin-top: 20px;'>Thank you for being a part of the Raise It Fast Community! </td></tr></tbody></table><table border='0' cellpadding='0' cellspacing='0' style='margin:20px auto 0; max-width: 520px;width:100%;'>"; 

		$message1 .="<tr><td style='color: #999999; font-size: 12px; text-align: center;'>1401 Lavaca St #503, Austin, TX 78701</td></tr><tr height=20></tr>"; 
		$message1 .="<tr><td style='color: #999999; font-size: 12px; text-align: center;'><a href=".site_url()." style='text-decoration:none; color: #999999;'>The Raise it Fast Team</a></td></tr>";    
		$message1 .="</table></body></html>";

		$check = wp_mail($donor_email, sprintf(__('[%s] Thank you for donation'), get_option('blogname')), $message1);


		if($check)
		{
			echo '1';
		}

				//=========Send Auth Code Via Text message ==================//				

		$account_sid = get_option('twilio_account_sid'); 
		$auth_token  = get_option('twilio_auth_token');							
				//require('lib/twilio-php-latest/Services/Twilio.php');
		$client = new Services_Twilio($account_sid, $auth_token);				
				//$from = '+12182265630';				
		$from        = get_option('twilio_phone_no');

		try
		{
			$client->account->messages->sendMessage( $from, $donor_phone, "Hi ".$donor_name." Thank you for your support.");
		}
		catch (Exception $e)
		{ 
		}

		die();
	}



	/******************** Add User Phone Number For Social Media registered users ******************/
	add_action('wp_ajax_nopriv_add_user_phone_number', 'add_user_phone_number');
	add_action('wp_ajax_add_user_phone_number', 'add_user_phone_number');

	function add_user_phone_number()
	{   
		global $current_user;

		$uid    = $_POST['uid'];
		$uphone = $_POST['uphone'];

		if(is_user_logged_in())
		{		
			$user = wp_get_current_user();
			//$user_id =  $user->ID;			
			$user_email = $user->user_email;
			$user_firstname = $current_user->user_firstname;

			update_user_meta( $uid, 'user_phone', $uphone, true );
			
			$user_phone  = get_user_meta($uid,'user_phone', true);
			
			$auth_code   = get_user_meta($uid,'has_to_be_activated', true);
			
			if(isset($user_phone) && $user_phone !=="")
			{
				
			//=========Send Auth Code Via Text message ==================//				

				$account_sid = get_option('twilio_account_sid'); 
				$auth_token  = get_option('twilio_auth_token');							
				//require('lib/twilio-php-latest/Services/Twilio.php');
				$client = new Services_Twilio($account_sid, $auth_token);				
				//$from = '+12182265630';				
				$from        = get_option('twilio_phone_no');
				$client->account->messages->sendMessage( $from, $user_phone, "Hi $user_firstname, Your Authentication code is $auth_code");

			// Email Notification For Users

				$message1 = "<html><body style='background:#f3f3f3;padding:20px 0;'><table border='0' cellpadding='0' cellspacing='0' style='margin:auto; max-width: 520px;width:100%;font-family: Arial;padding:20px;background:#fff;'><tbody>";
				$message1 .="<tr><td style='font-size: 16px;'>".sprintf(__('Hello')." %s ", ucfirst($user_firstname)).",</td></tr><tr height=20></tr>";
				$message1 .="<tr><td style='font-size: 16px; line-height: 20px;'>Welcome to Raise It Fast!</td></tr><tr height=30></tr>";
				$message1 .="<tr><td style='font-size: 16px; line-height: 20px;'>Please use this code to authenticate your account with Raise it Fast.</td></tr><tr height=20></tr>";
				$message1 .="<tr><td><a style='background:#3498db; padding: 13px 25px; color: #fff; text-decoration: none; font-size: 15px; border-radius: 3px; font-weight: 600;'>".$auth_code."</a></td></tr><tr height=30></tr>";
				$message1 .="<tr><td style='font-size: 16px; line-height: 20px;'>If you have any questions or concerns don't hesitate to use our website chat function, call us, or email us by going to our help page at ".site_url('/contact-us/')." Or, you can simply reply to this email. </td></tr><tr height=30></tr>";  
				$message1 .="<tr><td style='font-size: 16px; margin-top: 20px;'>Thank you for being a part of the Raise It Fast community! </td></tr></tbody></table><table border='0' cellpadding='0' cellspacing='0' style='margin:20px auto 0; max-width: 520px;width:100%;'>"; 

				$message1 .="<tr><td style='color: #999999; font-size: 12px; text-align: center;'>1401 Lavaca St #503, Austin, TX 78701</td></tr><tr height=20></tr>"; 
				$message1 .="<tr><td style='color: #999999; font-size: 12px; text-align: center;'><a href=".site_url()." style='text-decoration:none; color: #999999;'>The Raise it Fast Team</a></td></tr>";    
				$message1 .="</table></body></html>";

				$check = wp_mail($user_email, sprintf(__('[%s] Your Authentication Code'), get_option('blogname')), $message1);

				if($check)
				{
					echo '1';
				}				 
			}		
		}
		die();
	}

	/********************* Authenticate User registered via social media *********************/
	add_action('wp_ajax_nopriv_authenticate_social_user_', 'authenticate_social_user_');
	add_action('wp_ajax_authenticate_social_user_', 'authenticate_social_user_');
	function authenticate_social_user_()
	{
		$authcode  = $_POST['auth_code'];
		$uid       = $_POST['uid'];

		$auth_code = get_user_meta($uid, 'has_to_be_activated', true);

		if($auth_code ==  $authcode)
		{	
			update_user_meta( $uid, 'acc_activate', 1 );

			echo '1';

		}else{

			echo '2';
		}

		die();
	}

	/********************* Check Auth Code **************************/
	add_action('wp_ajax_nopriv_subscribe_email_fund_post', 'subscribe_email_fund_post');
	add_action('wp_ajax_subscribe_email_fund_post', 'subscribe_email_fund_post');
	function subscribe_email_fund_post() {
		$sub_email = $_POST['email'];
		$post_id = $_POST['email_post_id'];

		$custom_fields = get_post_custom($post_id );
		$my_custom_field = $custom_fields['email_subscriber'];

		if(isset($sub_email)) {

			for ($index = 0 ; $index < count($my_custom_field); $index ++)
			{
				$custom_field_data[] = $my_custom_field[$index];
			}

			if (in_array($sub_email, $custom_field_data))
			{
				echo '2';
			}
			else
			{
				$submit = add_post_meta($post_id, 'email_subscriber', $sub_email);
				echo '1';

			}

		}
		die();
	}



	require_once('functions/function-sidebar.php');
	require_once('functions/function-user-data.php');
	require_once('functions/function-recent-fundraiser.php');
	require_once('functions/function-signup.php');
	require_once('functions/function-user-fundraiser-data.php');
	require_once('functions/function-business-partner-data.php');
	require_once('functions/function-fundraiser-approvals.php');
	require_once('functions/function-business-approvals.php');
	require_once('functions/function-pending-fundraisers.php');
	require_once('functions/function-date-change.php');
	require_once('functions/function-fundraiser-accpet-date-time.php');
	require_once('functions/function-dashboard-business-search.php');
	require_once('functions/function-create-business-host-page.php');
	require_once('functions/function-donation-history.php');
	require_once('functions/function-create-fundraiser-campaign.php');
	require_once('functions/function-single-business-partner.php');
	require_once('functions/function-edit-info.php');
	require_once('functions/function-view-all-fundraisers.php');
	require_once('functions/function-view-all-business.php');



	/******************* mail info *****************/

	add_filter('wp_mail_from','yoursite_wp_mail_from');
	function yoursite_wp_mail_from($content_type) {
		$user_info   = get_userdata(1);

		$admin_name  = $user_info->user_login;

		$admin_email = get_option( 'admin_email' );

		return $admin_email;
	}
	add_filter('wp_mail_from_name','yoursite_wp_mail_from_name');
	function yoursite_wp_mail_from_name($name) {
		return 'The Raise it Fast Team';
	}




	// ========= multiple image upload =========
	add_action('wp_ajax_cvf_upload_files', 'cvf_upload_files');
add_action('wp_ajax_nopriv_cvf_upload_files', 'cvf_upload_files'); // Allow front-end submission 

function cvf_upload_files(){
    $parent_post_id = isset( $_POST['post_id'] ) ? $_POST['post_id'] : 0;  // The parent ID of our attachments
    $valid_formats = array("jpg", "png", "gif", "bmp", "jpeg"); // Supported file types
    /*    $max_file_size = 1024 * 500; // in kb*/
    $max_image_upload = 5; // Define how many images can be uploaded to the current post
    $wp_upload_dir = wp_upload_dir();
    $path = $wp_upload_dir['path'] . '/';
    $count = 0;

    $attachments = get_posts( array(
    	'post_type'         => 'retailer',
    	'posts_per_page'    => -1,
    	'post_parent'       => $parent_post_id,
        'exclude'           => get_post_thumbnail_id() // Exclude post thumbnail to the attachment count
    ) );

    // Image upload handler
    if( $_SERVER['REQUEST_METHOD'] == "POST" ){

        // Check if user is trying to upload more than the allowed number of images for the current post
    	if( ( count( $attachments ) + count( $_FILES['files']['name'] ) ) > $max_image_upload ) {
    		$upload_message[] = "Sorry you can only upload " . $max_image_upload . " Business images";
    	} else {

    		foreach ( $_FILES['files']['name'] as $f => $name ) {
    			$extension = pathinfo( $name, PATHINFO_EXTENSION );
                // Generate a randon code for each file name
    			$new_filename = cvf_td_generate_random_code(5)  . '.' . $extension;

    			if ( $_FILES['files']['error'][$f] == 4 ) {
    				continue; 
    			}

    			if ( $_FILES['files']['error'][$f] == 0 ) {
                    // Check if image size is larger than the allowed file size
/*    				if ( $_FILES['files']['size'][$f] > $max_file_size ) {
    					$upload_message[] = "$name is too large!.";
    					continue;

                    // Check if the file being uploaded is in the allowed file types
    				}*/ if( ! in_array( strtolower( $extension ), $valid_formats ) ){
    					$upload_message[] = "$name is not a valid format";
    					continue; 

    				} else{ 
                        // If no errors, upload the file...
    					if( move_uploaded_file( $_FILES["files"]["tmp_name"][$f], $path.$new_filename ) ) {

    					$count++; 

    					$image_parts = explode(";base64,", $_POST['base_64_image']);

    					$image_base64 = base64_decode($image_parts[1]);

    					$directory = "/".date(Y)."/".date(m)."/";

    					$wp_upload_dir = wp_upload_dir( null, false );

    					$upload =  $wp_upload_dir['basedir'];

    					$upload_dir = $upload.$directory;

    					if (! is_dir($upload_dir)) {
    						mkdir( $upload_dir, 0755 );
    					}
    					$filename = "IMG_Prof_img".time().".png";
    					$fileurl = $upload.$directory.$filename;
    					$filetype = wp_check_filetype( basename( $fileurl), null );
    					file_put_contents($fileurl, $image_base64);
    					$attachment = array(
    						'guid' => $wp_upload_dir['url'] . '/' . basename( $fileurl ),
    						'post_mime_type' => $filetype['type'],
    						'post_title' => preg_replace('/\.[^.]+$/', '', basename($fileurl)),
    						'post_content' => '',
    						'post_parent'  => $parent_post_id,
    						'post_status' => 'inherit'
    					);
    					$attach_id = wp_insert_attachment( $attachment, $fileurl ,$postId);

    					require_once ABSPATH . 'wp-admin/includes/image.php';

    					$attach_data = wp_generate_attachment_metadata( $attach_id, $fileurl ); 
    					wp_update_attachment_metadata( $attach_id, $attach_data );
    					set_post_thumbnail( $parent_post_id, $attach_id );

    					}
    				}
    			}
    		}
    	}
    }
    // Loop through each error then output it to the screen
    if ( isset( $upload_message ) ) :
    	foreach ( $upload_message as $msg ){        
    		printf( __('<p class="bg-danger">%s</p>', 'wp-trade'), $msg );
    	}
    endif;
    
    // If no error, show success message
    if( $count != 0 ){
    	printf( __('<p class = "bg-success upload-more-inage"> You may upload more images to your Business Partner listing, please click on upload button to add more images.</p>', 'wp-trade'), $count );   
    }
    
    die();
}



	// ========= multiple image uploads for fundraiser =========
add_action('wp_ajax_fund_cvf_upload_files', 'fund_cvf_upload_files');
add_action('wp_ajax_nopriv_fund_cvf_upload_files', 'fund_cvf_upload_files'); // Allow front-end submission 

function fund_cvf_upload_files(){

    $parent_post_id = isset( $_POST['post_id'] ) ? $_POST['post_id'] : 0;  // The parent ID of our attachments
    $valid_formats = array("jpg", "png", "gif", "bmp", "jpeg"); // Supported file types
    /*    $max_file_size = 1024 * 500; // in kb*/
    $max_image_upload = 5; // Define how many images can be uploaded to the current post
    $wp_upload_dir = wp_upload_dir();
    $path = $wp_upload_dir['path'] . '/';
    $count = 0;

    $attachments = get_posts( array(
    	'post_type'         => 'fundraiser',
    	'posts_per_page'    => -1,
    	'post_parent'       => $parent_post_id,
        'exclude'           => get_post_thumbnail_id() // Exclude post thumbnail to the attachment count
    ) );

    //echo "<pre>"; print_r($attachments);

    // Image upload handler
    if( $_SERVER['REQUEST_METHOD'] == "POST" ){

        // Check if user is trying to upload more than the allowed number of images for the current post
    	if( ( count( $attachments ) + count( $_FILES['files']['name'] ) ) > $max_image_upload ) {
    		$upload_message[] = "Sorry you can only upload " . $max_image_upload . " Fundraiser images";
    	} else {

    		foreach ( $_FILES['files']['name'] as $f => $name ) {
    			$extension = pathinfo( $name, PATHINFO_EXTENSION );
                // Generate a randon code for each file name
    			$new_filename = cvf_td_generate_random_code_forfund( 5 )  . '.' . $extension;

    			if ( $_FILES['files']['error'][$f] == 4 ) {
    				continue; 
    			}

    			if ( $_FILES['files']['error'][$f] == 0 ) {
    				if( ! in_array( strtolower( $extension ), $valid_formats ) ){
    					$upload_message[] = "$name is not a valid format";
    					continue; 

    				} else{ 
                        // If no errors, upload the file...
    					if( move_uploaded_file( $_FILES["files"]["tmp_name"][$f], $path.$new_filename ) ) {

    					$count++; 

    					$image_parts = explode(";base64,", $_POST['base_64_image']);

    					$image_base64 = base64_decode($image_parts[1]);

    					$directory = "/".date(Y)."/".date(m)."/";

    					$wp_upload_dir = wp_upload_dir( null, false );

    					$upload =  $wp_upload_dir['basedir'];

    					$upload_dir = $upload.$directory;

    					if (! is_dir($upload_dir)) {
    						mkdir( $upload_dir, 0755 );
    					}
    					$filename = "IMG_Prof_img".time().".png";
    					$fileurl = $upload.$directory.$filename;
    					$filetype = wp_check_filetype( basename( $fileurl), null );
    					file_put_contents($fileurl, $image_base64);
    					$attachment = array(
    						'guid' => $wp_upload_dir['url'] . '/' . basename( $fileurl ),
    						'post_mime_type' => $filetype['type'],
    						'post_title' => preg_replace('/\.[^.]+$/', '', basename($fileurl)),
    						'post_content' => '',
    						'post_parent'  => $parent_post_id,
    						'post_status' => 'inherit'
    					);
    					$attach_id = wp_insert_attachment( $attachment, $fileurl ,$postId);

    					require_once ABSPATH . 'wp-admin/includes/image.php';

    					$attach_data = wp_generate_attachment_metadata( $attach_id, $fileurl ); 
    					wp_update_attachment_metadata( $attach_id, $attach_data );
    					set_post_thumbnail( $parent_post_id, $attach_id );

    					}


    				}
    			}
    		}
    	}
    }
    // Loop through each error then output it to the screen
    if ( isset( $upload_message ) ) :
    	foreach ( $upload_message as $msg ){        
    		printf( __('<p class="bg-danger">%s</p>', 'wp-trade'), $msg );
    	}
    endif;
    
    // If no error, show success message
    if( $count != 0 ){
    	printf( __('<p class = "bg-success cam-more-image"> You can upload more images to your Fundraiser Campaign, please click on upload button to add more images.  </p>', 'wp-trade'), $count );   
    }
    
    die();
}




// Random code generator used for file names.
function cvf_td_generate_random_code($length=10) {
	$string = '';
	$characters = "23456789ABCDEFHJKLMNPRTVWXYZabcdefghijklmnopqrstuvwxyz";
	for ($p = 0; $p < $length; $p++) {
		$string .= $characters[mt_rand(0, strlen($characters)-1)];
	}
	return $string;
}


// edit business image code

// ========= multiple image upload for fundraiser =========

add_action('wp_ajax_nopriv_buis_edit_upload_files', 'buis_edit_upload_files');
add_action('wp_ajax_buis_edit_upload_files', 'buis_edit_upload_files');

function buis_edit_upload_files()
{

	$postId = $_POST['post_id'];

	$image_parts = explode(";base64,", $_POST['files_data']);

	$image_base64 = base64_decode($image_parts[1]);

	$directory = "/".date(Y)."/".date(m)."/";

	$wp_upload_dir = wp_upload_dir( null, false );

	$upload =  $wp_upload_dir['basedir'];

	$upload_dir = $upload.$directory;

	if (! is_dir($upload_dir)) {
		mkdir( $upload_dir, 0755 );
	}
//print_r($wp_upload_dir);


	$filename = "IMG_Prof_img".time().".png";

//$fileurl = $upload.'/'.$filename;

	$fileurl = $upload.$directory.$filename;

	$filetype = wp_check_filetype( basename( $fileurl), null );
 //print_r($filetype);

	file_put_contents($fileurl, $image_base64);

	$attachment = array(
		'guid' => $wp_upload_dir['url'] . '/' . basename( $fileurl ),
		'post_mime_type' => $filetype['type'],
		'post_title' => preg_replace('/\.[^.]+$/', '', basename($fileurl)),
		'post_content' => '',
		'post_status' => 'inherit'
	);

   //print_r($attachment);

  //echo "<br>file name :  $fileurl";

	$attach_id = wp_insert_attachment( $attachment, $fileurl ,$postId);

	require_once ABSPATH . 'wp-admin/includes/image.php';

	$attach_data = wp_generate_attachment_metadata( $attach_id, $fileurl );
	wp_update_attachment_metadata( $attach_id, $attach_data );

 //set_post_thumbnail( $postId, $attach_id );

	die();
}
// Random code generator used for file names.
function cvf_td_generate_random_code_foreditbuis($length=10) {
	$string = '';
	$characters = "23456789ABCDEFHJKLMNPRTVWXYZabcdefghijklmnopqrstuvwxyz";
	for ($p = 0; $p < $length; $p++) {
		$string .= $characters[mt_rand(0, strlen($characters)-1)];
	}
	return $string;
} 
// Random code generator used for file names.
function cvf_td_generate_random_code_forfund($length=10) {
	$string = '';
	$characters = "23456789ABCDEFHJKLMNPRTVWXYZabcdefghijklmnopqrstuvwxyz";
	for ($p = 0; $p < $length; $p++) {
		$string .= $characters[mt_rand(0, strlen($characters)-1)];
	}
	return $string;
}
//for create business page
add_action('wp_ajax_image_upload_files', 'image_upload_files');
add_action('wp_ajax_nopriv_image_upload_files', 'image_upload_files'); // Allow front-end submission 

function image_upload_files(){

	$busi_name = stripslashes(stripslashes(stripslashes($_POST['buis_name_new'])));
	$busi_name = str_replace('\"', '', $busi_name );
	
	//$buis_name        = $_POST['r_buis_name_new'];
	$busi_desc = stripslashes(stripslashes($_POST['buis_description_new']));
	$busi_desc = str_replace('\"', '', $busi_desc );

	$user_id = $_POST['user_id'];
	$new_post_id = $_POST['hidden_post_id'];



	// Insert the post into the database

	if($new_post_id == "hidden_post_id" )
	{	
		$user_post = array(
			'post_title'   => $busi_name,
			'post_content' => $busi_desc,
			'post_author'    => $user_id,
			'post_type'  => 'retailer',
			'post_status'  => 'publish',
		);
		echo $post_id = wp_insert_post( $user_post );}
		else
		{ 
			$user_post_update = array(
				'ID'           => $new_post_id,
				'post_title'   => $busi_name,
				'post_content' => $busi_desc,
				'post_author'    => $user_id,
				'post_type'  => 'retailer',
				'post_status'  => 'publish',
			);
			echo $post_id = wp_update_post( $user_post_update );  
		}
		die();
	}

//for create fundraiser page
	add_action('wp_ajax_ajax_create_fundraiser_page', 'ajax_create_fundraiser_page');
add_action('wp_ajax_nopriv_ajax_create_fundraiser_page', 'ajax_create_fundraiser_page'); // Allow front-end submission 

function ajax_create_fundraiser_page(){

	$fund_name = stripslashes(stripslashes(stripslashes($_POST['fund_name'])));
	$fund_name = str_replace('\"', '', $fund_name );
	
	$fund_description = stripslashes(stripslashes($_POST['fund_description']));
	$fund_description = str_replace('\"', '', $fund_description );

	$fund_city = $_POST['fund_city'];
	$findzip   = $_POST['findzip'];

	$user_id = $_POST['user_id'];
	$new_post_id = $_POST['post_id'];

	$tax_deductible = $_POST['tax_deductible'];
	$post_org = $_POST['post_org'];

	// Insert the post into the database

	if($new_post_id == "" )
	{	
		$fund_user_post = array(
			'post_title'   => $fund_name,
			'post_content' => $fund_description,
			'post_author'    => $user_id,
			'post_type'  => 'fundraiser',
			'post_status'  => 'draft',
		);
		$post_id = wp_insert_post($fund_user_post);
		if($tax_deductible == 'true')
		{
			update_post_meta($post_id, 'tax_deductible', $tax_deductible); 
		}
		if($post_org != '')
		{
			update_post_meta($post_id, 'post_org', $post_org ); 
		}
		update_post_meta($post_id, 'fund_city', $fund_city );
		update_post_meta($post_id, 'fund_zip', $findzip );  
	}
	else
	{ 
		$fund_user_post_update = array(
			'ID'           => $new_post_id,
			'post_title'   => $fund_name,
			'post_content' => $fund_description,
			'post_author'    => $user_id,
			'post_type'  => 'fundraiser',
			'post_status'  => 'draft',
		);
		$post_id = wp_update_post($fund_user_post_update);

		if($post_org != '')
		{
			update_post_meta( $post_id, 'post_org', $post_org ); 
		}
		if($tax_deductible == 'true')
		{
			update_post_meta($post_id, 'tax_deductible', $tax_deductible); 
		}
		update_post_meta( $post_id, 'fund_city', $fund_city );
		update_post_meta( $post_id, 'fund_zip', $findzip );  
		
	}
	echo trim($post_id);
	die();
}

add_filter( 'fep_header_notification', function( $show ){
	$show = '<div onclick="location.href=\'' . fep_query_url('messagebox') . '\';" style="cursor:pointer;">' . $show . '</div>';
	return $show;
});


add_filter( 'password_change_email', 'wpse207879_change_password_mail_message', 10, 3 );
function wpse207879_change_password_mail_message( $pass_change_mail, $user, $userdata ) {
	$new_message_txt = "<html><body style='background:#f3f3f3;padding:20px 0;'><table border='0' cellpadding='0' cellspacing='0' style='margin:auto; max-width: 520px;width:100%;font-family: Arial;padding:20px;background:#fff;'><tbody><tr><td style='font-size: 16px;'>Hello ".ucfirst($user['user_nicename']).",</td></tr><tr height=20></tr><tr><td style='font-size: 16px; line-height: 20px;'> This notice confirms that your password was changed on  ".site_url()." </td></tr><tr height=20></tr><tr height=20></tr><tr><td style='font-size: 16px; line-height: 20px;'>If you have any questions or concerns don't hesitate to use our website chat function, call us, or email us by going to our help page at ".site_url('/contact-us/')." Or, you can simply reply to this email.</td></tr><tr height=30></tr><tr><td style='font-size: 16px; margin-top: 20px;'>Thank you in advance!</td></tr></tbody></table><table border='0' cellpadding='0' cellspacing='0' style='margin:20px auto 0; max-width: 520px;width:100%;'><tr><td style='color: #999999; font-size: 12px; text-align: center;'>1401 Lavaca St #503, Austin, TX 78701</td></tr><tr height=20></tr><tr><td style='color: #999999; font-size: 12px; text-align: center;'><a href=".site_url()." style='text-decoration:none; color: #999999;'>The Raise it Fast Team</a></td></tr></table></body></html>";
	$pass_change_mail[ 'message' ] = $new_message_txt;
	return $pass_change_mail;
}

//*****************PAGINATION CODE ADDED BY GAURAV********************//

include("include-dashboard-functions.php");
include("include-functions.php");
