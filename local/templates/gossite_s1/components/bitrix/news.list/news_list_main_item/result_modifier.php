<? 
$resItemsMain = $resItemsAdd = [];
if(!empty($arResult['ITEMS'])) {
foreach($arResult['ITEMS'] as $item) {
	switch($item['PROPERTIES']['THEME_STATUS']['VALUE_ENUM_ID']) {
		case 44:
			$resItemsMain[$item['ID']] = [
				'date' => $item['ACTIVE_FROM'],
				'item' => $item
			];
		break;
		case 45:
			$resItemsAdd[$item['ID']] = [
				'date' => $item['ACTIVE_FROM'],
				'item' => $item
			];
		break;
	}
}

function compare_func($a, $b)
{
    $t1 = strtotime($a["date"]);
    $t2 = strtotime($b["date"]);

    return ($t2 - $t1);
}

usort($resItemsMain, "compare_func");
usort($resItemsAdd, "compare_func");

if(!empty($resItemsMain)) $arResult['breakingNews'] = $resItemsMain[0]['item'];
if(!empty($resItemsAdd)) $arResult['mainNews'] = $resItemsAdd[0]['item'];

}