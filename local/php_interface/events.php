<?
AddEventHandler('main', 'OnAdminContextMenuShow', 'QAsendMail');
function QAsendMail(&$items) {
    $request = \Bitrix\Main\Context::getCurrent()->getRequest();
    if ('/bitrix/admin/iblock_element_edit.php' == $request->getRequestedPage() && $request->get('ID') && (22 == $request->get('IBLOCK_ID'))) {
        $items[] = [
            "TEXT" => "Отправить ответ",
            "LINK" => "javascript:QAsendMail(" . $request->get('ID') . ")",
            "TITLE" => "Отправить трек",
        ];
    }
}

AddEventHandler("main", "OnEndBufferContent", "removeType");
function removeType(&$content) {
    $content = replace_output($content);
}

function replace_output($d) {
    return str_replace(' type="text/javascript"', "", $d);
}

AddEventHandler("main", "OnEndBufferContent", "deleteKernelCss1");
function deleteKernelCss1(&$content) {
    global $USER, $APPLICATION;
    if ((is_object($USER) && $USER->IsAuthorized()) || strpos($APPLICATION->GetCurDir(), "/bitrix/") !== false)
        return;
    if ($APPLICATION->GetProperty("save_kernel") == "Y")
        return;

    $arPatternsToRemove = array(
        '/<link.href=".+\/css\/core\.min\.css\?\d+"[^>]+>/',
        '/<link.href=".+\/opensans\/ui\.font\.opensans\.min\.css\?\d+"[^>]+>/',
        //'/<link.href=".+\/dist\/main\.popup\.bundle\.min\.css\?\d+"[^>]+>/',
        //'/<link.+?href=".+?kernel_main\/kernel_main_v1\.css\?\d+"[^>]+>/',
    );

    $content = preg_replace($arPatternsToRemove, "", $content);
    $content = preg_replace("/\n{2,}/", "\n\n", $content);
}
