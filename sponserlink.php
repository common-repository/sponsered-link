<?php
/*
Plugin Name: Sponsered Link
Version:4.0
Author:Red Symbol Technologies 
Plugin URI:www.redsymboltechnologies.com
Description:Sponser Link is the best free WordPress  plugin. Sponsered Link is allows you to easily create and manage Sponsered Link through a simple admin interface.
*/
?>
<?php
define( 'SPONSERED_LINK_VERSION', '4.0' );
define( 'SPONSERED_LINK_PLUGIN_URL', plugin_dir_url( __FILE__ ) );
define( 'SPONSERED_LINK_PLUGIN_DIR', plugin_dir_path( __FILE__ ) );

require_once(SPONSERED_LINK_PLUGIN_DIR.'/connectDb/install_db.php');
require_once(SPONSERED_LINK_PLUGIN_DIR.'/connectDb/unistall_db.php');

/*Add css in fronted*/

function sponseredLink_admin_init() {
	wp_enqueue_style( 'sponsercss', SPONSERED_LINK_PLUGIN_URL.'css/sponser.css', false, '1.0.0' );
}
add_action( 'wp_enqueue_scripts', 'sponseredLink_admin_init','20' );

/*Add js in plugin */

function sponsered_jquery() {
wp_enqueue_script( 'checkbox_validation', SPONSERED_LINK_PLUGIN_URL.'js/checkbox_validation.js', array(), '1.0.0', true );
}
add_action( 'admin_enqueue_scripts', 'sponsered_jquery' );

function show_sponser() 
{
    global $wpdb;
   include 'sponser_admin.php';   
}
function my_sponser_setting_page(){
	     
	     include('sponser_settings.php');
	}
function sponser_admin() 
{
    add_menu_page("sponser-page", "Sponser Link", 'manage_options', "sponser_admin", "show_sponser");
	add_submenu_page( 'sponser_admin', 'Settings','Settings', 'manage_options', 'sponser_settings','my_sponser_setting_page');
}
add_action('admin_menu', 'sponser_admin');

register_activation_hook(__FILE__,'sponser_activate' );
register_deactivation_hook(__FILE__,'sponser_deactivate' );

/*  Display Title and url*/
add_filter( 'widget_text', 'shortcode_unautop');

add_filter( 'widget_text', 'do_shortcode');

function show_sponser_fornt()
{
     global $wpdb;
	 $limit   = get_option('sponsersetting');
	 $sponserview   = get_option('sponserview');
	 if(!empty($sponserview)){
		 $class=$sponserview ;
	 }
	 else{
		 $class='list';
	 }
     $result  = $wpdb->get_results($wpdb->prepare("select * from ".$wpdb->prefix."sponser_link order by rand() LIMIT 0,%d",$limit));
	 $html    = '<div class="customSocialPanel-'.$class.'"><ul>';
	 foreach($result as $value){
		if($value->publish == 1)
		{
		 $html .= "<li class='".$class."'>";
		 $html .="<a href='".$value->link."' target='".$value->target."'>";
		 $html .="<div class='image-".$class."'>";
		 if($value->image !='' && $class == 'grid'){
			$html .="<img src='".$value->image."'>";
		 }
		 $html .="</div>";
		 $html .="<label>".$value->title."</label>";
		 $html .="</a></li>";
		}
	}
	    $html  .= "</ul></div>";
    return $html;
}
add_shortcode( 'SponseredLink', 'show_sponser_fornt' );

/*Add custom url*/
add_action('wp_ajax_add_sponser', 'process_add_sponser');

function process_add_sponser(){
		if ( empty($_POST) || !wp_verify_nonce($_POST['add-sponser-url'],'add_sponser') ) {
			echo 'You targeted the right function, but sorry, your nonce did not verify.';
			die();
		} else {
				global $wpdb;
				$table_name = $wpdb->prefix."sponser_link";
				$title 	  =  sanitize_text_field($_REQUEST['title']);
	            $link     =  sanitize_text_field($_REQUEST['link']);
		        $created  =  time();
		        $publish  =  sanitize_text_field($_REQUEST['publish']);
				$target  =  sanitize_text_field($_REQUEST['target']);
				$upload     = wp_upload_bits($_FILES["image"]["name"], null, file_get_contents($_FILES["image"]["tmp_name"]));
				$wpdb->insert( 
					$table_name, 
					array( 
						'title'    => $title, 
						'link'     => $link,
						'created'  => $created,
						'publish'  => $publish,
						'target'  => $target,
						'image'      => $upload['url']
					), 
					array( 
						'%s', 
						'%s',
					 	'%s', 
						'%s',
						'%s',
						'%s'
					) 
				);
			    $displayUrl = $_SERVER['HTTP_REFERER'].'&addmsg=Added Successfully';
				echo "<script type='text/javascript'>location.href = '" . $displayUrl. "';</script>";
				die(0);
	}
}
/*Edit custom url*/

add_action('wp_ajax_edit_sponser', 'process_edit_sponser');

function process_edit_sponser(){
	
		if ( empty($_POST) || !wp_verify_nonce($_POST['edit-sponser-url'],'edit_sponser') ) {
			echo 'You targeted the right function, but sorry, your nonce did not verify.';
			die();
		} else {
			global $wpdb;
			$table_name = $wpdb->prefix."sponser_link";
			$title 		= sanitize_text_field($_REQUEST['title']);
			$link 		= sanitize_text_field($_REQUEST['link']);
            $publish 	= sanitize_text_field($_REQUEST['publish']);
			$target  =  sanitize_text_field($_REQUEST['target']);
			if($_FILES["image"]["name"] == ''){
				$upload['url']     =sanitize_text_field($_REQUEST['image_hidden']);
			}
			else{
				$upload     = wp_upload_bits($_FILES["image"]["name"], null, file_get_contents($_FILES["image"]["tmp_name"]));
            }
			$id 		=  sanitize_text_field($_REQUEST['id']);

			$wpdb->update( 
				$table_name, 
				array( 
					'title'    => $title,	
					'link'     => $link,
					'publish'  => $publish,
					'target'  => $target,
					'image'      => $upload['url'] 
				), 
				array( 'id' =>  $id ), 
				array( 
					'%s',	
					'%s',
					'%s',
					'%s',
					'%s'
				), 
				array( '%d' ) 
			);
		    $displayUrl2 = $_SERVER['HTTP_REFERER'];
			$Location22	= explode('&', $displayUrl2);
			echo "<script type='text/javascript'>location.href = '" . $Location22[0].'&editmsg=Update Successfully'. "';</script>";
			die(0);
	}
}
/*setting custom url*/

add_action('wp_ajax_sponser_setting', 'process_sponser_setting');

function process_sponser_setting(){
		if ( empty($_POST) || !wp_verify_nonce($_POST['setting-sponser-url'],'sponser_setting') || !wp_verify_nonce($_POST['setting-sponser-pagination'],'sponser_pagination' ) || !wp_verify_nonce($_POST['setting-sponser-view'],'sponser_view' )) {
			echo 'You targeted the right function, but sorry, your nonce did not verify.';
			die();
		} else {
			global $wpdb;
			$setting = sanitize_text_field($_POST['sponser_text']);
			if(isset($setting) && $setting !=''){
			 update_option( 'sponsersetting', $setting);
			}
			$sponsered_pagination = sanitize_text_field($_POST['sponser_pagination']);
			if(isset($sponsered_pagination) && $sponsered_pagination!=''){
			update_option( 'sponserpagination', $sponsered_pagination);
			}
			$sponser_view = sanitize_text_field($_POST['sponser_view']);
			if(isset($sponser_view) && $sponser_view!=''){
			update_option( 'sponserview', $sponser_view);
			}
		    $pos = strpos($_SERVER['HTTP_REFERER'], '&display=Setting saved');
			if($pos == false ){
			$settingPage = $_SERVER['HTTP_REFERER'].'&display=Setting saved';
			}else{
			$settingPage = $_SERVER['HTTP_REFERER'];
			}
			echo "<script type='text/javascript'>location.href = '" . $settingPage. "';</script>";
			die(0);
	}
}




