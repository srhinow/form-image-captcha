var doAjax = function(e){
  e.stop(); // prevent the form from submitting

  new Request({
    url: window.location + '?isAjax=1',
    method: 'post',
    data: this,
    onRequest: function(){
      $('captcha_img').fade('out');
    },
    onSuccess: function(r){
      // the 'r' is response from server
     // $('number_box').setStyle('display','block');
        $('captcha_img').set('src', r);
        $('captcha_img').fade('in');
    }
  }).send();
}

addEvent('domready', function(){
  $('refresh_captcha').addEvent('click', doAjax);
});