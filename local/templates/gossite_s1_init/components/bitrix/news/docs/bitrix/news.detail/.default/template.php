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
<div class="doc-detail">
	<div class="item">
        <?if($arParams["DISPLAY_DATE"]!="N" && $arResult["DISPLAY_ACTIVE_FROM"]):?>
            <p class="date"><?=$arResult["DISPLAY_ACTIVE_FROM"]?></p>
        <?endif;?>
        <?if($arParams["DISPLAY_NAME"]!="N" && $arResult["NAME"]):?>
            <h3><?=$arResult["NAME"]?></h3>
        <?endif;?>
        <?if($arParams["DISPLAY_PREVIEW_TEXT"]!="N" && $arResult["FIELDS"]["PREVIEW_TEXT"]):?>
            <p><?=$arResult["FIELDS"]["PREVIEW_TEXT"];unset($arResult["FIELDS"]["PREVIEW_TEXT"]);?></p>
        <?endif;?>
        <?if($arResult["NAV_RESULT"]):?>
            <?if($arParams["DISPLAY_TOP_PAGER"]):?><?=$arResult["NAV_STRING"]?><br /><?endif;?>
            <?echo $arResult["NAV_TEXT"];?>
            <?if($arParams["DISPLAY_BOTTOM_PAGER"]):?><br /><?=$arResult["NAV_STRING"]?><?endif;?>
        <?elseif(strlen($arResult["DETAIL_TEXT"])>0):?>
            <?echo $arResult["DETAIL_TEXT"];?>
        <?else:?>
            <?echo $arResult["PREVIEW_TEXT"];?>
        <?endif?>
        <div style="clear:both"></div>
        <br />
        <?foreach($arResult["FIELDS"] as $code=>$value):
            if ('PREVIEW_PICTURE' == $code || 'DETAIL_PICTURE' == $code)
            {
                ?><?=GetMessage("IBLOCK_FIELD_".$code)?>:&nbsp;<?
                if (!empty($value) && is_array($value))
                {
                    ?><img border="0" src="<?=$value["SRC"]?>" width="<?=$value["WIDTH"]?>" height="<?=$value["HEIGHT"]?>"><?
                }
            }
            else
            {
                ?><?=GetMessage("IBLOCK_FIELD_".$code)?>:&nbsp;<?=$value;?><?
            }
            ?><br />
        <?endforeach;?>
            <?
            if(!empty($arResult["PROPERTIES"]["FILE"]["VALUE"])){
            $doc_count = count($arResult["DISPLAY_PROPERTIES"]["FILE"]["VALUE"]);
            $arFiles = $arResult["DISPLAY_PROPERTIES"]["FILE"]["FILE_VALUE"];
            if($doc_count > 1):?>
                <?foreach ($arFiles as $key => $file){?>
                    <?=$key+1?>. 
                    <p class="view"><a class="view_popup_doc" title="<?=$arItem["NAME"]?>" href="<?=SITE_DIR?>local/viewdoc.php?link=<?=$file["LINK"]?>" ><i class="ion ion-ios-eye-outline margin-r-5" aria-hidden="true"></i><?=GetMessage('CT_BNL_ELEMENT_FILE_VIEW')?></a></p>
                    <p class="files"><a href="<?=$file["SRC"]?>" target="_blank"><i class="<?=$file["ICON"]?> margin-r-5" aria-hidden="true"></i><?=GetMessage('CT_BNL_ELEMENT_FILE_DOWNLOAD')?></a><span class="margin-l-5"><?=$file["FORMAT_SIZE"]?></span></p>
                    <br />
                <?}?>
            <?else:?>
                <p class="view"><a class="view_popup_doc"  title="<?=$arItem["NAME"]?>" href="<?=SITE_DIR?>local/viewdoc.php?link=<?=$arFiles["LINK"]?>" ><i class="ion ion-ios-eye-outline margin-r-5" aria-hidden="true"></i><?=GetMessage('CT_BNL_ELEMENT_FILE_VIEW')?></a></p>
                <p class="files"><a href="<?=$arFiles["SRC"]?>" target="_blank"><i class="<?=$arFiles["ICON"]?> margin-r-5" aria-hidden="true"></i><?=GetMessage('CT_BNL_ELEMENT_FILE_DOWNLOAD')?></a><span class="margin-l-5"><?=$arFiles["FORMAT_SIZE"]?></span></p>
            <?endif;
            }?>
    </div>                 
</div>
