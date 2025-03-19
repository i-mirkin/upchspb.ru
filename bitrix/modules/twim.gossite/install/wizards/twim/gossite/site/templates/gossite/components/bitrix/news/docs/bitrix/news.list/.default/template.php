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
<?if($arParams["DISPLAY_TOP_PAGER"]):?>
	<?=$arResult["NAV_STRING"]?><br />
<?endif;?>
<div class="doc-list">
<?foreach($arResult["ITEMS"] as $arItem):?>
	<?
	$this->AddEditAction($arItem['ID'], $arItem['EDIT_LINK'], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_EDIT"));
	$this->AddDeleteAction($arItem['ID'], $arItem['DELETE_LINK'], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_DELETE"), array("CONFIRM" => GetMessage('CT_BNL_ELEMENT_DELETE_CONFIRM')));
	?>
    <div class="item"  id="<?=$this->GetEditAreaId($arItem['ID']);?>">
        <?if($arParams["DISPLAY_DATE"]!="N" && $arItem["DISPLAY_ACTIVE_FROM"]):?>
			<p class="date"><?echo $arItem["DISPLAY_ACTIVE_FROM"]?></p>
		<?endif?>
            
        <?if($arParams["DISPLAY_NAME"]!="N" && $arItem["NAME"]):?>
			<?if(!$arParams["HIDE_LINK_WHEN_NO_DETAIL"] || ($arItem["DETAIL_TEXT"] && $arResult["USER_HAVE_ACCESS"])):?>
				<a class="title-doc" href="<?echo $arItem["DETAIL_PAGE_URL"]?>"><b><?echo $arItem["NAME"]?></b></a><br />
			<?else:?>
				<p class="title-doc" >
                    <b><?echo $arItem["NAME"]?></b><br />
                </p>
			<?endif;?>
		<?endif;?>
        <?
        if(!empty($arItem["DISPLAY_PROPERTIES"]["FILE"])){
            if(isset($arItem["DISPLAY_PROPERTIES"]["FILE"]["VALUE"])
                && is_array($arItem["DISPLAY_PROPERTIES"]["FILE"]["VALUE"])
                && count($arItem["DISPLAY_PROPERTIES"]["FILE"]["VALUE"]) > 1
            ){
                $arFiles = $arItem["DISPLAY_PROPERTIES"]["FILE"]["FILE_VALUE"];?>
                <?foreach ($arFiles as $key => $file){?>
                    <?=(int)$key+1?>.
                    <p class="view"><a class="view_popup_doc" title="<?=$arItem["NAME"]?>" href="<?=SITE_DIR?>local/viewdoc.php?link=<?=$file["LINK"]?>" ><i class="ion ion-ios-eye-outline margin-r-5" aria-hidden="true"></i><?=GetMessage('CT_BNL_ELEMENT_FILE_VIEW')?></a></p>
                    <p class="files"><a href="<?=$file["SRC"]?>" target="_blank"><i class="<?=$file["ICON"]?> margin-r-5" aria-hidden="true"></i><?=GetMessage('CT_BNL_ELEMENT_FILE_DOWNLOAD')?></a><span class="margin-l-5"><?=$file["FORMAT_SIZE"]?></span></p>
                    <br />
                <?}?>
            <?}else{
                $arFiles = $arItem["DISPLAY_PROPERTIES"]["FILE"]["FILE_VALUE"];
                ?>
                <p class="view"><a class="view_popup_doc"  title="<?=$arItem["NAME"]?>" href="<?=SITE_DIR?>local/viewdoc.php?link=<?=$arFiles["LINK"]?>" ><i class="ion ion-ios-eye-outline margin-r-5" aria-hidden="true"></i><?=GetMessage('CT_BNL_ELEMENT_FILE_VIEW')?></a></p>
                <p class="files"><a href="<?=$arFiles["SRC"]?>" target="_blank"><i class="<?=$arFiles["ICON"]?> margin-r-5" aria-hidden="true"></i><?=GetMessage('CT_BNL_ELEMENT_FILE_DOWNLOAD')?></a><span class="margin-l-5"><?=$arFiles["FORMAT_SIZE"]?></span></p>
            <?}
        }?>
    </div>
    <!--item-->
<?endforeach;?>
</div>
<!--doc-list-->
<?if($arParams["DISPLAY_BOTTOM_PAGER"]):?>
     <?=$arResult["NAV_STRING"]?>
<?endif;?>
