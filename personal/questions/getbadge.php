<?
header('Content-Type: application/json');
require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/modules/main/include/prolog_before.php");
CModule::IncludeModule("iblock");
global $USER;
$PROPERTY_COMPLETE_Y_ID = 85;
$IBLOCK_ID = 22;
//$userid = $_POST['userid'];
if (!$USER->IsAuthorized()) {
    echo 'Польз. не авторизован';
}
else {
    // определяем группу пользователя
    $arGroups = CUser::GetUserGroup($USER->GetID());

    // 82 = DIRECTOR  83 = HEAD 84 = EXECUTOR
    // ДЛЯ ДИРЕКТОРА
    if (in_array(9, $arGroups)) {
        // все задачи у Р
        $cntItems = CIBlockElement::GetList(
            false,
            array('IBLOCK_ID' => $IBLOCK_ID, 'PROPERTY_DIRECTOR' => $USER->GetID(), 'PROPERTY_HOLDER' => 82, '!PROPERTY_COMPLETE' => $PROPERTY_COMPLETE_Y_ID),
            array('IBLOCK_ID')
        )->Fetch()['CNT'];
        $result['MY'] = $cntItems;

        // все задачи Р, которые он передал Начальникам отделов
        $cntItems = CIBlockElement::GetList(
            false,
            array('IBLOCK_ID' => $IBLOCK_ID, 'PROPERTY_DIRECTOR' => $USER->GetID(), 'PROPERTY_HOLDER' => 83, '!PROPERTY_COMPLETE' => $PROPERTY_COMPLETE_Y_ID),
            array('IBLOCK_ID')
        )->Fetch()['CNT'];
        $result['HEAD'] = $cntItems;

        // все задачи Р, которые Начальники отделов передали Исполнителям
        $cntItems = CIBlockElement::GetList(
            false,
            array('IBLOCK_ID' => $IBLOCK_ID, 'PROPERTY_DIRECTOR' => $USER->GetID(), 'PROPERTY_HOLDER' => 84, '!PROPERTY_COMPLETE' => $PROPERTY_COMPLETE_Y_ID),
            array('IBLOCK_ID')
        )->Fetch()['CNT'];
        $result['EXECUTOR'] = $cntItems;
    }
    // ДЛЯ НО
    elseif (in_array(10, $arGroups)) {
        // все задачи у текущего НО
        $cntItems = CIBlockElement::GetList(
            false,
            array('IBLOCK_ID' => $IBLOCK_ID, 'PROPERTY_HEAD' => $USER->GetID(), 'PROPERTY_HOLDER' => 83, '!PROPERTY_COMPLETE' => $PROPERTY_COMPLETE_Y_ID),
            array('IBLOCK_ID')
        )->Fetch()['CNT'];
        $result['MY'] = $cntItems;

        // все задачи текущего НО, которые он передал Исполнителям
        $cntItems = CIBlockElement::GetList(
            false,
            array('IBLOCK_ID' => $IBLOCK_ID, 'PROPERTY_HEAD' => $USER->GetID(), 'PROPERTY_HOLDER' => 84, '!PROPERTY_COMPLETE' => $PROPERTY_COMPLETE_Y_ID),
            array('IBLOCK_ID')
        )->Fetch()['CNT'];
        $result['EXECUTOR'] = $cntItems;
    }
    // ДЛЯ ИСПОЛНИТЕЛЯ
    elseif (in_array(11, $arGroups)) {
        // все задачи у текущего И
        $cntItems = CIBlockElement::GetList(
            false,
            array('IBLOCK_ID' => $IBLOCK_ID, 'PROPERTY_EXECUTOR' => $USER->GetID(), 'PROPERTY_HOLDER' => 84, '!PROPERTY_COMPLETE' => $PROPERTY_COMPLETE_Y_ID),
            array('IBLOCK_ID')
        )->Fetch()['CNT'];
        $result['MY'] = $cntItems;
    }
}
echo json_encode($result);
?>