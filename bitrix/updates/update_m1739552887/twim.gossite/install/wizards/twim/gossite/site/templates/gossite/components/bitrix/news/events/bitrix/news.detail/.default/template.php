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
<div class="news-detail">
    <?if($arParams["DISPLAY_DATE"]!="N" && $arResult["DISPLAY_ACTIVE_FROM"]):?>
		<p class="date"><?=$arResult["DISPLAY_ACTIVE_FROM"]?></p>
	<?endif;?>
    <?if($arParams["DISPLAY_PICTURE"]!="N" && is_array($arResult["DETAIL_PICTURE"])):?>
		<div class="wrap-img">
            <img
                class="img-responsive"
                src="<?=$arResult["DETAIL_PICTURE"]["SRC"]?>"
                alt="<?=$arResult["DETAIL_PICTURE"]["ALT"]?>"
                title="<?=$arResult["DETAIL_PICTURE"]["TITLE"]?>"
                />
        </div>
	<?endif?>
    <div class="text">
        <?if($arResult["NAV_RESULT"]):?>
            <?if($arParams["DISPLAY_TOP_PAGER"]):?><?=$arResult["NAV_STRING"]?><br /><?endif;?>
            <?echo $arResult["NAV_TEXT"];?>
            <?if($arParams["DISPLAY_BOTTOM_PAGER"]):?><br /><?=$arResult["NAV_STRING"]?><?endif;?>
        <?elseif(strlen($arResult["DETAIL_TEXT"])>0):?>
            <?echo $arResult["DETAIL_TEXT"];?>
        <?else:?>
            <?echo $arResult["PREVIEW_TEXT"];?>
        <?endif;?>
        <br />
        
        <?if(!empty($arResult["DISPLAY_PROPERTIES"]["MORE_PHOTOS"])):?>
            <h3><?=getMessage("TITLE_PHOTO");?></h3>
            <div class="chocolat-gallery row" data-chocolat-title="<?=$arResult["NAME"]?>">
                <?foreach($arResult["DISPLAY_PROPERTIES"]["MORE_PHOTOS"]["DISPLAY_VALUE_SRC"] as $key => $arPic):?>
                    <div class="col-xs-6 col-sm-4 col-md-3">
                        <a class="chocolat-image" href="<?=$arPic["LARGE"]["src"]?>" title="<?=$arResult["NAME"]?>">
                            <img class="img-responsive" src="<?=$arPic["TRUMB"]["src"]?>" alt="<?=$arResult["NAME"]?>" />
                        </a>
                    </div>
                <?endforeach;?>
            </div>
        <?endif;?>
            
         <?if(!empty($arResult["DISPLAY_PROPERTIES"]["LINK_VIDEO"])):?>
            <h3><?=getMessage("TITLE_VIDEO");?></h3>
            <div class="row">
                <?foreach($arResult["DISPLAY_PROPERTIES"]["LINK_VIDEO"]["VALUE"] as $linkVideo):
                    parse_str( parse_url( $linkVideo, PHP_URL_QUERY ), $array_youtube);
                    ?>
                    <div class="col-md-6">
                        <div class="embed-responsive embed-responsive-4by3">
                             <iframe class="embed-responsive-item" src="https://www.youtube.com/embed/<?=$array_youtube['v']?>" frameborder="0" allowfullscreen></iframe>
                        </div>
                    </div>
                <?endforeach;?>
           </div>
           <br />
       <?endif;?>
        
        <?foreach($arResult["FIELDS"] as $code=>$value):
            if ('PREVIEW_PICTURE' == $code || 'DETAIL_PICTURE' == $code)
            {
                continue;
                ?><?=GetMessage("IBLOCK_FIELD_".$code)?>:&nbsp;<?
                if (!empty($value) && is_array($value))
                {
                    ?><img border="0" src="<?=$value["SRC"]?>" width="<?=$value["WIDTH"]?>" height="<?=$value["HEIGHT"]?>"><?
                }
            }
            else
            {
                ?><?=GetMessage("IBLOCK_FIELD_".$code)?>:&nbsp;<?=$value;?><?
            }?><br />
        <?endforeach;
        foreach($arResult["DISPLAY_PROPERTIES"] as $pid=>$arProperty):
            if($pid == "MORE_PHOTOS") continue;
            if($pid == "LINK_VIDEO") continue;
            ?>
            <?=$arProperty["NAME"]?>:&nbsp;
            <?if(is_array($arProperty["DISPLAY_VALUE"])):?>
                <?=implode("&nbsp;/&nbsp;", $arProperty["DISPLAY_VALUE"]);?>
            <?else:?>
                <?=$arProperty["DISPLAY_VALUE"];?>
            <?endif?>
            <br />
        <?endforeach;?>
            
    </div>
</div>
<!--news-detail-->  
<?if(array_key_exists("USE_SHARE", $arParams) && $arParams["USE_SHARE"] == "Y")
{?>
    <div class="row nav-news-detail">
        <div class="col-sm-12 text-right">
            <div class="social-likes">
                <div class="facebook" title="Поделиться ссылкой на Фейсбуке"><span class="sr-only">Facebook</span><i class="fa fa-facebook" aria-hidden="true"></i></div>
                <div class="twitter" title="Поделиться ссылкой в Твиттере"><span class="sr-only">Twitter</span><i class="fa fa-twitter" aria-hidden="true"></i></div>
                <div class="vkontakte" title="Поделиться ссылкой во Вконтакте"><span class="sr-only">Вконтакте</span><i class="fa fa-vk" aria-hidden="true"></i></div>
                <div class="plusone" title="Поделиться ссылкой в Гугл-плюсе"><span class="sr-only">Google+</span><i class="fa fa-google-plus" aria-hidden="true"></i></div>
            </div>
        </div>
    </div>
<?
}
?>
