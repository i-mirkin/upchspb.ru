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
<div class="wrap-question-list">
<?if($arParams["DISPLAY_TOP_PAGER"]):?>
	<?=$arResult["NAV_STRING"]?><br />
<?endif;?>
<div class="question-list">
    <?foreach($arResult["ITEMS"] as $arItem):?>	
        <?
        $this->AddEditAction($arItem['ID'], $arItem['EDIT_LINK'], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_EDIT"));
        $this->AddDeleteAction($arItem['ID'], $arItem['DELETE_LINK'], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_DELETE"), array("CONFIRM" => GetMessage('CT_BNL_ELEMENT_DELETE_CONFIRM')));
		$k=1;
        ?>
        <div class="question-item" id="<?=$this->GetEditAreaId($arItem['ID']);?>">
            <div class="wrap-icon">
                <i class="icom icon-question"></i>
            </div>
            <? if (count($arItem['TAG_LINKS'])>0): ?>
			<div class="question-item-tag">
				
				<? foreach($arItem['TAG_LINKS'] as $tagLink) { ?>
				<span><a href="/tag/<?=$tagLink['CODE']?>/"><?=$tagLink['NAME']?></a><?if($k!=count($arItem['TAG_LINKS'])) {?> | <?}?></span>
				<? $k++;
					} ?>
			</div>
			<?endif;?>
            <div class="wrap-question">
                <?//if($arParams["DISPLAY_NAME"]!="N" && $arItem["NAME"]):?>
                        <b><?echo $arItem["PREVIEW_TEXT"]?></b> <a class="link-question-detail" href="<?=$arItem['DETAIL_PAGE_URL']?>" title="<?=getMessage("QU_DETAIL_LINK")?>"><i class="ion ion-link" aria-hidden="true"></i></a><br />
                <?//endif;?>
                <div class="auhtor">
                    <i class="fa fa-user" aria-hidden="true"></i> 
                    <?=$arItem["DISPLAY_PROPERTIES"]["USER"]["DISPLAY_VALUE"]?> 
                    <span class="date-time"><?echo mb_strtolower($arItem["DATE_CREATE"], LANG_CHARSET)?></span>
                    <a href="#answer_q_<?=$arItem['ID']?>" class="link-open-question"><?=getMessage("QU_OPEN_ANSWER")?><i class="fa fa-chevron-down" aria-hidden="true"></i></a>
                </div>
                <div id="answer_q_<?=$arItem['ID']?>">
                    <div class="wrap-answer">
                        <div class="question-inner">
                            <i class="icom icon-answer"></i>
                            <div class="answer">
                                <?=$arItem["DISPLAY_PROPERTIES"]["otvet"]["DISPLAY_VALUE"]?>
                                 <div class="auhtor">
                                    <i class="fa fa-user" aria-hidden="true"></i> <?=$arItem["DISPLAY_PROPERTIES"]["AUHTOR_ANSWER"]["DISPLAY_VALUE"]?> <span class="date-time"><?echo mb_strtolower($arItem["TIMESTAMP_X"], LANG_CHARSET)?></span>
                                 </div>
                            </div>
                        </div>    
                    </div>
                </div>
            </div>
        </div>
    <?endforeach;?>
</div>
<?if($arParams["DISPLAY_BOTTOM_PAGER"]):?>
	<br /><?=$arResult["NAV_STRING"]?>
<?endif;?>
</div>
