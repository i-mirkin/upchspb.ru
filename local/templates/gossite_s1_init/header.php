<?
if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) {
    die();
}
use Bitrix\Main\Page\Asset, 
    Bitrix\Main\Context, 
    Bitrix\Main\Localization\Loc,
    Bitrix\Main\Config\Option,
    Bitrix\Main\Loader,
    Bitrix\Main\SiteTable;
Loc::loadMessages(__FILE__);

$Asset = Asset::getInstance();
$request = Context::getCurrent()->getRequest(); 
global $USER;

//gossite option
$jsOption = array(); // global option js
$arOptionGosSite = array();

//config theme
require_once('themes/config.php');
if($themeConfig['demo'] === 'Y' && !empty($_SESSION["DEMO_CONFIG_THEME"])){
    $themeConfig = $_SESSION["DEMO_CONFIG_THEME"];   
}
if($themeConfig['demo'] === 'Y' && !empty($_SESSION["DEMO_STYLE_THEME"])){
    $style = gzdecode($_SESSION["DEMO_STYLE_THEME"]);
    $Asset->addString('<style id="custom_style" type="text/css">' . $style . '</style>');
} elseif($themeConfig['theme_color'] === 'default'){
    $Asset->addCss(SITE_TEMPLATE_PATH . "/build/style.min.css");
} else {
    $Asset->addCss(SITE_TEMPLATE_PATH . "/build/theme.min.css");
}
$jsOption["ya_map_iconColor"] = $themeConfig['color']["dark"];

//set option site
if(Loader::includeModule("twim.gossite")){
    $arOptionGosSite =  Option::getForModule("twim.gossite", SITE_ID);
    if(!empty($arOptionGosSite["api_map_key_ya"])){
        $jsOption["api_map_key_ya"] = $arOptionGosSite["api_map_key_ya"]; // yandex api key map js   
    }
    if(!empty($arOptionGosSite["coord_ya"])){
        $jsOption["coord_ya"] = $arOptionGosSite["coord_ya"]; // yandex coord
    }
    $jsOption["type_voice"] = $arOptionGosSite["type_voice"]; // yandex api key global option js
    if($jsOption["type_voice"] == "ya"){
        $jsOption["speechkit_apikey"] = $arOptionGosSite["api_voice_key_ya"]; // yandex api key global option js
        $Asset->addJs('https://webasr.yandex.net/jsapi/v1/webspeechkit.js');
    } elseif($jsOption["type_voice"] == "rv"){
        $Asset->addJs('https://code.responsivevoice.org/responsivevoice.js');
    }
}

//add js, css, string in head
$Asset->addString('<meta http-equiv="X-UA-Compatible" content="IE=edge" />');
$Asset->addString('<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1" />');
$Asset->addJs(SITE_TEMPLATE_PATH . "/build/script.min.js");
$Asset->addJs(SITE_TEMPLATE_PATH . "/build/init.min.js");
$Asset->addCss(SITE_TEMPLATE_PATH . "/css/slick-theme.css");
$Asset::getInstance()->addString('<script type="text/javascript">var jsOption = '. json_encode($jsOption). '</script>'); 
if ($USER->IsAdmin() || $themeConfig['demo'] === 'Y') {
    $Asset->addJs(SITE_TEMPLATE_PATH . "/build/control.min.js");
}
// is ajax
$isAjax = isset($_SERVER['HTTP_X_REQUESTED_WITH']) && !empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest' && isset($_REQUEST['AJAX_PAGE']) && 'Y' == $_REQUEST['AJAX_PAGE'];

// current page
$requestPage = $request->getRequestedPage(); 

// is main page
$IS_MAIN = 'N';
if ($requestPage  === SITE_DIR.'index.php') {$IS_MAIN = 'Y';}

// name site
$arSire = SiteTable::GetByID(SITE_ID)->Fetch();

//class body
$class_body = '';
// boxed theme
if($themeConfig['layout'] !== 'wide'){
    $class_body = $themeConfig['layout'] . ' ';
}
//init special
$special_param = json_decode(filter_input(INPUT_COOKIE, 'special_param'), true);
if($special_param["special"] == "Y"){
    $class_body .= "special ";    
    $class_body .= ($special_param["image"] == "N") ? "hide-image ": "";
    $class_body .= (!empty($special_param["theme"])) ? $special_param["theme"] . " ": "";
    $class_body .= (!empty($special_param["fz"])) ? $special_param["fz"] . " ": "";
    $class_body .= (!empty($special_param["ls"])) ? $special_param["ls"] . " ": "";
    $class_body .= (!empty($special_param["ff"])) ? $special_param["ff"] : ""; 
}
$class_body = trim($class_body);
?>
<!DOCTYPE html>
<html lang="<?=LANGUAGE_ID?>">
<head>
    <link rel="apple-touch-icon-precomposed" sizes="57x57" href="<?=SITE_TEMPLATE_PATH?>/favicon/apple-touch-icon-57x57.png" />
    <link rel="apple-touch-icon-precomposed" sizes="114x114" href="<?=SITE_TEMPLATE_PATH?>/favicon/apple-touch-icon-114x114.png" />
    <link rel="apple-touch-icon-precomposed" sizes="72x72" href="<?=SITE_TEMPLATE_PATH?>/favicon/apple-touch-icon-72x72.png" />
    <link rel="apple-touch-icon-precomposed" sizes="144x144" href="<?=SITE_TEMPLATE_PATH?>/favicon/apple-touch-icon-144x144.png" />
    <link rel="apple-touch-icon-precomposed" sizes="120x120" href="<?=SITE_TEMPLATE_PATH?>/favicon/apple-touch-icon-120x120.png" />
    <link rel="apple-touch-icon-precomposed" sizes="152x152" href="<?=SITE_TEMPLATE_PATH?>/favicon/apple-touch-icon-152x152.png" />
    <link rel="icon" type="image/png" href="<?=SITE_TEMPLATE_PATH?>/favicon/favicon-32x32.png" sizes="32x32" />
    <link rel="icon" type="image/png" href="<?=SITE_TEMPLATE_PATH?>/favicon/favicon-16x16.png" sizes="16x16" />
    <link rel='shortcut icon' type='image/ico' href='<?=SITE_TEMPLATE_PATH?>/favicon/favicon.ico' />
    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
      <script src="https://cdn.jsdelivr.net/g/html5shiv@3.7.3,respond@1.4.2"></script>
    <![endif]-->
    <?php
    $APPLICATION->SetPageProperty("og:image", "/images/logo_og.png");
    $APPLICATION->ShowHead();
    $APPLICATION->ShowMeta("og:url");
    $APPLICATION->ShowMeta("og:title");
    $APPLICATION->ShowMeta("og:description");
    $APPLICATION->ShowMeta("og:image");
    ?>
    <title><?$APPLICATION->ShowTitle();?> | <?=$arSire["SITE_NAME"]?></title>
</head>
<body<?if(!empty($class_body)):?> class="<?=$class_body?>"<?endif;?>>  
<div class="wrapper">
    <a name="top"></a>
    <div id="panel">
        <?$APPLICATION->ShowPanel();?>
    </div>
    <?//special panel
    $APPLICATION->IncludeFile(
        SITE_TEMPLATE_PATH."/include/special.php",
        Array(),
        Array("MODE"=>"text")
    );?>
    <div class="wrap-search-top collapse" id="search-panel">
        <div class="wrap-form">
            <h4 class="pull-left"><?=Loc::getMessage("HEADER_SEARCH_TITLE")?></h4>
            <div class="pull-right">
                <button type="button" class="close" aria-label="Close" title="<?=Loc::getMessage("HEADER_CLOSE")?>">
                    <i class="ion ion-ios-close-empty" aria-hidden="true"></i>
                    <span class="sr-only"><?=Loc::getMessage("HEADER_CLOSE")?></span>
                </button>
            </div>
            <div class="clearfix"></div>
            <div class="ya-site-form ya-site-form_inited_no" data-bem="{&quot;action&quot;:&quot;http://ombudsman.efremov.bquadro.co.uk/search/&quot;,&quot;arrow&quot;:false,&quot;bg&quot;:&quot;transparent&quot;,&quot;fontsize&quot;:16,&quot;fg&quot;:&quot;#000000&quot;,&quot;language&quot;:&quot;ru&quot;,&quot;logo&quot;:&quot;rb&quot;,&quot;publicname&quot;:&quot;Поиск по ombudsmanspb.ru&quot;,&quot;suggest&quot;:true,&quot;target&quot;:&quot;_self&quot;,&quot;tld&quot;:&quot;ru&quot;,&quot;type&quot;:2,&quot;usebigdictionary&quot;:true,&quot;searchid&quot;:2410044,&quot;input_fg&quot;:&quot;#333333&quot;,&quot;input_bg&quot;:&quot;#ffffff&quot;,&quot;input_fontStyle&quot;:&quot;normal&quot;,&quot;input_fontWeight&quot;:&quot;normal&quot;,&quot;input_placeholder&quot;:&quot;Поиск&quot;,&quot;input_placeholderColor&quot;:&quot;#333333&quot;,&quot;input_borderColor&quot;:&quot;#118cb7&quot;}"><form action="https://yandex.ru/search/site/" method="get" target="_self" accept-charset="utf-8"><input type="hidden" name="searchid" value="2410044"/><input type="hidden" name="l10n" value="ru"/><input type="hidden" name="reqenc" value=""/><input type="search" name="text" value=""/><input type="submit" value="Найти"/></form></div><style type="text/css">.ya-page_js_yes .ya-site-form_inited_no { display: none; }</style><script type="text/javascript">(function(w,d,c){var s=d.createElement('script'),h=d.getElementsByTagName('script')[0],e=d.documentElement;if((' '+e.className+' ').indexOf(' ya-page_js_yes ')===-1){e.className+=' ya-page_js_yes';}s.type='text/javascript';s.async=true;s.charset='utf-8';s.src=(d.location.protocol==='https:'?'https:':'http:')+'//site.yandex.net/v2.0/js/all.js';h.parentNode.insertBefore(s,h);(w[c]||(w[c]=[])).push(function(){Ya.Site.Form.init()})})(window,document,'yandex_site_callbacks');</script>
        </div>
    </div>
    <div class="wrap-content">
        <div class="content">
            <header class="header">
                <div class="header-top">
                    <div class="hidden-xs hidden-print">
                        <div class="wrap-top-menu">
                            <div class="b-container">
                                <?$APPLICATION->IncludeComponent("bitrix:menu", "top", Array(
                                    "ALLOW_MULTI_SELECT" => "N",	
                                        "CHILD_MENU_TYPE" => "left",	
                                        "DELAY" => "N",	
                                        "MAX_LEVEL" => "1",	
                                        "MENU_CACHE_GET_VARS" => "",
                                        "MENU_CACHE_TIME" => "360000",	
                                        "MENU_CACHE_TYPE" => "A",
                                        "MENU_CACHE_USE_GROUPS" => "Y",	
                                        "ROOT_MENU_TYPE" => "top",	
                                        "USE_EXT" => "N",	
                                        "COMPONENT_TEMPLATE" => ".default"
                                    ),
                                    false
                                );?>
                            </div>
                        </div>
                    </div>
                    <div class="wrap-header-content">
                        <div class="b-container">
                            <div class="navbar-header">
                                <button type="button" class="navbar-toggle collapsed pull-left" data-toggle="collapse" data-target="#navbar-main" aria-expanded="false">
                                    <span class="icon-bar"></span>
                                    <span class="icon-bar"></span>
                                    <span class="icon-bar"></span>
                                    <span class="sr-only"><?=Loc::getMessage("HEADER_MOBILE_MENU")?></span>
                                </button><?
                                if($themeConfig['hide_gerb'] === 'N' && $arOptionGosSite["img_gerb"]):?>
                                <div class="wrap-gerb"><?
                                    if($IS_MAIN != 'Y'):?>
                                    <a href="<?=SITE_DIR?>" title="<?=Loc::getMessage("HEADER_MAIN_PAGE")?>">
                                        <img src="<?=$arOptionGosSite["img_gerb"]?>" alt="">
                                    </a>
                                    <?else:?>
                                    <img src="<?=$arOptionGosSite["img_gerb"]?>" alt="">
                                   <?endif;?>
                                </div>
                                <?endif;?>
                                <div class="title-site hidden-xs"><?
                                $APPLICATION->IncludeFile(
                                    SITE_DIR."include/title-site.php",
                                    Array(),
                                    Array("MODE"=>"text")
                                );
                                ?></div>
                                <div class="wrap-icon-menu">
                                    <div class="contact-header hidden-xs hidden-sm">
                                    <?if($arOptionGosSite["phone"]):?>
                                        <p class="phone"><a href="callto:<?=$arOptionGosSite["phone"]?>"><i class="ion ion-ios-telephone-outline margin-r-10" aria-hidden="true"></i><?=$arOptionGosSite["phone"]?></a></p>
                                    <?endif;?>
                                    <?if($arOptionGosSite["email"]):?>
                                        <p class="mail"><a href="mailto:<?=$arOptionGosSite["email"]?>"><i class="ion ion-ios-email-outline margin-r-10" aria-hidden="true"></i><?=$arOptionGosSite["email"]?></a></p>
                                    <?endif;?>
                                    </div>
                                    <div class="icon-header hidden-print">
                                        <a role="button" title="<?=Loc::getMessage("HEADER_SEARCH_OPEN")?>" data-toggle="collapse" href="#search-panel" aria-expanded="false" aria-controls="search-panel" ><i class="ion ion-ios-search" aria-hidden="true"></i><?=Loc::getMessage("HEADER_SEARCH_OPEN")?></a>
                                        <a href="<?=SITE_DIR?>sitemap.php" class="map" title="<?=Loc::getMessage("HEADER_MAP")?>"><i class="icom icon-organization" aria-hidden="true"></i><span class="sr-only"><?=Loc::getMessage("HEADER_MAP")?></span></a>
                                        <a href="#special" title="<?=Loc::getMessage("HEADER_TOGGLE_SPECIAL")?>" class="special"><i class="ion ion-ios-eye-outline" aria-hidden="true"></i><span class="sr-only"><?=Loc::getMessage("HEADER_TOGGLE_SPECIAL")?></span></a>
                                        <a href="#print" title="<?=Loc::getMessage("HEADER_PRINT")?>" class="print hidden-xs" onclick="window.print(); return false;"><i class="icom icon-printer" aria-hidden="true"></i><span class="sr-only"><?=Loc::getMessage("HEADER_PRINT")?></span></a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>    
                </div>
                <div class="wrap-fix-menu">
                    <div class="wrap-main-menu collapse navbar-collapse"  id="navbar-main">
                        <div class="b-container">
                            <?$APPLICATION->IncludeComponent(
                                "bitrix:menu", 
                                "main", 
                                array(
                                    "ALLOW_MULTI_SELECT" => "N",
                                    "CHILD_MENU_TYPE" => "left",
                                    "DELAY" => "N",
                                    "MAX_LEVEL" => "2",
                                    "MENU_CACHE_GET_VARS" => array(
                                    ),
                                    "MENU_CACHE_TIME" => "3600000",
                                    "MENU_CACHE_TYPE" => "A",
                                    "MENU_CACHE_USE_GROUPS" => "Y",
                                    "MENU_THEME" => "site",
                                    "ROOT_MENU_TYPE" => "main",
                                    "USE_EXT" => "Y",
                                    "COMPONENT_TEMPLATE" => "main",
                                    "ADD_CLASS" => $themeConfig['menu']
                                ),
                                false
                            );?>
                        </div>
                    </div>
                </div>  
            </header> 
            <div class="mobile-header clearfix visible-xs-block">
                <?if($themeConfig['hide_gerb'] === 'N' && $arOptionGosSite["img_gerb"]):?>
                <div class="wrap-gerb"><?
                    if($IS_MAIN != 'Y'):?>
                    <a href="<?=SITE_DIR?>" title="<?=Loc::getMessage("HEADER_MAIN_PAGE")?>">
                        <img src="<?=$arOptionGosSite["img_gerb"]?>" alt="">
                    </a>
                    <?else:?>
                    <img src="<?=$arOptionGosSite["img_gerb"]?>" alt="">
                    <?endif;?>
                </div>
                <?endif;?>
                <div class="title-site">
                     <span>
                        <?$APPLICATION->IncludeFile(
                            SITE_DIR."include/title-site.php",
                            Array(),
                            Array("MODE"=>"text")
                        );?>  
                    </span>
                </div>
            </div>
            <?if($IS_MAIN == 'Y' && $themeConfig['main_page']['slider'] === "Y"):?>
            <div class="b-container">
                <div class="wrap-owl-slider-main hidden-print hidden-xs">    
                    <?$APPLICATION->IncludeFile(
                        SITE_DIR."include/slider_main.php",
                        Array(),
                        Array("MODE"=>"text")
                    );?> 
                </div>
            </div>
            <?elseif($IS_MAIN == 'Y' && $themeConfig['main_page']['slider'] === "N"):?>
            <br>
            <?endif;?>    
            <?$APPLICATION->IncludeComponent(
                "bitrix:main.include", 
                ".default", 
                array(
                    "AREA_FILE_SHOW" => "sect",
                    "AREA_FILE_SUFFIX" => "profile_mobile",
                    "AREA_FILE_RECURSIVE" => "Y",
                    "COMPONENT_TEMPLATE" => ".default",
                    "EDIT_TEMPLATE" => ""
                ),
                false
            );?>     
        <main class="main">
            <div class="workarea">
                <div class="b-container">
                <?if($IS_MAIN == 'N'){
                    $APPLICATION->IncludeComponent("bitrix:breadcrumb", "breadcrumb_box", Array(
                        "PATH" => "",	
                            "SITE_ID" => "s1",	
                            "START_FROM" => "0",	
                        ),
                        false
                    );
                } 
                if ($isAjax) {
                    $APPLICATION->RestartBuffer();
                }            
                if($IS_MAIN == 'N'):?>
                <div class="row">
                    <div class="<?=$APPLICATION->AddBufferContent("columnPage");?>">
                        <div class="box">
                            <div class="box-title">
                                <h1><?$APPLICATION->ShowTitle(false);?></h1>
                            </div>
                            <div class="box-body">
                <?endif;?>