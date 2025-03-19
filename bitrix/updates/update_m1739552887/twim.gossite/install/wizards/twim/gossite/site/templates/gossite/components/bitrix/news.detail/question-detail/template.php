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
<div class="question-list">
    <div class="question-item">
        <div class="wrap-icon">
            <i class="icom icon-question"></i>
        </div>
        <div class="wrap-question">
            <?if($arParams["DISPLAY_NAME"]!="N" && $arResult["NAME"]):?>
                    <b><?echo $arResult["NAME"]?></b><br />
            <?endif;?>
            <div class="auhtor">
                <i class="fa fa-user" aria-hidden="true"></i> 
                <?=$arResult["DISPLAY_PROPERTIES"]["USER"]["DISPLAY_VALUE"]?> 
                <span class="date-time"><?echo mb_strtolower($arResult["DATE_CREATE"], LANG_CHARSET)?></span>
            </div>
            <div class="wrap-answer">
                <div class="question-inner">
                    <i class="icom icon-answer"></i>
                    <div class="answer">
                        <?=$arResult["DISPLAY_PROPERTIES"]["otvet"]["DISPLAY_VALUE"]?>
                         <div class="auhtor">
                            <i class="fa fa-user" aria-hidden="true"></i> <?=$arResult["DISPLAY_PROPERTIES"]["AUHTOR_ANSWER"]["DISPLAY_VALUE"]?> <span class="date-time"><?echo mb_strtolower($arResult["TIMESTAMP_X"], LANG_CHARSET)?></span>
                         </div>
                    </div>
                </div>    
            </div>
        </div>
    </div>
</div>