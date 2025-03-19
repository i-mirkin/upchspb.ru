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
<?if($arParams["DISPLAY_TOP_PAGER"]):?>
	<?=$arResult["NAV_STRING"]?><br />
<?endif;?>
<div class="list-answers ir-answers_list-answers">    
<?foreach($arResult["ITEMS"] as $arItem):?>
	<?
	$this->AddEditAction($arItem['ID'], $arItem['EDIT_LINK'], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_EDIT"));
	$this->AddDeleteAction($arItem['ID'], $arItem['DELETE_LINK'], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_DELETE"), array("CONFIRM" => GetMessage('CT_BNL_ELEMENT_DELETE_CONFIRM')));
	?>
    <div class="list-answers__item" id="<?=$this->GetEditAreaId($arItem['ID']);?>">
        <p class="list-answers__title"><?echo $arItem["NAME"]?></p>
        <div class="list-answers__props">
            <?if(isset($arItem["DISPLAY_PROPERTIES"]["NUMBER"])):?>
            <span class="list-answers__number"><b><?=$arItem["DISPLAY_PROPERTIES"]["NUMBER"]["NAME"]?>:</b> <?=$arItem["DISPLAY_PROPERTIES"]["NUMBER"]["VALUE"]?></span>
            <?endif;?>
            <?if(isset($arItem["DISPLAY_PROPERTIES"]["DATE_PUBLIC"])):?>
            <span class="list-answers__date"><b><?=$arItem["DISPLAY_PROPERTIES"]["DATE_PUBLIC"]["NAME"]?>:</b> <?=$arItem["DISPLAY_PROPERTIES"]["DATE_PUBLIC"]["VALUE"]?></span>
            <?endif;?>
            <?if(isset($arItem["DISPLAY_PROPERTIES"]["FILE"])):?>
            <span class="list-answers__file"><b><?=$arItem["DISPLAY_PROPERTIES"]["FILE"]["NAME"]?>:</b> <i class="fa fa-file-pdf-o" aria-hidden="true"></i> <a href="<?=$arItem["DISPLAY_PROPERTIES"]["FILE"]["FILE_VALUE"]["SRC"]?>" class="list-answers__link"><?=GetMessage('ELEMENT_DOWNLOAD')?></a></span>
            <?endif;?>
        </div>
    </div>

<?endforeach;?>
</div>
<?if($arParams["DISPLAY_BOTTOM_PAGER"]):?>
	<?=$arResult["NAV_STRING"]?>
<?endif;?>
</div>