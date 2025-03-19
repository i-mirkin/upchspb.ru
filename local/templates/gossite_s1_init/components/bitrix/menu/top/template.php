<?if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>

<?if (!empty($arResult)):?>
<ul class="nav nav-top">
    <?
    foreach($arResult as $arItem):
        if($arParams["MAX_LEVEL"] == 1 && $arItem["DEPTH_LEVEL"] > 1) 
            continue;
    ?>
        <?if($arItem["SELECTED"]):?>
            <li  role="presentation" class="active"><a href="<?=$arItem["LINK"]?>"  tabindex="1"><?=$arItem["TEXT"]?></a></li>
        <?else:?>
            <li  role="presentation"><a href="<?=$arItem["LINK"]?>" tabindex="1"><?=$arItem["TEXT"]?></a></li>
        <?endif?>

    <?endforeach?>
</ul>
<!--nav-top-->
<?endif?>
                                    
