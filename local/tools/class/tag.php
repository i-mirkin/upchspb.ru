<?php
namespace Bquadro;

class Tag
{
	public static function Test()
	{
		die(__FILE__);
	}
	
	//Проверка урлов для каталога тегирование и элемент
	public static function resolveComponentEngine($engine, $pageCandidates, &$arVariables){die(__FILE__);

		/** @global CMain $APPLICATION */
		global $APPLICATION, $CACHE_MANAGER;
		static $aSearch = array("&lt;", "&gt;", "&quot;", "&#039;");
		static $aReplace = array("<", ">", "\"", "'");

		$component = $engine->getComponent();
		if ($component)
			$iblock_id = intval($component->arParams["IBLOCK_ID"]);
		else
			$iblock_id = 0;

		//To fix GetPagePath security hack for SMART_FILTER_PATH
		foreach ($pageCandidates as $pageID => $arVariablesTmp)
		{
			foreach ($arVariablesTmp as $variableName => $variableValue)
			{
				if ($variableName === "SMART_FILTER_PATH")
					$pageCandidates[$pageID][$variableName] = str_replace($aSearch, $aReplace, $variableValue);
			}
		}

		$requestURL = $APPLICATION->GetCurPage(true);

		$cacheId = $requestURL.implode("|", array_keys($pageCandidates))."|".SITE_ID."|".$iblock_id;
		$cache = new CPHPCache;
		if ($cache->StartDataCache(3600, $cacheId, "iblock_find"))
		{
			if (defined("BX_COMP_MANAGED_CACHE"))
			{
				$CACHE_MANAGER->StartTagCache("iblock_find");
				CIBlock::registerWithTagCache($iblock_id);
			}

			/* кастомный кусок начался */
			$SECTION_ID = CIBlockFindTools::GetSectionID(false, $arVariablesTmp["SECTION_CODE"], array('IBLOCK_ID' => $iblock_id));
			foreach ($pageCandidates as $pageID => $arVariablesTmp)
			{

				if ($pageID== "section_tag" && (!isset($arVariablesTmp["ELEMENT_ID"]) && !isset($arVariablesTmp["ELEMENT_CODE"]))){

					if ($arVariablesTmp["SECTION_CODE"] && $SECTION_ID = CIBlockFindTools::GetSectionID(false, $arVariablesTmp["SECTION_CODE"], array('IBLOCK_ID' => $iblock_id)))
					{
						global $DB;
						$arVariables = $arVariablesTmp;
						$arVariables["SECTION_ID"] = $SECTION_ID;
						//ищем теги
						$sql = "
							SELECT
									bq_tags_list.*
							FROM `bq_tags_list`
							WHERE
									`ACTIVE` = 'Y' AND
									`CODE` = '" . $arVariablesTmp["SECTION_TAG_CODE"] . "'	 AND
									`SECTION_ID` = '" . $arVariables["SECTION_ID"] . "'
							ORDER BY SORT ASC LIMIT 1";
						$res = $DB->Query($sql);
						if ($_tag = $res->GetNext()) {
							$_tag['FILTER_DATA'] = unserialize($_tag['~FILTER_DATA']);
							unset($_tag['~FILTER_DATA']);
							$arVariables["SECTION_TAG_ID"] = $_tag['ID'];
							$arVariables["SECTION_TAG_CODE"] = $_tag['CODE'];
							$arVariables["SECTION_TAG"] = $_tag;

							if (defined("BX_COMP_MANAGED_CACHE"))
							{
								$CACHE_MANAGER->RegisterTag("bq_tags");
								$CACHE_MANAGER->EndTagCache();
							}
							
							$cache->endDataCache(array($pageID, $arVariables));
							return $pageID;
						}
					}
				}
			}

			/* кастомный кусок закончился */

			foreach ($pageCandidates as $pageID => $arVariablesTmp)
			{
				if (
					$arVariablesTmp["SECTION_CODE_PATH"] != ""
					&& (isset($arVariablesTmp["ELEMENT_ID"]) || isset($arVariablesTmp["ELEMENT_CODE"]))
				)
				{
					if (CIBlockFindTools::checkElement($iblock_id, $arVariablesTmp))
					{
						$arVariables = $arVariablesTmp;
						if (defined("BX_COMP_MANAGED_CACHE"))
							$CACHE_MANAGER->EndTagCache();
						$cache->EndDataCache(array($pageID, $arVariablesTmp));
						return $pageID;
					}
				}
			}

			foreach ($pageCandidates as $pageID => $arVariablesTmp)
			{
				if (
					$arVariablesTmp["SECTION_CODE_PATH"] != ""
					&& (!isset($arVariablesTmp["ELEMENT_ID"]) && !isset($arVariablesTmp["ELEMENT_CODE"]))
				)
				{
					if (CIBlockFindTools::checkSection($iblock_id, $arVariablesTmp))
					{
						$arVariables = $arVariablesTmp;
						if (defined("BX_COMP_MANAGED_CACHE"))
							$CACHE_MANAGER->EndTagCache();
						$cache->EndDataCache(array($pageID, $arVariablesTmp));
						return $pageID;
					}
				}
			}

			if (defined("BX_COMP_MANAGED_CACHE"))
				$CACHE_MANAGER->AbortTagCache();
			$cache->AbortDataCache();
		}
		else
		{
			$vars = $cache->GetVars();
			$pageID = $vars[0];
			$arVariables = $vars[1];
			return $pageID;
		}

		reset($pageCandidates);
		list($pageID, $arVariables) = each($pageCandidates);

		return $pageID;
	}
}