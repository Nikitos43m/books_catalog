$(document).ready(function(){

    $( ".open-filter" ).click(function() {
        $(this).addClass("active");
       // $(".filter").show();
        //$(".filter").fadeIn(600);
        $(".filter").slideToggle();
    });

})