<?
define('STOP_STATISTICS', true);
require_once($_SERVER['DOCUMENT_ROOT'].'/bitrix/modules/main/include/prolog_before.php');
$GLOBALS['APPLICATION']->RestartBuffer();
use Bitrix\Main\Context; 
$request = Context::getCurrent()->getRequest(); 
$link_doc = strip_tags($request->getQuery("link"));
?>
<div><object><embed src="<?=$link_doc?>" class="embed_doc_viewer" /></object></div>
<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/epilog_after.php");?>
