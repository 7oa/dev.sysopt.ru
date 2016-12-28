$(document).ready(function(){

        var $menu = $("#menuLine");

        $(window).scroll(function(){
            if ( $(this).scrollTop() > 100 && $menu.hasClass("default") ){
                $menu.fadeOut('fast',function(){
                    $(this).removeClass("default")
                           .addClass("fixed")
                           .fadeIn('slow');
                });
            } else if($(this).scrollTop() <= 100 && $menu.hasClass("fixed")) {
                $menu.removeClass("fixed").addClass("default");
                
            }
        });//scroll
    });