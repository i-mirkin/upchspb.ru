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
$this->setFrameMode(true);?>

<div class="event-calendar">
       
   <div id="datetimepicker-events" class="calendar-inline"></div>
                    
	<div class="list-events-main">
		<?foreach($arResult["ITEMS"] as $arItem):?>
			
			<div class="item" style="display:none;" data-date="<?=ConvertDateTime($arItem["ACTIVE_FROM"], "DD.MM.YYYY");?>">
				<?if($arParams["DISPLAY_DATE"]!="N" && $arItem["DISPLAY_ACTIVE_FROM"]):?>
					<p class="date"><?echo $arItem["DISPLAY_ACTIVE_FROM"]?></p>
				<?endif?>
				
			</div>
		<?endforeach;?>                            
	</div>
</div>
