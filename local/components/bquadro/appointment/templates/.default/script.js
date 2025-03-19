var Appointment;
(function($){
	'use strict';
	
	function Appointment()
	{
		this.init = function() 
		{		
			var data = {'action': 'init'};
			$.post({
				url: "",
				dataType: "json",
				data: data,
				success: function(data){
					if('object' == typeof data.dateList) {
						var dateCalendar = [];
						$.each(data.dateList, function(k,v){
							dateCalendar.push(v);
						});						
					}

                    if('undefined' != typeof dateCalendar && dateCalendar.length > 0) {
					$('#datetimepicker_appointment').flatpickr(
					{
						inline: true,    
						dateFormat: "Y-m-d",
						enable: dateCalendar,						
						locale: data.lang_id,
						onChange: function(selectedDates, dateStr, instance) {
							var selectedDateId = Appointment.getKeyByValue(data.dateList, dateStr);
							Appointment.themeHoursList(dateStr);
						},						
					});
				    }
					
				}
			});
			
			$('body').on('submit', $('form[name=appointment]'), function(e) {
				e.preventDefault();				
				$('form[name=appointment]').append('<input type="hidden" name="capt_field" value="Y">');
				$.post({
					url: '',
					data: $('form[name=appointment]').serialize(),
					success: function(data) {
						$('form[name=appointment]').find('.form-error').remove();
						var dataResp = JSON.parse(data);						
						if(dataResp.ERROR) {
							$.each(dataResp.ERROR, function(k,v){								
								$('form[name=appointment]').find('.user_'+k).after('<span class="form-error">' + v + '</span>');
								if(k == 'schedule') $('form[name=appointment] .theme-list').append('<span class="form-error">' + v + '</span>');
								if(k == 'uconsent') $('form[name=appointment] #userconsent-container').append('<span class="form-error">' + v + '</span>');
								if(k == 'captcha_word') $('form[name=appointment] #captcha_word').after('<span class="form-error">' + v + '</span>');
							});
						}
						if(dataResp.SUCCESS) {
							$('.appointment_wrap').html('<p>' + dataResp.SUCCESS.MSG + '</p>');
						}
					}
				});
			});
		}
		
		this.themeHoursList = function(dateId)
		{			
			var data = {'action': 'themeHoursList', 'dateId':dateId};
			$.post({
				url: "",
				dataType: "json",
				data: data,
				success: function(data){
					var appform = $('form[name=appointment]');
					appform.find('.theme-list').remove();
					$('.appointment_err_list').empty();
					$('.app-fl').hide();
					if(data.IS_EMPTY) { 
						$('.appointment_err_list').append(data.IS_EMPTY);						
						return;	
					}															
					appform.find('.field-list').before('<div class="theme-list"></div>');
					$.each(data, function(k,v) {
						appform.find('.theme-list').append('<div class="theme-list-item"><label for="' + v.ID + '"><input type="radio" name="schedule" id="' + v.ID + '"  value="' + v.ID + '"><span class="tl-time">'+v.HOURS+'</span><span class="tl-theme">'+v.THEME+'</span></label></div>');						
					});					
					$('.app-fl').show();
				}
			});
		}
		
		this.getKeyByValue = function (object, value) { 
            for (var prop in object) { 
                if (object.hasOwnProperty(prop)) { 
                    if (object[prop] === value) 
                    return prop; 
                } 
            } 
        } 
	}
	
	$(document).ready(function(){
		Appointment = new Appointment();
		Appointment.init();
	});
	
})(jQuery);