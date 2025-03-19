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
	ShowError(implode("<br />", $arResult["ERROR_MESSAGE"]));
}
if(strlen($arResult["OK_MESSAGE"]) > 0)
{
	ShowMessage(Array("TYPE"=>"OK", "MESSAGE"=>$arResult["OK_MESSAGE"]));
}
?>

<form id="feedback-main" action="<?=POST_FORM_ACTION_URI?>" method="POST" enctype="multipart/form-data">
<?=bitrix_sessid_post()?>     
    <div class="form-group">
        <label>
            <?=GetMessage("MFT_THEME")?><?if(empty($arParams["REQUIRED_FIELDS"]) || in_array("THEME", $arParams["REQUIRED_FIELDS"])):?><span class="require">*</span><?endif?>
        </label>
        <select class="form-control" name="theme">
            <?foreach ($arParams["THEME"] as $key => $value):?>
                <option value="<?=$key?>"<?if($arResult["THEME"] == $key):?> selected="selected" <?endif;?>><?=$value?></option>
            <?endforeach;?>
        </select>
    </div>
	<div class="form-group">
		<label>
			<?=GetMessage("MFT_NAME")?><?if(empty($arParams["REQUIRED_FIELDS"]) || in_array("NAME", $arParams["REQUIRED_FIELDS"])):?><span class="require">*</span><?endif?>
		</label>
		<input type="text" name="user_name" class="form-control" value="<?=$arResult["AUTHOR_NAME"]?>">
	</div>
    <div class="form-group">
		<label>
			<?=GetMessage("MFT_SURNAME")?><?if(empty($arParams["REQUIRED_FIELDS"]) || in_array("SURNAME", $arParams["REQUIRED_FIELDS"])):?><span class="require">*</span><?endif?>
		</label>
		<input type="text" name="user_surname" class="form-control" value="<?=$arResult["AUTHOR_SURNAME"]?>">
	</div>
    <div class="form-group">
		<label>
			<?=GetMessage("MFT_SECOND_NAME")?><?if(empty($arParams["REQUIRED_FIELDS"]) || in_array("SECOND_NAME", $arParams["REQUIRED_FIELDS"])):?><span class="require">*</span><?endif?>
		</label>
		<input type="text" name="user_second_name" class="form-control" value="<?=$arResult["AUTHOR_SECOND_NAME"]?>">
	</div>
    <div class="form-group">
		<label>
			<?=GetMessage("MFT_EMAIL")?><?if(empty($arParams["REQUIRED_FIELDS"]) || in_array("EMAIL", $arParams["REQUIRED_FIELDS"])):?><span class="require">*</span><?endif?>
		</label>
		<input type="text" name="user_email" class="form-control" value="<?=$arResult["AUTHOR_EMAIL"]?>">
	</div>    
    <div class="form-group">
		<label>
			<?=GetMessage("MFT_PHONE")?><?if(empty($arParams["REQUIRED_FIELDS"]) || in_array("PHONE", $arParams["REQUIRED_FIELDS"])):?><span class="require">*</span><?endif?>
		</label>
		<input type="text" name="user_phone" class="form-control" value="<?=$arResult["AUTHOR_PHONE"]?>">
	</div>
    <div class="form-group mb-feedback__form-group">
        <input 
            id="send_answer_address"
            class="mb-feedback__radio" 
            type="checkbox" 
            name="send" 
            value="address" 
            <?if($arResult["SEND"] == "address"):?>checked="checked"<?endif;?>         
        />
        <label for="send_answer_address"><?=getMessage("MFT_SEND_ADDRESS")?></label>
    </div> 
    <div class="form-group form-group__type-send"<?if($arResult["HIDE_INPUT_SEND"] == "address"):?> style="display:none"<?endif?>>
		<label>
			<?=GetMessage("MFT_ADDRESS")?><span class="require">*</span>
		</label>
        <input type="text" name="ADDRESS" class="form-control" value="<?=$arResult["ADDRESS"]?>">
	</div>
	<div class="form-group">
		 <label>
			<?=GetMessage("MFT_MESSAGE")?><?if(empty($arParams["REQUIRED_FIELDS"]) || in_array("MESSAGE", $arParams["REQUIRED_FIELDS"])):?><span class="require">*</span><?endif?>
		</label>
		<textarea name="MESSAGE" rows="5" cols="40" class="form-control"><?=$arResult["MESSAGE"]?></textarea>
	</div> 
    <?if($arParams["INCLUDE_FILE"] == "Y"):?>
        <div class="form-group">
            <label>
                <?=GetMessage("MFT_FILE")?>
            </label>
            <input type="file" name="file_message">
            <p class="help-block">
                <?=GetMessage("MFT_FILE_SUPPOTS_SIZE", array("#SIZE#" => $arParams["FILE_SIZE"]))?> <br />
                <?=GetMessage("MFT_FILE_SUPPOTS_EXT", array("#EXT#" => $arParams["FILE_EXT"]))?>
            </p>
        </div>
    <?endif?>
    <?if ($arParams['USER_CONSENT'] == 'Y'):?>
         <?$APPLICATION->IncludeComponent(
          "bitrix:main.userconsent.request",
          "",
          array(
              "ID" => $arParams["USER_CONSENT_ID"],
              "IS_CHECKED" => $arParams["USER_CONSENT_IS_CHECKED"],
              "AUTO_SAVE" => "Y",
              "IS_LOADED" => $arParams["USER_CONSENT_IS_LOADED"],
              "REPLACE" => array(
               'button_caption' => GetMessage("MFT_SUBMIT"),
               'fields' => array(GetMessage("MFT_EMAIL"), GetMessage("MFT_PHONE"), GetMessage("MFT_NAME"), GetMessage("MFT_SURNAME"), GetMessage("MFT_SECOND_NAME"), GetMessage("MFT_ADDRESS"))
              ),
          )
         );?>
    <?else:?>
        <?if($arParams["PROCESS_PERSONAL_DATA"] == "Y"):?>
            <div class="checkbox">
                <label>
                    <input type="checkbox" name="agreement"<?if($arResult["PROCESS_PERSONAL_DATA"] == "Y"):?> checked="checked" <?endif;?> value="y"> <?=GetMessage("MFT_PROCESS_PERSONAL_DATA")?><span class="require">*</span>
                </label>
            </div>
        <?endif?>
    <?endif;?>
	<?if($arParams["USE_CAPTCHA"] == "Y"):?>
	<div class="form-group">
		<label><?=GetMessage("MFT_CAPTCHA")?></label> 
        <input type="hidden" name="captcha_sid" value="<?=$arResult["capCode"]?>"> <sup>[3]</sup>
        <div>
            <img src="/bitrix/tools/captcha.php?captcha_sid=<?=$arResult["capCode"]?>" width="180" height="40" alt="CAPTCHA">
        </div>
        <div>
            <br>
            <input type="text" name="captcha_word" size="30" maxlength="50" value="" class="form-control" style="max-width: 180px;">
        </div>
	</div>
	<?endif;?>
	<input type="hidden" name="PARAMS_HASH"  value="<?=$arResult["PARAMS_HASH"]?>">
    <input type="hidden" name="submit" value="y">
	<input type="submit"  class="btn btn-info" value="<?=GetMessage("MFT_SUBMIT")?>">
</form>
<br>
<small>
	<?=GetMessage("MFT_SEND_ANSWER_DESC")?><br />
    <?if($arParams["USE_CAPTCHA"] == "Y"):?>
	<?=GetMessage("MFT_CAPTCHA_DESCRIPTION")?><br />
    <?endif;?>
</small>
</div>
