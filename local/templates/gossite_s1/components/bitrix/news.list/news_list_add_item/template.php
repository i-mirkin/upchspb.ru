<?if(!empty($arResult['ITEMS'])){?>
		<?
		$this->AddEditAction($arResult['ITEMS'][0]['ID'], $arResult['ITEMS'][0]['EDIT_LINK'], CIBlock::GetArrayByID($arResult['ITEMS'][0]["IBLOCK_ID"], "ELEMENT_EDIT"));
		$this->AddDeleteAction($arResult['ITEMS'][0]['ID'], $arResult['ITEMS'][0]['DELETE_LINK'], CIBlock::GetArrayByID($arResult['ITEMS'][0]["IBLOCK_ID"], "ELEMENT_DELETE"), array("CONFIRM" => GetMessage('CT_BNL_ELEMENT_DELETE_CONFIRM')));
		$breakingimg = '';
		$breakingimg = CFile::ResizeImageGet($arResult['ITEMS'][0]['PREVIEW_PICTURE']['ID'], array('width'=>927, 'height'=>480), BX_RESIZE_IMAGE_PROPORTIONAL, true, false, false, 80);
		?>
	<div class="news-list__item news-list__item--main" id="<?=$this->GetEditAreaId($breakingNews['ID']);?>">
		<a href="<?=$breakingNews['DETAIL_PAGE_URL']?>" class="news-list__item-cont clearfix">
			<div class="news-list__item-img" style="background-image: url(<?if($breakingimg) { echo $breakingimg['src']; } else {echo SITE_TEMPLATE_PATH . '/images/noimg.png';}?>);">
				<div class="news-list__item-theme" style="display:none"><?= $arResult['ITEMS'][0]['DISPLAY_PROPERTIES']['THEME']['VALUE'] ?></div>
			</div>
			<div class="news-list__item-date"><?=$arResult['ITEMS'][0]['DISPLAY_ACTIVE_FROM']?></div>
				<div class="news-list__item-main">Важно</div>
			<div class="news-list__item-title"><?= $arResult['ITEMS'][0]['NAME'] ?></div>
			<?//<div class="news-list__item-preview"> $breakingNews['PREVIEW_TEXT'] </div>?>			
		</a>
		
	</div>	
<?}?>
