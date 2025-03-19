<?php
if(!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true)
	die();
use Bitrix\Main\Localization\Loc;
$arOptionGosSite = $arParams["OPTION_SITE"];
?>
<footer class="footer footer_xs">
    <div class="b-container">
        <div class="row hidden-print">
            <div class="col-xs-12 col-md-9-6">
                <div class="row">
                    <div class="footer__wrap-nav-bottom-xs">
                      <?$APPLICATION->IncludeComponent(
                        "bitrix:menu", 
                        "bottom", 
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
                            "ROOT_MENU_TYPE" => "main",
                            "USE_EXT" => "Y",
                            "COMPONENT_TEMPLATE" => "bottom"
                        ),
                        false
                    );?>
                      </div>
                </div>
            </div>
            <div class="col-xs-12 col-md-2-4">
                  <div class="footer__wrap-soc-xs">
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
            </div>
        </div>
        <br>
        <div class="row">
            <div class="col-xs-12 col-md-2-4">
                <p class="copyright"><?=date(Y)?> &copy; <?=Loc::getMessage("FOOTER_COPYRIGTH")?></p>
            </div>
            <div class="col-md-2-4 hidden-xs hidden-sm">
              <div class="footer__wrap-nav-bottom-icon-xs">
                  <ul class="nav nav-bottom-icon"> 
                        <?if($arOptionGosSite["phone"]):?>
                        <li role="presentation"><a href="callto:<?=$arOptionGosSite["phone"]?>"><i class="ion ion-ios-telephone-outline" aria-hidden="true"></i><?=$arOptionGosSite["phone"]?></a></li>
                        <?endif;?>
                  </ul>
              </div>
            </div>
          <div class="col-md-2-4 hidden-xs hidden-sm">
                <div class="footer__wrap-nav-bottom-icon-xs">
                    <ul class="nav nav-bottom-icon"> 
                        <?if($arOptionGosSite["email"]):?>
                        <li role="presentation"><a href="mailto:<?=$arOptionGosSite["email"]?>"><i class="ion ion-ios-email-outline" aria-hidden="true"></i><?=$arOptionGosSite["email"]?></a></li>
                        <?endif;?>
                    </ul>
                </div>
            </div>
            <div class="col-md-4-8 hidden-xs hidden-sm">
                <div class="footer__wrap-nav-bottom-icon-xs">
                    <ul class="nav nav-bottom-icon">
                        <?if($arOptionGosSite["address"]):?>
                        <li role="presentation"><span><i class="ion ion-ios-location-outline" aria-hidden="true"></i><?=$arOptionGosSite["address"]?></span></li>
                        <?endif;?>
                    </ul>
                </div>
            </div>
        </div>
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