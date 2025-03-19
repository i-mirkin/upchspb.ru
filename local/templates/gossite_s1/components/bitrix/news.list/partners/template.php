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
// dump($arResult)
?>


<div class="col-in">
	<?/*
	<div class="front-top clearfix">
		
		<div class="front-top__title"><?=getMessage("CT_BNL_PARTNERS")?></div>
		
	</div>
	*/?>
	<div class="partner-list clearfix">
		<div class="partner-list__slider">
			<?foreach($arResult["ITEMS"] as $key =>  $arItem):?>
				<?
				$this->AddEditAction($arItem['ID'], $arItem['EDIT_LINK'], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_EDIT"));
                $this->AddDeleteAction($arItem['ID'], $arItem['DELETE_LINK'], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_DELETE"), array("CONFIRM" => GetMessage('CT_BNL_ELEMENT_DELETE_CONFIRM')));
				$imgfile = CFile::ResizeImageGet($arItem["PREVIEW_PICTURE"], array('width'=>271, 'height'=>176), BX_RESIZE_IMAGE_PROPORTIONAL, true, false, false, 70);  ?>
				<div class="partner-list__item" id="<?=$this->GetEditAreaId($arItem['ID']);?>">
					<a href="<?=$arItem['PROPERTIES']['LINK']['VALUE']?>" class="partner-list__item-img" target="_blank">
						<img class="lazy_inst" data-src="<?=$imgfile['src']?>" alt="<?=$arItem['NAME']?>">
					</a>
				</div>			
			<?endforeach;?>
		</div>
	</div>
</div>



