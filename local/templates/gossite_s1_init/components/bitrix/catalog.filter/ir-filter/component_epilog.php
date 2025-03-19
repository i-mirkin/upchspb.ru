<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();
//конвертируем из формата сайта дату в формат БД для свойства дата, так как фильтр не умеет
global $DB;
$filterName = $arParams["FILTER_NAME"];
$site_format = CSite::GetDateFormat("SHORT");  
if(isset($GLOBALS[$filterName]["PROPERTY"]["?DATE_PUBLIC"])){
    $GLOBALS[$filterName]["PROPERTY"]["?DATE_PUBLIC"] =  $DB->FormatDate($GLOBALS[$filterName]["PROPERTY"]["?DATE_PUBLIC"], $site_format, "YYYY-MM-DD");  
}