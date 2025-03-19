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
$Asset->addString('<meta name="cmsmagazine" content="cf4f03a6602f60790197ac6e5f1e2da0" />');
$Asset->addJs(SITE_TEMPLATE_PATH . "/build/script.min.js");
$Asset->addJs(SITE_TEMPLATE_PATH . "/build/init.min.js");
$Asset->addJs(SITE_TEMPLATE_PATH . "/js/slick.min.js");
$Asset->addJs(SITE_TEMPLATE_PATH . "/js/detect.js");
$Asset->addJs(SITE_TEMPLATE_PATH . "/js/script.js");
$Asset->addJs(SITE_TEMPLATE_PATH . "/js/flatpickr.js");
$Asset->addJs(SITE_TEMPLATE_PATH . "/js/flatpickr.ru.js");
$Asset->addJs(SITE_TEMPLATE_PATH . "/js/tooltipster.bundle.min.js");
$Asset->addJs(SITE_TEMPLATE_PATH . "/js/styler/jquery.formstyler.js");
$Asset->addJs(SITE_TEMPLATE_PATH . "/js/slick-lightbox.min.js");
$Asset->addJs(SITE_TEMPLATE_PATH . "/js/SendEvent.min.js");
$Asset->addJs(SITE_TEMPLATE_PATH . "/js/lazyload.min.js");

$Asset->addCss(SITE_TEMPLATE_PATH . "/css/jquery.scrollbar.css");
$Asset->addCss(SITE_TEMPLATE_PATH . "/css/slick.css");
$Asset->addCss(SITE_TEMPLATE_PATH . "/css/slick-theme.css");
$Asset->addCss(SITE_TEMPLATE_PATH . "/css/template_styles.css"); 
$Asset->addCss(SITE_TEMPLATE_PATH . "/css/slick-lightbox.css");
$Asset->addCss(SITE_TEMPLATE_PATH . "/css/flatpickr.min.css");
$Asset->addCss(SITE_TEMPLATE_PATH . "/js/styler/jquery.formstyler.css");
$Asset->addCss(SITE_TEMPLATE_PATH . "/css/tooltipster.bundle.css");

$Asset::getInstance()->addString('<script>var jsOption = '. json_encode($jsOption). '</script>'); 
if ($USER->IsAdmin() || $themeConfig['demo'] === 'Y') {
    //$Asset->addJs(SITE_TEMPLATE_PATH . "/build/control.min.js");
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
    <link rel='shortcut icon' type='image/ico' href='<?=SITE_TEMPLATE_PATH?>/favicon/favicon.ico' />
    <link rel="preload" href="/local/templates/gossite_s1/fonts/Roboto/RobotoBold/RobotoBold.woff" as="font" crossorigin="">
	<link rel="preload" href="/local/templates/gossite_s1/fonts/Roboto/RobotoLight/RobotoLight.woff" as="font" crossorigin="">
	<link rel="preload" href="/local/templates/gossite_s1/fonts/Roboto/RobotoMedium/RobotoMedium.woff" as="font" crossorigin="">
	<link rel="preload" href="/local/templates/gossite_s1/fonts/Roboto/RobotoRegular/RobotoRegular.woff" as="font" crossorigin="">
	<link rel="preload" href="/local/templates/gossite_s1/fonts/ionicons.ttf?v=2.0.0" as="font" crossorigin="">    		
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
    <script>
    jQuery(document).ready(function(){
		var lazyLoadInstance = new LazyLoad({
			elements_selector: ".lazy_inst" 
		});
		window.lazyLoadInstance = lazyLoadInstance;
	});
	</script>
</head>
<body<?if(!empty($class_body)):?> class="<?=$class_body?>"<?endif;?>>  
<header class="header" data-site="<?=SITE_DIR?>">
	<div id="panel">
        <?$APPLICATION->ShowPanel();?>
    </div>
	<?//special panel
    $APPLICATION->IncludeFile(
        SITE_TEMPLATE_PATH."/include/special.php",
        Array(),
        Array("MODE"=>"text")
    );?>
	<div class="header__top">
		<div class="b-container clearfix">
			<div class="header__top-menu"></div>
			
			<div class="header__top-wr clearfix">
				<a href="#special" title="<?=GetMessage('HEADER_TOGGLE_SPECIAL')?>" class="special"><span class="sr-only"><?=GetMessage('SPECIAL_VERSION')?></span></a>
					
				<div class="header-land">
					<div class="header-land__item"><a href="/en/">EN</a></div>
					<div class="header-land__item"><a href="/">RU</a></div>
				</div>
				<div class="header__top-search"></div>
				<? if('s1' == SITE_ID) { ?>
					<?$APPLICATION->IncludeComponent(
	"bquadro:sm.links", 
	"header", 
	[    
	//"youtube" => "https://www.youtube.com/channel/UCC0bg6xVQpdWLt9t1QuMzVg",
	"facebook" => "https://www.facebook.com/HR.OmbudsmanforSt.Petersburg/",
	"vkontakte" => "https://vk.com/",
	"instagram" => "https://www.instagram.com/?hl=ru",
	"telegram" => "https://tlgrm.ru/",
	"COMPONENT_TEMPLATE" => "header"
	],
	false
);?>
				<? } ?>
				<? if('en' == SITE_ID) { ?>
					<?$APPLICATION->IncludeComponent(
	"bquadro:sm.links", 
	"header", 
	[    
	//"youtube" => "https://www.youtube.com/channel/UCC0bg6xVQpdWLt9t1QuMzVg",
	"facebook" => "https://www.facebook.com/HR.OmbudsmanforSt.Petersburg/",
	"COMPONENT_TEMPLATE" => "header"
	],
	false
);?>
				<? } ?>
			</div>
		</div>
	</div>
	<div class="header__center">
		<div class="b-container">
			<div class="header__center-wr">
				<?if($themeConfig['hide_gerb'] === 'N' && $arOptionGosSite["img_gerb"]):?>
				<div class="header-logo-emblem">
          <?
              $dir  = $APPLICATION->GetCurDir();
          ?>
          <?if ($dir == "/"):?>
            <span class="header__logo clearfix" title="<?=Loc::getMessage("HEADER_MAIN_PAGE")?>">
              <img src="<?=$arOptionGosSite["img_gerb"]?>" alt="" class="header__logo-img">
              <span class="header__logo-text"><?$APPLICATION->IncludeFile(
                            SITE_DIR."include/title-site.php",
                            Array(),
                            Array("MODE"=>"text")
                        );?> </span>
            </span>
          <?else:?>
            <a href="<?=SITE_DIR?>" class="header__logo clearfix" title="<?=Loc::getMessage("HEADER_MAIN_PAGE")?>">
              <img src="<?=$arOptionGosSite["img_gerb"]?>" alt="" class="header__logo-img">
              <span class="header__logo-text"><?$APPLICATION->IncludeFile(
                            SITE_DIR."include/title-site.php",
                            Array(),
                            Array("MODE"=>"text")
                        );?> </span>
            </a>
          <?endif;?>
					<img src="<?=SITE_TEMPLATE_PATH;?>/images/emblem.png" class="header__emblem" alt="">
				</div>
				<?endif;?>
				


				<div class="header__center-line"></div>

				<div class="header-search">
					<?$APPLICATION->IncludeComponent(
                    	"bitrix:search.form", 
                    	"top_searchdf", 
                    	array(
                    		"USE_SUGGEST" => "N",
                    		"PAGE" => "#SITE_DIR#search/index.php",
                    		"COMPONENT_TEMPLATE" => "top_searchdf"
                    	),
                    	false
                    );?> 
          			<div class="header-search__close"></div>
				</div>
				<div class="header__center-line"></div>

				<div class="header-info">
					<?if($arOptionGosSite["phone"]):?>
					<div class="header-info__item header-info__item--tel">
						<a href="tel:<?=str_replace(' ', '', $arOptionGosSite["phone"])?>"><?=$arOptionGosSite["phone"]?></a>
					</div>
					<?endif;?>
					<?if($arOptionGosSite["email"]):?>
					<div class="header-info__item header-info__item--mail">
						<a href="mailto:<?=$arOptionGosSite["email"]?>"><?=$arOptionGosSite["email"]?></a>
					</div>
					<?endif;?>
					<?if($arOptionGosSite["address"]):?>
					<div class="header-info__item header-info__item--address">
						<?= $arOptionGosSite["address"] ?>
					</div>
					<?endif;?>
				</div>
			</div>
		</div>
	</div>
	<div class="header__bottom">
		<div class="header__bottom-close"></div>
		<div class="header-bottom__info"></div>
		<div class="b-container scrollbar-dynamic">
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
		"MENU_CACHE_USE_GROUPS" => "N",
		"MENU_THEME" => "site",
		"ROOT_MENU_TYPE" => "main",
		"USE_EXT" => "Y",
		"COMPONENT_TEMPLATE" => "main",
		"ADD_CLASS" => $themeConfig["menu"]
	),
	false
);?>
		</div>
	</div>
	<div class="header__mob clearfix">
		<a href="/appointment/" class="btn header__mob-btn btn--appointment">Записаться на прием</a>
		<a href="/apply/" class="btn header__mob-btn btn--application">ПОДАТЬ ЗАЯВЛЕНИЕ</a>
		<a href="javascript:void(0)" data-toggle="modal_classic" data-target="#modal_question" data-title="Задать вопрос:" data-load-page="/vopros-otvet/question.php" class="btn header__mob-btn btn--question"><span>Задать вопрос</span></a>
	</div>
</header>
<main class="main">
            <div class="workarea">
                <div class="b-container">
					<div class="col-wrap clearfix">
                <?if($IS_MAIN == 'N'){ ?>
					<div class="col-left">
						<div class="col-in col-in--crest">
				<?
                    $APPLICATION->IncludeComponent(
	"bitrix:breadcrumb", 
	"breadcrumb_box", 
	array(
		"PATH" => "",
		"SITE_ID" => "s1",
		"START_FROM" => "0",
		"COMPONENT_TEMPLATE" => "breadcrumb_box"
	),
	false
);
                } 
                if ($isAjax) {
                    $APPLICATION->RestartBuffer();
                }            
                if($IS_MAIN == 'N'):?>
                
                    
                        <div class="box">
                            <div class="box-title">
                                <h1><?$APPLICATION->ShowTitle();?></h1>
                            </div>
                            <div class="box-body">
                <?endif;?>
						

