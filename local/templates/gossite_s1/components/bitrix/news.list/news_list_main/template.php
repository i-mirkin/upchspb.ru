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
$first_col = array_slice($arResult["ITEMS"], 0, 4);
$second_col = array_slice($arResult["ITEMS"], 3, 15);
$mainList = array();
?>

<?
$breakingNews = $mainNews = '';
$mainNewsList = $breakingNewsList = [];

foreach($arResult["ITEMS"] as $item) { 	
	if(45 == $item['DISPLAY_PROPERTIES']['THEME_STATUS']['VALUE_ENUM_ID']) $mainNews = $item;
	if(44 == $item['DISPLAY_PROPERTIES']['THEME_STATUS']['VALUE_ENUM_ID']) $breakingNews = $item;
	if($item['DISPLAY_PROPERTIES']['MAIN_SHOW']['VALUE'] == 'Y') $mainList[] = $item;
}

?>

<?if(!empty($mainList) || !empty($breakingNews) || !empty($mainNews)) { ?>

<div class="news-list news-list--front clearfix">
	<?foreach($mainList as $arItem):?>	
		<?
		$this->AddEditAction($arItem['ID'], $arItem['EDIT_LINK'], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_EDIT"));
		$this->AddDeleteAction($arItem['ID'], $arItem['DELETE_LINK'], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_DELETE"), array("CONFIRM" => GetMessage('CT_BNL_ELEMENT_DELETE_CONFIRM')));
		$img = '';
		$img = CFile::ResizeImageGet($arItem['PREVIEW_PICTURE']['ID'], array('width'=>198, 'height'=>140), BX_RESIZE_IMAGE_PROPORTIONAL, true, false, false, 70);		
		?>		
		<? 
			$sectLink = ''; 
			switch($arItem['DISPLAY_PROPERTIES']['THEME_TIP']['VALUE_ENUM_ID']) {
				case 47:
					$sectLink = '/news_preview/';
				break;
				case 46:
					$sectLink = '/information/smi-o-nas/';
				break;
			}
			$k=1;
		?>
	<div class="news-list__item clearfix" id="<?=$this->GetEditAreaId($arItem['ID']);?>" <?if('Y' == $arItem['PROPERTIES']['ADMIN_ONLY']['VALUE']) { ?>data-admin-only="Y"<? } ?>>
		<div class="news-list__item-top clearfix">
			<div class="news-list__item-date"><?=$arItem['DISPLAY_ACTIVE_FROM']?></div>			
			<?if(in_array($arItem['DISPLAY_PROPERTIES']['THEME_TIP']['VALUE_ENUM_ID'],[47])) { ?>
			<div class="news-list__item-theme ptip"><span><?=$arItem['DISPLAY_PROPERTIES']['THEME_TIP']['VALUE']?></span></div>
			<? } ?>
			<?if(in_array($arItem['DISPLAY_PROPERTIES']['THEME_TIP']['VALUE_ENUM_ID'],[46])) { ?>
			<div class="news-list__item-theme "><a href="<?=$sectLink?>"><?=$arItem['DISPLAY_PROPERTIES']['THEME_TIP']['VALUE']?></a></div> 
			<? } ?>
			<?if(isset($arItem['TAG_LINKS']) && !empty($arItem['TAG_LINKS'])) { ?>
			<div class="news-list__item-tag">
				<? foreach($arItem['TAG_LINKS'] as $tagLink) { ?>
					<span><a href="/tag/<?=$tagLink['CODE']?>/"><?=$tagLink['NAME']?></a><?if($k!=count($arItem['TAG_LINKS'])) {?> | <?}?></span>
				<? $k++;} ?>
			</div>
			<? } ?>
		</div>
		<div class="news-list__item-wr">
			<div class="news-list__item-title"><a href="<?=$arItem['DETAIL_PAGE_URL']?>"><?= $arItem['NAME']?></a></div>
			<div class="news-list__item-text"><?= $arItem['~PREVIEW_TEXT']?></div>
		</div>
	</div>
	<?endforeach;?>
	<div class="nl-link-wrap"><a href="/news/" class="btn btn-info"><?= GetMessage('ALL_NEWS');?></a></div>
</div>

<? } ?>
