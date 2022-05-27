
import dt from 'datatables.net-bs';
dt(window, $); 

const $ = require('jquery');
global.$ = global.jQuery = $;

$(function() {
    $('.data_table').DataTable();
});