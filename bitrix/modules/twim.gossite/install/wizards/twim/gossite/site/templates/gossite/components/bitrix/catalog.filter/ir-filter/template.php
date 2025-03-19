<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
/** @var array $arParams */
/** @var array $arResult */
/** @global CMain $APPLICATION */
/** @global CUser $USER */
/** @global CDatabase $DB */
/** @var CBitrixComponentTemplate $this */
/** @var string $templateName */
/** @var string $templateFile */
/** @var string $templateFolder */
/** @var string $componentPath */
/** @var CBitrixComponent $component */
$this->setFrameMode(true);
?>
<div>
<form class="ir-answers-filter" name="<?echo $arResult["FILTER_NAME"]."_form"?>" action="<?echo $arResult["FORM_ACTION"]?>" method="get">
    <?if(array_key_exists($arResult["DATE_PUBLIC_ID"], $arResult["ITEMS"])):?>
        <div class="form-group">
            <label><?=$arResult["ITEMS"][$arResult["DATE_PUBLIC_ID"]]["NAME"]?>:</label> <br>
            <div class="input-group">
                <input class="form-control" data-input-date name="<?=$arResult["ITEMS"][$arResult["DATE_PUBLIC_ID"]]["INPUT_NAME"]?>" value="<?=$arResult["ITEMS"][$arResult["DATE_PUBLIC_ID"]]["INPUT_VALUE"]?>" data-auto-close="true" type="text">
                <div class="input-group-addon"><i class="fa fa-calendar" aria-hidden="true"></i></div>
            </div>
		</div>
    <?endif;?>
    <?if(array_key_exists($arResult["NUMBER_ID"], $arResult["ITEMS"])):?>
        <div class="form-group">
            <label><?=$arResult["ITEMS"][$arResult["NUMBER_ID"]]["NAME"]?>:</label>
            <br>
            <input type="text" class="form-control" name="<?=$arResult["ITEMS"][$arResult["NUMBER_ID"]]["INPUT_NAME"]?>" value="<?=$arResult["ITEMS"][$arResult["NUMBER_ID"]]["INPUT_VALUE"]?>" />
        </div>
    <?endif;?>
    <div class="form-group">
        <input type="hidden" name="set_filter" value="Y" />
        <button class="btn btn-info btn-sm" type="submit" name="set_filter" value="<?=GetMessage("CT_BCF_SET_FILTER")?>"><?=GetMessage("CT_BCF_SET_FILTER")?></button>&ensp; 
        <button class="btn btn-info btn-sm" type="submit" name="del_filter" value="<?=GetMessage("CT_BCF_DEL_FILTER")?>"><?=GetMessage("CT_BCF_DEL_FILTER")?></button>
    </div>
</form>
</div>

