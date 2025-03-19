<?if(!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED!==true)die();

use Bitrix\Main\Loader,
	Bitrix\Main\UserTable,
	Bitrix\Highloadblock as HL,
	Bitrix\Main\Entity;

Loader::includeModule('highloadblock');

//Материалы
$HLB_MATERIAL	=	2;

$hlblock	=	HL\HighloadBlockTable::getById($HLB_MATERIAL)->fetch();
$entity	=	HL\HighloadBlockTable::compileEntity($hlblock);
$main_query	=	new	Entity\Query($entity);
$main_query->setSelect(array('*'));
$result	=	$main_query->exec();
$result	=	new	CDBResult($result);

// build results
$rows	=	array();
while	($row	=	$result->Fetch())	{
		$row["ICO"]	=	CFile::GetByID($row["UF_FILE"]);
		$rows[$row["UF_XML_ID"]]	=	$row;
}
$arResult["MATERIAL"]	=	$rows;

// get projects
$arItemIds = $arIds = array();
foreach($arResult['ITEMS'] as $arItem)
{
	if (intval($arItem['PROPERTIES']['product']['VALUE']) > 0)
	{
		$arItemIds[] = $arItem['PROPERTIES']['product']['VALUE'];
		$iblockId = $arItem['PROPERTIES']['product']['LINK_IBLOCK_ID'];
	}
	$arIds[] = $arItem['ID'];
}

if (!empty($arItemIds) && $iblockId)
{
	$arFilter = Array('IBLOCK_ID'=>$iblockId, 'ID'=>array_unique($arItemIds));
	$res = CIBlockElement::GetList(Array(), $arFilter);
	while ($ob = $res->GetNextElement())
	{
		$arFields = $ob->GetFields();
		$arFields["PROPERTIES"] = $ob->GetProperties();
		$arResult['PRODUCT'][$arFields['ID']] = $arFields;
	}
}

if (Loader::includeModule('bq.dev'))
{
	// get status
	$params = array(
		'order'	=>	array('UF_SORT'	=>	'ASC'),
		'select' => array('*'),
		'cache' => array('ttl' => 3600),
	);
				
	$resStatus = Bq\Dev\ApplicationStatusTable::GetList($params);
	while ($ar = $resStatus->fetch())
	{
		$arResult['STATUS'][] = $ar;
	}
	
	if (!empty($arIds))
	{
		// get applacation status
		$params = array(
			'filter' => array('APPLICATION_ID' => $arIds, 'BUILD_ID' => $arParams['BUILD_ID']),
			'select' => array('*', 'STATUS.UF_XML_ID', 'STATUS.UF_NAME'),
			'cache' => array('ttl' => 3600),
		);
					
		$res = Bq\Dev\ApplicationTable::GetList($params);
		while ($ar = $res->fetch())
		{
			$arResult['APPLICATION_STATUS'][$ar['APPLICATION_ID']] = $ar;
		}	
	}	
}

// get reviews
if (!empty($arIds) && Loader::includeModule('api.reviews'))
{
	$arUserID = array();
	
	foreach($arIds as $id)
	{
		$arParams['REVIEWS_DISPLAY_FIELDS'] = array('ANNOTATION');
		
		$arSort = array(
			'ACTIVE_FROM' => 'DESC',
		);
		
		$arFilter = array(
			'=ACTIVE' => 'Y', 
			'=SITE_ID' => SITE_ID,
			'=ELEMENT_ID' => $id,
			'=SECTION_ID' => $arParams['BUILD_ID'],
		);
		
		$arBaseSelect = array(
			'ID',
			'ACTIVE_FROM',
			'DATE_CREATE',
			'USER_ID',
			'SITE_ID',
			'IBLOCK_ID',
			'SECTION_ID',
			'ELEMENT_ID',
		);
		$arDopSelect  = array_values($arParams['REVIEWS_DISPLAY_FIELDS']);
		$arSelect = array_merge($arBaseSelect, $arDopSelect);
		
		//Proccess data
		$rsReviews = Api\Reviews\ReviewsTable::getList(array(
			 'order'  => $arSort,
			 'filter' => $arFilter,
			 'select' => $arSelect,
			 "limit"  => 16,
			 'cache' => array('ttl'=>3600)
		));

		while($arItem = $rsReviews->fetch(new Api\Reviews\Converter))
		{

			foreach($arParams['REVIEWS_DISPLAY_FIELDS'] as $FIELD) {
				$arItem[ $FIELD ] = Api\Reviews\Converter::replace($arItem[ $FIELD ], array());
			}

			if(strlen($arItem['ACTIVE_FROM']) > 0)
				$arItem['DISPLAY_ACTIVE_FROM'] = Api\Reviews\Tools::formatDate($arParams['ACTIVE_DATE_FORMAT'], MakeTimeStamp($arItem['ACTIVE_FROM'], CSite::GetDateFormat()));
			else
				$arItem['DISPLAY_ACTIVE_FROM'] = '';


			//Shema.org (ISO 8601) format: 2016-06-12
			$arItem['DISPLAY_DATE_PUBLISHED'] = '';
			$date_published                   = $arItem['ACTIVE_FROM'];
			if(!$date_published) {
				$date_published = $arItem['DATE_CREATE'];
			}
			if($date_published) {
				$arItem['DISPLAY_DATE_PUBLISHED'] = Api\Reviews\Tools::formatDate('Y-m-d', MakeTimeStamp($date_published, CSite::GetDateFormat()));
			}

			//USER_ID
			if($arItem['USER_ID'])
				$arUserID[] = $arItem['USER_ID'];

			$arResult['REVIEWS'][$arItem['ELEMENT_ID']][] = $arItem;
		}
		unset($arItem);
	}

	//GET USERS INFO
	$arResult['USERS'] = array();
	if($arUserID = array_unique($arUserID)) {
		$rsUsers = UserTable::getList(array(
			 'filter' => array('=ID' => array_values($arUserID)),
			 'select' => array('ID', 'TITLE', 'NAME', 'LAST_NAME', 'SECOND_NAME', 'LOGIN', 'EMAIL', 'PERSONAL_PHONE', 'PERSONAL_PHOTO'),
		));

		$siteNameFormat = \CSite::GetNameFormat(false);
		while($arUser = $rsUsers->fetch()) {
			$arResult['USERS'][ $arUser['ID'] ] = array(
				 'ID'          => $arUser['ID'],
				 'PICTURE'     => $arUser['PERSONAL_PHOTO'],
				 'GUEST_NAME'  => \CUser::FormatName($siteNameFormat, $arUser, true, true),
				 'GUEST_EMAIL' => $arUser['EMAIL'],
				 'GUEST_PHONE' => $arUser['PERSONAL_PHONE'],
			);
		}
	}
	//\\GET USERS INFO
}