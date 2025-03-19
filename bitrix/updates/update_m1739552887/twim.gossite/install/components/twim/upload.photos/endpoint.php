<?php
define("NO_KEEP_STATISTIC", true); 
define('PUBLIC_AJAX_MODE', true);
define('STOP_STATISTICS', true);
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_before.php");
use Bitrix\Main\Loader;
Loader::includeModule("iblock");

require_once "handler.php";
$uploader = new UploadHandler();
// Specify the list of valid extensions, ex. array("jpeg", "xml", "bmp")
$uploader->allowedExtensions = array('jpeg', 'jpg', 'png'); // all files types allowed by default

// Specify max file size in bytes.
$uploader->sizeLimit = 5242880; // 1024 * 1024 * 5 default is 5 MiB

// Specify the input name set in the javascript.
$uploader->inputName = "qqfile"; // matches Fine Uploader's default inputName value by default

// If you want to use the chunking/resume feature, specify the folder to temporarily save parts.
$uploader->chunksFolder = "chunks";

$method = get_request_method();

// This will retrieve the "intended" request method.  Normally, this is the
// actual method of the request.  Sometimes, though, the intended request method
// must be hidden in the parameters of the request.  For example, when attempting to
// delete a file using a POST request. In that case, "DELETE" will be sent along with
// the request in a "_method" parameter.
function get_request_method() {
    global $HTTP_RAW_POST_DATA;

    if(isset($HTTP_RAW_POST_DATA)) {
    	parse_str($HTTP_RAW_POST_DATA, $_POST);
    }

    if (isset($_POST["_method"]) && $_POST["_method"] != null) {
        return $_POST["_method"];
    }

    return $_SERVER["REQUEST_METHOD"];
}

if ($method == "POST") {
    header("Content-Type: text/plain");

    // Assumes you have a chunking.success.endpoint set to point here with a query parameter of "done".
    // For example: /myserver/handlers/endpoint.php?done
    if (isset($_GET["done"])) {
        $result = $uploader->combineChunks("files");
    }
    // Handles upload requests
    else {
        // Call handleUpload() with the name of the folder, relative to PHP's getcwd()
        $result = $uploader->handleUpload("files");

        // To return a name used for uploaded file you can use the following line.
        $result["uploadName"] = $uploader->getUploadName();
        
        $el = new CIBlockElement;
        
        $dir = dirname(__FILE__) . "/files/" . $result["uuid"] . "/";
		
		$detail_picture =  $dir . $result["uploadName"];
		$path_file = pathinfo($detail_picture); 
        $arFile = CFile::MakeFileArray($detail_picture);

		$arLoadProductArray = Array(
		  "MODIFIED_BY"    => $USER->GetID(),
		  "IBLOCK_SECTION_ID" => $_POST["albom_id"],        
		  "IBLOCK_ID"      => P_GALLERY_IBLOCK_ID,
		  "NAME"           => $path_file["filename"], 
		  "ACTIVE"         => "Y",  
		  "PREVIEW_PICTURE"=> $arFile,
		  "DETAIL_PICTURE" => $arFile,
		  );

		if($PHOTO_ID = $el->Add($arLoadProductArray, true, false, true))
		  $result2["ID_ELEMENT"] =  "New photo id: ".$PHOTO_ID;
		else
		  $result2["ID_ELEMENT"] =  "Error: ".$el->LAST_ERROR;
        
		 $uploader->removeDir($dir); 
    }

    
    echo json_encode($result);
}
// for delete file requests
else if ($method == "DELETE") {
    $result = $uploader->handleDelete("files");
    echo json_encode($result);
}
else {
    header("HTTP/1.0 405 Method Not Allowed");
}
?>
