<?
die;
Loader::includeModule('bq.dev');
Loader::includeModule('iblock')

$arSelect = Array("ID");
$arFilter = Array("IBLOCK_ID" => array(9, 27));
$res = CIBlockElement::GetList(Array(), $arFilter, false, false, $arSelect);
//$res = CIBlockElement::GetList(Array(), $arFilter, false, array('iNumPage'=>0, 'nPageSize'=>100), $arSelect);

$arCompanyUser = array();
while ($ar_res = $res->GetNext())
{
	$id = $ar_res['ID'];
	$db_props = CIBlockElement::GetProperty(CIBlockElement::GetIBlockByID($id), $id, array("sort" => "asc"), Array("CODE"=>"COMPANY"));
	while($ar_props = $db_props->Fetch())
	{
		$arCompanyApplication[$id][] = $ar_props['VALUE'];
	}
}

foreach($arCompanyApplication as $app_id=>$app)
{
	foreach($app as $build)
	{
		$arFields = array(
			'APPLICATION_ID' => $app_id,
			'BUILD_ID' => $build,
			'STATUS_ID' => 4,
		);
	
		// get applacation status
		$params = array(
			'filter' => array('APPLICATION_ID' => $app_id, 'BUILD_ID' => $build),
			'select' => array('ID'),
		);
					
		$res = Bq\Dev\ApplicationTable::GetList($params);
		if ($ar = $res->fetch())
		{
			$result = Bq\Dev\ApplicationTable::Update($ar['ID'], $arFields);
			if (!$result->isSuccess()) 
			{
				$arResult['MESSAGE'] = "update error";
			}
			else
			{
				$arResult['ID'] = $id;
				$arResult['MESSAGE'] = "update success";
				$arResult['SUCCESS'] = "Y";
			}
		}
		else
		{
			$result = Bq\Dev\ApplicationTable::Add($arFields);
			if (!$result->isSuccess()) 
			{
				$arResult['MESSAGE'] = "add error";
			}
			else
			{
				$arResult['ID'] = $result->getId();
				$arResult['MESSAGE'] = "add success";
				$arResult['SUCCESS'] = "Y";
			}
		}
	}
}
?>