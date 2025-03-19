<?
if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true)
{
	die();
}
/**
 * @global CMain $APPLICATION
 * @var array $arParams
 * @var array $arResult
 * @var CBitrixComponent $component
 */
?>
<div class="ir-auth">
    <p><?=GetMessage("AUTH_PLEASE_AUTH")?></p>
    <?if($arResult['ERROR_MESSAGE'] <> ''):
        $text = str_replace(array("<br>", "<br />"), "\n", $arResult['ERROR_MESSAGE']);
        ShowError(htmlspecialcharsbx($text)); 
    endif?>
    <?
    if(!empty($arParams["~AUTH_RESULT"])):
        $text = str_replace(array("<br>", "<br />"), "\n", $arParams["~AUTH_RESULT"]["MESSAGE"]);
        ShowError(htmlspecialcharsbx($text));   
    endif?>
   <?if($arResult["AUTH_SERVICES"]):?>
    <?
    $APPLICATION->IncludeComponent("bitrix:socserv.auth.form",
        "flat",
        array(
            "AUTH_SERVICES" => $arResult["AUTH_SERVICES"],
            "AUTH_URL" => $arResult["AUTH_URL"],
            "POST" => $arResult["POST"],
        ),
        $component,
        array("HIDE_ICONS"=>"Y")
    );
    ?>
    <?endif?>
    <form  class="ir-auth__form" name="form_auth" method="post" target="_top" action="<?=$arResult["AUTH_URL"]?>">   
        <input type="hidden" name="AUTH_FORM" value="Y" />
		<input type="hidden" name="TYPE" value="AUTH" />
        <?if (strlen($arResult["BACKURL"]) > 0):?>
        <input type="hidden" name="backurl" value="<?=$arResult["BACKURL"]?>" />
        <?endif?>
        <div class="form-group">
            <label><?=GetMessage("AUTH_LOGIN")?>:</label>
            <br>
            <input type="text" name="USER_LOGIN" class="form-control" maxlength="255" value="<?=$arResult["LAST_LOGIN"]?>" />
        </div>
        <div class="form-group">
            <label><?=GetMessage("AUTH_PASSWORD")?>:</label>
            <br>
            <input type="password" name="USER_PASSWORD" class="form-control" maxlength="255" autocomplete="off" />
        </div>
        <?if($arResult["CAPTCHA_CODE"]):?>
            <input type="hidden" name="captcha_sid" value="<?echo $arResult["CAPTCHA_CODE"]?>" />
            <div class="form-group">
                <label> <?echo GetMessage("AUTH_CAPTCHA_PROMT")?>:</label>
                <img src="/bitrix/tools/captcha.php?captcha_sid=<?echo $arResult["CAPTCHA_CODE"]?>" width="180" height="40" alt="CAPTCHA" class="ir-captcha-img" />
                <input type="text" name="captcha_word" class="form-control" maxlength="50" value="" autocomplete="off" />
            </div>
        <?endif;?>
        <?if ($arResult["STORE_PASSWORD"] == "Y"):?>
            <div class="form-group">
                <label class="checkbox-button">
                    <input class="checkbox-button__input"  type="checkbox" id="USER_REMEMBER" name="USER_REMEMBER" value="Y">
                    <span class="checkbox-button__custom-input"> <?=GetMessage("AUTH_REMEMBER_ME")?></span>
                </label>
            </div>
        <?endif?>
        <div class="form-group">
            <button class="btn btn-info btn-sm" type="submit" name="Login" value="<?=GetMessage("AUTH_AUTHORIZE")?>"><?=GetMessage("AUTH_AUTHORIZE")?></button>
        </div>
    </form>
    <p>
    <?if ($arParams["NOT_SHOW_LINKS"] != "Y"):?>
        <noindex>
            <a href="<?=$arResult["AUTH_FORGOT_PASSWORD_URL"]?>" class="ir-auth__link-pas-rec"><?=GetMessage("AUTH_FORGOT_PASSWORD_2")?></a>
        </noindex>
        <br>
    <?endif?>
    <?if($arParams["NOT_SHOW_LINKS"] != "Y" && $arResult["NEW_USER_REGISTRATION"] == "Y" && $arParams["AUTHORIZE_REGISTRATION"] != "Y"):?>
        <noindex>
            <a href="<?=$arResult["AUTH_REGISTER_URL"]?>" rel="nofollow"><?=GetMessage("AUTH_REGISTER")?></a><br><br>
            <?=GetMessage("AUTH_FIRST_ONE")?>
        </noindex>
    <?endif?>
    </p>
</div>
<script type="text/javascript">
<?if (strlen($arResult["LAST_LOGIN"])>0):?>
try{document.form_auth.USER_PASSWORD.focus();}catch(e){}
<?else:?>
try{document.form_auth.USER_LOGIN.focus();}catch(e){}
<?endif?>
</script>