import 'bootstrap';

import DataTable from 'datatables.net-dt';
import flatpickr from "flatpickr";


flatpickr("#cutomDate1", {
    enable: ["2025-03-30", "2025-05-21", "2025-06-08", new Date(2025, 8, 9) ]
});


 

/**
 * We'll load the axios HTTP library which allows us to easily issue requests
 * to our Laravel back-end. This library automatically handles sending the
 * CSRF token as a header based on the value of the "XSRF" token cookie.
 */

import axios from 'axios';
window.axios = axios;

window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';


document.addEventListener('DOMContentLoaded', function() {
    var tableElement = document.querySelector('#myTable');
    if (tableElement) {
        var table = new DataTable(tableElement);

        var tanggalHeader = document.querySelector('#myTable td#tanggal-col');
        if (tanggalHeader) {
            tanggalHeader.style.width = '100px';
        }

        table.columns.adjust().draw();
    }
});

/**
 * Echo exposes an expressive API for subscribing to channels and listening
 * for events that are broadcast by Laravel. Echo and event broadcasting
 * allows your team to easily build robust real-time web applications.
 */

// import Echo from 'laravel-echo';

// import Pusher from 'pusher-js';
// window.Pusher = Pusher;

// window.Echo = new Echo({
//     broadcaster: 'pusher',
//     key: import.meta.env.VITE_PUSHER_APP_KEY,
//     cluster: import.meta.env.VITE_PUSHER_APP_CLUSTER ?? 'mt1',
//     wsHost: import.meta.env.VITE_PUSHER_HOST ?? `ws-${import.meta.env.VITE_PUSHER_APP_CLUSTER}.pusher.com`,
//     wsPort: import.meta.env.VITE_PUSHER_PORT ?? 80,
//     wssPort: import.meta.env.VITE_PUSHER_PORT ?? 443,
//     forceTLS: (import.meta.env.VITE_PUSHER_SCHEME ?? 'https') === 'https',
//     enabledTransports: ['ws', 'wss'],
// });
