// This is for broadcast notifications.

import Echo from 'laravel-echo'

window.Echo = new Echo({
  broadcaster: 'pusher',
  key: 'e5fe6643b1ad99325320',
  cluster: 'ap2',
  forceTLS: true
});

var channel = Echo.private(`App.Models.User.${userID}`);
channel.notification(function(data) {
    console.log(data);
    alert(data.body);
    //alert(JSON.stringify(data));
});
