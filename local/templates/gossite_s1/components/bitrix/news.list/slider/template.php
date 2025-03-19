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
$k = 0;
?>
<?if(!empty($arResult["ITEMS"])) { ?>
<div class="front-slider">
	<div class="front-slider__fone">
		<?foreach($arResult["ITEMS"] as $arItem):?>		
		<?
			$this->AddEditAction($arItem['ID'], $arItem['EDIT_LINK'], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_EDIT"));
			$this->AddDeleteAction($arItem['ID'], $arItem['DELETE_LINK'], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_DELETE"), array("CONFIRM" => GetMessage('CT_BNL_ELEMENT_DELETE_CONFIRM')));  ?>
			<?php $fileImg = CFile::ResizeImageGet($arItem["PREVIEW_PICTURE"], array('width'=>2094, 'height'=>859), BX_RESIZE_IMAGE_PROPORTIONAL, true, false, false, 80);?>
			<?php if($k == 0) { ?>
			<a href="<?=$arItem['DISPLAY_PROPERTIES']['LINK']['VALUE']?>" class="front-slider__fone-item front-slider__fone-item--vs" data-ind='<?=$k?>' style="background-image: url(<?= !empty($fileImg['src']) ? $fileImg['src'] : $arItem["PREVIEW_PICTURE"]["SRC"]; ?>);" id="<?=$this->GetEditAreaId($arItem['ID']);?>" <?if('Y' == $arItem['PROPERTIES']['ADMIN_ONLY']['VALUE']) { ?>data-admin-only="Y"<? } ?>></a><?//front-slider__fone-item--vs?>
			<?php } else { ?>
			<a href="<?=$arItem['DISPLAY_PROPERTIES']['LINK']['VALUE']?>" class="front-slider__fone-item front-slider__fone-item--vs lazy_inst" data-ind='<?=$k?>' data-bg="<?= !empty($fileImg['src']) ? $fileImg['src'] : $arItem["PREVIEW_PICTURE"]["SRC"]; ?>" id="<?=$this->GetEditAreaId($arItem['ID']);?>" <?if('Y' == $arItem['PROPERTIES']['ADMIN_ONLY']['VALUE']) { ?>data-admin-only="Y"<? } ?>></a><?//front-slider__fone-item--vs?>
			<?php } ?>
			
		<?$k++; endforeach;?>
	</div>
	<div class="front-slider__wr">
		<div class="front-slider__cont">
			<?foreach($arResult["ITEMS"] as $arItem):?>
				<?//if($arParams["DISPLAY_PREVIEW_TEXT"]!="N" && $arItem["PREVIEW_TEXT"]):?>
				<a href="<?=$arItem['DISPLAY_PROPERTIES']['LINK']['VALUE']?>" class="front-slider__item">
					<!-- <div class="front-slider__item-prev">Анонс</div> -->
					<? //<div class="front-slider__item-text"></div>$arItem["PREVIEW_TEXT"]?>
				</a>
				<?//endif;?>
			<? $k++; endforeach;?>
		</div>
	</div>
	<div class="front-slider__arr front-slider__arr--prev"></div>
	<div class="front-slider__arr front-slider__arr--next"></div>
</div>
<?}?>









