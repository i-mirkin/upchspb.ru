<div class="front-top clearfix ">
	<div class="front-top__title">Новости</div>
	<div class="front-top__link"><a href="/news/">Все новости</a></div>
</div>
<?if(!empty($arResult['ITEMS'])){?>
	<?$breakingNews = $arResult['breakingNews'];?>
	<div class="news-list news-list--front news-list--big clearfix">
	<?if(!empty($breakingNews)) { ?>
	<?
	$this->AddEditAction($breakingNews['ID'], $breakingNews['EDIT_LINK'], CIBlock::GetArrayByID($breakingNews["IBLOCK_ID"], "ELEMENT_EDIT"));
	$this->AddDeleteAction($breakingNews['ID'], $breakingNews['DELETE_LINK'], CIBlock::GetArrayByID($breakingNews["IBLOCK_ID"], "ELEMENT_DELETE"), array("CONFIRM" => GetMessage('CT_BNL_ELEMENT_DELETE_CONFIRM')));
	$breakingimg = '';
	$breakingimg = CFile::ResizeImageGet($breakingNews['PREVIEW_PICTURE']['ID'], array('width'=>927, 'height'=>480), BX_RESIZE_IMAGE_PROPORTIONAL, true, false, false, 80);
	?>
	<div class="news-list__item news-list__item--main" id="<?=$this->GetEditAreaId($breakingNews['ID']);?>" <?if('Y' == $breakingNews['PROPERTIES']['ADMIN_ONLY']['VALUE']) { ?>data-admin-only="Y"<? } ?>>
	<a href="<?=$breakingNews['DETAIL_PAGE_URL']?>" class="news-list__item-cont clearfix">
		<div class="news-list__item-img" style="background-image: url(<?if($breakingimg) { echo $breakingimg['src']; } else {echo SITE_TEMPLATE_PATH . '/images/noimg.png';}?>);">
			<div class="news-list__item-theme" style="display:none"><?= $breakingNews['DISPLAY_PROPERTIES']['THEME']['VALUE'] ?></div>
		</div>
		<div class="news-list__item-date"><?=$breakingNews['DISPLAY_ACTIVE_FROM']?></div>
			<div class="news-list__item-main">Важно</div>
		<div class="news-list__item-title"><?= $breakingNews['NAME'] ?></div>
		<?//<div class="news-list__item-preview"> $breakingNews['PREVIEW_TEXT'] </div>?>			
	</a>

	</div>
	<? } ?>
	<?$mainNews = $arResult['mainNews'];?>
	<?if(!empty($mainNews)) { ?>
	<?
	$this->AddEditAction($mainNews['ID'], $mainNews['EDIT_LINK'], CIBlock::GetArrayByID($mainNews["IBLOCK_ID"], "ELEMENT_EDIT"));
	$this->AddDeleteAction($mainNews['ID'], $mainNews['DELETE_LINK'], CIBlock::GetArrayByID($mainNews["IBLOCK_ID"], "ELEMENT_DELETE"), array("CONFIRM" => GetMessage('CT_BNL_ELEMENT_DELETE_CONFIRM')));
	$mainNewsImg = '';
	$mainNewsImg = CFile::ResizeImageGet($mainNews['PREVIEW_PICTURE']['ID'], array('width'=>927, 'height'=>480), BX_RESIZE_IMAGE_PROPORTIONAL, true, false, false, 80);
	?>
	<div class="news-list__item" id="<?=$this->GetEditAreaId($mainNews['ID']);?>" <?if('Y' == $mainNews['PROPERTIES']['ADMIN_ONLY']['VALUE']) { ?>data-admin-only="Y"<? } ?>>
	<a href="<?=$mainNews['DETAIL_PAGE_URL']?>" class="news-list__item-cont clearfix">
		<div class="news-list__item-img" style="background-image: url(<?if($mainNewsImg) { echo $mainNewsImg['src'];} else {echo SITE_TEMPLATE_PATH . '/images/noimg.png'; }?>);">
			<div class="news-list__item-theme" style="display:none"><?= $mainNews['DISPLAY_PROPERTIES']['THEME']['VALUE'] ?></div>
		</div>
		<div class="news-list__item-date"><?=$mainNews['DISPLAY_ACTIVE_FROM']?></div>
		<div class="news-list__item-title"><?= $mainNews['NAME'] ?></div>
		<?//<div class="news-list__item-preview"><?= $mainNews['PREVIEW_TEXT'] </div>?>
	</a>		
	</div>
	<? } ?>
	</div>
<?}?>