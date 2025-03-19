<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
$arOptionGosSite = $arParams["OPTION_SITE"];?>
<a role="button" data-toggle="collapse" href="#search-panel" aria-expanded="false" aria-controls="search-panel" ><i class="ion ion-ios-search" aria-hidden="true"></i></a>
<?if($arOptionGosSite["email"]):?>
<a href="mailto:<?=$arOptionGosSite["email"]?>"><i class="ion ion-ios-email-outline" aria-hidden="true"></i><span class="sr-only"><?=$arOptionGosSite["email"]?></span></a>
<?endif;?>
<a href="#special" class="special"><i class="ion ion-ios-eye-outline" aria-hidden="true"></i></a>
<a href="#top" class="upper"><i class="ion ion-ios-arrow-up" aria-hidden="true"></i></a>
