<?if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>

<?if (!empty($arResult)):?>
<ul class="nav nav-soc">
    <?
    foreach($arResult as $arItem):
        if($arParams["MAX_LEVEL"] == 1 && $arItem["DEPTH_LEVEL"] > 1) 
            continue;
    ?>
     <li role="presentation"><a href="<?=$arItem["LINK"]?>" target="_blank" title="<?=$arItem["TEXT"]?>" ><i class="<?=$arItem["PARAMS"]["ICON"]?>" aria-hidden="true"></i><span class="sr-only"><?=$arItem["TEXT"]?></span></a></li>

    <?endforeach?>
</ul>
<!--nav-soc-->
<?endif?>

