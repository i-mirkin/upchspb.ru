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
<div class="mfeedback" data-f="bitrix\templates\.default\components\bquadro\apply">
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

<form name="apply_form" action="<?=POST_FORM_ACTION_URI?>" method="POST" class="question_form"  accept-charset="windows-1251" enctype="multipart/form-data">
    <?=bitrix_sessid_post()?>
	
    <div class="form-group">
        <input class="form-control " type="text" name="user_surname" value="<?=$arResult["AUTHOR_SURNAME"]?>">
        <label class="float-label">
            <?=GetMessage("MFT_SURNAME")?>*
        </label>
    </div>
    
    <div class="form-group">
        <input class="form-control " type="text" name="user_name" value="<?=$arResult["AUTHOR_NAME"]?>">
        <label class="float-label">
            <?=GetMessage("MFT_NAME")?>*
        </label>
    </div>

    <div class="form-group">
        <input class="form-control " type="text" name="user_patronymic" value="<?=$arResult["AUTHOR_PATRONYMIC"]?>">
        <label class="float-label">
            <?=GetMessage("MFT_PATRONYMIC")?>
        </label>
    </div>
	
	<div class="form-group">
        <input class="form-control mask" type="text" name="user_phone" value="<?=$arResult["AUTHOR_PHONE"]?>">
        <label class="float-label">
            <?=GetMessage("MFT_PHONE")?>*
        </label>
    </div>
    <div class="form-group">  
        <input class="form-control " type="text" name="user_email" value="<?=$arResult["AUTHOR_EMAIL"]?>">
        <label class="float-label">
            <?=GetMessage("MFT_EMAIL")?>*
        </label>
    </div>
    <div class="form-group">
            <input type="text" class="user_postaddr form-control " name="user_postaddr">           
            <label class="float-label"><?=GetMessage('UPOSTADDR')?>*</label>
        </div>
	<div class="form-group"> 
		<textarea class="form-control" name="MESSAGE" rows="5" cols="40"><?=$arResult["MESSAGE"]?></textarea>
        <label class="float-label">
			<?=GetMessage("MFT_MESSAGE")?>*
		</label>
	</div>
	<div class="file-load file-load-contact clearfix form-group">
		<div>
			<label class="label-file" for="inputFileContact">
                <p><span class="label-file__link"><?=GetMessage('MFT_FILE_UPLOAD')?>*</span><span class="label-file__formats" style="color: #202020;">jpg, jpeg, png, doc, docx, odt, txt, rtf, ppt, pptx, xls, pdf, rar, zip, 7z, sig</span></p>
                <p><?=GetMessage('MFT_FILE_MAX')?></p>
				<p id="ipfrow" сlass="ip_f min-row"><input class="inputFile inputFileContact" id="inputFileContact" type="file" name="FILE[]" multiple></p> 
			</label>
			<? if ($arError["FILE"]) {?><div class="form-error"><?=$arError["FILE"]?></div><?}?>
		</div>
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
				".default", 
				array(
					"ID" => "1",
					"IS_CHECKED" => "Y",
					"AUTO_SAVE" => "Y",
					"IS_LOADED" => "N",
					"SUBMIT_EVENT_NAME" => "userconsent-event",
					"REPLACE" => array(
						"button_caption" => GetMessage("MFT_SUBMIT"),
						"fields" => array(
							0 => GetMessage("MFT_EMAIL"),
							1 => GetMessage("MFT_NAME"),
						),
					),
					"COMPONENT_TEMPLATE" => ".default"
				),
				false
			);?>
        </div>
    <?endif;?>
	
	<div class="form-group">
        <input type="hidden" name="PARAMS_HASH" value="<?=$arResult["PARAMS_HASH"]?>">
        <input type="submit" class="btn btn-info" name="submit" value="<?=GetMessage("MFT_SUBMIT")?>">
    </div>

	<script>
	jQuery('[name=apply_form]').append('<input type="hidden" name="app_capt" value="Y">');
	</script>
</form>
</div>
