$(function () {
  setInterval(function() {
      $('.flashAnswer').fadeOut(300);
      $('.flashAnswer').fadeIn(700);
  }, 1000);
});
