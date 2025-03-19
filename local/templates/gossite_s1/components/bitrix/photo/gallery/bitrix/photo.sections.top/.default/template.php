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
<div class="gallery-alboms">
    <div class="row">
<?foreach($arResult["SECTIONS"] as $arSection):?>
	<?
	$this->AddEditAction('section_'.$arSection['ID'], $arSection['ADD_ELEMENT_LINK'], CIBlock::GetArrayByID($arSection["IBLOCK_ID"], "ELEMENT_ADD"), array('ICON' => 'bx-context-toolbar-create-icon'));
	$this->AddEditAction('section_'.$arSection['ID'], $arSection['EDIT_LINK'], CIBlock::GetArrayByID($arSection["IBLOCK_ID"], "SECTION_EDIT"));
	$this->AddDeleteAction('section_'.$arSection['ID'], $arSection['DELETE_LINK'], CIBlock::GetArrayByID($arSection["IBLOCK_ID"], "SECTION_DELETE"), array("CONFIRM" => GetMessage('CT_BPS_SECTION_DELETE_CONFIRM')));
    ?>
    <div class="col-sm-6 col-md-4" id="<?=$this->GetEditAreaId('section_'.$arSection['ID']);?>">
        <?foreach($arSection["ITEMS"] as $arItem):?>
            <div class="thumbnail">
                <a href="<?=$arSection["SECTION_PAGE_URL"]?>">
                    <div class="wrap-img">
                        <?if(is_array($arItem["PICTURE"])):?>
                            <img
                                src="<?=$arItem["PICTURE"]["SRC_RE"]?>"
                                alt="<?=$arItem["PICTURE"]["ALT"]?>"
                                title="<?=$arItem["PICTURE"]["TITLE"]?>"
                                />
                        <?endif?>
                    </div>
                </a>
                <div class="caption__wr">
                    <div class="caption">
                      <a href="<?=$arSection["SECTION_PAGE_URL"]?>"><b><?=$arSection["NAME"]?></b></a>
                    </div>
                    <p class="count"><?=$arResult["SECTION_COUNT_EL"][$arSection["ID"]]?> <i class="fa fa-picture-o" aria-hidden="true"></i></p>
                </div>
                
             </div>
		<?endforeach?>
     </div>
<?endforeach;?>
    </div>
</div>
<!--gallery-alboms-->
