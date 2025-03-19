<?
require_once($_SERVER['DOCUMENT_ROOT'] . "/bitrix/modules/main/include/prolog_before.php"); 
use Bitrix\Main\Application;
use Bitrix\Main\Localization\Loc;
Loc::loadMessages(__FILE__);
global $USER;
$request = Application::getInstance()->getContext()->getRequest();
$arPost = $request->getPostList()->toArray();
$isAdmin = $USER->IsAdmin();
$isAjax = isset($_SERVER['HTTP_X_REQUESTED_WITH']) && !empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest' && isset($_REQUEST['ajax']) && 'Y' === $_REQUEST['ajax'];
require_once('config.php'); // config file
require_once('TwimGossiteColorControl.php'); // class function colorLuminance, hexToRgb .. 
if (!$isAdmin && $themeConfig['demo'] === 'N'){ die();} // only admin & demo
$arDefaultTheme = $themeConfig["themes_default"];
$arLayouts = $themeConfig["layout_type"];
// unset demo
if($isAdmin){
    unset($_SESSION["DEMO_STYLE_THEME"]); // del demo style
    unset($_SESSION["DEMO_CONFIG_THEME"]); // del demo config
}

if (($arPost["save"] === "Y" || $arPost["reset"] === "Y")  && $isAjax) { 
    $css_default_style = file_get_contents(dirname(__DIR__) . "/build/style.min.css");
    
    //theme
    if($arPost["theme_color"] == "default" || $arPost["reset"] === "Y"){
        $colorMain = $arDefaultTheme["default"][0];
        $colorSecond = $arDefaultTheme["default"][1];
        $arPost["theme_color"] = "default";
        $cssText = $css_default_style;
    }elseif($arPost["theme_color"] === "custom" || array_key_exists($arPost["theme_color"], $arDefaultTheme)){
        if($arPost["theme_color"] === "custom"){
            $colorMain = $arPost["custom_color_main"];
            $colorSecond = $arPost["custom_color_second"];  
        } else {
            $colorMain = $arDefaultTheme[$arPost["theme_color"]][0];
            $colorSecond = $arDefaultTheme[$arPost["theme_color"]][1];   
        }
        $arRepColor = TwimGossiteColorControl::getArColorNewReplace($colorMain, $colorSecond);
        $cssText = TwimGossiteColorControl::generateStyle(
            $css_default_style, 
            $themeConfig["themes_default"]['default'], 
            $arRepColor
        ); 
    }
    //color theme
    $themeConfig["color"] = array (
        'main' => $colorMain,
        'dark' => $colorSecond,
    );
    // name theme
    $themeConfig["theme_color"] = $arPost["theme_color"];
    // layout theme
    if(in_array($arPost["layout"], $arLayouts)){
        $themeConfig["layout"] = $arPost["layout"];
    } else{
        $themeConfig["layout"] = "wide";
    }
    // slider
    if($arPost["main_page_slider"] === "Y"){
        $themeConfig["main_page"]["slider"] = "Y";
    } else{
        $themeConfig["main_page"]["slider"] = "N";
    }
    // media
    if($arPost["main_page_media"] === "Y"){
        $themeConfig["main_page"]["media"] = "Y";
    } else{
        $themeConfig["main_page"]["media"] = "N";
    }
    // events
    if($arPost["main_page_events"] === "Y"){
        $themeConfig["main_page"]["events"] = "Y";
    } else{
        $themeConfig["main_page"]["events"] = "N";
    }
    // banners
    if($arPost["main_page_banners"] === "Y"){
        $themeConfig["main_page"]["banners"] = "Y";
    } else{
        $themeConfig["main_page"]["banners"] = "N";
    }
    // contacts
    if($arPost["main_page_contacts"] === "Y"){
        $themeConfig["main_page"]["contacts"] = "Y";
    } else{
        $themeConfig["main_page"]["contacts"] = "N";
    }
    // news
    if(in_array($arPost["news_type"], $themeConfig["main_page"]["news_type"])){
        $themeConfig["main_page"]["news"] = $arPost["news_type"];
    } else{
        $themeConfig["main_page"]["news"] = "tile";
    }
    // news_preview
    if(in_array($arPost["news_preview_type"], $themeConfig["main_page"]["news_preview_type"])){
        $themeConfig["main_page"]["news_preview"] = $arPost["news_preview_type"];
    } else{
        $themeConfig["main_page"]["news_preview"] = "default_news1";
    }
    // main menu
    if(in_array($arPost["menu_type"], $themeConfig["menu_type"])){
        $themeConfig["menu"] = $arPost["menu_type"];
    } else{
        $themeConfig["menu"] = "line";
    }
    // footer
    if(in_array($arPost["footer_type"], $themeConfig["footer"]["varible_type"])){
        $themeConfig["footer"]["type"] = $arPost["footer_type"];
    } else{
        $themeConfig["footer"]["type"] = "extended";
    }
    // hide_gerb theme
    if($arPost["hide_gerb"] === "Y"){
        $themeConfig["hide_gerb"] = "Y";
    } else{
        $themeConfig["hide_gerb"] = "N";
    }
    //gerb_size
    if(in_array($arPost["gerb_size_type"], $themeConfig["gerb_size_type"])){
        $themeConfig["gerb_size"] = $arPost["gerb_size_type"];
    } else{
        $themeConfig["gerb_size"] = "normal";
    }
    
    $css_new_style_line = preg_replace('/\.\.\//i', SITE_TEMPLATE_PATH . '/', $cssText); // replace path only tag style 

    if($arPost["reset"] === "Y"){
        require_once('default_config.php'); // config file default
        $themeConfig = $defaultThemeConfig;
        $arResult = array(
            "theme" => "default", 
            "css" => $css_new_style_line,
            "layout" => $defaultThemeConfig["layout"],
            "layouts" => $arLayouts,
            "hide_gerb" => $defaultThemeConfig["hide_gerb"]
        );
    } else {
        $arResult = [
            "theme" => $arPost["theme_color"],
            "css" => $css_new_style_line,
            "layout" => $themeConfig["layout"],
            "layouts" => $arLayouts,
            "hide_gerb" => $themeConfig["hide_gerb"]  
        ];
    }
    
    if ($isAdmin){
        $sSave = var_export($themeConfig, true);
        file_put_contents(__DIR__ . '/config.php', "<?php\n\$themeConfig = {$sSave};\n?>"); //save config
        file_put_contents(dirname(__DIR__) . "/build/theme.min.css", $cssText); 
    } elseif ($themeConfig['demo'] === 'Y'){ // demo, save in session
        $_SESSION["DEMO_STYLE_THEME"] = gzencode($css_new_style_line, 9);    
        $_SESSION["DEMO_CONFIG_THEME"] = $themeConfig; 
    }
    
    echo json_encode($arResult); // ajax answer
    die();   
}
?>
<div id="control-panel" class="theme-control fixed-control hidden-xs">
    <div class="wrap-control">
        <div class="header-control">
            <h5><?=Loc::getMessage("THEME_CONTROL_TITLE_DESC")?></h5>
            <button class="toggle-control"><i class="fa fa-cog" area-control="hidden"></i><span class="sr-only"><?=Loc::getMessage("THEME_CONTROL_CONTROL_TEMPLATE")?></span></button>
        </div>
        <div class="body-contorol">
            <form name="theme-control" action="<?=SITE_TEMPLATE_PATH?>/themes/control.php" method="POST">
                <div class="width-control">
                    <h4><?=Loc::getMessage("THEME_CONTROL_WIDTH_LAYOUT")?>:</h4>
                    <?foreach ($arLayouts as $type) {?>
                    <label class="btn btn-xs btn-info<?if($themeConfig["layout"] === $type):?> active<?endif;?>">
                        <input class="hidden" type="radio" name="layout" value="<?=$type?>" <?if($themeConfig["layout"] === $type):?>checked="checked"<?endif;?>/>
                        <?=Loc::getMessage("THEME_CONTROL_".$type)?>
                    </label>
                    <?}?>
                </div>
                <div class="color-control">
                    <h4><?=Loc::getMessage("THEME_CONTROL_COLOR_THEME")?>:</h4>
                    <div class="wrap-theme-color">
                        <?foreach ($arDefaultTheme as $name => $colors) {?>
                            <label class="label-themes<?if($themeConfig["theme_color"]===$name):?> active<?endif;?>" data-theme="<?=$name?>" title="<?=$name?>">
                                <input class="hidden" type="radio" name="theme_color" value="<?=$name?>"<?if($themeConfig["theme_color"]===$name):?> checked="checked" <?endif;?>/>
                                <div class="box-color">
                                    <span class="main" style="border-color: <?=$colors[0]?> transparent transparent transparent;"></span>
                                    <span class="dark" style="border-color: transparent transparent <?=$colors[1]?> transparent;"></span>
                                </div>
                            </label>
                        <?}?>
                        <label id="custom-color" class="box-custom<?if($themeConfig["theme_color"]==="custom"):?> active<?endif;?>">
                            <input class="hidden" type="radio" name="theme_color" value="custom"<?if($themeConfig["theme_color"]===$name):?> checked="checked" <?endif;?>/>
                            <div class="box-color">
                                <span class="main" style="border-color: <?=$themeConfig["color"]["main"]?> transparent transparent transparent;"></span>
                                <span class="dark" style="border-color: transparent transparent <?=$themeConfig["color"]["dark"]?> transparent;"></span>
                            </div>
                            <div class="popup-color-set hidden">
                                <small><?=Loc::getMessage("THEME_CONTROL_SELECT_COLOR")?>:</small>
                                <span class="close"><i class="ion ion-ios-close-empty"></i><span class="sr-only"><?=Loc::getMessage("THEME_CONTROL_CLOSE_DESC")?></span></span>
                                <div class="row">
                                    <div class="col-xs-6">
                                        <label>
                                            <small><?=Loc::getMessage("THEME_CONTROL_COLOR_1")?></small>
                                            <input type="text" name="custom_color_main"  value="<?=$themeConfig["color"]["main"]?>"/>
                                        </label>
                                        
                                    </div>
                                    <div class="col-xs-6">
                                        <label>
                                            <small><?=Loc::getMessage("THEME_CONTROL_COLOR_2")?></small>
                                            <input type="text" name="custom_color_second" value="<?=$themeConfig["color"]["dark"]?>"/>
                                        </label>
                                    </div>
                                </div>   
                            </div> 
                        </label>
                    </div>
                </div>
                <div class="element-control">
                   <h4><?=Loc::getMessage("THEME_CONTROL_HEADER")?>:</h4>
                    <div class="checkbox">
                        <label>
                          <input type="checkbox" name="hide_gerb" data-reload="Y" value="Y" <?if($themeConfig["hide_gerb"]==="Y"):?> checked="checked" <?endif;?>/>
                          <?=Loc::getMessage("THEME_CONTROL_HIDE_LOGO")?>
                        </label>
                    </div>
                    <p><?=Loc::getMessage("THEME_CONTROL_SIZE_LOGO")?>:</p>
                    <?foreach ($themeConfig["gerb_size_type"] as $size) {?>
                    <label class="btn btn-xs btn-info<?if($themeConfig["gerb_size"] === $size):?> active<?endif;?>">
                        <input class="hidden" type="radio" name="gerb_size_type" data-reload="Y" value="<?=$size?>" <?if($themeConfig["gerb_size"] === $size):?>checked="checked"<?endif;?>/>
                        <?=Loc::getMessage("THEME_CONTROL_SIZE_LOGO_".$size)?>
                    </label>
                    <?}?>
                    <p><?=Loc::getMessage("THEME_CONTROL_MENU_DESC")?>:</p>
                    <?foreach ($themeConfig["menu_type"] as $type) {?>
                    <label class="btn btn-xs btn-info<?if($themeConfig["menu"] === $type):?> active<?endif;?>">
                        <input class="hidden" type="radio" name="menu_type" data-reload="Y" value="<?=$type?>" <?if($themeConfig["menu"] === $type):?>checked="checked"<?endif;?>/>
                        <?=Loc::getMessage("THEME_CONTROL_MENU_TYPE_".$type)?>
                    </label>
                    <?}?>
                </div>
                <div class="element-control">
                   <h4><?=Loc::getMessage("THEME_CONTROL_MAIN_PAGE_DESC")?>:</h4>
                    <div class="checkbox">
                        <label>
                          <input type="checkbox" name="main_page_slider" data-reload="Y" value="Y" <?if($themeConfig['main_page']["slider"]==="Y"):?> checked="checked" <?endif;?>/>
                          <?=Loc::getMessage("THEME_CONTROL_MAIN_PAGE_SLIDER")?>
                        </label>
                    </div>
                   <div class="checkbox">
                        <label>
                          <input type="checkbox" name="main_page_media" data-reload="Y" value="Y" <?if($themeConfig['main_page']["media"]==="Y"):?> checked="checked" <?endif;?>/>
                          <?=Loc::getMessage("THEME_CONTROL_MAIN_PAGE_MEDIA")?>
                        </label>
                    </div>
                   <div class="checkbox">
                        <label>
                          <input type="checkbox" name="main_page_events" data-reload="Y" value="Y" <?if($themeConfig['main_page']["events"]==="Y"):?> checked="checked" <?endif;?>/>
                          <?=Loc::getMessage("THEME_CONTROL_MAIN_PAGE_CALENDAR")?>
                        </label>
                    </div>
                   <div class="checkbox">
                        <label>
                          <input type="checkbox" name="main_page_banners" data-reload="Y" value="Y" <?if($themeConfig['main_page']["banners"]==="Y"):?> checked="checked" <?endif;?>/>
                          <?=Loc::getMessage("THEME_CONTROL_MAIN_PAGE_BANNERS")?>
                        </label>
                    </div>
                   <div class="checkbox">
                        <label>
                          <input type="checkbox" name="main_page_contacts" data-reload="Y" value="Y" <?if($themeConfig['main_page']["contacts"]==="Y"):?> checked="checked" <?endif;?>/>
                          <?=Loc::getMessage("THEME_CONTROL_MAIN_PAGE_CONTACTS")?>
                        </label>
                    </div>
                   <p><?=Loc::getMessage("THEME_CONTROL_NEWS_DESC")?>:</p>
                    <?foreach ($themeConfig['main_page']["news_type"] as $type) {?>
                    <label class="btn btn-xs btn-info<?if($themeConfig['main_page']["news"] === $type):?> active<?endif;?>">
                        <input class="hidden" type="radio" name="news_type" data-reload="Y" value="<?=$type?>" <?if($themeConfig['main_page']["news"] === $type):?>checked="checked"<?endif;?>/>
                        <?=Loc::getMessage("THEME_CONTROL_NEWS_MAIN_".$type)?>
                    </label>
                    <?}?>
                    <p><?=Loc::getMessage("THEME_CONTROL_NEWS_PREVIEW")?>:</p>
                    <?foreach ($themeConfig['main_page']["news_preview_type"] as $prev) {?>
                    <label class="btn btn-xs btn-info<?if($themeConfig['main_page']["news_preview"] === $prev):?> active<?endif;?>">
                        <input class="hidden" type="radio" name="news_preview_type" data-reload="Y" value="<?=$prev?>" <?if($themeConfig['main_page']["news_preview"] === $prev):?>checked="checked"<?endif;?>/>
                        <?=Loc::getMessage("THEME_CONTROL_NEWS_MAIN_PREVIEW_".$prev)?>
                    </label>
                    <?}?>
                </div>
                <div class="element-control">
                   <h4><?=Loc::getMessage("THEME_CONTROL_FOOTER_DESC")?>:</h4>
                    <?foreach ($themeConfig['footer']["varible_type"] as $type) {?>
                    <label class="btn btn-xs btn-info<?if($themeConfig['footer']["type"] === $type):?> active<?endif;?>">
                        <input class="hidden" type="radio" name="footer_type" data-reload="Y" value="<?=$type?>" <?if($themeConfig['footer']["type"] === $type):?>checked="checked"<?endif;?>/>
                        <?=Loc::getMessage("THEME_CONTROL_FOOTER_TYPE_".$type)?>
                    </label>
                    <?}?>
                </div>
                <hr>
                <div class="element-control">
                <button class="btn btn-info" type="submit" name="save" value="Y"><?=Loc::getMessage("THEME_CONTROL_SAVE_DESC")?></button>
                <button class="btn btn-info" type="submit" name="reset" value="Y"><?=Loc::getMessage("THEME_CONTROL_DEFAULT_SETTINGS")?></button>
                </div>
                <br>
            </form>
        </div>
    </div>
</div>
