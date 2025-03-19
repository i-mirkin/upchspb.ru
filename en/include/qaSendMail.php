<?
require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/modules/main/include/prolog_before.php"); 
use \Bitrix\Main\Loader;
use \Bitrix\Main\Mail\Event;
Loader::includeModule('iblock');

$request = \Bitrix\Main\Context::getCurrent()->getRequest();
$elementId = $request->get('ID') ?: '';

if($elementId) {	
		
	$arFields = [];
	$arSelect = Array("PREVIEW_TEXT", "PROPERTY_otvet", "PROPERTY_EMAIL");
	$arFilter = Array("IBLOCK_ID"=>22, "ID" => $elementId);
	$res = CIBlockElement::GetList(Array(), $arFilter, false, array(), $arSelect);
	while($ob = $res->GetNextElement())
	{
		$arFields = $ob->GetFields();	
	}

	if(!empty($arFields)) {
		if(empty($arFields['PROPERTY_OTVET_VALUE'])) {
			$result = [
				'STATUS' => 'error',
				'EXP' => 'Не заполнено поле Ответ.'
			];
			echo json_encode($result);		
			return;
		}
		
		
		$dataSend = [
			'EVENT_NAME' => 'QA_SEND_RESPONSE',
			'LID' => 's1',		
			'C_FIELDS' => [
				'EMAIL' => $arFields['PROPERTY_EMAIL_VALUE'],
				'QUESTION' => $arFields['PREVIEW_TEXT'],
				'ANSWER' => $arFields['~PROPERTY_OTVET_VALUE']['TEXT']
			]
		];
		
		$eventSend = Event::send($dataSend); 
		
		if($eventSend) {
			$result = [
				'STATUS' => 'ok',				
				'EMAIL' => $arFields['PROPERTY_EMAIL_VALUE'],				
			];
			
			echo json_encode($result);
			
			return;
		}
	}
	
	return false;
}