var START_MAPDIV;
var START_MAPDIV_MARKER;
var START_MAPDIV_LATLNG;
var END_MAPDIV_MARKER;
var END_MAPDIV_LATLNG;
var RESTRICT_TO_COUNTRY = true;
var straightLineRoute;
var MAP_REFOCUS_RUNNING=false;
var resize_only = false;
var siteURLs=[];
var directionsRenderer;

var distances_loaded = false;
var allBaseLocations = false;
var base_distances = {};
var intDateFormat = 'dd-mm-yyyy';
var intDateFormatCaps = 'DD-MM-YYYY';
var tzformatam = 'H:mm';
var collect_flight_details = 0;

function gm_authFailure() {
	console.log('A google maps authentication error occured, please see https://helpdesk.transporters.io/getting-started/setting-up-maps-or-fixing-recent-maps-issues');
	maps_active = false;
	setTimeout(function(){
		jQuery(".gm-err-autocomplete").attr('disabled', false).removeClass('gm-err-autocomplete').css('background-image','none').attr('placeholder', '');
		jQuery(".is_places_suggest").each(function(){google.maps.event.clearInstanceListeners(jQuery(this)[0]);});

		
	},150);
}

jQuery.validator.addMethod('notEqual', function(value, element, param) {
	return this.optional(element) || value != param;
}, 'This field is required.');

function getQuoteForm(siteURL, widget_id, widget_type, fixed) {
    if(ampm_active){
        tzformatam = 'H:mm A'
    }
	siteURLs[widget_type] = siteURL;
    jQuery.ajax({
        url: siteURLs[widget_type] + 'api/v1/quote-form',
        jsonp: 'callback',
        data: {
            format: 'json',
        	fixed: fixed
        },
        success: function(response) {
            if (response.result == 'OK') {
                if (typeof response.templates.html_quote_form_confirmation !== 'undefined') {
                    jQuery('#html_quote_form_confirmation' + widget_type).html(response.templates.html_quote_form_confirmation);
                }
                if (typeof response.templates.booking_details_box !== 'undefined' && response.templates.booking_details_box == true) {
                    jQuery('#booking_details_box' + widget_type).show();
                }
                if (typeof response.templates.booking_details_box_description !== 'undefined') {
                    jQuery('#booking_details_subject' + widget_type).html(response.templates.booking_details_box_description);
                    //jQuery('textarea[name="booking_details"]').attr('placeholder', response.templates.booking_details_box_description);
                }

                jQuery.region = response.region;
                jQuery.country = response.country;
                if(response.country == "United States of America"){
                    intDateFormat = 'mm/dd/yyyy';
                    intDateFormatCaps = 'MM/DD/YYYY';
                }
                
                jQuery('#panel-quote-form' + widget_type).fadeIn();
                
                if(jQuery('#panel-quote-form' + widget_type).width() > 768){
                	jQuery('#panel-quote-form' + widget_type).addClass("wide");
                }else if(jQuery('#panel-quote-form' + widget_type).width() < 500){
                	jQuery('#panel-quote-form' + widget_type).addClass("small");
                }

                if(fixed){
                
                	if(response.startLocation !== 'undefined'){
						var startLocation = response.startLocation;
						if(startLocation.length > 0){
							var select_html = '<option data-id=\"0\" value=\"0\">Select a location</option>';
							for(var i=0;i<startLocation.length;i++){
								select_html += '<option data-endId=\"'+startLocation[i].end_id+'\" data-latitude=\"'+startLocation[i].latitude+'\" data-longitude=\"'+startLocation[i].longitude+'\" >'+startLocation[i].name+'</option>';
								
							}
							if(fixed_route_custom == 1 || fixed_route_custom == 3){
							    select_html += '<option data-id=\"custom\">Custom</option>';
							}
							jQuery('#select-start-location'+widget_type).html(select_html);
							jQuery('#select-start-map-location'+widget_type).html(select_html);
						}
					}
				
					if(response.endLocation !== 'undefined'){
						var endLocation = response.endLocation;
						if(endLocation.length > 0){
							var select_html = '<option data-endId=\"0\" value=\"0\">Select a location</option>';
							for(var i=0;i<endLocation.length;i++){
								select_html += '<option data-id=\"'+endLocation[i].id+'\" data-startid=\",'+endLocation[i].start_id+',\" data-latitude=\"'+endLocation[i].latitude+'\" data-longitude=\"'+endLocation[i].longitude+'\" >'+endLocation[i].name+'</option>';
							}
							if(fixed_route_custom == 2 || fixed_route_custom == 3){
							    select_html += '<option data-id=\"custom\">Custom</option>';
							}
							jQuery('#select-end-location'+widget_type).html(select_html);
							jQuery('#select-end-map-location'+widget_type).html(select_html);
						}
					}
				
                	jQuery('#select-start-location'+widget_type).on('change',function(){
                	    if(jQuery(this).find(':selected').data('latitude')){
						    jQuery('#start-map-location-latitude' + widget_type).val(jQuery(this).find(':selected').data('latitude'));
						    jQuery('#start-map-location-longitude' + widget_type).val(jQuery(this).find(':selected').data('longitude'));
						}

						jQuery('#select-end-location'+widget_type+' option').hide();
						jQuery('#start-location'+widget_type).hide();
						jQuery('#start-location'+widget_type).val(jQuery('#select-start-location'+widget_type+' option:selected').html());
						jQuery('#start-map-location'+widget_type).val(jQuery('#select-start-location'+widget_type+' option:selected').html());
						jQuery('#start-map-location-box'+widget_type).hide();
						var endid = jQuery(this).find(':selected').data('endid');
						if(jQuery(this).find(':selected').data('id') == 'custom'){
						    jQuery('#start-location'+widget_type).show();
						    jQuery('#start-location'+widget_type).val('');
						    jQuery('#start-map-location'+widget_type).val('');
						    jQuery('#start-map-location-box'+widget_type).show();
						}else if(endid.toString().indexOf(',') !== -1){
							cut_endid = endid.split(',');
							for(var i=0;i < cut_endid.length;i++){
								if(cut_endid[i]){
                                    jQuery('#select-end-location'+widget_type+' option[data-startid*=",' + cut_endid[i] + ',"]').show();
                                }
							}
							jQuery('#select-end-location'+widget_type+' option[value=0]').show();
							if(cut_endid.indexOf(jQuery('#select-end-location'+widget_type).find(':selected').data('id')) == -1 && jQuery('#select-end-location'+widget_type).find(':selected').data('id') != 0){
								jQuery('#select-end-location'+widget_type).val(0);
								jQuery('#end-map-location-latitude' + widget_type).val(0);
								jQuery('#end-map-location-longitude' + widget_type).val(0);
							}
						}else{
							jQuery('#select-end-location'+widget_type+' option[data-startid*=",' + endid + ',"]').show();
							jQuery('#select-end-location'+widget_type+' option[value=0]').show();
							if(jQuery('#select-end-location'+widget_type).find(':selected').data('id') != endid && jQuery('#select-end-location'+widget_type).find(':selected').data('id') != 0){
								jQuery('#select-end-location'+widget_type).val(0);
								jQuery('#end-map-location-latitude' + widget_type).val(0);
								jQuery('#end-map-location-longitude' + widget_type).val(0);
							}
						}
						jQuery('#select-end-location'+widget_type+' option[data-id=0]').show();
					    jQuery('#select-end-location'+widget_type+' option[data-id=custom]').show();
					});

					jQuery('#select-end-location'+widget_type).on('change',function(){
						
						jQuery('#end-location'+widget_type).hide();
						jQuery('#end-map-location-box'+widget_type).hide();
						jQuery('#end-location'+widget_type).val(jQuery('#select-end-location'+widget_type+' option:selected').html());
						jQuery('#end-map-location'+widget_type).val(jQuery('#select-end-location'+widget_type+' option:selected').html());
						
						if(jQuery(this).find(':selected').data('id') == 'custom'){
						    jQuery('#end-location'+widget_type).show();
						    jQuery('#end-map-location-box'+widget_type).show();
						    jQuery('#end-location'+widget_type).val('');
						    jQuery('#end-map-location'+widget_type).val('');
						}else{
						    if(jQuery(this).find(':selected').data('latitude') && jQuery(this).find(':selected').data('longitude')){
							    jQuery('#end-map-location-latitude' + widget_type).val(jQuery(this).find(':selected').data('latitude'));
							    jQuery('#end-map-location-longitude' + widget_type).val(jQuery(this).find(':selected').data('longitude'));
						    }else{
							    jQuery('#end-map-location-latitude' + widget_type).val(0);
							    jQuery('#end-map-location-longitude' + widget_type).val(0);
						    }
						}
					});

                }
                if(maps_active){
                
                	if(RESTRICT_TO_COUNTRY){
                		var START_AUTOCOMPLETE = new google.maps.places.Autocomplete(document.getElementById('start-location' + widget_type), {
		                    componentRestrictions: {
		                        country: jQuery.region
		                    }
		                });
                	}else{
                		var START_AUTOCOMPLETE = new google.maps.places.Autocomplete(document.getElementById('start-location' + widget_type));
                	}
                	

	                START_AUTOCOMPLETE.addListener('place_changed', function() {
	                    var place = START_AUTOCOMPLETE.getPlace();
	                    if (!place || !place.geometry) {
	                        console.log("Autocomplete's returned place contains no geometry");
	                        return;
	                    }

	                    jQuery('#start-map-location-latitude' + widget_type).val(place.geometry.location.lat());
	                    jQuery('#start-map-location-longitude' + widget_type).val(place.geometry.location.lng());
	                });
	                if(RESTRICT_TO_COUNTRY){
		                var END_AUTOCOMPLETE = new google.maps.places.Autocomplete(document.getElementById('end-location' + widget_type), {
		                    componentRestrictions: {
		                        country: jQuery.region
		                    }
		                });
		            }else{
		            	var END_AUTOCOMPLETE = new google.maps.places.Autocomplete(document.getElementById('end-location' + widget_type));
		            }

	                END_AUTOCOMPLETE.addListener('place_changed', function() {
	                    var place = END_AUTOCOMPLETE.getPlace();
	                    if (!place || !place.geometry) {
	                        console.log("Autocomplete's returned place contains no geometry");
	                        return;
	                    }

	                    jQuery('#end-map-location-latitude' + widget_type).val(place.geometry.location.lat());
	                    jQuery('#end-map-location-longitude' + widget_type).val(place.geometry.location.lng());
	                });
                }
                

                jQuery('#start-date' + widget_type).attr('readonly', true).css('background-color', '#FFFFFF');
                jQuery('#start-date' + widget_type).tiodatepicker({
                    orientation: 'left',
                    autoclose: true,
                    format: intDateFormat,
                    ignoreReadonly: true
                }).on('changeDate', function() {
                    jQuery('#form-get-a-quote' + widget_type).valid();
                });
                jQuery('#start-time' + widget_type).attr('readonly', true).css('background-color', '#FFFFFF');
                jQuery('#start-time' + widget_type).tiotimepicker({
                    minuteStep: 5,
                    showMeridian: ampm_active,
                    defaultTime: ['12', '00'].join(':'),
                    ignoreReadonly: true
                }).on('hide.tiotimepicker', function(e) {
                    var value = e.time.minutes % 5;
                    if (value != 0) {
                        jQuery('#start-time' + widget_type).tiotimepicker('setTime', [e.time.hours, e.time.minutes - value].join(':'));
                    }
                });

                jQuery('#return-date-first' + widget_type).attr('readonly', true).css('background-color', '#FFFFFF');
                jQuery('#return-date-first' + widget_type).tiodatepicker({
                    orientation: 'left',
                    autoclose: true,
                    format: intDateFormat,
                    ignoreReadonly: true
                }).on('changeDate', function() {
                    jQuery('#form-get-a-quote' + widget_type).valid();
                });
                jQuery('#return-time-first' + widget_type).attr('readonly', true).css('background-color', '#FFFFFF');
                jQuery('#return-time-first' + widget_type).tiotimepicker({
                    minuteStep: 5,
                    showMeridian: ampm_active,
                    defaultTime: ['12', '00'].join(':'),
                    ignoreReadonly: true
                }).on('hide.tiotimepicker', function(e) {
                    var value = e.time.minutes % 5;
                    if (value != 0) {
                        jQuery('#return-time-first' + widget_type).tiotimepicker('setTime', [e.time.hours, e.time.minutes - value].join(':'));
                    }
                });
                
                
                if(jQuery("#quoteform_mode"+ widget_type).val() == 'multiquote3'){
                	jQuery("#3_step_final"+ widget_type).hide();
					jQuery("#form-group-vehicleType"+ widget_type).hide();
					jQuery("#form-group-journeyType"+ widget_type).hide();
					jQuery("#btn-quotation-request"+ widget_type).hide();
					
					if (typeof response.journeyType !== 'undefined' && response.journeyType.length > 0) {
						jQuery('#first_step_journey_row'+ widget_type).show();
						jQuery('#journeyType_first'+ widget_type).children().remove();
						jQuery('#journeyType_first'+ widget_type).append(jQuery('<option>', {
							value: '',
							text: 'Select journey type',
							disabled: true,
							selected: true,
							'class': 'disabled'
						}));
						jQuery.each(response.journeyType, function (index, value) {
							jQuery('#journeyType_first'+ widget_type).append(jQuery('<option>', value));
						});
					}
					jQuery("body").on("click", ".multiquote-button", function(){
					    if(jQuery(this).hasClass('priced')){
					        jQuery("#btn-quotation-request"+widget_type).html(book_now_text);
					    }else{
					        jQuery("#btn-quotation-request"+widget_type).html(get_quote_text);
					    }
						console.log('book');
						jQuery("#vehicleType"+ widget_type).val(jQuery(this).attr("data-id"));
						jQuery("#3_step_final"+ widget_type).show();
						jQuery("#btn-quotation-request"+ widget_type).show();
						jQuery("#multi_quote_results"+ widget_type).hide();
						jQuery("#form-group-input"+ widget_type).hide();
						return false;
					});
                }
                
                
                jQuery('#form-get-a-quote' + widget_type).validate({
                    onclick: true,
                    errorElement: 'span',
                    errorClass: 'help-block help-block-error',
                    focusInvalid: false,
                    ignore: '',
                    rules: {
                        start_location: {
                            required: true,
                            notEqual: 0
                        },
                        end_location: {
                            required: true,
                            notEqual: 0
                        },
                        start_date: {
                            required: true
                        },
                        start_time: {
                            required: true
                        }
                    },
                    messages: {
                        start_location: 'This field is required.',
                        end_location: 'This field is required.',
                        start_date: 'This field is required.',
                        start_time: 'This field is required.'

                    },
                    highlight: function(element) {
                        jQuery(element).closest('.form-group').addClass('has-error');
                    },
                    unhighlight: function(element) {
                        jQuery(element).closest('.form-group').removeClass('has-error');
                    },
                    success: function(label) {
                        label.closest('.form-group').removeClass('has-error');
                    },
                    errorPlacement: function(error, element) {
                        error.insertAfter(jQuery(element));
                    },
                    submitHandler: function() {
                        var form = jQuery('#form-get-a-quote' + widget_type);
                        var element = form.closest('.panel-body');
                        jQuery.ajax({
                            url: siteURLs[widget_type] + 'api/v1/quote-form/token',
                            type: 'POST',
                            data: form.serialize(),
                            beforeSend: function(xhr) {
                                element.block({
                                    message: '<i class="fa fa-spinner fa-pulse"></i>',
                                    css: {
                                        border: 'inherit !important',
                                        backgroundColor: 'inherit !important'
                                    }
                                });

   
                                if (jQuery('#start-map-location-latitude' + widget_type).val().trim() &&
                                    jQuery('#start-map-location-longitude' + widget_type).val().trim()) {
                                    /*already set*/
                                } else if (jQuery('#start-location' + widget_type).val().trim() || jQuery('#select-start-location' + widget_type).val().trim()) {
                                    if(fixed){
                                    	var value = jQuery('#select-start-location' + widget_type).val();
                                    }else{
                                    	var value = jQuery('#start-location' + widget_type).val();
                                    }
                                    
                                    if (value.indexOf(jQuery.country) == -1) {
                                        value = [value, jQuery.country].join(', ');
                                    }
									if(maps_active){
		                                var geocoder = new google.maps.Geocoder();
		                                geocoder.geocode({
		                                    address: value,
		                                    region: jQuery.region
		                                }, function(result, format) {
		                                    if (format == 'OK') {
		                                        jQuery('#start-map-location-latitude' + widget_type).val(result[0].geometry.location.lat());
		                                        jQuery('#start-map-location-longitude' + widget_type).val(result[0].geometry.location.lng());
		                                    }
		                                });
                                    }
                                }

                                if (jQuery('#end-map-location-latitude' + widget_type).val().trim() && jQuery('#end-map-location-longitude' + widget_type).val().trim()) {
                                    /*already set*/
                                } else if (jQuery('#end-location' + widget_type).val().trim() || jQuery('#select-end-location' + widget_type).val().trim()) {
                                	if(fixed){
                                    	var value = jQuery('#select-end-location' + widget_type).val();
                                    }else{
                                    	var value = jQuery('#end-location' + widget_type).val();
                                    }

                                    
                                    if (value.indexOf(jQuery.country) == -1) {
                                        value = [value, jQuery.country].join(', ');
                                    }
									if(maps_active){
		                                var geocoder = new google.maps.Geocoder();
		                                geocoder.geocode({
		                                    address: value,
		                                    region: jQuery.region
		                                }, function(result, format) {
		                                    if (format == 'OK') {
		                                        jQuery('#end-map-location-latitude' + widget_type).val(result[0].geometry.location.lat());
		                                        jQuery('#end-map-location-longitude' + widget_type).val(result[0].geometry.location.lng());
		                                    }
		                                });
                                    }
                                }

                            }
                        }).done(function(data, textStatus, jqXHR) {
			   collect_flight_details = data.collect_flight_details;
                           if(typeof data.collect_flight_details != 'undefined'){
                              if(data.collect_flight_details == 1){
                                  jQuery('#flight_details_link' + widget_type).css('display', 'block');
                              }else if(data.collect_flight_details == 2){
                                 jQuery('#flight_details_link' + widget_type).click();
                              }
                              
                                jQuery('.flightdate').tiodatepicker({
		                            format: 'dd/mm/yyyy',
		                            autoclose: true,
		                            orientation: 'auto'
	                            });
	                            jQuery('.flighttime').tiotimepicker({
		                            minuteStep: 5,
		                            showMeridian: false,
		                            defaultTime: ['00', '00'].join(':')
	                            });
                           }
                            jQuery.ajax({
                                url: transporters_ajax_object.ajax_url,
                                data: {
                                    action: 'get_stage',
                                    stage: 'after1',
                                    widget_id: widget_id
                                },
                                success: function(result) {
                                    jQuery('body').append(result);
                                }
                            });
                            element.fadeOut(function() {
                                jQuery('#panel-quotation-request' + widget_type).fadeIn(function() {

                                	if(fixed){
                                		// START MAP
										jQuery('#select-start-map-location'+widget_type).val(jQuery('#select-start-location'+widget_type).val());

										jQuery('#select-start-map-location'+widget_type).on('change focusout', function () {
                                            if(jQuery(this).find(':selected').data('latitude')){
											    jQuery('#start-map-location-latitude'+widget_type).val(jQuery(this).find(':selected').data('latitude'));
											    jQuery('#start-map-location-longitude'+widget_type).val(jQuery(this).find(':selected').data('longitude'));
											}
																						
											jQuery('#start-map-location'+widget_type).val(jQuery('#select-start-map-location'+widget_type+' option:selected').html());
                                            jQuery('#start-location'+widget_type).hide();
											jQuery('#start-map-location-box'+widget_type).hide();
											jQuery('#select-end-map-location'+widget_type+' option').hide();
											var endid = jQuery(this).find(':selected').data('endid');
											if(jQuery(this).find(':selected').data('id') == 'custom'){
											    jQuery('#start-location'+widget_type).show();
											    jQuery('#start-map-location-box'+widget_type).show();
											    jQuery('#start-map-location'+widget_type).val('');
											}else if(endid.toString().indexOf(',') !== -1){
												cut_endid = endid.split(',');
												for(var i=0;i < cut_endid.length;i++){
													if(cut_endid[i]){
                                                        jQuery('#select-end-map-location'+widget_type+' option[data-startid*=",' + cut_endid[i] + ',"]').show();
                                                    }
												}
												jQuery('#select-end-map-location'+widget_type+' option[value=0]').show();
												if(cut_endid.indexOf(jQuery('#select-end-map-location'+widget_type).find(':selected').data('id')) == -1 && jQuery('#select-end-map-location'+widget_type).find(':selected').data('id') != 0){
													jQuery('#select-end-map-location'+widget_type).val(0);
													jQuery('#end-map-location-latitude'+widget_type).val(0);
													jQuery('#end-map-location-longitude'+widget_type).val(0);
												}
											}else{
												jQuery('#select-end-map-location'+widget_type+' option[data-startid*=",' + endid + ',"]').show();

												jQuery('#select-end-map-location'+widget_type+' option[value=0]').show();
												if(jQuery('#select-end-map-location'+widget_type).find(':selected').data('id') != endid && jQuery('#select-end-map-location'+widget_type).find(':selected').data('id') != 0){
													jQuery('#select-end-map-location'+widget_type).val(0);
													jQuery('#end-map-location-latitude'+widget_type).val(0);
													jQuery('#end-map-location-longitude'+widget_type).val(0);
												}
											}
											jQuery('#select-end-map-location'+widget_type+' option[data-id=0]').show();
                                            jQuery('#select-end-map-location'+widget_type+' option[data-id=custom]').show();

										});

										jQuery('#select-end-map-location'+widget_type+' option').hide();
										var endid = jQuery('#select-start-location'+widget_type).find(':selected').data('endid');
										if(jQuery('#select-start-location'+widget_type).find(':selected').data('id') == 'custom'){
										
										}else if(endid.toString().indexOf(',') !== -1){
											cut_endid = endid.split(',');
											for(var i=0;i < cut_endid.length;i++){
												jQuery('#select-end-map-location'+widget_type+' option[data-id=",' + cut_endid[i] + ',"]').show();
											}
										}else{
											jQuery('#select-end-map-location'+widget_type+' option[data-id=",' + endid + ',"]').show();
										}
										jQuery('#select-end-map-location'+widget_type+' option[data-id=0]').show();

										jQuery('#select-end-map-location'+widget_type).val(jQuery('#select-end-location'+widget_type).val());

										jQuery('#select-end-map-location'+widget_type).on('change focusout', function () {
                                            if(jQuery(this).find(':selected').data('latitude')){
											    jQuery('#end-map-location-latitude'+widget_type).val(jQuery(this).find(':selected').data('latitude'));
											    jQuery('#end-map-location-longitude'+widget_type).val(jQuery(this).find(':selected').data('longitude'));
											}
											jQuery('#end-map-location'+widget_type).val(jQuery('#select-end-map-location'+widget_type+' option:selected').html());
										});
										jQuery('#start-mapdiv-location'+widget_type).hide();
										
										if(jQuery('#select-start-location' + widget_type).find(':selected').data('id') == 'custom' || jQuery('#select-end-location' + widget_type).find(':selected').data('id') == 'custom'){
										    jQuery('#start-mapdiv-location'+widget_type).show();
											jQuery('#end-map-location'+widget_type).val('');
										    loadMaps(widget_type);
										}
                                	}else{
                                		loadMaps(widget_type);
                                	}
                                    

                                    var tz = moment([jQuery('#start-date' + widget_type).val(), jQuery('#start-time' + widget_type).val()].join(' '), intDateFormatCaps+' '+tzformatam);
                                    tz.format(intDateFormatCaps);
                                    tz.format(tzformatam);
                                    jQuery('#pickup-date' + widget_type).val(tz.format(intDateFormatCaps));
                                    jQuery('#pickup-date' + widget_type).attr('readonly', true).css('background-color', '#FFFFFF');
                                    jQuery('#pickup-date' + widget_type).tiodatepicker({
                                        orientation: 'left',
                                        autoclose: true,
                                        format: intDateFormat,
                                        ignoreReadonly: true
                                    }).on('changeDate', function() {
                                        if (jQuery('#return-journey-needed' + widget_type).prop('checked')) {
                                            var tz = moment([jQuery('#pickup-date' + widget_type).val(), jQuery('#pickup-time' + widget_type).val()].join(' '), intDateFormatCaps+' '+tzformatam);
                                            if (tz.isAfter(moment([jQuery('#return-date' + widget_type).val(), jQuery('#return-time' + widget_type).val()].join(' '), intDateFormatCaps+' '+tzformatam))) {
                                                jQuery('#return-date' + widget_type).tiodatepicker('update', tz.format(intDateFormatCaps));
                                                jQuery('#return-time' + widget_type).tiotimepicker('setTime', tz.format(tzformatam));
                                            } 
                                        }

                                        jQuery('#form-quotation-request' + widget_type).valid();
                                        loadMultiQuotes(widget_type);
                                    });
                                    jQuery('#pickup-time' + widget_type).attr('readonly', true).css('background-color', '#FFFFFF');
                                    
                                    jQuery('#pickup-time' + widget_type).tiotimepicker({
                                        minuteStep: 5,
                                        showMeridian: ampm_active,
                                        defaultTime: tz.format(tzformatam),
                                        ignoreReadonly: true
                                    }).on('hide.tiotimepicker', function(e) {
                                        jQuery('#pickup-date' + widget_type).trigger('changeDate');

                                        var value = e.time.minutes % 5;
                                        if (value != 0) {
                                            jQuery('#pickup-time' + widget_type).tiotimepicker('setTime', [e.time.hours, e.time.minutes - value].join(':'));
                                        }
                                    });
                                    
									if(jQuery('#return-date-first' + widget_type).val()!='' && typeof jQuery('#return-date-first' + widget_type+":enabled").val() != 'undefined'){
										console.log('has_return date');
										var tz = moment([jQuery('#return-date-first' + widget_type).val(), jQuery('#return-time-first'+ widget_type).val()].join(' '), intDateFormatCaps+' '+tzformatam);
                                        loadReturnDatePicker(tz, widget_type);

                                       	jQuery('#form-group-return' + widget_type).slideDown();
										jQuery('#return-journey-needed' + widget_type).prop("checked", true);
                                    	jQuery('#return-date' + widget_type).prop('disabled', false);
                                    	jQuery('#return-time' + widget_type).prop('disabled', false);
									}else if(jQuery('#return_tab_active' + widget_type).val()){
										console.log('get_return date');
										var tz = moment([jQuery('#start-date' + widget_type).val(), jQuery('#start-time' + widget_type).val()].join(' '), intDateFormatCaps+' '+tzformatam);
                                        loadReturnDatePicker(tz, widget_type);
                                        
                                        jQuery('#form-group-return' + widget_type).slideDown();
                                    	jQuery('#return-journey-needed' + widget_type).prop("checked", true);
                                    	jQuery('#return-date' + widget_type).prop('disabled', false);
                                    	jQuery('#return-time' + widget_type).prop('disabled', false);
                                    }else{
                                    	console.log('no_return date');
                                    	jQuery('#return-journey-needed' + widget_type).prop("checked", false);
                                    	jQuery('#form-group-return' + widget_type).slideUp();
                                    	jQuery('#return-date' + widget_type).prop('disabled', true);
                                    	jQuery('#return-time' + widget_type).prop('disabled', true);
                                    }
																		
                                    jQuery('#return-journey-needed' + widget_type).on('click', function() {

                                        if (jQuery(this).prop('checked')) {
                                        	var tz = moment([jQuery('#pickup-date' + widget_type).val(), jQuery('#pickup-time' + widget_type).val()].join(' '), intDateFormatCaps+' '+tzformatam);
                                            loadReturnDatePicker(tz, widget_type);
                                            
											jQuery('#return-date' + widget_type).prop('disabled', false);
                                    		jQuery('#return-time' + widget_type).prop('disabled', false);
                                            jQuery('#form-group-return' + widget_type).slideDown();
                                        } else {
                                        	jQuery('#return-date' + widget_type).prop('disabled', true);
                                    		jQuery('#return-time' + widget_type).prop('disabled', true);
                                            jQuery('#form-group-return' + widget_type).slideUp();
                                        }
                                        loadMultiQuotes(widget_type);
                                    });

                                    //CHARTERS
									if(jQuery("#set_charter_hours"+ widget_type+":enabled").val() > 0){
										jQuery("#charter_hours"+ widget_type).val(jQuery("#set_charter_hours"+ widget_type).val());
										jQuery("#return_needed_box"+ widget_type).hide();
										jQuery("#charter_hours_row"+ widget_type).show();

									}else{
										jQuery("#return_needed_box"+ widget_type).show();
										jQuery("#charter_hours_row"+ widget_type).hide();
									}

                                    jQuery('#form-group-input' + widget_type).children().remove();
                                    jQuery.each(data.input, function(groupName, inputMultiple) {
                                        //console.log(groupName, inputMultiple);
                                        if (typeof inputMultiple != 'undefined' && typeof inputMultiple[0] != 'undefined') {
                                            var append = '<div class="form-horizontal"><h4 id="group-' + inputMultiple[0].group + '" class="no-margin" style="font-size: 12px; text-transform: uppercase; letter-spacing: 1px; color: #959595; font-weight: 700;">' + groupName + '</h4>';
                                            jQuery.each(inputMultiple, function(index, value) {
                                                append += '<div class="form-group form-group-sm"><label for="input-field-' + value.type + '" class="col-xs-5 control-label">' + value.name + '</label><div class="col-xs-7"><input data-group="' + value.group + '" data-min="' + value.min + '" data-max="' + value.count + '" data-type="' + value.type + '" data-rate="' + value.rate + '" type="text" name="input[' + value.type + ']" id="input-' + value.type + widget_type + '" class="form-control input" value="0"></div></div>';
                                            });
                                            append += '</div>';
                                            jQuery('#form-group-input' + widget_type).append(append);
                                        }
                                    });
                                    jQuery.each(data.max, function(groupSlug, maxRate) {
                                        jQuery.each(data.input, function(groupName, inputMultiple) {
                                            jQuery.each(inputMultiple, function(index, value) {
                                                var element = jQuery('input[data-type="' + value.type + '"]');
                                                if (typeof element != 'undefined' && element.data('group') == groupSlug) {
                                                    var inputRate = parseFloat(element.data('rate'));
                                                    if (isNaN(inputRate)) inputRate = 0;
                                                    element.attr('data-max', maxRate / inputRate);
                                                }
                                            });
                                        });
                                    });
                                    allBaseLocations = data.allBaseLocations;
                                    jQuery('#vehicleType' + widget_type).children().remove();
                                    jQuery('#vehicleType' + widget_type).append(jQuery('<option>', {
                                        value: '',
                                        text: 'Select vehicle type',
                                        disabled: true,
                                        selected: true,
                                        'class': 'disabled'
                                    }));
                                    jQuery.each(data.vehicleType, function(index, value) {
                                        jQuery('#vehicleType' + widget_type).append(jQuery('<option>', value));
                                    });
                                    jQuery('label[for="vehicleType"]').children('span')
                                        .children('small')
                                        .text(' (' + (jQuery('#vehicleType' + widget_type).children().length - jQuery('#vehicleType' + widget_type).children('.disabled, .hide').length) + ')');

                                    if (typeof data.journeyType !== 'undefined' && data.journeyType.length > 0) {
                                        jQuery('#journeyType' + widget_type).children().remove();
                                        jQuery('#journeyType' + widget_type).append(jQuery('<option>', {
                                            value: '',
                                            text: 'Select journey type',
                                            disabled: true,
                                            selected: true,
                                            'class': 'disabled'
                                        }));
                                        jQuery.each(data.journeyType, function(index, value) {
                                            jQuery('#journeyType' + widget_type).append(jQuery('<option>', value));
                                        });
                                        if(jQuery('#journeyType_first' + widget_type).val()>0){
											jQuery('#journeyType' + widget_type).val(jQuery('#journeyType_first').val());
										}
										if(jQuery('#quoteform_mode' + widget_type).val() != 'multiquote3'){
											jQuery('#form-group-journeyType' + widget_type).show();
										}
                                    }


                                    jQuery('.input').TouchSpin({
                                        buttondown_class: 'btn btn-sm btn-primary',
                                        buttonup_class: 'btn btn-sm btn-primary'
                                    });
                                    jQuery('.input').on('change', function() {
                                        jQuery.each(data.max, function(groupSlug, maxRate) {
                                            var number = [];
                                            var amount = 0;
                                            /*jQuery.each(data.input, function(groupName, inputMultiple) {
                                                jQuery.each(inputMultiple, function(index, value) {
                                                    var input = jQuery('input[data-type="' + value.type + '"]');
                                                    if (typeof input != 'undefined' && input.data('group') == groupSlug) {
                                                        var type = parseInt(input.data('type'));
                                                        if (isNaN(type)) type = 0;

                                                        var rate = parseFloat(input.data('rate'));
                                                        if (isNaN(rate)) rate = 0;

                                                        var val = parseInt(input.val());
                                                        if (isNaN(val)) val = 0;

                                                        number[type] = val * rate;
                                                        amount += number[type];
                                                    }
                                                });
                                            });*/
                                            jQuery.each(data.input, function(groupName, inputMultiple) {
                                                jQuery.each(inputMultiple, function(index, value) {
                                                    var input = jQuery('input[data-type="' + value.type + '"]');
                                                    if (typeof input != 'undefined' && input.data('group') == groupSlug) {
                                                        var type = parseInt(input.data('type'));
                                                        if (isNaN(type)) type = 0;

                                                        var rate = parseFloat(input.data('rate'));
                                                        if (isNaN(rate)) rate = 0;

                                                        var val = parseInt(input.val());
                                                        if (isNaN(val)) val = 0;
                                                        
                                                        number[type] = val * rate;
                                                        amount += number[type];

                                                        var fixed = parseFloat((maxRate - amount).toFixed(2));
                                                        var toFixed = parseFloat((fixed / rate).toFixed(2));
                                                        var available = parseInt(toFixed + val);

                                                        input.attr('data-max', available);
                                                        input.trigger("touchspin.updatesettings", {
                                                            max: available
                                                        });
                                                    }
                                                });
                                            });

                                            //var labelSmall = (maxRate - amount);
                                            //jQuery('#group-' + groupSlug).children('small').html(' (' + labelSmall.toFixed(2) + ')');
                                        });
                                        var rules = [];
                                        jQuery.each(data.input, function(groupName, inputMultiple) {
                                            jQuery.each(inputMultiple, function(index, value) {
                                                var input = jQuery('input[data-type="' + value.type + '"]');
                                                if (typeof input != 'undefined') {
                                                    var group = input.data('group');
                                                    if (typeof group != 'undefined') {
                                                        if (typeof rules[group] == 'undefined') {
                                                            rules[group] = 0;
                                                        }

                                                        var rate = input.data('rate');
                                                        if (isNaN(rate)) rate = 0;

                                                        var val = input.val();
                                                        if (isNaN(val)) val = 0;

                                                        rules[group] += val * rate;
                                                    }
                                                }
                                            });
                                        });
                                        var oldVehicle = jQuery('#vehicleType' + widget_type+' option:selected').val();
                                        jQuery('#vehicleType' + widget_type).children().each(function(index, value) {
                                            jQuery(value).removeClass('hide');
                                        });
                                        jQuery('#vehicleType' + widget_type).children().each(function(index, value) {
                                            var input = jQuery(value);
                                            if (typeof input.data() != 'undefined') {
                                                jQuery.each(input.data(), function(key, value) {
                                                    if (rules[key] > value) {
                                                        if (jQuery('#vehicleType' + widget_type).val() == input.val()) {
                                                            jQuery('#vehicleType' + widget_type).val('');
                                                        }
                                                        input.addClass('hide');
                                                    }
                                                });
                                            }
                                        });
                                        var newVehicle = jQuery('#vehicleType' + widget_type+' option:selected').val();
                                        
                                        if(oldVehicle!=newVehicle){
                                        	if(!jQuery("#vehicle_filter_alert").length){
		                                    	jQuery('#form-group-vehicleType' + widget_type).append('<p id="vehicle_filter_alert" style="color:red; font-weight:bold;">The vehicle type you selected is not available with your chosen '+jQuery(this).attr("data-group")+'. Please reselect vehicle.</p>');
		                                    	jQuery("#vehicle_filter_alert").fadeIn(500).delay(4000).fadeOut(500);
		                                    	setTimeout(function() {
													jQuery("#vehicle_filter_alert").remove();
												}, 6000);
											}
                                        }
                                        
                                        
                                        jQuery('label[for="vehicleType"]').children('span')
                                            .children('small')
                                            .text(' (' + (jQuery('#vehicleType' + widget_type).children().length - jQuery('#vehicleType' + widget_type).children('.disabled, .hide').length) + ')');
                                            
                                        loadMultiQuotes(widget_type);
                                    });
                                    if(jQuery("#quoteform_mode"+ widget_type).val() =='multiquote3'){
										jQuery("#multi_quote_results"+ widget_type).show();
										loadMultiQuotes(widget_type);
									}
                                    jQuery('#form-quotation-request' + widget_type).validate({
                                        errorElement: 'span',
                                        errorClass: 'help-block help-block-error',
                                        focusInvalid: false,
                                        ignore: '',
                                        rules: {
                                            start_map_location: {
                                                required: true,
                                                notEqual: 0
                                            },
                                            end_map_location: {
                                                required: true,
                                                notEqual: 0
                                            },
                                            pickup_date: {
                                                required: true
                                            },
                                            pickup_time: {
                                                required: true
                                            },
                                            return_journey_needed: {
                                                required: false,
                                            },
                                            return_date: {
                                                required: false
                                            },
                                            return_time: {
                                                required: false
                                            },
                                            vehicle_type_id: {
                                                required: true
                                            },
                                            contact_name: {
                                                required: true
                                            },
                                            contact_email: {
                                                required: true,
                                                email: true
                                            },
                                            mobile_number: {
                                                required: true
                                            }
                                        },
                                        messages: {
                                            start_map_location: 'This field is required.',
                                            end_map_location: 'This field is required.',
                                            pickup_date: 'This field is required.',
                                            pickup_time: 'This field is required.',
                                            vehicleType: 'This field is required.',
                                            contact_name: 'This field is required.',
                                            contact_email: 'This field is required.',
                                            mobile_number: 'This field is required.'

                                        },
                                        highlight: function(element) {
                                            var input = jQuery(element);
                                            if (input.attr('name') == 'start_map_location' || input.attr('name') == 'end_map_location') {
                                                input.parent().children('.input-group-btn').find('.btn').removeClass('btn-default').addClass('btn-danger');
                                            }
                                            input.closest('.form-group').addClass('has-error');
                                        },
                                        unhighlight: function(element) {
                                            var input = jQuery(element);
                                            if (input.attr('name') == 'start_map_location' || input.attr('name') == 'end_map_location') {
                                                input.parent().children('.input-group-btn').find('.btn').removeClass('btn-danger').addClass('btn-default');
                                            }
                                            input.closest('.form-group').removeClass('has-error');
                                        },
                                        success: function(label) {
                                        console.log('11111');
                                            label.closest('.form-group').removeClass('has-error');
                                        },
                                        errorPlacement: function(error, element) {
                                        console.log('33333');
                                            var input = jQuery(element);
                                            if (input.attr('name') == 'start_map_location' || input.attr('name') == 'end_map_location') {
                                                input.parent().children('.input-group-btn').find('.btn').removeClass('btn-default').addClass('btn-danger');
                                                //error.insertAfter(input.closest('.form-group:visible').children('.mapdiv'));
                                                console.log(input);
                                                console.log(error);
                                                error.insertAfter('#btn-quotation-request' + widget_type);
                                            } else {
                                                error.insertAfter(input);
                                                console.log('22222');
                                            }
                                        },
                                        submitHandler: function() {
                                        console.log('555555');
                                            if (jQuery('#return-journey-needed' + widget_type).attr('checked')) {
                                                if ((jQuery('#pickup-date' + widget_type).val() == jQuery('#return-date' + widget_type).val()) && (jQuery('#pickup-time' + widget_type).val() == jQuery('#return-time' + widget_type).val())) {
                                                    alert('Your return time is the same as outbound time. Please change your return time or unselect the return journey.');
                                                    return;
                                                }
                                            }

                                            jQuery.fn.goToPanelThankYou = function() {
                                                var form = jQuery('#form-quotation-request' + widget_type);
                                                var element = form.closest('.panel-body');
                                                jQuery("#base_distances"+ widget_type).val(JSON.stringify(Object.assign({}, base_distances)));
                                                jQuery.ajax({
                                                    url: siteURLs[widget_type] + 'api/v1/quote-form/store',
                                                    type: 'POST',
                                                    data: jQuery('#form-get-a-quote' + widget_type + ', #form-quotation-request' + widget_type + ', #form-thank-you' + widget_type).serialize(),
                                                    beforeSend: function(xhr) {
                                                        element.block({
                                                            message: '<i class="fa fa-spinner fa-pulse"></i>',
                                                            css: {
                                                                border: 'inherit !important',
                                                                backgroundColor: 'inherit !important'
                                                            }
                                                        });
                                                    }
                                                }).done(function(data, textStatus, jqXHR) {
                                                    if (data.result == 'ok') {
                                                        jQuery.ajax({
                                                            url: transporters_ajax_object.ajax_url,
                                                            data: {
                                                                action: 'get_stage',
                                                                stage: 'after2',
                                                                widget_id: widget_type[widget_type.length-1]
                                                            },
                                                            success: function(result) {
                                                                jQuery('body').append(result);
                                                            }
                                                        });
                                                        element.fadeOut(function() {

                                                            var html_thank_you = jQuery('#html_quote_form_confirmation' + widget_type).html();
                                                            if (typeof data.replacePairs !== 'undefined') {
                                                                jQuery.each(data.replacePairs, function(key, value) {
                                                                	if(key == '[ORDER_ID]' && typeof transportersQuoteCompleteCallback === "function"){
																		transportersQuoteCompleteCallback(widget_type, value);
																	}
                                                                    html_thank_you = html_thank_you.replace(key, value);
                                                                });
                                                            }
                                                            jQuery('#html_quote_form_confirmation' + widget_type).html(html_thank_you);

                                                            jQuery('#panel-thank-you' + widget_type).fadeIn(function() {});
                                                        });
                                                    }
                                                }).fail(function(jqXHR, textStatus, errorThrown) {
                                                    jQuery('#alert-quotation-request' + widget_type).empty();
                                                    if (typeof jqXHR.responseJSON === 'undefined') {
                                                        jqXHR.responseJSON = [
                                                            ['Sorry, Internal Server Error.']
                                                        ];
                                                    }

                                                    jQuery.each(jqXHR.responseJSON, function(key, rules) {
                                                        jQuery.each(rules, function(index, rule) {
                                                            jQuery('#alert-quotation-request' + widget_type).append('<div class="alert alert-danger alert-dismissible" role="alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button><strong>' + rule + '</strong></div>');
                                                        });
                                                        jQuery('#panel-quote-form' + widget_type).get(0).scrollIntoView();
                                                    });
                                                }).always(function() {
                                                    element.unblock();
                                                });
                                            };
                                            if(fixed){
	                                            if(jQuery("#select-start-map-location"+widget_type+" option:selected").attr('data-latitude')){
	                                                jQuery('#start-map-location-latitude' + widget_type).val(jQuery("#select-start-map-location"+widget_type+" option:selected").attr('data-latitude'));
	                                                jQuery('#start-map-location-longitude' + widget_type).val(jQuery("#select-start-map-location"+widget_type+" option:selected").attr('data-longitude'));
	                                            }
	                                            if(jQuery("#select-end-map-location"+widget_type+" option:selected").attr('data-latitude')){
	                                                jQuery('#end-map-location-latitude' + widget_type).val(jQuery("#select-end-map-location"+widget_type+" option:selected").attr('data-latitude'));
	                                                jQuery('#end-map-location-longitude' + widget_type).val(jQuery("#select-end-map-location"+widget_type+" option:selected").attr('data-longitude'));
	                                            }
                                            }
                                            
		                                    jQuery('#form-thank-you' + widget_type).empty();

		                                    getDistances(widget_type);
											waitDistances(function () {
		                                        jQuery(this).goToPanelThankYou();
		                                    });
                                            
                                        }
                                    });
                                    jQuery('#btn-quotation-request' + widget_type).prop('disabled', false)
                                        .on('click', function() {
                                            jQuery('#form-quotation-request' + widget_type).valid();
                                        });
                                    jQuery('#btn-back-get-quote' + widget_type).prop('disabled', false)
                                        .on('click', function() {
                                            jQuery.ajax({
                                                url: transporters_ajax_object.ajax_url,
                                                data: {
                                                    action: 'get_stage',
                                                    stage: 'back',
                                                    widget_id: widget_type[widget_type.length-1]
                                                },
                                                success: function(result) {
                                                    jQuery('body').append(result);
                                                }
                                            });
                                            var element = jQuery(this).closest('.panel-body');
                                            element.block({
                                                message: '<i class="fa fa-spinner fa-pulse"></i>',
                                                css: {
                                                    border: 'inherit !important',
                                                    backgroundColor: 'inherit !important'
                                                }
                                            });
                                            element.unblock().fadeOut(function() {
                                                jQuery('#panel-get-a-quote' + widget_type).fadeIn(function() {
                                                    //
                                                });
                                            });
                                        });
                                });
                            });
                        }).fail(function(jqXHR, textStatus, errorThrown) {
                            jQuery('#alert-get-a-quote' + widget_type).empty();
                            jQuery.each(jqXHR.responseJSON, function(key, rules) {
                                jQuery.each(rules, function(index, rule) {
                                    jQuery('#alert-get-a-quote' + widget_type).append('<div class="alert alert-danger alert-dismissible" role="alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button><strong>' + rule + '</strong></div>');
                                });
                            });
                        }).always(function() {
                            element.unblock();
                        });
                    }
                });
                jQuery('#btn-get-a-quote' + widget_type).prop('disabled', false)
                    .on('click', function() {
                        jQuery('#form-get-a-quote' + widget_type).valid();
                    });
            }else{
            	alert(response);
            }
        }


	});
	jQuery("body").on('change', '#vehicleType' + widget_type, function() {
	    //getDistances(widget_type);
		//do we need this now? or just load on proceed?
	});

    jQuery("body").on('click', '#add_via_stop'+ widget_type, function() {
	    addStopRow(widget_type);
	    return false;
	});

    jQuery(".tabrow .tab").click(function(){
        var tab = jQuery(this).attr('data-tab');
        jQuery(this).parents('.transportersio-quote.panel').find(".tabrow .tab").removeClass('active');
        jQuery(this).addClass('active');
        showTabContents(widget_type);
    });
	showTabContents(widget_type);

}

function showTabContents(widget_type){
	var tab = jQuery("#form-get-a-quote"+widget_type+" .tabrow .tab.active");
	tab.parents('.transportersio-quote.panel').find(".hide_tab_"+tab.attr('data-tab')).addClass('tab_hidden');
   	tab.parents('.transportersio-quote.panel').find(".show_tab_"+tab.attr('data-tab')).removeClass('tab_hidden');

	tab.parents('.transportersio-quote.panel').find(".disable_tab_"+tab.attr('data-tab')).prop("disabled",true);
   	tab.parents('.transportersio-quote.panel').find(".enable_tab_"+tab.attr('data-tab')).prop("disabled",false);
   	
}


var tz = moment().tz('Europe/London');

var disable_geocode_on_places = false;
var via_waypoints = [];
function loadMaps(widget_type) {
	jQuery('#start-map-location' + widget_type).val(jQuery('#start-location' + widget_type).val());
	jQuery('#end-map-location' + widget_type).val(jQuery('#end-location' + widget_type).val());
	jQuery("#viastops2").html('');
	via_waypoints = [];
	if(jQuery(".via_stops_arr").length){
	    jQuery(".via_stops_arr").each(function(i, el){
	        var via_id = jQuery(this).val();
	        var loc = jQuery('#via-location_'+via_id+widget_type).val();
	        var lat = jQuery('#via_latitude_'+via_id+widget_type).val();
	        var lng = jQuery('#via_longitude_'+via_id+widget_type).val();
	        var via_html= '<div>'+via_label+': '+loc;
	        via_html += '<input type="hidden" name="via_stops[]" value="'+via_id+'">';
	        via_html += '<input type="hidden" name="via_loc_'+via_id+'" value="'+loc+'">';
	        via_html += '<input type="hidden" name="via_lat_'+via_id+'" value="'+lat+'">';
	        via_html += '<input type="hidden" name="via_lng_'+via_id+'" value="'+lng+'">';
	        via_html += '</div>';
	        jQuery("#viastops2"+widget_type).append(via_html);
	        via_waypoints.push({
                location: lat+','+lng,
                stopover: false,
             });
	    });
	}
	
	if(!maps_active){ return false;}
    // START MAP
    
    jQuery('#start-map-location' + widget_type).on('change focusout', function() {
        if (!jQuery(this).val().trim()) {
            return;
        }
        if(disable_geocode_on_places){return;}

        var geocoder = new google.maps.Geocoder();
        geocoder.geocode({
            address: jQuery(this).val()//,
            //region: jQuery.region
        }, function(result, format) {
            if (format == 'OK') {
                if (!result[0] || !result[0].geometry) {
                    return;
                }

                START_MAPDIV_MARKER.setPosition(result[0].geometry.location);

                jQuery('#start-map-location-latitude' + widget_type).val(result[0].geometry.location.lat());
                jQuery('#start-map-location-longitude' + widget_type).val(result[0].geometry.location.lng());
				console.log('do route geocode');
                fitAndCenterMapWithRoute(widget_type);
            }
        });
    });


    jQuery('#btn-start-map-location' + widget_type).on('click', function() {
    	
        var getPosition = START_MAPDIV_MARKER.getPosition();
        START_MAPDIV.panTo(getPosition);

        jQuery('#start-map-location-latitude' + widget_type).val(getPosition.lat());
        jQuery('#start-map-location-longitude' + widget_type).val(getPosition.lng());

        var geocoder = new google.maps.Geocoder();
        geocoder.geocode({
            location: getPosition,
            region: jQuery.region
        }, function(result, format) {
            if (format == 'OK') {
                if (!result[0] || !result[0].geometry) {
                    return;
                }

                jQuery('#start-map-location' + widget_type).val(result[0].formatted_address);
                fitAndCenterMapWithRoute(widget_type);
            }
        });
    });
    if(RESTRICT_TO_COUNTRY){
    	var START_MAP_AUTOCOMPLETE = new google.maps.places.Autocomplete(document.getElementById('start-map-location' + widget_type), {
	        componentRestrictions: {
	            country: jQuery.region
	        }
	    });
    }else{
    	var START_MAP_AUTOCOMPLETE = new google.maps.places.Autocomplete(document.getElementById('start-map-location' + widget_type));
    }

    START_MAP_AUTOCOMPLETE.addListener('place_changed', function() {
    	disable_geocode_on_places = true;
        var place = START_MAP_AUTOCOMPLETE.getPlace();
        if (!place || !place.geometry) {
            console.log("Autocomplete's returned place contains no geometry");
            return;
        }

//console.log(place);
//console.log(place.geometry.location.lat());
        //START_MAPDIV.setCenter(place.geometry.location);
        
        START_MAPDIV_MARKER.setPosition(place.geometry.location);
        console.log('do route places');
        fitAndCenterMapWithRoute(widget_type);
    });

    var START_MAPDIV_LATLNG = new google.maps.LatLng(51.498, -0.126);
    if (jQuery('#start-map-location-latitude' + widget_type).val().trim() && jQuery('#start-map-location-longitude' + widget_type).val().trim()) {
        START_MAPDIV_LATLNG = new google.maps.LatLng(jQuery('#start-map-location-latitude' + widget_type).val(), jQuery('#start-map-location-longitude' + widget_type).val());
    }

    START_MAPDIV = new google.maps.Map(document.getElementById('start-mapdiv-location' + widget_type), {
        center: START_MAPDIV_LATLNG,
        zoom: 8,
        mapTypeId: google.maps.MapTypeId.ROADMAP,
        streetViewControl: false
    });
    START_MAPDIV.controls[google.maps.ControlPosition.TOP_RIGHT].push(new FullScreenControl(START_MAPDIV));
    straightLineRoute = new google.maps.Polyline({
		strokeColor: '#FF0000',
		strokeOpacity: 0.7,
		strokeWeight:3,
		map:START_MAPDIV
	});

    START_MAPDIV_MARKER = new google.maps.Marker({
        position: START_MAPDIV_LATLNG,
        map: START_MAPDIV,
        draggable: true,
		icon: 'https://maps.google.com/mapfiles/ms/icons/green-dot.png'
    });
    google.maps.event.addListener(START_MAPDIV_MARKER, 'dragend', function() {
        jQuery('#btn-start-map-location' + widget_type).trigger('click');
    });

    google.maps.event.addDomListener(window, 'resize', function() {
        google.maps.event.trigger(START_MAPDIV, 'resize');
        resize_only = true;
        fitAndCenterMapWithRoute(widget_type);
        resize_only = false;
    });
    directionsRenderer = new google.maps.DirectionsRenderer();
    directionsRenderer.setMap(START_MAPDIV);
    
    jQuery('#end-map-location' + widget_type).on('change focusout', function() {
        if (!jQuery(this).val().trim()) {
            return;
        }
		if(disable_geocode_on_places){return;}
		
        var value = jQuery(this).val();
        if (value.indexOf(jQuery.country) == -1) {
            value = [value, jQuery.country].join(', ');
        }

        var geocoder = new google.maps.Geocoder();
        geocoder.geocode({
            address: value,
            region: jQuery.region
        }, function(result, format) {
            if (format == 'OK') {
                if (!result[0] || !result[0].geometry) {
                    return;
                }

                END_MAPDIV_MARKER.setPosition(result[0].geometry.location);

                jQuery('#end-map-location-latitude' + widget_type).val(result[0].geometry.location.lat());
                jQuery('#end-map-location-longitude' + widget_type).val(result[0].geometry.location.lng());
                fitAndCenterMapWithRoute(widget_type);
            }
        });
    });
    jQuery('#btn-end-map-location' + widget_type).on('click', function() {
        var getPosition = END_MAPDIV_MARKER.getPosition();
        //END_MAPDIV.panTo(getPosition);

        jQuery('#end-map-location-latitude' + widget_type).val(getPosition.lat());
        jQuery('#end-map-location-longitude' + widget_type).val(getPosition.lng());

        var geocoder = new google.maps.Geocoder();
        geocoder.geocode({
            location: getPosition,
            region: jQuery.region
        }, function(result, format) {
            if (format == 'OK') {
                if (!result[0] || !result[0].geometry) {
                    return;
                }

                jQuery('#end-map-location' + widget_type).val(result[0].formatted_address);
                fitAndCenterMapWithRoute(widget_type);
            }
        });
    });
    if(RESTRICT_TO_COUNTRY){
    	var END_MAP_AUTOCOMPLETE = new google.maps.places.Autocomplete(document.getElementById('end-map-location' + widget_type), {
	        componentRestrictions: {
	            country: jQuery.region
	        }
	    });
	}else{
		var END_MAP_AUTOCOMPLETE = new google.maps.places.Autocomplete(document.getElementById('end-map-location' + widget_type));
	}
    END_MAP_AUTOCOMPLETE.addListener('place_changed', function() {
    	disable_geocode_on_places = true;
        var place = END_MAP_AUTOCOMPLETE.getPlace();
        if (!place || !place.geometry) {
            console.log("Autocomplete's returned place contains no geometry");
            return;
        }

        //END_MAPDIV.setCenter(place.geometry.location);
        END_MAPDIV_MARKER.setPosition(place.geometry.location);
        fitAndCenterMapWithRoute(widget_type);
    });

    END_MAPDIV_LATLNG = new google.maps.LatLng(51.498, -0.126);
    if (jQuery('#end-map-location-latitude' + widget_type).val().trim() && jQuery('#end-map-location-longitude' + widget_type).val().trim()) {
        END_MAPDIV_LATLNG = new google.maps.LatLng(jQuery('#end-map-location-latitude' + widget_type).val(), jQuery('#end-map-location-longitude' + widget_type).val());
    }

    /*END_MAPDIV = new google.maps.Map(document.getElementById('end-mapdiv-location' + widget_type), {
        center: END_MAPDIV_LATLNG,
        zoom: 8,
        mapTypeId: google.maps.MapTypeId.ROADMAP,
        streetViewControl: false
    });
    END_MAPDIV.controls[google.maps.ControlPosition.TOP_RIGHT].push(new FullScreenControl(END_MAPDIV));
	*/
    END_MAPDIV_MARKER = new google.maps.Marker({
        position: END_MAPDIV_LATLNG,
        map: START_MAPDIV,
        draggable: true,
		icon: 'https://maps.google.com/mapfiles/ms/icons/red-dot.png'
    });
    google.maps.event.addListener(END_MAPDIV_MARKER, 'dragend', function() {
        jQuery('#btn-end-map-location' + widget_type).trigger('click');
    });

    fitAndCenterMapWithRoute(widget_type);
}

function loadReturnDatePicker(tz, widget_type){

    jQuery('#return-date' + widget_type).val(tz.format(intDateFormatCaps));
    
    jQuery('#return-date' + widget_type).attr('readonly', true).css('background-color', '#FFFFFF');
    jQuery('#return-date' + widget_type).tiodatepicker({
    	orientation: 'left',
    	autoclose: true,
    	format: intDateFormat,
    	ignoreReadonly: true
    }).on('changeDate', function() {
		jQuery('#pickup-date' + widget_type).trigger('changeDate');

		jQuery('#form-quotation-request' + widget_type).valid();
	});
	jQuery('#return-time' + widget_type).attr('readonly', true).css('background-color', '#FFFFFF');

	jQuery('#return-time' + widget_type).tiotimepicker({
		minuteStep: 5,
		showMeridian: ampm_active,
		defaultTime: tz.format(tzformatam),
 		ignoreReadonly: true
	}).on('hide.tiotimepicker', function(e) {
		jQuery('#pickup-date' + widget_type).trigger('changeDate');

		var value = e.time.minutes % 5;
		if (value != 0) {
			jQuery('#return-time' + widget_type).tiotimepicker('setTime', [e.time.hours, e.time.minutes - value].join(':'));
		}
	});
}
function waitDistances(callback){
	if(distances_loaded){
		setTimeout(function(){
			callback();//Add a slight extra delay to boost chances of base distances coming back as well
		},250);
	}else{
		setTimeout(function(){
			waitDistances(callback);
		},50);
	}
}

function getDistances(widget_type) {
	if(!maps_active){
		jQuery('#transport-distance' + widget_type).remove(); 
		jQuery('#form-thank-you' + widget_type).append(jQuery('<input>', {
            type: 'hidden',
            name: 'transport_distance',
            id: 'transport-distance' + widget_type,
            value: -2
        }));
        
        
        distances_loaded = true;
        return true;
	}
	distances_loaded = false;
        jQuery('#transport-distance' + widget_type).remove();
        jQuery('#transport-duration' + widget_type).remove();
        jQuery('#return-distance' + widget_type).remove();
        jQuery('#return-duration' + widget_type).remove();

        var element = jQuery('#vehicleType' + widget_type + ' option:selected');
        if(jQuery("#quoteform_mode"+ widget_type).val() == 'multiquote3'){
        	element = jQuery('#vehicleType' + widget_type + ' option:enabled').first();
			
		}
		
		var TYPE = element.attr('type');
		
        switch (TYPE) {
            case 'google-driving':
                var directionsService = new google.maps.DirectionsService();
			
	
				if(allBaseLocations){
					jQuery.each(allBaseLocations, function(i,el){
						getbaseDistance(i, el.base_location_lat, el.base_location_lng, widget_type);
					});
				}


                var request = {
                        origin: new google.maps.LatLng(jQuery('#start-map-location-latitude' + widget_type).val(), jQuery('#start-map-location-longitude' + widget_type).val()),
                        destination: new google.maps.LatLng(jQuery('#end-map-location-latitude' + widget_type).val(), jQuery('#end-map-location-longitude' + widget_type).val()),
                        travelMode: google.maps.TravelMode.DRIVING,
                        waypoints: via_waypoints
                };
                

                directionsService.route(request, function(result, format) {
                    if (format == google.maps.DirectionsStatus.OK) {
                        jQuery('#form-thank-you' + widget_type).append(jQuery('<input>', {
                            type: 'hidden',
                            name: 'transport_distance',
                            id: 'transport-distance' + widget_type,
                            value: result.routes[0].legs[0].distance.value
                        }));
                        jQuery('#form-thank-you' + widget_type).append(jQuery('<input>', {
                            type: 'hidden',
                            name: 'transport_duration',
                            id: 'transport-duration' + widget_type,
                            value: result.routes[0].legs[0].duration.value
                        }));
                        
                        if (typeof directionsRenderer !== "undefined") {
                            directionsRenderer.setDirections(result);
                        }
                        
                        if (jQuery('#return-journey-needed' + widget_type).prop('checked')) {
                            var directionsService = new google.maps.DirectionsService();

                           var request = {
                                    origin: new google.maps.LatLng(jQuery('#start-map-location-latitude' + widget_type).val(), jQuery('#start-map-location-longitude' + widget_type).val()),
                                    destination: new google.maps.LatLng(jQuery('#end-map-location-latitude' + widget_type).val(), jQuery('#end-map-location-longitude' + widget_type).val()),
                                    travelMode: google.maps.TravelMode.DRIVING
                            };
                            

                            directionsService.route(request, function(result, format) {
                                if (format == google.maps.DirectionsStatus.OK) {
                                    jQuery('#form-thank-you' + widget_type).append(jQuery('<input>', {
                                        type: 'hidden',
                                        name: 'return_distance',
                                        id: 'return-distance' + widget_type,
                                        value: result.routes[0].legs[0].distance.value
                                    }));
                                    jQuery('#form-thank-you' + widget_type).append(jQuery('<input>', {
                                        type: 'hidden',
                                        name: 'return_duration',
                                        id: 'return-duration' + widget_type,
                                        value: result.routes[0].legs[0].duration.value
                                    }));

                                    /*if (typeof success == 'boolean' && success==false) {
                                        jQuery(this).goToPanelThankYou();
                                    }else if (typeof success !== 'undefined') {
                                    	success();
                                    }*/
                                    distances_loaded = true;
                                }
                            });
                        } else {
                            /*if (typeof success == 'boolean' && success==false) {
                                jQuery(this).goToPanelThankYou();
                            }else if (typeof success !== 'undefined') {
                                success();
                            }*/
                            distances_loaded = true;
                        }
                    } else {
                        jQuery('#form-thank-you' + widget_type).append(jQuery('<input>', {
                            type: 'hidden',
                            name: 'transport_distance',
                            id: 'transport-distance' + widget_type,
                            value: -1
                        }));
                        jQuery('#form-thank-you' + widget_type).append(jQuery('<input>', {
                            type: 'hidden',
                            name: 'transport_duration',
                            id: 'transport-duration' + widget_type,
                            value: -1
                        }));
                        //jQuery(this).goToPanelThankYou();
                        distances_loaded = true;
                    }
                });
                break;
            case 'straight-line':
                var UNIT = element.attr('unit');
                var PER_HOUR = element.attr('per_hour');

                var UNIT_RATE = 0;

                switch (UNIT) {
                    case 'km':
                        UNIT_RATE = 1000;
                        break;
                    case 'mile':
                        UNIT_RATE = 1609.34;
                        break;
                    case 'nmi':
                        UNIT_RATE = 1852;
                        break;
                    default:
                        UNIT_RATE = 1;
                        break;
                }

                var from = new google.maps.LatLng(jQuery('#start-map-location-latitude' + widget_type).val(), jQuery('#start-map-location-longitude' + widget_type).val());
                var to = new google.maps.LatLng(jQuery('#end-map-location-latitude' + widget_type).val(), jQuery('#end-map-location-longitude' + widget_type).val());
                var computeDistanceBetween = Math.round(google.maps.geometry.spherical.computeDistanceBetween(from, to));
                jQuery('#transport-distance' + widget_type).remove();
                jQuery('#transport-duration' + widget_type).remove();
                jQuery('#form-thank-you' + widget_type).append(jQuery('<input>', {
                    type: 'hidden',
                    name: 'transport_distance',
                    id: 'transport-distance' + widget_type,
                    value: computeDistanceBetween
                }));
                jQuery('#form-thank-you' + widget_type).append(jQuery('<input>', {
                    type: 'hidden',
                    name: 'transport_duration',
                    id: 'transport-duration' + widget_type,
                    value: ((computeDistanceBetween / UNIT_RATE) / PER_HOUR) * 60 * 60
                }));

                if (jQuery('#return-journey-needed' + widget_type).prop('checked')) {
                    var from = new google.maps.LatLng(jQuery('#end-map-location-latitude' + widget_type).val(), jQuery('#end-map-location-longitude' + widget_type).val());
                    var to = new google.maps.LatLng(jQuery('#start-map-location-latitude' + widget_type).val(), jQuery('#start-map-location-longitude' + widget_type).val());
                    var computeDistanceBetween = Math.round(google.maps.geometry.spherical.computeDistanceBetween(from, to));

                    jQuery('#form-thank-you' + widget_type).append(jQuery('<input>', {
                        type: 'hidden',
                        name: 'return_distance',
                        id: 'return-distance' + widget_type,
                        value: computeDistanceBetween
                    }));
                    jQuery('#form-thank-you' + widget_type).append(jQuery('<input>', {
                        type: 'hidden',
                        name: 'return_duration',
                        id: 'return-duration' + widget_type,
                        value: ((computeDistanceBetween / UNIT_RATE) / PER_HOUR) * 60 * 60
                    }));
                } 
                
                /*if (typeof success == 'boolean' && success==false) {
                     jQuery(this).goToPanelThankYou();
                }else if (typeof success !== 'undefined') {
                     success();
                }
				*/
				distances_loaded = true;
                break;
            default:
                window.alert('Please select other vehicle type');
                break;
        }

}

function getbaseDistance(id, base_lat, base_lng, widget_type){
	var directionsService = new google.maps.DirectionsService();
	//[[TODO - account for wait and stay returns]]
	var request = {
		origin: new google.maps.LatLng(base_lat, base_lng),
		waypoints: [{
			location: new google.maps.LatLng(jQuery('#start-map-location-latitude'+widget_type).val(), jQuery('#start-map-location-longitude'+widget_type).val()),
			stopover: false
		}, {
			location: new google.maps.LatLng(jQuery('#end-map-location-latitude'+widget_type).val(), jQuery('#end-map-location-longitude'+widget_type).val()),
			stopover: false
		}],
		destination: new google.maps.LatLng(base_lat, base_lng),
		travelMode: google.maps.TravelMode.DRIVING
	};
	directionsService.route(request, function (result, format) {
		if (format == google.maps.DirectionsStatus.OK) {
			base_distances['base'+id] = {'distance': result.routes[0].legs[0].distance.value, 'duration': result.routes[0].legs[0].duration.value};
		}else{
		    base_distances['base'+id] = {'distance': -1, 'duration': -1 };
		}
	});
}

function fitAndCenterMapWithRoute(widget_type){
	if(!MAP_REFOCUS_RUNNING){
		MAP_REFOCUS_RUNNING=true;
		console.log('fitAndCenterMapWithRoute');
		
		var element = jQuery('#vehicleType' + widget_type + ' option:selected');
        if(jQuery("#quoteform_mode"+ widget_type).val() == 'multiquote3'){
        	element = jQuery('#vehicleType' + widget_type + ' option:enabled').first();
		}
		if(element.attr('type') == 'straight-line'){
		    var path = straightLineRoute.getPath();
		    path.clear();
		    path.push(START_MAPDIV_MARKER.getPosition());
		    path.push(END_MAPDIV_MARKER.getPosition());
		
		}
		
		var bounds = new google.maps.LatLngBounds();
		bounds.extend(START_MAPDIV_MARKER.getPosition());
		bounds.extend(END_MAPDIV_MARKER.getPosition());
		START_MAPDIV.fitBounds(bounds);
		MAP_REFOCUS_RUNNING=false;
		if(resize_only == false){
			//Disable load new quotes if resizing window - mobile app was triggering this
			loadMultiQuotes(widget_type);
		}
		disable_geocode_on_places = false;
		

		if (typeof detectAirport === "function") { 
			detectAirport(widget_type);	
		}
	}
}
var currentMultiRequest = null;  
function loadMultiQuotes(widget_type){
	//skip if not multi mode
	if(jQuery("#quoteform_mode"+ widget_type).val() != 'multiquote3'){return '';}
	jQuery("#multi_quote_results"+ widget_type).show().removeClass('hidden');
	jQuery("#multi_quote_results"+ widget_type).html("<i class='fa fa-spinner fa-spin'></i> "+loading_text);
	var ids=[];
	jQuery("#vehicleType"+ widget_type+" option:enabled:not(.hide)").each(function(i,el){
		ids.push(jQuery(this).val());
	});
	
	if(typeof(jQuery('#vehicleType'+ widget_type+' option:enabled').first().attr('type')) != 'undefined'){
		getDistances(widget_type);
		waitDistances(function () {
			jQuery("#base_distances"+ widget_type).val(JSON.stringify(Object.assign({}, base_distances)));
			currentMultiRequest = jQuery.ajax({
				url: siteURLs[widget_type] + 'api/v1/quote-form/multi',
				method:'POST',
				beforeSend : function()    {           
					if(currentMultiRequest != null) {currentMultiRequest.abort();}
				},
				data: jQuery('#form-quotation-request'+ widget_type+', #form-thank-you'+ widget_type+', #journeyType_first'+ widget_type).serialize()+'&vehicle_type_ids='+ids,
				success: function(data){
					jQuery("#multi_quote_results"+ widget_type).html(data);

			
					jQuery("#3_step_final"+ widget_type).hide();
					jQuery("#btn-quotation-request"+ widget_type).hide();
				
				}
			});
		});
	}
}

function detectAirport(widget_type){
	if(!collect_flight_details || collect_flight_details == '0') { return; }
	if(jQuery("#end-map-location"+ widget_type).val().toLowerCase().includes("airport")){
		jQuery("#flight_direction_in"+ widget_type).attr('checked', true);
		jQuery("#flight_details_link"+ widget_type).click();
	}else if(jQuery("#start-map-location"+ widget_type).val().toLowerCase().includes("airport")){
		jQuery("#flight_direction_out"+ widget_type).attr('checked', true);
		jQuery("#flight_details_link"+ widget_type).click();
	}
}
var via_stop_count = 0;
var VIA_AUTOCOMPLETE = [];
function addStopRow(widget_type){
    via_stop_count++;
    var html = '<div class="form-group" id="via_stop_row_'+via_stop_count+'">';
    html += '<label for="end-location">'+via_label+'</label>';
    html += '<a href="#" onclick="jQuery(\'#via_stop_row_'+via_stop_count+'\').remove();" class="pull-right">X</a>';
    html += '<input tabindex="2" type="text" name="via_location" id="via-location_'+via_stop_count+widget_type+'" class="form-control is_places_suggest" value="" required>';
	html += '<input type="hidden" name="via_stops_arr[]" value="'+via_stop_count+'" class="via_stops_arr">';
	html += '<input type="hidden" name="via_latitude_'+via_stop_count+'" id="via_latitude_'+via_stop_count+widget_type+'"><input type="hidden" name="via_longitude_'+via_stop_count+'" id="via_longitude_'+via_stop_count+widget_type+'"></div>';
    
    jQuery('#viastops'+widget_type).append(html);
    
    VIA_AUTOCOMPLETE[via_stop_count] = new google.maps.places.Autocomplete(document.getElementById('via-location_'+ via_stop_count + widget_type), {
	        componentRestrictions: {
	            country: jQuery.region
	        }
	});
	VIA_AUTOCOMPLETE[via_stop_count].inputId = via_stop_count;
	
	VIA_AUTOCOMPLETE[via_stop_count].addListener('place_changed', function() {
	    var cnt = this.inputId;
	    var place = this.getPlace();
	    if (!place || !place.geometry) {
	        console.log("Autocomplete's returned place contains no geometry");
	        return;
	    }
        jQuery('#via_latitude_'+cnt+widget_type).val(place.geometry.location.lat());
	    jQuery('#via_longitude_'+cnt+widget_type).val(place.geometry.location.lng());
	});
  
    
}
