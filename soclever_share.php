<?php 
/*
Plugin Name: Social Login & Sharing buttons with Analytics By SoClever
Plugin URI: https://www.socleversocial.com/
Description: A simple and easy to use plugin that enables you to add share buttons to all of your posts and/or pages and login buttons for registering or commenting and get detailed report on our Soclever dashbaord.
Version: 1.1.0
Author: Soclever Team
Author URI: https://www.socleversocial.com/
Author Email:info@socleversocial.com
*/

if ( ! defined('ABSPATH')) exit;

header("Expires: Thu, 19 Nov 1981 08:52:00 GMT");
header("Cache-Control: no-store, no-cache, must-revalidate");


register_activation_hook(__FILE__, 'scss_activation');
register_uninstall_hook(__FILE__, 'scss_uninstall');
require_once(plugin_dir_path( __FILE__ ).'scss_show.php');
function scss_activation(){
		update_option('scss_no_autho_url','https://www.socleversocial.com/dashboard/'); //update plugin version.       
        update_option('scss_display_position','top');
        update_option('scss_valid_domain','0');
        update_option('scss_site_id','0');
        update_option('scss_api_key','0');
        update_option('scss_api_secret','0');
        update_option('scss_selected_buttons','');
        update_option('scss_button_orders','');
        update_option('scss_counter_type','2');
        update_option('scss_gap','1');
        update_option('scss_icon_size','30x30');
        update_option('scss_display_style','0');
        update_option('scss_button_style','1');
        update_option('scss_share_autho','1');
        update_option('scss_domain',''); 
        update_option('scsl_network','');
        update_option('scsl_button_style','ic');
        update_option('scsl_button_size','30');
        update_option('scsl_add_column','0');
        update_option('scsl_email_notify','0');
        update_option('scsl_use_avtar','0');
        update_option('scsl_show_comment','0');
        update_option('scsl_comment_auto_approve','0');
        update_option('scsl_show_in_loginform','1');
        update_option('scsl_login_form_redirect','current');
        update_option('scsl_login_form_redirect_url','');
        update_option('scsl_show_in_regpage','0');
        update_option('scsl_reg_page_redirect','current');
        update_option('scsl_reg_page_redirect_url','');
        update_option('scsl_show_if_members_only','1');
        
        
	}


function scss_uninstall()
	{
		
		delete_option( 'scss_no_autho_url' );         
        delete_option( 'scss_display_position');
        delete_option( 'scss_valid_domain');
		delete_option('scss_site_id');
        delete_option('scss_api_key');
        delete_option('scss_api_secret');
        delete_option('scss_selected_buttons');
        delete_option('scss_button_orders');
        delete_option('scss_counter_type');
        delete_option('scss_gap');
        delete_option('scss_icon_size');
        delete_option('scss_display_style');
        delete_option('scss_button_style');
        delete_option('scss_domain');
        delete_option('scss_share_autho');
        delete_option('scsl_add_column');
        delete_option('scsl_email_notify');
        delete_option('scsl_use_avtar');
        delete_option('scsl_show_comment');
        delete_option('scsl_comment_auto_approve');
        delete_option('scsl_show_in_loginform');
        delete_option('scsl_login_form_redirect');
        delete_option('scsl_login_form_redirect_url');
        delete_option('scsl_show_in_regpage');
        delete_option('scsl_reg_page_redirect');
        delete_option('scsl_reg_page_redirect_url');
        delete_option('scsl_show_if_members_only');

        
	}
    
    function general_soclever_login($resPonse,$is_from)
{
    global $wpdb;
    $fb_data=json_decode($resPonse);      
  $email=$fb_data->email;
  $member_id=$fb_data->member_id;
  $is_from=$is_from;
  $first_name=$fb_data->first_name;
  $last_name=$fb_data->last_name;
  $select_alreay = "SELECT ID,user_login,user_email,user_status FROM ".$wpdb->prefix."users WHERE user_email='".esc_sql($email)."'  LIMIT 1";
        $data=$wpdb->get_results($select_alreay);            
        if(count($data) > 0)
        {
            
            $id_use=$data[0]->ID;
             $is_new='0';
        }
        else
        {
            $pwd=wp_generate_password();
        $fname=$first_name;
        $lname=$last_name;
        $creds['user_login'] = $fname.rand(1,100000);
        $creds['user_pass'] =$pwd;
        $creds['user_email'] =$email;
        $creds['user_nicename'] =$fname.' '.$laname;
        $creds['display_name'] =$fname.' '.$laname;
        $creds['first_name'] =$fname;
        $creds['last_name'] =$lname;
        $creds['user_status']='1';
        $ins_data=wp_insert_user($creds);
        $id_use=intval($ins_data);
        $is_new='1';
        }
        
  $select_user="select user_login from ".$wpdb->prefix."users where ID='".esc_sql($id_use)."'";

$row_user=$wpdb->get_results($select_user);

$new_pass=wp_generate_password();
$user_pass = wp_hash_password($new_pass);
$wpdb->update( $wpdb->prefix.'users', array( 'user_pass' =>$user_pass),array('ID'=>$id_use));
$creds['user_login']=$row_user[0]->user_login;
$creds['user_password']=$new_pass;
$creds['remember'] = true;

$userlogin=wp_signon($creds,true);

$notify_cs=file_get_contents("https://www.socleversocial.com/dashboard/track_register_new.php?siteid=".get_option('scss_site_id')."&action=notifycs&is_new=".$is_new."&is_from=".$is_from."&siteUid=".$id_use."&member_id=".$member_id);
if($notify_cs)
{
    $red_url=($_COOKIE['lch']=='l' || $_COOKIE['lch']=='' )?get_site_url():$_COOKIE['lch'];
    if($is_new=='1' && get_option('scsl_email_notify')=='1')
    {
    scsl_send_reg_email($creds['user_login'],$is_from);    
    
    }
    header("location:".scsl_redirect_url()."");
    exit;
}    
         
  
}

function socleverlogin_plugin_parse_request($wp) {
    global $wpdb;
    
    $lch=sanitize_text_field($_GET['lch']);    
  if(isset($lch) && $lch!='')
{
    setcookie('lch',$lch,time()+100,'/');

}

    if (array_key_exists('socleverlogin-plugin', $wp->query_vars) 
            && $wp->query_vars['socleverlogin-plugin'] == 'social-login') {


 
require 'openid.php';
 
try
{
   
    
    $openid = new LightOpenID($_SERVER['HTTP_HOST']);
     
    
    if(!$openid->mode)
    {
         
        $login_yahoo=sanitize_text_field($_GET['login']);
        if(isset($login_yahoo))
        {
            
            $openid->identity = 'https://me.yahoo.com';
             
            
            $openid->required = array('contact/email','person/guid','dob','birthDate','namePerson' , 'person/gender' , 'pref/language' , 'media/image/default','birthDate/birthday');
             
            
            
            
            header('Location: ' . $openid->authUrl());
        }
        else
        {
            wp_die("Yahoo! login failed.");
        }
        
        
         
    }
     
    else if($openid->mode == 'cancel')
    {
        wp_die('User has canceled authentication!');
        
    }
     
    
    else
    {
        if($openid->validate())
        {
             $d = $openid->getAttributes();
             $cs_url="https://www.socleversocial.com/dashboard/";
            $strurl=(substr(get_option('siteurl'), -1) == '/' ? '' : '/');
            $cs_siteid=get_option('scss_site_id');
            $yoursiteurl=get_option('siteurl').$strurl;

            $siteTitle=get_option('blogname');
            
         
         
            
        $request_url="https://www.socleversocial.com/dashboard/track_register_new.php?is_yh=1&siteid=".get_option('scss_site_id')."&is_from=5&other=".urlencode(json_encode($d));
        $resPonse=file_get_contents($request_url);
        if($resPonse)
        {
           general_soclever_login($resPonse,'5'); 
            
        }    
            
            
             
        }
        else
        {
            
        }
    }
}
 
catch(ErrorException $e)
{
    echo $e->getMessage();
}
 


       
    }
}
add_action('parse_request', 'socleverlogin_plugin_parse_request');

function socleverlogin_plugin_query_vars($vars) {
    $vars[] = 'socleverlogin-plugin';
    return $vars;
}
add_filter('query_vars', 'socleverlogin_plugin_query_vars');

add_action('wp_ajax_scsfblogin', 'scsl_login_fb' );
add_action('wp_ajax_nopriv_scsfblogin', 'scsl_login_fb' );
function scsl_login_fb()
{
    
    global $wpdb;
  $lch=sanitize_text_field($_GET['lch']);
  if(isset($lch) && $lch!='')
{
    setcookie('lch',$lch,time()+100,'/');

} 
   $get_fb=file_get_contents("https://www.socleversocial.com/dashboard/get_fb_data.php?siteid=".get_option('scss_site_id')."");
   
   if($get_fb!='0')
   {
    $app_arr=explode("~",$get_fb);
   $app_id = $app_arr[0];
   $my_url=admin_url('admin-ajax.php')."?action=scsfblogin";
   $app_secret = $app_arr[1];
   $code = $_REQUEST["code"];
   if(isset($_REQUEST['error']))
   {
    if(isset($_REQUEST['error_reason']) && $_REQUEST['error_reason']=='user_denied'){
        
        echo $_REQUEST['error'];
        echo"<br/><a href='".get_site_ur()."'>Go to site</a>";
       exit;
   }
   }
   if(empty($code)) {
        $dialog_url = "http://www.facebook.com/dialog/oauth?client_id=" 
            . $app_id . "&redirect_uri=" . urlencode($my_url)."&scope=email,user_birthday,user_relationships,user_location,user_hometown,user_friends,user_likes";

        echo("<script>top.location.href='".$dialog_url."'</script>");
    }

    $token_url = "https://graph.facebook.com/oauth/access_token?client_id="
        . $app_id . "&redirect_uri=" . urlencode($my_url) . "&client_secret="
        . $app_secret . "&code=" . $code;

	$ch = curl_init();
                    	
	curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
	curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
	curl_setopt($ch, CURLOPT_VERBOSE, 1);
	curl_setopt($ch, CURLOPT_TIMEOUT, 30);
	curl_setopt($ch, CURLOPT_USERAGENT, $_SERVER['HTTP_USER_AGENT']);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
	
	//Get Access Token
	curl_setopt($ch, CURLOPT_URL,$token_url);
	$access_token = curl_exec($ch);
  
	curl_close($ch);
	
	
    $graph_url = "https://graph.facebook.com/v2.2/me?" . $access_token."&fields=id,name,first_name,last_name,timezone,email,picture,gender,locale,birthday,relationship_status,location,hometown,friends.limit%280%29,likes{id,name}";
	$ch = curl_init();
    curl_setopt($ch, CURLOPT_HEADER, 0);
    curl_setopt($ch, CURLOPT_URL, $graph_url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_TIMEOUT, 30);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
    $temp_user = curl_exec($ch);
    curl_close($ch);
	$fbuser_old = $temp_user;	
	$fbuser=json_decode($fbuser_old);
    if($fbuser_old && $fbuser->email!="")
	{
	   
        $request_url="https://www.socleversocial.com/dashboard/track_register_new.php?app_id=".$app_id."&is_fb=1&friend_data=".$fbuser->friends->summary->total_count."&siteid=".get_option('scss_site_id')."&other=".urlencode($fbuser_old);
        $resPonse=file_get_contents($request_url);
        if($resPonse)
        {
         general_soclever_login($resPonse,'1');
                      
        }
        
   }         
    wp_die();
   }
   else
   {
    echo "<h3>Login with FB failed.</h3><a href='".get_site_ur()."'></a>";
   }   
    
}

add_action('wp_ajax_scslogin', 'scsl_login' );
add_action('wp_ajax_nopriv_scslogin', 'scsl_login' );
function scsl_login(){
  global $wpdb;
  $lch=sanitize_text_field($_GET['lch']);
  if(isset($lch) && $lch!='')
{
    setcookie('lch',$lch,time()+100,'/');

} 
   
  $email=(isset($_GET['email']))?sanitize_text_field($_GET['email']):sanitize_text_field($_POST['email']);
  $member_id=(isset($_GET['member_id']))?sanitize_text_field($_GET['member_id']):sanitize_text_field($_POST['member_id']);
  $is_from=(isset($_GET['is_from']))?sanitize_text_field($_GET['is_from']):sanitize_text_field($_POST['is_from']);
  $first_name=(isset($_GET['first_name']))?sanitize_text_field($_GET['first_name']):sanitize_text_field($_POST['first_name']);
  $last_name=(isset($_GET['last_name']))?sanitize_text_field($_GET['last_name']):sanitize_text_field($_POST['last_name']);
  $select_alreay = "SELECT ID,user_login,user_email,user_status FROM ".$wpdb->prefix."users WHERE user_email='".esc_sql($email)."'  LIMIT 1";

        $data=$wpdb->get_results($select_alreay);            
        if(count($data) > 0)
        {
            
            $id_use=$data[0]->ID;
             $is_new='0';
        }
        else
        {
        $pwd=wp_generate_password();
        $fname=$first_name;
        $lname=$last_name;
        $creds['user_login'] = $fname.rand(1,100000);
        $creds['user_pass'] =$pwd;
        $creds['user_email'] =$email;
        $creds['user_nicename'] =$fname.' '.$laname;
        $creds['display_name'] =$fname.' '.$laname;
        $creds['first_name'] =$fname;
        $creds['last_name'] =$lname;
        $creds['user_status']='1';
        $ins_data=wp_insert_user($creds);
        $id_use=intval($ins_data);
        $is_new='1';
        }
        
  $select_user="select user_login from ".$wpdb->prefix."users where ID='".esc_sql($id_use)."'";

$row_user=$wpdb->get_results($select_user);

$new_pass=wp_generate_password();
$user_pass = wp_hash_password($new_pass);
$wpdb->update( $wpdb->prefix.'users', array( 'user_pass' =>$user_pass),array('ID'=>$id_use));
$creds['user_login']=$row_user[0]->user_login;
$creds['user_password']=$new_pass;
$creds['remember'] = true;


	

	



$user=wp_signon($creds,true);


$notify_cs=file_get_contents("https://www.socleversocial.com/dashboard/track_register_new.php?siteid=".get_option('scss_site_id')."&action=notifycs&is_new=".$is_new."&is_from=".$is_from."&siteUid=".$id_use."&member_id=".$member_id);
if($notify_cs)
{

    $red_url=($_COOKIE['lch']=='l' || $_COOKIE['lch']=='')?get_site_url():$_COOKIE['lch'];
    if($is_new=='1' && get_option('scsl_email_notify')=='1')
    {
    scsl_send_reg_email($creds['user_login'],$is_from);    
    
    }
    if($is_from=='7' || $is_from=='8' )
    {
        
    
    header("location:".scsl_redirect_url()."");
    
    exit;

     
    }
    else
    {
        echo scsl_redirect_url();
    }
  
 } 
else
{
exit("not notified");
}
wp_die(); 
}

/*wp new login function start*/

function scsl_comment_approved ($approved)
{
	
	if (empty($approved))
	{
		if (get_option('scsl_comment_auto_approve')=='1')
		{
			$user_id = get_current_user_id ();
			if (is_numeric ($user_id))
			{
				
					$approved = 1;
				
			}
		}
	}
	return $approved;
}
add_action ('pre_comment_approved', 'scsl_comment_approved');


function scsl_filter_comment_form_defaults ($default_fields)
{
    
	
	if (get_option('scsl_show_comment')=='1' && get_option('scsl_show_if_members_only')=='1' && is_array ($default_fields) && comments_open () && !is_user_logged_in ())
	{
		
			if (!isset ($default_fields ['must_log_in']))
			{
				$default_fields ['must_log_in'] = '';
			}
			$default_fields['must_log_in'] .=scsl_get_preview('0');
		
	}
    

	return $default_fields;
}
add_filter ('comment_form_defaults', 'scsl_filter_comment_form_defaults');

function scsl_comment_form_login_buttons( $post_id ) {
    
	if (get_option('scsl_show_comment')=='1' && get_option('scsl_show_if_members_only')=='0' && comments_open () && !is_user_logged_in ())
	{
        echo scsl_get_preview('0');
	}
    
}

add_action( 'comment_form_before', 'scsl_comment_form_login_buttons' );

add_filter ('get_avatar', 'scsl_custom_avatar', 10, 5);

function scsl_custom_avatar( $avatar, $id_or_email, $size, $default, $alt )
{
     
     
     if(get_option('scsl_use_avtar')=='1')
     {   
    $user = false;
		
    if ( is_numeric( $id_or_email ) ) {
			
        $id = (int) $id_or_email;
        $user = get_user_by( 'id' , $id );
			
        } elseif ( is_object( $id_or_email ) ) {
			
            if ( ! empty( $id_or_email->user_id ) ) {
                $id = (int) $id_or_email->user_id;
                $user = get_user_by( 'id' , $id );
            }
			
    } else {
        $user = get_user_by( 'email', $id_or_email );	
    }
		
    if ( $user && is_object( $user ) ) {
       
        $csavatar=file_get_contents("https://www.socleversocial.com/dashboard/get_avtars.php?site_id=".get_option('scss_site_id')."&siteUid=".$user->data->ID."");
        
			
        if ($csavatar!='') {
                
                $avatar = "<img alt='{$alt}' src='{$csavatar}' class='avatar avatar-{$size} photo' height='{$size}' width='{$size}' />";
        }
			
    }
    }
    return $avatar;
}

function scsl_redirect_url()
{
    $red_url=($_COOKIE['lch']=='l')?get_site_url():$_COOKIE['lch'];    
    $redirect_to =$red_url;
		if (get_option('scsl_login_form_redirect')!='')
		{
			switch (strtolower(get_option('scsl_login_form_redirect')))
			{
				case 'current':
						$redirect_to =$redirect_to;					
					break;				
				case 'dashboard':
					$redirect_to = admin_url();
					break;
				case 'custom':
					if (strlen(get_option('scsl_login_form_redirect_url')) > 0)
					{
						$redirect_to = trim(get_option('scsl_login_form_redirect_url'));
					}
					break;
				default:
				case 'homepage':
					$redirect_to = home_url();
					break;
			}
		}
	
	

return $redirect_to;


}

/*wp new login function end*/

if(get_option('scss_valid_domain')=='1')
{
 
 add_action('wp_head', 'scsl_login_head_front');
 
 function scsl_login_head_front()
{
    if(!is_user_logged_in() && get_option('scsl_show_comment')=='1' && (is_single() || is_page()) )
    {
    echo '<script type="text/javascript" src="https://www.socleversocial.com/dashboard/client_share_js/client_'.get_option('scss_site_id').'_login.js"></script>
<script type="text/javascript">
                                        csloginjs.init([\''.get_option('scss_api_key').'\',\''.get_option('scss_site_id').'\',\''.get_option('scss_api_secret').'\',\''.get_option('scss_domain').'\']);
                                            csloginjs.validateCsApi();
                                            
                                        </script>
    ';
   } 
}

    
    add_action('login_head', 'scsl_login_head');

function scsl_login_head()
{
    if(!is_user_logged_in())
    {
    echo '<script type="text/javascript" src="https://www.socleversocial.com/dashboard/client_share_js/client_'.get_option('scss_site_id').'_login.js"></script>
<script type="text/javascript">
                                        csloginjs.init([\''.get_option('scss_api_key').'\',\''.get_option('scss_site_id').'\',\''.get_option('scss_api_secret').'\',\''.get_option('scss_domain').'\']);
                                            csloginjs.validateCsApi();
                                            
                                        </script>
    ';
   } 
}




add_action ('sidebar_login_widget_logged_out_content_end', 'scsl_login_buttons_show');
add_filter( 'login_form', 'scsl_login_buttons_show');
function scsl_login_buttons_show()
 {
    if(!is_user_logged_in() && get_option('scsl_show_in_loginform')=='1' )
    {
    $js_buttons=scsl_get_preview('0');   
    $display_content .=$js_buttons;
    
    echo $display_content;
    }
}



}


add_action( 'admin_menu', 'cs_share_menu' );

function cs_share_menu(){
    add_menu_page( 'SoClever', 'SoClever', 'manage_options', 'soclever_share', 'scsshare_html_page', plugins_url( 'scss_css/sc_share.png', __FILE__ ), 81); 
}

    
    add_action('wp_head', 'scss_image_set');

function scss_image_set()
	{
	  	$scss_image = '';
			
		if ( is_singular() ) 
			{
				$post_thumbnail_id = get_post_thumbnail_id(get_the_ID());
				$post_thumbnail_url = wp_get_attachment_url( $post_thumbnail_id );

if($post_thumbnail_url=='')
                {

                    $post_thumbnail_url=get_header_image();

                }
                
                $scss_image .= '<meta property="scss_image" content="'.$post_thumbnail_url.'" />';
				$scss_image .= '<meta property="og:image" content="'.$post_thumbnail_url.'" />';
                $scss_image .= '<script type="text/javascript" /> var scss_share_image="'.$post_thumbnail_url.'"</script>';
			} 
		else 
			{

			}
			
		echo $scss_image;
	}

 
if((isset($_POST['save_share_1']) && sanitize_text_field($_POST['save_share_1'])=='Save' ) || (isset($_POST['save_share_2']) && sanitize_text_field($_POST['save_share_2'])=='Save' ) || (isset($_POST['save_share_3']) && sanitize_text_field($_POST['save_share_3'])=='Save' ) )
{
    
update_option('scss_display_position',stripslashes(sanitize_text_field($_POST['scss_display_position'])));
$social_buttons=""; $orders="";
$sorting_arry=sanitize_text_field($_POST['short_order']);
if(isset($_POST['share_button']) && count(sanitize_text_field($_POST['share_button'])) > 0)
{
foreach($_POST['share_button'] as $key=>$val)
{
    $new_sorting_arr[$key]=sanitize_text_field($_POST['short_order'][$key]);
}
asort($new_sorting_arr);
foreach($new_sorting_arr as $key=>$val)
{
    if(isset($_POST['share_button'][$key]))
    {
    $social_buttons .=",".sanitize_text_field($_POST['share_button'][$key]);
    $orders .=",".$new_sorting_arr[$key];
    }
}
}
update_option('scss_button_orders',$orders);
update_option('scss_selected_buttons',$social_buttons);
update_option('scss_counter_type',sanitize_text_field($_POST['counter_type']));
update_option('scss_gap',sanitize_text_field($_POST['gap']));
update_option('scss_icon_size',sanitize_text_field($_POST['icon_size']));
update_option('scss_display_style',sanitize_text_field($_POST['display_style']));
update_option('scss_button_style',sanitize_text_field($_POST['button_style']));
update_option('scss_share_autho','1');

$js_written=file_get_contents('https://www.socleversocial.com/dashboard/wp_write_noauthosharejs.php?site_id='.sanitize_text_field(get_option('scss_site_id')).'&save=Save&autho_share=1');
      if($js_written=='1')
      {
        header("location:admin.php?page=soclever_share");
        exit;
        
           
      }

}


if(isset($_POST['save_login']) && $_POST['save_login']=='Save' )
{

update_option('scsl_button_style',sanitize_text_field($_POST['scsl_button_style']));
update_option('scsl_button_size',sanitize_text_field($_POST['scsl_button_size']));
if(isset($_POST['scsl_network']))
{
update_option('scsl_network',sanitize_text_field(implode(",",$_POST['scsl_network'])));    
}
update_option('scsl_caption',sanitize_text_field($_POST['scsl_caption']));
update_option('scsl_add_column',sanitize_text_field($_POST['scsl_add_column']));
update_option('scsl_email_notify',sanitize_text_field($_POST['scsl_email_notify']));

update_option('scsl_use_avtar',sanitize_text_field($_POST['scsl_use_avtar']));
update_option('scsl_show_comment',sanitize_text_field($_POST['scsl_show_comment']));
update_option('scsl_comment_auto_approve',sanitize_text_field($_POST['scsl_comment_auto_approve']));

update_option('scsl_show_in_loginform',sanitize_text_field($_POST['scsl_show_in_loginform']));
update_option('scsl_login_form_redirect',sanitize_text_field($_POST['scsl_login_form_redirect']));
update_option('scsl_login_form_redirect_url',sanitize_text_field($_POST['scsl_login_form_redirect_url']));


update_option('scsl_show_in_regpage',sanitize_text_field($_POST['scsl_show_in_regpage']));
update_option('scsl_reg_page_redirect',sanitize_text_field($_POST['scsl_reg_page_redirect']));
update_option('scsl_reg_page_redirect_url',sanitize_text_field($_POST['scsl_reg_page_redirect_url']));

update_option('scsl_show_if_members_only',sanitize_text_field($_POST['scsl_show_if_members_only']));

    
}   
 

function scsl_send_reg_email($username,$is_from)
{
    $provider_arr=array("1"=>"Facebook","2"=>"LinkedIN","3"=>"Google+","4"=>"Twitter","5"=>"Yahoo","6"=>"Instagram","7"=>"Paypal","8"=>"Microsoft");
	//The blogname option is escaped with esc_html on the way into the database
	$blogname = wp_specialchars_decode (get_option ('blogname'), ENT_QUOTES);

	//Setup Mail Header
	$recipient = get_bloginfo ('admin_email');
	$subject = 'Registration using Social Network - '. $blogname.'';

	//Setup Mail Body
	$body = 'New user registered on your site '.$blogname."\r\n\r\n";
	$body .= 'Username: '.$username."\r\n\r\n";
	$body .= 'Social Network: '.$provider_arr[$is_from]."\r\n";

	//Send Mail
	@wp_mail ($recipient, $subject, $body);
    
}


function scsl_get_preview($is_preview='0')
{
    
    $network=explode(",",get_option('scsl_network'));
    $button_size=get_option('scsl_button_size');
    $btn_style=get_option('scsl_button_style');
    $caption_text=get_option('scsl_caption');
    
    $login_buttons=file_get_contents("https://www.socleversocial.com/dashboard/login_buttons.php?site_id=".get_option('scss_site_id')."&bsize=".$button_size."&bstyle=".$btn_style."&is_preview=".$is_preview."&caption=".base64_encode($caption_text)."&frm=l");
    
    return $login_buttons;
    
}



if(isset($_POST['submit_share']) && sanitize_text_field($_POST['submit_share'])=='Submit' )
{
   
    
    $res_ponse_str=file_get_contents('https://www.socleversocial.com/dashboard/wp_activate.php?site_id='.sanitize_text_field($_POST['client_id']).'&api_key='.sanitize_text_field($_POST['api_key']).'&api_secret='.sanitize_text_field($_POST['api_secret']).'');
    $res_ponse=explode("~~",$res_ponse_str);
    if(sanitize_text_field($_POST['api_key'])==$res_ponse[0] && sanitize_text_field($_POST['api_secret'])==$res_ponse[1] && $res_ponse[0]!='0')
    {
        echo "<h2>Thanks for authentication. Redirecting now to setting page...</h2>";
        /*echo"<br/><h3>Preview</h3><br/>";
        echo htmlspecialchars_decode($res_ponse[2]);*/
        update_option("scss_valid_domain",'1');
        update_option("scss_site_id",sanitize_text_field($_POST['client_id']));
        update_option("scss_api_key",sanitize_text_field($_POST['api_key']));
        update_option("scss_api_secret",sanitize_text_field($_POST['api_secret']));
        update_option("scss_domain",sanitize_text_field($_POST['scss_domain']));
        ?>
        <script type="text/javascript">
         setTimeout(function(){ window.location='admin.php?page=soclever_share'; }, 3000);
         </script>
        <?php
        exit;
    }
    else
    {
       
        echo"<h2 margin='40px;width:90%;'>Authentication failed.If you have already account then please contact us at support@socleversocial.com.If you haven't socleversocial.com account then <a href='https://www.socleversocial.com/pricing/ target='_blank'>Register</a> your account</h2>";
        ?>
        <script type="text/javascript">
         setTimeout(function(){ window.location='options-general.php?page=soclever_share'; }, 3000);
         </script>
        <?php
        exit;
    }
   
}



function scsshare_html_page() {
 wp_register_style( 'scss-style', plugins_url('scss_css/scss_style.css?ver='.time().'', __FILE__) );
 wp_enqueue_style( 'scss-style' );
   
?>

<header class="scss-clearfix">
    <h1>
	<a href="https://www.socleversocial.com/" target="_blank">
        <img src="<?php echo plugins_url( 'scss_css/logo.png', __FILE__ ); ?>" alt="SoClever Social" />
	</a>
    </h1>

    <h2>
       Get access to your Free reports on Soclever Dashboard
    </h2>
</header>



<?php
if(get_option('scss_valid_domain')=='1')
{
    $selected_buttons=explode(",",get_option('scss_selected_buttons'));
    
$all_social_buttons=array("2","4","7","13","17","18","19","20");    
if(is_array($selected_buttons) && get_option('scss_selected_buttons')!='')
{
  $share_button=array_unique(array_merge($selected_buttons,$all_social_buttons), SORT_REGULAR);
    



}
else
{
    $share_button=array("2","4","7","13","17","18","19","20");
}
$share_button_title=array("2"=>"Facebook","4"=>"Google+","7"=>"LinkedIN","13"=>"Twitter","17"=>"Pinterest","18"=>"WhatsApp","19"=>"StumbleUpon","20"=>"Reddit");
$counter_type=get_option('scss_counter_type');
$short_order=array("1","2","3","4","5","6","7","8");
$gap=get_option('scss_gap');
$icon_size=get_option('scss_icon_size');
$display_style=get_option('scss_display_style');
$button_style=get_option('scss_button_style');
$width_arr=explode("x",$icon_size);
$div_width="width:".$width_arr[0]."px;";   
$gap_string="margin-top:".$gap."px;";
 
$float_string="float:right;";
 
 wp_register_script( 'scss_tabb', plugins_url('scss_js/tabbed.js', __FILE__));
 wp_enqueue_script( 'scss_tabb' );
 $img_div_width="width:85%;";
    
?>
<form class="login-form mt-lg" action="" method="post" name="authosharefrm" enctype="multipart/form-data">
<div class="tabber" style="width: 95% !important;">
     <div class="tabbertab">
	  <h2>Sharing Settings</h2>
      <table class="table" style="margin:20px;font-size:1em;">
	  <tr><th align="left">Select networks & Sort Order</th></tr>
                                <tr>
                                    <td style="border: medium none;">
                                        <div style="text-align: right; border-bottom: 1px solid; margin-bottom: 5px;width: 180px;">
                                            <a href="javascript:void(0);" onclick="call_check_uncheck_all('all')">All</a>&nbsp;&nbsp;<a href="javascript:void(0);" onclick="call_check_uncheck_all('none')">None</a>
                                        </div>
                                        <div id="social_list_div" style="width: 100%;">
                                            <?php $i=0;
                                            
                                            if(count($share_button)>0)
                                            {
                                                foreach($share_button as $key => $val)
                                                {
                                                    if($share_button_title[$val]!='')
                                                    {
                                                    $i++;
                                                     $odr=$i;
                                                     $left_margin="20%";
                                                     switch($val)
                                                     {
                                                        case '2':
                                                        $left_margin="18%";
                                                        break;
                                                        case '4':
                                                        $left_margin="21%";
                                                        break;
                                                        case '13':
                                                        $left_margin="24%";
                                                        break;
                                                        
                                                     }
                                                    ?>
                                                    <div style="margin-bottom: 5px;">
                                                        <input type="checkbox" name="share_button[<?php echo $i;?>]" id="share_button_<?php echo $i;?>" value="<?php echo $val;?>"  <?php if(is_array($selected_buttons) && in_array($val,$selected_buttons)) { ?> checked="checked"  <?php } ?> />&nbsp;&nbsp;<?php echo $share_button_title[$val];?>
                                                        <input type="text" style="width: 20px;margin-left:<?php echo $left_margin; ?>;"  name="short_order[<?php echo $odr;?>]" id="short_order_<?php echo $odr;?>" value="<?php echo $odr;?>" /> 
                                                    </div>
                                                    <?php 
                                                    }
                                                }
                                            }
                                            else
                                            {
                                                ?><input type="hidden" name="share_button[0]" value="0" /> <?php
                                            }
                                             ?>
                                        </div>
                                    </td>
                                </tr>
                                
                                <tr>
                    <th align="left">Display Position</th>
                    </tr>
                    <tr>                    
                    <td>
                    <select name="scss_display_position" id="scss_display_position">
                    <option value="top" <?php if(get_option('scss_display_position')=='top') { echo "selected='selected'"; } ?>>Top</option>
                    <option value="bottom" <?php if(get_option('scss_display_position')=='bottom') { echo "selected='selected'"; } ?>>Bottom</option>
                    <option value="both" <?php if(get_option('scss_display_position')=='both') { echo "selected='selected'"; } ?>>Both</option>
                    </select>
                    </td>
                    </tr>
                               
                    <tr>
                                    <td>
                                        <div class="clearfix">
                                            <div class="btn-toolbar pull-right">
                                            
                                                <input type="submit" name="save_share_1" class="scssbutton" value="Save" />
                                            </div>
                                        </div>
                                    </td>
                     </tr>
                     
        </table>                        
     </div>


     <div class="tabbertab">
	  <h2>Share Bar Style</h2>
	  <table class="table" style="margin:20px;font-size:1em;">
      <tr>
      <th align="left">Select Your Style</th></tr>
      <tr>
      <td style="border: medium none;">
                                        
                                        <div><input type="radio" name="button_style" style="margin-top: 10px;" id="button_style_2" value="1"<?php if($button_style=="1") { echo ' checked="checked"'; };?>  /><div style="margin-top: -26px;margin-left:20px;">&nbsp;&nbsp;<img src="<?php echo plugins_url( 'scss_css/style201.png', __FILE__ ); ?>" style="width:140px;" alt="Square Icons" title="Square Icons" /></div></div>
                                        <div><input type="radio" name="button_style" style="margin-top: 10px;" id="button_style_3" value="2"<?php if($button_style=="2") { echo ' checked="checked"'; };?>  /><div style="margin-top: -24px;margin-left:20px;">&nbsp;&nbsp;<img src="<?php echo plugins_url( 'scss_css/style202.png', __FILE__ ); ?>" style="width:140px;" alt="Rounded Icons" title="Rounded Icons" /></div></div>
                                        <div><input type="radio" name="button_style" style="margin-top: 10px;" id="button_style_4" value="3"<?php if($button_style=="3") { echo ' checked="checked"'; };?>  /><div style="margin-top: -20px;margin-left:20px;">&nbsp;&nbsp;<img src="<?php echo plugins_url( 'scss_css/style203.png', __FILE__ ); ?>" style="width:140px;" alt="Square Grey Icons" title="Square Grey Icons" /></div></div>
                                        <div><input type="radio" name="button_style" style="margin-top: 10px;" id="button_style_5" value="4"<?php if($button_style=="4") { echo ' checked="checked"'; };?>  /><div style="margin-top: -20px;margin-left:20px;">&nbsp;&nbsp;<img src="<?php echo plugins_url( 'scss_css/style204.png', __FILE__ ); ?>" style="width:140px;" alt="Rounded Grey Icons" title="Rounded Grey Icons"  /></div></div>
      </td>
      </tr>
      <tr><th align="left">Button Size</th></tr>
                                <tr>
                                    <td style="border: medium none;">
                                    
                                    
                                        <select name="icon_size">
                                        <option value="30x30"<?php if($icon_size=="30x30") { echo 'selected'; };?>  />&nbsp;&nbsp;30x30</option>
                                        <option value="32x32"<?php if($icon_size=="32x32") { echo 'selected'; };?>  />&nbsp;&nbsp;32x32</option>
                                        <option value="40x40"<?php if($icon_size=="40x40") { echo 'selected'; };?>  />&nbsp;&nbsp;40x40</option>
                                        <option value="50x50"<?php if($icon_size=="50x50") { echo 'selected'; };?>  />&nbsp;&nbsp;50x50</option>
                                        <option value="60x60"<?php if($icon_size=="60x60") { echo 'selected'; };?>  />&nbsp;&nbsp;60x60</option>
                                        <option value="70x70"<?php if($icon_size=="70x70") { echo 'selected'; };?>  />&nbsp;&nbsp;70x70</option>
                                        <option value="85x85"<?php if($icon_size=="85x85") { echo 'selected'; };?>  />&nbsp;&nbsp;85x85</option>
                                        <option value="100x100"<?php if($icon_size=="100x100") { echo 'selected'; };?> />&nbsp;&nbsp;100x100</option>
                                        </select>
                                    </td>
        </tr>
        
        <tr><th align="left">Display Style</th></tr>
                                <tr>
                                    <td style="border: medium none;">
                                        <div><input type="radio" name="display_style" id="display_style_1" value="0"<?php if($display_style=="0") { echo ' checked="checked"'; };?>  />&nbsp;&nbsp;Horizontal</div>
                                        <div><input type="radio" name="display_style" id="display_style_2" value="1"<?php if($display_style=="1") { echo ' checked="checked"'; };?>  />&nbsp;&nbsp;Vertical (Left)</div>
                                        <div><input type="radio" name="display_style" id="display_style_3" value="2"<?php if($display_style=="2") { echo ' checked="checked"'; };?>  />&nbsp;&nbsp;Vertical (Right)</div>                                        
                                    </td>
                                </tr>
         <tr><th align="left">Padding Gap</th></tr>
                                <tr>
                                    <td style="border: medium none;">
                                    <select name="gap" id="gap" >
                                    <?php for($i=0;$i<=20;$i++) { ?>
                                    <option value="<?php echo $i; ?>" <?php echo ($i==$gap)?"selected":"";?> ><?php echo $i; ?></option>
                                    <?php } ?>
                                    </select>px
                                         </td>
                                </tr>                       
            <tr>
                                    <td>
                                        <div class="clearfix">
                                            <div class="btn-toolbar pull-right">
                                            
                                                <input type="submit" name="save_share_2" class="scssbutton" value="Save" />
                                            </div>
                                        </div>
                                    </td>
                     </tr>
                                                                  
      </table>
     </div>
        

     <div class="tabbertab">
	  <h2>Share Bar Counter</h2>
	  <table class="table" style="margin:20px;font-size:1em;">
      <tr><th align="left">Counter Display</th></tr>
                                <tr>
                                    <td style="border: medium none;">
                                        <div><input type="radio" name="counter_type" id="counter_type_1" value="0"<?php if($counter_type=="0") { echo ' checked="checked"'; };?>  />&nbsp;&nbsp;Horizontal</div>
                                        <div><input type="radio" name="counter_type" id="counter_type_2" value="1"<?php if($counter_type=="1") { echo ' checked="checked"'; };?>  />&nbsp;&nbsp;Vertical</div>
                                        <div><input type="radio" name="counter_type" id="counter_type_3" value="2"<?php if($counter_type=="2") { echo ' checked="checked"'; };?>  />&nbsp;&nbsp;No Counter</div>
                                    </td>
                                </tr> 
        <tr>
                                    <td>
                                        <div class="clearfix">
                                            <div class="btn-toolbar pull-right">
                                            
                                                <input type="submit" name="save_share_3" class="scssbutton" value="Save" />
                                            </div>
                                        </div>
                                    </td>
                     </tr>
                                    
      </table>
     </div>
     <div class="tabbertab">
	  <h2>Social Login</h2>
	  
      
                            <table class="scsl_login_table" style="margin:20px 20px 20px 0px;font-size:1em;width:100%;" cellspacing="3" cellpadding="3">
                                
                                
                    
                   
 
                    <tr class="heading_row">
                    <th>General Setting</th>
                    </tr>
                    
                    <tr>
							<td>
								<strong>Enter text to be shown on top of social login box. </strong>
							</td>
						</tr>
						<tr>
							<td>
								<?php
									$scsl_caption =(get_option('scsl_caption')) ? get_option('scsl_caption') : 'Login with:';
								?>
								<input type="text" name="scsl_caption" size="79" value="<?php echo htmlspecialchars ($scsl_caption); ?>" />
							</td>
						</tr>
                    
                    <tr>
                    <tr>
							<td>
								<strong>Please select login button style</strong>
							</td>
						</tr>
						<tr>
							<td>
								
								<input type="radio" name="scsl_button_style" value="ic" <?php echo (get_option('scsl_button_style') == 'ic' ? 'checked="checked"' : ''); ?> /> <strong>Square Icons</strong><br />
							<input type="radio" name="scsl_button_style" value="fc" <?php echo (get_option('scsl_button_style') == 'fc' ? 'checked="checked"' : ''); ?> /> <strong>Colored Logos</strong><br />
                            <input type="radio" name="scsl_button_style" value="fg" <?php echo (get_option('scsl_button_style') == 'fg' ? 'checked="checked"' : ''); ?> /> <strong>Grey Logos</strong>
							</td>
						</tr>
                    
                    <tr>
							<td>
								<strong>Please select Login button size</strong>
							</td>
						</tr>
						<tr>
							<td>
								
							<input type="radio" name="scsl_button_size" value="30" <?php echo (get_option('scsl_button_size') == '30' ? 'checked="checked"' : ''); ?> /> <strong>30px</strong><br />
							<input type="radio" name="scsl_button_size" value="40" <?php echo (get_option('scsl_button_size') == '40' ? 'checked="checked"' : ''); ?> /> <strong>40px </strong><br />
                            <input type="radio" name="scsl_button_size" value="50" <?php echo (get_option('scsl_button_size') == '50' ? 'checked="checked"' : ''); ?> /> <strong>50px</strong><br />
                            <input type="radio" name="scsl_button_size" value="60" <?php echo (get_option('scsl_button_size') == '60' ? 'checked="checked"' : ''); ?> /> <strong>60px</strong><br />
                            <input type="radio" name="scsl_button_size" value="65" <?php echo (get_option('scsl_button_size') == '65' ? 'checked="checked"' : ''); ?> /> <strong>65px</strong><br />
							</td>
						</tr>
                     <tr>
							<td>
								<strong>Do you want to receive an email when new user registers with social network?</strong>
							</td>
						</tr>
						<tr>
							<td>
								
							<input type="radio" name="scsl_email_notify" value="1" <?php echo (get_option('scsl_email_notify') == '1' ? 'checked="checked"' : ''); ?> /> <strong>Yes</strong><br />
                            <input type="radio" name="scsl_email_notify" value="0" <?php echo (get_option('scsl_email_notify') == '0' ? 'checked="checked"' : ''); ?> /> <strong>No</strong><br />
							
							</td>
						</tr>                
                        <tr>
							<td>
								<strong>If user's social network has avtar then do you want to use it as default avtar?</strong>
							</td>
						</tr>
						<tr>
							<td>
								
							<input type="radio" name="scsl_use_avtar" value="0" <?php echo (get_option('scsl_use_avtar') == '0' ? 'checked="checked"' : ''); ?> /> <strong>No</strong><br />
                            <input type="radio" name="scsl_use_avtar" value="1" <?php echo (get_option('scsl_use_avtar') == '1' ? 'checked="checked"' : ''); ?> /> <strong>Yes,if user's social network has avtar.</strong><br />
                            
							
							</td>
						</tr>    
                    </table> 
                    <table class="scsl_login_table" style="margin:20px 20px 20px 0px;font-size:1em;width:100%;" cellspacing="3" cellpadding="3">
                    <tr class="heading_row">
                    <th>Comment Setting</th>
                    </tr> 
                        <tr>
							<td>
								<strong>Do you want to show social login box on comment area?</strong>
							</td>
						</tr>
						<tr>
							<td>
								
							<input type="radio" name="scsl_show_comment" value="1" <?php echo (get_option('scsl_show_comment') == '1' ? 'checked="checked"' : ''); ?> /> <strong>Yes</strong><br />
                            <input type="radio" name="scsl_show_comment" value="0" <?php echo (get_option('scsl_show_comment') == '0' ? 'checked="checked"' : ''); ?> /> <strong>No</strong><br />
                            
							
							</td>
						</tr> 
                        
                        <tr>
							<td>
								<strong>Show the Social Login buttons in the comment area if comments are disabled for guests?</strong>
							</td>
						</tr>
						<tr class="row_even">
							<td>
								
								<span>The buttons will be displayed below the "You must be logged in to leave a comment" notice</span><br />
								<input type="radio" name="scsl_show_if_members_only" value="1" <?php echo (get_option('scsl_show_if_members_only') == 1 ? 'checked="checked"' : ''); ?> /><b>Yes</b><br />
								<input type="radio" name="scsl_show_if_members_only" value="0" <?php echo (get_option('scsl_show_if_members_only') == 0 ? 'checked="checked"' : ''); ?> /> <b>No</b>
							</td>
						</tr>
					
                        
                        
                        <tr>
							<td>
								<b>Do you want to automatically approve comments posted by users who are logged in with social login?</b>
							</td>
						</tr>
						<tr>
							<td>
								
							<input type="radio" name="scsl_comment_auto_approve" value="1" <?php echo (get_option('scsl_comment_auto_approve') == '1' ? 'checked="checked"' : ''); ?> /> <strong>Yes</strong><br />
                            <input type="radio" name="scsl_comment_auto_approve" value="0" <?php echo (get_option('scsl_comment_auto_approve') == '0' ? 'checked="checked"' : ''); ?> /> <strong>No</strong><br />
                            
							
							</td>
						</tr>
                    </table>    
                    <table class="scsl_login_table" style="margin:20px 20px 20px 0px;font-size:1em;width:100%;" cellspacing="3" cellpadding="3">
                    <tr class="heading_row">
                    <th>Login Setting</th>
                    </tr>
                    <tr>
                    <td><b>Do you want show login buttons in login form?</b></td>
                    </tr>                        
                    <tr>
                    <td>
                    
                            <input type="radio" name="scsl_show_in_loginform" value="1" <?php echo (get_option('scsl_show_in_loginform') == '1' ? 'checked="checked"' : ''); ?> /> <strong>Yes</strong><br />
                            <input type="radio" name="scsl_show_in_loginform" value="0" <?php echo (get_option('scsl_show_in_loginform') == '0' ? 'checked="checked"' : ''); ?> /> <strong>No</strong><br />
                            
                    </td>
                    </tr>
                    <tr>
                    <td><b>Where user should be redirected after login from login page?</b></td>
                    </tr>                        
                    <tr>
                    <td>
                    
                                <input type="radio" name="scsl_login_form_redirect" value="current" <?php echo (get_option('scsl_login_form_redirect') == 'current' ? 'checked="checked"' : ''); ?> />Current page<br />
								<input type="radio" name="scsl_login_form_redirect" value="homepage" <?php echo (get_option('scsl_login_form_redirect') == 'homepage' ? 'checked="checked"' : ''); ?> /> Home Page<br />
								<input type="radio" name="scsl_login_form_redirect" value="dashboard" <?php echo (get_option('scsl_login_form_redirect') == 'dashboard' ? 'checked="checked"' : ''); ?> />Dashboard<br />
								<input type="radio" name="scsl_login_form_redirect" value="custom" <?php echo (get_option('scsl_login_form_redirect') == 'custom' ? 'checked="checked"' : ''); ?> /> Following URL:<br />
								<input type="text" name="scsl_login_form_redirect_url" size="79" value="<?php echo htmlspecialchars (get_option('scsl_login_form_redirect_url')); ?>" />
                            
                    </td>
                    </tr>                    
                    <tr>
                    <th align="left">Providers</th>
                    </tr>
                    <tr>                    
                    <td>
                    <?php  $savedSetting=file_get_contents("https://www.socleversocial.com/dashboard/wp_login_setting.php?site_id=".get_option('scss_site_id')."&action=preview&button_style=".get_option('scsl_button_style')."&button_size=".get_option('scsl_button_size')."");
                    if($savedSetting=='0')
                    {
                        echo"<font color='#ff0000'>No provider selected on SoCleverSocial Dashboard</font>";
                    }
                    else
                    {
                        echo $savedSetting;
                    }
                    
                     ?>      
                    </td>
                    </tr>                    
                    <?php if($savedSetting!='0')
                    {
                     ?>    
                    <tr>
                                    <td>
                                        <div class="clearfix">
                                            <div class="btn-toolbar pull-right">                                            
                                                <input type="submit" name="save_login" class="scssbutton" value="Save" />
                                            </div>
                                        </div>
                                    </td>
                      </tr>
                      <?php } ?>
                            </table>
                        
                        
     </div>
    
</div>
</form>
<?php wp_nonce_field('update-options'); ?>
<script type="text/javascript">


    function call_check_uncheck_all(chk)
    {
       var totalsocials="<?php echo count($share_button); ?>";
        if(chk!="N/A")
        {
            for(i=1;i<=totalsocials;i++)
            {
                if(chk=="all") {
                    document.getElementById('share_button_'+i).checked=true;
                }

                else if(chk=="none") {
                    document.getElementById('share_button_'+i).checked=false;
                }
            }
        }
       
    }
    
    
</script>


<?php } else { ?>  

<table id="cssteps">
        <thead>
            <tr valign="top">
                <th>
                <h1>Step 1 - Create a SocleverSocial.com account</h1>
                <p>To get started, register your Soclever Social account and find your API key in the site settings. If you already have an account please log in. </p>
                </th>
            </tr>
        </thead>
        <tbody>
           
        </tbody>
        <tfoot>
            <tr valign="top">
                <td>
                    <a href="https://www.socleversocial.com/register/?wpd=<?php echo base64_encode(get_site_url()); ?>" target="_blank" class="scssbutton">Register</a> 
                    <a href="https://www.socleversocial.com/dashboard/" target="_blank" class="scssbutton">Login</a></p>
                </td>
            </tr>
            <tr valign="top" align="left">
                <th>
                <h1>Step 2 - Enter your API Settings</h1>                
                </th>
            </tr>
            <tr>
            <td>
                <form method="post" action="">
  <?php wp_nonce_field('update-options'); ?>
<table width="55%">
<tr valign="middle">
<th width="20%" scope="row">Client ID</th>
<td>
<input type="text" name="client_id" id="client_id" width="10" />
 
</td>
</tr>
<tr valign="middle">
<th width="20%" scope="row">API Key</th>
<td>
<input type="text" name="api_key" id="api_key"  width="40"/>
 
</td>
</tr>
<tr valign="middle">
<th width="20%" scope="row">API Secret</th>
<td>
<input type="text" name="api_secret" id="api_secret"  width="40"/>
 
</td>
</tr>
<tr valign="middle">
<th width="20%" scope="row">Valid Domain</th>
<td>
<input type="text" name="scss_domain" id="scss_domain"  width="100"/> 
 
</td>
</tr>
<tr valign="middle">
<td>&nbsp;</td>
<td>
<input type="submit" name="submit_share" class="scssbutton" id="submit_share"  value="Submit"/>
 
</td>
</tr>
</table>
  </form>
  
            
            </td>
            </tr>
        </tfoot>
    </table>

  
    
    
<?php    
}
 ?>
<div style="background: none repeat scroll 0 0 #fff;border: 1px solid #eee;margin-bottom: 30px;width:95%;">
					<h4 style=" border-bottom: 1px solid #eee;margin-bottom: 10px;padding: 10px 0;text-align: center;">Help</h4>
					<div style="padding: 10px 10px 30px 0px;">
						<a style="display:block;margin-left:10px;" href="http://developers.socleversocial.com/wordpress-social-sharing-buttons-instructions/" target="_blank">
							Plug in Configuration and Troubleshooting</a>
						<a style="display:block;margin-left:10px;" href="http://developers.socleversocial.com/how-to-get-api-key-and-secret/" target="_blank">
							How to get Soclever API key and secret?</a>
						<a style="display:block;margin-left:10px;" href="http://developers.socleversocial.com/" target="_blank">
							Social Network Apps Set Up</a>
						<a style="display:block;margin-left:10px;" href="https://www.socleversocial.com/about-us/" target="_blank">
							About Soclever</a>	
							<b> How to create Facebook App for your website</b><br />
<iframe src="//player.vimeo.com/video/118392066?title=0&byline=0&portrait=0" width="800" height="481" frameborder="0" webkitallowfullscreen mozallowfullscreen allowfullscreen></iframe>
					</div>
				</div>

 <?php } ?>