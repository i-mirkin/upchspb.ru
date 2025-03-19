<?php
namespace TwimGossite\Helpers;

use Bitrix\Main\Loader;
use Bitrix\Main\Localization\Loc;
use Bitrix\Main\Mail\Event;

Loc::loadMessages(__FILE__);

class CEventGosApplication{   
    // OnBeforeUserUpdate
    function static OnBeforeUserUpdateHandler(&$arFields){
        $arErrors = [];
        if(is_set($arFields, "NAME") && strlen($arFields["NAME"])<=0) 
        {
            $arErrors[] = Loc::getMessage('ER_EMPTY_NAME_USER');
        }
        if(is_set($arFields, "LAST_NAME") && strlen($arFields["LAST_NAME"])<=0)
        {
            $arErrors[] = Loc::getMessage('ER_EMPTY_SURNAME_USER');
        }
        if(!empty($arErrors)){
            global $APPLICATION;
            $APPLICATION->throwException(implode("<br>", $arErrors));
            return false;
        }
    }
    
    // OnBeforeIBlockElementUpdate
    function static OnBeforeIBlockElementUpdateHandler(&$arFields){
        Loader::includeModule("iblock");
        global $USER_FIELD_MANAGER;      
        $arUserFieldsIblock  = $USER_FIELD_MANAGER->GetUserFields('ASD_IBLOCK',intval($arFields["IBLOCK_ID"]));
        
        // sending answer by form question    
        if(intval($arUserFieldsIblock["UF_SEND_MAIL_QUEST"]["VALUE"]) === 1){
           self::SendAnswerByQuestion($arFields); 
        }
        // sending internet-reception
        if(intval($arUserFieldsIblock["UF_SEND_MAIL_IR"]["VALUE"]) === 1){
            self::SendMailInternetRecieption($arFields); 
        }  
    }
    
    /**
     * send Answer By Question
     * @param type $arFields
     */
    protected static function SendAnswerByQuestion($arFields){
        Loader::includeModule("iblock");
        $arSelect = Array("ID", "IBLOCK_ID", "NAME", "ACTIVE", "PROPERTY_EMAIL", "PROPERTY_otvet");
        $arFilter = Array("IBLOCK_ID"=>IntVal($arFields["IBLOCK_ID"]), "ID" =>IntVal($arFields["ID"]));
        $res = \CIBlockElement::GetList(Array(), $arFilter, false, Array("nTopCount"=>1), $arSelect);
        if($ob = $res->GetNextElement()){ 
            $arFieldsOld = $ob->GetFields();  
            $arProps = $ob->GetProperties();
            if($arFieldsOld["ACTIVE"] === "N" && $arFields["ACTIVE"] === "Y"){
                $answer = '';
                foreach ($arFields["PROPERTY_VALUES"][$arProps["otvet"]["ID"]] as $item) {
                    $answer .= strip_tags($item["VALUE"]["TEXT"]) . "\n\r";
                }
                if(!empty($arProps["EMAIL"]["VALUE"]) && !empty($answer)){
                    $rsSites = \CIBlock::GetSite($arFields["IBLOCK_ID"]);
                    while($arSite = $rsSites->Fetch()) {
                        Event::send(array(
                            "EVENT_NAME" => "ANSWER_FORM",
                            "LID" => $arSite["LID"],
                            "C_FIELDS" => array(
                                "EMAIL_TO" => $arProps["EMAIL"]["VALUE"],
                                "ID" => $arFields["ID"],
                                "TEXT" => $arFields["NAME"],
                                "ANSWER" => $answer
                            ),
                        )); 
                    }   
                } 
            }
        }
    }
    /**
     * send  Mail Internet-Recieption
     * @param type $arFields
     */
    protected static function SendMailInternetRecieption($arFields){
        Loader::includeModule("iblock");
        $arSelect = Array("ID", "IBLOCK_ID", "NAME", "ACTIVE", "PROPERTY_MESSAGE", "PROPERTY_ANSWER", "PROPERTY_STATUS");
        $arFilter = Array("IBLOCK_ID"=>IntVal($arFields["IBLOCK_ID"]), "ID" =>IntVal($arFields["ID"]));
        $res = \CIBlockElement::GetList(Array(), $arFilter, false, Array("nTopCount"=>1), $arSelect);
        if($ob = $res->GetNextElement()){
            $EventName = "";
            $statusName = "";
            $arFieldsEl = $ob->GetFields();  
            $arProps = $ob->GetProperties();
            //get status
            $propertyStatus = \CIBlockPropertyEnum::GetList(Array("DEF"=>"DESC", "SORT"=>"ASC"), Array("IBLOCK_ID"=>IntVal($arFields["IBLOCK_ID"]), "CODE"=>"STATUS"));
            while($enum_fields = $propertyStatus->GetNext()){
                if($arFields["PROPERTY_VALUES"][$arProps["STATUS"]["ID"]][0]["VALUE"] == $enum_fields["ID"]){
                    $statusName = $enum_fields["VALUE"];
                }
            }
            //get Answer value id
            $idPropsAnswer = $arProps["ANSWER"]["ID"];
            $db_props = \CIBlockElement::GetProperty(IntVal($arFields["IBLOCK_ID"]), $arFields["ID"], array("sort" => "asc"), Array("CODE"=>"ANSWER"));
            if($ar_props = $db_props->Fetch()){
                $propsAnswerValueId = $ar_props["PROPERTY_VALUE_ID"];
            } else {
                $propsAnswerValueId = "n0";
            }
            //send answer 
            if(!empty($arFields["PROPERTY_VALUES"][$idPropsAnswer][$propsAnswerValueId]["VALUE"]["TEXT"]) && $arFields["PROPERTY_VALUES"][$idPropsAnswer][$propsAnswerValueId]["VALUE"]["TEXT"] !== $arProps["ANSWER"]["VALUE"]["TEXT"]){
               $EventName = "IR_ADD_ANSWER";
            // change status
            } elseif ($arProps["STATUS"]["VALUE_ENUM_ID"] !== $arFields["PROPERTY_VALUES"][$arProps["STATUS"]["ID"]][0]["VALUE"]){ 
                $EventName = "IR_CHANGE_STATUS";
            }
            if(!empty($EventName)){
                $rsSites = \CIBlock::GetSite($arFields["IBLOCK_ID"]);
                while($arSite = $rsSites->Fetch()) {
                    Event::send(array(
                        "EVENT_NAME" => $EventName, 
                        "LID" => $arSite["LID"],
                        "C_FIELDS" => array(
                            "STATUS" => $statusName,
                            "TEXT" => $arProps["MESSAGE"]["VALUE"]["TEXT"], 
                            "E_MAIL_AUTHOR" => $arProps["E_MAIL_AUTHOR"]["VALUE"],
                            "ANSWER" => $arFields["PROPERTY_VALUES"][$idPropsAnswer][$propsAnswerValueId]["VALUE"]["TEXT"], 
                            "ID" => $arFields["ID"]
                        ),
                    )); 
                }
            }
        }
    } 
}