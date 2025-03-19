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
<div class="news-detail <?=($arResult['LIST_PAGE_URL']=="/reports/")?'news-detail--report':''?>" <?if('Y' == $arResult['PROPERTIES']['ADMIN_ONLY']['VALUE']){?>data-admin-only="Y"<?}?>> 
    <?if($arParams["DISPLAY_DATE"]!="N" && $arResult["DISPLAY_ACTIVE_FROM"]):?>
		<p class="date"><?=$arResult["DISPLAY_ACTIVE_FROM"]?></p>
	<?endif;?>
		<?if(!empty($arResult["DISPLAY_PROPERTIES"]["MORE_PHOTOS"])):?>
		<div class="detail-slider">
			<div class="detail-slider-for">
			<?foreach($arResult["DISPLAY_PROPERTIES"]["MORE_PHOTOS"]["DISPLAY_VALUE_SRC"] as $key => $arPic):?>
				<div class="detail-slider-for__item">
					<a href="<?=$arPic["LARGE"]["src"]?>"  class="fancybox fancybox-img" data-fancybox-group="product_image">
						<img class="" alt="<?=$arResult["NAME"]?>" title="<?=$arResult["NAME"]?>" src="<?=$arPic["LARGE"]["src"]?>"  data-src="" />
					</a>
                    <?if($arPic["DESCRIPTION"]) { ?>
                        <p><?=$arPic["DESCRIPTION"]?></p> 
                    <? } ?>
				</div>
			<?endforeach;?>
			</div>
			<div class="detail-slider-nav">
				<?foreach($arResult["DISPLAY_PROPERTIES"]["MORE_PHOTOS"]["DISPLAY_VALUE_SRC"] as $key => $arPic):?>
				<div class="detail-slider-nav__item">
					<div class="detail-slider-nav__item-img">
						<img class="" alt="<?=$arResult["NAME"]?>" title="<?=$arResult["NAME"]?>" src="<?=$arPic["TRUMB"]["src"]?>" />
					</div>
				</div>
				<?endforeach;?>
			</div>
		</div>
	<?endif;?>
    <?if($arParams["DISPLAY_PICTURE"]!="N" && is_array($arResult["DETAIL_PICTURE"])):?>
		<? $file = CFile::ResizeImageGet($arResult["DETAIL_PICTURE"], array('width'=>640, 'height'=>350), BX_RESIZE_IMAGE_PROPORTIONAL, true, false, false, 70); ?>
		<div class="wrap-img">
            <img
                class="img-responsive"
                src="<?=$file['src']?>"
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
            if($pid == "FOOTNOTES") continue;
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
<? if ($arResult['LIST_PAGE_URL']=="/reports/") :?>
<span class="news-detail-more btn btn-info">Подробнее</span>
<? endif; ?>
<?if($arResult['FOOTNOTES']) { ?>
<script>
$(document).ready(function(){
	var notes = <?=CUtil::PhpToJSObject($arResult['FOOTNOTES'])?>;
	$.each(notes, function(k,v){		
		$('.atooltip[data-id=' + k + ']').attr('title', v);		
	});
	$('.atooltip').tooltipster({
		trigger: 'click',
		maxWidth: 300
	});
});
</script>
<? } ?>


<!--news-detail-->  

    <div class="row nav-news-detail">
        <div class="col-sm-4"><a href="#" onclick="window.print()"><?=GetMessage('PRINT_VER')?></a></div>
        <?if(array_key_exists("USE_SHARE", $arParams) && $arParams["USE_SHARE"] == "Y") {?>
        <div class="col-sm-8 text-right">
            <div class="social-likes">
                <?/*<div class="facebook" title="Поделиться ссылкой на Фейсбуке"><span class="sr-only">Facebook</span><i class="fa fa-facebook" aria-hidden="true"></i></div>*/?>
                <?/*<div class="twitter" title="Поделиться ссылкой в Твиттере"><span class="sr-only">Twitter</span><i class="fa fa-twitter" aria-hidden="true"></i></div>*/?>
                <div class="vkontakte" title="Поделиться ссылкой во Вконтакте"><span class="sr-only">Вконтакте</span><i class="fa fa-vk" aria-hidden="true"></i></div>
                <?/*<div class="plusone" title="Поделиться ссылкой в Гугл-плюсе"><span class="sr-only">Google+</span><i class="fa fa-google-plus" aria-hidden="true"></i></div>*/?>
				<div class="odnoklassniki" title="Поделиться ссылкой в OK.RU"><span class="sr-only">OK.RU</span><i class="fa fa-odnoklassniki" aria-hidden="true"></i></div>
				<div class="mailru" title="Поделиться ссылкой в MAIL.RU"><span class="sr-only">MAIL.RU</span><i class="fa fa-envelope-o" aria-hidden="true"></i></div>
				<a href="https://www.livejournal.com/post" target="_blank" data-lj-siteroot="https://www.livejournal.com" data-lj-type="share-counter" data-lj-ml='{"counter.noShares":"0"}' style="position: relative !important;display: inline-block !important;height: 38px !important;overflow: hidden !important;padding: 0 !important;box-sizing: border-box !important;background: #15374C !important;border-radius: 5px !important;box-shadow: none !important;vertical-align: middle !important;text-shadow: none !important;text-align: center !important;text-decoration: none !important;text-transform: none !important;letter-spacing: normal !important;line-height: 38px !important;font-weight: bold !important;font-style: normal !important;font-size: 13px !important;font-family: Arial, sans-serif !important;color: #FFF !important;width: 40px !important" > <svg style="position: absolute !important;top: 0 !important;bottom: 0 !important;left: 0 !important;margin: 3px !important;right: 0 !important" viewBox="0 0 22 22.024" width="40" height="38"><path fill="#2690CF" d="M11.698 1.416c-1.455 0-2.837.302-4.09.845L5.344 0H5.34A10.34 10.34 0 0 0 0 5.37l2.268 2.263-.004.002a10.19 10.19 0 0 0-.87 4.084c0 5.69 4.612 10.303 10.304 10.303 5.69 0 10.302-4.61 10.302-10.303 0-5.69-4.61-10.304-10.302-10.304"></path><path fill="#013040" d="M10.646 16a10.353 10.353 0 0 1 5.34-5.368L7.608 2.265H7.6a10.343 10.343 0 0 0-5.337 5.372L10.645 16zm5.938-2.51a6.016 6.016 0 0 0-3.1 3.116l3.913.812-.813-3.93z"></path><path fill="#FFF" d="M16.584 13.49c-.31-1.502-.597-2.86-.597-2.86h-.004A10.348 10.348 0 0 0 10.646 16l2.837.606a6.074 6.074 0 0 1 3.1-3.117"></path></svg> </a>
                <?php
                $telegramLink = "https://telegram.me/share/url?url=".$_SERVER["REQUEST_SCHEME"]."://".$_SERVER["HTTP_HOST"]."".$_SERVER["REQUEST_URI"]."&text=".$arResult["PREVIEW_TEXT"]."";
                ?>
                
                <div class="social-likes__widget social-likes__widget_tg" title="Поделиться в telegram">
                	<a class="social-likes__button social-likes__button_tg btn_telegram_share" target="_blank" href="<?= $telegramLink;?>"></a>
                </div>
            </div>
			<script>(function(d, s, id) { var js, ljjs = d.getElementsByTagName(s)[0]; if (d.getElementById(id)) return; js = d.createElement(s); js.id = id; js.src = 'https://www.livejournal.com/js/??sdk.js?v=0.1'; ljjs.parentNode.insertBefore(js, ljjs); }(document, 'script', 'livejournal-jssdk'));</script> 
        </div>
        <?}?>
    </div>
<?php $templateData['META_DESC'] = $arResult["PREVIEW_TEXT"];?>