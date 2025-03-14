<?php

function transporters_quoteform_control_menu() {
    global $submenu;
	add_menu_page( 'Transporters.io', 'Transporters.io', 'manage_options', 'transporters_quoteform', 'transporters_dashboard', plugins_url( '../images/transporters-icon.png', __FILE__ ), 6 );
	$first_sub = true;
	for($i=1; $i<=5; $i++){
		$url = get_option('transporters_url_site_'.$i);
		if($url !=''){
			if($first_sub){
				add_submenu_page( 'transporters_quoteform', 'Settings', 'Settings', 'manage_options', 'transporters_quoteform', 'transporters_dashboard' );
				$first_sub=false;
			}
			$url = get_option('transporters_url_site_'.$i);
			if($url){
			    add_submenu_page( 'transporters_quoteform', 'Admin Login '.$i, 'Admin Login '.$i, 'manage_options', 'transporters_admin'.$i, 'transporters_admin');
			    //print_r($submenu['transporters_quoteform'][$i]);die();
			    //$submenu['transporters_quoteform'][$i][2] = $url;
			}
		}
	}
}
function transporters_admin(){
    if(wp_get_referer()){check_admin_referer(-1);}
    if(isset($_GET['page'])){
	    if($_GET['page'] == 'transporters_admin1'){$url = get_option('transporters_url_site_1');}
	    elseif($_GET['page'] == 'transporters_admin2'){$url = get_option('transporters_url_site_2');}
	    elseif($_GET['page'] == 'transporters_admin3'){$url = get_option('transporters_url_site_3');}
	    elseif($_GET['page'] == 'transporters_admin4'){$url = get_option('transporters_url_site_4');}
	    elseif($_GET['page'] == 'transporters_admin5'){$url = get_option('transporters_url_site_5');}
	}
	echo("<style>#wpcontent{padding:0; height:100%;border: 2px solid #FFF;}#wpbody-content {padding-bottom: 0;}</style>");
	echo('<a href="'.esc_url($url).'" target="_blank">Click here if you have trouble logging in below</a>');
	echo("<iframe src='".esc_url($url)."' style='width:100%; height:100%; min-height:95vh; border: 0;'></iframe>");
	echo "<script type='text/javascript' > document.body.className+=' folded';</script>";
}

function transporters_dashboard(){
	if(wp_get_referer()){check_admin_referer(-1);}
	//this fails on some live site because wp_get_referer() returns false if referrer is current URL
	$quote_number = 5;
	
	for($i=1;$i<=$quote_number;$i++){
		if(isset($_POST['url_site_'.$i])){
		    check_admin_referer( 'transporters_quoteform_'.$i );
			if(strpos(sanitize_url(wp_unslash($_POST['url_site_'.$i])), '.transporters.io')){
				$_POST['url_site_'.$i] = str_replace('http://', 'https://', sanitize_url(wp_unslash($_POST['url_site_'.$i])));
			}
			if(substr(sanitize_url(wp_unslash($_POST['url_site_'.$i])), -1) != '/') update_option( 'transporters_url_site_'.$i, sanitize_url(wp_unslash($_POST['url_site_'.$i])).'/' );
			else update_option( 'transporters_url_site_'.$i, sanitize_url(wp_unslash($_POST['url_site_'.$i])) );
		}
		
		if(isset($_POST['custom_css_'.$i])){
			update_option( 'transporters_custom_css_'.$i, $_POST['custom_css_'.$i] );//phpcs:ignore
		}
		
		if(isset($_POST['custom_js_'.$i])){
			update_option( 'transporters_custom_js_'.$i, $_POST['custom_js_'.$i] );//phpcs:ignore
		}
		
		if(isset($_POST['custom_js_after1_'.$i])){
			update_option( 'transporters_custom_js_after1_'.$i, $_POST['custom_js_after1_'.$i] );//phpcs:ignore
		}
		
		if(isset($_POST['custom_js_after2_'.$i])){
			update_option( 'transporters_custom_js_after2_'.$i, $_POST['custom_js_after2_'.$i] );//phpcs:ignore
		}
		
		if(isset($_POST['custom_js_back_'.$i])){
			update_option( 'transporters_custom_js_back_'.$i, $_POST['custom_js_back_'.$i] );//phpcs:ignore
		}
		
		if(isset($_POST['ts_custom_background_'.$i])){
			if(isset($_POST['ts_onoff_switch_background_'.$i]) && sanitize_text_field(wp_unslash($_POST['ts_onoff_switch_background_'.$i])) == 1){
				update_option( 'ts_custom_background_'.$i, sanitize_text_field(wp_unslash($_POST['ts_custom_background_'.$i])) );
			}else{
				update_option( 'ts_custom_background_'.$i, 'none');
			}
		}
		
		if(isset($_POST['ts_custom_text_color_'.$i])){
			update_option( 'ts_custom_text_color_'.$i, sanitize_text_field(wp_unslash($_POST['ts_custom_text_color_'.$i])) );
		}
		
		if(isset($_POST['ts_custom_title_color_'.$i])){
			update_option( 'ts_custom_title_color_'.$i, sanitize_text_field(wp_unslash($_POST['ts_custom_title_color_'.$i])) );
		}
		
		if(isset($_POST['ts_custom_border_color_'.$i])){
			if(isset($_POST['ts_onoff_switch_border_color_'.$i]) && sanitize_text_field(wp_unslash($_POST['ts_onoff_switch_border_color_'.$i])) == 1){
				update_option( 'ts_custom_border_color_'.$i, sanitize_text_field(wp_unslash($_POST['ts_custom_border_color_'.$i])) );
			}else{
				update_option( 'ts_custom_border_color_'.$i, 'none');
			}
		}
		
		if(isset($_POST['ts_custom_button_color_'.$i])){
			update_option( 'ts_custom_button_color_'.$i, sanitize_text_field(wp_unslash($_POST['ts_custom_button_color_'.$i])) );
		}
		

		if(isset($_POST['update_form_'.$i])){
		    check_admin_referer( 'transporters_quoteform_'.$i );
		    
			if(isset($_POST['return_journey_'.$i])){
				update_option( 'transporters_return_journey_'.$i, sanitize_text_field(wp_unslash($_POST['return_journey_'.$i])));
			}else{
				update_option( 'transporters_return_journey_'.$i, 0);
			}
			
			if(isset($_POST['ts_fixed_route_'.$i])){
				update_option( 'ts_fixed_route_'.$i, sanitize_text_field(wp_unslash($_POST['ts_fixed_route_'.$i])));
			}else{
				update_option( 'ts_fixed_route_'.$i, 0);
			}
			if(isset($_POST['ts_fixed_route_custom_'.$i])){
				update_option( 'ts_fixed_route_custom_'.$i, sanitize_text_field(wp_unslash($_POST['ts_fixed_route_custom_'.$i])));
			}else{
				update_option( 'ts_fixed_route_custom_'.$i, 0);
			}
			
			if(isset($_POST['ts_vehicle_groups_'.$i])){
				update_option( 'ts_vehicle_groups_'.$i, sanitize_text_field(wp_unslash($_POST['ts_vehicle_groups_'.$i])));
			}else{
				update_option( 'ts_vehicle_groups_'.$i, 0);
			}
			
			if(isset($_POST['ts_show_notes_'.$i])){
				update_option( 'ts_show_notes_'.$i, sanitize_text_field(wp_unslash($_POST['ts_show_notes_'.$i])));
			}else{
				update_option( 'ts_show_notes_'.$i, 0);
			}

			if(isset($_POST['ts_ampm_'.$i])){
				update_option( 'ts_ampm_'.$i, sanitize_text_field(wp_unslash($_POST['ts_ampm_'.$i])));
			}else{
				update_option( 'ts_ampm_'.$i, 0);
			}

			if(isset($_POST['ts_delayformload_'.$i])){
				update_option( 'ts_delayformload_'.$i, sanitize_text_field(wp_unslash($_POST['ts_delayformload_'.$i])));
			}else{
				update_option( 'ts_delayformload_'.$i, 0);
			}
			
			if(isset($_POST['ts_viastops_'.$i])){
				update_option( 'ts_viastops_'.$i, sanitize_text_field(wp_unslash($_POST['ts_viastops_'.$i])));
			}else{
				update_option( 'ts_viastops_'.$i, 0);
			}

			if(isset($_POST['ts_tab_options_'.$i])){
				update_option( 'ts_tab_options_'.$i, wp_unslash($_POST['ts_tab_options_'.$i] ));//phpcs:ignore
			}else{
				update_option( 'ts_tab_options_'.$i, null );
			}
			
			if(isset($_POST['profile_id_'.$i])){
				update_option( 'transporters_profile_id_'.$i, sanitize_text_field(wp_unslash($_POST['profile_id_'.$i])));
			}else{
				update_option( 'transporters_profile_id_'.$i, 0);
			}

			if(isset($_POST['display_mode_'.$i])){
				update_option( 'transporters_display_mode_'.$i, sanitize_text_field(wp_unslash($_POST['display_mode_'.$i])));
			}else{
				update_option( 'transporters_display_mode_'.$i, 0);
			}
			
		}
	}
	
	if(isset($_POST['map_api_key'])){
	    check_admin_referer( 'transporters_quoteform_setting' );
		update_option( 'transporters_map_api_key', sanitize_text_field(wp_unslash($_POST['map_api_key'])));
	}
	
	
	echo '<div class="wrap">';
	echo '<h2>'.esc_html_e('Dashboard','transporters-io').'</h2>';
	echo '<img src="'.esc_url(plugins_url( '../images/transporters-logo.png', __FILE__ )).'" style="position: absolute;right: 10px;top: 10px;" />';// phpcs:ignore
	echo '<p>'.esc_html_e('Welcome to the Transporters.io Wordpress Plugin','transporters-io').'</p>';
	echo '<p>'.wp_kses(_e('This plugin allows you to style and place up to 5 <a href="https://transporters.io/wordpress/">Transporters quote forms</a> on your website','transporters-io'),'a').'</p>';
	echo '<p>'.esc_html_e('Simply enter your details on the quote form pages and then insert as either a widget or shortcode.','transporters-io').'</p>';
	echo '<p>'.esc_html_e('For support please visit','transporters-io').' <a href="https://helpdesk.transporters.io/">https://helpdesk.transporters.io</a></p>';
	echo '<div id="ts-tabs">
			  <ul>';
			  for($i=1;$i<=$quote_number;$i++){
				  echo '<li><a href="#ts-quote-form-'.esc_html($i).'">Quote Form '.esc_html($i).'</a></li>';
			  }
	echo '<li><a href="#ts-setting">Settings'.(get_option('transporters_map_api_key') ? '' : ' <span class="dashicons dashicons-warning" style="color:#c60600;"></span>' ).'</a></li>
			  </ul>';
			  
	for($i=1;$i<=$quote_number;$i++){
// phpcs:ignore
		echo '<div id="ts-quote-form-'.esc_html($i).'">'.transporters_quote_form_X($i).'
			  </div>';
	}
// phpcs:ignore
	echo '<div id="ts-setting"><div class="wrap"><p>'.transporters_setting().'</p></div>
			  </div>
			</div>';
	echo '</div>';
	echo '<script>
			  jQuery( function() {
				jQuery( "#ts-tabs" ).tabs();
			  } );
			  
			  function switchBackground(value,id){
				  if(value === false){
					  jQuery("#ts_box_custom_background_"+id).hide();
					  jQuery("#ts-preview-"+id+" > .ts-container").css("background-color","transparent");
				  }else{
					  jQuery("#ts_box_custom_background_"+id).show();
					  jQuery("#ts-preview-"+id+" > .ts-container").css("background-color",jQuery("#ts_custom_background_"+id).val());
					  
				  }
			  }
			  
			  function switchBorder(value,id){
				  if(value === false){
					  jQuery("#ts_box_custom_border_color_"+id).hide();
					  jQuery("#ts-preview-"+id+" .preview-border-color").css("border","1px solid transparent");
					  jQuery("#ts-preview-"+id+" .preview-border-color-bottom").css("border-bottom","1px solid transparent");
				  }else{
					  jQuery("#ts_box_custom_border_color_"+id).show();
					  jQuery("#ts-preview-"+id+" .preview-border-color").css("border","1px solid "+jQuery("#ts_custom_border_color_"+id).val());
					  jQuery("#ts-preview-"+id+" .preview-border-color-bottom").css("border-bottom","1px solid "+jQuery("#ts_custom_border_color_"+id).val());
				  }
			  }
			  
			  </script>';	    
}

function transporters_quote_form_X($id){
	
	$html = '';
	
	$html .= '<style>
				#ts-preview-'.$id.'{
					float:left;
					width:35%;
				}
				
				#ts-preview-'.$id.' label{
					font-weight: 600;
    				line-height: 30px;
					color: #000;
				}
				
				#ts-preview-'.$id.' h1,#ts-preview-'.$id.' h2,#ts-preview-'.$id.' h3,#ts-preview-'.$id.' p{
					font-family: "Source Sans Pro",Calibri,Candara,Arial,sans-serif;
					font-weight: 300;
					line-height: 1.1;
				}
				
				#ts-preview-'.$id.' h1{
					font-size: 39px;
				}
				
				#ts-preview-'.$id.' h2{
					font-size: 32px;
					margin-bottom: 10.5px;
				}
				
				#ts-preview-'.$id.' p{
					margin: 0 0 10.5px;
					font-size: 15px;
				}
				
				#ts-preview-'.$id.' .ts-lead{
					font-size: 22.5px;
				}
				
				#ts-preview-'.$id.' .ts-container{
					border: 1px solid #e3e3e3;
    				padding: 0px 10px;
					border-radius: 4px;
				}
				
				#ts-preview-'.$id.' .ts-page-header{
					padding-bottom: 10px;
					margin: 0px 0 20px;
					border-bottom: 1px solid #e6e6e6;
				}
				
				#ts-preview-'.$id.' .ts-component{
					border: 1px solid #e3bc27;
				}
				
				#ts-preview-'.$id.' .ts-panel-heading{
					color: #7e4040;
					border-color: #e3bc27;
					background-color: #e3ac27;
					padding: 10px 15px;
    				border-bottom: 1px solid transparent;
				}
				
				#ts-preview-'.$id.' .ts-panel-title{
					margin-top: 0;
					margin-bottom: 0;
					font-size: 17px;
					color: inherit;
				}
				
				#ts-preview-'.$id.' #Panels-'.$id.'{
					color: inherit;
					font-size: 39px;
				}
				
				#ts-preview-'.$id.' .ts-panel-body{
					padding: 15px;
				}
				
				#ts-preview-'.$id.' .ts-btn-primary {
					color: #7e4040;
					border-color: #e3bc27;
					background-color: #e3ac27;
				}
				
				#ts-preview-'.$id.' .ts-btn {
					display: inline-block;
					font-weight: normal;
					text-align: center;
					vertical-align: middle;
					-ms-touch-action: manipulation;
					touch-action: manipulation;
					cursor: pointer;
					background-image: none;
					border: 1px solid transparent;
					white-space: nowrap;
					padding: 10px 18px;
					font-size: 15px;
					line-height: 1.42857143;
					border-radius: 0;
					-webkit-user-select: none;
					-moz-user-select: none;
					-ms-user-select: none;
					user-select: none;
					margin-bottom: 5px;
					text-decoration: none;
				}
				
				#ts-preview-'.$id.' .ts-btn-xs, #ts-preview-'.$id.' .ts-btn-group-xs>.ts-btn {
					padding: 1px 5px;
					font-size: 13px;
					line-height: 1.5;
					border-radius: 0;
				}
				
				#ts-preview-'.$id.' > .ts-container{
					background-color:'.((get_option('ts_custom_background_'.$id)) ? ((get_option('ts_custom_background_'.$id) == 'none') ? 'transparent' : get_option('ts_custom_background_'.$id)) : '#ffffff').';
				}
				
				#ts-preview-'.$id.'{
					color:'.((get_option('ts_custom_text_color_'.$id)) ? ((get_option('ts_custom_text_color_'.$id) == 'none') ? 'transparent' : get_option('ts_custom_text_color_'.$id)) : '#003ffb').';
				}
				
				#ts-preview-'.$id.' .preview-text-color{
					color:'.((get_option('ts_custom_text_color_'.$id)) ? ((get_option('ts_custom_text_color_'.$id) == 'none') ? 'transparent' : get_option('ts_custom_text_color_'.$id)) : '#003ffb').';
				}
				
				#ts-preview-'.$id.' .preview-title-color{
					color:'.((get_option('ts_custom_title_color_'.$id)) ? ((get_option('ts_custom_title_color_'.$id) == 'none') ? 'transparent' : get_option('ts_custom_title_color_'.$id)) : '#ffffff').';
				}
				
				#ts-preview-'.$id.' .preview-border-color{
					border:1px solid '.((get_option('ts_custom_border_color_'.$id)) ? ((get_option('ts_custom_border_color_'.$id) == 'none') ? 'transparent' : get_option('ts_custom_border_color_'.$id)) : '#e3bc27').';
				}
				
				#ts-preview-'.$id.' .preview-border-color-bottom{
					border-bottom:1px solid '.((get_option('ts_custom_border_color_'.$id)) ? ((get_option('ts_custom_border_color_'.$id) == 'none') ? 'transparent' : get_option('ts_custom_border_color_'.$id)) : '#e3bc27').';
				}
				
				#ts-preview-'.$id.' .preview-button-color{
					background-color:'.((get_option('ts_custom_button_color_'.$id)) ? ((get_option('ts_custom_button_color_'.$id) == 'none') ? 'transparent' : get_option('ts_custom_button_color_'.$id)) : '#e3ac27').';
				}
				</style>';
				
	$html .= '<script>
			  jQuery( function() {
				jQuery("#ts_custom_background_'.$id.'").wpColorPicker({
					change: function(event, ui){
							var element = event.target;
							var color = ui.color.toString();
							jQuery("#ts-preview-'.$id.' > .ts-container").css("background-color",color);
						}
					});
				
				jQuery("#ts_custom_text_color_'.$id.'").wpColorPicker({
					change: function(event, ui){
							var element = event.target;
							var color = ui.color.toString();
							jQuery("#ts-preview-'.$id.'").css("color",color);
							jQuery("#ts-preview-'.$id.' .preview-text-color").css("color",color);
						}
					});
					
					
				jQuery("#ts_custom_title_color_'.$id.'").wpColorPicker({
					change: function(event, ui){
							var element = event.target;
							var color = ui.color.toString();
							jQuery("#ts-preview-'.$id.' .preview-title-color").css("color",color);
						}
					});	
					
					
				jQuery("#ts_custom_border_color_'.$id.'").wpColorPicker({
					change: function(event, ui){
							var element = event.target;
							var color = ui.color.toString();
							jQuery("#ts-preview-'.$id.' .preview-border-color").css("border","1px solid "+color);
							jQuery("#ts-preview-'.$id.' .preview-border-color-bottom").css("border-bottom","1px solid "+color);
						}
					});		
					
				jQuery("#ts_custom_button_color_'.$id.'").wpColorPicker({
					change: function(event, ui){
							var element = event.target;
							var color = ui.color.toString();
							jQuery("#ts-preview-'.$id.' .preview-button-color").css("background-color",color);
						}
					});		
				
			  });
			  </script>';			

	$html .= '<div class="wrap">';
	$html .= '<form id="quoteform_setting" class="ts-form" method="post" action="'.admin_url( 'admin.php?page=transporters_quoteform').'#ts-quote-form-'.$id.'">';
	$html .= wp_nonce_field( 'transporters_quoteform_'.$id);
	$html .= '<div class="ts-left">
				<p>'.__('Short code','transporters-io').' : [transporters_quote_form id='.$id.']</p>
				<div class="ts-row">
					<div class="title-label">
						<label for="url_site_'.$id.'">'.__('Transporters System URL','transporters-io').' <span class="description">('.__('required','transporters-io').')</span></label>
					</div>
					<div class="ts-input-box">
						<input name="url_site_'.$id.'" type="text" id="url_site_'.$id.'" value="'.get_option('transporters_url_site_'.$id).'" placeholder="https://example.transporters.io/">';
						if(get_option('transporters_url_site_'.$id) !='' && strpos(get_option('transporters_url_site_'.$id), '.transporters.io')==0){
							$html .= '<br class="clear"><span style="color:#ff0000;">Please check URL - Normal value would be in the format https://yoursignupname.transporters.io/</span>';
						}
						
					$html .= '</div>
				</div>
				
				<div class="ts-row">
					<div class="title-label">
						<label for="return_journey_'.$id.'">'.__('Default to return journey','transporters-io').' </label>
					</div>
					<div class="ts-input-box">
						<input type="checkbox" name="return_journey_'.$id.'" id="return_journey_'.$id.'" style="width:auto;" value="1" '.(get_option('transporters_return_journey_'.$id) == 1 ? 'checked="checked"' : '').' />
					</div>
				</div>
				
				<div class="ts-row">
					<div class="title-label" title="'.__('Restrict start and destination locations by adding Fixed Locations or Fixed Routes inside your Transporters Settings','transporters-io').'">
						<label for="ts_fixed_route_'.$id.'">'.__('Fixed locations','transporters-io').' <span class="dashicons dashicons-editor-help"></span></label>
					</div>
					<div class="ts-input-box">
						<input type="checkbox" name="ts_fixed_route_'.$id.'" id="ts_fixed_route_'.$id.'" style="width:auto;" value="1" '.(get_option('ts_fixed_route_'.$id) == 1 ? 'checked="checked"' : '').' />
					</div>
				</div>
				<div class="ts-row" style="display:none;" id="fixed_custom_row_'.$id.'">
					<div class="title-label">
						<label for="ts_fixed_route_custom_'.$id.'">'.__('Allow Custom Option on Fixed Locations','transporters-io').'</label>
					</div>
					<div class="ts-input-box">
					    <select name="ts_fixed_route_custom_'.$id.'" id="ts_fixed_route_custom_'.$id.'">
						<option value="0" '.(get_option('ts_fixed_route_custom_'.$id) == 0 ? 'selected="delected"' : '').'>Disabled</option>
						<option value="1" '.(get_option('ts_fixed_route_custom_'.$id) == 1 ? 'selected="delected"' : '').'>Pickup Only</option>
						<option value="2" '.(get_option('ts_fixed_route_custom_'.$id) == 2 ? 'selected="delected"' : '').'>Destination Only</option>
						<option value="3" '.(get_option('ts_fixed_route_custom_'.$id) == 3 ? 'selected="delected"' : '').'>Both Locations</option>
						</select>
					</div>
				</div>
				<script>
				    jQuery(document).ready(function(){
				        jQuery("#ts_fixed_route_'.$id.'").change(function(){
				        console.log("555");
    				        if(jQuery("#ts_fixed_route_'.$id.'").is(":checked")){
    				            jQuery("#fixed_custom_row_'.$id.'").show();
    				        }else{
    				            jQuery("#fixed_custom_row_'.$id.'").hide();
    				        }
				        });
				        jQuery("#ts_fixed_route_'.$id.'").change();
				    });
				</script>
				<div class="ts-row">
					<div class="title-label">
						<label for="ts_vehicle_groups_'.$id.'">'.__('Use Vehicle Groups not Vehicle Types','transporters-io').'</label>
					</div>
					<div class="ts-input-box">
						<input type="checkbox" name="ts_vehicle_groups_'.$id.'" id="ts_vehicle_groups_'.$id.'" style="width:auto;" value="1" '.(get_option('ts_vehicle_groups_'.$id) == 1 ? 'checked="checked"' : '').' />
					</div>
				</div>
				
				<div class="ts-row">
					<div class="title-label">
						<label for="ts_show_notes_'.$id.'">'.__('Show Notes','transporters-io').'</label>

					</div>
					<div class="ts-input-box">
						<input type="checkbox" name="ts_show_notes_'.$id.'" id="ts_show_notes_'.$id.'" style="width:auto;" value="1" '.(get_option('ts_show_notes_'.$id) == 1 ? 'checked="checked"' : '').' />
					</div>
				</div>
				
				<div class="ts-row">
					<div class="title-label">
						<label for="ts_ampm_'.$id.'">'.__('AM/PM','transporters-io').'</label>

					</div>
					<div class="ts-input-box">
						<input type="checkbox" name="ts_ampm_'.$id.'" id="ts_ampm_'.$id.'" style="width:auto;" value="1" '.(get_option('ts_ampm_'.$id) == 1 ? 'checked="checked"' : '').' />
					</div>
				</div>
				
				<div class="ts-row">
					<div class="title-label">
						<label for="ts_delayformload_'.$id.'" title="'.__('Will improve google page speed scores, with the form displaying slightly slower than if disabled','transporters-io').'">'.__('Lazy Loading?','transporters-io').' <span class="dashicons dashicons-editor-help"></span></label>

					</div>
					<div class="ts-input-box">
						<input type="checkbox" name="ts_delayformload_'.$id.'" id="ts_delayformload_'.$id.'" style="width:auto;" value="1" '.(get_option('ts_delayformload_'.$id) == 1 ? 'checked="checked"' : '').' />
					</div>
				</div>
				
				<div class="ts-row">
					<div class="title-label">
						<label for="ts_viastops_'.$id.'">'.__('Allow Via Stops?','transporters-io').' </label>

					</div>
					<div class="ts-input-box">
						<input type="checkbox" name="ts_viastops_'.$id.'" id="ts_viastops_'.$id.'" style="width:auto;" value="1" '.(get_option('ts_viastops_'.$id) == 1 ? 'checked="checked"' : '').' />
					</div>
				</div>
				
				
				<div class="ts-row">
					<div class="title-label">
						<label for="profile_id_'.$id.'" title="'.__('Multiple company profiles is a Transporters Pro feature. If you want to assign this quote form to a profile enter its ID number in the box below.','transporters-io').'">'.__('Profile ID','transporters-io').' <span class="dashicons dashicons-editor-help"></span></label>
					</div>
					<div class="ts-input-box">
						<input type="number" name="profile_id_'.$id.'" id="profile_id_'.$id.'" value="'.stripslashes(get_option('transporters_profile_id_'.$id)).'" >
					</div>
				</div>

				<div class="ts-row">
					<div class="title-label">
						<label for="profile_id_'.$id.'">'.__('Tabs','transporters-io').'</label>
					</div>
					<div class="ts-input-box">
						<select multiple name="ts_tab_options_'.$id.'[]" id="ts_tab_options_'.$id.'" style="min-width:40%">';
						$active_tabs = get_option('ts_tab_options_'.$id);
						$tabs = array('one_way', 'return', 'charter');
						foreach($tabs as $tab){
							$html.='<option value="'.$tab.'" '.(is_array($active_tabs)&& in_array($tab,$active_tabs)?' selected="selected"':'').'>'.ucfirst(str_replace('_', ' ', $tab))
							.'</option>';
						}
						$html.='</select>
					</div>
				</div>


				<div class="ts-row">
					<div class="title-label">
						<label>'.__('Display Mode','transporters-io').'</label>
					</div>
					<div class="ts-input-box">
						<input type="radio" name="display_mode_'.$id.'" id="display_mode_'.$id.'" value="0" '.(get_option('transporters_display_mode_'.$id)==0?'checked="checked"':'').'" >
						<label for="display_mode_'.$id.'">'.__('Standard 2 Step Form','transporters-io').'</label><br>
					</div>
					<div class="title-label">
						&nbsp;
					</div>
					<div class="ts-input-box">
						<input type="radio" name="display_mode_'.$id.'" id="display_mode_'.$id.'" value="multiquote3" '.(get_option('transporters_display_mode_'.$id)=='multiquote3'?'checked="checked"':'').'" >
						<label for="display_mode_'.$id.'">'.__('3 Step Multi Quote Form','transporters-io').'</label><br>
					</div>
				</div>
				
				
				<p class="submit"><input type="submit" name="createuser" id="createusersub" class="button button-primary" value="'.__('Update Quote Form','transporters-io').'"></p>
			</div>';
	$html .= '<div class="ts-right">
					<div class="ts-row">
						<div class="title-label title-color">
							<label for="ts_onoff_switch_background_'.$id.'">'.__('Background','transporters-io').'</label>
						</div>
						<div class="ts-input-box">
							
							<div class="ts-switch-box">
								<div class="onoffswitch">
									<input type="checkbox" name="ts_onoff_switch_background_'.$id.'" onchange="switchBackground(this.checked,'.$id.');" value="1" class="onoffswitch-checkbox" id="ts_onoff_switch_background_'.$id.'" '.((get_option('ts_custom_background_'.$id)) ? ((get_option('ts_custom_background_'.$id) == 'none') ? '' : 'checked') : 'checked').' >
									<label class="onoffswitch-label" for="ts_onoff_switch_background_'.$id.'">
										<span class="onoffswitch-inner"></span>
										<span class="onoffswitch-switch"></span>
									</label>
								</div>
							</div>
							
							<div id="ts_box_custom_background_'.$id.'" class="ts-color-box" '.((get_option('ts_custom_background_'.$id)) ? ((get_option('ts_custom_background_'.$id) == 'none') ? 'style="display:none;"' : '') : '').'>
								<input type="color" id="ts_custom_background_'.$id.'" name="ts_custom_background_'.$id.'" class="color-field" data-preferred-format="hex" value="'.((get_option('ts_custom_background_'.$id)) ? ((get_option('ts_custom_background_'.$id) == 'none') ? '#ffffff' : get_option('ts_custom_background_'.$id)) : '#ffffff').'">
							</div>
						</div>
					</div>
					
					<div class="ts-row">
						<div class="title-label title-color">
							<label for="ts_custom_text_color_'.$id.'">'.__('Text colour','transporters-io').'</label>
						</div>
						<div class="ts-input-box">
								<input type="color" id="ts_custom_text_color_'.$id.'" name="ts_custom_text_color_'.$id.'" class="color-field" data-preferred-format="hex" value="'.((get_option('ts_custom_text_color_'.$id)) ? get_option('ts_custom_text_color_'.$id) : '#003ffb').'">							
						</div>
					</div>
					
					<div class="ts-row">
						<div class="title-label title-color">
							<label for="ts_custom_title_color_'.$id.'">'.__('Titles colour','transporters-io').'</label>
						</div>
						<div class="ts-input-box">						
							<input type="color" id="ts_custom_title_color_'.$id.'" name="ts_custom_title_color_'.$id.'" class="color-field" data-preferred-format="hex" value="'.((get_option('ts_custom_title_color_'.$id)) ? get_option('ts_custom_title_color_'.$id) : '#ffffff').'">
						</div>
					</div>
					
					<div class="ts-row">
						<div class="title-label title-color">
							<label for="ts_onoff_switch_border_color_'.$id.'">'.__('Borders colour','transporters-io').'</label>
						</div>
						<div class="ts-input-box">
						
						<div class="ts-switch-box">
								<div class="onoffswitch">
									<input type="checkbox" name="ts_onoff_switch_border_color_'.$id.'" onchange="switchBorder(this.checked,'.$id.');" value="1" class="onoffswitch-checkbox" id="ts_onoff_switch_border_color_'.$id.'" '.((get_option('ts_custom_border_color_'.$id)) ? ((get_option('ts_custom_border_color_'.$id) == 'none') ? '' : 'checked') : 'checked').'>
									<label class="onoffswitch-label" for="ts_onoff_switch_border_color_'.$id.'">
										<span class="onoffswitch-inner"></span>
										<span class="onoffswitch-switch"></span>
									</label>
								</div>
							</div>
							
							<div id="ts_box_custom_border_color_'.$id.'" class="ts-color-box" '.((get_option('ts_custom_border_color_'.$id)) ? ((get_option('ts_custom_border_color_'.$id) == 'none') ? 'style="display:none;"' : '') : '').'>
								<input type="color" id="ts_custom_border_color_'.$id.'" name="ts_custom_border_color_'.$id.'" class="color-field" data-preferred-format="hex" value="'.((get_option('ts_custom_border_color_'.$id)) ? ((get_option('ts_custom_border_color_'.$id) == 'none') ? '#e3bc27' : get_option('ts_custom_border_color_'.$id)) : '#e3bc27').'">
							</div>
							
						</div>
					</div>
					
					<div class="ts-row">
						<div class="title-label title-color">
							<label for="ts_custom_button_color_'.$id.'">'.__('Buttons colour','transporters-io').'</label>
						</div>
						<div class="ts-input-box">
							<input type="color" id="ts_custom_button_color_'.$id.'" name="ts_custom_button_color_'.$id.'" class="color-field" data-preferred-format="hex" value="'.((get_option('ts_custom_button_color_'.$id)) ? get_option('ts_custom_button_color_'.$id) : '#e3bc27').'">
						</div>
					</div>
					
					<div class="ts-row">
						<input type="button" name="filter_action" onClick="jQuery(\'.ts-advanced\').toggle();" class="button" value="Advanced">
					</div>
	
					<div class="ts-row ts-advanced">
						<div class="title-label">
							<label for="custom_js_after1_'.$id.'">'.__('Custom JS (after stage 1)','transporters-io').'</label>
						</div>
						<div class="ts-input-box">
							<textarea name="custom_js_after1_'.$id.'" type="text" id="custom_js_after1_'.$id.'" >'.stripslashes(get_option('transporters_custom_js_after1_'.$id)).'</textarea>
						</div>
					</div>
					
					<div class="ts-row ts-advanced">
						<div class="title-label">
							<label for="custom_js_after2_'.$id.'">'.__('Custom JS (after stage 2)','transporters-io').'</label>
						</div>
						<div class="ts-input-box">
							<textarea name="custom_js_after2_'.$id.'" type="text" id="custom_js_after2_'.$id.'" >'.stripslashes(get_option('transporters_custom_js_after2_'.$id)).'</textarea>
						</div>
					</div>
					
					<div class="ts-row ts-advanced">
						<div class="title-label">
							<label for="custom_js_back_'.$id.'">'.__('Custom JS (after back)','transporters-io').'</label>
						</div>
						<div class="ts-input-box">
							<textarea name="custom_js_back_'.$id.'" type="text" id="custom_js_back_'.$id.'" >'.stripslashes(get_option('transporters_custom_js_back_'.$id)).'</textarea>
						</div>
					</div>
					
					
					<div class="ts-row ts-advanced">
						<div class="title-label">
							<label for="custom_css_'.$id.'">'.__('Custom CSS','transporters-io').'</label>
						</div>
						<div class="ts-input-box">
							<textarea name="custom_css_'.$id.'" type="text" id="custom_css_'.$id.'" >'.stripslashes(get_option('transporters_custom_css_'.$id)).'</textarea>
						</div>
					</div>
					
					<div class="ts-row ts-advanced">
						<div class="title-label">
							<label for="custom_js_'.$id.'">'.__('Custom JS','transporters-io').'</label>
						</div>
						<div class="ts-input-box">
							<textarea name="custom_js_'.$id.'" type="text" id="custom_js_'.$id.'" >'.stripslashes(get_option('transporters_custom_js_'.$id)).'</textarea>
						</div>
					</div>
					
				</div>';
	$html .= '<div id="ts-preview-'.$id.'">
					<label for="user_login">'.__('Preview','transporters-io').'</label>
					<div class="ts-container">
						<div class="ts-docs-section">
							<div class="ts-page-header" style="margin-top: 0px;">
								<div class="row">
									<div class="ts-col-xs-12">
										<h1 id="Panels-'.$id.'">Panels</h1>
									</div>
								</div>
							</div>
							<div class="row">
								<div class="ts-col-xs-12">
									<div class="ts-component preview-border-color">
										<div class="ts-panel ts-panel-primary">
											<div class="ts-panel-heading preview-border-color-bottom preview-button-color">
												<h3 class="ts-panel-title preview-title-color preview-button-color">Panel primary</h3>
											</div>
											<div class="ts-panel-body">
												Panel content
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
						<div class="ts-docs-section">
							<div class="ts-page-header">
								<div class="row">
									<div class="ts-col-xs-12">
										<h1 id="ts-buttons" class="preview-text-color">Buttons</h1>
									</div>
								</div>
							</div>
							<div class="row">
								<div class="ts-col-xs-12">
									<a href="javascript:;" class="ts-btn ts-btn-primary ts-btn-xs preview-title-color preview-border-color preview-button-color">Mini</a>
									<br>
									<a href="javascript:;" class="ts-btn ts-btn-primary ts-btn-sm preview-title-color preview-border-color preview-button-color">Small</a>
									<br>
									<a href="javascript:;" class="ts-btn ts-btn-primary preview-title-color preview-border-color preview-button-color">Medium</a>
									<br>
									<a href="javascript:;" class="ts-btn ts-btn-primary ts-btn-lg preview-title-color preview-border-color preview-button-color">Large</a>
								</div>
							</div>
						</div>
						<div class="ts-docs-section">
							<div class="ts-page-header">
								<div class="row">
									<div class="ts-col-xs-12">
										<h1 id="ts-typography" class="preview-text-color">Typography</h1>
									</div>
								</div>
							</div>
							<div class="row">
								<div class="ts-col-xs-12">
									<h1 style="margin-top: 0px;" class="preview-text-color">Heading 1</h1>
									<p class="ts-lead">Vivamus sagittis lacus vel augue laoreet rutrum faucibus dolor auctor.</p>
								</div>
								<div class="ts-col-xs-12">
									<h2 class="preview-text-color">Example body text</h2>
									<p>Nullam quis risus eget
										<a href="#">urna mollis ornare</a> vel eu leo. Cum sociis natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus. Nullam id dolor id nibh ultricies vehicula.
									</p>
									<p>
										<small>This line of text is meant to be treated as fine print.</small>
									</p>
									<p>The following snippet of text is <strong>rendered as bold text</strong>.</p>
									<p>The following snippet of text is <em>rendered as italicized text</em>.</p>
									<p>An abbreviation of the word attribute is <abbr title="attribute">attr</abbr>.</p>
								</div>
							</div>
						</div>
					</div>
				</div>';			
				
	$html .= '<input type="hidden" name="update_form_'.$id.'" value="1" />';
	$html .= '</form>';
	$html .= '</div>';
	return $html;
}

function transporters_setting(){
	
	$html = '';

	$html .= '<div style="width:40%; float:left;">
	<h4>Enter your Google Maps API Key</h4>
	<p>'.__('Transporters.io relies on Google maps - you need to enter your free API key in the box below.','transporters-io').'</p>';
	$html .= '<p><a href="https://helpdesk.transporters.io/getting-started/setting-up-maps-or-fixing-recent-maps-issues" class="button button-primary" target="_blank">'.__('More Info On Google Maps','transporters-io').'</a></p>';
	$html .= '<p><a href="https://console.developers.google.com/flows/enableapi?apiid=maps_backend,geocoding_backend,directions_backend,places_backend&keyType=CLIENT_SIDE&reusekey=true" target="_blank">'.__('Get Google map API Key','transporters-io').'</a></p>';
	$html .= '<p><a href="https://console.developers.google.com/billing/linkedaccount" target="_blank">'.__('Check Maps Billing','transporters-io').'</a></p>';
	
	
	$html .= '<form id="quoteform_setting" method="post" action="'.admin_url( 'admin.php?page=transporters_quoteform').'#ts-setting">';
	$html .= wp_nonce_field( 'transporters_quoteform_setting');
	$html .= '<table class="form-table">
	<tbody>
	<tr class="form-field form-required">
		<th scope="row"><label for="map_api_key">'.__('Google Map API Key','transporters-io').' <span class="description">('.__('required','transporters-io').')</span></label></th>
		<td><input name="map_api_key" type="text" id="map_api_key" value="'.get_option('transporters_map_api_key').'" ></td>
	</tr>
	</tbody>
	</table>
	<p class="submit"><input type="submit" class="button button-primary" value="'.__('Update Setting','transporters-io').'"></p>
	</form>
	</div>
	<div style="width:45%; float:left;">
	<h4>Common Troubleshooting</h4>
	If you have problems with the address suggestions or google maps not displaying, please check the following.<br>
	<br>
	1) Click <a href="https://console.cloud.google.com/apis/dashboard">https://console.cloud.google.com/apis/dashboard</a>
		Then click enable API and ensure that the following are active.<br>
		<ul>
		<li><a href="https://console.cloud.google.com/apis/library/places.googleapis.com">Google Places API Web Service (new)</a></li>
		<li><a href="https://console.cloud.google.com/apis/library/places-backend.googleapis.com">Google Places API Web Service (old)</a></li>
		<li><a href="https://console.cloud.google.com/apis/library/geocoding-backend.googleapis.com">Google Maps Geocoding API</a></li>
		<li><a href="https://console.cloud.google.com/apis/library/directions-backend.googleapis.com">Google Maps Directions API</a></li>
		<li><a href="https://console.cloud.google.com/apis/library/routes.googleapis.com">Google Routes API</a></li>
		<li><a href="https://console.cloud.google.com/apis/library/maps-backend.googleapis.com">Google Maps JavaScript API</a></li>
		</ul>
	<br> 
	2) Click <a href="https://console.cloud.google.com/apis/credentials">https://console.developers.google.com/apis/credentials</a><br>
	Find the API key entered in the box on this page.<br>
	Under Key restriction choose "HTTP referrers (web sites)"<br>
	In the list of sites to accept make sure the following is present.<br>
	*yourwebsitename.com/*<br>
	[Replace "yourwebsitename.com" with your real website]<br>
	<br>
	3) Make sure billing is active on your Google Maps account.<br>
	Although you should not need to pay unless you exceed the generous free allowance, activating billing is now a requirement by Google.<br>
	<a href="https://helpdesk.transporters.io/getting-started/setting-up-maps-or-fixing-recent-maps-issues" target="_blank">Read more about this.</a>
	</div>';
	
	return $html;
}

?>
