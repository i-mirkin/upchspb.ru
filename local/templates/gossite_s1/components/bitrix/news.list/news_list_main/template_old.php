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

foreach($arResult["ITEMS"] as $item) { 
	if(22 == $item['DISPLAY_PROPERTIES']['THEME']['VALUE_ENUM_ID']) $mainNews = $item;
	if(21 == $item['DISPLAY_PROPERTIES']['THEME']['VALUE_ENUM_ID']) $breakingNews = $item;
	if($item['DISPLAY_PROPERTIES']['MAIN_SHOW']['VALUE'] == 'Y') $mainList[] = $item;
}

?>

<?if(!empty($arResult["ITEMS"])) { ?>
<div class="front-top clearfix">
	<div class="front-top__title">Новости</div>
	<div class="front-top__link"><a href="/news/">Все новости</a></div>
</div>
<? if (!empty($breakingNews) || !empty($mainNews)) { ?>
<div class="news-list news-list--front news-list--big clearfix">
	<?if(!empty($breakingNews)) { ?>
		<?
		$this->AddEditAction($breakingNews['ID'], $breakingNews['EDIT_LINK'], CIBlock::GetArrayByID($breakingNews["IBLOCK_ID"], "ELEMENT_EDIT"));
		$this->AddDeleteAction($breakingNews['ID'], $breakingNews['DELETE_LINK'], CIBlock::GetArrayByID($breakingNews["IBLOCK_ID"], "ELEMENT_DELETE"), array("CONFIRM" => GetMessage('CT_BNL_ELEMENT_DELETE_CONFIRM')));
		$breakingimg = '';
		$breakingimg = CFile::ResizeImageGet($breakingNews['PREVIEW_PICTURE']['ID'], array('width'=>840, 'height'=>434), BX_RESIZE_IMAGE_PROPORTIONAL, true, false, false, 70);
		?>
	<div class="news-list__item news-list__item--main" id="<?=$this->GetEditAreaId($breakingNews['ID']);?>">
		<a href="<?=$breakingNews['DETAIL_PAGE_URL']?>" class="news-list__item-cont clearfix">
			<div class="news-list__item-img" style="background-image: url(<?if($breakingimg) { echo $breakingimg['src']; } else {echo SITE_TEMPLATE_PATH . '/images/noimg.png';}?>);">
				<div class="news-list__item-theme" style="display:none"><?= $breakingNews['DISPLAY_PROPERTIES']['THEME']['VALUE'] ?></div>
			</div>
			<div class="news-list__item-date"><?=$breakingNews['DISPLAY_ACTIVE_FROM']?></div>
			<div class="news-list__item-main">Срочно</div>
			<div class="news-list__item-title"><?= $breakingNews['NAME'] ?></div>
		</a>
	</div>
	<? } ?>
	<?if(!empty($mainNews)) { ?>
		<?
		$this->AddEditAction($mainNews['ID'], $mainNews['EDIT_LINK'], CIBlock::GetArrayByID($mainNews["IBLOCK_ID"], "ELEMENT_EDIT"));
		$this->AddDeleteAction($mainNews['ID'], $mainNews['DELETE_LINK'], CIBlock::GetArrayByID($mainNews["IBLOCK_ID"], "ELEMENT_DELETE"), array("CONFIRM" => GetMessage('CT_BNL_ELEMENT_DELETE_CONFIRM')));
		$mainNewsImg = '';
		$mainNewsImg = CFile::ResizeImageGet($mainNews['PREVIEW_PICTURE']['ID'], array('width'=>840, 'height'=>434), BX_RESIZE_IMAGE_PROPORTIONAL, true, false, false, 70);
		?>
	<div class="news-list__item" id="<?=$this->GetEditAreaId($mainNews['ID']);?>">
		<a href="<?=$mainNews['DETAIL_PAGE_URL']?>" class="news-list__item-cont clearfix">
			<div class="news-list__item-img" style="background-image: url(<?if($mainNewsImg) { echo $mainNewsImg['src'];} else {echo SITE_TEMPLATE_PATH . '/images/noimg.png'; }?>);">
				<div class="news-list__item-theme" style="display:none"><?= $mainNews['DISPLAY_PROPERTIES']['THEME']['VALUE'] ?></div>
			</div>
			<div class="news-list__item-date"><?=$mainNews['DISPLAY_ACTIVE_FROM']?></div>
			<div class="news-list__item-title"><?= $mainNews['NAME'] ?></div>
		</a>
	</div>
	<? } ?>
</div>
<? } ?>

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
			switch($arItem['DISPLAY_PROPERTIES']['THEME']['VALUE_ENUM_ID']) {
				case 19:
					$sectLink = '/news_preview/';
				break;
				case 20:
					$sectLink = '/o-nas/smi/';
				break;
			}
			$k=1;
		?>
	<div class="news-list__item clearfix" id="<?=$this->GetEditAreaId($arItem['ID']);?>">
		<div class="news-list__item-top clearfix">
			<div class="news-list__item-date"><?=$arItem['DISPLAY_ACTIVE_FROM']?></div>			
			<?if($arItem['DISPLAY_PROPERTIES']['THEME']['VALUE']) { ?>
			<div class="news-list__item-theme"><a href="<?=$sectLink?>"><?=$arItem['DISPLAY_PROPERTIES']['THEME']['VALUE']?></a></div>
			<? } ?>
			<?if(isset($arItem['TAG_LINKS']) && !empty($arItem['TAG_LINKS'])) { ?>
			<div class="news-list__item-tag">
				<? foreach($arItem['TAG_LINKS'] as $tagLink) { ?>
					<span><a href="/tag/<?=$tagLink['CODE']?>/"><?=$tagLink['NAME']?></a><?if($k!=count($arItem['TAG_LINKS'])) {?> | <?}?></span>
				<? $k++;} ?>
			</div>
			<? } ?>
		</div>
		<div class="news-list__item-img" style="background-image: url(<?if($img) { echo $img['src'];} else {echo SITE_TEMPLATE_PATH . '/images/noimg.png'; }  ?>);"></div>
		<div class="news-list__item-wr">
			<div class="news-list__item-title"><a href="<?=$arItem['DETAIL_PAGE_URL']?>"><?= $arItem['NAME']?></a></div>
			<div class="news-list__item-text"><?= $arItem['~PREVIEW_TEXT']?></div>
		</div>
	</div>
	<?endforeach;?>
</div>
<? } ?>
