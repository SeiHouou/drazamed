window._ = require('lodash');

/**
 * We'll load jQuery and the Bootstrap jQuery plugin which provides support
 * for JavaScript based Bootstrap features such as modals and tabs. This
 * code may be modified to fit the specific needs of your application.
 */

try {
    window.Popper = require('popper.js').default;
    window.$ = window.jQuery = require('jquery');

    require('bootstrap');
} catch (e) {}


// import 'jquery-ui/ui/widgets/autocomplete.js';

// /**
//  * We'll load the axios HTTP library which allows us to easily issue requests
//  * to our Laravel back-end. This library automatically handles sending the
//  * CSRF token as a header based on the value of the "XSRF" token cookie.
//  */

// window.axios = require('axios');
// window.lang = require('lang.js');


// // import 'jquery-ui/ui/widgets/datepicker.js';


// window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';

/**
 * Echo exposes an expressive API for subscribing to channels and listening
 * for events that are broadcast by Laravel. Echo and event broadcasting
 * allows your team to easily build robust real-time web applications.
 */

import Echo from 'laravel-echo';

window.Pusher = require('pusher-js');

window.Echo = new Echo({
    broadcaster: 'pusher',
    key: "270a27c11d1a38de071b",
    cluster: "us2",
    encrypted: true,
    // auth: {
    //     headers: {
    //         Authorization: 'Bearer ' + 1052486
    //     },
    // },
});

// window.Echo.channel(`Drazamed`)
//     .listen('MessageSent', (e) => {
//     console.log('notif arrived', e);
// })
// window.Echo.channel('Drazamed')
// //   .listen('.MessageSent', (e) => {
// //     console.log(e);
// //     app.messages.push({
// //       message: e.message.message,
// //       user: e.user
// //     });
// //   })
//   .listen('.orderStatus', (e) => {
//     console.log('Orden verificada : ' );
//     console.log(e);
//     // console.log(e.user.id);
//     httpGetAsync('/user/is-actual-user/' + e.user.id, checkedUser);
//   });

// import 'jquery-ui/ui/widgets/autocomplete.js';

import 'jquery-ui/ui/widgets/autocomplete.js';

/**
 * We'll load the axios HTTP library which allows us to easily issue requests
 * to our Laravel back-end. This library automatically handles sending the
 * CSRF token as a header based on the value of the "XSRF" token cookie.
 */

window.axios = require('axios');
window.lang = require('lang.js');


// import 'jquery-ui/ui/widgets/datepicker.js';


window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';

