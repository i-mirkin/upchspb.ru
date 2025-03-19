<?
if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();

if($arDefaultParams)
{
	foreach ($arDefaultParams as $param => $value)
	{
		$arParams[$param] = $arParams[$param] ? $arParams[$param] : $value;
	}
}

CModule::IncludeModule('iblock');
	
$arParams['IBLOCK_ID'] = intval($arParams['IBLOCK_ID']);

//$arParams['MAX_DEPTH'] = intval($arParams['MAX_DEPTH']);
//if ($arParams['MAX_DEPTH'] <= 0 || $arParams['MAX_DEPTH'] > 3) 
	$arParams['MAX_DEPTH'] = 3;

$arParams['USE_USER_LINK'] = $arParams['USE_USER_LINK'] == 'N' ? 'N' : 'Y';

$mode = isset($_REQUEST['mode']) ? $_REQUEST['mode'] : '';

//if ($mode != 'subtree')
//{
	if ($mode == 'subtree')
	{
		$arParams['LEVEL'] = intval($_REQUEST['level']);
		$SECTION_ID = intval($_REQUEST['section']);
		
		$dbRes = CIBlockSection::GetByID($SECTION_ID);
		$arCurrentSection = $dbRes->Fetch();
	}
	else
	{
		$arParams['LEVEL'] = 0;
	}


	if ($mode != 'subtree' || $arCurrentSection)
	{
		$arFilter = array(
			'IBLOCK_ID' => $arParams['IBLOCK_ID'], 
			'GLOBAL_ACTIVE' => 'Y',
		);

		if ($mode == 'subtree')
		{
			$arParams['MAX_DEPTH'] += $arCurrentSection['DEPTH_LEVEL']-1;
		
			$arFilter = array_merge($arFilter, array(
				'>LEFT_MARGIN' => $arCurrentSection['LEFT_MARGIN'],
				'<RIGHT_MARGIN' => $arCurrentSection['RIGHT_MARGIN'],
				'!ID' => $arCurrentSection['ID'], // little hack because of the iblock module minor bug
			));
		}
		
		$arFilter['<=DEPTH_LEVEL'] = $arParams['MAX_DEPTH'];
		
		$dbRes = CIBlockSection::GetList(
			array('left_margin' => "asc"),
			$arFilter,
			false,
			array('UF_LINK', "SECTION_PAGE_URL", "DESCRIPTION", "NAME", "DEPTH_LEVEL")
		);

		$arResult['ENTRIES'] = array();
		$arHeads = array();
		while ($arRes = $dbRes->GetNext())
		{
			if ($arParams['DETAIL_URL'])
				$arRes['DETAIL_URL'] = str_replace(array('#ID#', '#SECTION_ID#'), $arRes['ID'], $arParams['DETAIL_URL']);
				
			if ($arRes['PICTURE'])
			{
				$arRes['PICTURE'] = CGovernment::InitImage($arRes['PICTURE'], 50);
			}
			
			$arResult['ENTRIES'][$arRes['ID']] = $arRes;
			
		}
		
		if ($mode == 'subtree')
		{
			$APPLICATION->RestartBuffer();
			$arResult['__SKIP_ROOT'] = 'Y';
		}
		else
		{
			$APPLICATION->SetAdditionalCSS('/bitrix/themes/.default/pubstyles.css');
			$APPLICATION->AddHeadScript('/bitrix/js/main/utils.js');
			CAjax::Init();
		}
		
		$this->IncludeComponentTemplate();
	}
	
	if ($mode == 'subtree')
	{
		require_once($_SERVER["DOCUMENT_ROOT"].BX_ROOT."/modules/main/include/epilog_after.php");
		die();
	}
?>
