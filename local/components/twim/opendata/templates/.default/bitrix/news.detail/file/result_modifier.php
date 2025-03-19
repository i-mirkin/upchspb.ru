<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
//$arResult["FILES_ID"] - массив с параметрами для статистики, значение для множественных файлов данных и стркутур единое, будет сумма всех скачиваний 
$cp = $this->__component;
    if(is_object($cp)){
      // если файл паспорта есть
    if(is_array($arResult["DISPLAY_PROPERTIES"]["META"])) {
        $name = $arResult["DISPLAY_PROPERTIES"]["META"]["FILE_VALUE"]["ORIGINAL_NAME"]; 
        $arResult["FILES"][$name]["PATH"] = $arResult["DISPLAY_PROPERTIES"]["META"]["FILE_VALUE"]["SRC"];    
        $arResult["FILES"][$name]["ID"] = $arResult["DISPLAY_PROPERTIES"]["META"]["FILE_VALUE"]["ID"];    
    } 
    // файлы данных и их id, для статичтики
    if(is_array($arResult["DISPLAY_PROPERTIES"]["DATA"]["DISPLAY_VALUE"])){ // если несколько файлов
        foreach ($arResult["DISPLAY_PROPERTIES"]["DATA"]["FILE_VALUE"] as $file) {
            $arResult["FILES"][$file["ORIGINAL_NAME"]]["PATH"] = $file["SRC"];      
            $arResult["FILES"][$file["ORIGINAL_NAME"]]["ID"] = $file["ID"];  
        }
    }else{ // если один
        $name = $arResult["DISPLAY_PROPERTIES"]["DATA"]["FILE_VALUE"]["ORIGINAL_NAME"];
        $arResult["FILES"][$name]["PATH"] = $arResult["DISPLAY_PROPERTIES"]["DATA"]["FILE_VALUE"]["SRC"]; 
        $arResult["FILES"][$name]["ID"] = $arResult["DISPLAY_PROPERTIES"]["DATA"]["FILE_VALUE"]["ID"];
    }
    // файлы структуры и их id, для статичтики
    if(is_array($arResult["DISPLAY_PROPERTIES"]["STRUCTURE"]["DISPLAY_VALUE"])){ // если несколько файлов
        foreach ($arResult["DISPLAY_PROPERTIES"]["STRUCTURE"]["FILE_VALUE"] as $file) {
            $arResult["FILES"][$file["ORIGINAL_NAME"]]["PATH"] = $file["SRC"];    
            $arResult["FILES"][$file["ORIGINAL_NAME"]]["ID"] = $file["ID"];  
        }
    }else{ // если один
        $name = $arResult["DISPLAY_PROPERTIES"]["STRUCTURE"]["FILE_VALUE"]["ORIGINAL_NAME"]; 
        $arResult["FILES"][$name]["PATH"] = $arResult["DISPLAY_PROPERTIES"]["STRUCTURE"]["FILE_VALUE"]["SRC"];   
        $arResult["FILES"][$name]["ID"] = $arResult["DISPLAY_PROPERTIES"]["STRUCTURE"]["FILE_VALUE"]["ID"];
    }    
    $cp->arResult["FILES"] = $arResult["FILES"];
    $cp->SetResultCacheKeys(array("FILES"));  
}

