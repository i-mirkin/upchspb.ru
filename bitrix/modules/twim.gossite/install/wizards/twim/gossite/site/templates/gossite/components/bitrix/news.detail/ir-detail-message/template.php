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
$this->setFrameMode(true);
if($arResult["CREATED_BY"] !== $arParams["USER_ID"]):
    Bitrix\Iblock\Component\Tools::process404(
        'Обращение не найдено', //Сообщение
        true, // Нужно ли определять 404-ю константу
        true, // Устанавливать ли статус
        false, // Показывать ли 404-ю страницу
        false // Ссылка на отличную от стандартной 404-ю
 );
else:?>
<div class="ir-message">
    <?if($arResult["DISPLAY_PROPERTIES"]["DATE"]["DISPLAY_VALUE"]):?>
        <b><?=$arResult["DISPLAY_PROPERTIES"]["DATE"]["NAME"]?>:</b>
        <?=$arResult["DISPLAY_PROPERTIES"]["DATE"]["DISPLAY_VALUE"]?>
        <br />
    <?endif;?>
    <?if($arResult["DISPLAY_PROPERTIES"]["E_MAIL_AUTHOR"]["DISPLAY_VALUE"]):?>
        <b><?=$arResult["DISPLAY_PROPERTIES"]["E_MAIL_AUTHOR"]["NAME"]?>:</b>
        <?=$arResult["DISPLAY_PROPERTIES"]["E_MAIL_AUTHOR"]["DISPLAY_VALUE"]?>
        <br />
    <?endif;?>    
    <?if($arResult["DISPLAY_PROPERTIES"]["PHONE_AUTHOR"]["DISPLAY_VALUE"]):?>
        <b><?=$arResult["DISPLAY_PROPERTIES"]["PHONE_AUTHOR"]["NAME"]?>:</b>
        <?=$arResult["DISPLAY_PROPERTIES"]["PHONE_AUTHOR"]["DISPLAY_VALUE"]?>
        <br />
    <?endif;?>  
    <?if($arResult["DISPLAY_PROPERTIES"]["STATUS"]["DISPLAY_VALUE"]):?>
        <b><?=$arResult["DISPLAY_PROPERTIES"]["STATUS"]["NAME"]?>:</b>
        <?=$arResult["DISPLAY_PROPERTIES"]["STATUS"]["DISPLAY_VALUE"]?>
        <br />
    <?endif;?>    
    <?if($arResult["DISPLAY_PROPERTIES"]["CATEGORY"]["DISPLAY_VALUE"]):?>
        <b><?=$arResult["DISPLAY_PROPERTIES"]["CATEGORY"]["NAME"]?>:</b>
        <?=$arResult["DISPLAY_PROPERTIES"]["CATEGORY"]["DISPLAY_VALUE"]?>
        <br />
    <?endif;?>     
    <?if($arResult["DISPLAY_PROPERTIES"]["AGENCY"]["DISPLAY_VALUE"]):?>
        <b><?=$arResult["DISPLAY_PROPERTIES"]["AGENCY"]["NAME"]?>:</b>
        <?=$arResult["DISPLAY_PROPERTIES"]["AGENCY"]["DISPLAY_VALUE"]?>
        <br />
    <?endif;?> 
    <?if($arResult["DISPLAY_PROPERTIES"]["COAUTHOR"]["DISPLAY_VALUE"]):?>
        <b><?=$arResult["DISPLAY_PROPERTIES"]["COAUTHOR"]["NAME"]?>:</b>
        <?=$arResult["DISPLAY_PROPERTIES"]["COAUTHOR"]["DISPLAY_VALUE"]?>
        <br />
    <?endif;?>
    <?if($arResult["DISPLAY_PROPERTIES"]["COMPANY_AUTHOR"]["DISPLAY_VALUE"]):?>
        <b><?=$arResult["DISPLAY_PROPERTIES"]["COMPANY_AUTHOR"]["NAME"]?>:</b>
        <?=$arResult["DISPLAY_PROPERTIES"]["COMPANY_AUTHOR"]["DISPLAY_VALUE"]?>
        <br />
    <?endif;?>    
    <?if($arResult["DISPLAY_PROPERTIES"]["FILE"]["DISPLAY_VALUE"]):?>
        <b><?=$arResult["DISPLAY_PROPERTIES"]["FILE"]["NAME"]?>:</b>
        <?if(is_array($arResult["DISPLAY_PROPERTIES"]["FILE"]["DISPLAY_VALUE"])):?>
            <?echo implode(", ", $arResult["DISPLAY_PROPERTIES"]["FILE"]["DISPLAY_VALUE"])?>
        <?else:?>
            <?=$arResult["DISPLAY_PROPERTIES"]["FILE"]["DISPLAY_VALUE"]?>
        <?endif;?>
        <br />
    <?endif;?>        
    <?if($arResult["DISPLAY_PROPERTIES"]["THEME"]["DISPLAY_VALUE"]):?>
        <b><?=$arResult["DISPLAY_PROPERTIES"]["THEME"]["NAME"]?>:</b>
        <?=$arResult["DISPLAY_PROPERTIES"]["THEME"]["DISPLAY_VALUE"]?>
        <br />
    <?endif;?>     
    <div>
        <?if($arResult["DISPLAY_PROPERTIES"]["MESSAGE"]["DISPLAY_VALUE"]):?>
            <b><?=getMessage("TEXT_MESSAGE_FEEDBACK_DESC")?>:</b> <br>
            <?=$arResult["DISPLAY_PROPERTIES"]["MESSAGE"]["DISPLAY_VALUE"]?>
            <br />
        <?endif;?>     
    </div>
    <div>   
        <?if($arResult["DISPLAY_PROPERTIES"]["ANSWER"]["DISPLAY_VALUE"]):?>
            <b><?=getMessage("TEXT_ANSWER_FEEDBACK_DESC")?>:</b> <br>
            <?=$arResult["DISPLAY_PROPERTIES"]["ANSWER"]["DISPLAY_VALUE"]?>
            <br />
        <?endif;?>     
    </div> 
</div>
<br>
<a href="<?=$arResult["LIST_PAGE_URL"]?>"><?=getMessage("LINK_BACK_DESC")?></a>
<?endif;?>