<?php
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_before.php");
CModule::IncludeModule("iblock");

if($_POST["action"] == "appointment"){

    // название Темы
    $rsThemes = CIBlockElement::GetList(array(), array('IBLOCK_ID' => 38, 'ID' => $_POST['theme_id'], 'ACTIVE' => 'Y'), false, false, array('ID', 'NAME'));
    $arTheme = $rsThemes->GetNext();
    // название Часов
    $rsHours = CIBlockElement::GetList(array(), array('IBLOCK_ID' => 37, 'ID' => $_POST["hours"], 'ACTIVE' => 'Y'), false, false, array('ID', 'NAME'));
    $arHour = $rsHours->GetNext();


    $IBLOCK_ID = 39; //Запись
    $el = new CIBlockElement;
    $PROP = array();
    $PROP[97] = ""; // Расписание, привязка к элементу сгенерированного расписания
    $PROP[98] = $_POST["name"];
    $PROP[99] = $_POST["surname"];
    $PROP[100] = $_POST["patronymic"];
    $PROP[101] = $_POST["phone"];
    $PROP[102] = $_POST["email"];
    $PROP[103] = $_POST["postaddr"];
    $PROP[158] = $_POST["date"]; // Дата записи
    $PROP[159] = $_POST["hours"]; // Время записи
    $NAME = $arTheme['NAME'].'_'.$_POST["date"].'_'.$arHour['NAME'];
    $arLoadProductArray = Array(
        "IBLOCK_SECTION_ID" => false, // элемент лежит в корне раздела
        "IBLOCK_ID"      => $IBLOCK_ID,
        "PROPERTY_VALUES"=> $PROP,
        "NAME"           => $NAME,
        "PREVIEW_TEXT"   => $_POST["reason"],
        "ACTIVE"         => "Y",
    );
    $RESULT_ID = $el->Add($arLoadProductArray);

    $arResult["DEBUG"] = $PROP;

    if($RESULT_ID) {
        $arResult["RESULT"] =  "OK";
        $arResult["MESSAGE"] =  "Вы записаны на прием ".$_POST['date'].' в '.$arHour['NAME'].' по вопросу '. $arTheme['NAME'];
    }
    else {
        $arResult["RESULT"] =  "ERROR";
        $arResult["MESSAGE"] =  "Что-то пошло не так, попробуйте позже [".$el->LAST_ERROR."].";
    }

}

echo json_encode($arResult);
