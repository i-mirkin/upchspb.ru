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
$first_col = array_slice($arResult["ITEMS"], 0, 3);
$second_col = array_slice($arResult["ITEMS"], 3, 15);
?>
<div class="news-list-main clearfix">
    <div class="row">
        <div class="col-md-8">
            <?foreach($first_col as $key => $arItem):?>
            <?
            $this->AddEditAction($arItem['ID'], $arItem['EDIT_LINK'], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_EDIT"));
            $this->AddDeleteAction($arItem['ID'], $arItem['DELETE_LINK'], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_DELETE"), array("CONFIRM" => GetMessage('CT_BNL_ELEMENT_DELETE_CONFIRM')));
            ?>
                <?if($key == 0):?>
                    <div class="item first" id="<?=$this->GetEditAreaId($arItem['ID']);?>">
                        <?if($arParams["DISPLAY_NAME"]!="N" && $arItem["NAME"]):?>
                            <?if(!$arParams["HIDE_LINK_WHEN_NO_DETAIL"] || ($arItem["DETAIL_TEXT"] && $arResult["USER_HAVE_ACCESS"])):?>
                                <a href="<?echo $arItem["DETAIL_PAGE_URL"]?>" class="title"><b><?echo $arItem["NAME"]?></b></a>
                            <?else:?>
                                <b><?echo $arItem["NAME"]?></b><br />
                            <?endif;?>
                        <?endif;?>
                        <?if($arParams["DISPLAY_DATE"]!="N" && $arItem["DISPLAY_ACTIVE_FROM"]):?>
                            <p class="date"><?echo $arItem["DISPLAY_ACTIVE_FROM"]?></p>
                        <?endif?>
                        <?if($arParams["DISPLAY_PICTURE"]!="N" && is_array($arItem["PREVIEW_PICTURE"])):?>
                            <div class="wrap-img">
                                <?if(!$arParams["HIDE_LINK_WHEN_NO_DETAIL"] || ($arItem["DETAIL_TEXT"] && $arResult["USER_HAVE_ACCESS"])):?>
                                    <a href="<?=$arItem["DETAIL_PAGE_URL"]?>"><img
                                        src="<?=$arItem["PREVIEW_PICTURE"]["SRC"]?>"
                                        alt="<?=$arItem["PREVIEW_PICTURE"]["ALT"]?>"
                                        title="<?=$arItem["PREVIEW_PICTURE"]["TITLE"]?>"
                                         class="img-responsive"
                                        /></a>
                                <?else:?>
                                    <img
                                        src="<?=$arItem["PREVIEW_PICTURE"]["SRC"]?>"
                                        alt="<?=$arItem["PREVIEW_PICTURE"]["ALT"]?>"
                                        title="<?=$arItem["PREVIEW_PICTURE"]["TITLE"]?>"
                                        class="img-responsive"
                                        />
                                <?endif;?>
                            </div>
                        <?endif?> 
                    </div>
                    <!--item-->
                <?else:?>
                    <div class="item second">
                        <?if($arParams["DISPLAY_PICTURE"]!="N" && is_array($arItem["PREVIEW_PICTURE"])):?>
                            <div class="wrap-img">
                               <div>
                                   <?if(!$arParams["HIDE_LINK_WHEN_NO_DETAIL"] || ($arItem["DETAIL_TEXT"] && $arResult["USER_HAVE_ACCESS"])):?>
                                        <a href="<?=$arItem["DETAIL_PAGE_URL"]?>"><img
                                            src="<?=$arItem["PREVIEW_PICTURE"]["SRC"]?>"
                                            alt="<?=$arItem["PREVIEW_PICTURE"]["ALT"]?>"
                                            title="<?=$arItem["PREVIEW_PICTURE"]["TITLE"]?>"
                                             class="img-responsive"
                                            /></a>
                                    <?else:?>
                                        <img
                                            src="<?=$arItem["PREVIEW_PICTURE"]["SRC"]?>"
                                            alt="<?=$arItem["PREVIEW_PICTURE"]["ALT"]?>"
                                            title="<?=$arItem["PREVIEW_PICTURE"]["TITLE"]?>"
                                            class="img-responsive"
                                            />
                                    <?endif;?>
                               </div>
                            </div>
                        <?endif?> 
                        <div class="wrap-text">
                            <?if($arParams["DISPLAY_NAME"]!="N" && $arItem["NAME"]):?>
                                <?if(!$arParams["HIDE_LINK_WHEN_NO_DETAIL"] || ($arItem["DETAIL_TEXT"] && $arResult["USER_HAVE_ACCESS"])):?>
                                    <a href="<?echo $arItem["DETAIL_PAGE_URL"]?>" class="title"><b><?echo $arItem["NAME"]?></b></a>
                                <?else:?>
                                    <b><?echo $arItem["NAME"]?></b><br />
                                <?endif;?>
                            <?endif;?>
                            <?if($arParams["DISPLAY_PREVIEW_TEXT"]!="N" && $arItem["PREVIEW_TEXT"]):?>
                                <p class="preview-text"><?echo $arItem["PREVIEW_TEXT"];?></p>
                            <?endif;?>
                            <div class="bottom-text">
                                <?if($arParams["DISPLAY_DATE"]!="N" && $arItem["DISPLAY_ACTIVE_FROM"]):?>
                                    <p class="date"><?echo $arItem["DISPLAY_ACTIVE_FROM"]?></p>
                                <?endif?>
                                <p class="icon">
                                     <?if(!empty($arItem["FIELDS"]["DETAIL_TEXT"])):?>
                                        <i class="fa fa-file-text-o" aria-hidden="true" title="<?=getMessage("CT_BNL_ELEMENT_DETAIL_TEXT")?>"></i>
                                     <?endif;?>
                                     <?if(!empty($arItem["DISPLAY_PROPERTIES"]["MORE_PHOTOS"])):
                                         $count_photo = count($arItem["DISPLAY_PROPERTIES"]["MORE_PHOTOS"]["VALUE"]);
                                     ?><i class="fa fa-picture-o" aria-hidden="true" title="<?=getMessage("CT_BNL_ELEMENT_MORE_PHOTOS")?>"></i> <?=$count_photo?>
                                     <?endif;?>
                                     <?if(!empty($arItem["DISPLAY_PROPERTIES"]["LINK_VIDEO"])):
                                         $count_video = count($arItem["DISPLAY_PROPERTIES"]["LINK_VIDEO"]["VALUE"]);
                                     ?><i class="fa fa-film" aria-hidden="true" title="<?=getMessage("CT_BNL_ELEMENT_LINK_VIDEO")?>"></i> <?=$count_video?>
                                     <?endif;?>
                                </p>
                            </div>
                        </div>
                    </div>
                    <!--item-->
                <?endif;?>
            <?endforeach;?>
    </div> 
    <div class="col-md-4">
        <?foreach($second_col as $arItem):?>
            <?
            $this->AddEditAction($arItem['ID'], $arItem['EDIT_LINK'], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_EDIT"));
            $this->AddDeleteAction($arItem['ID'], $arItem['DELETE_LINK'], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_DELETE"), array("CONFIRM" => GetMessage('CT_BNL_ELEMENT_DELETE_CONFIRM')));
            ?>
            <div class="item"  id="<?=$this->GetEditAreaId($arItem['ID']);?>">
                <?if($arParams["DISPLAY_NAME"]!="N" && $arItem["NAME"]):?>
                    <?if(!$arParams["HIDE_LINK_WHEN_NO_DETAIL"] || ($arItem["DETAIL_TEXT"] && $arResult["USER_HAVE_ACCESS"])):?>
                        <a href="<?echo $arItem["DETAIL_PAGE_URL"]?>" class="title"><b><?echo $arItem["NAME"]?></b></a>
                    <?else:?>
                        <b><?echo $arItem["NAME"]?></b><br />
                    <?endif;?>
                <?endif;?>
                <?if($arParams["DISPLAY_PREVIEW_TEXT"]!="N" && $arItem["PREVIEW_TEXT"]):?>
                    <p class="preview-text"><?echo $arItem["PREVIEW_TEXT"];?></p>
                <?endif;?>
                <?if($arParams["DISPLAY_DATE"]!="N" && $arItem["DISPLAY_ACTIVE_FROM"]):?>
                    <p class="date"><?echo $arItem["DISPLAY_ACTIVE_FROM"]?></p>
                <?endif?>
                <p class="icon">
                     <?if(!empty($arItem["FIELDS"]["DETAIL_TEXT"])):?>
                        <i class="fa fa-file-text-o" aria-hidden="true" title="<?=getMessage("CT_BNL_ELEMENT_DETAIL_TEXT")?>"></i>
                     <?endif;?>
                     <?if(!empty($arItem["DISPLAY_PROPERTIES"]["MORE_PHOTOS"])):
                         $count_photo = count($arItem["DISPLAY_PROPERTIES"]["MORE_PHOTOS"]["VALUE"]);
                     ?><i class="fa fa-picture-o" aria-hidden="true" title="<?=getMessage("CT_BNL_ELEMENT_MORE_PHOTOS")?>"></i> <?=$count_photo?>
                     <?endif;?>
                     <?if(!empty($arItem["DISPLAY_PROPERTIES"]["LINK_VIDEO"])):
                         $count_video = count($arItem["DISPLAY_PROPERTIES"]["LINK_VIDEO"]["VALUE"]);
                     ?><i class="fa fa-film" aria-hidden="true" title="<?=getMessage("CT_BNL_ELEMENT_LINK_VIDEO")?>"></i> <?=$count_video?>
                     <?endif;?>
                </p>
            </div>
            <!--item-->
        <?endforeach;?>
    </div>
   </div>
</div>
<!--news-list-main-->
