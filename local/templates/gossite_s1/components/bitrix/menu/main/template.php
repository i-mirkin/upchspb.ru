<?if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
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
if (!empty($arResult)):?>
<ul class="header-menu"><?
$previousLevel = 0;
foreach($arResult as $arItem):
	if ($previousLevel && $arItem["DEPTH_LEVEL"] < $previousLevel):
		echo str_repeat("</ul></li>", ($previousLevel - $arItem["DEPTH_LEVEL"]));
	endif;
	if ($arItem["IS_PARENT"]):
        if ($arItem["DEPTH_LEVEL"] == 1):
			?><li class="header-menu__item header-menu__item--parent <?if ($arItem["SELECTED"]):?> active<?endif?><?if ($arItem["PARAMS"]["VISIBLE"]):?> <?=$arItem["PARAMS"]["VISIBLE"]?><?endif?>"><?
                ?><a href="<?=$arItem["LINK"]?>" class="header-menu__item-title"><?=$arItem["TEXT"]?></a><?
				?><ul class="header-menu__lvl2"><?
		else:
			?><li class="header-menu__lvl2-item header-menu__item--parent <?if ($arItem["SELECTED"]):?> header-menu__lvl2-item--active<?endif?>"><a href="<?=$arItem["LINK"]?>"><?=$arItem["TEXT"]?></a><?
				?><ul class="header-menu__lvl2"><?
		endif;
	else:
        if ($arItem["DEPTH_LEVEL"] == 1):
            ?><li class="header-menu__item <?if ($arItem["SELECTED"]):?> active<?endif?><?if ($arItem["PARAMS"]["VISIBLE"]):?> <?=$arItem["PARAMS"]["VISIBLE"]?><?endif?>"><a href="<?=$arItem["LINK"]?>" class="header-menu__item-title"><?=$arItem["TEXT"]?></a></li><?
        else:
            ?><li class="header-menu__lvl2-item <?if ($arItem["SELECTED"]):?>header-menu__lvl2-item--active<?endif?>"><a href="<?=$arItem["LINK"]?>"><?=$arItem["TEXT"]?></a></li><?
        endif;
    endif;
	$previousLevel = $arItem["DEPTH_LEVEL"];
endforeach;
if ($previousLevel > 1):
	echo str_repeat("</ul></li>", ($previousLevel-1) );
endif;
?></ul><?
endif?>
