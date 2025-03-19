<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
$arError = array();
// если файл паспорта есть
if(is_array($arResult["DISPLAY_PROPERTIES"]["META"])) {
        // читаем файл и записываем дл¤ отображени¤
        $count_structure = $count_data = 0; // флаг проверки версий файлов, если больше 0, то есть другие версии файлов
        $arListFile = array();
        $arVersionFile = array(); // массив файлов версий
        if (($handle = fopen(filter_input(INPUT_SERVER, "DOCUMENT_ROOT") . $arResult["DISPLAY_PROPERTIES"]["META"]["FILE_VALUE"]["SRC"], "r")) !== FALSE) {
            while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
                if($data[0] == "standardversion"){
                    $data[1] = '<a href="'.$data[1].'">'. $data[1] .'</a>';
                } elseif($data[0] == "publishermbox"){
                    $data[1] = '<a href="mailto:'.$data[1].'">'. $data[1] .'</a>';
                }elseif(in_array ($data[0], array("created", "modified", "valid"))){
                    $data[1] =  date("d.m.Y", strtotime($data[1]));
                }elseif(strpos($data[0],"structure-") === 0){   
                    $name = pathinfo($data[1]);
                    $data[1] = '<a href="'.$data[1].'">'. $name["basename"] .'</a>';
                    if($count_structure == 0){ 
                        $data[0] = "structure";
                    }else{ // если больше одной версии, то сохран¤¤ в массив версий структур
                        $arVersionFile["STRUCTURE_FILES"][] = $data[1];  
                    }
                    $count_structure++;
                }elseif(strpos($data[0],"data-") === 0){
                    $name = pathinfo($data[1]);
                    $data[1] = '<a href="'.$data[1].'">'. $name["basename"] .'</a>';
                    if($count_data == 0){
                        $data[0] = "data";
                    }else{// если больше одной версии, то сохран¤¤ в массив версий данных
                        $arVersionFile["DATA_FILES"][] = $data[1];
                    }
                    $count_data++;
                }
                 if($count_data <= 1 && $count_structure <= 1){
                   $arListFile[] = $data; 
                }
            }
            fclose($handle);
        }else{
            $arError["FILE_META"] = "Error open file meta";
            $arResult["ERROR"] = $arError;
        }
        unset($arListFile[0]); // удал¤ем запись переменных полей
        // сохран¤ем записи файла, дл¤ вывода реестра
        $arResult["FILE_META_ARRAY"] = $arListFile;
        // файлы версий
        $arResult["FILE_VERSION"] = $arVersionFile;
}

$cp = $this->__component;
    if(is_object($cp)){
      // если файл паспорта есть
    if(is_array($arResult["DISPLAY_PROPERTIES"]["META"])) {
        $arResult["FILES"]["META"] = $arResult["DISPLAY_PROPERTIES"]["META"]["FILE_VALUE"]["ID"];    
    } 
    // файлы данных и их id, дл¤ статичтики
    if(is_array($arResult["DISPLAY_PROPERTIES"]["DATA"]["DISPLAY_VALUE"])){ // если несколько файлов
        foreach ($arResult["DISPLAY_PROPERTIES"]["DATA"]["FILE_VALUE"] as $file) {   
            $arResult["FILES"]["DATA"][] = $file["ID"];  
        }
    }else{ // если один 
        $arResult["FILES"]["DATA"][] = $arResult["DISPLAY_PROPERTIES"]["DATA"]["FILE_VALUE"]["ID"];
    }
    // файлы структуры и их id, дл¤ статичтики
    if(is_array($arResult["DISPLAY_PROPERTIES"]["STRUCTURE"]["DISPLAY_VALUE"])){ // если несколько файлов
        foreach ($arResult["DISPLAY_PROPERTIES"]["STRUCTURE"]["FILE_VALUE"] as $file) {
             $arResult["FILES"]["STRUCTURE"][] = $file["ID"];  
        }
    }else{ // если один
        $arResult["FILES"]["STRUCTURE"][] = $arResult["DISPLAY_PROPERTIES"]["STRUCTURE"]["FILE_VALUE"]["ID"];
    }    
    $cp->arResult["FILES"] = $arResult["FILES"];
    $cp->SetResultCacheKeys(array("FILES"));  
}
