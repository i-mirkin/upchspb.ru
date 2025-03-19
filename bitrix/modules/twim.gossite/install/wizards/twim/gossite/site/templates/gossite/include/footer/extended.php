<?php
if(!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true)
	die();
use Bitrix\Main\Localization\Loc;
$arOptionGosSite = $arParams["OPTION_SITE"];
?>
<footer class="footer">
    <div class="b-container">
          <div class="row hidden-print">
              <div class="col-md-9-6 hidden-xs hidden-sm">
                  <div class="row">
                      <?$APPLICATION->IncludeComponent(
                        "bitrix:menu", 
                        "bottom", 
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
                            "COMPONENT_TEMPLATE" => "bottom"
                        ),
                        false
                    );?>
                  </div>
              </div>
              <div class="col-sm-12 col-md-2-4">
                  <div class="weather hidden-xs hidden-sm">
                      <h5><?=Loc::getMessage("FOOTER_WEATHER_TITLE")?></h5>
                      <br />
                      <div class="wrap-widget">
                          <?$APPLICATION->IncludeFile(
                                SITE_DIR."include/weather.php",
                                Array(),
                                Array("MODE"=>"text")
                            );?> 
                      </div>
                  </div>
                  <div class="wrap-mobile-nav-bottom-icon  visible-xs-block visible-sm-block">
                    <?$APPLICATION->IncludeFile(
                        SITE_DIR."/include/contacts_footer.php",
                        Array("OPTION_SITE" => $arOptionGosSite),
                        Array("MODE"=>"text", "SHOW_BORDER" => false)
                    );?>  
                  </div>
                  <div class="wrap-soc-menu">
                      <?$APPLICATION->IncludeComponent(
                            "bitrix:menu", 
                            "soc", 
                            array(
                                "ALLOW_MULTI_SELECT" => "N",
                                "CHILD_MENU_TYPE" => "left",
                                "DELAY" => "N",
                                "MAX_LEVEL" => "1",
                                "MENU_CACHE_GET_VARS" => array(
                                ),
                                "MENU_CACHE_TIME" => "3600000",
                                "MENU_CACHE_TYPE" => "A",
                                "MENU_CACHE_USE_GROUPS" => "Y",
                                "MENU_THEME" => "site",
                                "ROOT_MENU_TYPE" => "soc",
                                "USE_EXT" => "Y",
                                "COMPONENT_TEMPLATE" => "soc"
                            ),
                            false
                        );?>
                  </div>
                  <div class="wrap-build-company hidden-xs">
                      <a href="http://creatwim.ru" tabindex="-1" target="_blank" title="<?=Loc::getMessage("FOOTER_COPYRIGTH_PRODUCE")?>">
                          <img src="<?=SITE_TEMPLATE_PATH?>/images/twim.svg" alt="<?=Loc::getMessage("FOOTER_COPYRIGTH_PRODUCE")?>" />
                      </a>
                  </div>
                    <div class="hidden-xs hidden-sm">
                    <?$APPLICATION->IncludeFile(
                        SITE_DIR."/include/contacts_footer.php",
                        Array("OPTION_SITE" => $arOptionGosSite),
                        Array("MODE"=>"text", "SHOW_BORDER" => false)
                    );?>          
                    </div> 
              </div>
          </div>
          <p class="copyright"><?=date("Y")?> &copy; <?=Loc::getMessage("FOOTER_COPYRIGTH")?></p>
    </div>
    <div class="hidden-print">
        <div class="wrap-counter text-center hidden-xs hidden-sm">
            <div class="b-container">
                <?$APPLICATION->IncludeFile(
                     SITE_DIR."include/counters.php",
                     Array(),
                     Array("MODE"=>"text")
                 );?> 
            </div>
        </div>
    </div>
</footer>