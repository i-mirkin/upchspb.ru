<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
$arOptionGosSite = $arParams["OPTION_SITE"];?>
<div class="wrap-main-contacts">
    <?if(!empty($arOptionGosSite["api_map_key_ya"]) && !empty($arOptionGosSite["coord_ya"])):?>
        <?$APPLICATION->IncludeComponent(
            "twim:system.empty", 
            "ya_map", 
            array(
                "CACHE_TIME" => "360000",
                "CACHE_TYPE" => "A",
                "PARAM1" => "",
                "PARAM2" => "1",
                "COMPONENT_TEMPLATE" => "ya_map",
                "TITLE" => "",
            ),
            false,
			array(
			"HIDE_ICONS" => "Y"
			)
        );?>
    <?endif;?> 
    <div class="main-contacts">
        <div class="wrap-text">
            <h5><?
                $APPLICATION->IncludeFile(
                    SITE_DIR."include/title-site.php",
                    Array(),
                    Array("MODE"=>"text", "SHOW_BORDER" => false)
                );
                ?>
            </h5>
            <br />
            <?if(!empty($arOptionGosSite["post_boss"])):?>
            <p><small><?=$arOptionGosSite["post_boss"]?></small></p>
            <?endif;?>
            <?if(!empty($arOptionGosSite["fio_boss"])):?>
            <p><?=$arOptionGosSite["fio_boss"]?></p>
            <br />
            <?endif;?>
            <p><small>Контактная информация</small></p>
            <address>
                <?if(!empty($arOptionGosSite["address"])):?>
                <?=$arOptionGosSite["address"]?><br />
                <?endif;?>
                <?if(!empty($arOptionGosSite["phone"])):?>
                <?=$arOptionGosSite["phone"]?><br />
                <?endif;?>
                <?=$arOptionGosSite["email"]?>
            </address>
        </div>
    </div>
</div> 
