<?php
$arDelEntity = [
    "UF_COUNTER_DOWNLOAD" => 'OPEN_DATA',
    "UF_SEND_MAIL_IR" => 'ASD_IBLOCK',
    "UF_SEND_MAIL_QUEST" => 'ASD_IBLOCK'
];

$rsData = CUserTypeEntity::GetList(array($by=>$order), array());
while($arRes = $rsData->Fetch()){
    if($arDelEntity[$arRes["FIELD_NAME"]] == $arRes["ENTITY_ID"]){
        $oUserTypeEntity = new CUserTypeEntity();
        $oUserTypeEntity->Delete($arRes["ID"]); 
    }
}