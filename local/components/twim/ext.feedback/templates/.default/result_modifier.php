<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
/**
 * format file size
 * @param int $size
 * @return string 
 */
function format_size_feedback_form($size) {
    $metrics[0] = getMessage("SIZE_FILE_DESC_BYTE");
    $metrics[1] = getMessage("SIZE_FILE_DESC_KILO");
    $metrics[2] = getMessage("SIZE_FILE_DESC_MEGA");
    $metrics[3] = getMessage("SIZE_FILE_DESC_GIGA");
    $metrics[4] = getMessage("SIZE_FILE_DESC_TERA");
    $metric = 0;
    while (floor($size / 1024) > 0) {
        $metric ++;
        $size /= 1024;
    }
    $result = round($size, 1) . " " .
            (isset($metrics[$metric]) ? $metrics[$metric] : '???' );
    return $result;
}
// форматирование размера файла
$arParams["FILE_SIZE"] = format_size_feedback_form($arParams["FILE_SIZE"]);
