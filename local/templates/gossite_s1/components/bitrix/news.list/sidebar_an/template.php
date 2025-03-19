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
<?if(!empty($arResult["ITEMS"])) { ?>
    <h4 style="color:red;"><?=GetMessage('ANNOUNCEMENT_TTL');?></h4>
    <br>
    <div class="news-list news-list--col">
        <?foreach($arResult["ITEMS"] as $arItem):?>
            <?
            $this->AddEditAction($arItem['ID'], $arItem['EDIT_LINK'], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_EDIT"));
            $this->AddDeleteAction($arItem['ID'], $arItem['DELETE_LINK'], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_DELETE"), array("CONFIRM" => GetMessage('CT_BNL_ELEMENT_DELETE_CONFIRM')));
            ?>
            <a href="<?=$arItem["DETAIL_PAGE_URL"]?>" class="news-list__item clearfix" id="<?=$this->GetEditAreaId($arItem['ID']);?>" <?if('Y' == $arItem['PROPERTIES']['ADMIN_ONLY']['VALUE']) { ?>data-admin-only="Y"<? } ?>>
                <div class="news-list__item-date"><?=$arItem["DISPLAY_ACTIVE_FROM"]?></div>
                <div class="news-list__item-title"><?=$arItem["NAME"]?></div>
            </a>
        <?endforeach;?>
    </div>
    <div class="line-gorizont"></div>
<? } ?>


