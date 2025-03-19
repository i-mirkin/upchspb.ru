<?php if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();

use Bitrix\Main\Page\Asset;

if ($arResult['ITEMS']) {
    Asset::getInstance()->addString('<script src="https://vk.com/js/api/openapi.js?169" type="text/javascript"></script>');
    Asset::getInstance()->addString('<script type="text/javascript">
    VK.init({
        apiId: ВАШ_API_ID,
        onlyWidgets: true
      });
</script>');
}
