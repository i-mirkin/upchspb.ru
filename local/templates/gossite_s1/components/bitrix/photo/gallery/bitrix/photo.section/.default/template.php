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
<div class="photo-section">
<?if($arParams["DISPLAY_TOP_PAGER"]):?>
	<?=$arResult["NAV_STRING"]?>
<?endif;?>
<div class="gallery-alboms chocolat-gallery--new" data-chocolat-title="<?=$arResult["NAME"]?>">
	<div class="row">
        <?foreach($arResult["ITEMS"] as $arItem):?>
            <?if(is_array($arItem)):?>
                <?
                $this->AddEditAction($arItem['ID'], $arItem['EDIT_LINK'], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_EDIT"));
                $this->AddDeleteAction($arItem['ID'], $arItem['DELETE_LINK'], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_DELETE"), array("CONFIRM" => GetMessage('CT_BPS_ELEMENT_DELETE_CONFIRM')));
                    ?>
                    <div class="col-sm-6 col-md-4"  id="<?=$this->GetEditAreaId($arItem['ID']);?>">
                        <div class="thumbnail">
                            <div id="photo_<?=$arItem["ID"]?>" data-src="<?=$arItem["DETAIL_PICTURE"]["SRC"]?>" class="chocolat-image">
								<?if($arItem['~PREVIEW_TEXT']) { ?><? } ?>
								<span class="chocolat-image-preview" style="display: none"><?=$arItem['~PREVIEW_TEXT']?></span>
								
                                <div class="wrap-img">
                                    <?if(is_array($arItem["PICTURE"])):?>
                                        <img
                                            src="<?=$arItem["DETAIL_PICTURE"]["SRC"]?>"
                                            alt="<?=$arItem["PICTURE"]["ALT"]?>"
                                            title="<?=$arItem["PICTURE"]["TITLE"]?>"
                                            />
                                    <?endif?>
                                </div>
                            </div>
                            <div class="caption">
                                <b><?=$arItem["NAME"]?></b>
                            </div>
                         </div>
                     </div>      
            <?endif;?>            
        <?endforeach?>
    </div>
</div>
<!--gallery-alboms-->                    
<?if($arParams["DISPLAY_BOTTOM_PAGER"]):?>
	<br /><?=$arResult["NAV_STRING"]?>
<?endif;?>
</div>

