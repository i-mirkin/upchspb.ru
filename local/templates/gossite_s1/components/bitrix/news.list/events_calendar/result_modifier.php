<?php 

    $arSelect = Array("ID", "NAME", "DATE_ACTIVE_FROM");
    $arFilter = Array("IBLOCK_ID" => 33, "PROPERTY_CALENDAR_VALUE" => "Y", "ACTIVE"=>"Y");
    $res = CIBlockElement::GetList([], $arFilter);    
    while($ob = $res->GetNextElement())
    {
        $arFields = $ob->GetFields();
        $arResult["ITEMS"][] = ['DISPLAY_ACTIVE_FROM' => $arFields['ACTIVE_FROM'], 'ACTIVE_FROM'=>$arFields['ACTIVE_FROM']];
    }
