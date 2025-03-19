<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)
	die();
if(!CModule::IncludeModule("iblock"))
	return;

$iblockXMLFile = WIZARD_SERVICE_RELATIVE_PATH."/xml/".LANGUAGE_ID."/staff.xml"; 
$iblockCode = "staff_".WIZARD_SITE_ID; 
$iblockType = "structure"; 

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
		"staff",
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
            'NAME' => array (
              'IS_REQUIRED' => 'Y',
              'DEFAULT_VALUE' => '',
            ),
            'PREVIEW_PICTURE' => array (
              'IS_REQUIRED' => 'N',
              'DEFAULT_VALUE' => array (
                'FROM_DETAIL' => 'N',
                'SCALE' => 'Y',
                'WIDTH' => 500,
                'HEIGHT' => 500,
              ),
            ),
            'PREVIEW_TEXT_TYPE' =>  array (
              'IS_REQUIRED' => 'Y',
              'DEFAULT_VALUE' => 'html',
            ),
            'DETAIL_TEXT_TYPE' => array (
              'IS_REQUIRED' => 'Y',
              'DEFAULT_VALUE' => 'text',
            ),
            'CODE' => array (
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
            'SECTION_NAME' => array (
              'IS_REQUIRED' => 'Y',
              'DEFAULT_VALUE' => '',
            ),
            'SECTION_CODE' => array (
              'IS_REQUIRED' => 'N',
              'DEFAULT_VALUE' =>  array (
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

CWizardUtil::ReplaceMacros(WIZARD_SITE_PATH."/administration/staff/index.php", array("STAFF_IBLOCK_ID" => $iblockID));
?>
