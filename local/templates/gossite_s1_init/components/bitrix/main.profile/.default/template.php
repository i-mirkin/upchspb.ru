<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true)
	die();
?>
<div class="ir-profile">
    <?if(!empty($arResult["strProfileError"])){
        ShowError($arResult["strProfileError"]);
    }?>
    <?if ($arResult['DATA_SAVED'] == 'Y'){
        ShowMessage(Array("TYPE"=>"OK", "MESSAGE"=>GetMessage('PROFILE_DATA_SAVED')));
    }?>
<form method="post" name="form1" action="<?=$arResult["FORM_TARGET"]?>" class="ir-registration__form" enctype="multipart/form-data">
<?=$arResult["BX_SESSION_CHECK"]?>
<input type="hidden" name="lang" value="<?=LANG?>" />
<input type="hidden" name="ID" value=<?=$arResult["ID"]?> />
        <?
        if($arResult["ID"]>0)
        {
        ?>
            <?
            if (strlen($arResult["arUser"]["TIMESTAMP_X"])>0)
            {
            ?>
            <p><?=GetMessage('LAST_UPDATE')?> <?=$arResult["arUser"]["TIMESTAMP_X"]?></p>
            <?
            }
            ?>
            <?
            if (strlen($arResult["arUser"]["LAST_LOGIN"])>0)
            {
            ?>
            <p><?=GetMessage('LAST_LOGIN')?> <?=$arResult["arUser"]["LAST_LOGIN"]?></p>
            <?
            }
            ?>
        <?
        }
        ?>
        <div class="form-group">
            <label><?=GetMessage('NAME')?><span class="require">*</span></label>
            <br>
            <input type="text" name="NAME" maxlength="50" class="form-control" value="<?=$arResult["arUser"]["NAME"]?>" />
        </div>
        <div class="form-group">
            <label><?=GetMessage('LAST_NAME')?><span class="require">*</span></label>
            <br>
            <input type="text" name="LAST_NAME" maxlength="50" class="form-control" value="<?=$arResult["arUser"]["LAST_NAME"]?>" />
        </div>
        <div class="form-group">
            <label><?=GetMessage('SECOND_NAME')?></label>
            <br>
            <input type="text" name="SECOND_NAME" maxlength="50" class="form-control" value="<?=$arResult["arUser"]["SECOND_NAME"]?>" />
        </div>
        <div class="form-group">
            <label><?=GetMessage('EMAIL')?><?if($arResult["EMAIL_REQUIRED"]):?><span class="require">*</span><?endif?></label>
            <br>
            <input type="text" name="EMAIL" maxlength="50" class="form-control" value="<? echo $arResult["arUser"]["EMAIL"]?>" />
        </div>
        <?if($arResult["arUser"]["EXTERNAL_AUTH_ID"] == ''):?>
        <div class="form-group">
            <label><?=GetMessage('NEW_PASSWORD_REQ')?></label>
            <br>
            <input type="password" name="NEW_PASSWORD" maxlength="50" value="" autocomplete="off" class="form-control" />
        </div>
        <div class="form-group">
            <label><?=GetMessage('NEW_PASSWORD_CONFIRM')?></label>
            <br>
            <input type="password" name="NEW_PASSWORD_CONFIRM" maxlength="50" value="" autocomplete="off" class="form-control" />
        </div>
        <?endif?>    
        <div class="form-group">
            <label><?=GetMessage('USER_PHONE')?></label>
            <br>
           <input type="text" name="PERSONAL_PHONE" maxlength="255" value="<?=$arResult["arUser"]["PERSONAL_PHONE"]?>" class="form-control" />
        </div>
        <div class="form-group">
            <label><?=GetMessage('USER_CITY')?></label>
            <br>
            <input type="text" name="PERSONAL_CITY" maxlength="255" value="<?=$arResult["arUser"]["PERSONAL_CITY"]?>" class="form-control" />
        </div>
        <div class="form-group">
            <button class="btn btn-info btn-sm" type="submit" name="save" value="<?=(($arResult["ID"]>0) ? GetMessage("MAIN_SAVE") : GetMessage("MAIN_ADD"))?>"><?=(($arResult["ID"]>0) ? GetMessage("MAIN_SAVE") : GetMessage("MAIN_ADD"))?></button>
        </div>
        <p><?echo $arResult["GROUP_POLICY"]["PASSWORD_REQUIREMENTS"];?></p>
        <p><span class="require">*</span> <?=getMessage("REG_REQUARE_FEILDS")?></p>
    </form>
    <?
    if($arResult["SOCSERV_ENABLED"])
    {
        $APPLICATION->IncludeComponent("bitrix:socserv.auth.split", ".default", array(
                "SHOW_PROFILES" => "Y",
                "ALLOW_DELETE" => "Y"
            ),
            false
        );
    }
    ?>
</div>