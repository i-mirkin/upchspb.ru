<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)
	die();
if(!CModule::IncludeModule("iblock"))
	return;

$iblockXMLFile = WIZARD_SERVICE_RELATIVE_PATH."/xml/".LANGUAGE_ID."/vopros.xml"; 
$iblockCode = "vopros_".WIZARD_SITE_ID; 
$iblockType = "vopros"; 

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
		"vopros",
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
            ),
            'ACTIVE_FROM' => 
            array (
              'IS_REQUIRED' => 'N',
            ),
            'ACTIVE_TO' => 
            array (
              'IS_REQUIRED' => 'N',
            ),
            'SORT' => 
            array (
              'IS_REQUIRED' => 'N',
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
            ),
            'PREVIEW_TEXT' => 
            array (
              'IS_REQUIRED' => 'N',
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
            ),
            'SECTION_DESCRIPTION' => 
            array (
              'IS_REQUIRED' => 'N',
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
global $USER_FIELD_MANAGER;
$USER_FIELD_MANAGER->Update('ASD_IBLOCK', $iblockID, array(
    'UF_SEND_MAIL_QUEST'  => 1
)); 
CWizardUtil::ReplaceMacros(WIZARD_SITE_PATH."/appeals/vopros-otvet/index.php", array("QUESTION_IBLOCK_ID" => $iblockID));
CWizardUtil::ReplaceMacros(WIZARD_SITE_PATH."/appeals/vopros-otvet/detail.php", array("QUESTION_IBLOCK_ID" => $iblockID));
CWizardUtil::ReplaceMacros(WIZARD_SITE_PATH."/appeals/vopros-otvet/question.php", array("QUESTION_IBLOCK_ID" => $iblockID));
?>
