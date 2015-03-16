$(document).ready(function() {
  //height of window - navbar
  var height = ($(window).height()/4)*3;
  $('.front').height(height);

  //$('.login_control').css({'margin-top': height*0.35});
  $( window ).resize(function() {
    var height = ($(window).height()/4)*3;
    $('.front').height(height);
    //$('.login_control').css({'margin-top': height*0.35});
  });
});