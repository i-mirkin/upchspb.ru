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
<?if(!empty($arResult["ERROR_MESSAGE"]))
{
	foreach($arResult["ERROR_MESSAGE"] as $v)
		ShowError($v);
}
if(strlen($arResult["OK_MESSAGE"]) > 0)
{
	?><div class="mf-ok-text"><?=$arResult["OK_MESSAGE"]?></div><?
}
?>

<form action="<?=POST_FORM_ACTION_URI?>" method="POST" enctype="multipart/form-data">
<?=bitrix_sessid_post()?>
    <div class="mf-select">
        <div class="mf-text">
            <?=GetMessage("MFT_THEME")?><?if(empty($arParams["REQUIRED_FIELDS"]) || in_array("THEME", $arParams["REQUIRED_FIELDS"])):?><span class="mf-req">*</span><?endif?>
        </div>
        <select name="theme">
            <?foreach ($arParams["THEME"] as $key => $value):?>
                <option value="<?=$key?>"<?if($arResult["THEME"] == $key):?> selected="selected" <?endif;?>><?=$value?></option>
            <?endforeach;?>
        </select>
    </div>
	<div class="mf-name">
		<div class="mf-text">
			<?=GetMessage("MFT_NAME")?><?if(empty($arParams["REQUIRED_FIELDS"]) || in_array("NAME", $arParams["REQUIRED_FIELDS"])):?><span class="mf-req">*</span><?endif?>
		</div>
		<input type="text" name="user_name" value="<?=$arResult["AUTHOR_NAME"]?>">
	</div>
	<div class="mf-email">
		<div class="mf-text">
			<?=GetMessage("MFT_EMAIL")?><?if(empty($arParams["REQUIRED_FIELDS"]) || in_array("EMAIL", $arParams["REQUIRED_FIELDS"])):?><span class="mf-req">*</span><?endif?>
		</div>
		<input type="text" name="user_email" value="<?=$arResult["AUTHOR_EMAIL"]?>">
	</div>
    <div class="mf-phone">
		<div class="mf-text">
			<?=GetMessage("MFT_PHONE")?><?if(empty($arParams["REQUIRED_FIELDS"]) || in_array("PHONE", $arParams["REQUIRED_FIELDS"])):?><span class="mf-req">*</span><?endif?>
		</div>
		<input type="text" name="user_phone" value="<?=$arResult["AUTHOR_PHONE"]?>">
	</div>
    <div class="mf-address">
		<div class="mf-text">
			<?=GetMessage("MFT_ADDRESS")?><?if(empty($arParams["REQUIRED_FIELDS"]) || in_array("ADDRESS", $arParams["REQUIRED_FIELDS"])):?><span class="mf-req">*</span><?endif?>
		</div>
		<textarea name="ADDRESS" rows="3" cols="40"><?=$arResult["ADDRESS"]?></textarea>
	</div>
	<div class="mf-message">
		<div class="mf-text">
			<?=GetMessage("MFT_MESSAGE")?><?if(empty($arParams["REQUIRED_FIELDS"]) || in_array("MESSAGE", $arParams["REQUIRED_FIELDS"])):?><span class="mf-req">*</span><?endif?>
		</div>
		<textarea name="MESSAGE" rows="5" cols="40"><?=$arResult["MESSAGE"]?></textarea>
	</div> 
    <?if($arParams["INCLUDE_FILE"] == "Y"):?>
        <div class="mf-file">
            <div class="mf-text">
                <?=GetMessage("MFT_FILE")?>
            </div>
            <input type="file" name="file_message">
            <p class="help-block">
                <?=GetMessage("MFT_FILE_SUPPOTS_SIZE", array("#SIZE#" => $arParams["FILE_SIZE"]))?> <br />
                <?=GetMessage("MFT_FILE_SUPPOTS_EXT", array("#EXT#" => $arParams["FILE_EXT"]))?>
            </p>
        </div>
    <?endif?>
    <?if($arParams["PROCESS_PERSONAL_DATA"] == "Y"):?>
        <div class="mf-checkbox">
            <label>
                <input type="checkbox" name="agreement"<?if($arResult["PROCESS_PERSONAL_DATA"] == "Y"):?> checked="checked" <?endif;?> value="y"> <?=GetMessage("MFT_PROCESS_PERSONAL_DATA")?><span class="mf-req">*</span>
            </label>
        </div>
    <?endif?>
	<?if($arParams["USE_CAPTCHA"] == "Y"):?>
	<div class="mf-captcha">
		<div class="mf-text"><?=GetMessage("MFT_CAPTCHA")?></div>
		<input type="hidden" name="captcha_sid" value="<?=$arResult["capCode"]?>">
		<img src="/bitrix/tools/captcha.php?captcha_sid=<?=$arResult["capCode"]?>" width="180" height="40" alt="CAPTCHA">
		<div class="mf-text"><?=GetMessage("MFT_CAPTCHA_CODE")?><span class="mf-req">*</span></div>
		<input type="text" name="captcha_word" size="30" maxlength="50" value="">
	</div>
	<?endif;?>
	<input type="hidden" name="PARAMS_HASH" value="<?=$arResult["PARAMS_HASH"]?>">
	<input type="submit" name="submit" value="<?=GetMessage("MFT_SUBMIT")?>">
</form>
</div>
