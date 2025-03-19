<?php
if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();

use \Bitrix\Main\Loader,
    \Bitrix\Iblock\SectionTable;

Loader::includeModule('iblock');


$rsSection = SectionTable::getList([
    'order' => ['SORT' => 'ASC'],
    'filter' => [
        'IBLOCK_ID' => $arParams['IBLOCK_ID'],
    ],
    'select' =>  ['ID','CODE','NAME'],
]);



while ($arSection=$rsSection->fetch())
{
    $arResult['SECTIONS'][$arSection['ID']] = $arSection;
}

foreach ($arResult['ITEMS'] as $key => $item) {
    if ($item['IBLOCK_SECTION_ID']) {
        if ($item['PROPERTIES']['position']['VALUE'] == 'Начальник отдела') {
            $arResult['SECTIONS'][$item['IBLOCK_SECTION_ID']]['first_item'] =  $item;
            $arResult['SECTIONS'][$item['IBLOCK_SECTION_ID']]['first_item_ttl'] =  $item['PROPERTIES']['position']['VALUE'];
        }
        if ($item['PROPERTIES']['position']['VALUE'] == 'Специалисты отдела') {
            $arResult['SECTIONS'][$item['IBLOCK_SECTION_ID']]['items'][] =  $item;
            $arResult['SECTIONS'][$item['IBLOCK_SECTION_ID']]['items_ttl'] =  $item['PROPERTIES']['position']['VALUE'];
        }
    } else {
        if ($item['PROPERTIES']['position']['VALUE'] == 'Руководитель аппарата') {
            $arResult['FIRST_SECTION']['first_item'] =  $item;
            $arResult['FIRST_SECTION']['first_item_ttl'] =  $item['PROPERTIES']['position']['VALUE'];
        }
        if ($item['PROPERTIES']['position']['VALUE'] == 'Советники Уполномоченного') {
            $arResult['FIRST_SECTION']['items'][] =  $item;
            $arResult['FIRST_SECTION']['items_ttl'] =  $item['PROPERTIES']['position']['VALUE'];
        }
    }
}
