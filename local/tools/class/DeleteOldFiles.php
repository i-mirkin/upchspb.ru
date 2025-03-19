<?php

namespace Bquadro;
class DeleteOldFiles
{
    public static function Start() {
        if(\CModule::IncludeModule("iblock"))
        {
            $date = new \DateTime();
            $date->modify('-1 month');
            $date4Filter = $date->format('d.m.Y H:i:s'); // Получаем дату на месяц раньше текущей

            $arSelect = ["ID", "IBLOCK_ID", "NAME", "DATE_ACTIVE_FROM","PROPERTY_*"];
            $arFilter = ["IBLOCK_ID"=>34, "<DATE_ACTIVE_FROM" => $date4Filter, "!PROPERTY_FILE" => false]; // Фильтр - Получаем все элементы устаревшие более чем на месяц
            $res = \CIBlockElement::GetList(["DATE_ACTIVE_FROM" => "DESC"], $arFilter, false, [], $arSelect);

            while($ob = $res->GetNextElement()){
                $arProps = $ob->GetProperties();
                $arFields = $ob->GetFields();

                if (is_array($arProps['FILE']['VALUE'])) {
                    foreach ($arProps['FILE']['VALUE'] as $key => $fileId) {
                        if ($fileId) \CFile::Delete($fileId); // Удаляем файлы
                    }
                } else {
                    \CFile::Delete($arProps['FILE']['VALUE']);
                }

                \CIBlockElement::SetPropertyValuesEx($arFields['ID'], false, ['FILE' => false]);
            }
        }
        return "\Bquadro\DeleteOldFiles::Start();";
    }
}