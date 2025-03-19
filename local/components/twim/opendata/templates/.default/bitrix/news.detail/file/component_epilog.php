<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
use \Bitrix\Main\Localization\Loc;
Loc::loadLanguageFile(__FILE__);
if(isset($arResult["FILES"])){
    $arParamFile = pathinfo(filter_input(INPUT_SERVER, "REQUEST_URI")); // читаю url
    if(array_key_exists($arParamFile["basename"], $arResult["FILES"])){ // провер≤ем если url - это ссылка на файл и совпадают имена
        // полный путь к файлу
        $pathFile = filter_input(INPUT_SERVER, "DOCUMENT_ROOT") . $arResult["FILES"][$arParamFile["basename"]]["PATH"];
        $count_download = GetUserFieldOD("OPEN_DATA", $arResult["FILES"][$arParamFile["basename"]]["ID"], "UF_COUNTER_DOWNLOAD");   
        if(!is_numeric($count_download)){
            $count_download = 0;
        }
        $count_download++;
        SetUserFieldOD("OPEN_DATA", $arResult["FILES"][$arParamFile["basename"]]["ID"], "UF_COUNTER_DOWNLOAD", $count_download);
        // отдаю файл с диалоговым окном и оригинальным названием
        file_force_download_od($pathFile, $arParamFile["basename"]);
    } else {
         ShowError(Loc::getMessage("DOWNLOAD_ERROR_FILE"), ".error");
    }
}
