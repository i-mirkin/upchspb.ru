<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
echo preg_replace_callback(
    "/#MENU_CONTENT#/is".BX_UTF_PCRE_MODIFIER,
     function(){
        ob_start(); 
        $GLOBALS["APPLICATION"]->IncludeFile(
            SITE_DIR."/include/content_menu.php",
            Array(),
            Array("MODE"=>"text")
        );
        $retrunStr = @ob_get_contents();
        ob_get_clean();
        return $retrunStr;
    },
    $arResult["CACHED_TPL"]
);
?>
