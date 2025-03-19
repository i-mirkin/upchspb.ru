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
?>

<div class="news-list-stuff news-list-stuff-d-none"> 

<?php if($arResult['FIRST_SECTION']):
    if($arResult['FIRST_SECTION']['first_item']):?>
    <h2><?= $arResult['FIRST_SECTION']['first_item_ttl']?>:</h2>
    <table>
        <tbody>
        <tr>
            <td>
                <img alt="<?= $arResult['FIRST_SECTION']['first_item']['NAME']?>" src="<?= $arResult['FIRST_SECTION']['first_item']['PREVIEW_PICTURE']['SRC']?>" title="<?= $arResult['FIRST_SECTION']['first_item']['NAME']?>" width="167" height="251"><br>
            </td>
        </tr>
        <tr>
            <td>
                <h3><?= $arResult['FIRST_SECTION']['first_item']['NAME']?></h3>
            </td>
        </tr>
        </tbody>
    </table>
<?php endif;
    if($arResult['FIRST_SECTION']['items']):?>
    <h2><?= $arResult['FIRST_SECTION']['items_ttl']?></h2>
    <?php $chunkItems = array_chunk($arResult['FIRST_SECTION']['items'], 2);?>
    <table>
        <tbody>
            <?php foreach($chunkItems as $key => $items):?>
                <tr>
                    <?php foreach($items as $keyItem => $item):?>
                        <td>
                            <img alt="<?= $item['NAME']?>" src="<?= $item['PREVIEW_PICTURE']['SRC']?>" title="<?= $item['NAME']?>" width="167" height="250"><br>
                        </td>
                    <?php endforeach;?>
                </tr>
                <tr>
                    <?php foreach($items as $keyItem => $item):?>
                        <td>
                            <h3><?= $item['NAME']?></h3>
                        </td>
                    <?php endforeach;?>
                </tr>
            <?php endforeach;?>
        </tbody>
    </table>
<?php endif;
endif;
if($arResult['SECTIONS']):
    foreach($arResult['SECTIONS'] as $idSec => $sec):?>
        <h1 class="text-center text-xs-left"><?= $sec['NAME']?></h1>
        <?php if($sec['first_item']):?>
        <h2><?= $sec['first_item_ttl']?></h2>
        <table>
            <tbody>
            <tr>
                <td>
                    <img alt="<?= $sec['first_item']['NAME']?>" src="<?= $sec['first_item']['PREVIEW_PICTURE']['SRC']?>" title="<?= $sec['first_item']['NAME']?>" width="167" height="250"><br>
                </td>
            </tr>
            <tr>
                <td>
                    <h3><?= $sec['first_item']['NAME']?></h3>
                </td>
            </tr>
            </tbody>
        </table>
        <?php endif;
        if($sec['items']):?>
        <h2><?= $sec['items_ttl']?></h2>
        <table>
            <tbody>
            <?php $chunkItems2 = array_chunk($sec['items'], 2);
                foreach($chunkItems2 as $key => $items):?>
                    <tr>
                        <?php foreach($items as $keyItem => $item):?>
                            <td>
                                <img alt="<?= $item['NAME']?>" src="<?= $item['PREVIEW_PICTURE']['SRC']?>" title="<?= $item['NAME']?>" width="167" height="250"><br>
                            </td>
                        <?php endforeach;?>
                    </tr>
                    <tr>
                        <?php foreach($items as $keyItem => $item):?>
                            <td>
                                <h3><?= $item['NAME']?></h3>
                            </td>
                        <?php endforeach;?>
                    </tr>
                <?php endforeach;?>
            </tbody>
        </table>
        <?php endif;
        endforeach;
endif;?>
</div>
