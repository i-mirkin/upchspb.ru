<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
?>
<div class="user-panel hidden-xs">
<?if($arResult["FORM_TYPE"] == "login"):?>
    <div class="user-panel__item">
        <a class="user-panel__link" href="<?=$arParams["LOGIN_URL"]?>&backurl=<?=$arResult["BACKURL"]?>">
            <i class="fa fa-sign-in user-panel__icon"></i>
            <?=getMessage("AUTH_LOGIN_BUTTON");?>
        </a>
    </div>
<?
else:
?>
    <div class="user-panel__item">
        <span class="user-panel__name"><?=$arResult["USER_NAME"]?></span>
        <span class="user-panel__login">(<?=$arResult["USER_LOGIN"]?>)</span>
    </div>
    <div class="user-panel__item">
        <a class="user-panel__link" href="<?=$arParams["LIST_URL"]?>">
            <i class="fa fa-list user-panel__icon"></i>
            <?=GetMessage("AUTH_LIST")?>
        </a>
    </div>
    <div class="user-panel__item">
        <a class="user-panel__link" href="<?=$arResult["PROFILE_URL"]?>" title="<?=GetMessage("AUTH_PROFILE")?>">
            <i class="fa fa-address-card-o user-panel__icon"></i>
            <?=GetMessage("AUTH_PROFILE")?>
        </a>
    </div>
    <div class="user-panel__item">
        <form action="<?=$arResult["AUTH_URL"]?>">
            <?foreach ($arResult["GET"] as $key => $value):?>
                <input type="hidden" name="<?=$key?>" value="<?=$value?>" />
            <?endforeach?>
            <input type="hidden" name="logout" value="yes" />
            <button class="user-panel__link" type="submit" name="logout_butt" value="<?=GetMessage("AUTH_LOGOUT_BUTTON")?>" >
                <i class="fa fa-sign-out user-panel__icon"></i>
                <?=GetMessage("AUTH_LOGOUT_BUTTON")?>
            </button>
        </form>
    </div>
<?endif?>
</div>