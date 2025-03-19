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
<div class="ir-statements">
    <?if($arParams["DISPLAY_TOP_PAGER"]):?>
        <?=$arResult["NAV_STRING"]?><br />
    <?endif;?>
	<div class="ir-statements__table-fluid">
		<table class="ir-statements__table">
		<thead>
		<tr>
			<th class="center">
				<?=getMessage("CT_BNL_ELEMENT_DATE_DESC");?>
			</th>
			<th>
				<?=getMessage("CT_BNL_ELEMENT_ADDRESSEE_DESC");?>
			</th>
			<th>
				<?=getMessage("CT_BNL_ELEMENT_THEME_DESC");?>
			</th>
			<th class="center">
				<?=getMessage("CT_BNL_ELEMENT_STATUS_DESC");?>
			</th>
		</tr>
		</thead>
		<tbody>
            <?foreach($arResult["ITEMS"] as $arItem):?>
            <?
            $this->AddEditAction($arItem['ID'], $arItem['EDIT_LINK'], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_EDIT"));
            $this->AddDeleteAction($arItem['ID'], $arItem['DELETE_LINK'], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_DELETE"), array("CONFIRM" => GetMessage('CT_BNL_ELEMENT_DELETE_CONFIRM')));
            ?>
            <tr id="<?=$this->GetEditAreaId($arItem['ID']);?>" onclick="window.location.href='<?=$arItem["DETAIL_PAGE_URL"]?>'; return false">
                <td data-label="<?=getMessage("CT_BNL_ELEMENT_DATE_DESC");?>" class="center">
                    <?if($arItem["DISPLAY_PROPERTIES"]["DATE"]["DISPLAY_VALUE"]):?>
                        <?=$arItem["DISPLAY_PROPERTIES"]["DATE"]["DISPLAY_VALUE"]?>
                    <?endif;?>
                </td>
                <td data-label="<?=getMessage("CT_BNL_ELEMENT_ADDRESSEE_DESC");?>">
                    <?if($arItem["CATEGORY"]):?><?=$arItem["CATEGORY"]?><?endif;?><?if($arItem["AGENCY"]):?>, <?=$arItem["AGENCY"]?><?endif;?>
                </td>
                <td data-label="<?=getMessage("CT_BNL_ELEMENT_THEME_DESC");?>">
                    <?if($arItem["DISPLAY_PROPERTIES"]["THEME"]["DISPLAY_VALUE"]):?>
                        <?=$arItem["DISPLAY_PROPERTIES"]["THEME"]["DISPLAY_VALUE"]?>
                    <?endif;?>
                </td>
                <td data-label="<?=getMessage("CT_BNL_ELEMENT_STATUS_DESC");?>" class="center">
                    <?if($arItem["DISPLAY_PROPERTIES"]["STATUS"]["DISPLAY_VALUE"]):?>
                        <?=$arItem["DISPLAY_PROPERTIES"]["STATUS"]["DISPLAY_VALUE"]?>
                    <?endif;?>
                </td>
            </tr>
            <?endforeach;?>
		</tbody>
		</table>
	</div>
    <?if($arParams["DISPLAY_BOTTOM_PAGER"]):?>
        <?=$arResult["NAV_STRING"]?>
    <?endif;?>    
</div>