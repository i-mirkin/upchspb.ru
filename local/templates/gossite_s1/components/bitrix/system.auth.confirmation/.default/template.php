<?
if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true)
{
	die();
}
/**
 * Bitrix vars
 * @global CMain $APPLICATION
 * @global CUser $USER
 * @var array $arParams
 * @var array $arResult
 */

//one css for all system.auth.* forms
$APPLICATION->SetAdditionalCSS("/bitrix/css/main/system.auth/flat/style.css");

//here you can place your own messages
switch($arResult["MESSAGE_CODE"])
{
	case "E01":
		//When user not found
		$class = "alert-warning";
		break;
	case "E02":
		//User was successfully authorized after confirmation
		$class = "alert-success";
		break;
	case "E03":
		//User already confirm his registration
		$class = "alert-warning";
		break;
	case "E04":
		//Missed confirmation code
		$class = "alert-warning";
		break;
	case "E05":
		//Confirmation code provided does not match stored one
		$class = "alert-danger";
		break;
	case "E06":
		//Confirmation was successfull
		$class = "alert-success";
		break;
	case "E07":
		//Some error occured during confirmation
		$class = "alert-danger";
		break;
	default:
		$class = "alert-warning";
}
?>

<?
if($arResult["MESSAGE_TEXT"] <> ''):
	$text = str_replace(array("<br>", "<br />"), "\n", $arResult["MESSAGE_TEXT"]);
?>
<div class="ir-auth">
    <div class="alert <?=$class?>">
        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <?echo nl2br(htmlspecialcharsbx($text))?>
    </div>
</div>
<?endif?>

<?if($arResult["SHOW_FORM"]):?>
<div class="ir-auth">
	<form method="post" action="<?echo $arResult["FORM_ACTION"]?>">
        <div class="form-group">
            <label><?=GetMessage("CT_BSAC_LOGIN")?>:</label>
            <br>
            <input class="form-control" type="text" name="<?echo $arParams["LOGIN"]?>" maxlength="50" value="<?echo $arResult["LOGIN"]?>" />
        </div>
        <div class="form-group">
            <label><?=GetMessage("CT_BSAC_CONFIRM_CODE")?>:</label>
            <br>
            <input class="form-control" type="text" name="<?echo $arParams["CONFIRM_CODE"]?>" maxlength="50" value="<?echo $arResult["CONFIRM_CODE"]?>" />
        </div>
        <div class="form-group">
            <button type="submit" class="btn btn-info btn-sm" name="change_pwd" value="<?=GetMessage("CT_BSAC_CONFIRM")?>"><?=GetMessage("CT_BSAC_CONFIRM")?></button>
        </div>
		<input type="hidden" name="<?echo $arParams["USER_ID"]?>" value="<?echo $arResult["USER_ID"]?>" />
	</form>
</div>
<?elseif(!$USER->IsAuthorized()):?>
	<?$APPLICATION->IncludeComponent("bitrix:system.auth.authorize", ".default", array());?>
<?endif?>