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

<?if(!empty($arResult['ITEMS'])) { ?>
<?
	$calendarItem = array_shift(array_values($arResult['ITEMS']));		
	$fileImgSrc = '';
	$fileImg = CFile::ResizeImageGet($calendarItem['PREVIEW_PICTURE'], array('width'=>477, 'height'=>477), BX_RESIZE_IMAGE_PROPORTIONAL, true, false, false, 70);  	
	$fileImgSrc = $fileImg ? $fileImg['src'] : SITE_TEMPLATE_PATH . '/images/noimg.png' ;	
	
	$this->AddEditAction($calendarItem['ID'], $calendarItem['EDIT_LINK'], CIBlock::GetArrayByID($calendarItem["IBLOCK_ID"], "ELEMENT_EDIT"));
	$this->AddDeleteAction($calendarItem['ID'], $calendarItem['DELETE_LINK'], CIBlock::GetArrayByID($calendarItem["IBLOCK_ID"], "ELEMENT_DELETE"), array("CONFIRM" => GetMessage('CT_BNL_ELEMENT_DELETE_CONFIRM')));
?>
<?
	$pdfDoc = CFile::GetPath($calendarItem['PROPERTIES']['PDF']['VALUE']);	
	$imgDoc = CFile::GetPath($calendarItem['PROPERTIES']['IMAGE']['VALUE']);
?>

<div class="calendar-rights__title"><a target="_blank" href="<?php echo $pdfDoc?>">Правозащитный календарь</a></div>
<div class="calendar-rights__cont" id="<?=$this->GetEditAreaId($calendarItem['ID']);?>">
	<a href="<?=$imgDoc?>" class="calendar-rights__img lazy_inst" data-bg="<?=$fileImgSrc?>" target="_blank"></a>
	<div class="calendar-rights__wr">
		<?if($calendarItem['PROPERTIES']['AUTHOR']['VALUE']) { ?>
		<div class="calendar-rights__date"><?=$calendarItem['PROPERTIES']['AUTHOR']['VALUE']?></div>
		<? } ?>
		<?php //<a href="$pdfDoc" class="calendar-rights__name" target="_blank">$calendarItem['NAME']</a> ?>
		<?if($calendarItem['PREVIEW_TEXT']) { ?>
		<div class="calendar-rights__text"><?=$calendarItem['PREVIEW_TEXT']?></div>
		<? } ?>
	</div>
</div>
<? } ?>




