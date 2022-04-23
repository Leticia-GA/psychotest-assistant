const $ = require('jquery');
global.$ = global.jQuery = $; 

$('.delete_confirmation_btn').on('click', () => {
    console.log("Eliminaoooo");
});