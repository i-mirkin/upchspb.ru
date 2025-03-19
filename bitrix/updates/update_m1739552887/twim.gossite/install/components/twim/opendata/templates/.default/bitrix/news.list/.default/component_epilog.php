<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
use \Bitrix\Main\Localization\Loc;
Loc::loadLanguageFile(__FILE__);

if(is_array($templateData["FILE_LIST"])){
    $arParamFile = pathinfo(filter_input(INPUT_SERVER, "REQUEST_URI")); // читаю url
    if($templateData["FILE_LIST"]["ORIGINAL_NAME"] === $arParamFile["basename"]){ // проверяем если url - это ссылка на реестр
        // полный путь к файлу
        $pathFile = filter_input(INPUT_SERVER, "DOCUMENT_ROOT") . $templateData["FILE_LIST"]["SRC"];
        
        $count_download = GetUserFieldOD ("OPEN_DATA", $templateData["FILE_LIST"]["ID"], "UF_COUNTER_DOWNLOAD");    
        if(is_null($count_download)){
            $count_download = 0;
        }
        $count_download++;
        SetUserFieldOD("OPEN_DATA", $templateData["FILE_LIST"]["ID"], "UF_COUNTER_DOWNLOAD", $count_download);
        // отдаю файл с диалоговым окном и оригинальным названием
        file_force_download_od($pathFile, $templateData["FILE_LIST"]["ORIGINAL_NAME"]);
    }
    
    $count_download = GetUserFieldOD ("OPEN_DATA",$templateData["FILE_LIST"]["ID"], "UF_COUNTER_DOWNLOAD");    
    if($count_download > 0){
        echo Loc::getMessage("DOWNLOAD_COUNT", array("#COUNT#"=>$count_download)) . human_plural_form_od($count_download, array(GetMessage("RAZ"),GetMessage("RAZA"),GetMessage("RAZ"))); 
    }

}
