<?php
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();

use Bitrix\Main\Loader;

/**
 * Bitrix vars
 *
 * @var array $arParams
 * @var array $arResult
 * @var CBitrixComponent $this
 * @global CMain $APPLICATION
 * @global CUser $USER
 */

$arResult["PARAMS_HASH"] = md5(serialize($arParams) . $this->GetTemplateName());

$arParams["USE_CAPTCHA"] = (($arParams["USE_CAPTCHA"] != "N" && !$USER->IsAuthorized()) ? "Y" : "N");
$arParams["EVENT_NAME"] = trim($arParams["EVENT_NAME"]);
if ($arParams["EVENT_NAME"] == '')
    $arParams["EVENT_NAME"] = "QUESTION_FORM";
$arParams["EMAIL_TO"] = trim($arParams["EMAIL_TO"]);
if ($arParams["EMAIL_TO"] == '')
    $arParams["EMAIL_TO"] = COption::GetOptionString("main", "email_from");
$arParams["OK_TEXT"] = trim($arParams["OK_TEXT"]);
if ($arParams["OK_TEXT"] == '')
    $arParams["OK_TEXT"] = GetMessage("MF_OK_MESSAGE");

Loader::includeModule("iblock");

if ($_SERVER["REQUEST_METHOD"] == "POST" && $_POST["submit"] <> '' && (!isset($_POST["PARAMS_HASH"]) || $arResult["PARAMS_HASH"] === $_POST["PARAMS_HASH"])) {
    if (($_POST["AJAX_PAGE"]) === "Y" && LANG_CHARSET === 'windows-1251') {
        $_POST["user_name"] = iconv('UTF-8', 'windows-1251', $_POST["user_name"]);
        $_POST["user_email"] = iconv('UTF-8', 'windows-1251', $_POST["user_email"]);
        $_POST["user_phone"] = iconv('UTF-8', 'windows-1251', $_POST["user_phone"]);
        $_POST["MESSAGE"] = iconv('UTF-8', 'windows-1251', $_POST["MESSAGE"]);
    }

    $arResult["ERROR_MESSAGE"] = array();
    if (check_bitrix_sessid()) {
        if (empty($arParams["REQUIRED_FIELDS"]) || !in_array("NONE", $arParams["REQUIRED_FIELDS"])) {
            if ((empty($arParams["REQUIRED_FIELDS"]) || in_array("NAME", $arParams["REQUIRED_FIELDS"])) && strlen($_POST["user_name"]) <= 1)
                $arResult["ERROR_MESSAGE"][] = GetMessage("MF_REQ_NAME");
            if ((empty($arParams["REQUIRED_FIELDS"]) || in_array("EMAIL", $arParams["REQUIRED_FIELDS"])) && strlen($_POST["user_email"]) <= 1)
                $arResult["ERROR_MESSAGE"][] = GetMessage("MF_REQ_EMAIL");
            if ((empty($arParams["REQUIRED_FIELDS"]) || in_array("PHONE", $arParams["REQUIRED_FIELDS"])) && strlen($_POST["user_phone"]) <= 3)
                $arResult["ERROR_MESSAGE"][] = GetMessage("MF_REQ_PHONE");
            if ((empty($arParams["REQUIRED_FIELDS"]) || in_array("MESSAGE", $arParams["REQUIRED_FIELDS"])) && strlen($_POST["MESSAGE"]) <= 3)
                $arResult["ERROR_MESSAGE"][] = GetMessage("MF_REQ_MESSAGE");
            if ((empty($arParams["REQUIRED_FIELDS"]) || in_array("q_categ", $arParams["REQUIRED_FIELDS"])) && strlen($_POST["q_categ"]) <= 3)
                $arResult["ERROR_MESSAGE"][] = GetMessage("MF_REQ_CATEG");
        }
        if (strlen($_POST["user_email"]) > 1 && !check_email($_POST["user_email"])) {
            $arResult["ERROR_MESSAGE"][] = GetMessage("MF_EMAIL_NOT_VALID");
        }

        $qcapt = $_POST['qcapt'] ?: '';
        if (empty($qcapt) || $qcapt != 'Y') {
            $arResult["ERROR_MESSAGE"][] = GetMessage("SPAM_ERROR");
        }

        if ($arParams["USE_CAPTCHA"] == "Y") {
            include_once($_SERVER["DOCUMENT_ROOT"] . "/bitrix/modules/main/classes/general/captcha.php");
            $captcha_code = $_POST["captcha_sid"];
            $captcha_word = $_POST["captcha_word"];
            $cpt = new CCaptcha();
            $captchaPass = COption::GetOptionString("main", "captcha_password", "");
            if (strlen($captcha_word) > 0 && strlen($captcha_code) > 0) {
                if (!$cpt->CheckCodeCrypt($captcha_word, $captcha_code, $captchaPass))
                    $arResult["ERROR_MESSAGE"][] = GetMessage("MF_CAPTCHA_WRONG");
            }
            else
                $arResult["ERROR_MESSAGE"][] = GetMessage("MF_CAPTHCA_EMPTY");
        }

        if (empty($arResult["ERROR_MESSAGE"])) {

            $arParams["IBLOCK_ID"] = intval($arParams["IBLOCK_ID"]);
            if ($arParams["IBLOCK_ID"] > 0) {

                // add new elements
                $el = new CIBlockElement;
                $PROP = array();
                $PROP["USER"] = $_POST["user_name"];
                $PROP["EMAIL"] = $_POST["user_email"];
                $PROP["PHONE"] = $_POST["user_phone"];
                $PROP["Q_CATEGORY"] = $_POST["q_categ"];

                //im start
                $PROP["HOLDER"] = HOLDER_DIRECTOR_ID; // Новое сообщение по умолчанию у Руководителя (HOLDER_DIRECTOR_ID в init.php)

                // выбираем всех активных(!) Руководителей, сортируем по уровню и выбираем с самым высоким уровнем (с наименьшим значением)
                $rsUser = CUser::GetList(($by = "UF_LEVEL"), ($order = "asc"),
                    array(
                        "ACTIVE" => "Y",
                        "GROUPS_ID" => array(9)
                    ),
                    array(
                        "SELECT" => array(
                            "ID",
                        ),
                    )
                );

                // назначим Руководителя
                if ($arUser = $rsUser->Fetch()) {
                    $PROP["DIRECTOR"] = $arUser['ID'];
                }

                // создаем запись в логе
                $PROP["LOG"] = date('m.d.y H:m') . ' <span class="log-new">Новый вопрос</span>';
                // создаем первый комментарий
                $PROP["COMMENTS"] = date('m.d.y H:m') . ' Поступил новый вопрос для ' . CUser::GetByID($arUser['ID'])->Fetch()['LAST_NAME'] . ' ' . CUser::GetByID($arUser['ID'])->Fetch()['NAME'];

                //im end


                $db_props = CIBlockProperty::GetByID("AUHTOR_ANSWER", $arParams["IBLOCK_ID"]);
                if ($ar_res = $db_props->GetNext()) {
                    $PROP["AUHTOR_ANSWER"] = $ar_res["DEFAULT_VALUE"];
                }

                $qCategVal = '';
                if ($_POST["q_categ"]) {
                    $resCategoryEl = CIBlockElement::GetByID($_POST["q_categ"]);
                    if ($arResCategoryEl = $resCategoryEl->GetNext()) {
                        $qCategVal = $arResCategoryEl['NAME'];
                    }
                }

                $arLoadProductArray = array(
                    "DATE_ACTIVE_FROM" => ConvertTimeStamp(false, "FULL"),
                    "IBLOCK_SECTION_ID" => false,
                    "IBLOCK_ID" => $arParams["IBLOCK_ID"],
                    "PROPERTY_VALUES" => $PROP,
                    "NAME" => $_POST["MESSAGE"],
                    "ACTIVE" => "N",
                    "PREVIEW_TEXT" => $_POST["MESSAGE"],
                );

                $id_elements = $el->Add($arLoadProductArray);

            }

            $arFields = array(
                "AUTHOR" => $_POST["user_name"],
                "AUTHOR_EMAIL" => $_POST["user_email"],
                "EMAIL_TO" => $arParams["EMAIL_TO"],
                "TEXT" => $_POST["MESSAGE"],
                "PHONE" => $_POST["user_phone"],
                "CATEGORY" => $qCategVal,

            );

            if ($id_elements) {
                $arFields["IBLOCK_ID"] = $arParams["IBLOCK_ID"];
                $arFields["ID"] = $id_elements;
            }

            /*if(!empty($arParams["EVENT_MESSAGE_ID"]))
            {
                foreach($arParams["EVENT_MESSAGE_ID"] as $v)
                    if(IntVal($v) > 0)
                        CEvent::Send($arParams["EVENT_NAME"], SITE_ID, $arFields, "N", IntVal($v));
            }
            else*/
            $elID = CEvent::Send($arParams["EVENT_NAME"], SITE_ID, $arFields);

            $_SESSION["MF_NAME"] = htmlspecialcharsbx($_POST["user_name"]);
            $_SESSION["MF_EMAIL"] = htmlspecialcharsbx($_POST["user_email"]);
            $_SESSION["MF_PHONE"] = htmlspecialcharsbx($_POST["user_phone"]);
            LocalRedirect($APPLICATION->GetCurPageParam("success=" . $arResult["PARAMS_HASH"], array("success")));
        }

        $arResult["MESSAGE"] = htmlspecialcharsbx($_POST["MESSAGE"]);
        $arResult["AUTHOR_NAME"] = htmlspecialcharsbx($_POST["user_name"]);
        $arResult["AUTHOR_EMAIL"] = htmlspecialcharsbx($_POST["user_email"]);
        $arResult["AUTHOR_PHONE"] = htmlspecialcharsbx($_POST["user_phone"]);
    }
    else
        $arResult["ERROR_MESSAGE"][] = GetMessage("MF_SESS_EXP");
}
elseif ($_REQUEST["success"] == $arResult["PARAMS_HASH"]) {
    $arResult["OK_MESSAGE"] = $arParams["OK_TEXT"];
}

if (empty($arResult["ERROR_MESSAGE"])) {
    if ($USER->IsAuthorized()) {
        $arResult["AUTHOR_NAME"] = $USER->GetFormattedName(false);
        $arResult["AUTHOR_EMAIL"] = htmlspecialcharsbx($USER->GetEmail());
    }
    else {
        if (strlen($_SESSION["MF_NAME"]) > 0)
            $arResult["AUTHOR_NAME"] = htmlspecialcharsbx($_SESSION["MF_NAME"]);
        if (strlen($_SESSION["MF_EMAIL"]) > 0)
            $arResult["AUTHOR_EMAIL"] = htmlspecialcharsbx($_SESSION["MF_EMAIL"]);
        if (strlen($_SESSION["MF_PHONE"]) > 0)
            $arResult["AUTHOR_PHONE"] = htmlspecialcharsbx($_SESSION["MF_PHONE"]);
    }
}

if ($arParams["USE_CAPTCHA"] == "Y")
    $arResult["capCode"] = htmlspecialcharsbx($APPLICATION->CaptchaGetCode());

$arSelectCateg = array("ID", "NAME", "DATE_ACTIVE_FROM");
$arFilterCateg = array("IBLOCK_ID" => 43, "ACTIVE_DATE" => "Y", "ACTIVE" => "Y");
$arFieldsCateg = [];
$resCateg = CIBlockElement::GetList(array(), $arFilterCateg, false, array(), $arSelectCateg);
while ($obCateg = $resCateg->GetNextElement()) {
    $arFieldsCateg[] = $obCateg->GetFields();
}

$arResult['arFieldsCateg'] = $arFieldsCateg;

$this->IncludeComponentTemplate();
