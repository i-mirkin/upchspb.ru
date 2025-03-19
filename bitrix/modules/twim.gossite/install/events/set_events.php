<?
global $DB;
$MODULE_ID = "twim.gossite";
$arEvents = array();
$rs = $DB->Query("SELECT * FROM b_event_type WHERE  EVENT_NAME IN ('IR_NEW_USER', 'IR_FEEDBACK_FORM', 'IR_CHANGE_STATUS', 'IR_ADD_ANSWER', 'QUESTION_FORM', 'ANSWER_FORM');", false, "File: ".__FILE__."<br>Line: ".__LINE__);
while($ar = $rs->Fetch()){
    $arEvents[$ar["LID"]][$ar["EVENT_NAME"]] = $ar;
}
$langs = CLanguage::GetList(($b=""), ($o=""));
while ($lang = $langs->Fetch())
{
	$lid = $lang["LID"];
	IncludeModuleLangFile($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/" . $MODULE_ID . "/install/events/set_events.php", $lid);
    
    if(!isset($arEvents[$lid]["QUESTION_FORM"])){
        $et = new CEventType;
        $et->Add(array(
            "LID" => $lid,
            "EVENT_NAME" => "QUESTION_FORM",
            "NAME" => GetMessage("GOSSITE_QUESTION_FORM_TYPE_NAME"),
            "DESCRIPTION" => GetMessage("GOSSITE_QUESTION_FORM_DESCRIPTION"),
        ));
    }
    if(!isset($arEvents[$lid]["ANSWER_FORM"])){
        $et = new CEventType;
        $et->Add(array(
            "LID" => $lid,
            "EVENT_NAME" => "ANSWER_FORM",
            "NAME" => GetMessage("GOSSITE_ANSWER_FORM_TYPE_NAME"),
            "DESCRIPTION" => GetMessage("GOSSITE_ANSWER_FORM_DESCRIPTION"),
        ));
    }
    if(!isset($arEvents[$lid]["IR_NEW_USER"])){
        $et = new CEventType;
        $et->Add(array(
            "LID" => $lid,
            "EVENT_NAME" => "IR_NEW_USER",
            "NAME" => GetMessage("GOSSITE_IR_NEW_USER_TYPE_NAME"),
            "DESCRIPTION" => GetMessage("GOSSITE_IR_NEW_USER_DESCRIPTION"),
        ));
    }
    if(!isset($arEvents[$lid]["IR_FEEDBACK_FORM"])){
        $et = new CEventType;
        $et->Add(array(
            "LID" => $lid,
            "EVENT_NAME" => "IR_FEEDBACK_FORM",
            "NAME" => GetMessage("GOSSITE_IR_FEEDBACK_FORM_TYPE_NAME"),
            "DESCRIPTION" => GetMessage("GOSSITE_IR_FEEDBACK_FORM_DESCRIPTION"),
        ));
    }
    if(!isset($arEvents[$lid]["IR_CHANGE_STATUS"])){
        $et = new CEventType;
        $et->Add(array(
            "LID" => $lid,
            "EVENT_NAME" => "IR_CHANGE_STATUS",
            "NAME" => GetMessage("GOSSITE_IR_CHANGE_STATUS_TYPE_NAME"),
            "DESCRIPTION" => GetMessage("GOSSITE_IR_CHANGE_STATUS_DESCRIPTION"),
        ));
    }
    if(!isset($arEvents[$lid]["IR_ADD_ANSWER"])){
        $et = new CEventType;
        $et->Add(array(
            "LID" => $lid,
            "EVENT_NAME" => "IR_ADD_ANSWER",
            "NAME" => GetMessage("GOSSITE_IR_ADD_ANSWER_TYPE_NAME"),
            "DESCRIPTION" => GetMessage("GOSSITE_IR_ADD_ANSWER_DESCRIPTION"),
        ));
    }
}
?>