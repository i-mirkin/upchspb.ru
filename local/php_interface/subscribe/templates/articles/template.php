<?
if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
global $SUBSCRIBE_TEMPLATE_RUBRIC;
$SUBSCRIBE_TEMPLATE_RUBRIC=$arRubric;
global $APPLICATION;
\Bitrix\Main\Loader::includeModule('iblock');
?>
<p>Рассылка статей</p>

<?
	$articlesList = [];
	$arSelectArticles = Array("ID", "NAME", "PREVIEW_TEXT", "DETAIL_PAGE_URL");
	$arFilterArticles = Array("IBLOCK_ID"=>32, "ACTIVE"=>"Y", "PROPERTY_SEND_MAIL" => 32);
	$resArticles = CIBlockElement::GetList(Array(), $arFilterArticles, false, Array(), $arSelectArticles);
	while($obArticles = $resArticles->GetNextElement())
	{
		$obArticlesFields = $obArticles->GetFields();
		$articlesList[] = $obArticlesFields;		
		CIBlockElement::SetPropertyValues($obArticlesFields['ID'], 32, 33, 'SEND_MAIL');
	}
	$SUBSCRIBE_TEMPLATE_RESULT = $articlesList;
	
	$CURRENT_PAGE = (CMain::IsHTTPS()) ? "https://" : "http://";
	$CURRENT_PAGE .= SITE_SERVER_NAME;
?>

<?if(!empty($articlesList)) { ?>
	<ul style="list-style-type:none; padding: 0">
	<?foreach($articlesList as $articlesListEl) { ?>
		<li>
			<strong><?=$articlesListEl['NAME']?></strong>
			<p><?=$articlesListEl['PREVIEW_TEXT']?></p>
			<a href="<?= $CURRENT_PAGE . $articlesListEl['DETAIL_PAGE_URL']?>">Подробнее</a>			
		</li>
	<?}?>
	</ul>
<?}?>

<?

if($SUBSCRIBE_TEMPLATE_RESULT)
	return array(
		"SUBJECT"=>$SUBSCRIBE_TEMPLATE_RUBRIC["NAME"],
		"BODY_TYPE"=>"html",
		"CHARSET"=>"Windows-1251",
		"DIRECT_SEND"=>"Y",
		"FROM_FIELD"=>$SUBSCRIBE_TEMPLATE_RUBRIC["FROM_FIELD"],
	);
else
	return false;
?>