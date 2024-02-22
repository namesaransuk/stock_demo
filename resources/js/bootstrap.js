window._ = require('lodash');

/**
 * We'll load jQuery and the Bootstrap jQuery plugin which provides support
 * for JavaScript based Bootstrap features such as modals and tabs. This
 * code may be modified to fit the specific needs of your application.
 */

try {
    window.Popper = require('popper.js').default;
    window.$ = window.jQuery = require('jquery');
    require('overlayscrollbars');
    require('bootstrap');

    require('jquery-validation/dist/jquery.validate')
    require('jquery-validation/dist/additional-methods.min')
    require('chart.js')
    require('chartjs-plugin-datalabels/dist/chartjs-plugin-datalabels.min')
    require('owl.carousel')
    require('dropify')
    require('devbridge-autocomplete')

    window.Swal = require('sweetalert2');
    require('select2/dist/js/select2');

    require( 'datatables.net-bs4' )($);
    require( 'datatables.net-buttons-bs4' )($);
    require( 'datatables.net-responsive-bs4' )($);

    require('bootstrap');
} catch (e) {}

/**
 * We'll load the axios HTTP library which allows us to easily issue requests
 * to our Laravel back-end. This library automatically handles sending the
 * CSRF token as a header based on the value of the "XSRF" token cookie.
 */

window.axios = require('axios');

window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';

/**
 * Echo exposes an expressive API for subscribing to channels and listening
 * for events that are broadcast by Laravel. Echo and event broadcasting
 * allows your team to easily build robust real-time web applications.
 */

// import Echo from 'laravel-echo';

// window.Pusher = require('pusher-js');

// window.Echo = new Echo({
//     broadcaster: 'pusher',
//     key: process.env.MIX_PUSHER_APP_KEY,
//     cluster: process.env.MIX_PUSHER_APP_CLUSTER,
//     forceTLS: true
// });
jQuery.extend(jQuery.validator.messages, {
    required: "กรุณากรอกข้อมูล.",
    remote: "กรุณากรอกตรวจสอบให้ถูกต้อง.",
    email: "กรุณากรอกรูปแบบอีเมลให้ถูกต้อง.",
    url: "กรุณากรอก URL ให้ถูกต้อง.",
    date: "กรุณากรอกวันที่ให้ถูกต้อง.",
    dateISO: "กรุณากรอกวันที่ (ISO) ให้ถูกต้อง.",
    number: "Please enter a valid number.",
    digits: "Please enter only digits.",
    creditcard: "Please enter a valid credit card number.",
    equalTo: "Please enter the same value again.",
    accept: "Please enter a value with a valid extension.",
    maxlength: jQuery.validator.format("จำกัด {0} ตัวอักษร."),
    minlength: jQuery.validator.format("Please enter at least {0} characters."),
    rangelength: jQuery.validator.format("Please enter a value between {0} and {1} characters long."),
    range: jQuery.validator.format("Please enter a value between {0} and {1}."),
    max: jQuery.validator.format("Please enter a value less than or equal to {0}."),
    min: jQuery.validator.format("Please enter a value greater than or equal to {0}.")
});
