<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
if (!function_exists('revers_coords')) {
    function revers_coords($array){
		$new_array = array();
		foreach ($array as $item) {
			if(is_array($item)){
				$new_array[] = revers_coords($item);
			} else {
				$new_array = array_reverse($array);
				break;
			}
		}
		return $new_array;
	}
}
if (!function_exists('level_array')) { // level array
    function level_array($array){
		$level = 0;
        $v = current($array);
           while (is_array($v)) {
                $level++;
                $v = current($v);
        }
		return $level;
	}
}
// get coord area
if(SITE_CHARSET === "windows-1251") {
	$arParams["REGION_NAME"] = iconv('CP1251','UTF-8',$arParams["REGION_NAME"]);
}
$strQueryText = QueryGetData(
    "nominatim.openstreetmap.org", 80, "/", "format=json&polygon_geojson=1&q=" . urlencode($arParams["REGION_NAME"]), $error_number, $error_text
);
$area_param = json_decode($strQueryText);
$arResult["AREA_COORD"] = array(); // polygon coord
if(!empty($area_param)){
    foreach ($area_param as $arArea) {
        $arCord = $arArea->geojson->coordinates;
        $arResult["AREA_COORD"] = revers_coords($arCord);
        $level = level_array($arResult["AREA_COORD"]); // level only 3
        if($level > 3){
            $diff_level = $level - 3;
            for ($index = 0; $index < $diff_level; $index++) {
                $arResult["AREA_COORD"] = $arResult["AREA_COORD"][0];
            }  
        } elseif($level < 3){
            $diff_level = 3 - $level;
            for ($index = 0; $index < $diff_level; $index++) {
                $arResult["AREA_COORD"][0] = $arResult["AREA_COORD"];
            }  
        }
        break;   
    }
}

