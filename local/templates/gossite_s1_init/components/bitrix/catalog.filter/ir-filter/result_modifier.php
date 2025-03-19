<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();
// сохраняем id по коду свойства
foreach ($arResult["arrProp"] as $id => $arProps) {
    $arResult[$arProps["CODE"] . "_ID"] = "PROPERTY_" . $id;
}
