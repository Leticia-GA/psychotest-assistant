const $ = require('jquery');
global.$ = global.jQuery = $;

$(function() {
    checkNotifications();

    setInterval(checkNotifications, 30000); 
});

function checkNotifications() {
    $.ajax({
        url: "/notifications"
      }).done(function(numberOfNotifications) {
            if(numberOfNotifications > 0) {
                $("#notifications .balloon").remove();
                $("#notifications").append('<span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger balloon">' 
                    + numberOfNotifications + '</span>'
                );
            }     
        });
}