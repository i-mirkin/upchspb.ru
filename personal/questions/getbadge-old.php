<?
header('Content-Type: application/json');
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_before.php");
CModule::IncludeModule("iblock");
global $USER;
//$userid = $_POST['userid'];
if(!$USER->IsAuthorized()) echo 'Польз. не авторизован';
else {
	// определяем группу пользователя
	$arGroups = CUser::GetUserGroup($USER->GetID());
	
	if(in_array(9, $arGroups)){ // Руководитель -> выбираем все новые, а так же готовые к отправке
		// старые без статуса
		//$cntItems = CIBlockElement::GetList(false,array('IBLOCK_ID' => 22, 'PROPERTY_STATUS' => array(false, 64, 68)), array('IBLOCK_ID'))->Fetch()['CNT'];
		// в новых статус по умолчанию ставим "Новое"
		$cntItems = CIBlockElement::GetList(false,array('IBLOCK_ID' => 22, 'PROPERTY_STATUS' => array(64, 68)), array('IBLOCK_ID'))->Fetch()['CNT'];
		
	}
	elseif(in_array(10, $arGroups)){ // для начальника отдела выбираем все его задачи
		$cntItems = CIBlockElement::GetList(false,array('IBLOCK_ID' => 22, 'PROPERTY_HEAD' => $USER->GetID()), array('IBLOCK_ID'))->Fetch()['CNT'];
	}
	elseif(in_array(11, $arGroups)){ // для исполнителя выбираем все его задачи
		$cntItems = CIBlockElement::GetList(false, array('IBLOCK_ID' => 22, 'PROPERTY_EXECUTOR' => $USER->GetID()), array('IBLOCK_ID'))->Fetch()['CNT'];
	}
	
	
	// определяем сколько адресовано текущему пользователю 
	
	$result = array(
		'new'  => $cntItems
	);
 
	echo json_encode($result);

}

?>