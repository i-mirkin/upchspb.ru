<? if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();
use Bitrix\Main\Loader,
    Bitrix\Main\Context,
    Bitrix\Main\Page\Asset,
    Bitrix\Main\Data\Cache,
    Bitrix\Main\Web\Uri,
    Bitrix\Main\Application;
/** @global CMain $APPLICATION */
/** @global CUser $USER */
/** @global CDatabase $DB */
/** @var CBitrixComponent $this */
/** @var array $arParams */
/** @var array $arResult */
/** @var string $componentName */
/** @var string $componentPath */
/** @var string $componentTemplate */
/** @var string $parentComponentName */
/** @var string $parentComponentPath */
/** @var string $parentComponentTemplate */
require_once "handler.php";

if(!isset($arParams["CACHE_TIME"]))
	$arParams["CACHE_TIME"] = 36000000; 

if(empty($arParams["FILE_SIZE"]) || !is_numeric($arParams["FILE_SIZE"])){
    $arParams["FILE_SIZE"] = 20 * 1024 * 1024; // default 20 mb 
}
if(empty($arParams["FILE_EXT"])){
   $arParams["FILE_EXT"] = "jpg, png, jpeg, bmp"; // type files upload
}   
$arFileExtStr = explode(", ", $arParams["FILE_EXT"]); // ext files upload
$arFileExt = array_map(function($str){ return trim($str);}, $arFileExtStr);
$arParams["FILE_EXT"] = $arFileExt;

if(!is_numeric($arParams["FILE_COUNT_MAX"])){ // max files uplod
   $arParams["FILE_COUNT_MAX"] = 20;
}   

$arParams["IBLOCK_ID"] = trim($arParams["IBLOCK_ID"]);

$arParams["IBLOCK_TYPE"] = trim($arParams["IBLOCK_TYPE"]);
if(strlen($arParams["IBLOCK_TYPE"])<=0)
	$arParams["IBLOCK_TYPE"] = "media";
$arResult = array();
$context = Context::getCurrent();
$server = $context->getServer();
$asset = Asset::getInstance();
$request = $context->getRequest();
$docRoot = Application::getDocumentRoot();
$arResult["PATH"] = $APPLICATION->GetCurPage(false);
$cache = Cache::createInstance();  
if(!Loader::includeModule("iblock"))
{
    $cache->clean($this->GetCacheID(), "/".SITE_ID.$this->GetRelativePath());
    ShowError(GetMessage("IBLOCK_MODULE_NOT_INSTALLED"));
    return;
}
    
$method = get_request_method();
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

// upload file
$qquuid = $request->getPost("qquuid");
if ($method == "POST" && !empty($qquuid)) { // load image
    $upload_dir = $docRoot . "/upload/fine-uploader/files/";  // upload dir files
    $upload_chunk = $docRoot . "/upload/fine-uploader/chunks/"; // upload dir chunks
	if (!file_exists($upload_dir)) {
        $test = mkdir($upload_dir, 0777, true);
    } 
	if (!file_exists($upload_chunk)) {
        mkdir($upload_chunk, 0777, true);
    }
    $uploader = new UploadHandler();
    $uploader->allowedExtensions = $arParams["FILE_EXT"];
    $uploader->sizeLimit = $arParams["FILE_SIZE"]; 
    $uploader->inputName = "qqfile";
    $uploader->chunksFolder = $upload_chunk;
    header("Content-Type: text/plain");
    if (isset($_GET["done"])) {
        $arResult = $uploader->combineChunks($upload_chunk);
    }
    else {
        $arResult = $uploader->handleUpload($upload_dir);
        $arResult["uploadName"] = $uploader->getUploadName();  
        $el = new CIBlockElement;
        $dir = $upload_dir . $arResult["uuid"] . "/";
		$detail_picture =  $dir . $arResult["uploadName"];
		$path_file = pathinfo($detail_picture); 
        $arFile = CFile::MakeFileArray($detail_picture);
        $album_id = intval(trim($request->getPost("album_id")));
		$arLoadProductArray = Array(
            "MODIFIED_BY"    => $USER->GetID(),
            "IBLOCK_SECTION_ID" => $album_id,        
            "IBLOCK_ID"      => $arParams["IBLOCK_ID"],
            "NAME"           => $path_file["filename"], 
            "ACTIVE"         => "Y",  
            "PREVIEW_PICTURE"=> $arFile,
            "DETAIL_PICTURE" => $arFile,
		);
        // creat new element
		if($PHOTO_ID = $el->Add($arLoadProductArray, true, false, true))
		  $arResult["ID_ELEMENT"] =  "New photo id: ".$PHOTO_ID;
		else
		  $arResult["ID_ELEMENT"] =  "Error: ".$el->LAST_ERROR;
       
		$uploader->removeDir($dir); // remove temp dir
    }    
}
else if ($method == "DELETE") 
{ // delete action
    $arResult = $uploader->handleDelete("files");
} else { 
    // list album and create albom
    if ($cache->initCache($arParams["CACHE_TIME"], $this->GetCacheID(), "/".SITE_ID.$this->GetRelativePath()))
    {
        $arSection = $cache->getVars();
    }
    elseif ($cache->startDataCache())
    {
        if(is_numeric($arParams["IBLOCK_ID"]))
        {
            $rsIBlock = CIBlock::GetList(array(), array(
                "ACTIVE" => "Y",
                "ID" => $arParams["IBLOCK_ID"],
            ));
        }
        else
        {
            $rsIBlock = CIBlock::GetList(array(), array(
                "ACTIVE" => "Y",
                "CODE" => $arParams["IBLOCK_ID"],
                "SITE_ID" => SITE_ID,
            ));
        }
        if($arIblock = $rsIBlock->GetNext())
        {
            $arSection = array(); // album list
            $arFilter = Array('IBLOCK_ID'=>$arIblock["ID"], 'ACTIVE'=>'Y');
            $db_list = CIBlockSection::GetList(Array("SORT"=>"ASC"), $arFilter, false, array("ID", "NAME"), false);
            while($ar_result = $db_list->GetNext())
            {
              $arSection[$ar_result["ID"]] = $ar_result;
            }
        }
        $cache->endDataCache($arSection);
    } 

    $arResult["SECTIONS"] = $arSection;

    // select section
    $album_id = trim($request->getQuery("album_id"));
    if(is_numeric($album_id) && array_key_exists($album_id, $arResult["SECTIONS"])){
        if($arParams["USE_JQUERY"] == "Y"){$asset->addJs($componentPath .  "/fine-uploader/jquery-3.1.1.min.js");}
        $asset->addJs($componentPath .  "/fine-uploader/jquery.fine-uploader.js");
        $asset->addCss($componentPath . "/fine-uploader/fine-uploader-gallery.css");
        $arResult["SECTION_ID"] = intval($album_id);
        $arResult["SECTION_NAME"] = $arResult["SECTIONS"][$arResult["SECTION_ID"]]["NAME"];
    }

    // create album
    if(check_bitrix_sessid()){
        $name_albom = trim(strip_tags($request->getPost("create_album"))); 
        if(!empty($name_albom)){
            $bs = new CIBlockSection;
            $arFields = Array(
              "ACTIVE" => "Y",
              "IBLOCK_SECTION_ID" =>false,
              "IBLOCK_ID" => $arParams["IBLOCK_ID"],
              "NAME" => $name_albom,
              );
            $ID = $bs->Add($arFields);
            $res = ($ID>0);
            if(!$res) {
                $arResult["ERRORS"]["ADD_SECTION"] = $bs->LAST_ERROR;
            } else { 
                $cache->clean($this->GetCacheID(), "/".SITE_ID.$this->GetRelativePath());
                $uriString = $request->getRequestUri(); 
                $uri = new Uri($uriString); // new uri
                $uri->deleteParams(array("create_album"));
                $uri->addParams(array("album_id" => $ID));
                $redirect = $uri->getUri();
                LocalRedirect($redirect);
            }
        }
    }
}
if($method == "POST") // ajax json load
{  
    $APPLICATION->RestartBuffer();
    echo json_encode($arResult);
    die();
} else {
    $this->IncludeComponentTemplate();
} 
?>
