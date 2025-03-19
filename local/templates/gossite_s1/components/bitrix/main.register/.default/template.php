<?
/**
 * Bitrix Framework
 * @package bitrix
 * @subpackage main
 * @copyright 2001-2014 Bitrix
 */

/**
 * Bitrix vars
 * @global CMain $APPLICATION
 * @global CUser $USER
 * @param array $arParams
 * @param array $arResult
 * @param CBitrixComponentTemplate $this
 */
if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)
	die();?>
<div class="ir-registration">
    <?if($USER->IsAuthorized()):?>
        <p><?echo GetMessage("MAIN_REGISTER_AUTH")?></p>
    <?else:?>
        <h3 class="ir-title"><?=GetMessage("AUTH_REGISTER")?></h3>
        <?
        if (count($arResult["ERRORS"]) > 0):
            foreach ($arResult["ERRORS"] as $key => $error)
                if (intval($key) == 0 && $key !== 0) 
                    $arResult["ERRORS"][$key] = str_replace("#FIELD_NAME#", "&quot;".GetMessage("REGISTER_FIELD_".$key)."&quot;", $error);
                ShowError(implode("<br />", $arResult["ERRORS"]));   
        elseif($arResult["USE_EMAIL_CONFIRMATION"] === "Y"):?>
            <p><?echo GetMessage("REGISTER_EMAIL_WILL_BE_SENT")?></p>
        <?endif?>
       
        <form class="ir-registration__form" method="post" action="<?=POST_FORM_ACTION_URI?>" name="regform" enctype="multipart/form-data">
            <?
            if($arResult["BACKURL"] <> ''):
            ?>
                <input type="hidden" name="backurl" value="<?=$arResult["BACKURL"]?>" />
            <?
            endif;
            ?>   
            <?foreach ($arResult["SHOW_FIELDS"] as $FIELD):?>
                <div class="form-group">
                    <label><?=GetMessage("REGISTER_FIELD_".$FIELD)?>:<?if ($arResult["REQUIRED_FIELDS_FLAGS"][$FIELD] == "Y"):?><span class="require">*</span><?endif?></label>
                    <br>
                    <?
                switch ($FIELD)
                {
                    case "PASSWORD":?>
                    <input class="form-control" size="30" type="password" name="REGISTER[<?=$FIELD?>]" value="<?=$arResult["VALUES"][$FIELD]?>" autocomplete="off" />
                    <?
                    break;
                    case "CONFIRM_PASSWORD":
                        ?><input class="form-control" size="30" type="password" name="REGISTER[<?=$FIELD?>]" value="<?=$arResult["VALUES"][$FIELD]?>" autocomplete="off" /><?
                        break;

                    case "PERSONAL_GENDER":
                        ?><select name="REGISTER[<?=$FIELD?>]">
                            <option value=""><?=GetMessage("USER_DONT_KNOW")?></option>
                            <option value="M"<?=$arResult["VALUES"][$FIELD] == "M" ? " selected=\"selected\"" : ""?>><?=GetMessage("USER_MALE")?></option>
                            <option value="F"<?=$arResult["VALUES"][$FIELD] == "F" ? " selected=\"selected\"" : ""?>><?=GetMessage("USER_FEMALE")?></option>
                        </select><?
                        break;

                    case "PERSONAL_COUNTRY":
                    case "WORK_COUNTRY":
                        ?><select name="REGISTER[<?=$FIELD?>]"><?
                        foreach ($arResult["COUNTRIES"]["reference_id"] as $key => $value)
                        {
                            ?><option value="<?=$value?>"<?if ($value == $arResult["VALUES"][$FIELD]):?> selected="selected"<?endif?>><?=$arResult["COUNTRIES"]["reference"][$key]?></option>
                        <?
                        }
                        ?></select><?
                        break;

                    case "PERSONAL_PHOTO":
                    case "WORK_LOGO":
                        ?><input class="form-control" size="30" type="file" name="REGISTER_FILES_<?=$FIELD?>" /><?
                        break;

                    case "PERSONAL_NOTES":
                    case "WORK_NOTES":
                        ?><textarea class="form-control" cols="30" rows="5" name="REGISTER[<?=$FIELD?>]"><?=$arResult["VALUES"][$FIELD]?></textarea><?
                        break;
                    default:
                        if ($FIELD == "PERSONAL_BIRTHDAY"):?><small><?=$arResult["DATE_FORMAT"]?></small><br /><?endif;
                        ?><input size="30" class="form-control" type="text" name="REGISTER[<?=$FIELD?>]" value="<?=$arResult["VALUES"][$FIELD]?>" /><?
                            if ($FIELD == "PERSONAL_BIRTHDAY")
                                $APPLICATION->IncludeComponent(
                                    'bitrix:main.calendar',
                                    '',
                                    array(
                                        'SHOW_INPUT' => 'N',
                                        'FORM_NAME' => 'regform',
                                        'INPUT_NAME' => 'REGISTER[PERSONAL_BIRTHDAY]',
                                        'SHOW_TIME' => 'N'
                                    ),
                                    null,
                                    array("HIDE_ICONS"=>"Y")
                                );
                    }?>
                </div>   
            <?endforeach?>    

            <?// ********************* User properties ***************************************************?>
            <?if($arResult["USER_PROPERTIES"]["SHOW"] == "Y"):?>
                <?=strlen(trim($arParams["USER_PROPERTY_NAME"])) > 0 ? $arParams["USER_PROPERTY_NAME"] : GetMessage("USER_TYPE_EDIT_TAB")?>
                <?foreach ($arResult["USER_PROPERTIES"]["DATA"] as $FIELD_NAME => $arUserField):?>
               <?=$arUserField["EDIT_FORM_LABEL"]?>:<?if ($arUserField["MANDATORY"]=="Y"):?><span class="starrequired">*</span><?endif;?>
                        <?$APPLICATION->IncludeComponent(
                            "bitrix:system.field.edit",
                            $arUserField["USER_TYPE"]["USER_TYPE_ID"],
                            array("bVarsFromForm" => $arResult["bVarsFromForm"], "arUserField" => $arUserField, "form_name" => "regform"), null, array("HIDE_ICONS"=>"Y"));?>
                <?endforeach;?>
            <?endif;?>
            <?// ******************** /User properties ***************************************************?>
            <?if($arResult["USE_CAPTCHA"] == "Y"):?>
                <input type="hidden" name="captcha_sid" value="<?echo $arResult["CAPTCHA_CODE"]?>" />
                <div class="form-group">
                    <label> <?echo GetMessage("REGISTER_CAPTCHA_TITLE")?>:</label>
                    <img src="/bitrix/tools/captcha.php?captcha_sid=<?echo $arResult["CAPTCHA_CODE"]?>" width="180" height="40" alt="CAPTCHA" class="ir-captcha-img" />
                    <input type="text" name="captcha_word" class="form-control" maxlength="50" value="" autocomplete="off" />
                </div>
            <?endif;?>
            <div class="form-group">
                <button class="btn btn-info btn-sm" type="submit" name="register_submit_button" value="<?=GetMessage("AUTH_REGISTER")?>"><?=GetMessage("AUTH_REGISTER")?></button>
            </div>
        </form> 
        <p><?echo $arResult["GROUP_POLICY"]["PASSWORD_REQUIREMENTS"];?></p>
        <p><span class="require">*</span> <?=GetMessage("AUTH_REQ")?></p>
        <p>
            <a href="<?echo $APPLICATION->GetCurPageParam("login=yes", array(
                "login",
                "logout",
                "register",
                "forgot_password",
                "change_password"));?>"><?=GetMessage("REGISTER_AUTH_LINK")?></a>
            <br>
        </p>
    <?endif?>
</div>
<!--.ir-registration-->