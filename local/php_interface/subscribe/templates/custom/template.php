<?
if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
global $SUBSCRIBE_TEMPLATE_RUBRIC;
$SUBSCRIBE_TEMPLATE_RUBRIC=$arRubric;
global $APPLICATION;
\Bitrix\Main\Loader::includeModule('iblock'); 
?>
<?
	$newsList = [];
	$arSelectNews = Array("ID", "NAME", "PREVIEW_TEXT", "DETAIL_PAGE_URL");
	$arFilterNews = Array("IBLOCK_ID"=>5, "ACTIVE"=>"Y", "PROPERTY_SEND_MAIL" => 30);
	$resNews = CIBlockElement::GetList(Array(), $arFilterNews, false, Array(), $arSelectNews);
	while($obNews = $resNews->GetNextElement())
	{
		$obNewsFields = $obNews->GetFields();
		$newsList[] = $obNewsFields;		
		CIBlockElement::SetPropertyValues($obNewsFields['ID'], 5, 31, 'SEND_MAIL');
	}
	$SUBSCRIBE_TEMPLATE_RESULT = $newsList;
	
	$CURRENT_PAGE = (CMain::IsHTTPS()) ? "https://" : "http://";
	$CURRENT_PAGE .= SITE_SERVER_NAME; 
?>

<?if(!empty($newsList)) { ?>
	<table align="center">
        <tbody><tr>
            <td>
                <table width="600">                    
                    <?if(file_exists($_SERVER['DOCUMENT_ROOT'] . '/local/php_interface/subscribe/include/header.php')) require_once($_SERVER['DOCUMENT_ROOT'] . '/local/php_interface/subscribe/include/header.php'); ?>
                    <tbody>
                    <tr>
                    	<td>
                    	<table width="600">
	                    	<tbody> 
		                    	<tr>
		                    		<td>		                    			
				                    	<?if($SUBSCRIBE_TEMPLATE_RUBRIC['DESCRIPTION']) echo $SUBSCRIBE_TEMPLATE_RUBRIC['DESCRIPTION'];?>
										<ul  style="list-style-type:none; padding: 0"> 
										<?foreach($newsList as $newsListEl) { ?>
										<li style="margin: 15px 0">  
											<strong><?=$newsListEl['NAME']?></strong>
											<p><?=$newsListEl['PREVIEW_TEXT']?></p>
											<a href="<?= $CURRENT_PAGE . $newsListEl['DETAIL_PAGE_URL']?>">Подробнее</a> 			
										</li>
										<?}?>
										</ul>
										<p  style="margin: 40px 0 0; font-size: 0.9em;">Если Вы хотите отказаться от получения новостей Уполномоченного по правам человека в Санкт-Петербурге, нажмите <a href="<?=$CURRENT_PAGE?>/subscribe/#UNSUBSCRIBE#">здесь</a></p> 
									</td> 
								</tr>
							</tbody>
						</table>
						</td>
					</tr>
                	</tbody>
            	</table>
            </td>
        </tr>
    </tbody></table>
<?}?>

<?

if($SUBSCRIBE_TEMPLATE_RESULT)
	return array(
		"SUBJECT"=>$SUBSCRIBE_TEMPLATE_RUBRIC["NAME"],
		"BODY_TYPE"=>"html",
		"CHARSET"=>"Windows-1251",
		"DIRECT_SEND"=>"Y",
		"AUTO_SEND_FLAG"=>"Y",   		
		"DO_NOT_SEND" => "Y", 
		"FROM_FIELD"=>$SUBSCRIBE_TEMPLATE_RUBRIC["FROM_FIELD"],
	);
else
	return false;
?>