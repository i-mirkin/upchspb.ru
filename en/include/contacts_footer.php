<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
use Bitrix\Main\Localization\Loc;
Loc::loadMessages(__FILE__);
$arOptionGosSite = $arParams["OPTION_SITE"];?>
<ul class="nav nav-bottom-icon">
    <li role="presentation"><a href="javascript:void(0)" class="special"><i class="ion ion-ios-eye-outline" aria-hidden="true"></i><?=Loc::getMessage("CONTRAST_VERSION")?></a></li>
    <?if($arOptionGosSite["phone"]):?>
    <li role="presentation"><a href="callto:<?=$arOptionGosSite["phone"]?>"><i class="ion ion-ios-telephone-outline" aria-hidden="true"></i><?=$arOptionGosSite["phone"]?></a></li>
    <?endif;?>
    <?if($arOptionGosSite["email"]):?>
    <li role="presentation"><a href="mailto:<?=$arOptionGosSite["email"]?>"><i class="ion ion-ios-email-outline" aria-hidden="true"></i><?=$arOptionGosSite["email"]?></a></li>
    <?endif;?>
    <?if($arOptionGosSite["address"]):?>
    <li role="presentation"><span><i class="ion ion-ios-location-outline" aria-hidden="true"></i><?=$arOptionGosSite["address"]?></span></li>
    <?endif;?>
</ul>