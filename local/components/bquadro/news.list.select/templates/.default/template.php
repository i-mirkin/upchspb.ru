<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
/** @var array $arParams */
/** @var array $arResult */
/** @global CMain $APPLICATION */
/** @global CUser $USER */
/** @global CDatabase $DB */
/** @var CBitrixComponentTemplate $this */
/** @var string $templateName */
/** @var string $templateFile */
/** @var string $templateFolder */
/** @var string $componentPath */
/** @var CBitrixComponent $component */
use Bitrix\Main\Localization\Loc;

$this->setFrameMode(true);
//dump($arResult["ITEMS"]);
?>

<?if($arParams["DISPLAY_TOP_PAGER"]):?>
<?=$arResult["NAV_STRING"]?>
<?endif;?>

<div class="lk-table">
	<table class="lk-table__table">
		<tr class="lk-table__table-head">
			<?//includeUncachedArea($this->GetFolder()."/include/head.php");?>
		</tr>
		
		<?foreach($arResult["ITEMS"] as $arItem):?>
		<?
		$this->AddEditAction($arItem['ID'], $arItem['EDIT_LINK'], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_EDIT"));
		$this->AddDeleteAction($arItem['ID'], $arItem['DELETE_LINK'], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_DELETE"), array("CONFIRM" => GetMessage('CT_BNL_ELEMENT_DELETE_CONFIRM')));

		//$phone = NormalizePhone((string)$arItem['DISPLAY_PROPERTIES']['phone']['DISPLAY_VALUE'], 10);
		$phone = $arItem['DISPLAY_PROPERTIES']['NORMALIZE_PHONE']['DISPLAY_VALUE'];
		$email = $arItem['DISPLAY_PROPERTIES']['EMAIL']['DISPLAY_VALUE'];
		if (isset($arResult['PRODUCT'][$arItem['PROPERTIES']['product']['VALUE']]))
		{
			$product = $arResult['PRODUCT'][$arItem['PROPERTIES']['product']['VALUE']];
		}

		$reviews_count = count($arResult['REVIEWS'][$arItem['ID']]);

		$objDateTime = new DateTime($arItem['DATE_CREATE']);
		?>

		<tr class="lk-table__table-row<?= !$reviews_count ? " empty-reviews" : ""?>" id="<?=$this->GetEditAreaId($arItem['ID']);?>" data-id="lk-table-item-<?= $arItem['ID']?>">
			<td data-label="Стоимость" class="lk-table__row lk-table__row--number">
				<div class="lk-table__item lk-table__item-number<?= (strlen($arItem['PROPERTIES']['PRICE_FULL']['VALUE']) > 0) ? "" : " not--bottom"?>" title="<?=GetMessage('CT_BNL_LOOK')?>">
					<a href="<?= $arItem['DETAIL_PAGE_URL']?>"><?= $arItem['ID']?></a>
				</div>
				<?if (strlen($arItem['PROPERTIES']['PRICE_FULL']['VALUE']) > 0):?>
					<div class="lk-table__item lk-table__sum"><?= catalog_price_format($arItem['PROPERTIES']['PRICE_FULL']['VALUE'], 'RUB')?></div>
				<?endif;?>
			</td>
			<td data-label="" class="lk-table__row lk-table__row--comments">
				<button data-href="lk-table-item-<?= $arItem['ID']?>" class="lk-btn--dot lk-show<?= !$reviews_count ? " empty-reviews" : ""?>"><?= $reviews_count?></button>
			</td>
			<td data-label="Дата" class="lk-table__row lk-table__row--date">
				<div class="lk-table__item lk-table__item-date"><?echo $objDateTime->format("d.m.Y");?></div>
			</td>
			<td data-label="Регион" class="lk-table__row lk-table__row--region<?= (!isset($arItem['DISPLAY_PROPERTIES']['REGION'])) ? " lk-table__table-row--hide" : ""?>">
				<?if (isset($arItem['DISPLAY_PROPERTIES']['REGION'])):?>
					<div class="lk-table__item lk-table__item-region"><?= $arItem['DISPLAY_PROPERTIES']['REGION']['DISPLAY_VALUE']?></div>
				<?endif;?>
			</td>
			<td data-label="Проект" class="lk-table__row lk-table__row--project
					<?= ($product 
						|| strlen($product["PROPERTIES"]["OTYPE"]["VALUE"]) > 0 
						|| strlen($arItem["PROPERTIES"]["OTYPE"]["VALUE"]) > 0
						|| strlen($product["PROPERTIES"]["AREA1"]["VALUE"]) > 0
						|| isset($arItem['DISPLAY_PROPERTIES']['material']) 
						|| isset($arItem['DISPLAY_PROPERTIES']['MATERIAL']))
						? "" : " lk-table__table-row--hide"?>
					">
				<?if ($product):?>
					<div class="lk-table__item lk-info__item-link" title="<?=GetMessage('CT_BNL_LOOK_PROJ')?>">
						<div class="lk-info__item-preview" >
							<div class="projects">
								<?
								global	$arWatermark,	$arWatermark2,	$arWatermark3;
								global	$FAVORITES;

								if	(!$product["PREVIEW_PICTURE"])
									$product["PREVIEW_PICTURE"]	=	$product["DETAIL_PICTURE"];
								if	(!$product["PREVIEW_PICTURE"])
									$product["PREVIEW_PICTURE"]	=	array("src"	=>	"/images/no_photo.png");
								else
									$product["PREVIEW_PICTURE"]	=	CFile::ResizeImageGet($product["PREVIEW_PICTURE"],	array("width"	=>	306,	"height"	=>	204),	BX_RESIZE_IMAGE_EXACT,	false,	array($arWatermark,	$arWatermark2, array("name" => "sharpen", "precision" => 25)), false, 50);

								$arStatusXML	=	$product["PROPERTIES"]["STATUS"]["VALUE_XML_ID"];

								$area	=	$product["PROPERTIES"]["AREA1"]["VALUE"]	!=	""	?	$product["PROPERTIES"]["AREA1"]["VALUE"]	:	"";
								$area	.=	($product["PROPERTIES"]["AREA1"]["VALUE"]	!=	""	&&	$product["PROPERTIES"]["AREA2"]["VALUE"]	!=	"")	?	"/"	:	"";
								$area	.=	$product["PROPERTIES"]["AREA2"]["VALUE"]	!=	""	?	$product["PROPERTIES"]["AREA2"]["VALUE"]	:	"";
								$area	=	$area	!=	""	?	$area	.	" м&#178;"	:	false;

								if	(in_array("project",	$product["PROPERTIES"]["PTYPE"]["VALUE_XML_ID"]))	{
									$product["PROPERTIES"]["PTYPE"]["VALUE_XML_ID"]	=	false;
									$product["PROPERTIES"]["PTYPE"]["VALUE"]	=	false;
								}

								$price_full	=	false;
								if	($product["PROPERTIES"]["PRICE_FULL"]["VALUE"])
									$price_full	=	catalog_price_format($product["PROPERTIES"]["PRICE_FULL"]["VALUE"]);
								if	($product["PROPERTIES"]["PRICE_CALC"]["VALUE_ENUM_ID"]	==	'222')
									$price_full	=	"~"	.	$price_full;

								$mat	=	false;
								$matArray	=	false;
								if	(is_array($product["PROPERTIES"]["MATERIAL"]["VALUE"])	&&	count($product["PROPERTIES"]["MATERIAL"]["VALUE"])	>	1)	{
									$price_max	=	0;
									foreach	($product["PROPERTIES"]["MATERIAL"]["VALUE"]	as	$k	=>	$val)	{
										$matArray[]	=	$arResult["MATERIAL"][$val]["UF_NAME"];
										if	($arResult["MATERIAL"][$val]["UF_PRICE"]	>	$price_max)
											$price_max	=	$arResult["MATERIAL"][$val]["UF_PRICE"];
									}
									if	($price_full	==	FALSE	&&	$product["PROPERTIES"]["AREA1"]["VALUE"])	{
										$price_full	=	"~"	.	catalog_price_format($price_max	*	$product["PROPERTIES"]["AREA1"]["VALUE"]);
									}
								}	elseif	(is_array($product["PROPERTIES"]["MATERIAL"]["VALUE"])	&&	count($product["PROPERTIES"]["MATERIAL"]["VALUE"])	==	1)	{
									$mat	=	$arResult["MATERIAL"][$product["PROPERTIES"]["MATERIAL"]["VALUE"][0]];
									if	($price_full	==	false	&&	$mat["UF_PRICE"]	>	0	&&	$product["PROPERTIES"]["AREA1"]["VALUE"]	>	0)	{
										$price_full	=	"~"	.	catalog_price_format($mat["UF_PRICE"]	*	$product["PROPERTIES"]["AREA1"]["VALUE"]);
									}
								}
								?>
								<div class="item_block">
									<a href="<?=	$product["DETAIL_PAGE_URL"]	?>" class="item" target="_blank">
										<div class="img b-rectangle b-cover ratio3-2" style="background-image:url(<?=	$product["PREVIEW_PICTURE"]["src"]	?>);">
											<div class="b-rectangle-content">
												<div class="item_bb_block">
													<?	if	(in_array("NEW",	$arStatusXML)):	?><span class="projects_new" title="Новинка">new</span><?	endif;	?>
													<?	if	(in_array("BEST",	$arStatusXML)):	?><span class="projects_best" title="Бестселлер">best</span><?	endif;	?>
													<?	if	(in_array("SALE",	$arStatusXML)):	?><span class="projects_discount" title="Участвует в акции">%</span><?	endif;	?>
												</div>
												<div class="item_img_bottom_line <?=	($product["PROPERTIES"]["PTYPE"]["VALUE"])	?	"b_type"	:	""	?> ">
													<?	if	($product["PROPERTIES"]["CODE"]["VALUE"]):	?><span class="projects_number"><?=	$product["PROPERTIES"]["CODE"]["VALUE"]	?></span><?	endif;	?>
													<?	if	($area):	?><span class="projects_area"><?=	$area	?></span><?	endif;	?>
													<?	if	($product["PROPERTIES"]["PTYPE"]["VALUE"]):	?><span class="projects_type"><?=	$product["PROPERTIES"]["PTYPE"]["VALUE"][0]	?></span><?	endif;	?>
												</div>
											</div>
										</div>
										<div class="bottom_block">
											<?	if	($product["PROPERTIES"]["BEDROOM"]["VALUE"]):	?><span class="var" title="Количество спален">спальн.<span><?=	$product["PROPERTIES"]["BEDROOM"]["VALUE"]	?></span></span><?	endif;	?>
											<?	if	($product["PROPERTIES"]["PROJECT_COUNT"]["VALUE"]	&&	(int)	$product["PROPERTIES"]["PROJECT_COUNT"]["VALUE"]	>	1):	?><span class="var" title="Варианты проекта">вар.<span><?=	$product["PROPERTIES"]["PROJECT_COUNT"]["VALUE"]	?></span></span><?	endif;	?>
											<?	if	($mat):	?><span class="var material" title="Материал стен: <?=	$mat["UF_NAME"];	?>">матер.<span><img alt="material" src="<?=	CFile::GetPath($mat["UF_FILE"]);	?>"></span></span><?	endif;	?>
											<?	if	($matArray):	?><span class="var material" title="Материал стен: <?=	implode(", ",	$matArray);	?>">матер.<span><img alt="material" src="/images/material_extra.png"></span></span><?	endif;	?>
											<?	if	($price_full):	?><span class="cost">
												<?
												$price_title = "";
												switch($product["PROPERTIES"]["PTYPE"]["VALUE_XML_ID"][0])
												{
													case "house_kit": 
													$price_title = "Стоимость<br/>домокомплекта";
													break;
													case "project_contract": 
													$price_title = "Стоимость<br/>строительства";
													break;
													default:
													$price_title = "Стоимость<br/>постройки";
													break;
												}
												?>
												<span class="cost_title"><?=htmlspecialcharsBack($price_title)?></span><span class="price"><?=	$price_full	?></span></span>
											<?	endif;	?>
											<div class="clear"></div>
										</div>
									</a>
								</div>
							</div>
						</div>
						<a href="<?= $product["DETAIL_PAGE_URL"]?>" target="_blank"><?= $product["PROPERTIES"]["CODE"]["VALUE"]?></a>
						<?if ($product["PROPERTIES"]["COMPANY_CODE"]["VALUE"] && !in_array(10, $product["PROPERTIES"]["PTYPE"]["VALUE_ENUM_ID"])):?>/&nbsp;<span class="lk-info__item-projectname"><?= $product["PROPERTIES"]["COMPANY_CODE"]["VALUE"]?></span><?endif;?>
					</div>
				<?endif;?>
				<?if (strlen($product["PROPERTIES"]["OTYPE"]["VALUE"]) > 0 || strlen($arItem["PROPERTIES"]["OTYPE"]["VALUE"]) > 0):?>
					<div class="lk-table__item lk-table__item-type"><?= $product["PROPERTIES"]["OTYPE"]["VALUE"] ?: $arItem["PROPERTIES"]["OTYPE"]["VALUE"]?></div>
				<?endif;?>
				<?if (strlen($product["PROPERTIES"]["AREA1"]["VALUE"]) > 0):?>
					<div class="lk-table__item lk-table__item-variant">S <?= $product["PROPERTIES"]["AREA1"]["VALUE"]?> м<sup>2</sup></div>
				<?endif;?>
				<?if (isset($arItem['DISPLAY_PROPERTIES']['material']) || isset($arItem['DISPLAY_PROPERTIES']['MATERIAL'])):?>
					<div class="lk-table__item lk-table__item-furnish"><?= ($arItem['DISPLAY_PROPERTIES']['material']['DISPLAY_VALUE'] ?: $arItem['DISPLAY_PROPERTIES']['MATERIAL']['DISPLAY_VALUE'])?></div>
				<?endif;?>
				<?/*?><div class="lk-table__item lk-table__item-equipment">Минимальная</div><?*/?>
			</td>
			<td data-label="Стоимость" class="lk-table__row lk-table__row--sum">
				<?if (strlen($arItem['PROPERTIES']['PRICE_FULL']['VALUE']) > 0):?>
				<div class="lk-table__item lk-table__item-sum"><?= catalog_price_format($arItem['PROPERTIES']['PRICE_FULL']['VALUE'], 'RUB')?></div>
				<?endif;?>
				<?if (isset($arItem['DISPLAY_PROPERTIES']['material']) || isset($arItem['DISPLAY_PROPERTIES']['MATERIAL'])):?>
				<div class="lk-table__item lk-table__item-furnish"><?= ($arItem['DISPLAY_PROPERTIES']['material']['DISPLAY_VALUE'] ?: $arItem['DISPLAY_PROPERTIES']['MATERIAL']['DISPLAY_VALUE'])?></div>
				<?endif;?>
				<?/*?><div class="lk-table__item lk-table__item-equipment">Минимальная</div><?*/?>
			</td>
			<td data-label="Контакты" class="lk-table__row lk-table__row--contacts">
				<div class="lk-table__item lk-table__item-name"><?= $arItem['NAME']?></div>
				<?if ($phone):?>
				<div class="lk-table__item lk-table__item-phone"><a href="tel:+<?= $phone?>">+<?= $phone?></a></div>
				<?endif;?>
				<?if ($email):?>
				<div class="lk-table__item lk-table__item-mail"><a href="mailto:<?= $email?>"><?= $email?></a></div>
				<?endif;?>
			</td>
			<td data-label="" class="lk-table__row lk-table__row--status">
				<div class="lk-status clearfix" title="<?=GetMessage('CT_BNL_STATUS')?>">
					<select class="lk-select-status" data-id="<?= $arItem['ID']?>" data-build_id="<?= $arParams['BUILD_ID']?>" data-active="<?= $arParams["IS_ACTIVE"]?>">
						<?$i = 0;?>
						<?foreach($arResult["STATUS"] as $propItem):?>
						<?$i ++?>
						<option 
						class="lk-status-<?=$i;?>" 
						value="<?= $propItem['UF_XML_ID']?>"
						<?if ($arResult['APPLICATION_STATUS'][$arItem['ID']]['STATUS_ID'] == $propItem['ID'] || (!$arResult['APPLICATION_STATUS'][$arItem['ID']] && $propItem['UF_DEF'])):?>selected<?endif;?>
						><?= $propItem['UF_SHORT_NAME']?></option>
						<?endforeach;?>
					</select>
					<div class="lk-table__item-btn">
						<button data-href="lk-table-item-<?= $arItem['ID']?>" class="lk-btn--dot lk-show<?= !$reviews_count ? " empty-reviews" : ""?>"><?= $reviews_count?></button>
					</div>
				</div>
			</td>
		</tr>

		<?if ($reviews_count):?>
		<tr class="lk-table__table-row lk-table__table-row--comments" data-id="lk-table-item-<?= $arItem['ID']?>">
			<td colspan="8" class="">
				<div class="lk-comm">
					<?$i = 0;?>
					<?foreach($arResult['REVIEWS'][$arItem['ID']] as $review):?>
					<?
								//if ($i == 2)
									//break;
					$date_active = $review['ACTIVE_FROM'];
					$site_format = CSite::GetDateFormat();
					$stmp = MakeTimeStamp($date_active, $site_format);
					?>
					<?if ($i == 1):?>
					<div data-id="lk-table-item-comm-<?= $arItem['ID']?>" class="lk-comm__allwrap">
						<?endif;?>
						<div class="lk-comm__wrap">
							<div class="lk-comm__info">
								<?if ($arResult['USERS'][$review['USER_ID']]['GUEST_NAME']):?>
								<span class="lk-comm__author"><?= $arResult['USERS'][$review['USER_ID']]['GUEST_NAME']?></span>
								<?endif;?>
								<?if ($stmp):?>
								<span class="lk-comm__date"><?= date('d.m.Y', $stmp)?></span>
								<span class="lk-comm__time"><?= date('H:i', $stmp)?></span>
								<?endif;?>
							</div>
							<div class="lk-comm__content">
								<?= $review['ANNOTATION']?>
							</div>
						</div>
						<?$i++;?>
						<?endforeach;?>

						<?if ($i > 1):?>
					</div>
					<?endif;?>

					<div class="lk-comments__actions-bottom">
						<button data-href="lk-table-item-<?= $arItem['ID']?>" class="lk-btn--dot lk-hide-comment">Скрыть все комментарии</button>
						<?if ($i > 1):?>
						<div class="lk-comments__btn-wrap">
							<button data-href="lk-table-item-comm-<?= $arItem['ID']?>" class="lk-btn--dot lk-show-comment">Показать еще</button>
							<span class="lk-show-comment--number"><?= ($i-1);?></span>
						</div>
						<?endif;?>
					</div>
				</div>
			</td>
		</tr>
		<?endif;?>
		<?endforeach;?>
	</table>

	<?if (!$arResult["ITEMS"]):?> 
	<p><?= Loc::getMessage("TH_TABLE_NOT_FOUND")?></p>
	<br><br><br><br>
	<?endif;?>
</div>

<div class="lk-info__item-projectname-alt"><div></div></div>

<?if($arParams["DISPLAY_BOTTOM_PAGER"]):?>
<?=$arResult["NAV_STRING"]?>
<?endif;?>