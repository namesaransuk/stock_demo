require('./bootstrap');
window.moment = require('moment');
$.extend( true, $.fn.dataTable.defaults, {
    // "searching": false,
    // "ordering": false,
    "language": {
        "url": window.location.origin+"/js/datatables/th.json"
    }
} );

