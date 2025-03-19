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
	<div class="main-contacts-map">
    <script type="text/javascript" data-skip-moving="true" charset="utf-8" async src="https://api-maps.yandex.ru/services/constructor/1.0/js/?um=constructor%3A5c5c0d7099c8a9c47f3e61386a5c20dc6cc2407652ddb9aa776bcb8699b227a8&amp;width=100%25&amp;height=300&amp;lang=en_US&amp;scroll=true"></script>
	</div>
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
            <p><small>Contact information</small></p>
            <address>
                <?if(!empty($arOptionGosSite["address"])):?>
                <?=$arOptionGosSite["address"]?><br />
                <?endif;?>
                <?if(!empty($arOptionGosSite["phone"])):?>
                <?=$arOptionGosSite["phone"]?><br />
                <?endif;?>
                <?=$arOptionGosSite["email"]?>
            </address>
			<?$APPLICATION->IncludeComponent(
				"bitrix:main.include",
				"",
				Array(
					"AREA_FILE_RECURSIVE" => "Y",
					"AREA_FILE_SHOW" => "sect",
					"AREA_FILE_SUFFIX" => "inc",
					"EDIT_TEMPLATE" => "standard.php"
				)
			);?>
        </div>
    </div>
</div> 
