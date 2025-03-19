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
$this->setFrameMode(true);?>
<div class="event-calendar">
    <div class="row">
        <div class="col-sm-6">
            <div id="datetimepicker-events" class="calendar-inline"></div>
        </div>
        <div class="col-sm-6">
            <div class="wrap-events-main">
                <div class="scroll-wrap" id="scroll-events-main" >
                    <div class="scrollbar-theme">
                        <div class="list-events-main">
                            <?foreach($arResult["ITEMS"] as $arItem):?>
                                <?
                                $this->AddEditAction($arItem['ID'], $arItem['EDIT_LINK'], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_EDIT"));
                                $this->AddDeleteAction($arItem['ID'], $arItem['DELETE_LINK'], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_DELETE"), array("CONFIRM" => GetMessage('CT_BNL_ELEMENT_DELETE_CONFIRM')));
                                ?>
                                <div class="item" style="display:none;" id="<?=$this->GetEditAreaId($arItem['ID']);?>" data-date="<?=ConvertDateTime($arItem["ACTIVE_FROM"], "DD.MM.YYYY");?>">
                                    <?if($arParams["DISPLAY_DATE"]!="N" && $arItem["DISPLAY_ACTIVE_FROM"]):?>
                                        <p class="date"><?echo $arItem["DISPLAY_ACTIVE_FROM"]?></p>
                                    <?endif?>
                                    <?if($arParams["DISPLAY_NAME"]!="N" && $arItem["NAME"]):?>
                                        <?if(!$arParams["HIDE_LINK_WHEN_NO_DETAIL"] || ($arItem["DETAIL_TEXT"] && $arResult["USER_HAVE_ACCESS"])):?>
                                            <a  class="title" href="<?echo $arItem["DETAIL_PAGE_URL"]?>"><b><?echo $arItem["NAME"]?></b></a><br />
                                        <?else:?>
                                            <b><?echo $arItem["NAME"]?></b><br />
                                        <?endif;?>
                                    <?endif;?>
                                    <?if($arParams["DISPLAY_PREVIEW_TEXT"]!="N" && $arItem["PREVIEW_TEXT"]):?>
                                        <p class="preview-text"><?echo $arItem["PREVIEW_TEXT"];?></p>
                                    <?endif;?>
                                    <?if(!$arParams["HIDE_LINK_WHEN_NO_DETAIL"] || ($arItem["DETAIL_TEXT"] && $arResult["USER_HAVE_ACCESS"])):?>
                                        <a href="<?echo $arItem["DETAIL_PAGE_URL"]?>" class="btn btn-info"><?=getMessage("CT_BNL_DESC_FULL_LINK")?></a>
                                    <?endif;?>
                                </div>
                            <?endforeach;?>                            
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
