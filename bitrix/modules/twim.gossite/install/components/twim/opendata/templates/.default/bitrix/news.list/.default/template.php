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
$this->setFrameMode(true);
if(SITE_CHARSET === "windows-1251") {
	$win = "Y";
}
if(!empty($arResult["FILE_LIST_ARRAY"])):
// сохраняем в кеш параметры файла для скачки
$templateData["FILE_LIST"] = $arResult["FILE_LIST"];?>
    <div class="opendata">
        <?=getMessage("OPENDATA_DESC_LICENSE")?>
        <br>
        <h3 align="center"><?=getMessage("OPENDATA_DESC_TITLE_REESTR")?></h3>
        <div class="opendata-list">
            <div class="table-responsive">
                <table class="table table-bordered">
                    <?foreach($arResult["FILE_LIST_ARRAY"] as $arItem):?>
                        <tr>
                            <td class="title"><a href="<?=$arItem[0]?>/"><?=($win === "Y") ? iconv('utf-8','windows-1251',$arItem[1]) : $arItem[1] ?></a></td>
                            <td class="link"><a href="<?=$arItem[2]?>"><?=($win === "Y") ? iconv('utf-8','windows-1251',$arItem[3]) : $arItem[3] ?></a></td>
                        </tr>
                    <?endforeach;?>
                </table>
           </div>
        </div>
        <?if(is_array($arResult["FILE_LIST"])):?>
            <?=getMessage("OPENDATA_DESC_LINK_REESTR")?> - <a href="<?=$arResult["FILE_LIST"]["ORIGINAL_NAME"]?>"><?=$arResult["FILE_LIST"] ["extension"]?></a> <br />
        <?endif;?>
    </div>
<?endif;?>
