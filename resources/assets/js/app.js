
import Echo from "laravel-echo"


$(function(){
    /**
     * Echo exposes an expressive API for subscribing to channels and listening
     * for events that are broadcast by Laravel. Echo and event broadcasting
     * allows your team to easily build robust real-time web applications.
     */

    window.Echo = new Echo({
        broadcaster: 'pusher',
        key: 'f05fd10a2a81a154f001',
        cluster: 'us2',
        encrypted: true
    });

    window.Echo.channel('private-app')
        .listen('PrintJobCreated', function(e){
            $.notify("Please approve the 3D Model before printing.", {
                title: "New Print Job Submitted!",
                icon: "https://library.byui.edu/images/byu-idaho-logo.png"
            });
        });

});