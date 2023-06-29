$(document).ready(function(){

    $('.checkboxReport').click(function() {
       $('.checkboxReport').not(this).prop('checked', false);
    });

 });