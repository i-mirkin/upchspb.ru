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
$this->setFrameMode(true);?>
<?
    $reqSearch = htmlspecialchars($_REQUEST['q']);
?>
<div class="search-form">
<form action="<?=$arResult["FORM_ACTION"]?>" id="ya-site-form0" autocomplete="off">	
	<div class="ya-site-form__form">
		<div class="ya-site-form__search-input-layout-l"><?if($arParams["USE_SUGGEST"] === "Y"):?><?$APPLICATION->IncludeComponent(
			"bitrix:search.suggest.input",
			"",
			array(
				"NAME" => "q",
				"VALUE" => "",
				"INPUT_SIZE" => 15,
				"DROPDOWN_SIZE" => 10,
			),
			$component, array("HIDE_ICONS" => "Y")
		    );?><?else:?><input type="text" name="q" value="<?=$reqSearch ?: ''?>" class="ya-site-form__input-text" placeholder="<?= GetMessage('SEARCH_PLACEHOLDER')?>" /><?endif;?></div>
	
		<div class="ya-site-form__search-input-layout-r"><input name="s" type="submit" class="ya-site-form__submit" value="<?=GetMessage("BSF_T_SEARCH_BUTTON");?>" /></div>
	</div>
</form>
</div>