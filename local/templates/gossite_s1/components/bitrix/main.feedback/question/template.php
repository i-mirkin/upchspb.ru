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
	ShowMessage(Array("TYPE"=>"OK", "MESSAGE"=>$arResult["OK_MESSAGE"]))?><?
}
?>

<form action="<?=POST_FORM_ACTION_URI?>" method="POST">
<?=bitrix_sessid_post()?>
	<div class="row">
        <div class="col-sm-6">
            <div class="form-group">
                <label>
                    <?=GetMessage("MFT_NAME")?><?if(empty($arParams["REQUIRED_FIELDS"]) || in_array("NAME", $arParams["REQUIRED_FIELDS"])):?><span class="mf-req">*</span><?endif?>
                </label>
                <input class="form-control" type="text" name="user_name" value="<?=$arResult["AUTHOR_NAME"]?>">
            </div>
        </div>
        <div class="col-sm-6">
            <div class="form-group">
                <label>
                    <?=GetMessage("MFT_EMAIL")?><?if(empty($arParams["REQUIRED_FIELDS"]) || in_array("EMAIL", $arParams["REQUIRED_FIELDS"])):?><span class="mf-req">*</span><?endif?>
                </label>
                <input class="form-control" type="text" name="user_email" value="<?=$arResult["AUTHOR_EMAIL"]?>">
            </div>
        </div>
    </div>

	<div class="form-group">
		<label>
			<?=GetMessage("MFT_MESSAGE")?><?if(empty($arParams["REQUIRED_FIELDS"]) || in_array("MESSAGE", $arParams["REQUIRED_FIELDS"])):?><span class="mf-req">*</span><?endif?>
		</label>
		<textarea class="form-control" name="MESSAGE" rows="5" cols="40"><?=$arResult["MESSAGE"]?></textarea>
	</div>

	<?if($arParams["USE_CAPTCHA"] == "Y"):?>
	<div class="form-group">
        <label><?=GetMessage("MFT_CAPTCHA")?></label>
		<input type="hidden" name="captcha_sid" value="<?=$arResult["capCode"]?>">
		<img src="/bitrix/tools/captcha.php?captcha_sid=<?=$arResult["capCode"]?>" width="180" height="40" alt="CAPTCHA">
		<label class="hidden"><?=GetMessage("MFT_CAPTCHA_CODE")?><span class="mf-req">*</span></label>
		<input class="form-control"  type="text" name="captcha_word" size="30" maxlength="50" value="">
	</div>
	<?endif;?>
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
               'fields' => array(GetMessage("MFT_EMAIL"), GetMessage("MFT_NAME"))
              ),
          )
         );?>
    <?endif;?>
	<div class="form-group">
        <input type="hidden" name="PARAMS_HASH" value="<?=$arResult["PARAMS_HASH"]?>">
        <input type="hidden" name="submit" value="y">
        <input type="submit" class="btn btn-info" value="<?=GetMessage("MFT_SUBMIT")?>">
    </div>
</form>
</div>
