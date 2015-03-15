$(document).ready(function() {
  //height of window - navbar
  var height = ($(window).height()/4)*3;
  $('.front').height(height);
  var margin = height*0.15;
  if (height<415){
    $('.login_control').css({'margin-top': '0px'});

  } else {
    $('.login_control').css({'margin-top': margin});
  }
  //$('.login_control').css({'margin-top': height*0.35});
  $( window ).resize(function() {
    var height = ($(window).height()/4)*3;
    $('.front').height(height);
    //$('.login_control').css({'margin-top': height*0.35});
    var margin = height*0.15;
    if (height<415){
      $('.login_control').css({'margin-top': '0px'});
    } else {
      $('.login_control').css({'margin-top': margin});
    }
  });
});