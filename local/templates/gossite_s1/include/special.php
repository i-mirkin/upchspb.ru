<?php
if(!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true)
	die();
use Bitrix\Main\Localization\Loc;
Loc::loadMessages(__FILE__);
/* 
 * special panel
 */
$special_param = json_decode(filter_input(INPUT_COOKIE, 'special_param'), true);
?>

<div class="special-panel hidden hidden-print">
    <div class="wrap-control clearfix">
        <div class="control font-size">
            <span><?=Loc::getMessage("SPECIAL_FONT_SIZE")?>:</span>
            <button class="normal<?if(empty($special_param["fz"])) echo " active"?>" data-font-size=""><em>A</em></button>
            <button class="medium<?if($special_param["fz"] === "fz-medium") echo " active"?>" data-font-size="fz-medium"><em>A</em></button>
            <button class="large<?if($special_param["fz"] === "fz-large") echo " active"?>" data-font-size="fz-large"><em>A</em></button>
        </div>
        <div class="control font-family">
            <span><?=Loc::getMessage("SPECIAL_FONT_FAMILY")?>:</span>
            <button class="san-serif<?if(empty($special_param["ff"])) echo " active"?>" data-font-family="">Arial</button>
            <button class="serif<?if($special_param["ff"] === "ff-serif") echo " active"?>" data-font-family="ff-serif">Times New Roman</button>
        </div>
        <div class="control color">
            <span><?=Loc::getMessage("SPECIAL_THEME")?>:</span>
            <button data-color="tm-white" class="white<?if($special_param["theme"] === "tm-white") echo " active"?>"><?=Loc::getMessage("SPECIAL_THEME_SIMBOL")?></button>
            <button data-color="tm-black" class="black<?if($special_param["theme"] === "tm-black") echo " active"?>"><?=Loc::getMessage("SPECIAL_THEME_SIMBOL")?></button>
            <button data-color="tm-blue" class="blue<?if($special_param["theme"] === "tm-blue") echo " active"?>"><?=Loc::getMessage("SPECIAL_THEME_SIMBOL")?></button>
            <button data-color="tm-brown" class="brown<?if($special_param["theme"] === "tm-brown") echo " active"?>"><?=Loc::getMessage("SPECIAL_THEME_SIMBOL")?></button>
        </div>
        <div class="control img-show">
            <span><?=Loc::getMessage("SPECIAL_IMAGE")?>:</span>
			<button class="img-show-button" data-image="Y">
					<?if($special_param["image"] === "Y"):?>
						<i class="fa fa-check-square-o" aria-hidden="true"></i>
					<?else:?>
						<i class="fa fa-square-o" aria-hidden="true"></i>
					<?endif;?>
			</button>
        </div>
        <div class="control wrap-full-link">
            <button class="normal-version"><i class="fa fa-eye-slash margin-r-5" aria-hidden="true"></i><?=Loc::getMessage("SPECIAL_NORMAL_VERSION")?></button>
        </div>
        <div class="control settings">
            <button id="link_settings"><i class="fa fa-cogs" aria-hidden="true"></i> <?=Loc::getMessage("SPECIAL_SETTINGS")?></button>
        </div>
        <div class="settings-panel">
            <div class="wrap">
                <div class="char-interval">
                    <span><?=Loc::getMessage("SPECIAL_LETTER_SPACING")?>:</span> 
                    <button data-interval="" class="normal<?if(empty($special_param["ls"])) echo " active"?>"><?=Loc::getMessage("SPECIAL_LETTER_SPACING_NORMAL")?></button> 
                    <button data-interval="interval-medium" class="medium<?if($special_param["ls"] === "interval-medium") echo " active"?>"><?=Loc::getMessage("SPECIAL_LETTER_SPACING_MEDIUM")?></button> 
                    <button data-interval="interval-large" class="large<?if($special_param["ls"] === "interval-largee") echo " active"?>"><?=Loc::getMessage("SPECIAL_LETTER_SPACING_LARGE")?></button>
                </div>
                <div class="font-family">
                    <span><?=Loc::getMessage("SPECIAL_SET_FONT_FAMILY")?>:</span>
                    <button class="san-serif<?if(empty($special_param["ff"])) echo " active"?>" data-font-family="">Arial</button>
                    <button class="serif<?if($special_param["ff"] === "ff-serif") echo " active"?>" data-font-family="ff-serif">Times New Roman</button>
                </div>
                <div class="color">
                    <span><?=Loc::getMessage("SPECIAL_SET_THEME")?>:</span>
                    <button data-color="tm-white" class="white<?if($special_param["theme"] === "tm-white") echo " active"?>"><?=Loc::getMessage("SPECIAL_THEME_BW")?></button>
                    <button data-color="tm-black" class="black<?if($special_param["theme"] === "tm-black") echo " active"?>"><?=Loc::getMessage("SPECIAL_THEME_WB")?></button>
                    <button data-color="tm-blue" class="blue<?if($special_param["theme"] === "tm-blue") echo " active"?>"><?=Loc::getMessage("SPECIAL_THEME_BDB")?></button>
                    <button data-color="tm-brown" class="brown<?if($special_param["theme"] === "tm-brown") echo " active"?>"><?=Loc::getMessage("SPECIAL_THEME_BB")?></button>
                </div>
            </div>
        </div>
    </div>		
</div>
<!-- special-panel -->