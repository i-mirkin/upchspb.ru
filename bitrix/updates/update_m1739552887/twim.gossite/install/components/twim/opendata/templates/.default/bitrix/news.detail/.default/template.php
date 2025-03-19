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
if(!empty($arResult["ERROR"]))  ShowError($arResult["ERROR"]["FILE_META"], ".error");
// в кеш id паспорта, для статистики
$templateData["FILE_META_ID"] = $arResult["DISPLAY_PROPERTIES"]["META"]["FILE_VALUE"]["ID"];
?>
<div class="opendata">
    <h3><?=GetMessage("TITLE_PASPORT_OPENDATA")?></h3>
    <div class="opendata-list">
       <div class="table-responsive">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th class="title"><?=GetMessage("PARAMS_TEXT")?></th>
                        <th><?=GetMessage("PARAMS_VALUE_TEXT")?></th>
                    </tr>
                </thead>
                <?foreach ($arResult["FILE_META_ARRAY"] as $arItem):?>
                    <tr>
                        <td class="title"><?=GetMessage($arItem[0] . "_TEXT")?></td>
                        <td><?=($win === "Y") ? iconv('utf-8','windows-1251',$arItem[1]) : $arItem[1] ?></td>
                    </tr>
                <?endforeach;?>
                <?if(!empty($arResult["FILE_VERSION"])):?>
                    <tr>
                        <td class="title"><?= GetMessage("data_version_TEXT")?></td>
                        <td><?=implode(", ", $arResult["FILE_VERSION"]["DATA_FILES"]);?></td>
                    </tr>
                     <tr>
                        <td class="title"><?= GetMessage("structure_version_TEXT") ?></td>
                        <td><?=implode(", ", $arResult["FILE_VERSION"]["STRUCTURE_FILES"]);?></td>
                    </tr>
                <?endif;?>
            </table>
        </div>
    </div>     
</div>
