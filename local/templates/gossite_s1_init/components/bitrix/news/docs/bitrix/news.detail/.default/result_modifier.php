<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();

/**
 * format file size
 * @param int $size
 * @return string 
 */
function format_size($size) {
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
/**
 * get icon by file
 * @param type $file
 * @return string
 */
function get_icon_file ($file) {
    $type = pathinfo($file, PATHINFO_EXTENSION);
    switch ($type) {
        case 'doc':
            $icon = 'fa fa-file-word-o';
            break;
        case 'docx':
            $icon = 'fa fa-file-word-o';
            break;
        case 'xls':
            $icon = 'fa fa-file-excel-o';
            break;
        case 'xlsx':
            $icon = 'fa fa-file-excel-o';
            break;
        case 'pdf':
            $icon = 'fa fa-file-pdf-o';
            break;
        case 'ppt':
            $icon = 'fa fa-file-powerpoint-o';
            break;
        case 'pptx':
            $icon = 'fa fa-file-powerpoint-o';
            break;
        case 'txt':
            $icon = 'fa fa-file-text-o';
            break;
        case 'jpg':
            $icon = 'fa fa-file-photo-o';
            break;
        case 'png':
            $icon = 'fa fa-file-photo-o';
            break;
        case 'jpeg':
            $icon = 'fa fa-file-photo-o';
            break;
        case 'gif':
            $icon = 'fa fa-file-photo-o';
            break; 	
        case 'rar':
            $icon = 'fa fa-file-archive-o';
            break;
        case 'zip':
            $icon = 'fa fa-file-archive-o';
            break; 	
        case '7z':
            $icon = 'fa fa-file-archive-o';
            break; 	
        default:
            $icon = 'fa fa-file-o';
            break;
    }  
    return $icon;
};
/**
 * get link viewer
 * @param type $file
 * @return type
 */
function get_service_viewer ($file) {
    $type = pathinfo($file, PATHINFO_EXTENSION);
    if(in_array($type, array("doc", "docx", "xls", "xlsx", "ppt", "pptx"))){
        $link = "https://view.officeapps.live.com/op/view.aspx?src=http://" . SITE_SERVER_NAME . $file;
    } else {
        $link = $file;
    }  
    return $link;
}

// формируем параметры для файлов, иконка, ссылка на просмотр, размер файла
$doc_count = count($arResult["DISPLAY_PROPERTIES"]["FILE"]["VALUE"]);
$arFiles = $arItem["DISPLAY_PROPERTIES"]["FILE"]["FILE_VALUE"];
if($doc_count > 1):
    foreach ($arFiles as $id => $file){
        $item = &$arResult["DISPLAY_PROPERTIES"]["FILE"]["FILE_VALUE"][$id];
        $item["FORMAT_SIZE"] = format_size($file["FILE_SIZE"]);  
        $item["LINK"] = get_service_viewer ($file["SRC"]);   
        $item["ICON"] = get_icon_file ($file["SRC"]);
    }
else:
    $item = &$arResult["DISPLAY_PROPERTIES"]["FILE"]["FILE_VALUE"];
    $item["FORMAT_SIZE"] = format_size($item["FILE_SIZE"]);    
    $item["LINK"] = get_service_viewer ($item["SRC"]);   
    $item["ICON"] = get_icon_file ($item["SRC"]);
endif;
