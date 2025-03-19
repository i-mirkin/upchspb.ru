<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
use \Bitrix\Main\Localization\Loc;
Loc::loadLanguageFile(__FILE__);

$count_download = GetUserFieldOD ("OPEN_DATA", $arResult["FILES"]["META"], "UF_COUNTER_DOWNLOAD");    
if($count_download > 0){
    echo Loc::getMessage("DOWNLOAD_META_COUNT", array("#COUNT#"=>$count_download)) . human_plural_form_od($count_download, array(Loc::getMessage("RAZ"),Loc::getMessage("RAZA"),Loc::getMessage("RAZ"))); 
    echo "<br />";
}
$count_download_data = 0;
foreach ($arResult["FILES"]["DATA"] as $id) {
    $count_download_data += GetUserFieldOD ("OPEN_DATA", $id, "UF_COUNTER_DOWNLOAD"); 
}  
if($count_download_data > 0){
    echo Loc::getMessage("DOWNLOAD_DATA_COUNT", array("#COUNT#"=>$count_download_data)) . human_plural_form_od($count_download_data, array(Loc::getMessage("RAZ"),Loc::getMessage("RAZA"),Loc::getMessage("RAZ"))); 
    echo "<br />";
}
$count_download_structure = 0;
foreach ($arResult["FILES"]["STRUCTURE"] as $id) {
    $count_download_structure += GetUserFieldOD ("OPEN_DATA", $id, "UF_COUNTER_DOWNLOAD"); 
}
if($count_download_structure > 0){
    echo Loc::getMessage("DOWNLOAD_STRUCTURE_COUNT", array("#COUNT#"=>$count_download_structure)) . human_plural_form_od($count_download_structure, array(Loc::getMessage("RAZ"),Loc::getMessage("RAZA"),Loc::getMessage("RAZ"))); 
    echo "<br />";
}



