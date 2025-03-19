<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>
<div class="form subscribe-form-simple">
<?if($arResult["MESSAGE"] || $arResult["ERROR"]):?>
	<div class="subs-simple-msg messages">		
		<?foreach($arResult["MESSAGE"] as $itemID=>$itemValue)
			echo ShowMessage(array("MESSAGE"=>$itemValue, "TYPE"=>"OK"));
		foreach($arResult["ERROR"] as $itemID=>$itemValue)
			echo ShowMessage(array("MESSAGE"=>$itemValue, "TYPE"=>"ERROR"));?>
	</div>
<?endif;?>
<?
//whether to show the forms

if($arResult["ID"] == 0 && empty($_REQUEST["action"]) || CSubscription::IsAuthorized($arResult["ID"]))
{	
	//show confirmation form
	if($arResult["ID"]>0 && $arResult["SUBSCRIPTION"]["CONFIRMED"] <> "Y")
	{
		//include("confirmation.php");
	}
	else 
	{
		//setting section
		if(empty($arResult["REQUEST"]["CONFIRM_CODE"]))	include("setting.php");
	}
		
	?>
<?}?>
</div>