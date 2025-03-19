<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>
<div class="main-map-contacts hidden-print">
    <div class="loader"><div></div></div>
    <div id="ya-map-main" class="ya-map-main" data-title="<?=$arParams["TITLE"]?>" data-coord="[<?=$arParams["COORD_YA_MAP"]?>]"></div>
    <script type="text/javascript">
        var place_coord = "<?=json_encode($arResult["AREA_COORD"])?>";
    </script>
</div>