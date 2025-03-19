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
?>
<form action="<?=$arResult["PATH"]?>" >
    <div class="form-group">
        <label><?=GetMessage("TWIM_UPLOAD_SELECT_ALBOM")?></label>
        <select name="album_id" class="form-control">
            <option value="0" selected="selected" disabled="disabled"><?=GetMessage("TWIM_UPLOAD_SELECT_ALBOM")?></option>
            <?foreach ($arResult["SECTIONS"] as $section) {?>
                <option value="<?=$section["ID"]?>"<?if($arResult["SECTION_ID"] == $section["ID"]):?> selected="selected" <?endif;?>><?=$section["NAME"]?></option>
            <?}?>
        </select>
    </div>
    <div class="form-group">
        <button type="submit" class="btn btn-info"><?=GetMessage("TWIM_UPLOAD_SELECT_DESC")?></button>
    </div>
</form>
<form action="<?=$arResult["PATH"]?>" method="POST">
     <?=bitrix_sessid_post()?>
     <div class="form-group">
        <label><?=GetMessage("TWIM_UPLOAD_CREATE_ALBOM")?></label>
        <input type="text" name="create_album" class="form-control" value="" placeholder="<?=GetMessage("TWIM_UPLOAD_NAME_ALBOM")?>"/>
    </div>
    <div class="form-group">
        <button type="submit" class="btn btn-info"><?=GetMessage("TWIM_UPLOAD_CREATE_DESC")?></button>
    </div>    
</form>
<?if($arResult["SECTION_ID"]):?>
<h3><?=$arResult["SECTION_NAME"]?> <small><?=GetMessage("TWIM_UPLOAD_UPLOAD_IMG_DESC")?></small></h3>
<br />
<div>
	<ul>
        <li><?=GetMessage("TWIM_UPLOAD_RIGTHS_FORMAT")?> <?=implode(', ', $arParams["FILE_EXT"])?></li>
		<li><?=GetMessage("TWIM_UPLOAD_RIGTHS_SIZE")?> <?=$arParams["FILE_SIZE_FORMAT"]?></li>
		<li><?=GetMessage("TWIM_UPLOAD_RIGTHS_COUNT", array("#COUNT#"=>$arParams["FILE_COUNT_MAX"]))?></li>
		<li><?=GetMessage("TWIM_UPLOAD_RIGTHS_UPLOAD_END")?></li>
	</ul>
</div>
<br />

<!-- Fine Uploader DOM Element
====================================================================== -->
<div id="fine-uploader-gallery"></div>
<br />
<a href="../" class="btn btn-info"><?=GetMessage("TWIM_UPLOAD_PHOTOGALLERY_NAME")?></a>
<!-- Your code to create an instance of Fine Uploader and bind to the DOM/template
====================================================================== -->
<script type="text/template" id="qq-template-gallery">
    <div class="qq-uploader-selector qq-uploader qq-gallery" qq-drop-area-text="<?=GetMessage("TWIM_UPLOAD_DRAG_AND_DROP")?>">
        <div class="qq-total-progress-bar-container-selector qq-total-progress-bar-container">
            <div role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100" class="qq-total-progress-bar-selector qq-progress-bar qq-total-progress-bar"></div>
        </div>
        <div class="qq-upload-drop-area-selector qq-upload-drop-area" qq-hide-dropzone>
            <span class="qq-upload-drop-area-text-selector"></span>
        </div>
        <div class="qq-upload-button-selector qq-upload-button">
            <div><?=GetMessage("TWIM_UPLOAD_SELECT_DESC")?></div>
        </div>
        <span class="qq-drop-processing-selector qq-drop-processing">
            <span><?=GetMessage("TWIM_UPLOAD_LOADING_DESC")?></span>
            <span class="qq-drop-processing-spinner-selector qq-drop-processing-spinner"></span>
        </span>
        <ul class="qq-upload-list-selector qq-upload-list" role="region" aria-live="polite" aria-relevant="additions removals">
            <li>
                <span role="status" class="qq-upload-status-text-selector qq-upload-status-text"></span>
                <div class="qq-progress-bar-container-selector qq-progress-bar-container">
                    <div role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100" class="qq-progress-bar-selector qq-progress-bar"></div>
                </div>
                <span class="qq-upload-spinner-selector qq-upload-spinner"></span>
                <div class="qq-thumbnail-wrapper">
                    <img class="qq-thumbnail-selector" qq-max-size="120" qq-server-scale>
                </div>
                <button type="button" class="qq-upload-cancel-selector qq-upload-cancel">X</button>
                <button type="button" class="qq-upload-retry-selector qq-upload-retry">
                    <span class="qq-btn qq-retry-icon" aria-label="Retry"></span>
                    <?=GetMessage("TWIM_UPLOAD_REPEAT_DESC")?>
                </button>

                <div class="qq-file-info">
                    <div class="qq-file-name">
                        <span class="qq-upload-file-selector qq-upload-file"></span>
                        <span class="qq-edit-filename-icon-selector qq-edit-filename-icon" aria-label="Edit filename"></span>
                    </div>
                    <input class="qq-edit-filename-selector qq-edit-filename" tabindex="0" type="text">
                    <span class="qq-upload-size-selector qq-upload-size"></span>
                    <button type="button" class="qq-btn qq-upload-delete-selector qq-upload-delete">
                        <span class="qq-btn qq-delete-icon" aria-label="Delete"></span>
                    </button>
                    <button type="button" class="qq-btn qq-upload-pause-selector qq-upload-pause">
                        <span class="qq-btn qq-pause-icon" aria-label="Pause"></span>
                    </button>
                    <button type="button" class="qq-btn qq-upload-continue-selector qq-upload-continue">
                        <span class="qq-btn qq-continue-icon" aria-label="Continue"></span>
                    </button>
                </div>
            </li>
        </ul>
        <dialog class="qq-alert-dialog-selector">
            <div class="qq-dialog-message-selector"></div>
            <div class="qq-dialog-buttons">
                <button type="button" class="qq-cancel-button-selector"><?=GetMessage("TWIM_UPLOAD_CLOSE_DESC")?></button>
            </div>
        </dialog>

        <dialog class="qq-confirm-dialog-selector">
            <div class="qq-dialog-message-selector"></div>
            <div class="qq-dialog-buttons">
                <button type="button" class="qq-cancel-button-selector"><?=GetMessage("TWIM_UPLOAD_DIALOG_NO")?></button>
                <button type="button" class="qq-ok-button-selector"><?=GetMessage("TWIM_UPLOAD_DIALOG_YES")?></button>
            </div>
        </dialog>

        <dialog class="qq-prompt-dialog-selector">
            <div class="qq-dialog-message-selector"></div>
            <input type="text">
            <div class="qq-dialog-buttons">
                <button type="button" class="qq-cancel-button-selector"><?=GetMessage("TWIM_UPLOAD_CLOSE_DESC")?></button>
                <button type="button" class="qq-ok-button-selector"><?=GetMessage("TWIM_UPLOAD_DIALOG_YES")?></button>
            </div>
        </dialog>
    </div>
</script>
<script>
   $('#fine-uploader-gallery').fineUploader({
       noFilesError: '<?=GetMessage("TWIM_UPLOAD_FILE_NOT_UPLOAD")?>',
       template: 'qq-template-gallery',
       request: {
           endpoint: '<?=$arResult["PATH"]?>',
           params: {
            album_id: <?=$arResult["SECTION_ID"]?>
           }
       },
       validation: {
            allowedExtensions: <?=json_encode($arParams["FILE_EXT"])?>,
            itemLimit: <?=$arParams["FILE_COUNT_MAX"]?> ,
            sizeLimit: <?=$arParams["FILE_SIZE"]?> 
       }
   });
</script>
<?endif;?>

