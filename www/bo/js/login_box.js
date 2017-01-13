var loginBox = {
    
	init: function(){
		$$('.bo_login').each(function(element){
			$('UserLoginForm').observe('submit', function(event) {
		//		Effect.Fade(element);
			});
		});
	}
		
};


Event.observe(window, 'load', loginBox.init);