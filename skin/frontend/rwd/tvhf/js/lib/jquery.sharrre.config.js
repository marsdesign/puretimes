$j(function(){


  $j('#twitter').sharrre({
    share: {
      twitter: true
    },
    template: '<a class="box" href="#"><div class="count" href="#">{total}</div><div class="share"><i class="fa fa-twitter"></i></div></a>',
    enableHover: false,
    enableTracking: true,
    buttons: { twitter: {via: 'thevirginhair'}},
    click: function(api, options){
      api.simulateClick();
      api.openPopup('twitter');
    }
  });
  $j('#facebook').sharrre({
    share: {
      facebook: true
    },
    template: '<a class="box" href="#"><div class="count" href="#">{total}</div><div class="share"><i class="fa fa-facebook"></i></div></a>',
    enableHover: false,
    enableTracking: true,
    click: function(api, options){
      api.simulateClick();
      api.openPopup('facebook');
    }
  });
  $j('#googleplus').sharrre({
    share: {
      googlePlus: true
    },
    template: '<a class="box" href="#"><div class="count" href="#">{total}</div><div class="share"><i class="fa fa-google"></i></div></a>',
    enableHover: false,
    enableTracking: true,
    urlCurl: '/skin/frontend/rwd/tvhf/js/lib/sharrre.php',
    click: function(api, options){
      api.simulateClick();
      api.openPopup('googlePlus');
    }
  });
  $j('#pinterest').sharrre({
    share: {
      pinterest: true
    },
    template: '<a class="box" href="#"><div class="count" href="#">{total}</div><div class="share"><i class="fa fa-pinterest"></i></div></a>',
    enableHover: false,
    enableTracking: true,
    click: function(api, options){
      api.simulateClick();
      api.openPopup('pinterest');
    }
  });

    
});