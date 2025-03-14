<?php

function transportersQuoteFormHTML($widget_id, $widget_type, $fixed){
	$keyword = '';
	$referer = '';
	$ip = '';
	$html='';
	$affiliate_id  = '';

	if(isset($_COOKIE['transporters_referer'])){
		$referer_array = explode('***',sanitize_text_field(wp_unslash($_COOKIE['transporters_referer'])));
		if(is_array($referer_array)){
			if(isset($referer_array[1])) $keyword = $referer_array[1];
			if(isset($referer_array[0])) $referer = $referer_array[0];
		}
	}else if(isset($first_cookie)){
		$referer_array = explode('***',$first_cookie);
		if(is_array($referer_array)){
			if(isset($referer_array[1])) $keyword = $referer_array[1];
			if(isset($referer_array[0])) $referer = $referer_array[0];
		}
	}
	if(isset($_COOKIE['transporters_aff'])){
		$affiliate_id = sanitize_text_field(wp_unslash($_COOKIE['transporters_aff']));
	}else if(isset($first_cookie_aff)){
		$affiliate_id = $first_cookie_aff;
	}elseif(isset($_GET['aff'])){//phpcs:ignore
		$affiliate_id = sanitize_text_field(wp_unslash($_GET['aff']));//phpcs:ignore
	}elseif(isset($_GET['affiliate_id'])){//phpcs:ignore
		$affiliate_id = sanitize_text_field(wp_unslash($_GET['affiliate_id']));//phpcs:ignore
	}
		
	if($ip =='' && isset($_SERVER['HTTP_CF_CONNECTING_IP'])){
		$ip = sanitize_text_field(wp_unslash($_SERVER['HTTP_CF_CONNECTING_IP']));
	}elseif($ip =='' && isset($_SERVER['HTTP_X_FORWARDED_FOR'])){
		$ip = sanitize_text_field(wp_unslash($_SERVER['HTTP_X_FORWARDED_FOR']));
	}elseif($ip =='' && isset($_SERVER['REMOTE_ADDR'])){
		$ip = sanitize_text_field(wp_unslash($_SERVER['REMOTE_ADDR']));
	}

	$tabs = get_option('ts_tab_options_'.$widget_id);
	
	$tabWidth = 0;
	if(is_array($tabs)){$tabWidth = count($tabs);}
    
    $quoteform_mode = get_option( 'transporters_display_mode_'.$widget_id);		


	$html .= //'<script type="text/javascript" src="'.plugin_dir_url( __FILE__ ) . '../js/quoteform_scripts_front.js?v=3'.'"></script>
				'<script>
                    
                    var siteURL = "'.get_option('transporters_url_site_'.$widget_id).'";';
    if(get_option( 'ts_delayformload_'.$widget_id)){//delay mode, improve google pagespeed
		$html .='window.addEventListener("load", function () {
						getQuoteForm("'.get_option('transporters_url_site_'.$widget_id).'","'.$widget_id.'","'.$widget_type.'","'.$fixed.'");
					}, false);';
	}else{
		$html .='jQuery( document ).ready(function() {
						getQuoteForm("'.get_option('transporters_url_site_'.$widget_id).'","'.$widget_id.'","'.$widget_type.'","'.$fixed.'");
					});';
	}		
	$html .='			var loading_text="'.__('Loading available vehicles','transporters-io').'";
				</script>';
	if(get_option('transporters_map_api_key')){
		$html .= '<script>var maps_active = true;</script>';
	}else{
		$html .= '<script>var maps_active = false;</script>';
	}
	
	if(get_option('ts_ampm_'.$widget_id)){
		$html .= '<script>var ampm_active = true;</script>';
	}else{
		$html .= '<script>var ampm_active = false;</script>';
	}
	
	$html .= '<script>var fixed_route_custom = '.(int)get_option('ts_fixed_route_custom_'.$widget_id).';</script>';
	
	
	if(get_option('ts_viastops_'.$widget_id)){
	    $hasVia = true;
		$html .= '<script>
		    var has_via = true;
		    var via_label = "'.__('Via','transporters-io').'";
		</script>';
	}else{
	    $hasVia = false;
		$html .= '<script>var has_via = false;</script>';
	}
        
        $html .= '<script>var get_quote_text ="'.__('Get Quote','transporters-io').'"; var book_now_text ="'.__('Book Now','transporters-io').'"; </script>';
								
		$html .= '<style>'.stripslashes(get_option('transporters_custom_css_'.$widget_id)).'</style>';
		$html .= '<script>'.stripslashes(get_option('transporters_custom_js_'.$widget_id)).'</script>';
		$html .= '<style>
						#panel-quote-form'.$widget_type.'{
							'.(get_option('ts_custom_background_'.$widget_id) ? ((get_option('ts_custom_background_'.$widget_id) == 'none') ? 'background-color:transparent;' : 'background-color:'.get_option('ts_custom_background_'.$widget_id).';') : 'background-color:#ffffff;').'
						}
						
						#panel-quote-form'.$widget_type.',#panel-quote-form'.$widget_type.' h4,#panel-quote-form'.$widget_type.' small{
							'.(get_option('ts_custom_text_color_'.$widget_id) ? 'color:'.get_option('ts_custom_text_color_'.$widget_id).' !important;' : 'color:#003ffb !important;').'
						}
						
						#panel-quote-form'.$widget_type.' .panel-title{
							'.(get_option('ts_custom_title_color_'.$widget_id) ? 'color:'.get_option('ts_custom_title_color_'.$widget_id).';' : 'color:#ffffff;').'
						}
						
						#panel-quote-form'.$widget_type.' .btn{
							'.(get_option('ts_custom_title_color_'.$widget_id) ? 'color:'.get_option('ts_custom_title_color_'.$widget_id).';' : 'color:#ffffff;').'
							'.(get_option('ts_custom_border_color_'.$widget_id) ? ((get_option('ts_custom_border_color_'.$widget_id) == 'none') ? 'border-color:transparent;' : 'border-color:'.get_option('ts_custom_border_color_'.$widget_id).';') : 'border-color:#e3bc27;').'
							'.(get_option('ts_custom_button_color_'.$widget_id) ? 'background-color:'.get_option('ts_custom_button_color_'.$widget_id).';' : 'background-color:#e3bc27;').'
						}
						
						#panel-quote-form'.$widget_type.' .panel-heading{
							'.(get_option('ts_custom_button_color_'.$widget_id) ? 'background-color:'.get_option('ts_custom_button_color_'.$widget_id).';' : 'background-color:#e3bc27;').'
							'.(get_option('ts_custom_border_color_'.$widget_id) ? ((get_option('ts_custom_border_color_'.$widget_id) == 'none') ? 'border-bottom-color:transparent;' : 'border-bottom-color:'.get_option('ts_custom_border_color_'.$widget_id).';') : 'border-bottom-color:#e3bc27;').'
						}
						
						#panel-quote-form'.$widget_type.'{
							'.(get_option('ts_custom_border_color_'.$widget_id) ? ((get_option('ts_custom_border_color_'.$widget_id) == 'none') ? 'border-color:transparent;' : 'border-color:'.get_option('ts_custom_border_color_'.$widget_id).';') : 'border-color:#e3bc27;').'
						}';
						
						
		if($tabWidth > 0){$html.=' 
				.transportersio-quote .panel-get-a-quote.panel-body{padding-top:0;}';
		}
		
		$html.=' 
		.transportersio-quote .tabrow .tab{
		            background-color: #ccc;
		            padding:1em;
		            margin-top:0;
		            cursor:pointer;
		            box-shadow:1px -1px 1px #aaa inset;
		            border-right: 1px solid rgba(255,255,255,0.5);
		}
		.transportersio-quote .tab_hidden{display:none;}
		.transportersio-quote .tabrow .tab.active, .transportersio-quote .tabrow .tab.first.active{
		            background-color:'.(get_option('ts_custom_background_'.$widget_id)?get_option('ts_custom_background_'.$widget_id).';' : 'background-color:#fff;').'
		            box-shadow:none;
		}
        .transportersio-quote .form-horizontal, .transportersio-quote .form-group {
            clear: both;
        }
		
		.transportersio-quote.wide{
		
		}
		.transportersio-quote.wide .col-md-6{width:50%; float: left;}
		.transportersio-quote.wide .col-md-5{width:41.66666667%; float: left;}
		.transportersio-quote.wide .col-md-7{width:58.33333333%; float: left;}
		.transportersio-quote .col-sm-12{width:100%; float: left;}
		.transportersio-quote.small{
		
		}
		
		
		.multi-result-row {
            border:1px solid #ccc;
            padding: 0;
            margin-bottom: 0.5em; 
        }
        .multi-result-row .image-box{ 
            height:100%;
            width:25%;
            display:inline-block;
            vertical-align: top;
            
        }
        .multi-result-row .vehicle-image { 
            width:auto;
            max-height:100%;
            max-width:100%;
        }
        .multi-result-row .vehicle-info{
            padding: 1em 1%;
            width:50%;
            display:inline-block;
        }
        .multi-result-row.has-image .vehicle-info{
            padding: 0.5em;   
        }
        .multi-result-row .multiquote-button-box{
            width:20%;
            display:inline-block;
            vertical-align: text-bottom;
        }
        .multi-result-row .book-button{
            padding: 0;
            width:100%;
        }
        .multi-result-row .book-button.priced{
            font-weight:bold;
        }
        
        @media (max-width: 500px){
            .multi-result-row .multiquote-button-box, .multi-result-row .vehicle-info, .multi-result-row .image-box{width:100%;}
        }
		.transportersio-quote.small .multi-result-row .multiquote-button-box, .transportersio-quote.small .multi-result-row .vehicle-info, .transportersio-quote.small .multi-result-row .image-box{width:100%;}
			
	
					</style>';
		
		$html .= '<div id="panel-quote-form'.$widget_type.'" class="transportersio-quote panel panel-primary" style="display: none;">
                <div class="panel-heading">
                    <h3 class="panel-title">'.__('Get a Quote','transporters-io').'</h3>
                </div>
                <div id="panel-get-a-quote'.$widget_type.'" class="panel-body panel-get-a-quote" style="display: block;">
                    <div id="alert-get-a-quote'.$widget_type.'"></div>
                    <form action="javascript:;" method="post" id="form-get-a-quote'.$widget_type.'">
                    <input type="hidden" id="quoteform_mode'.$widget_type.'" value="'.$quoteform_mode.'">
                    <input type="hidden" name="vehicle_groups" value="'.get_option('ts_vehicle_groups_'.$widget_id).'">';
                  	if($fixed == true){	
                  	$html .= '<input type="hidden" name="fixed" value="1">';	
                  	
                  	}
                    if($tabWidth > 0){
                    	
                    	if(is_array($tabs) && in_array('return', $tabs) && get_option( 'transporters_return_journey_'.$widget_id)){$return_tab_active = true;}
                    	else{$return_tab_active = false;}
                    	
                        $html.='<div class="row tabrow">';
                        if(is_array($tabs)){
                            foreach($tabs as $tab){
                            	$active = (($tab == $tabs[0] && $return_tab_active == false) || ($return_tab_active && $tab=='return'));
                                $html.='<div class="col-sm-'.(12/$tabWidth).' tab '.($tab == $tabs[0]?' first ':'').($active?' active ':'').'" data-tab="'.$tab.'"" >
                                        '. __(str_replace('_', ' ', ucfirst($tab)),'transporters-io') .'</div>';//phpcs:ignore
                            }
                        }
                        $html.='</div>';
                        
                     }else{
                     	//if(get_option( 'transporters_return_journey_'.$widget_id)){$return_notab_active = true;}
                   		//else{$return_notab_active = false;}
                    	if(get_option( 'transporters_return_journey_'.$widget_id)){
                     		$html.='<input type="hidden" id="return_tab_active'.$widget_type.'" value="1">';
                     	}
                     }
                     

                       $html.='<div class="form-group">
                            <label for="start-location">'.__('Start location','transporters-io').'</label>';
		if($fixed == true){					
			$html .= '<select name="start_location" id="select-start-location'.$widget_type.'" class="form-control">
                                    <option data-endId="0" value="0">'.__('Select a location','transporters-io').'</option>
                                </select>';
		}
		$html .= '<input tabindex="1" type="text" name="start_location" id="start-location'.$widget_type.'" '.(($fixed == true)? 'style="display:none;"' : '').'
					   class="form-control is_places_suggest" value="" placeholder="'.__('Enter a location','transporters-io').'"
					   required>';
		
         $html .= '</div>
                        <div class="form-group" id="viastops'.$widget_type.'"></div>
                        <div class="form-group">
                            <label for="end-location">'.__('Destination','transporters-io').'</label>';
        if($hasVia == true){
            $html .= '<a href="#" id="add_via_stop'.$widget_type.'" class="pull-right btn btn-sm btn-primary"><span class="fa fa-plus"></span> Add Stop</a>';
        
        }                    
                           
		if($fixed == true){
				$html .= '<select name="end_location" id="select-end-location'.$widget_type.'" class="form-control">
                                    <option value="0">'.__('Select a location','transporters-io').'</option>
                                </select>';
		}
		$html .= '<input tabindex="2" type="text" name="end_location" id="end-location'.$widget_type.'" '.(($fixed == true)? 'style="display:none;"' : '').'
                                   class="form-control is_places_suggest" value="" placeholder="'.__('Enter a location','transporters-io').'"
                                   required>';
		
                            
         $html .= '</div>
                        <div class="form-group last" id="pickup_date_time_box'.$widget_type.'">
                            <label>'.__('Pickup date & time','transporters-io').'</label>

                            <div class="row">
                                <div class="col-xs-6" id="pickup_date_box'.$widget_type.'">
                                    <div class="form-group">
                                    	<input tabindex="3" type="text" name="start_date" id="start-date'.$widget_type.'"
                                               class="form-control" 
                                               data-date-start-date="+0d" onClick="jQuery(\'#start-date'.$widget_type.'\').blur();" required>
                                     </div>
                                </div>
                                <div class="col-xs-6" id="pickup_time_box'.$widget_type.'">
                                    <div class="form-group">
                                    	<input tabindex="4" type="text" name="start_time" id="start-time'.$widget_type.'"
                                               class="form-control" onClick="jQuery(\'#start-time'.$widget_type.'\').blur();" required>
                                     </div>
                                </div>
                            </div>
                        </div>
                        <div class="form-group  last tab_hidden show_tab_return hide_tab_one_way hide_tab_charter" id="return_date_time_box'.$widget_type.'">
                            <label>'.__('Return date & time','transporters-io').'</label>

                            <div class="row">
                                <div class="col-xs-6" id="return_date_box'.$widget_type.'">
                                    <div class="form-group">
                                        <input tabindex="3" type="text" name="return_date-first" id="return-date-first'.$widget_type.'"
                                               class="form-control  disable_tab_charter disable_tab_one_way enable_tab_return" 
                                               data-date-start-date="+0d" onClick="jQuery(\'#return-date-first'.$widget_type.'\').blur();">
                                    </div>
                                </div>
                                <div class="col-xs-6" id="return_time_box'.$widget_type.'">
                                    <div class="form-group">
                                        <input tabindex="4" type="text" name="return_time-first" id="return-time-first'.$widget_type.'"
                                               class="form-control  disable_tab_charter disable_tab_one_way enable_tab_return" onClick="jQuery(\'#return-time-first'.$widget_type.'\').blur();">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="form-group last tab_hidden hide_tab_return hide_tab_one_way show_tab_charter">
                            <label>'.__('Charter Hours','transporters-io').'</label>

                            <div class="row">
                                <div class="col-xs-12">
                                    <div class="form-group ">
                                        <select tabindex="3" type="text" name="set_charter_hours" id="set_charter_hours'.$widget_type.'" class="form-control enable_tab_charter disable_tab_one_way disable_tab_return" >
                                            <option value="0">'.__('Select Charter Duration','transporters-io').'</option>';
                                            for($i=1; $i<24; $i++){
                                                $html.='<option value="'.$i.'">'.$i.' '. __('Hour'.($i>1?'s':''),'transporters-io').'</option>';//phpcs:ignore
                                            }
                                            for($i=1; $i<=14; $i++){
                                                $html.='<option value="'.($i*24).'">'.$i.' '. __('Day'.($i>1?'s':''),'transporters-io').'</option>';//phpcs:ignore
                                            }
                                        $html.='</select>
                                    </div>
                                </div>
                            </div>
                        </div>';
                        if($quoteform_mode=='multiquote3'){
                        $html.='<div class="row" id="first_step_journey_row'.$widget_type.'" style="display: none;">
                            <div class="col-xs-12">
                                 <div id="form-group-journeyType_first'.$widget_type.'" class="form-group">
                                    <label for="journeyType">'.__('Journey Type','transporters-io').'</label>
                                    <select name="journeyType" id="journeyType_first'.$widget_type.'" class="form-control"></select>
                                </div>
                            </div>
                        </div>';
                        }
                        $html.='<button tabindex="5" type="submit" id="btn-get-a-quote'.$widget_type.'"
                                class="btn btn-sm btn-block btn-primary" disabled>
                             '.__('Get Quote','transporters-io').'
                        </button>
                    </form>
                </div>
                <div id="panel-quotation-request'.$widget_type.'" class="panel-body" style="display: none;">
                    <div id="alert-quotation-request'.$widget_type.'"></div>
                    <form action="javascript:;" method="post" id="form-quotation-request'.$widget_type.'">
                    	<input type="hidden" name="vehicle_groups" value="'.get_option('ts_vehicle_groups_'.$widget_id).'">
                        <input type="hidden" name="start_map_location_latitude" id="start-map-location-latitude'.$widget_type.'">
                        <input type="hidden" name="start_map_location_longitude" id="start-map-location-longitude'.$widget_type.'">
                        <input type="hidden" name="end_map_location_latitude" id="end-map-location-latitude'.$widget_type.'">
                        <input type="hidden" name="end_map_location_longitude" id="end-map-location-longitude'.$widget_type.'">
						<input type="hidden" name="web_page" id="web_page'.$widget_type.'" value="'.(isset($_SERVER['HTTP_HOST']) || isset($_SERVER['REQUEST_URI']) ? (sanitize_url(wp_unslash($_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI']))) : '').'" >
						<input type="hidden" name="web_referrer" id="web_referrer'.$widget_type.'" value="'.$referer.'">
						<input type="hidden" name="web_keyword" id="web_keyword'.$widget_type.'" value="'.$keyword.'">
						<input type="hidden" name="web_ip_address" id="web_ip_address'.$widget_type.'" value="'.$ip.'" >
						<input type="hidden" name="profile_id" id="profile_id'.$widget_type.'" value="'.(get_option('transporters_profile_id_'.$widget_id) ? get_option('transporters_profile_id_'.$widget_id) : 0).'">
						<input type="hidden" name="affiliate_id" id="affiliate_id'.$widget_type.'" value="'.$affiliate_id.'">
						<input type="hidden" name="base_distances" id="base_distances'.$widget_type.'" value="">
						<input type="hidden" name="is_wp" value="1" >
						<div class="row">
						<div class="col-md-5">
                        <div class="form-group pickup">
                            <label for="start-map-location">'.__('Confirm start location','transporters-io').'</label>';
			if($fixed == true){
				$html .= '<div class="input-group" style="display: block;">
                                <select name="start_map_location_select" id="select-start-map-location'.$widget_type.'" class="form-control">
                                    <option data-endId="0" value="0">'.__('Select a location','transporters-io').'</option>
                                </select>
                            </div>';
			}
		    $html .= '<div class="input-group input-group-sm" id="start-map-location-box'.$widget_type.'"  '.(($fixed == true)? 'style="display:none;"' : '').'>
                                <input type="text" name="start_map_location" id="start-map-location'.$widget_type.'"
                                       class="form-control is_places_suggest" autocomplete="nothanks" required>
                                <div class="input-group-btn">
                                    <button type="button" id="btn-start-map-location'.$widget_type.'" class="btn btn-primary">
                                        <i class="fa fa-map-marker"></i>
                                    </button>
                                </div>
                            </div>';
			
			$html .= '<div class="form-group" id="viastops2'.$widget_type.'"></div>';
		    $html .= '</div>
					<div class="form-group destination">
						<label for="end-map-location">'.__('Confirm destination','transporters-io').'</label>';
			if($fixed == true){
				$html .= '<div class="input-group" style="display: block;">
                                <select name="end_map_location_select" id="select-end-map-location'.$widget_type.'" class="form-control" >
                                    <option value="0">'.__('Select a location','transporters-io').'</option>
                                </select>
                            </div>';
			}
			$html .= '<div class="input-group input-group-sm" id="end-map-location-box'.$widget_type.'"  '.(($fixed == true)? 'style="display:none;"' : '').'>
                                <input type="text" name="end_map_location" id="end-map-location'.$widget_type.'"
                                       class="form-control is_places_suggest"  required>

                                <div class="input-group-btn">
                                    <button type="button" id="btn-end-map-location'.$widget_type.'" class="btn btn-primary">
                                        <i class="fa fa-map-marker"></i>
                                    </button>
                                </div>
                            </div>';
			
							
             $html .= '</div>
             			 <div id="start-mapdiv-location'.$widget_type.'" class="mapdiv" style="width: 99.8%; height: 200px;">
                                <span style="width: 100%; height: 200px;"></span>
                            </div>

                        <div class="form-group last" id="pickup_date_time_box'.$widget_type.'">
                            <label>'.__('Pickup date & time','transporters-io').'</label>

                            <div class="row">
                                <div class="col-xs-6" id="pickup_date_box'.$widget_type.'">
                                    <div class="form-group last">
                                        <input tabindex="3" type="text" name="pickup_date" id="pickup-date'.$widget_type.'"
                                               class="form-control" 
                                               data-date-start-date="+0d" required>
                                    </div>
                                </div>
                                <div class="col-xs-6" id="pickup_time_box'.$widget_type.'">
                                    <div class="form-group last">
                                        <input tabindex="4" type="text" name="pickup_time" id="pickup-time'.$widget_type.'"
                                               class="form-control" required>
                                    </div>
                                </div>
                            </div>
                            <div class="row return_journey_needed_row'.$widget_type.'" id="return_needed_box'.$widget_type.'">
                                <div class="col-xs-12">
                                    <div class="form-group last">
                                        <div class="checkbox">
                                            <label>
                                                <input type="checkbox" name="return_journey_needed"
                                                       id="return-journey-needed'.$widget_type.'" value="1"'.( (isset($return_notab_active)&&$return_notab_active)?' checked="checked"':'').'>
                                                <span>'.__('Return journey needed?','transporters-io').'</span>
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div id="form-group-return'.$widget_type.'" class="form-group last" style="display: none;">
                            <label for="return-date-time">'.__('Return date & time','transporters-io').'</label>

                            <div class="row">
                                <div class="col-xs-6">
                                    <div class="form-group">
                                        <input tabindex="3" type="text" name="return_date" id="return-date'.$widget_type.'"
                                               class="form-control" 
                                               data-date-start-date="+0d">
                                    </div>
                                </div>
                                <div class="col-xs-6">
                                    <div class="form-group">
                                        <input tabindex="4" type="text" name="return_time" id="return-time'.$widget_type.'"
                                               class="form-control">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row" id="charter_hours_row'.$widget_type.'">
                            <div class="col-xs-12">
                                <div class="form-group">
                                  	<label>'.__('Charter Hours','transporters-io').'</label>
                                    <select tabindex="3" type="text" name="charter_hours" id="charter_hours'.$widget_type.'" class="form-control" >
                                        <option value="0">'.__('Select Charter Duration','transporters-io').'</option>';
                                        for($i=1; $i<=24; $i++){
                                            $html.='<option value="'.$i.'">'.$i.' '. __('Hour'.($i>1?'s':''),'transporters-io').'</option>';//phpcs:ignore
                                        }
                                        for($i=1; $i<=14; $i++){
                                            $html.='<option value="'.($i*24).'">'.$i.' '. __('Day'.($i>1?'s':''),'transporters-io').'</option>';//phpcs:ignore
                                        }
                                    $html.='</select>
                                </div>
                            </div>
                        </div>
                        </div>
                        <div class="col-md-7">
                        <div id="form-group-input'.$widget_type.'" class="form-group last clearfix"></div>
                        <div id="form-group-vehicleType'.$widget_type.'" class="form-group">
                            <label for="vehicleType">
                                '.__('Vehicle Type','transporters-io').'
                                <span style="font-size: 12px; text-transform: uppercase; letter-spacing: 1px; color: #959595; font-weight: 700;">
                                    <small style="font-size: 75%;"></small>
                                </span>
                            </label>
                            <select name="vehicleType" id="vehicleType'.$widget_type.'" class="form-control" required></select>
                        </div>
						<div id="form-group-journeyType'.$widget_type.'" class="form-group" style="display: none;">
							<label for="journeyType">'.__('Journey Type','transporters-io').'</label>
							<select name="journeyType" id="journeyType'.$widget_type.'" class="form-control"></select>
						</div>
						<div class="form-group hidden" id="multi_quote_results'.$widget_type.'">

                        </div>
                        <div id="3_step_final'.$widget_type.'">
		                    <div id="booking_details_box'.$widget_type.'" class="form-group" style="display: none;">
		                        <label id="booking_details_subject'.$widget_type.'" for="booking_details">'.__('Booking details','transporters-io').'</label>
		                        <textarea name="booking_details" id="booking_details'.$widget_type.'" cols="30" rows="3" class="form-control"></textarea>
		                    </div>
		                    <div class="form-group" id="contact_name_box'.$widget_type.'">
		                        <label for="contact-name">'.__('Contact name','transporters-io').'</label>
		                        <input type="text" name="contact_name" id="contact-name'.$widget_type.'" class="form-control" required>
		                    </div>
		                    <div class="form-group" id="contact_email_box'.$widget_type.'">
		                        <label for="contact-email">'.__('Contact email','transporters-io').'</label>
		                        <input type="email" name="contact_email" id="contact-email'.$widget_type.'" class="form-control" required>
		                    </div>
		                    <div class="form-group" id="contact_number_box'.$widget_type.'">
		                        <label for="mobile-number">'.__('Mobile number','transporters-io').'</label>
		                        <input type="tel" name="mobile_number" id="mobile-number'.$widget_type.'" class="form-control" required>
		                    </div>';
						
					if(get_option('ts_show_notes_'.$widget_id) == 1){
					$html .= '<div class="form-group" id="notes_box'.$widget_type.'">
		                        <label for="note_message">'.__('Notes','transporters-io').'</label>
								<textarea name="note_message" id="note_message'.$widget_type.'" style="min-height:70px;" class="form-control"></textarea>
		                    </div>';
					}
					$html .= '<a href="#" onclick="jQuery(\'#flight_box'.$widget_type.'\').show();jQuery(this).remove();return false;" id="flight_details_link'.$widget_type.'" style="padding-bottom: 1em; display: none;">
							<span class="fa fa-plane"></span> '.__('Journey to or from an airport?','transporters-io').'</a>
						<div class="panel" id="flight_box'.$widget_type.'" style="border:1px solid #ddd; margin-bottom:1em; display:none;">
						<div class="panel-body">
							<h4 style="margin-top: 0;">'.__('Flight Details','transporters-io').'</h4>
						    <div class="row">
								<div class="col-md-6">
									<label for="flight_details[flight_airline]">'.__('Airline','transporters-io').'</label><br>
									<input type="text" name="flight_details[flight_airline]" class="form-control">
								</div>
								<div class="col-md-6">
									<label for="flight_details[flight_number]">'.__('Flight Number','transporters-io').'</label>
									<input type="text" name="flight_details[flight_number]" id="flight_number'.$widget_type.'" class="form-control">
								</div>
							</div>
							<div class="row">
								<div class="col-md-4">
									<label for="flight_direction_in'.$widget_type.'" title="'.__('Picking you up from the airport','transporters-io').'">'.__('Pick up','transporters-io').'</label><br>
									<input type="radio" id="flight_direction_in'.$widget_type.'" name="flight_details[flight_direction]" value="in"  >
								</div>
								<div class="col-md-4">
									<label for="flight_direction_out'.$widget_type.'" title="'.__('Dropping you off at the airport','transporters-io').'">'.__('Drop off','transporters-io').'</label><br>
									<input type="radio" id="flight_direction_out'.$widget_type.'" name="flight_details[flight_direction]" value="out"  >
								</div>
							</div>
							<div class="row">
								<div class="col-md-6">
									<label for="flight_details[flight_depart_date]" class="depart_label">'.__('Flight Departure','transporters-io').' </label>
									<input type="text" name="flight_details[flight_depart_date]" id="flight_depart_date'.$widget_type.'" class="form-control flightdate" >
								</div>
								<div class="col-md-6">
									<label for="flight_details[flight_depart_time]" class="depart_label">'.__('Time','transporters-io').'</label>
									<input type="text" name="flight_details[flight_depart_time]" id="flight_depart_time'.$widget_type.'" class="form-control flighttime">
								</div>
							</div>
							<div class="row">
								<div class="col-md-6">
									<label for="flight_details[flight_arrive_date]" class="arrive_label">'.__('Flight Arrival','transporters-io').' </label>
									<input type="text" name="flight_details[flight_arrive_date]" id="flight_arrive_date'.$widget_type.'" class="form-control flightdate">
								</div>
								<div class="col-md-6">
									<label for="flight_details[flight_arrive_time]" class="arrive_label">'.__('Time','transporters-io').'</label>
							    	<input type="text" name="flight_details[flight_arrive_time]" id="flight_arrive_time'.$widget_type.'" class="form-control flighttime">
								</div>
							</div>
							</div></div>';	
						
              $html .= '</div>
              			</div>
              			</div>
              			<div class="row final-buttons-row">
                            <div class="col-xs-4">
                                <button type="button" id="btn-back-get-quote'.$widget_type.'" class="btn btn-sm btn-block btn-primary">
                                    <i class="fa fa-reply"></i>
                                    <span class="hidden-xs hidden-sm">'.__('Back','transporters-io').'</span>
                                </button>
                            </div>
                            <div class="col-xs-8">
                                <button type="submit" id="btn-quotation-request'.$widget_type.'"
                                        class="btn btn-sm btn-block btn-primary" disabled>
                                    '.__('Get Quote','transporters-io').'
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
                <div id="panel-thank-you'.$widget_type.'" class="panel-body" style="display: none;">
                    <div id="alert-thank-you'.$widget_type.'"></div>
                    <form action="javascript:;" method="post" id="form-thank-you'.$widget_type.'">
                        <!--<input type="hidden" name="transport_distance" id="transport-distance'.$widget_type.'">-->
                        <!--<input type="hidden" name="transport_duration" id="transport-duration'.$widget_type.'">-->
                        <!--<input type="hidden" name="return_distance" id="return-distance'.$widget_type.'">-->
                        <!--<input type="hidden" name="return_duration" id="return-duration'.$widget_type.'">-->
                    </form>
                    <div class="row">
                        <div id="html_quote_form_confirmation'.$widget_type.'" class="col-md-12">
                            <p>'.__('Thank you for your request for a quote.','transporters-io').'</p>
                        </div>
                    </div>
                </div>
            </div>';
			
		if(get_option('transporters_url_site_'.$widget_id) == ''){
			$html = '<p>'.__('Please input URL Site.','transporters-io').'</p>';
		}

		return $html;
}
