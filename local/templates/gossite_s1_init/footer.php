<?
if(!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true)
	die();
use Bitrix\Main\Localization\Loc;
use Bitrix\Main\Context;
Loc::loadMessages(__FILE__);
function setDateModifPage(){
    global $APPLICATION;
    $context = Context::getCurrent();
    $server = $context->getServer();
    $docRoot = $server->getDocumentRoot();
    $timeModif = filemtime($docRoot.$APPLICATION->GetCurPage(true));
    $dateModif = date("d.m.Y H:i", $timeModif);
    $timestamp_x = $APPLICATION->GetPageProperty("show_timestamp_x");
    if(empty($timestamp_x)) {
        $timestamp_x = $APPLICATION->GetDirProperty("show_timestamp_x");
    }
    if($timestamp_x != "N" && $timeModif){
        return '<div class="date-change-page">' . Loc::getMessage("DATE_TIMESTAMP_X_PAGE") . ': ' . $dateModif . '</div>'; 
    } else {
        return "";
    }
}
$isAjax = isset($_SERVER['HTTP_X_REQUESTED_WITH']) && !empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest' && isset($_REQUEST['AJAX_PAGE']) && 'Y' == $_REQUEST['AJAX_PAGE'];
if ($isAjax) {
	die();
}
function columnPage(){ 
    global $APPLICATION; 
    $oneColumn = $APPLICATION->GetProperty("page_one_column");
    return ($oneColumn == "Y") ? "col-xs-12" : "col-sm-8 col-md-9";
} 
if($IS_MAIN == 'N'):?> 
            <?=setDateModifPage();?>
            <?$APPLICATION->ShowViewContent('item_timestamp_x');?>
            </div>
        </div>
    </div>
    <?if($APPLICATION->GetProperty("page_one_column") !== "Y"):?>
    <div class="col-sm-4 col-md-3">
        <?$APPLICATION->IncludeComponent(
            "bitrix:main.include", 
            ".default", 
            array(
                "AREA_FILE_SHOW" => "sect",
                "AREA_FILE_SUFFIX" => "profile",
                "AREA_FILE_RECURSIVE" => "Y",
                "COMPONENT_TEMPLATE" => ".default",
                "EDIT_TEMPLATE" => ""
            ),
            false
        );?>                       
        <?$APPLICATION->IncludeFile(
            SITE_DIR."include/right_column.php",
            Array(),
            Array("MODE"=>"text")
         );?>                           
    </div>
    <?endif;?>
</div>
<?endif; // is not main ?>
            </div>
        </div>
    </main>
</div>
<? // include footer
$pathFooter = SITE_TEMPLATE_PATH."/include/footer/extended.php";
if(!empty($themeConfig["footer"]["type"])){
    $pathFooter = SITE_TEMPLATE_PATH."/include/footer/".$themeConfig["footer"]["type"].".php";
};
$APPLICATION->IncludeFile(
    $pathFooter,
    Array("OPTION_SITE" => $arOptionGosSite),
    Array("MODE"=>"php", "SHOW_BORDER" => false)
);
?>  
<div class="fixed-panel hidden-print">
    <div class="icon-fixed">
        <?$APPLICATION->IncludeFile(
            SITE_DIR."include/fixed_block.php",
            Array("OPTION_SITE" => $arOptionGosSite),
            Array("MODE"=>"text", "SHOW_BORDER" => false)
         );?> 
    </div>
</div>
</div>
</div> 
<div class="soundbar soundbar_hide hide" data-toggle="tooltip" data-placement="left" title="<?=Loc::getMessage("FOOTER_SPEEK_HELP")?>">
    <div class="loader soundbar_loader soundbar_loader_hide"><div></div></div>
    <div class="soundbar__play" ><i class="fa fa-volume-up" aria-hidden="true"></i></div>
    <div class="soundbar__timers soundbar__timers_hide">
         <div class="soundbar__duration-time"></div>
         <div class="soundbar__stop"><i class="fa fa-stop" aria-hidden="true"></i></div>
         <div class="soundbar__curretn-time">00:00</div>
    </div>
</div>
<div class="modal fade modal_doc" id="modal_doc" tabindex="-1" role="dialog" aria-labelledby="modal_doc_viewer">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h5 class="modal-title" id="modal_doc_viewer">&nbsp;</h5>
      </div>
      <div class="modal-body"></div>
    </div>
  </div>
</div>
<div class="modal fade center modal_classic" tabindex="-1" role="dialog" id="modal_classic">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title"></h4>
      </div>
      <div class="modal-body"></div>
    </div>
  </div>
</div>
<?$APPLICATION->IncludeComponent(
"bitrix:main.userconsent.request",
"",
array(
    "ID" => 1,
    "IS_CHECKED" => "Y",
    "AUTO_SAVE" => "Y",
    "IS_LOADED" => "N",
    'HIDE' => "Y",
    "REPLACE" => array(
    'button_caption' => '',
    ),
)
);?>
<?require_once('themes/control.php');?>
</body>
</html>