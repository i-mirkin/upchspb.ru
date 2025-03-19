<?
require($_SERVER['DOCUMENT_ROOT'].'/bitrix/header.php');

		$themeHoursList = [];
		$arSelectThemeHours = Array("ID", "NAME", "PROPERTY_DATE", "PROPERTY_HOURS", "PROPERTY_THEME", "PROPERTY_STATUS");
		$arFilterThemeHours = Array("IBLOCK_ID"=>41, "ACTIVE"=>"Y", "PROPERTY_STATUS"=>28);

		$resThemeHours = CIBlockElement::GetList(Array(), $arFilterThemeHours, false, Array(), $arSelectThemeHours);
		while($obThemeHours = $resThemeHours->GetNextElement())
		{			
			$arFieldsThemeHours = $obThemeHours->GetFields();						
			dump($arFieldsThemeHours);
		}

require($_SERVER['DOCUMENT_ROOT'].'/bitrix/footer.php');