<?if(!defined("B_PROLOG_INCLUDED")||B_PROLOG_INCLUDED!==true)die();?>
<?
if ($arParams['SILENT'] == 'Y') return;

$cnt = $arParams['INPUT_NAME_FINISH'] <> '' ? 2 : 1;

for ($i = 0; $i < $cnt; $i++):
	if ($arParams['SHOW_INPUT'] == 'Y'):
?><input class="sc_in" type="text" readonly id="<?=$arParams['INPUT_NAME'.($i == 1 ? '_FINISH' : '')]?>" name="<?=$arParams['INPUT_NAME'.($i == 1 ? '_FINISH' : '')]?>" value="<?=$arParams['INPUT_VALUE'.($i == 1 ? '_FINISH' : '')]?>" <?=(Array_Key_Exists("~INPUT_ADDITIONAL_ATTR", $arParams)) ? $arParams["~INPUT_ADDITIONAL_ATTR"] : ""?>/><?
	endif; 
	?><img src="<?php echo SITE_TEMPLATE_PATH ?>/images/calend_ico.jpg" alt="<?=GetMessage('calend_title')?>" id="sc_i<?php echo $i?>" class="calendar-icon" onclick="BX.calendar({
    node:this, 
    field:'<?=htmlspecialcharsbx(CUtil::JSEscape($arParams['INPUT_NAME'.($i == 1 ? '_FINISH' : '')]))?>', 
    form: '<?if ($arParams['FORM_NAME'] != ''){echo htmlspecialcharsbx(CUtil::JSEscape($arParams['FORM_NAME']));}?>', 
    bTime: <?=$arParams['SHOW_TIME'] == 'Y' ? 'true' : 'false'?>, currentTime: '<?=(time()+date("Z")+CTimeZone::GetOffset())?>', 
    bHideTime: <?=$arParams['HIDE_TIMEBAR'] == 'Y' ? 'true' : 'false'?>,     
    'callback_after': function (e) {        
        let sTime = Date.parse(e);
        let curTime = Date.now();
        let curTimeObj = new Date(curTime);
        let curTimeFormat = curTimeObj.getDate() + '.' + padLeadingZeros(curTimeObj.getMonth() + 1, 2) + '.' + curTimeObj.getFullYear();
    	let nodeId = this.params.node.id;
    	let elId = '';
    
    	switch(nodeId) {
    		case 'sc_i0':
    			elId = 'from';
    		break;
    		case 'sc_i1':
    			elId = 'to';
    		break;
    	}
    
        if(sTime < 1325376000000) { 
        	document.getElementById('from').value = '01.01.2012';
        }
        if(sTime > curTime) {
        	document.getElementById(elId).value = curTimeFormat;        	
        }
        },}); changeCalendar();" onmouseover="BX.addClass(this, 'calendar-icon-hover');" onmouseout="BX.removeClass(this, 'calendar-icon-hover');" border="0"/><?if ($cnt == 2 && $i == 0):?><span class="date-interval-hellip">&ndash;</span><?endif;?><?
endfor;
?>
<script>
function padLeadingZeros(num, size) {
	if(num > 9) return num;
    var s = num+"";
    while (s.length < size) s = "0" + s;
    return s;
}


function changeCalendar() {
	$('.bx-calendar-top-year').attr({'onclick': 'changeYear();',});
}

function changeYear() {
	var yearList = [];
	var currentYearList = [];
	var addYearList = [];
	var currentYear = new Date().getFullYear();
	for(i = 2012; i <= currentYear; i++) {		
		yearList.push(i);
	}
	 
	/*jQuery('.bx-calendar-year-number').each(function(){		
    	if(jQuery(this).attr('data-bx-year') > currentYear || jQuery(this).attr('data-bx-year') < 2012) {
    		jQuery(this).remove();    		
    	} else {    		
    		currentYearList.push(parseInt(jQuery(this).attr('data-bx-year'))); 
    	}		     	
	});		
	
	addYearList = jQuery(yearList).not(currentYearList).get();*/	
	
	jQuery('.bx-calendar-year-number').remove();
	yearList.reverse();
	jQuery.each(yearList, function(k,v) {
		jQuery('.bx-calendar-year-content').append('<span class="bx-calendar-year-number" data-bx-year="' + v + '">' + v + '</span>');	
	});
	
	/*if(jQuery('.bx-calendar-year-number').first().attr('data-bx-year') < currentYear) {
		jQuery.each(addYearList, function(k,v) {
			jQuery('.bx-calendar-year-content').prepend('<span class="bx-calendar-year-number" data-bx-year="' + v + '">' + v + '</span>');	
		});
	} else {
		addYearList.reverse();
		jQuery.each(addYearList, function(k,v) {
			jQuery('.bx-calendar-year-content').append('<span class="bx-calendar-year-number" data-bx-year="' + v + '">' + v + '</span>');	
		});
	}*/

}

</script>