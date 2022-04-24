const $ = require('jquery');
global.$ = global.jQuery = $; 

$('.delete_confirmation_btn').on('click', (event) => {
    const element = event.target;
    window.location.href = $(element).attr('data-href');
});