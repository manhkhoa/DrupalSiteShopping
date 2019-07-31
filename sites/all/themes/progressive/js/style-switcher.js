jQuery(function($){

    $('#style-switcher h3 a').click(function(event){
        event.preventDefault();
        if($(this).hasClass('show')){
            $( "#style-switcher" ).animate({
              left: "-=200"
              }, 300, function() {
                // Animation complete.
              });
              $(this).removeClass('show').addClass('hidden1');
        }
        else {
            $( "#style-switcher" ).animate({
              left: "+=200"
              }, 300, function() {
                // Animation complete.
              });
              $(this).removeClass('hidden1').addClass('show');    
            }
    });

    $('#style-switcher h3 a').hover(
        function() {
            $(this).find('.fa').addClass('fa-spin');  
        },
        function() {
            $(this).find('.fa').removeClass('fa-spin');  
        }
    );

    $('.styles-switcher-colors a').click(function() {
      $('.style-switcher').prev("link[href^='/sites/all/themes/progressive/css/customizer/']").attr("href", "/sites/all/themes/progressive/css/customizer/" + $(this).attr('data-color') + "-pages-customizer.css");  
      return false;
    });

    // Layout
    $(".layout-boxed").click(function(e){
        e.preventDefault();
        $('.style-switcher-layout li a').removeClass('active');
        $(this).addClass('active');
        $("body").addClass("boxed");
        return false;
    });

    $(".layout-wide").click(function(e){
        e.preventDefault();
        $('.style-switcher-layout li a').removeClass('active');
        $(this).addClass('active');
        $("body").removeClass("boxed");
        return false;
    });

    $(".layout-rtl").click(function(e){
      e.preventDefault();
      $('.style-switcher-rtl li a').removeClass('active');
      $(this).addClass('active');
      $("html").attr("dir", 'rtl');
      $('body').append('<link rel="stylesheet" href="/sites/all/themes/progressive/css/drupal-rtl.css">');
      return false;
    });

    $(".layout-ltr").click(function(e){
      e.preventDefault();
      $('.style-switcher-rtl li a').removeClass('active');
      $(this).addClass('active');
      $("html").attr("dir", 'ltr');
      $('link[href="/sites/all/themes/progressive/css/drupal-rtl.css"]').remove();
      return false;
    });


});