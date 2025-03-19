<?
if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true)
{
	die();
}
/**
 * @global CMain $APPLICATION
 * @var array $arParams
 * @var array $arResult
 */?>
<div class="ir-rec-password">
    <h3 class="ir-title"><?=GetMessage("AUTH_FORGOT_PASSWORD_TITLE")?></h3>
    <?
    if(!empty($arParams["~AUTH_RESULT"])):
	$text = str_replace(array("<br>", "<br />"), "\n", $arParams["~AUTH_RESULT"]["MESSAGE"]);
    ?>
        <?if($arParams["~AUTH_RESULT"]["TYPE"] == "OK"):?>
            <?ShowMessage(Array("TYPE"=>"OK", "MESSAGE"=>$text));?>
            <?else:?>
            <?ShowError($text);?>
        <?endif?>
    <?endif?>
    <p><?=GetMessage("AUTH_FORGOT_PASSWORD_1")?></p>
    <p><b><?=GetMessage("AUTH_GET_CHECK_STRING")?></b></p>
    <form class="ir-rec-password__form" name="bform" method="post" target="_top" action="<?=$arResult["AUTH_URL"]?>">
        <?if($arResult["BACKURL"] <> ''):?>
            <input type="hidden" name="backurl" value="<?=$arResult["BACKURL"]?>" />
        <?endif?>
		<input type="hidden" name="AUTH_FORM" value="Y">
		<input type="hidden" name="TYPE" value="SEND_PWD">
        <div class="form-group">
            <label><?echo GetMessage("AUTH_LOGIN_EMAIL")?>:</label>
            <br>
            <input class="form-control" type="text" name="USER_LOGIN" maxlength="255" value="<?=$arResult["LAST_LOGIN"]?>" />
			<input type="hidden" name="USER_EMAIL" />
        </div>
        <?if($arResult["USE_CAPTCHA"]):?>
            <input type="hidden" name="captcha_sid" value="<?echo $arResult["CAPTCHA_CODE"]?>" />
            <div class="form-group">
                <label> <?echo GetMessage("system_auth_captcha")?>:</label>
                <img src="/bitrix/tools/captcha.php?captcha_sid=<?echo $arResult["CAPTCHA_CODE"]?>" width="180" height="40" alt="CAPTCHA" class="ir-captcha-img" />
                <input type="text" name="captcha_word" class="form-control" maxlength="50" value="" autocomplete="off" />
            </div>
        <?endif;?>
        <div class="form-group">
            <button type="submit" class="btn btn-info btn-sm" name="send_account_info" value="<?=GetMessage("AUTH_SEND")?>"><?=GetMessage("AUTH_SEND")?></button>
        </div>
    </form>
    <p>
        <a href="<?=$arResult["AUTH_AUTH_URL"]?>"><?=GetMessage("AUTH_AUTH")?></a>
        <br>
    </p>
</div>
<script type="text/javascript">
document.bform.onsubmit = function(){document.bform.USER_EMAIL.value = document.bform.USER_LOGIN.value;};
document.bform.USER_LOGIN.focus();
</script>
