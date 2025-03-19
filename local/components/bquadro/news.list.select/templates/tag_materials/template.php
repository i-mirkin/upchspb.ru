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

<?if(!empty($arResult["ITEMS"])) {?>
<div class="col-in">
	<div class="news-tag">
		<div class="front-top clearfix">
			<div class="front-top__title"><?=$arParams['BLOCK_TITLE']?></div>			
		</div>
		<div class="news-tag__wr clearfix">
		<?foreach($arResult["ITEMS"] as $arItem):?>			
			<?
			$this->AddEditAction($arItem['ID'], $arItem['EDIT_LINK'], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_EDIT"));
			$this->AddDeleteAction($arItem['ID'], $arItem['DELETE_LINK'], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_DELETE"), array("CONFIRM" => GetMessage('CT_BNL_ELEMENT_DELETE_CONFIRM')));
			$imgFileSrc = SITE_TEMPLATE_PATH . '/images/noimg.png';
			$imgFile = CFile::ResizeImageGet($arItem["PREVIEW_PICTURE"], array('width'=>423, 'height'=>347), BX_RESIZE_IMAGE_PROPORTIONAL, true, false, false, 70);
			if($imgFile) $imgFileSrc = $imgFile['src'];
			?>
		
			<a href="<?echo $arItem["DETAIL_PAGE_URL"]?>" class="news-tag__item" id="<?=$this->GetEditAreaId($arItem['ID']);?>">
				<div class="news-tag__item-img" style="background-image: url(<?=$imgFileSrc?>)"></div>
				<div class="news-tag__item-text"><?echo $arItem["NAME"]?></div>
			</a>
		<?endforeach;?>
		</div>
	</div>
</div>
<? } ?>

