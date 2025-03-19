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

<?if(!empty($arResult["ITEMS"])) { ?>
	<?if($arParams["DISPLAY_TOP_PAGER"]):?>
		<?=$arResult["NAV_STRING"]?><br />
	<?endif;?>
	<div class="news-list news-list--inner clearfix">
	<?foreach($arResult["ITEMS"] as $arItem):?>			
		<?
		$this->AddEditAction($arItem['ID'], $arItem['EDIT_LINK'], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_EDIT"));
		$this->AddDeleteAction($arItem['ID'], $arItem['DELETE_LINK'], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_DELETE"), array("CONFIRM" => GetMessage('CT_BNL_ELEMENT_DELETE_CONFIRM')));
		$fileImg = '';
		if($arItem['PREVIEW_PICTURE']) {
			$fileImg = CFile::ResizeImageGet($arItem['PREVIEW_PICTURE'], array('width'=>264, 'height'=>188), BX_RESIZE_IMAGE_PROPORTIONAL, true, false, false, 70);    
		}
		?>
		<a href="<?=$arItem["DETAIL_PAGE_URL"]?>"  class="news-list__item <?if($arItem['DISPLAY_PROPERTIES']['THEME']['VALUE_ENUM_ID'] == 21) { ?>news-list__item--main<? } ?> clearfix" id="<?=$this->GetEditAreaId($arItem['ID']);?>">
			<div class="news-list__item-top clearfix">
				<?//if($arParams["DISPLAY_DATE"]!="N" && $arItem["DISPLAY_ACTIVE_FROM"]):?>
				<div class="news-list__item-date"><?=$arItem["DISPLAY_ACTIVE_FROM"]?></div>
				<?//endif;?>
				<?if($arItem['DISPLAY_PROPERTIES']['TAG']['VALUE']) { ?>
				<div class="news-list__item-theme"><?=$arItem['DISPLAY_PROPERTIES']['TAG']['VALUE']?></div>
				<? } ?>
				<?if($arItem['DISPLAY_PROPERTIES']['BREAKING_NEWS']['VALUE'] == 'Y') { ?>
				<div class="news-list__item-main">Срочно</div>
				<? } ?>
			</div>
			<div class="news-list__item-wr">
				<?if($arParams["DISPLAY_NAME"]!="N" && $arItem["NAME"]):?>
				<div class="news-list__item-title"><?=$arItem["NAME"]?></div>
				<?endif;?>
				<?if($arParams["DISPLAY_PREVIEW_TEXT"]!="N" && $arItem["PREVIEW_TEXT"]):?>
                    <div class="news-list__item-text"><?echo $arItem["PREVIEW_TEXT"];?></div>
                <?endif;?>
			</div>
		</a>
	<?endforeach;?>
	</div>
	<?if($arParams["DISPLAY_BOTTOM_PAGER"]):?>
		<br /><?=$arResult["NAV_STRING"]?>
	<?endif;?>
<?}?>