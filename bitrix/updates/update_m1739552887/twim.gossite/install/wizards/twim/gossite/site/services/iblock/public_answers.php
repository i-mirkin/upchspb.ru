<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)
	die();
if(!CModule::IncludeModule("iblock"))
	return;

$iblockXMLFile = WIZARD_SERVICE_RELATIVE_PATH."/xml/".LANGUAGE_ID."/public_answers.xml"; 
$iblockCode = "public_answers_".WIZARD_SITE_ID; 
$iblockType = "internet_reception"; 

$rsIBlock = CIBlock::GetList(array(), array("CODE" => $iblockCode, "TYPE" => $iblockType));
$iblockID = false; 
if ($arIBlock = $rsIBlock->Fetch())
{
	$iblockID = $arIBlock["ID"]; 
	if (WIZARD_INSTALL_DEMO_DATA)
	{
		CIBlock::Delete($arIBlock["ID"]); 
		$iblockID = false; 
	}
}

if($iblockID == false)
{
	$permissions = Array(
			"1" => "X",
			"2" => "R"
		);
	$dbGroup = CGroup::GetList($by = "", $order = "", Array("STRING_ID" => "content_editor"));
	if($arGroup = $dbGroup -> Fetch())
	{
		$permissions[$arGroup["ID"]] = 'W';
	};
	$iblockID = WizardServices::ImportIBlockFromXML(
		$iblockXMLFile,
		$iblockCode,
		$iblockType,
		WIZARD_SITE_ID,
		$permissions
	);

	if ($iblockID < 1)
		return;
	
	//IBlock fields
	$iblock = new CIBlock;
	$arFields = Array(
		"ACTIVE" => "Y",
		"FIELDS" => array (
			'IBLOCK_SECTION' => 
			array (
			  'IS_REQUIRED' => 'N',
			  'DEFAULT_VALUE' => 
			  array (
				'KEEP_IBLOCK_SECTION_ID' => 'N',
			  ),
			),
			'ACTIVE' => 
			array (
			  'IS_REQUIRED' => 'Y',
			  'DEFAULT_VALUE' => NULL,
			),
			'ACTIVE_FROM' => 
			array (
			  'IS_REQUIRED' => 'N',
			  'DEFAULT_VALUE' => NULL,
			),
			'ACTIVE_TO' => 
			array (
			  'IS_REQUIRED' => 'N',
			  'DEFAULT_VALUE' => NULL,
			),
			'SORT' => 
			array (
			  'IS_REQUIRED' => 'N',
			  'DEFAULT_VALUE' => '0',
			),
			'NAME' => 
			array (
			  'IS_REQUIRED' => 'Y',
			  'DEFAULT_VALUE' => NULL,
			),
			'PREVIEW_PICTURE' => 
			array (
			  'IS_REQUIRED' => 'N',
			  'DEFAULT_VALUE' => 
			  array (
				'FROM_DETAIL' => 'N',
				'SCALE' => 'N',
				'WIDTH' => '',
				'HEIGHT' => '',
				'IGNORE_ERRORS' => 'N',
				'METHOD' => 'resample',
				'COMPRESSION' => 95,
				'DELETE_WITH_DETAIL' => 'N',
				'UPDATE_WITH_DETAIL' => 'N',
				'USE_WATERMARK_TEXT' => 'N',
				'WATERMARK_TEXT' => NULL,
				'WATERMARK_TEXT_FONT' => NULL,
				'WATERMARK_TEXT_COLOR' => NULL,
				'WATERMARK_TEXT_SIZE' => '',
				'WATERMARK_TEXT_POSITION' => NULL,
				'USE_WATERMARK_FILE' => 'N',
				'WATERMARK_FILE' => NULL,
				'WATERMARK_FILE_ALPHA' => '',
				'WATERMARK_FILE_POSITION' => NULL,
				'WATERMARK_FILE_ORDER' => NULL,
			  ),
			),
			'PREVIEW_TEXT_TYPE' => 
			array (
			  'IS_REQUIRED' => 'Y',
			  'DEFAULT_VALUE' => NULL,
			),
			'PREVIEW_TEXT' => 
			array (
			  'IS_REQUIRED' => 'N',
			  'DEFAULT_VALUE' => NULL,
			),
			'DETAIL_PICTURE' => 
			array (
			  'IS_REQUIRED' => 'N',
			  'DEFAULT_VALUE' => 
			  array (
				'SCALE' => 'N',
				'WIDTH' => '',
				'HEIGHT' => '',
				'IGNORE_ERRORS' => 'N',
				'METHOD' => 'resample',
				'COMPRESSION' => 95,
				'USE_WATERMARK_TEXT' => 'N',
				'WATERMARK_TEXT' => NULL,
				'WATERMARK_TEXT_FONT' => NULL,
				'WATERMARK_TEXT_COLOR' => NULL,
				'WATERMARK_TEXT_SIZE' => '',
				'WATERMARK_TEXT_POSITION' => NULL,
				'USE_WATERMARK_FILE' => 'N',
				'WATERMARK_FILE' => NULL,
				'WATERMARK_FILE_ALPHA' => '',
				'WATERMARK_FILE_POSITION' => NULL,
				'WATERMARK_FILE_ORDER' => NULL,
			  ),
			),
			'DETAIL_TEXT_TYPE' => 
			array (
			  'IS_REQUIRED' => 'Y',
			  'DEFAULT_VALUE' => NULL,
			),
			'DETAIL_TEXT' => 
			array (
			  'IS_REQUIRED' => 'N',
			  'DEFAULT_VALUE' => NULL,
			),
			'XML_ID' => 
			array (
			  'IS_REQUIRED' => 'Y',
			  'DEFAULT_VALUE' => NULL,
			),
			'CODE' => 
			array (
			  'IS_REQUIRED' => 'N',
			  'DEFAULT_VALUE' => 
			  array (
				'UNIQUE' => 'N',
				'TRANSLITERATION' => 'N',
				'TRANS_LEN' => 100,
				'TRANS_CASE' => 'L',
				'TRANS_SPACE' => '-',
				'TRANS_OTHER' => '-',
				'TRANS_EAT' => 'Y',
				'USE_GOOGLE' => 'N',
			  ),
			),
			'TAGS' => 
			array (
			  'IS_REQUIRED' => 'N',
			  'DEFAULT_VALUE' => NULL,
			),
			'SECTION_NAME' => 
			array (
			  'IS_REQUIRED' => 'Y',
			  'DEFAULT_VALUE' => NULL,
			),
			'SECTION_PICTURE' => 
			array (
			  'IS_REQUIRED' => 'N',
			  'DEFAULT_VALUE' => 
			  array (
				'FROM_DETAIL' => 'N',
				'SCALE' => 'N',
				'WIDTH' => '',
				'HEIGHT' => '',
				'IGNORE_ERRORS' => 'N',
				'METHOD' => 'resample',
				'COMPRESSION' => 95,
				'DELETE_WITH_DETAIL' => 'N',
				'UPDATE_WITH_DETAIL' => 'N',
				'USE_WATERMARK_TEXT' => 'N',
				'WATERMARK_TEXT' => NULL,
				'WATERMARK_TEXT_FONT' => NULL,
				'WATERMARK_TEXT_COLOR' => NULL,
				'WATERMARK_TEXT_SIZE' => '',
				'WATERMARK_TEXT_POSITION' => NULL,
				'USE_WATERMARK_FILE' => 'N',
				'WATERMARK_FILE' => NULL,
				'WATERMARK_FILE_ALPHA' => '',
				'WATERMARK_FILE_POSITION' => NULL,
				'WATERMARK_FILE_ORDER' => NULL,
			  ),
			),
			'SECTION_DESCRIPTION_TYPE' => 
			array (
			  'IS_REQUIRED' => 'Y',
			  'DEFAULT_VALUE' => NULL,
			),
			'SECTION_DESCRIPTION' => 
			array (
			  'IS_REQUIRED' => 'N',
			  'DEFAULT_VALUE' => NULL,
			),
			'SECTION_DETAIL_PICTURE' => 
			array (
			  'IS_REQUIRED' => 'N',
			  'DEFAULT_VALUE' => 
			  array (
				'SCALE' => 'N',
				'WIDTH' => '',
				'HEIGHT' => '',
				'IGNORE_ERRORS' => 'N',
				'METHOD' => 'resample',
				'COMPRESSION' => 95,
				'USE_WATERMARK_TEXT' => 'N',
				'WATERMARK_TEXT' => NULL,
				'WATERMARK_TEXT_FONT' => NULL,
				'WATERMARK_TEXT_COLOR' => NULL,
				'WATERMARK_TEXT_SIZE' => '',
				'WATERMARK_TEXT_POSITION' => NULL,
				'USE_WATERMARK_FILE' => 'N',
				'WATERMARK_FILE' => NULL,
				'WATERMARK_FILE_ALPHA' => '',
				'WATERMARK_FILE_POSITION' => NULL,
				'WATERMARK_FILE_ORDER' => NULL,
			  ),
			),
			'SECTION_XML_ID' => 
			array (
			  'IS_REQUIRED' => 'N',
			  'DEFAULT_VALUE' => NULL,
			),
			'SECTION_CODE' => 
			array (
			  'IS_REQUIRED' => 'N',
			  'DEFAULT_VALUE' => 
			  array (
				'UNIQUE' => 'N',
				'TRANSLITERATION' => 'N',
				'TRANS_LEN' => 100,
				'TRANS_CASE' => 'L',
				'TRANS_SPACE' => '-',
				'TRANS_OTHER' => '-',
				'TRANS_EAT' => 'Y',
				'USE_GOOGLE' => 'N',
			  ),
			),
			'LOG_SECTION_ADD' => 
			array (
			  'NAME' => 'LOG_SECTION_ADD',
			  'IS_REQUIRED' => 'N',
			  'DEFAULT_VALUE' => NULL,
			),
			'LOG_SECTION_EDIT' => 
			array (
			  'NAME' => 'LOG_SECTION_EDIT',
			  'IS_REQUIRED' => 'N',
			  'DEFAULT_VALUE' => NULL,
			),
			'LOG_SECTION_DELETE' => 
			array (
			  'NAME' => 'LOG_SECTION_DELETE',
			  'IS_REQUIRED' => 'N',
			  'DEFAULT_VALUE' => NULL,
			),
			'LOG_ELEMENT_ADD' => 
			array (
			  'NAME' => 'LOG_ELEMENT_ADD',
			  'IS_REQUIRED' => 'N',
			  'DEFAULT_VALUE' => NULL,
			),
			'LOG_ELEMENT_EDIT' => 
			array (
			  'NAME' => 'LOG_ELEMENT_EDIT',
			  'IS_REQUIRED' => 'N',
			  'DEFAULT_VALUE' => NULL,
			),
			'LOG_ELEMENT_DELETE' => 
			array (
			  'NAME' => 'LOG_ELEMENT_DELETE',
			  'IS_REQUIRED' => 'N',
			  'DEFAULT_VALUE' => NULL,
			),
			'XML_IMPORT_START_TIME' => 
			array (
			  'NAME' => 'XML_IMPORT_START_TIME',
			  'IS_REQUIRED' => 'N',
			  'DEFAULT_VALUE' => '2019-01-14 14:22:00',
			  'VISIBLE' => 'N',
			),
			'DETAIL_TEXT_TYPE_ALLOW_CHANGE' => 
			array (
			  'NAME' => 'DETAIL_TEXT_TYPE_ALLOW_CHANGE',
			  'IS_REQUIRED' => 'N',
			  'DEFAULT_VALUE' => 'Y',
			  'VISIBLE' => 'N',
			),
			'PREVIEW_TEXT_TYPE_ALLOW_CHANGE' => 
			array (
			  'NAME' => 'PREVIEW_TEXT_TYPE_ALLOW_CHANGE',
			  'IS_REQUIRED' => 'N',
			  'DEFAULT_VALUE' => 'Y',
			  'VISIBLE' => 'N',
			),
			'SECTION_DESCRIPTION_TYPE_ALLOW_CHANGE' => 
			array (
			  'NAME' => 'SECTION_DESCRIPTION_TYPE_ALLOW_CHANGE',
			  'IS_REQUIRED' => 'N',
			  'DEFAULT_VALUE' => 'Y',
			  'VISIBLE' => 'N',
			),
		  ), 
		"CODE" => $iblockCode, 
		"XML_ID" => $iblockCode,
		"NAME" => $iblock->GetArrayByID($iblockID, "NAME")
	);
	
	$iblock->Update($iblockID, $arFields);
}
else
{
	$arSites = array(); 
	$db_res = CIBlock::GetSite($iblockID);
	while ($res = $db_res->Fetch())
		$arSites[] = $res["LID"]; 
	if (!in_array(WIZARD_SITE_ID, $arSites))
	{
		$arSites[] = WIZARD_SITE_ID;
		$iblock = new CIBlock;
		$iblock->Update($iblockID, array("LID" => $arSites));
	}
}

CWizardUtil::ReplaceMacros(WIZARD_SITE_PATH."/appeals/internet-reception/public-answers/index.php", array("PUBLIC_ANSWERS_IBLOCK_ID" => $iblockID));
?>