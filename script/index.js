$(function(){
    $('.navlist').hover(
        function(){
            $(this).animate({'border-width':'5px'},100);
        }, 
        function(){
            $(this).animate({'border-width':'0px'},100);
        }
    )
    $('.tombolLogin').hover(
        function(){
            $('.tombolLogin').css('background-color','#f39c12');
        },
        function(){
            $('.tombolLogin').css('background-color','orange');
        }
    );
});