<?php
function scsss_display($content)
{
      
  	            $sscc_share_content_position=get_option('scss_display_position');
       		
				$content_new = "";
                
                
                //$js_code=file_get_contents('https://www.socleversocial.com/dashboard/wp_js.php?site_id='.esc_sql(get_option('scss_site_id')).'&api_key='.esc_sql(get_option('scss_api_key')).'&api_secret='.esc_sql(get_option('scss_api_secret')).'');
                
               
    $fileContent="";
      $iwidth=explode("x",get_option('scss_icon_size'));
      $button_style=get_option('scss_button_style');
      $display_style=get_option('scss_display_style');
      $gap=get_option('scss_gap');
      $counter_type=get_option('scss_counter_type');
      $share_button=explode(",",get_option('scss_selected_buttons'));
      
      $js_code ='<script type="text/javascript" src="https://www.socleversocial.com/dashboard/client_share_js/client_'.get_option('scss_site_id').'_share_noautho.js?v='.time().'"></script>'.PHP_EOL.
'<script>'.PHP_EOL.
    'csauthosharebarjs.init([\''.get_option('scss_api_key').'\', \''.get_option('scss_site_id').'\',\''.get_option('scss_api_secret').'\',\''.get_option('scss_domain').'\']);'.PHP_EOL.
    'csauthosharebarjs.validateCsApi();'.PHP_EOL.
    '</script>'.PHP_EOL;
      
      
    if(get_option('scss_share_autho')=='1')
    {
     
     $cspageURL = 'http';
     if($_SERVER["HTTPS"] == "on") {$pageURL .= "s";}
         $cspageURL .= "://";
         if ($_SERVER["SERVER_PORT"] != "80") {
         $cspageURL .= $_SERVER["SERVER_NAME"].":".$_SERVER["SERVER_PORT"].$_SERVER["REQUEST_URI"];
         } else {
         $cspageURL .= $_SERVER["SERVER_NAME"].$_SERVER["REQUEST_URI"];
          }
          
      $cspageTitle=get_the_title();        
      
      
     $show_shere_buttons=file_get_contents("https://www.socleversocial.com/dashboard/wp_share_buttons.php?w=".get_option('scss_icon_size')."&bs=".$button_style."&ds=".$display_style."&gap=".$gap."&ct=".$counter_type."&sb=".get_option('scss_selected_buttons')."&site_id=".get_option('scss_site_id')."&url=".base64_encode($cspageURL)."&title=".base64_encode($cspageTitle)."&siteUid=".get_current_user_id());
     $js_code .=    PHP_EOL;
     if($show_shere_buttons!='')
     {
        $js_code .=$show_shere_buttons;
        if($sscc_share_content_position=='top')
					{
						$content_new .=$js_code;
						$content_new .=$content;
					}
				elseif($sscc_share_content_position=='bottom')
					{	
						$content_new .=$content;
						$content_new .=$js_code;
						
					}
			         elseif($sscc_share_content_position=='both')
					{	
					    $content_new .=$js_code;
						$content_new .=$content;
						$content_new .=$js_code;
						
					}
                    return $content_new;
     }
     else
     {
        echo"";
     }
        
        
     }
     	
		
	}

add_filter('the_content', 'scsss_display');
?>