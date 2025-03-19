<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)
	die();
if(!CModule::IncludeModule("iblock"))
	return;

$iblockXMLFile = WIZARD_SERVICE_RELATIVE_PATH."/xml/".LANGUAGE_ID."/events.xml"; 
$iblockCode = "events_".WIZARD_SITE_ID; 
$iblockType = "news"; 

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
		"events",
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
            'ACTIVE' => array (
              'IS_REQUIRED' => 'Y',
              'DEFAULT_VALUE' => 'Y',
            ),
            'ACTIVE_FROM' => array (
              'IS_REQUIRED' => 'Y',
              'DEFAULT_VALUE' => '=now',
            ),
            'NAME' =>  array (
              'IS_REQUIRED' => 'Y',
              'DEFAULT_VALUE' => '',
            ),
            'PREVIEW_PICTURE' => array (
              'IS_REQUIRED' => 'N',
              'DEFAULT_VALUE' => array (
                'FROM_DETAIL' => 'Y',
                'SCALE' => 'Y',
                'WIDTH' => 750,
                'HEIGHT' => '',
                'IGNORE_ERRORS' => 'N',
                'METHOD' => 'resample',
                'COMPRESSION' => 95,
                'DELETE_WITH_DETAIL' => 'N',
                'UPDATE_WITH_DETAIL' => 'N',
                'USE_WATERMARK_TEXT' => 'N',
                'WATERMARK_TEXT' => '',
                'WATERMARK_TEXT_FONT' => '',
                'WATERMARK_TEXT_COLOR' => '',
                'WATERMARK_TEXT_SIZE' => '',
                'WATERMARK_TEXT_POSITION' => 'tl',
                'USE_WATERMARK_FILE' => 'N',
                'WATERMARK_FILE' => '',
                'WATERMARK_FILE_ALPHA' => '',
                'WATERMARK_FILE_POSITION' => 'tl',
                'WATERMARK_FILE_ORDER' => NULL,
              ),
            ),
            'PREVIEW_TEXT_TYPE' => array (
              'IS_REQUIRED' => 'Y',
              'DEFAULT_VALUE' => 'text',
            ),
            'PREVIEW_TEXT' => array (
              'IS_REQUIRED' => 'N',
              'DEFAULT_VALUE' => '',
            ),
            'DETAIL_PICTURE' => array (
              'IS_REQUIRED' => 'N',
              'DEFAULT_VALUE' => array (
                'SCALE' => 'Y',
                'WIDTH' => 1350,
                'HEIGHT' => '',
                'IGNORE_ERRORS' => 'N',
                'METHOD' => 'resample',
                'COMPRESSION' => 95,
                'USE_WATERMARK_TEXT' => 'N',
                'WATERMARK_TEXT' => '',
                'WATERMARK_TEXT_FONT' => '',
                'WATERMARK_TEXT_COLOR' => '',
                'WATERMARK_TEXT_SIZE' => '',
                'WATERMARK_TEXT_POSITION' => 'tl',
                'USE_WATERMARK_FILE' => 'N',
                'WATERMARK_FILE' => '',
                'WATERMARK_FILE_ALPHA' => '',
                'WATERMARK_FILE_POSITION' => 'tl',
                'WATERMARK_FILE_ORDER' => NULL,
              ),
            ),
            'DETAIL_TEXT_TYPE' => array (
              'IS_REQUIRED' => 'Y',
              'DEFAULT_VALUE' => 'html',
            ),
            'DETAIL_TEXT' => array (
              'IS_REQUIRED' => 'N',
              'DEFAULT_VALUE' => '',
            ),
            'XML_ID' =>  array (
              'IS_REQUIRED' => 'Y',
              'DEFAULT_VALUE' => '',
            ),
            'CODE' => array (
              'IS_REQUIRED' => 'N',
              'DEFAULT_VALUE' =>array (
                'UNIQUE' => 'Y',
                'TRANSLITERATION' => 'Y',
                'TRANS_LEN' => 100,
                'TRANS_CASE' => 'L',
                'TRANS_SPACE' => '-',
                'TRANS_OTHER' => '-',
                'TRANS_EAT' => 'Y',
                'USE_GOOGLE' => 'Y',
              ),
            ),
            'SECTION_NAME' => array (
              'IS_REQUIRED' => 'Y',
              'DEFAULT_VALUE' => '',
            ),
            'SECTION_DESCRIPTION_TYPE' => array (
              'IS_REQUIRED' => 'Y',
              'DEFAULT_VALUE' => 'text',
            ),
            'SECTION_DESCRIPTION' => array (
              'IS_REQUIRED' => 'N',
              'DEFAULT_VALUE' => '',
            ),
            'SECTION_CODE' => array (
              'IS_REQUIRED' => 'N',
              'DEFAULT_VALUE' => array (
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
CWizardUtil::ReplaceMacros(WIZARD_SITE_PATH."/information/events/index.php", array("EVENTS_IBLOCK_ID" => $iblockID));
CWizardUtil::ReplaceMacros(WIZARD_SITE_PATH."/include/events_calendar.php", array("EVENTS_IBLOCK_ID" => $iblockID));
?>
