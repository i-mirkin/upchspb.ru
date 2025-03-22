$('body').on('click','form.subscribe-left input', function() {
	console.log("typeof(grecaptcha)" + typeof(grecaptcha));
	if (typeof(grecaptcha) == 'undefined') {
		var grecaptcha_s = document.createElement('script');
		grecaptcha_s.src = 'https://www.google.com/recaptcha/api.js?render=6LeSmfwqAAAAANAMoL4X7cJHpqLuUta2c6JroDqk';
		var grecaptcha_h = document.getElementsByTagName('script')[0];
		grecaptcha_h.parentNode.insertBefore(grecaptcha_s,grecaptcha_h);
		console.log('in');
	}


});


$('body').on('click','form.subscribe-left button[name="Save"]', function() {

	grecaptcha.ready(function() {
		grecaptcha.execute('6LeSmfwqAAAAANAMoL4X7cJHpqLuUta2c6JroDqk',{action: 'feedback'}).then(
			function(token) {

				console.log("token=" + token);

				$('form.subscribe-left input[name="g_recaptcha_response"]').val(token);

				var form_obj = $('form.subscribe-left');
				var event_obj = form_obj.get(0);

				BX.fireEvent(event_obj,'submit');
				event_obj.submit();

				console.log("event_obj");
				console.log(event_obj);
			}
		);
	});
});

