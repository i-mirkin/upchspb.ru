<? if((int)$arResult["NavPageNomer"]>1 || (int)$_REQUEST["PAGEN_1"]>1){ 
 $APPLICATION->SetPageProperty("robots", "noindex, follow"); 
}
$request = \Bitrix\Main\Context::getCurrent()->getRequest();
$curPage = $request->get('PAGEN_' . $templateData['NavNum']) ?: '';
if($curPage > $templateData['NavPageCount']) {
    if (!defined("ERROR_404"))
    {        
        \CHTTP::setStatus("404 Not Found");
        define("ERROR_404", "Y");
    }
}