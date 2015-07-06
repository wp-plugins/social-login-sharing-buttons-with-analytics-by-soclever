<?php 

/*

Plugin Name: Social Login & Sharing buttons with Analytics By SoClever

Plugin URI: https://www.socleversocial.com/

Description: A simple and easy to use plugin that enables you to add share buttons to all of your posts and/or pages and login buttons for registering or commenting and get detailed report on our Soclever dashbaord.

Version: 1.2.0

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

        update_option('scss_button_style','2');

        update_option('scss_share_autho','1');

        update_option('scss_domain',''); 

        update_option('scsl_network','');
        update_option('scsss_mobile_friendly','0');

        update_option('scsl_button_style','ic');

        update_option('scsl_button_size','30');

        update_option('scsl_add_column','0');

        update_option('scsl_email_notify','0');

        update_option('scsl_use_avtar','0');

        update_option('scsl_show_comment','0');
        update_option('scsss_clientfb_id','');
        update_option('scsss_default_img','');

        update_option('scsl_comment_auto_approve','0');

        update_option('scsl_show_in_loginform','1');

        update_option('scsl_login_form_redirect','current');

        update_option('scsl_login_form_redirect_url','');

        update_option('scsl_show_in_regpage','0');

        update_option('scsl_reg_page_redirect','current');

        update_option('scsl_reg_page_redirect_url','');

        update_option('scsl_show_if_members_only','1');
        
        update_option('scsls_module_loaded','0');
        update_option('scs_sharebar_enable','1');
        
        update_option('customlogin_fb','');
        update_option('customlogin_gp','');
        update_option('customlogin_tw','');
        update_option('customlogin_li','');
        update_option('customlogin_yh','');
        update_option('customlogin_ms','');
        update_option('customlogin_pp','');
        update_option('customlogin_ig','');
        

        
        $share_button_title=array("2"=>"Facebook","4"=>"Google+","7"=>"LinkedIN","13"=>"Twitter","17"=>"Pinterest","18"=>"WhatsApp","19"=>"StumbleUpon","20"=>"Reddit","21"=>"Tumblr");
        foreach($share_button_title as $key=>$val)
        {
            $val=($val=='Google+')?'google_plus':$val;
            update_option('scss_custom_'.strtolower($val).'','');    
        }
        

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
        delete_option('scsss_default_img');
        delete_option('scsss_clientfb_id');
        

        delete_option('scsl_use_avtar');

        delete_option('scsl_show_comment');

        delete_option('scsl_comment_auto_approve');

        delete_option('scsl_show_in_loginform');

        delete_option('scsl_login_form_redirect');

        delete_option('scsl_login_form_redirect_url');

        delete_option('scsl_show_in_regpage');
        delete_option('scsss_mobile_friendly');

        delete_option('scsl_reg_page_redirect');

        delete_option('scsl_reg_page_redirect_url');

        delete_option('scsl_show_if_members_only');
        
        delete_option('scs_sharebar_enable');
        
        
        delete_option('customlogin_fb');
        delete_option('customlogin_gp');
        delete_option('customlogin_tw');
        delete_option('customlogin_li');
        delete_option('customlogin_yh');
        delete_option('customlogin_ms');
        delete_option('customlogin_pp');
        delete_option('customlogin_ig');
        
        
        
         $share_button_title=array("2"=>"Facebook","4"=>"Google+","7"=>"LinkedIN","13"=>"Twitter","17"=>"Pinterest","18"=>"WhatsApp","19"=>"StumbleUpon","20"=>"Reddit","21"=>"Tumblr");
        foreach($share_button_title as $key=>$val)
        {
            $val=($val=='Google+')?'google_plus':$val;
            delete_option('scss_custom_'.strtolower($val).'');    
        }                



        

	}

add_action('wp_footer', 'scsls_js_footer');

function scsls_js_footer()
{
    
    $footer_js="";
    if(!get_option('scs_share_ins') && !get_option('scs_login_ins') )
    {
   $footer_js='<script type="text/javascript">var sid=\''.get_option('scss_site_id').'\';(function()
                                                    { var u=((\'https:\'==document.location.protocol)?\'http://\':\'http://\')+\'s3.socleversocial.com/\'; var su=u;var s=document.createElement(\'script\'); s.type=\'text/javascript\'; s.defer=true; s.async=true; s.src=su+\'scs.js\'; var p=document.getElementsByTagName(\'script\')[0]; p.parentNode.insertBefore(s,p); }
                                                    )();       
                                           </script>'; 
   $footer_js .=PHP_EOL;
   }
   echo $footer_js;                                        
}	   


function soclever_share_login_setup($links, $file)
{
	static $soclever_social_share_plugin = null;

	if (is_null ($soclever_social_share_plugin))
	{
		$soclever_social_share_plugin = plugin_basename (__FILE__);
	}

	if ($file == $soclever_social_share_plugin)
	{
		$settings_link = '<a href="admin.php?page=soclever_share">' . __ ('Setup', 'soclever_share') . '</a>';
		array_unshift ($links, $settings_link);
	}
	return $links;
}
add_filter ('plugin_action_links', 'soclever_share_login_setup', 10, 2);


function scss_admin_scripts() {
	
        wp_enqueue_script('jquery-ui-sortable');
		wp_enqueue_script('jquery-ui');
        
	}
    
    function scss_admin_styles() {
	
		// admin styles
		wp_enqueue_style('thickbox');
		wp_enqueue_style('wp-color-picker');
		
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

$creds['user_login']=$row_user[0]->user_login;

        wp_set_current_user($user_id,$creds['user_login']);
        wp_set_auth_cookie($id_use);
        do_action('wp_login', $creds['user_login']);
  


$notify_cs=get_cslcurl("https://www.socleversocial.com/dashboard/track_register_new.php?siteid=".get_option('scss_site_id')."&action=notifycs&is_new=".$is_new."&is_from=".$is_from."&siteUid=".$id_use."&member_id=".$member_id);

if($notify_cs)

{

    $red_url=($_COOKIE['lch']=='l' || $_COOKIE['lch']=='' )?get_site_url():$_COOKIE['lch'];

    if($is_new=='1' && get_option('scsl_email_notify')=='1')

    {

    scsl_send_reg_email($creds['user_login'],$is_from);    

    

    }
    
    if($is_new=='1' && get_option('scsl_email_notify_user')=='1')
    {
    wp_new_user_notification($id_use,$pwd);    
    
    }
    
    $isIosChrome = (strpos($_SERVER['HTTP_USER_AGENT'], 'CriOS') !== false) ? true : false;
    if(isset($_GET['lch']))
    {
        $lch=$_GET['lch'];
    }
    else if($_COOKIE['lch'])
    {
        $lch=$_COOKIE['lch'];
    }
    
    
    $ic='0';
    if(isset($_GET['ic']))
    {
        $ic=$_GET['ic'];
    }
    else if($_COOKIE['ic'])
    {
        $ic=$_COOKIE['ic'];
    }
    
    
    if(!$isIosChrome)
    {
        
    
    //$red_url=($_COOKIE['lch']=='l')?get_site_url():$_COOKIE['lch'];
     ?>
     <script type="text/javascript">
     if(opener)
     {
     opener.location.href='<?php echo scsl_redirect_url($lch,$ic); ?>';
     close();
     }
     else
     {
        window.location.href='<?php echo scsl_redirect_url($lch,$ic); ?>';
     }
     </script>
     <?php
     }
     else
     {
     ?>
     <script type="text/javascript">
     window.location.href='<?php echo scsl_redirect_url($_GET['lch'],$_GET['ic']); ?>';
     </script>
     <?php   
     }
     exit;

}    

         

  

}



function socleverlogin_plugin_parse_request($wp) {

    global $wpdb;

    
    if(isset($_GET['lch']) && $_GET['lch']!='')
{
    setcookie('lch',$_GET['lch'],time()+100,'/');

} 
if(isset($_GET['ic']) && $_GET['ic']!='')
{
    setcookie('ic',$_GET['ic'],time()+100,'/');

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

        $resPonse=get_cslcurl($request_url);

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


add_action('wp_ajax_scslvideo', 'scsls_app_video' );
add_action('wp_ajax_nopriv_scslvideo', 'scsls_app_video' );

function scsls_app_video()
{
 echo'<iframe src="//player.vimeo.com/video/118392066?title=0&byline=0&portrait=0" width="600" height="400" frameborder="0" webkitallowfullscreen mozallowfullscreen allowfullscreen /></iframe>';
exit;

}



add_action('wp_ajax_scsfblogin', 'scsl_login_fb' );

add_action('wp_ajax_nopriv_scsfblogin', 'scsl_login_fb' );

function scsl_login_fb()

{

    

    global $wpdb;

  if(isset($_GET['lch']) && $_GET['lch']!='')
{
    setcookie('lch',$_GET['lch'],time()+100,'/');

} 
 if(isset($_GET['ic']))
{
    setcookie('ic',$_GET['ic'],time()+100,'/');

}

   $get_fb=get_cslcurl("https://www.socleversocial.com/dashboard/get_fb_data.php?siteid=".get_option('scss_site_id')."");

   

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

            . $app_id . "&redirect_uri=" . urlencode($my_url)."&scope=email,user_birthday,user_relationships,user_location,user_hometown,user_friends,user_likes&display=popup";



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

        $resPonse=get_cslcurl($request_url);

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

  if(isset($_GET['lch']) && $_GET['lch']!='')
{
    setcookie('lch',$_GET['lch'],time()+100,'/');

} 

if(isset($_POST['lch']))
    {
        $lch=$_POST['lch'];
        
    }
    else if(isset($_GET['lch']))
    {
        
        $lch=$_GET['lch'];
    }
    else
    {
        $lch="";
    }
    

if(isset($_POST['ic']))
    {
        $ic=$_POST['ic'];
        
    }
    else if(isset($_GET['ic']))
    {
        
        $ic=$_GET['ic'];
    }
    else
    {
        $ic="";
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



$creds['user_login']=$row_user[0]->user_login;

        wp_set_current_user($user_id,$creds['user_login']);
        wp_set_auth_cookie($id_use);
        do_action('wp_login', $creds['user_login']);




$notify_cs=get_cslcurl("https://www.socleversocial.com/dashboard/track_register_new.php?siteid=".get_option('scss_site_id')."&action=notifycs&is_new=".$is_new."&is_from=".$is_from."&siteUid=".$id_use."&member_id=".$member_id);

if($notify_cs)

{



    $red_url=($_COOKIE['lch']=='l' || $_COOKIE['lch']=='')?get_site_url():$_COOKIE['lch'];

    if($is_new=='1' && get_option('scsl_email_notify')=='1')

    {

    scsl_send_reg_email($creds['user_login'],$is_from);    

    

    }
    
    if($is_new=='1' && get_option('scsl_email_notify_user')=='1')
    {
    wp_new_user_notification($id_use,$pwd);    
    
    }
    
    if($is_from=='3' ||$is_from=='2' )
    {
      
        exit(scsl_redirect_url($lch,$ic));
    }
    

        
?>
<script type='text/javascript'>
window.location.href='<?php echo scsl_redirect_url($lch,$ic);  ?>';
</script>

<?php
    

    //header("location:".scsl_redirect_url()."");

    

    

  

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

			$default_fields['must_log_in'] .=scsl_get_preview('0','1');

		

	}

    



	return $default_fields;

}

add_filter ('comment_form_defaults', 'scsl_filter_comment_form_defaults');



function scsl_comment_form_login_buttons( $post_id ) {

    

	if (get_option('scsl_show_comment')=='1' && get_option('scsl_show_if_members_only')=='0' && comments_open () && !is_user_logged_in ())

	{

        echo scsl_get_preview('0','1');

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

       

        $csavatar=get_cslcurl("https://www.socleversocial.com/dashboard/get_avtars.php?site_id=".get_option('scss_site_id')."&siteUid=".$user->data->ID."");

        

			

        if ($csavatar!='') {

                

                $avatar = "<img alt='{$alt}' src='{$csavatar}' class='avatar avatar-{$size} photo' height='{$size}' width='{$size}' />";

        }

			

    }

    }

    return $avatar;

}



function scsl_redirect_url()

{

    $red_url=($_COOKIE['lch']=='l')?admin_url():$_COOKIE['lch'];    

    $redirect_to =$red_url;

		if (get_option('scsl_login_form_redirect')!='')

		{

			switch (strtolower(get_option('scsl_login_form_redirect')))

			{

				case 'current':

						if(strtolower($lch)=='l')
                        {
                            $lch=admin_url();
                        }
						$redirect_to =($lch!='')?$lch:scsl_login_get_current_url();					

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

	

	if($ic=='1')
{
    $redirect_to=$lch;
}
	
if(empty($redirect_to))
{
    $redirect_to = home_url ();
}


return rawurldecode($redirect_to);





}

function scsl_login_get_current_url ()
{
	$red_url=($_COOKIE['lch']=='l')?admin_url():$_COOKIE['lch'];
    return $red_url;
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

    $js_buttons=scsl_get_preview('0','0');   

    $display_content .=$js_buttons;

    

    echo $display_content;

    }

}







}


function get_cslcurl($url)
{
    
if(get_option('scsls_module_loaded')=='1')
{
 return file_get_contents($url);    
}
else
{        
$ch = curl_init(); 
curl_setopt($ch, CURLOPT_URL, $url); 
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, true);  
curl_setopt ($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_USERAGENT, $_SERVER['HTTP_USER_AGENT']);    
curl_setopt($ch, CURLOPT_SSLVERSION,3);
$result_response = curl_exec($ch);
$actual_return=$result_response;
curl_close($ch);
return $actual_return;
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


function getAvailablescss($strSelectedscss) {

	
	$htmlAvailableListscss = '';
	$arrSelectedscss = '';
	
	
	$arrSelectedscss = explode(',', $strSelectedscss);
	
	
	$arrAllAvailablescss = array('Facebook','Google+','LinkedIN','Twitter','Pinterest','WhatsApp','StumbleUpon','Reddit','Tumblr');
	
	// explode saved include list and add to a new array
	$arrAvailablescss = array_diff($arrAllAvailablescss, $arrSelectedscss);
	
	// check if array is not empty
	if ($arrSelectedscss != '') {
	
		// for each included button
		foreach ($arrAvailablescss as $strAvailablescss) {
		
			// add a list item for each available option
			$htmlAvailableListscss .= '<li id="' . $strAvailablescss . '">' . $strAvailablescss . '</li>';
		}
	}
	
	// return html list options
	return $htmlAvailableListscss;
}

function getSelectedscss($strSelectedscss) {
    
    

	// variables
	$htmlSelectedListscss = '';
	$arrSelectedscss = '';

	
	if ($strSelectedscss != '') {
	
		
		$arrSelectedscss = explode(',', $strSelectedscss);
		
		// check if array is not empty
		if ($arrSelectedscss != '') {
		
			
			foreach ($arrSelectedscss as $strSelectedscss) {
			
                if($strSelectedscss!='')    
				{
				$htmlSelectedListscss .= '<li id="' . $strSelectedscss . '">' . $strSelectedscss. '</li>';
                }
			}
		}
	}
	
	// return html list options
	return $htmlSelectedListscss;
}

 

if((isset($_POST['save_share_1']) && sanitize_text_field($_POST['save_share_1'])=='Save' ) || (isset($_POST['save_share_2']) && sanitize_text_field($_POST['save_share_2'])=='Save' ) || (isset($_POST['save_share_3']) && sanitize_text_field($_POST['save_share_3'])=='Save' ) )

{

    

update_option('scss_display_position',stripslashes(sanitize_text_field($_POST['scss_display_position'])));
$social_buttons=""; $orders="";

$share_button_title=array("2"=>"Facebook","4"=>"Google+","7"=>"LinkedIN","13"=>"Twitter","17"=>"Pinterest","18"=>"WhatsApp","19"=>"StumbleUpon","20"=>"Reddit","21"=>"Tumblr");

foreach($share_button_title as $key=>$val)
{
    $val=($val=='Google+')?'google_plus':$val;
    if($_POST['scss_custom_'.strtolower($val).'']!='')
    {
        
        update_option('scss_custom_'.strtolower($val).'',$_POST['scss_custom_'.strtolower($val).'']);
    }
}
$selected_buttons_new=array();
if(sanitize_text_field($_POST['scss_selected_buttons'])!='')
{
    $selected_buttons_new=explode(",",sanitize_text_field($_POST['scss_selected_buttons']));
}

//print_r($selected_buttons_new);

if(count($selected_buttons_new) > 0)
{
    foreach($selected_buttons_new as $key=>$val)
    {
        
        $social_buttons .=",".sanitize_text_field(array_search($val,$share_button_title));
    }
}

update_option('scss_selected_buttons',$social_buttons);
update_option('scss_counter_type',sanitize_text_field($_POST['counter_type']));
update_option('scss_gap',sanitize_text_field($_POST['gap']));
update_option('scss_icon_size',sanitize_text_field($_POST['icon_size']));
update_option('scss_display_style',sanitize_text_field($_POST['display_style']));
update_option('scss_button_style',sanitize_text_field($_POST['button_style']));

update_option('scss_show_homepage',sanitize_text_field($_POST['scss_show_homepage']));
        update_option('scss_show_post',sanitize_text_field($_POST['scss_show_post']));
        update_option('scss_show_page',sanitize_text_field($_POST['scss_show_page']));
        update_option('scss_show_category',sanitize_text_field($_POST['scss_show_category']));
        update_option('scss_show_excerpts',sanitize_text_field($_POST['scss_show_excerpts']));

update_option('scsss_mobile_friendly',sanitize_text_field($_POST['scsss_mobile_friendly']));
update_option('scss_share_autho','1');

update_option('scs_sharebar_enable',sanitize_text_field($_POST['enable_scsshare']));
update_option('scsss_default_img',sanitize_text_field($_POST['scsss_default_img']));
update_option('scsss_clientfb_id',sanitize_text_field($_POST['scsss_clientfb_id']));



        

$js_written=get_cslcurl('https://www.socleversocial.com/dashboard/wp_write_noauthosharejs.php?site_id='.sanitize_text_field(get_option('scss_site_id')).'&save=Save&autho_share=1');

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
update_option('scsl_email_notify_user',sanitize_text_field($_POST['scsl_email_notify_user']));


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



    update_option('customlogin_fb',sanitize_text_field($_POST['customlogin_fb']));
update_option('customlogin_gp',sanitize_text_field($_POST['customlogin_gp']));
update_option('customlogin_li',sanitize_text_field($_POST['customlogin_li']));
update_option('customlogin_tw',sanitize_text_field($_POST['customlogin_tw']));
update_option('customlogin_yh',sanitize_text_field($_POST['customlogin_yh']));
update_option('customlogin_ms',sanitize_text_field($_POST['customlogin_ms']));
update_option('customlogin_ig',sanitize_text_field($_POST['customlogin_ig']));
update_option('customlogin_pp',sanitize_text_field($_POST['customlogin_pp']));    


}   

 
function scsl_redirect(){
    $redirect_url = $_SERVER['HTTP_REFERER'];
    if(!empty($_REQUEST['redirect_to'])){
        wp_safe_redirect($_REQUEST['redirect_to']);
    } else {
        wp_redirect($redirect_url);
    }
    exit();
}
add_filter('wp_logout','scsl_redirect');



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





function scsl_get_preview($is_preview='0',$is_comment)

{

    

    $network=explode(",",get_option('scsl_network'));

    $button_size=get_option('scsl_button_size');

    $btn_style=get_option('scsl_button_style');

    $caption_text=get_option('scsl_caption');


    if(strtolower($btn_style)=='custom')
    {
      
      $fbpath=get_option('customlogin_fb');
      $gppath=get_option('customlogin_gp');
      $twpath=get_option('customlogin_tw');
      $lipath=get_option('customlogin_li');
      $yhpath=get_option('customlogin_yh');
      $mspath=get_option('customlogin_ms');
      $igpath=get_option('customlogin_ig');
      $pppath=get_option('customlogin_pp');
      
      $previewDiv='';
        $fb_div="";
        if(in_array('2',$network) && !empty($fbpath))
        {
            
            $fb_div .='<script type="text/javascript">';
            $imgdiv='<div style="display:inline-block;width: 100%; height:100%;"><img src="'.$fbpath.'" alt="Login with Facebook" title="Login with Facebook"></div>';
            $previewDiv .=$imgdiv;
            $fb_div .='csbutton.init([\''.$imgdiv.'\',\'100%\' ,\'100%\',\'login\',\'facebook\',\''.$is_comment.'\']);'.PHP_EOL;
            $fb_div .='csbutton.putCsbutton();         
                      </script>';
        
            
        }
        $gp_div="";
        if(in_array('4',$network) && !empty($gppath))
        {
            $gapi=get_cslcurl('https://www.socleversocial.com/dashboard/get_fb_data.php?action=gapi&siteid='.get_option('scs_site_id').'');
            
            $gp_div .='<script type="text/javascript">';
            $imgdiv='<div style="display:inline-block;width: 100%; height:100%;"><img src="'.$gppath.'" alt="Login with Google+" title="Login with Google+"></div>';
            $previewDiv .=$imgdiv;
            $gp_div .='csbutton.init([\''.$imgdiv.'\',\'100%\' ,\'100%\',\'login\',\''.$gapi.'\',\''.$is_comment.'\']);'.PHP_EOL;
            $gp_div .='csbutton.putCsbutton();         
                      </script>';
          
        }
        $li_div="";
        if(in_array('7',$network) && !empty($lipath))
        {
            
            $li_div .='<script type="text/javascript">';
            $imgdiv='<div style="display:inline-block;width: 100%; height:100%;"><img src="'.$lipath.'" alt="Login with LinkedIN" title="Login with LinkedIN"></div>';
            $li_div .='csbutton.init([\''.$imgdiv.'\',\'100%\' ,\'100%\',\'login\',\'li\',\''.$is_comment.'\']);'.PHP_EOL;
            $li_div .='csbutton.putCsbutton();         
                      </script>';
          
        }
        $tw_div="";
        if(in_array('13',$network) && !empty($twpath))
        {
            
            $tw_div .='<script type="text/javascript">';
            $imgdiv='<div style="display:inline-block;width: 100%; height:100%;"><img src="'.$twpath.'" alt="Login with Twitter" title="Login with Twitter"></div>';
            $previewDiv .=$imgdiv;
            $tw_div .='csbutton.init([\''.$imgdiv.'\',\'100%\' ,\'100%\',\'login\',\'twitter\',\''.$is_comment.'\']);'.PHP_EOL;
            $tw_div .='csbutton.putCsbutton();         
                      </script>';
          
        }
        $yh_div="";
        if(in_array('15',$network) && !empty($yhpath))
        {
            
            $yh_div .='<script type="text/javascript">';
            $imgdiv='<div style="display:inline-block;width: 100%; height:100%;"><img src="'.$yhpath.'" alt="Login with Yahoo!" title="Login with Yahoo!"></div>';
            $previewDiv .=$imgdiv;
            $yh_div .='csbutton.init([\''.$imgdiv.'\',\'100%\' ,\'100%\',\'login\',\'yahoo\',\''.$is_comment.'\']);'.PHP_EOL;
            $yh_div .='csbutton.putCsbutton();         
                      </script>';
          
        }
        $ms_div="";
        if(in_array('8',$network) && !empty($mspath))
        {
             
            $ms_div .='<script type="text/javascript">';
            $imgdiv='<div style="display:inline-block;width: 100%; height:100%;"><img src="'.$mspath.'" alt="Login with Microsoft" title="Login with Microsoft"></div>';
            $previewDiv .=$imgdiv;
            $ms_div .='csbutton.init([\''.$imgdiv.'\',\'100%\' ,\'100%\',\'login\',\'microsoft\',\''.$is_comment.'\']);'.PHP_EOL;
            $ms_div .='csbutton.putCsbutton();         
                      </script>';
          
        }
        $pp_div="";
        if(in_array('16',$network) && !empty($pppath))
        {
             
            $pp_div .='<script type="text/javascript">';
            $imgdiv='<div style="display:inline-block;width: 100%; height:100%;"><img src="'.$pppath.'" alt="Login with PayPal" title="Login with PayPal"></div>';
            $previewDiv .=$imgdiv;
            $pp_div .='csbutton.init([\''.$imgdiv.'\',\'100%\' ,\'100%\',\'login\',\'paypal\',\''.$is_comment.'\']);'.PHP_EOL;
            $pp_div .='csbutton.putCsbutton();         
                      </script>';
          
        }
        $ig_div="";
        if(in_array('5',$network) && !empty($igpath))
        {
            
            $ig_div .='<script type="text/javascript">';
            $imgdiv='<div style="display:inline-block;width: 100%; height:100%;"><img src="'.$igpath.'" alt="Login with Instagram" title="Login with Instagram"></div>';
            $previewDiv .=$imgdiv;
            $ig_div .='csbutton.init([\''.$imgdiv.'\',\''.$btn_width.'px\' ,\''.$button_size.'px\',\'login\',\'instagram\',\''.$is_comment.'\']);'.PHP_EOL;
            $ig_div .='csbutton.putCsbutton();         
                      </script>';
          
        }

        
        $login_plugin_start=$login_plugin_end="";
        if($is_preview=='1')
        {
            return $previewDiv;
        }
        else
        {
            
                $login_plugin_start .='<div style="clear:both;margin:10px 0px 10px 0px;">'.PHP_EOL.'<h3 style="line-height:25px;">'.$caption_text.'</h3>'.PHP_EOL;
                $login_plugin_start .='<script type="text/javascript" src="https://www.socleversocial.com/dashboard/client_share_js/csloginbuttons_'.get_option('scsl_site_id').'.js"></script>'.PHP_EOL;
                $login_plugin_end .='<br/><input type="hidden" id="scsl_is_comment" value="'.$is_comment.'"></div>';
            
                return $login_plugin_start.PHP_EOL.$fb_div.PHP_EOL.$gp_div.PHP_EOL.$li_div.PHP_EOL.$tw_div.PHP_EOL.$yh_div.PHP_EOL.$ms_div.PHP_EOL.$pp_div.PHP_EOL.$ig_div.$login_plugin_end;
        }
        }
        else
        {

    $login_buttons=get_cslcurl("https://www.socleversocial.com/dashboard/login_buttons.php?site_id=".get_option('scss_site_id')."&bsize=".$button_size."&bstyle=".$btn_style."&is_preview=".$is_preview."&caption=".base64_encode($caption_text)."&frm=l&is_comment=".$is_comment."");

    

    return $login_buttons;

    }

}







if(isset($_POST['submit_share']) && sanitize_text_field($_POST['submit_share'])=='Submit' )

{
update_option("scss_valid_domain",'0');

$res_ponse_str=file_get_contents('https://www.socleversocial.com/dashboard/wp_activate.php?site_id='.sanitize_text_field($_POST['client_id']).'&api_key='.sanitize_text_field($_POST['api_key']).'&api_secret='.sanitize_text_field($_POST['api_secret']).'&ser=6');
    if(!$res_ponse_str)
    {
        $res_ponse_str=get_cslcurl('https://www.socleversocial.com/dashboard/wp_activate.php?site_id='.sanitize_text_field($_POST['client_id']).'&api_key='.sanitize_text_field($_POST['api_key']).'&api_secret='.sanitize_text_field($_POST['api_secret']).'&ser=6');
    }
    else
    {
        update_option('scsls_module_loaded','1');
    }
   
    if(!$res_ponse_str)
    {
      echo "<h3>Please check your php.ini's setting for FSOCKOPEN or CURL</h2>";
      wp_die();  
    }
    else
    {
        if(get_option('scsls_module_loaded')=='0')
        {
        update_option('scsls_module_loaded','2');
        }
    }
   
   

    

    //$res_ponse_str=file_get_contents('https://www.socleversocial.com/dashboard/wp_activate.php?site_id='.sanitize_text_field($_POST['client_id']).'&api_key='.sanitize_text_field($_POST['api_key']).'&api_secret='.sanitize_text_field($_POST['api_secret']).'');

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

function scsshare_html_page()
{

 wp_register_style( 'scss-style', plugins_url('scss_css/scss_style.css?ver='.time().'', __FILE__) );

 wp_enqueue_style( 'scss-style' );

 

?>

 <script>
 

function show_activate_tab(tab_id)
{
    
    if(tab_id=='2')
    {
        document.getElementById("tab2li").className="active";
        document.getElementById("tab1li").className="";
        document.getElementById("tab2").style.display="inline-block";
        document.getElementById("tab1").style.display="none";
    }
    else
    {
        document.getElementById("tab1li").className="active";
        document.getElementById("tab2li").className="";
        document.getElementById("tab1").style.display="inline-block";
        document.getElementById("tab2").style.display="none";
    }
}

function show_sub_activate(tab_id)
{
    for(var i=3;i<=6;i++)
    {
        if(i!='5')
        {
        if(i==tab_id)
        {
            document.getElementById("tabli"+tab_id).className="active";
        
        document.getElementById("tab"+tab_id).style.display="inline-block";
        
        }
        else
        {
            document.getElementById("tabli"+i).className="";
            document.getElementById("tab"+i).style.display="none";
        }
        }
    }
}



 </script>
 
<header>
	<div class="main">
    	<div class="logo">
        	<a href="https://www.socleversocial.com/"><img src="<?php echo plugins_url( 'scss_css/logo.png', __FILE__ ); ?>" alt="SoClever Social" /></a>
        </div>
    </div>
</header>
<section>
	<div class="main">
 <div class="sect-left">
 	<nav>
<?php if(get_option('scss_valid_domain')=='0') { ?>
            	<ul>
                	<li class="active" id="tab1li"><a onclick="show_activate_tab('1');" href="javascript:void(0);">Your SoClever API Setting</a></li>
                    <li id="tab2li"><a href="javascript:void(0);"  onclick="show_activate_tab('2');">SoClever Social Login & Sharing Setting</a></li>
                </ul>
<?php } else { ?>
     	<ul>
                	
                    <li class="active" style="width: 100%;background-repeat: repeat;"><a>SoClever Social Login & Sharing Setting</a></li>
                </ul>
<?php } ?>
                
            </nav>




<?php

if(get_option('scss_valid_domain')=='1')
{

$selected_buttons=explode(",",get_option('scss_selected_buttons'));
$selectedButtons='';
    
$all_social_buttons=array("2","4","7","13","17","18","19","20");    
if(is_array($selected_buttons) && get_option('scss_selected_buttons')!='')
{
  $share_button=array_unique(array_merge($selected_buttons,$all_social_buttons), SORT_REGULAR);
    



}
else
{
    $share_button=array("2","4","7","13","17","18","19","20");
}
$share_button_title=array("2"=>"Facebook","4"=>"Google+","7"=>"LinkedIN","13"=>"Twitter","17"=>"Pinterest","18"=>"WhatsApp","19"=>"StumbleUpon","20"=>"Reddit","21"=>"Tumblr");
foreach($selected_buttons as $selected)
{
    $selectedButtons .=$share_button_title[$selected].",";
}
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

<?php
// jQuery
wp_enqueue_script('jquery');
wp_enqueue_media();
?>

<script type="text/javascript">

jQuery(document).ready(function() {

	//------- INCLUDE LIST ----------//

	// add drag and sort functions to include table
	jQuery(function() {
		jQuery( "#scsssort1, #scsssort2" ).sortable({
			connectWith: ".connectedSortable"
		}).disableSelection();
	  });
	 
	// extract and add include list to hidden field
	jQuery('#scss_selected_buttons').val(jQuery('#scsssort2 li').map(function() {
	// For each <li> in the list, return its inner text and let .map()
	//  build an array of those values.
	return jQuery(this).attr('id');
	}).get());
	  
	// after a change, extract and add include list to hidden field
	jQuery('.scss-include-list').mouseout(function() {
		jQuery('#scss_selected_buttons').val(jQuery('#scsssort2 li').map(function() {
		// For each <li> in the list, return its inner text and let .map()
		//  build an array of those values.
		return jQuery(this).attr('id');
		}).get());
	});
	  
    
    jQuery('.customUpload').click(function(e) {
        var strInputID = jQuery(this).data('scss-input');
        e.preventDefault();
        var image = wp.media({ 
            title: 'Upload Image',            
            multiple: false
        }).open()
        .on('select', function(e){
            
            var uploaded_image = image.state().get('selection').first();
            var image_url = uploaded_image.toJSON().url;            
            jQuery('#' + strInputID).val(image_url);
        });
    });

});

function show_custom_images()
{
    if(document.authosharefrm.button_style.value=='custom')
    {
        document.getElementById("scss-custom-images").style.display="inline-block";
    }
    else
    {
        document.getElementById("scss-custom-images").style.display="none";
    }
}
</script>

    	
<div style="clear: both;">&nbsp;&nbsp;</div>
<nav>
<ul>
                	<li id="tabli3" class="active" style="width:30%;"><a href="javascript:void(0);" onclick="show_sub_activate('3');">Share Bar Settings</a></li>
                    <li id="tabli4"  style="width:30%;"><a href="javascript:void(0);" onclick="show_sub_activate('4');">Share Bar Appearance</a></li>
                    <!--li  id="tabli5" style="width:20%;"><a href="javascript:void(0);" onclick="show_sub_activate('5');">Share Counter</a></li-->
                    <li  id="tabli6" style="width:40%;"><a href="javascript:void(0);" onclick="show_sub_activate('6');">Social Login Setting</a></li>                    
                </ul>
</nav>                


<div id="tab2">
<form class="login-form mt-lg" action="" method="post" name="authosharefrm" enctype="multipart/form-data">

<div class="box1" style="margin-top:-10px;">

     <div id="tab3">

	  

      <table class="table" style="margin:20px;font-size:1em;">
      <tr>
      <td>
       <div class="main-bx1" style="float: none;">
               	<p><strong>Enable Share Bar</strong></p>
                
                <div class="lbls radio-danger">
               		 <input type="radio" name="enable_scsshare"  id="enable_scsshare_1" value="1"<?php if(get_option('scs_sharebar_enable')=='1') { echo ' checked="checked"'; };?> />
            	<label for="enable_scsshare_1" class="css-label radGroup2">Yes</label>
                </div>
                
                <div class="lbls radio-danger">
               		 <input type="radio" name="enable_scsshare"  id="enable_scsshare_2" value="0"<?php if(get_option('scs_sharebar_enable')=='0') { echo ' checked="checked"'; };?> />
            	<label for="enable_scsshare_2" class="css-label radGroup2">No</label>
                </div>
                

                
      
      </td>
      </tr>
	  <tr>
      <td>
      <div class="main-bx1">
               	<label><strong>Select Networks</strong></label>
                </div>
      </td>
      </tr>
                                <tr>
                                    <td style="border: medium none;">
                                        
 <?php 
                                        
                                        
                        				$htmlShareButtonsForm .= '<table class="form-table">';
                        					$htmlShareButtonsForm .= '<tr valign="top">';                        						
                        						$htmlShareButtonsForm .= '<td class="scss-include-list available">';
                        							$htmlShareButtonsForm .= '<span class="include-heading">Available</span>';
                        							$htmlShareButtonsForm .= '<center><ul id="scsssort1" class="connectedSortable">';
                        							 $htmlShareButtonsForm .= getAvailablescss($selectedButtons);
                        							$htmlShareButtonsForm .= '</ul></center>';
                        						$htmlShareButtonsForm .= '</td>';
                        						$htmlShareButtonsForm .= '<td class="scss-include-list chosen">';
                        							$htmlShareButtonsForm .= '<span class="include-heading">Selected</span>';
                        							$htmlShareButtonsForm .= '<center><ul id="scsssort2" class="connectedSortable">';
                        							$htmlShareButtonsForm .= getSelectedscss($selectedButtons);
                        							$htmlShareButtonsForm .= '</ul></center>';
                        						$htmlShareButtonsForm .= '</td>';
                        					$htmlShareButtonsForm .= '</tr>';
                        				    $htmlShareButtonsForm .= '</table>';
                                            $htmlShareButtonsForm .= '</div>';
                                            $htmlShareButtonsForm .= '<input type="hidden" name="scss_selected_buttons" id="scss_selected_buttons" value="'.$selectedButtons.'" />';
                                            echo $htmlShareButtonsForm;
                                         ?>
                                       
                                        
                                    </td>
                                </tr>


                                
                                <tr>
                    <th align="left">Show share bar on following pages</th>
                    </tr>
                    <tr>                    
                    <td>
                    <input type="checkbox" name="scss_show_homepage" value="1" <?php echo (get_option('scss_show_homepage')=='1')?'checked':''; ?> /><b>Home Page</b><br/>
                    <input type="checkbox" name="scss_show_post" value="1" <?php echo (get_option('scss_show_post')=='1')?'checked':''; ?> /><b>Posts</b><br/>
                    <input type="checkbox" name="scss_show_page" value="1" <?php echo (get_option('scss_show_page')=='1')?'checked':''; ?> /><b>Pages</b><br/>
                    <input type="checkbox" name="scss_show_category" value="1" <?php echo (get_option('scss_show_category')=='1')?'checked':''; ?>  /><b>Categories/Archives</b><br/>
                    <input type="checkbox" name="scss_show_excerpts" value="1" <?php echo (get_option('scss_show_excerpts')=='1')?'checked':''; ?> /><b>Excerpts</b><br/>
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
                    <th align="left">Mobile Friendly</th>
                    </tr>
                    <tr>                    
                    <td>
                    <div class="lbls radio-danger">
               		 <input type="radio" name="scsss_mobile_friendly"  id="scsss_mobile_friendly_1" value="1"<?php if(get_option('scsss_mobile_friendly')=='1') { echo ' checked="checked"'; };?> />
            	<label for="scsss_mobile_friendly_1" class="css-label radGroup2">Yes</label>
                </div>
                
                <div class="lbls radio-danger">
               		 <input type="radio" name="scsss_mobile_friendly"  id="scsss_mobile_friendly_2" value="0"<?php if(get_option('scsss_mobile_friendly')=='0') { echo ' checked="checked"'; };?> />
            	<label for="scsss_mobile_friendly_2" class="css-label radGroup2">No</label>
                </div>
                
                    </td>
                    </tr> 
                    
                        <tr>
                    <th align="left">Your Facebook App ID</th>
                    </tr>
                    <tr>                    
                    <td>
                         <div class="main-bx1" style="padding:5px 0px 10px 0px;">
                        <input type="text" placeholder="your fb app id" name="scsss_clientfb_id" value="<?php echo get_option('scsss_clientfb_id'); ?>" class="input-txt" style="width: 150%;">
                        </div>
                      </td>
                    </tr>       
                    <tr>
                    <th align="left">Default sharing image</th>
                    </tr>
                    <tr>                    
                    <td>
                        <div class="main-bx1" style="padding:5px 0px 10px 0px;">
                        <input type="text" placeholder="e.g your logo url" name="scsss_default_img" value="<?php echo get_option('scsss_default_img'); ?>" class="input-txt" style="width: 150%;">
                        </div>
                      </td>
                    </tr>
                    
                    
                    <tr>
                    <th align="left">
                    Counter Display
                    </th>
                    </tr>
                    <tr>
                    <td>
                    
                    <div class="main-bx1" style="float:left;padding:0 !important;">
               	
                
                <div class="lbls radio-danger">
               		 <input type="radio" name="counter_type"  id="counter_type_1"  value="0"<?php if($counter_type=='0') { echo ' checked="checked"'; };?> />
            	<label for="counter_type_1" class="css-label radGroup2">Horizontal</label>
                </div>
                
                <div class="lbls radio-danger">
               		 <input type="radio" name="counter_type"  id="counter_type_2"  value="1"<?php if($counter_type=='1') { echo ' checked="checked"'; };?> />
            	<label for="counter_type_2" class="css-label radGroup2">Vertical</label>
                </div>
                 <div class="lbls radio-danger">
               		 <input type="radio" name="counter_type"  id="counter_type_3"  value="2"<?php if($counter_type=='2') { echo ' checked="checked"'; };?> />
            	<label for="counter_type_3" class="css-label radGroup2">No Counter</label>
               </div>
        
      
      </div>
                    </td>
                    
                    </tr>
                    <tr>
                    <th align="left">
                    <strong>Short Code : [Soclever_Share_Buttons]</strong>
                    </th>
                    </tr>
                    <tr>     
                    <tr>
                                    <td>
                                        <div class="btn">
            <input type="submit" id="button" name="save_share_1"  value="Save"  />
               	  
                </div>
                                    </td>
                     </tr>
                     
        </table>                        

     </div>





     <div id="tab4" style="display: none;">

	  

<?php
      $button_style_arr=array(" Rounded Color","Transparent Grey","Rounded Black","Flower","Glossy","Leaf","Polygon","Rectangular","Rounded Corners","Waterdrop");
?>
       <div class="main-bx1" style="float: none;">
               	<p><strong>Social Share Bar Style</strong></p>
                <?php foreach($button_style_arr as $key=>$val) { ?>
                <div class="lbls radio-danger">
               		 <input type="radio" name="button_style"  id="button_style_<?php echo intval($key+3); ?>" onclick="show_custom_images()" value="<?php echo intval($key+2); ?>"<?php if($button_style==intval($key+2)) { echo ' checked="checked"'; };?> />
            	<label for="button_style_<?php echo intval($key+3); ?>" class="css-label radGroup2"><?php echo $val; ?></label>
                </div>
                <?php } ?>
                <div class="lbls radio-danger">
               		 <input type="radio" name="button_style"  id="scss_image_set" onclick="show_custom_images()" value="custom"<?php if($button_style=="custom") { echo ' checked="checked"'; };?> />
            	<label for="scss_image_set" class="css-label radGroup2">Custom Images</label>
                </div>
                 </div>
              
              
	  <div class="main-bx1" style="float: none;">
      <?php
      
      $htmlShareButtonsForm="";
      $htmlShareButtonsForm .= '<div id="scss-custom-images" ' . ($button_style=='custom'?'style="display: inline-block;"':'style="display:none;"').'>';				
				$htmlShareButtonsForm .= '<table class="form-table">';
                foreach($share_button_title as $key=>$val)
                {
                    $val=($val=='Google+')?'google_plus':$val;
                    $htmlShareButtonsForm .= '<tr valign="top">';
						$htmlShareButtonsForm .= '<th scope="row" style="width: 120px;"><label>'.$val.':</label></th>';
						$htmlShareButtonsForm .= '<td>';
						$htmlShareButtonsForm .= '<input id="scss_custom_'.strtolower($val).'" type="text" size="50" name="scss_custom_'.strtolower($val).'" value="'.get_option('scss_custom_'.strtolower($val).'').'" />';
						$htmlShareButtonsForm .= '<input id="upload_'.strtolower($val).'_button" data-scss-input="scss_custom_'.strtolower($val).'" class="button customUpload" type="button" value="Upload Image" />';
						$htmlShareButtonsForm .= '</td>';
					$htmlShareButtonsForm .= '</tr>';
                }
					
				$htmlShareButtonsForm .= '</table>';
				$htmlShareButtonsForm .= '</div>';
                echo $htmlShareButtonsForm;
                ?>
      </div>
      
     <div class="main-bx1" style="float: none;">
               	<p><strong>Social Sharing Button Size</strong></p>
       <?php $button_size_arr=array("30x30","32x32","40x40","50x50","60x60","70x70","85x85","100x100");
       
       foreach($button_size_arr as $key=>$val)
       {
       
        ?>   
        
        <div class="lbls radio-danger">
               		 <input type="radio" name="icon_size"  id="icon_size_<?php echo intval($key+1); ?>" value="<?php echo $val; ?>"<?php if($icon_size==$val) { echo ' checked="checked"'; };?> />
            	<label for="icon_size_<?php echo intval($key+1); ?>" class="css-label radGroup2"><?php echo $val; ?></label>
                </div>
                
       
        <?php } ?>   

       </div>
       
       <div class="main-bx1" style="float: none;">
               	<p><strong>Social Sharing Display Style</strong></p>
                
                <div class="lbls radio-danger">
               		 <input type="radio" name="display_style"  id="display_style_1"  value="0"<?php if($display_style=='0') { echo ' checked="checked"'; };?> />
            	<label for="display_style_1" class="css-label radGroup2">Horizontal</label>
                </div>
                
                <div class="lbls radio-danger">
               		 <input type="radio" name="display_style"  id="display_style_2"  value="1"<?php if($display_style=='1') { echo ' checked="checked"'; };?> />
            	<label for="display_style_2" class="css-label radGroup2">Vertical (Left)</label>
                </div>
                 <div class="lbls radio-danger">
               		 <input type="radio" name="display_style"  id="display_style_3"  value="2"<?php if($display_style=='2') { echo ' checked="checked"'; };?> />
            	<label for="display_style_3" class="css-label radGroup2">Vertical (Right)</label>
               </div>
        
      
      </div>
       
       
        <div class="main-bx1" style="float: none;">
               	<p><strong>Padding Gap</strong></p>
                
                <select name="gap" id="gap" >
                                    <?php for($i=0;$i<=20;$i++) { ?>
                                    <option value="<?php echo $i; ?>" <?php echo ($i==$gap)?"selected":"";?> ><?php echo $i; ?></option>
                                    <?php } ?>
                                    </select>px
                                    
                
       </div>
       
       
                                  
                                    <div class="btn">
            <input type="submit" id="button" name="save_share_2"  value="Save"  />
               	  
                </div>
       <div style="clear: both;">&nbsp;&nbsp;</div>
       
           

     </div>

        


     <div id="tab6" style="display: none;">
<div class="box1" style="border: none;" >
            	<h2 class="bov-title">
                	General Setting
                </h2>
              <div class="main-bx1">
               	<p><strong>Enter Caption text to be shown on top of social login box</strong></p>
                <?php
									$scsl_caption =(get_option('scsl_caption')) ? get_option('scsl_caption') : 'Login with:';
								?>
                <input class="input-txt" type="text" name="scsl_caption" value="<?php echo $scsl_caption; ?>">
                </div>
                
                <div class="main-bx1">
               	<p><strong>Social Login button style</strong></p>
                <div class="lbls radio-danger">
               		 <input type="radio" name="scsl_button_style" id="radio3" value="ic" onclick="show_cscustom_div('none');"  <?php echo (get_option('scsl_button_style') == 'ic' ? 'checked="checked"' : ''); ?> />
            	<label for="radio3" class="css-label radGroup2">Square Icons</label>
                </div>
                <div class="lbls radio-danger">
               		 <input type="radio" name="scsl_button_style" id="radio4" value="fc" onclick="show_cscustom_div('none');"  <?php echo (get_option('scsl_button_style') == 'fc' ? 'checked="checked"' : ''); ?>  />
            	<label for="radio4" class="css-label radGroup2">Colored Logos</label>
                </div>
                <div class="lbls radio-danger">
               		 <input type="radio" name="scsl_button_style" id="radio5" value="fg" onclick="show_cscustom_div('none');"  <?php echo (get_option('scsl_button_style') == 'fg' ? 'checked="checked"' : ''); ?>  />
            	<label for="radio5" class="css-label radGroup2">Grey Logos</label>
                </div>
                <div class="lbls radio-danger">
               		 <input type="radio" name="scsl_button_style" id="radio6" onclick="show_cscustom_div('inline-block');" value="custom" <?php echo (get_option('scsl_button_style') == 'custom' ? 'checked="checked"' : ''); ?>  />
            	<label for="radio6" class="css-label radGroup2">Custom</label>
                <script type="text/javascript">
                if(typeof show_cscustom_div !='function')
                {
                function show_cscustom_div(show_custom)
                {
                    
                    document.getElementById('custom_styles').style.display=show_custom;                
                    
                  }
                
                }
                </script>
                </div>
                <div id="custom_styles" style="<?php echo (get_option('scsl_button_style')!='custom')?'display:none;':'';  ?>" >
                
                <?php 
                $loginProviderArray=array("fb"=>"Facebook","gp"=>"Google+","tw"=>"Twitter","li"=>"LinkedIN","yh"=>"Yahoo!","ms"=>"Microsoft","pp"=>"PayPal","ig"=>"Instagram");
                foreach($loginProviderArray as $key=>$val)
                {
                ?>
                
                <div class="main-bx1" id="<?php echo $key; ?>custom">
                <p><?php echo $val; ?></p>
                <input class="input-txt" type="text" name="customlogin_<?php echo $key; ?>" value="<?php echo get_option('customlogin_'.$key.''); ?>">
                </div>
                
                <?php    
                    
                }
                
                ?>                
                
                </div>
              </div>
              
              <div class="main-bx1">
               	<p><strong>Social Login button size</strong></p>
                <div class="lbls radio-danger">
               		 <input type="radio" name="scsl_button_size" id="radio6" value="30" <?php echo (get_option('scsl_button_size') == '30' ? 'checked="checked"' : ''); ?> />
            	<label for="radio6" class="css-label radGroup2">30px</label>
                </div>
                <div class="lbls radio-danger">
               		 <input type="radio" name="scsl_button_size" id="radio7" value="40" <?php echo (get_option('scsl_button_size') == '40' ? 'checked="checked"' : ''); ?>  />
            	<label for="radio7" class="css-label radGroup2">40px</label>
                </div>
                <div class="lbls radio-danger">
               		 <input type="radio" name="scsl_button_size" id="radio8" value="50" <?php echo (get_option('scsl_button_size') == '50' ? 'checked="checked"' : ''); ?>  />
            	<label for="radio8" class="css-label radGroup2">50px</label>
                </div>
                  <div class="lbls radio-danger">
               		 <input type="radio" name="scsl_button_size" id="radio9" value="60" <?php echo (get_option('scsl_button_size') == '60' ? 'checked="checked"' : ''); ?>  />
            	<label for="radio9" class="css-label radGroup2">60px</label>
                </div>
                <div class="lbls radio-danger">
               		 <input type="radio" name="scsl_button_size" id="radio10" value="65" <?php echo (get_option('scsl_button_size') == '65' ? 'checked="checked"' : ''); ?>  />
            	<label for="radio10" class="css-label radGroup2">65px</label>
                </div>
              </div>  
              
              <div class="main-bx1">
               	<p><strong>Email when new user registers with social network?</strong></p>
                <div class="lbls radio-danger">
               		 <input type="radio" name="scsl_email_notify" id="radio11" value="1" <?php echo (get_option('scsl_email_notify') == '1' ? 'checked="checked"' : ''); ?> />
            	<label for="radio11" class="css-label radGroup2">Yes</label>
                </div>
                <div class="lbls radio-danger">
               		 <input type="radio" name="scsl_email_notify" id="radio12" value="0" <?php echo (get_option('scsl_email_notify') == '0' ? 'checked="checked"' : ''); ?>  />
            	<label for="radio12" class="css-label no radGroup2">No</label>
                </div>
                
              </div>
              
              <div class="main-bx1">
               	<p><strong>Send email to user on registration with social network?</strong></p>
                <div class="lbls radio-danger">
               		 <input type="radio" name="scsl_email_notify_user" id="radio13" value="1" <?php echo (get_option('scsl_email_notify_user') == '1' ? 'checked="checked"' : ''); ?> />
            	<label for="radio11" class="css-label radGroup2">Yes</label>
                </div>
                <div class="lbls radio-danger">
               		 <input type="radio" name="scsl_email_notify_user" id="radio14" value="0" <?php echo (get_option('scsl_email_notify_user') == '0' ? 'checked="checked"' : ''); ?>  />
            	<label for="radio14" class="css-label no radGroup2">No</label>
                </div>
                
              </div>
              
              
              
              <div class="main-bx1">
               	<p><strong>Use user's social network avtar as your site's default avtar?</strong></p>
                <div class="lbls radio-danger">
               		 <input type="radio" name="scsl_use_avtar" id="radio15" value="0" <?php echo (get_option('scsl_use_avtar') == '0' ? 'checked="checked"' : ''); ?> />
            	<label for="radio15" class="css-label radGroup2">No</label>
                </div>
                <div class="lbls radio-danger">
               		 <input type="radio" name="scsl_use_avtar" id="radio16" value="1" <?php echo (get_option('scsl_use_avtar') == '1' ? 'checked="checked"' : ''); ?> />
            	<label for="radio16" class="css-label no radGroup2">Yes, if user's social network has avtar</label>
                </div>
                
              </div>
            </div>
            
            <div class="box1" style="border: none;">
            	<h2 class="bov-title">
                	Comment Setting
                </h2>
                
              <div class="main-bx1">
               	<p><strong>Display Social login box on comment area?</strong></p>
                <div class="lbls radio-danger">
               		 <input type="radio" name="scsl_show_comment" id="radio18" value="1" <?php echo (get_option('scsl_show_comment') == '1' ? 'checked="checked"' : ''); ?> />
            	<label for="radio18" class="css-label radGroup2">Yes</label>
                </div>
                <div class="lbls radio-danger">
               		 <input type="radio" name="scsl_show_comment" id="radio19" value="0" <?php echo (get_option('scsl_show_comment') == '0' ? 'checked="checked"' : ''); ?> />
            	<label for="radio19" class="css-label no radGroup2">No</label>
                </div>
                
              </div>
              
              <div class="main-bx1">
               	<p><strong>Show the Social Login buttons in the comment area if comments are disabled for guests?</strong></p>
                <p>The buttons will be displayed below the "You must be logged in to leave a comment" notice.
                </p>
                <div class="lbls radio-danger">
               		 <input type="radio" name="scsl_show_if_members_only" id="radio20" value="1" <?php echo (get_option('scsl_show_if_members_only') == 1 ? 'checked="checked"' : ''); ?> />
            	<label for="radio20" class="css-label radGroup2">Yes</label>
                </div>
                <div class="lbls radio-danger">
               		 <input type="radio" name="scsl_show_if_members_only" id="radio21" value="0" <?php echo (get_option('scsl_show_if_members_only') == 0 ? 'checked="checked"' : ''); ?> />
            	<label for="radio21" class="css-label no radGroup2">No</label>
                </div>
                
              </div>
              
              <div class="main-bx1">
               	<p><strong>Approve comments automatically for users who login with Social network?</strong></p>
                <div class="lbls radio-danger">
               		 <input type="radio" name="scsl_comment_auto_approve" id="radio22" value="1" <?php echo (get_option('scsl_comment_auto_approve') == '1' ? 'checked="checked"' : ''); ?> />
            	<label for="radio22" class="css-label radGroup2">Yes</label>
                </div>
                <div class="lbls radio-danger">
               		 <input type="radio" name="scsl_comment_auto_approve" id="radio23" value="1" <?php echo (get_option('scsl_comment_auto_approve') == '0' ? 'checked="checked"' : ''); ?> />
            	<label for="radio23" class="css-label no radGroup2">No</label>
                </div>
                
              </div>
           	</div>
            
            <div class="box1" style="border: none;">
            	<h2 class="bov-title">
                	Login Setting
                </h2>
                
              <div class="main-bx1">
               	<p><strong>Display login buttons in login form?</strong></p>
                <div class="lbls radio-danger">
               		 <input type="radio" name="scsl_show_in_loginform" id="radio24" value="1" <?php echo (get_option('scsl_show_in_loginform') == '1' ? 'checked="checked"' : ''); ?>  />
            	<label for="radio24" class="css-label radGroup2">Yes</label>
                </div>
                <div class="lbls radio-danger">
               		 <input type="radio" name="scsl_show_in_loginform" value="0" id="radio25" <?php echo (get_option('scsl_show_in_loginform') == '0' ? 'checked="checked"' : ''); ?>  />
            	<label for="radio25" class="css-label no radGroup2">No</label>
                </div>
                
              </div>
              
              <div class="main-bx1">
               	<p><strong>Choose landing page after login</strong></p>
                <div class="lbls radio-danger">
               		 <input type="radio" name="scsl_login_form_redirect" value="current" id="radio26" <?php echo (get_option('scsl_login_form_redirect') == 'current' ? 'checked="checked"' : ''); ?>  />
            	<label for="radio26" class="css-label radGroup2">Current page</label>
                </div>
                <div class="lbls radio-danger">
               		 <input type="radio" name="scsl_login_form_redirect" value="homepage" id="radio27" <?php echo (get_option('scsl_login_form_redirect') == 'homepage' ? 'checked="checked"' : ''); ?>  />
            	<label for="radio27" class="css-label no radGroup2">Home page</label>
                </div>
                 <div class="lbls radio-danger">
               		 <input type="radio" name="scsl_login_form_redirect" value="dashboard" id="radio28" <?php echo (get_option('scsl_login_form_redirect') == 'dashboard' ? 'checked="checked"' : ''); ?>  />
            	<label for="radio28" class="css-label radGroup2">Dashboard</label>
                </div>
                <div class="lbls radio-danger">
               		 <input type="radio" name="scsl_login_form_redirect" value="custom" id="radio29" <?php echo (get_option('scsl_login_form_redirect') == 'custom' ? 'checked="checked"' : ''); ?>  />
            	<label for="radio29" class="css-label no radGroup2">Following URL:</label>
              <div class="input-txt1">
                	<input class="input-txt" type="text" name="scsl_login_form_redirect_url" value="<?php echo htmlspecialchars (get_option('scsl_login_form_redirect_url')); ?>">
                </div>
                </div>
                </div>
                
              </div>
           	
            <div class="bt-txt">
               	  <p class="italic"><span class="bold">Social Networks</span> (Please select Social Networks at your<span class="sky"> SoClever dashboard)</span></p>
                    <!--p class="red">Please provide valid Soclever API setting.</p-->
                    
                    <?php 
                    $savedSetting='0';
                    if(get_option('scss_valid_domain')=='0')
                    {
                        echo'<p calss="red">Please provide valid Soclever API setting.</p>';
                    }
                    else
                    {
                     $savedSetting=get_cslcurl("https://www.socleversocial.com/dashboard/wp_login_setting.php?site_id=".get_option('scss_site_id')."&action=preview&button_style=".get_option('scsl_button_style')."&button_size=".get_option('scsl_button_size')."");
                    if($savedSetting=='0')
                    {
                        echo'<p calss="red">No provider selected on SoCleverSocial Dashboard</font>';
                    }
                    else
                    {
                        echo $savedSetting;
                    }
                    }
                     ?>
                     
                </div>
                
                <?php if($savedSetting!='0' && get_option('scss_valid_domain')=='1')
                    {
                     ?>    
                   
            <div class="btn">
            <input type="submit" id="button" name="save_login"  value="Save"  />
               	  
                </div>
                <?php } ?>
            <div style="clear: both;">&nbsp;</div>
      

                             

                        

                    

                        

                        

     </div>

    

</div>

</form>
</div>

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

<div id="tab1">    
    <div class="box1 blue_bg api_step">
    	<h2 class="bov-title">
        	Step 1 - Create a SocleverSocial.com account
        </h2>              
      <div class="main-bx1">
       	<p>To get started, register your <span>Soclever Social account</span> and find your <span>API key</span> in the site settings. If you already have an account please log in.</p>
        <p><a href="https://www.socleversocial.com/register/?wpd=<?php echo base64_encode(get_site_url()); ?>" target="_blank" class="butn green">Get your FREE API Key</a>
        <a href="https://www.socleversocial.com/dashboard/" target="_blank" class="butn blue">Login</a></p>
        
      </div>
    </div>
    <div class="box1 blue_bg api_step">
	<h2 class="bov-title">
    	Step 2 - Enter your API Settings
    </h2>
  
<form method="post" action="">
    <?php wp_nonce_field('update-options'); ?>
    <div class="main-bx1">
        <label>Client ID</label>
        <input type="text" name="client_id" id="client_id" class="input-txt"/>
    </div>
    <div class="main-bx1">
       	<label>API Key</label>
        <input type="text" name="api_key" id="api_key"  class="input-txt"/>
    </div>
    <div class="main-bx1">
       	<label>API Secret</label>
        <input type="text" name="api_secret" id="api_secret"  class="input-txt"/>
    </div>
    <div class="main-bx1">
       	<label>Valid Domain</label>
        <input type="text" name="scss_domain" id="scss_domain" class="input-txt"/>
    </div>
    <div class="main-bx1">
      <label>&nbsp;</label>
      <input type="submit" name="submit_share" class="butn blue" id="submit_share"  value="Submit"/>
    </div>
</form>
</div>

</div>
        
        

<?php    

}

 ?>
 <div class="box1 blue_bg">
            	<h2 class="bov-title">
                	Configuration
                </h2>
                <div class="main-bx1">
                	<p>1. <a class="sky" href="https://www.socleversocial.com/dashboard/" target="_blank" >Login</a> to your SoClever account. Or <a class="sky" href="https://www.socleversocial.com/register/?wpd=<?php echo base64_encode(get_site_url()); ?>" target="_blank" >Register</a> for free account to generate API Keys.</p>
                    <p>2. Get your API key, API secret and site ID from Site Settings page.</p>
                    <p>3. Configure your API details on API settings tab on your Wordpress Admin Panel.</p>
                    <p>4. To be able to enable Social Login for your site, please create Social Apps on social networks. For more information on how to create Apps for your website please visit our help section on Social Network Set Up.</p>
                    <p>5. Please configure your Social Apps API details on SoClever Authorization page.</p>
                    <p>6. Once you configure Authorization Page, social network buttons will be unlocked to use at Login Settings Page. Please select social networks you want to use for social login and save settings.</p>
                    <p>7. Refresh your admin panel to configure button size, padding gap and buttons style.</p>
                    <p>8. Feel free to contact us for any assistance you may require.</p>
                </div>
                
           	</div>
</div>

<div class="sect-right">
        	<div class="orange">
            	<h2 class="sub-tit"><span>Support & FAQ</span></h2>
                <div class="org-sub">
                <a style="display:block;margin-left:10px;" href="http://developers.socleversocial.com/wordpress-social-sharing-buttons-instructions/" target="_blank">

							Plug in Configuration and Troubleshooting</a>

						<a style="display:block;margin-left:10px;" href="http://developers.socleversocial.com/how-to-get-api-key-and-secret/" target="_blank">

							How to get Soclever API key and secret?</a>

						<a style="display:block;margin-left:10px;" href="http://developers.socleversocial.com/" target="_blank">

							Social Network Apps Set Up</a>

						<a style="display:block;margin-left:10px;" href="https://www.socleversocial.com/about-us/" target="_blank">

							About Soclever</a>
                </div>
            </div>
            
            <div class="r-video">
            	<p><strong>How to Create Facebook App for Website</strong></p>
                <?php add_thickbox(); ?>
                <a href="<?php echo admin_url('admin-ajax.php')."?action=scslvideo"; ?>?TB_iframe=true&width=600&height=400" class="thickbox">
                  <img src="<?php echo plugins_url('scss_css/video.png', __FILE__); ?>" alt="How to Create Facebook App for Website"/>       
                </a>
            
            </div>
            
            <div class="reviews">
            	<h2><img src="<?php echo plugins_url( 'scss_css/review_heading_icon.png', __FILE__ ); ?>" alt="" /> We Love Reviews</h2>
                <div class="review_con">
                	<p><img src="<?php echo plugins_url( 'scss_css/review_star_img.png', __FILE__ ); ?>" alt=""/></p>
                    <p>Please click here to leave a review. </p>
                    <p><a href="https://wordpress.org/support/view/plugin-reviews/social-login-sharing-buttons-with-analytics-by-soclever" target="_blank">Rate Us</a></p>
                </div>
            </div>
			
        </div>

</div>
</section>

<?php } ?>