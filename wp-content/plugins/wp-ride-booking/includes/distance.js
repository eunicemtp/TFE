var distance = 0;
var api_key = '<?php echo $api_key;?>';
var source, destination;
var directionsDisplay;
        window.addEventListener('load', function () {
            new google.maps.places.SearchBox(document.getElementById('txtSource'));
            new google.maps.places.SearchBox(document.getElementById('txtDestination'));
            directionsDisplay = new google.maps.DirectionsRenderer({ 'draggable': true });
        });

        function GetRoute() {
            // Initialize DirectionsService and DirectionsRenderer
            var directionsService = new google.maps.DirectionsService();
            var directionsRenderer = new google.maps.DirectionsRenderer();
            var mumbai = new google.maps.LatLng(18.9750, 72.8258);
            var mapOptions = {
                zoom: 7,    
                center: mumbai
            };
            map = new google.maps.Map(document.getElementById('dvMap'), mapOptions);

            directionsDisplay.setMap(map);
       

            //*********DIRECTIONS AND ROUTE**********************//
            source = document.getElementById("txtSource").value;
            destination = document.getElementById("txtDestination").value;

            var request = {
                origin: source,
                destination: destination,
                travelMode: google.maps.TravelMode.DRIVING
            };
            directionsService.route(request, function (response, status) {
                if (status == google.maps.DirectionsStatus.OK) {
                    directionsDisplay.setDirections(response);
                }
            });

            //*********DISTANCE AND DURATION**********************//
            var service = new google.maps.DistanceMatrixService();
            service.getDistanceMatrix({
                origins: [source],
                destinations: [destination],
                travelMode: google.maps.TravelMode.DRIVING,
                unitSystem: google.maps.UnitSystem.METRIC,
                avoidHighways: false,
                avoidTolls: false
            }, function (response, status) {
                if (status == google.maps.DistanceMatrixStatus.OK && response.rows[0].elements[0].status != "ZERO_RESULTS") {
                    distance = response.rows[0].elements[0].distance.text;                  
                    var dvDistance = document.getElementById("dvDistance");
                    dvDistance.innerHTML = "";
                    var pdata = "action=ride_price&distance=" + distance;
					jQuery.ajax({
						url: ajaxurl,
						data: pdata,
						type: 'POST',
						success:function(response){							
							var obj = jQuery.parseJSON(response);
							jQuery("#rate_per_km").html(obj.currency + obj.rate);
                            jQuery("#total_price").html(obj.currency + obj.total_rate);
							jQuery("#distance").html(distance);
							jQuery("#item_amount").val(obj.total_rate);
							jQuery("#paypal_form").show();
							jQuery("#ride_col").addClass('ride_col-dis');
							}
						
						
						})
					
                } else {
                    alert("Unable to find the distance via road.");
                }
            });
            jQuery("#dvMap").addClass('map_area');
        }
        