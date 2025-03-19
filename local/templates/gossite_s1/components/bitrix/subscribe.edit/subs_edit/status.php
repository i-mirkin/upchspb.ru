<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>
<?
//***********************************
//status and unsubscription/activation section
//***********************************
?>
<form action="<?=$arResult["FORM_ACTION"]?>" method="get">
<?if($arResult["SUBSCRIPTION"]["CONFIRMED"] == "Y"):?>
	<?if($arResult["SUBSCRIPTION"]["ACTIVE"] == "Y"){?>
		<p><input type="submit" name="unsubscribe" value="<?echo GetMessage("subscr_unsubscr")?>" />
		<input type="hidden" name="action" value="unsubscribe" /></p>
	<?}?>
<?endif;?>
<table width="100%" border="0" cellpadding="0" cellspacing="0" class="data-table">
	<?if($arResult["SUBSCRIPTION"]["CONFIRMED"] == "Y"):?>
		<tfoot><tr><td colspan="3">
		<?if($arResult["SUBSCRIPTION"]["ACTIVE"] == "Y"):?>
		<?else:?>
			<input type="submit" name="activate" value="<?echo GetMessage("subscr_activate")?>" />
			<input type="hidden" name="action" value="activate" />
		<?endif;?>
		</td></tr></tfoot>
	<?endif;?>
</table>
<input type="hidden" name="ID" value="<?echo $arResult["SUBSCRIPTION"]["ID"];?>" />
<?echo bitrix_sessid_post();?>
</form>
<br />