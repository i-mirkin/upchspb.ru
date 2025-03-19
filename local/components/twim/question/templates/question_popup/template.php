<?
if(!defined("B_PROLOG_INCLUDED")||B_PROLOG_INCLUDED!==true)die();
/**
 * Bitrix vars
 *
 * @var array $arParams
 * @var array $arResult
 * @var CBitrixComponentTemplate $this
 * @global CMain $APPLICATION
 * @global CUser $USER
 */
?>
<div class="mfeedback">
<?
if(!empty($arResult["ERROR_MESSAGE"]))
{
    ?><div class="error-message"><?ShowError(implode("<br />", $arResult["ERROR_MESSAGE"]));?></div><?
}
if(strlen($arResult["OK_MESSAGE"]) > 0)
{
    ?><div class="ok-message hidden"><p class="success-popup"><?=$arResult["OK_MESSAGE"];?></p></div><?
}
?>

<form name="question_form" action="<?=POST_FORM_ACTION_URI?>" method="POST" class="question_form"  accept-charset="windows-1251">
    <?=bitrix_sessid_post()?>
	
    <div class="form-group">
        <input class="form-control width_60" type="text" name="user_name" value="<?=$arResult["AUTHOR_NAME"]?>">
        <label class="float-label">
            <?=GetMessage("MFT_NAME")?>
        </label>
    </div>

    <div class="form-group">  
        <input class="form-control width_60" type="text" name="user_email" value="<?=$arResult["AUTHOR_EMAIL"]?>">
        <label class="float-label">
            <?=GetMessage("MFT_EMAIL")?>
        </label>
    </div>
       
	<div class="form-group">
		<textarea class="form-control" name="MESSAGE" rows="5" cols="40"><?=$arResult["MESSAGE"]?></textarea>
        <label class="float-label">
			<?=GetMessage("MFT_MESSAGE")?>
		</label>
	</div>
    <div class="form-group">
        <p class="help-block"><?=getMessage("MFT_ANNOTATION")?></p>
    </div>    
	<?if($arParams["USE_CAPTCHA"] == "Y"):?>
	<div class="form-group">
        <!--label><?=GetMessage("MFT_CAPTCHA")?></label-->
		<input type="hidden" name="captcha_sid" value="<?=$arResult["capCode"]?>">
		<img src="/bitrix/tools/captcha.php?captcha_sid=<?=$arResult["capCode"]?>" width="180" height="40" alt="CAPTCHA">
		<label class="hidden"><?=GetMessage("MFT_CAPTCHA_CODE")?><span class="mf-req">*</span></label>
		<input class="form-control"  type="text" name="captcha_word" size="30" maxlength="50" value="">
	</div>
	<?endif;?>
    <?if ($arParams['USER_CONSENT'] == 'Y'):?>
        <div id="userconsent-container">
            <?$APPLICATION->IncludeComponent(
             "bitrix:main.userconsent.request",
             "",
             array(
                 "ID" => $arParams["USER_CONSENT_ID"],
                 "IS_CHECKED" => $arParams["USER_CONSENT_IS_CHECKED"],
                 "AUTO_SAVE" => "Y",
                 "IS_LOADED" => $arParams["USER_CONSENT_IS_LOADED"],
                 'SUBMIT_EVENT_NAME' => 'userconsent-event',
                 "REPLACE" => array(
                  'button_caption' => GetMessage("MFT_SUBMIT"),
                  'fields' => array(GetMessage("MFT_EMAIL"), GetMessage("MFT_NAME"))
                 ),
             )
            );?>
        </div>
    <?endif;?>
	<div class="form-group">
        <input type="hidden" name="PARAMS_HASH" value="<?=$arResult["PARAMS_HASH"]?>">
        <input type="submit" class="btn btn-info" name="submit" value="<?=GetMessage("MFT_SUBMIT")?>">
    </div>
</form>
</div>
