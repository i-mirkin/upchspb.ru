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
<?if(!empty($arResult["SECTIONS"])) { ?>
<div class="col-in col-in--photogallery">
	<div class="front-top clearfix">
		<div class="front-top__title">Фотогалерея</div>
		<div class="front-top__link"><a href="/information/fotogalereya/">Все альбомы</a></div>
	</div>
	<div class="foto-album clearfix">
		<?foreach($arResult["SECTIONS"] as $arSection):?>
			<?foreach($arSection["ITEMS"] as $arItem):?>
			<?
				$this->AddEditAction($arItem['ID'], $arItem['EDIT_LINK'], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_EDIT"));
				$this->AddDeleteAction($arItem['ID'], $arItem['DELETE_LINK'], CIBlock::GetArrayByID($$arItem["IBLOCK_ID"], "ELEMENT_DELETE"), array("CONFIRM" => GetMessage('CT_BNL_ELEMENT_DELETE_CONFIRM')));
			?>
			<? $img = CFile::ResizeImageGet($arItem['PREVIEW_PICTURE']['ID'], array('width'=>585, 'height'=>480), BX_RESIZE_IMAGE_PROPORTIONAL, true, false, false, 70); ?>			
			<a href="<?=$arSection["SECTION_PAGE_URL"]?>" class="foto-album__item" id="<?=$this->GetEditAreaId($arItem['ID']);?>">
				<div class="foto-album__item-img" style="background-image: url(<?=$img['src']?>)"></div>
				<div class="foto-album__item-text"><?=$arSection["NAME"]?></div>
			</a>
			<?endforeach;?>
		<?endforeach;?>
	</div>
</div>
<? } ?>
