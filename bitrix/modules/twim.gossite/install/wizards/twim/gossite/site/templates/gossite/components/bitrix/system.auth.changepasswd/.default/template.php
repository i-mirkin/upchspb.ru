<?
if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true)
{
	die();
}
/**
 * @global CMain $APPLICATION
 * @var array $arParams
 * @var array $arResult
 */

//one css for all system.auth.* forms?>
<div class="ir-rec-password">
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
    <h3 class="ir-title"><?=GetMessage("AUTH_CHANGE_PASSWORD")?></h3>
	<form method="post" class="ir-rec-password__form" action="<?=$arResult["AUTH_FORM"]?>" name="bform">
    <?if (strlen($arResult["BACKURL"]) > 0): ?>
        <input type="hidden" name="backurl" value="<?=$arResult["BACKURL"]?>" />
    <? endif ?>
		<input type="hidden" name="AUTH_FORM" value="Y">
		<input type="hidden" name="TYPE" value="CHANGE_PWD">

        <div class="form-group">
            <label><?=GetMessage("AUTH_LOGIN")?>:</label>
            <br>
            <input class="form-control" type="text" name="USER_LOGIN" maxlength="255" value="<?=$arResult["LAST_LOGIN"]?>" />
        </div>
        <div class="form-group">
            <label><?=GetMessage("AUTH_CHECKWORD")?>:</label>
            <br>
            <input class="form-control" type="text" name="USER_CHECKWORD" maxlength="255" value="<?=$arResult["USER_CHECKWORD"]?>" />
        </div>
        <div class="form-group">
            <label><?=GetMessage("AUTH_NEW_PASSWORD_REQ")?>:</label>
            <br>
            <input class="form-control" type="password" name="USER_PASSWORD" maxlength="255" value="<?=$arResult["USER_PASSWORD"]?>" autocomplete="off" />
        </div>
        <div class="form-group">
            <label><?=GetMessage("AUTH_NEW_PASSWORD_CONFIRM")?>:</label>
            <br>
            <input class="form-control" type="password" name="USER_CONFIRM_PASSWORD" maxlength="255" value="<?=$arResult["USER_CONFIRM_PASSWORD"]?>" autocomplete="off" />
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
            <button type="submit"  class="btn btn-info btn-sm" name="change_pwd" value="<?=GetMessage("AUTH_CHANGE")?>"><?=GetMessage("AUTH_CHANGE")?></button>
        </div>
    </form>
    <p><?echo $arResult["GROUP_POLICY"]["PASSWORD_REQUIREMENTS"];?></p>
    <p>
        <a href="<?=$arResult["AUTH_AUTH_URL"]?>"><?=GetMessage("AUTH_AUTH")?></a>
        <br>
    </p>
</div>
<script type="text/javascript">
document.bform.USER_LOGIN.focus();
</script>
