<?if(!empty($arResult['ITEMS'])) { ?>
<div class="col-in col-in--addition">
<div class="front-top clearfix">
	<div class="front-top__title"><?=$arResult['BOX_TITLE']?></div>
</div>
<div class="front-dop clearfix">
	<div class="front-dop__wr">
		<?foreach($arResult['ITEMS'] as $item) { $k=1; ?>					
        <? $dateY = FormatDate('j F Y', MakeTimeStamp($item['DATE_ACTIVE_FROM'], "DD.MM.YYYY")); ?>
		<?
		$this->AddEditAction($item['ID'], $item['EDIT_LINK'], CIBlock::GetArrayByID($item["IBLOCK_ID"], "ELEMENT_EDIT"));
		$this->AddDeleteAction($item['ID'], $item['DELETE_LINK'], CIBlock::GetArrayByID($item["IBLOCK_ID"], "ELEMENT_DELETE"), array("CONFIRM" => GetMessage('CT_BNL_ELEMENT_DELETE_CONFIRM')));
		?>		
		<?
			$fileImgSrc = SITE_TEMPLATE_PATH . '/images/noimg.png';			
			$fileImg = CFile::ResizeImageGet($item['PREVIEW_PICTURE'], array('width'=>552, 'height'=>318), BX_RESIZE_IMAGE_PROPORTIONAL, true, false, false, 70);
			if($fileImg) $fileImgSrc = $fileImg['src'];
		?>		
		<div class="front-dop__item" id="<?=$this->GetEditAreaId($item['ID']);?>" <?if('Y' == $item['PROPERTY_ADMIN_ONLY_VALUE']) { ?>data-admin-only="Y"<? } ?>>			            
			<?if(isset($item['tags']) && !empty($item['tags'])) { ?>
				<div class="front-dop__item-tag">
					<? foreach($item['tags'] as $tagId) { ?>
					<span><a href="/tag/<?=$arResult['TAGS'][$tagId]['CODE']?>/"><?=$arResult['TAGS'][$tagId]['NAME']?></a><?if($k!=count($item['tags'])) {?> | <?}?></span> 
					<? $k++;} ?>
				</div>
			<? } ?>

			<div class="front-dop__item-img lazy_inst" data-bg="<?=$fileImgSrc?>"></div>
			<p><?= $dateY ?></p>
			<div  class="front-dop__item-title"><a href="<?=$item['DETAIL_PAGE_URL']?>"><?=$item['NAME']?></a></div>
			<?if(!empty($item['PREVIEW_TEXT'])) { ?>
			<div class="front-dop__item-text"><?=$item['PREVIEW_TEXT']?></div>
			<? } ?>
		</div>
		<? } ?>
		<?php if( $arResult['SITE_ID'] == 's1') { ?>
		<div class="nl-link-wrap"><a href="/tag/" class="btn btn-info"><?= GetMessage('ALL_TAGS');?></a></div>
		<?php } ?>
	</div>	
</div>
</div>
<?}?>