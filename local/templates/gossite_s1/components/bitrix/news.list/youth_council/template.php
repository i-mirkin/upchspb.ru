<?php if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
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
$this->setFrameMode(true);
// dump($arResult)
if($arResult['ITEMS']):?>
<p><?= $arResult['DESCRIPTION']?></p>
<div class="msovet">
    <?php foreach($arResult['ITEMS'] as $key => $item):?>
    <div class="msovet__item">
        <div class="msovet-item__img" style="background-image: url(<?= $item['PREVIEW_PICTURE']['SRC']?>)"></div>
        <div class="msovet-item__info">
            <div class="msovet-item__title"><?= $item['NAME']?></div>
            <?php if($item['PREVIEW_TEXT']):?>
                <div class="msovet-item__text"><?= $item['PREVIEW_TEXT']?></div>
            <?php endif;?>
        </div>
    </div>
    <?php endforeach;?>
</div>
<?php endif;?>