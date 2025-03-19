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
<div class="wrap-main-banners box hidden-print">
    <div class="box-title">
        <h4><?=getMessage("CT_BNL_ELEMENT_TITlE")?></h4>
        <div class="box-tools pull-right">
            <div class="arrow-banners" style="display:none;">
                <a href="#" class="prev-banners-main" title="<?=getMessage("CT_BNL_ELEMENT_PREV_SLIDE")?>"><i class="ion ion-ios-play-outline" aria-hidden="true"></i><span class="sr-only"><?=getMessage("CT_BNL_ELEMENT_PREV_SLIDE")?></span></a>
                <a href="#" class="next-banners-main" title="<?=getMessage("CT_BNL_ELEMENT_NEXT_SLIDE")?>"><i class="ion ion-ios-play-outline" aria-hidden="true"></i><span class="sr-only"><?=getMessage("CT_BNL_ELEMENT_NEXT_SLIDE")?></span></a>
            </div>
        </div>
        <hr />
    </div>
    <div class="box-body box-out-padding">
        <div class="wrap-owl-banners-main">
            <div class="owl-carousel owl-theme owl-banners-main" data-items="<?=count($arResult["ITEMS"])?>"> 
                <?foreach($arResult["FORMAT_ITEMS"] as $arItems):?>
                    <div>
                    <div class="banners-item">
                        <?
                        foreach($arItems as $key => $arItem):?>
                            <?
                            $this->AddEditAction($arItem['ID'], $arItem['EDIT_LINK'], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_EDIT"));
                            $this->AddDeleteAction($arItem['ID'], $arItem['DELETE_LINK'], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_DELETE"), array("CONFIRM" => GetMessage('CT_BNL_ELEMENT_DELETE_CONFIRM')));
                            $classPosBanner = "top";
                            if($arResult["FORMAT_LINES"] == 3){
                                $classPosBanner = ($key==0) ? "top" : "bottom";
                            } elseif($arResult["FORMAT_LINES"] == 2){
                                $classPosBanner = ($key%2==0) ? "top" : "bottom";
                            }
                            ?>
                            <div class="<?=$classPosBanner?>" id="<?=$this->GetEditAreaId($arItem['ID']);?>">
                                <?if(!empty($arItem["DISPLAY_PROPERTIES"]["LINK"]["VALUE"])):?>
                                    <a href="<?=$arItem["DISPLAY_PROPERTIES"]["LINK"]["VALUE"]?>"  target="_blank" rel="nofollow" tabindex="-1">
                                        <img
                                        class="img-responsive"
                                        src="<?=$arItem["PREVIEW_PICTURE"]["SRC"]?>"
                                        alt="<?=$arItem["PREVIEW_PICTURE"]["ALT"]?>"
                                        title="<?=$arItem["PREVIEW_PICTURE"]["TITLE"]?>"
                                        />
                                        <p class="title"><?=$arItem["NAME"]?></p>
                                  </a>
                                <?else:?>
                                    <img
                                        class="img-responsive"
                                        src="<?=$arItem["PREVIEW_PICTURE"]["SRC"]?>"
                                        alt="<?=$arItem["PREVIEW_PICTURE"]["ALT"]?>"
                                        title="<?=$arItem["PREVIEW_PICTURE"]["TITLE"]?>"
                                        />
                                    <p class="title"><?=$arItem["NAME"]?></p>
                                <?endif?>
                            </div>
                        <?endforeach;?>
						<?
                        if(count($arItems) == 1 && $arResult["FORMAT_LINES"] == 3){?>
                            <div class="bottom"></div>
                            <div class="bottom"></div>
                        <?} elseif(count($arItems) == 2 && $arResult["FORMAT_LINES"] == 3){?>
							<div class="bottom"></div>
						<?} elseif(count($arItems) == 1 && $arResult["FORMAT_LINES"] == 2){?>
							<div class="bottom"></div>
						<?}?>
                    </div>
                    </div>
                <?endforeach;?>
            </div>
        </div>
    </div>
</div>
