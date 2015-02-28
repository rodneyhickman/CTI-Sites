// Load jQuery
google.load("jquery", "1.2.6");
google.setOnLoadCallback(function() {
    $('#home-promo li a').click( function(){
        $('.home-promo-active').removeClass('home-promo-active');
        $(this).parent().addClass('home-promo-active');
        $('#home-specials').hide();
        $('#home-news').hide();
        $('#home-events').hide();
        $('#home-spotlight').hide();
        if($(this).attr('title') == 'Spotlight'){
          $('#home-spotlight').show();
        }
        if($(this).attr('title') == 'Specials'){
          $('#home-specials').show();
        }
        if($(this).attr('title') == 'News'){
          $('#home-news').show();
        }
        if($(this).attr('title') == 'Events'){
          $('#home-events').show();
        }
    });
});


