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
if (!empty($arResult)):
?><ul class="footer-menu"><?
$previousLevel = 0;
foreach($arResult as $arItem):
	if ($previousLevel && $arItem["DEPTH_LEVEL"] < $previousLevel):
		echo str_repeat("</ul></li>", ($previousLevel - $arItem["DEPTH_LEVEL"]));
	endif;
	if ($arItem["IS_PARENT"]):?>
		<?if ($arItem["DEPTH_LEVEL"] == 1):
			?><li class="footer-menu__item<?if($arItem["SELECTED"]):?> footer-menu__item--active<?endif?><?if ($arItem["PARAMS"]["VISIBLE_BOTTOM"]):?> <?=$arItem["PARAMS"]["VISIBLE_BOTTOM"]?><?endif?>"><?
                ?><a href="<?=$arItem["LINK"]?>"><?
                    ?><?=$arItem["TEXT"]?><?
                ?></a><?
				?><ul><?
		else:
			?><li<?if ($arItem["SELECTED"]):?> class="nav-item footer-menu__item--active"<?endif?>><a href="<?=$arItem["LINK"]?>"><?=$arItem["TEXT"]?></a><?
				?><ul><?
		endif;
	else:
        if ($arItem["DEPTH_LEVEL"] == 1):
            ?><li class="footer-menu__item <?if ($arItem["SELECTED"]):?> footer-menu__item--active<?endif?><?if ($arItem["PARAMS"]["VISIBLE_BOTTOM"]):?> <?=$arItem["PARAMS"]["VISIBLE_BOTTOM"]?><?endif?>"><a href="<?=$arItem["LINK"]?>"><?=$arItem["TEXT"]?></a></li> <?
        else:
            ?><li<?if ($arItem["SELECTED"]):?> class="footer-menu__item footer-menu__item--active"<?endif?>><a href="<?=$arItem["LINK"]?>"><?=$arItem["TEXT"]?></a></li> <?
        endif;
	endif;
    $previousLevel = $arItem["DEPTH_LEVEL"];
endforeach;
if ($previousLevel > 1):
	echo str_repeat("</ul></li>", ($previousLevel-1));
endif;
?></ul><?
endif;?>
