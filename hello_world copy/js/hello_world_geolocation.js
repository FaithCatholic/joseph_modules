(function (Drupal, $) {
    "use strict";


    Drupal.behaviors.helloWorldGeolocation = {
        attach: function (context, settings) {
            function geoLocate() {
                if (navigator.geolocation) {
                    navigator.geolocation.getCurrentPosition(function(position) {
                        const latitude = position.coords.latitude;
                        const longitude = position.coords.longitude;
                        const locationInfo = `Lat: ${latitude}, Long: ${longitude}`;

                        

                        $('#location-info').html(locationInfo);
                    });
                }
                else {

                }
            }
            
                geoLocate();
            
        }
    }
}) (Drupal, jQuery);