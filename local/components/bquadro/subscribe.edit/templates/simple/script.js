$('body').on('click','form.subscribe-left input', function() {
	if (typeof(grecaptcha) == 'undefined') {
		var grecaptcha_s = document.createElement('script');
		grecaptcha_s.src = 'https://www.google.com/recaptcha/api.js?render=6LcgU9EaAAAAABsxaoORDMNhR1t0m0nP0RCx8Aom';

		var grecaptcha_h = document.getElementsByTagName('script')[0];
	grecaptcha_h.parentNode.insertBefore(grecaptcha_s,grecaptcha_h);
	
	$('body').on('click','form.subscribe-left button[name="Save"]', function() {
	grecaptcha.ready(function() {
		grecaptcha.execute('6LcgU9EaAAAAABsxaoORDMNhR1t0m0nP0RCx8Aom',{action: 'feedback'}).then(
			function(token) {
				$('form.subscribe-left input[name="g_recaptcha_response"]').val(token);

				var form_obj = $('form.subscribe-left');
				var event_obj = form_obj.get(0);

				BX.fireEvent(event_obj,'submit');	
				event_obj.submit();
			}
		);
	});
});


	}
});

