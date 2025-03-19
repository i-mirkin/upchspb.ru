<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>
<?
//*************************************
//show confirmation form
//*************************************
?>

<div class="confirmation-block subscribe-edit">
	<form action="<?=$arResult["FORM_ACTION"]?>" method="get" class="form">
		<input class="form-control  subscribe-input" type="text" id="CONFIRM_CODE" name="CONFIRM_CODE" value="<?echo $arResult["REQUEST"]["CONFIRM_CODE"];?>" size="20" placeholder="<?echo GetMessage("subscr_conf_code")?>" />
		<div class="text_block">
			<?echo GetMessage("subscr_conf_note1")?> <a title="<?echo GetMessage("adm_send_code")?>" href="<?echo $arResult["FORM_ACTION"]?>?ID=<?echo $arResult["ID"]?>&amp;action=sendcode&amp;<?echo bitrix_sessid_get()?>"><?echo GetMessage("subscr_conf_note2")?></a>.
		</div>

		<input type="submit" class="btn btn-info btn-md subscribe-btn" name="confirm" value="<?echo GetMessage("subscr_conf_button")?>" />

		<input type="hidden" name="ID" value="<?echo $arResult["ID"];?>" />
		<?echo bitrix_sessid_post();?>
	</form>
</div>

<?/*?>
<div class="subscribe-edit">
<form action="<?=$arResult["FORM_ACTION"]?>" method="post" class="subscription-form">
	<?echo bitrix_sessid_post();?>
	<?$email = ($arResult["SUBSCRIPTION"]["EMAIL"]!=""?$arResult["SUBSCRIPTION"]["EMAIL"]:$arResult["REQUEST"]["EMAIL"]);?>
	
	<input type="hidden" name="PostAction" value="<?echo ($arResult["ID"]>0? "Update":"Add")?>" />
	<input type="hidden" name="ID" value="<?echo $arResult["SUBSCRIPTION"]["ID"];?>" />
	<?if($_REQUEST["register"] == "YES"):?>
		<input type="hidden" name="register" value="YES" />
	<?endif;?>
	<?if($_REQUEST["authorize"]=="YES"):?>
		<input type="hidden" name="authorize" value="YES" />
	<?endif;?>
	
	<label for="" class="subscription-form__label">Подпишитесь на новости</label>
	<input class="subscription-form__input" placeholder="Введите e-mail*" type="text" id="EMAIL" name="EMAIL" value="<?=$email;?>" size="30" maxlength="255" />
	<input type="hidden" name="RUB_ID[]" id="rub_<?=$arResult["RUBRICS"][0]["ID"]?>" value="<?=$arResult["RUBRICS"][0]["ID"]?>" />
	<input type="hidden" name="FORMAT" id="html" value="html"  />
	
	<button type="submit" class="subscription-form__btn btn" name="Save"><?echo GetMessage("ADD_USER");?></button>
</form>
</div>
<?*/?>