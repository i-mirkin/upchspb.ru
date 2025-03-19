<?
if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)
	die();

COption::SetOptionString("fileman", "different_set", "Y");
CModule::IncludeModule('fileman');
$arMenuTypes = GetMenuTypes(WIZARD_SITE_ID);
if(!$arMenuTypes['main'])
	$arMenuTypes['main'] =  GetMessage("WIZ_MENU_MAIN");
if(!$arMenuTypes['left'])
	$arMenuTypes['left'] = GetMessage("WIZ_MENU_SUB");
if(!$arMenuTypes['soc'])
	$arMenuTypes['soc'] = GetMessage("WIZ_MENU_SOC");
if(!$arMenuTypes['top'])
	$arMenuTypes['top'] = GetMessage("WIZ_MENU_TOP");
	
SetMenuTypes($arMenuTypes, WIZARD_SITE_ID);
COption::SetOptionInt("fileman", "num_menu_param", 2, false ,WIZARD_SITE_ID);

// set menu in mapsite
$map_top_menu_type = str_replace(' ', '', COption::GetOptionString("main", "map_top_menu_type"));
$arMapTopMenu = explode(',', $map_top_menu_type);
if (!in_array("main", $arMapTopMenu)) {
    if(trim($map_top_menu_type) == ''){
        $map_top_menu_type .= 'main';
    } else {
        $map_top_menu_type .= ',main';
    } 
}
if (!in_array("top", $arMapTopMenu)) {
    $map_top_menu_type .= ',top';
}
COption::SetOptionString("main", "map_top_menu_type", $map_top_menu_type);

$map_left_menu_type = str_replace(' ', '', COption::GetOptionString("main", "map_left_menu_type"));
$arMapLeftMenu = explode(',',$map_left_menu_type);
if (!in_array("left", $arMapLeftMenu)) {
    if(trim($map_left_menu_type) == ''){
        $map_left_menu_type .= 'left';
    } else {
        $map_left_menu_type .= ',left';
    }
}

COption::SetOptionString("main", "map_left_menu_type", $map_left_menu_type);
?>
