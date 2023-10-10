jQuery(document).ready(function(){
   

    $(".dropdown").hover(
        function() { $('.dropdown-menu', this).fadeIn(300);
        },
        function() { $('.dropdown-menu', this).fadeOut(300);
    });
   
 
   
});