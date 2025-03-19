<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
$arError = array();
// если раздел указан 
if($arParams["PARENT_SECTION"]) {
    // получаем файл реестра из пользователского поля
    $aUserField = GetUserFieldOD("IBLOCK_".$arParams["IBLOCK_ID"]."_SECTION" , $arParams["PARENT_SECTION"], "UF_OPEN_DATA_LIST");
    if($aUserField){
        // если файл есть, получаем его параметры
        $arFile = CFile::GetFileArray($aUserField);
        // читаем файл и записываем для отображения
        $arListFile = array();
        if (($handle = fopen(filter_input(INPUT_SERVER, "DOCUMENT_ROOT") . $arFile["SRC"], "r")) !== FALSE) {
            while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
                $arListFile[] =  $data;
            }
            fclose($handle);
        }else{
            $arError["FILE_LIST"] = "Error open file list registry";
        }
        unset($arListFile[0]); // удаляем запись переменных полей
        unset($arListFile[1]); // удаляем запись о версии
        // сохраняем записи файла, для вывода реестра
        $arResult["FILE_LIST_ARRAY"] = $arListFile;
        // сохраняем параметры файла реестра
        $arResult["FILE_LIST"] = array_merge($arFile, pathinfo($arFile["SRC"])); 
    }
}
