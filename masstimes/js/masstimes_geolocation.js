/**
 * @file
 * Grabs user location and sends back to server with ajax request.
 */

(function ($, Drupal) {

    if (navigator.geolocation) {
      navigator.geolocation.getCurrentPosition(function (position) {
        
        var coords = {
          lat: position.coords.latitude,
          long: position.coords.longitude
        };
        //Send location data to our server.
        $.ajax({
          url: '/masstimes/user_location',
          dataType: 'json',
          type: 'post',
          contentType: 'application/json',
          data: JSON.stringify(coords),
          processData: false,
          success: function(data) {
            console.log(data);
          }
        });
      });
  
    } else {
      alert("Your browser does not support HTML5 geolocation.");
    }
  
  })(jQuery, Drupal);