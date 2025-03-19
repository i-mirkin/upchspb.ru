function QAsendMail(id) {
	jQuery.ajax({
		type: 'POST',
		url: '/include/qaSendMail.php?ID='+id ,
		success: function(response, textStatus, jqXHR) {
			var content = 'Ошибка отправки';
			if(null !== response) {
				if(response.length) { 
					var dataResponse = JSON.parse(response);
					console.log('dataResponse = ' + dataResponse);
					if((null !== typeof dataResponse) && ('object' === typeof dataResponse)) {
						switch(dataResponse.STATUS) {
							case 'ok':
								content = '<p>Успешно отправлен ответ на: ' + dataResponse.EMAIL + '.</p>';
							break;
							case 'error':
								content = '<p>Ошибка: ' + dataResponse.EXP + '</p>';
							break;
						}
						
					}
				}
			}
			new BX.CDialog({
				'title': 'Отправка ответа',
				'content': content
			}).Show();
		},		
	});
}