<?
use Bitrix\Main\Loader,
    Bitrix\Main\Config\Option,
    Bitrix\Main\Localization\Loc,
    Bitrix\Main\Page\Asset,
    Bitrix\Main\Context;

Loc::loadMessages(__FILE__);

// перевод параметров

if (!Loader::includeModule(TWIM_GOSSITE_MODULE_ID) ){
    die('Module "'.TWIM_GOSSITE_MODULE_ID.'" not installed');
}

$request = Context::getCurrent()->getRequest();
$arPost = $request->getPostList()->toArray();

$GLOBALS["APPLICATION"]->SetAdditionalCSS("/bitrix/css/".TWIM_GOSSITE_MODULE_ID."/style.css");
Asset::getInstance()->addJs("/bitrix/js/".TWIM_GOSSITE_MODULE_ID."/script.js"); 

$arSitesParamDef = Option::getDefaults(TWIM_GOSSITE_MODULE_ID);

//Restore defaults
if ($_SERVER["REQUEST_METHOD"]=="POST" && strlen($RestoreDefaults)>0 && check_bitrix_sessid() &&  strlen($arPost["key_" . $arPost["tabControl_active_tab"]])>0) 
{
    $siteIdResetOption = $arPost["key_" . $arPost["tabControl_active_tab"]];
    Option::delete(TWIM_GOSSITE_MODULE_ID, array("site_id" => $siteIdResetOption));
    foreach($arSitesParamDef as $option => $value){
        Option::set(TWIM_GOSSITE_MODULE_ID, $option, $value, $siteIdResetOption);
    }
 
}
$arTabs = array();

$dbResult = \Bitrix\Main\SiteTable::getList(
	array(
		'filter' => array('ACTIVE' => 'Y')
	)
);
while($result = $dbResult->fetch()){
	$arSites[] = $result;
}
foreach($arSites as $key => $arSite){
    $arSitesParam = Option::getForModule(TWIM_GOSSITE_MODULE_ID, $arSite['LID']);
    //set default option
    foreach ($arSitesParamDef as $option => $value) {
        if(!isset($arSitesParam[$option])){
            $arSitesParam[$option] = $value;
        }
    }
    
	$arTabs[] = array(
		'DIV' => 'edit'.($key + 1),
		'TAB' => Loc::getMessage('GOSSITE_TAB_DESC', array('#SITE_NAME#' => $arSite['NAME'], '#LID#' => $arSite['LID'])),
		'TITLE' => Loc::getMessage('GOSSITE_TAB_TITLE'),
		'SITE_ID' => $arSite['LID'],
		'DIR' => $arSite['DIR'],
        'PARAMETRS' => $arSitesParam,
	);
}

$arTypeFiles = [
    "image/gif"     => "gif", 
    "image/jpeg"    => "jpg", 
    "image/png"     => "png", 
    "image/svg+xml" => "svg", 
];



//Save options
if(check_bitrix_sessid() && $_SERVER['REQUEST_METHOD'] === 'POST' && ($arPost['save'] || $arPost['apply'])){
    CheckDirPath($_SERVER["DOCUMENT_ROOT"].'/upload/'.TWIM_GOSSITE_MODULE_ID.'/');

    foreach($arTabs as $key => $site){
        $arSettings	= Array();
        foreach($arSitesParamDef as $option => $default_value){
			if (isset($arPost[$option."_".$site['SITE_ID']])){
				$arSettings[$option] = $arPost[$option."_".$site['SITE_ID']];
                $arTabs[$key]["PARAMETRS"][$option] = $arSettings[$option]; 
            }	
        }
      
        // gerb
        $fileImg = $request->getFile("img_gerb_".$site['SITE_ID']);
        if(isset($fileImg) && array_key_exists($fileImg["type"], $arTypeFiles)){
            $uploadfile = $_SERVER['DOCUMENT_ROOT'].'/upload/'.TWIM_GOSSITE_MODULE_ID.'/logo_' .$site['SITE_ID'] . '.' . $arTypeFiles[$fileImg["type"]];
            if (move_uploaded_file($fileImg["tmp_name"], $uploadfile)) {
                $arTabs[$key]["PARAMETRS"]["img_gerb"] = '/upload/'.TWIM_GOSSITE_MODULE_ID.'/logo_' .$site['SITE_ID'] . '.' . $arTypeFiles[$fileImg["type"]];
                $arSettings["img_gerb"] = $arTabs[$key]["PARAMETRS"]["img_gerb"];
            }
        }
        if(isset($arPost["img_gerb_delete_".$site['SITE_ID']])){
            $arSettings["img_gerb"] = "";
            $arTabs[$key]["PARAMETRS"]["img_gerb"] = "";
        }
        // boss
        $fileImg = $request->getFile("img_boss_".$site['SITE_ID']);
        if(isset($fileImg) && array_key_exists($fileImg["type"], $arTypeFiles)){
            $uploadfile = $_SERVER['DOCUMENT_ROOT'].'/upload/'.TWIM_GOSSITE_MODULE_ID.'/boss_' .$site['SITE_ID'] . '.' . $arTypeFiles[$fileImg["type"]];
            if (move_uploaded_file($fileImg["tmp_name"], $uploadfile)) {
                $arTabs[$key]["PARAMETRS"]["img_boss"] = '/upload/'.TWIM_GOSSITE_MODULE_ID.'/boss_' .$site['SITE_ID'] . '.' . $arTypeFiles[$fileImg["type"]];
                $arSettings["img_boss"] = $arTabs[$key]["PARAMETRS"]["img_boss"];
            }
        }
        if(isset($arPost["img_boss_delete_".$site['SITE_ID']])){
            $arSettings["img_boss"] = "";
            $arTabs[$key]["PARAMETRS"]["img_boss"] = "";
        }
		
        foreach($arSettings as $option => $value){
            Option::set(TWIM_GOSSITE_MODULE_ID, $option, $value, $site['SITE_ID']);
        }
	}	   
}

$tabControl = new CAdminTabControl("tabControl", $arTabs);
$tabControl->Begin();
?>
<script>
    BX.message({
        "twim.gossit_not_set_params" : "twim.gossit: <?=GetMessageJS("TWIM_GOSSITE_NE_USTANOVLENY_PARAM")?>",
        "twim.gossit_json_parse": "twim.gossit: <?=GetMessageJS("TWIM_GOSSITE_OSIBKA_CTENIA_DANNYH")?>",
        "twim.gossit_not_set_api_key": "twim.gossit: <?=GetMessageJS("TWIM_GOSSITE_NE_UKAZAN_KLUC_K")?>"
        });
</script>
<form name="twim_gossite_settings" method="post" enctype="multipart/form-data" action="<?echo $APPLICATION->GetCurPage()?>?mid=<?=htmlspecialcharsbx($mid)?>&amp;lang=<?echo LANG?>">
   <?=bitrix_sessid_post();?> 
    <?
	foreach($arTabs as $key => $arTab){
        $tabControl->BeginNextTab();
    ?>
    <tr class="">
        <td colspan="2">
        <input type="hidden" name="key_edit<?=$key+1?>" value="<?=$arTab["SITE_ID"]?>"/>
        </td>
    </tr>
    <tr class="heading">
        <td colspan="2"><?=GetMessage("TWIM_GOSSITE_OSNOVNYE_PARAMETRY")?></td>
    </tr>
    <tr>
        <td width="40%" class="field-name">
            E-mail <?=GetMessage("TWIM_GOSSITE_SAYTA")?></td>
        <td width="60%">
           <input name="email_<?=$arTab["SITE_ID"]?>" type="text" size="45" value="<?=$arTab["PARAMETRS"]["email"]?>"/>
        </td>
    </tr>
    <tr>
        <td width="40%" class="field-name">
            E-mail <?=GetMessage("TWIM_GOSSITE_DLA_VEB_FORM")?></td>
        <td width="60%">
           <input name="email_form_<?=$arTab["SITE_ID"]?>" type="text" size="45" value="<?=$arTab["PARAMETRS"]["email_form"]?>"/>
        </td>
    </tr>
	<tr>
        <td width="40%" class="field-name">
            <?=GetMessage("TWIM_GOSSITE_TELEFON_DLA_SVAZI")?></td>
        <td width="60%">
           <input name="phone_<?=$arTab["SITE_ID"]?>" type="text" size="45" value="<?=$arTab["PARAMETRS"]["phone"]?>"/>
        </td>
    </tr>
    <tr>
        <td width="40%" valign="top">
            <?=GetMessage("TWIM_GOSSITE_ADRES_ORGANIZACII")?></td>
        <td width="60%">
            <textarea name="address_<?=$arTab["SITE_ID"]?>" style="width:100%" rows="5"><?=$arTab["PARAMETRS"]["address"]?></textarea>
        </td>
    </tr>
    <tr>
        <td width="40%" class="field-name">
            <?=GetMessage("TWIM_GOSSITE_FIO_RUKOVODITELA")?></td>
        <td width="60%">
           <input name="fio_boss_<?=$arTab["SITE_ID"]?>" type="text" size="45" value="<?=$arTab["PARAMETRS"]["fio_boss"]?>"/>
        </td>
    </tr>
    <tr>
        <td width="40%" class="field-name">
            <?=GetMessage("TWIM_GOSSITE_DOLJNOSTQ_RUKOVODITE")?></td>
        <td width="60%">
           <input name="post_boss_<?=$arTab["SITE_ID"]?>" type="text" size="45" value="<?=$arTab["PARAMETRS"]["post_boss"]?>"/>
        </td>
    </tr>
    <tr>
        <td width="40%" class="field-name" valign="top">
            <?=GetMessage("TWIM_GOSSITE_FOTOGRAFIA_RUKOVODIT")?></td>
        <td width="60%">
           <input name="img_boss_<?=$arTab["SITE_ID"]?>" size="20" type="file" />
           <?if(!empty($arTab["PARAMETRS"]["img_boss"])):?>
                <img src="<?=$arTab["PARAMETRS"]["img_boss"]?>?v=<?=mktime()?>" style="display:block; max-width:200px; margin: 20px 0" alt=""> 
                <label>
                <input type="checkbox" name="img_boss_delete_<?=$arTab["SITE_ID"]?>" value="Y"> <?=GetMessage("TWIM_GOSSITE_UDALITQ_FOTOGRAFIU")?>
                </label>
                <input name="img_boss_<?=$arTab["SITE_ID"]?>" type="hidden" value="<?=$arTab["PARAMETRS"]["img_boss"]?>"/>
            <?endif;?>
        </td>
    </tr>
    <tr>
        <td width="40%" class="field-name" valign="top">
           <?=GetMessage("TWIM_GOSSITE_GERB")?></td>
        <td width="60%">
            <input name="img_gerb_<?=$arTab["SITE_ID"]?>" size="20" type="file" /> 
            <?if(!empty($arTab["PARAMETRS"]["img_gerb"])):?>
                <img src="<?=$arTab["PARAMETRS"]["img_gerb"]?>?v=<?=mktime()?>" style="display:block; max-width:200px; margin: 20px 0" alt=""> 
                <label>
                <input type="checkbox" name="img_gerb_delete_<?=$arTab["SITE_ID"]?>" value="Y"> <?=GetMessage("TWIM_GOSSITE_UDALITQ_GERB")?>
                </label>
                <input name="img_gerb_<?=$arTab["SITE_ID"]?>" type="hidden" value="<?=$arTab["PARAMETRS"]["img_gerb"]?>"/>
            <?endif;?>
        </td>
    </tr>
    <tr class="heading">
        <td colspan="2">
           API-<?=GetMessage("TWIM_GOSSITE_KLUC_DLA")?></td>
    </tr>
    <tr>
        <td width="40%" class="field-name">
            API-<?=GetMessage("TWIM_GOSSITE_KLUC")?></td>
        <td width="60%">
           <input name="api_map_key_ya_<?=$arTab["SITE_ID"]?>" size="20" type="text" value="<?=$arTab["PARAMETRS"]["api_map_key_ya"]?>"/>
        </td>
    </tr>
    <tr>
        <td colspan="2">
            <div class="adm-info-message-wrap" align="center">
                <div class="adm-info-message">
                    <?=GetMessage("TWIM_GOSSITE_REGISTRACIA_I_POLUCE")?><a href="https://developer.tech.yandex.ru/keys/" target="_blank">developer.tech.yandex.ru</a>, <?=GetMessage("TWIM_GOSSITE_USLUGA_PREDOSTAVLAET")?><br>
                    JS API <?=GetMessage("TWIM_GOSSITE_KART_I_GEOK")?></div>
            </div>
        </td>
    </tr>
    <?if(!empty($arTab["PARAMETRS"]["api_map_key_ya"])):?>
    <tr>
        <td width="40%" class="field-name">
            <?=GetMessage("TWIM_GOSSITE_KOORDINATY_NA_KARTE")?></td>
        <td width="60%">
            <input name="coord_ya_<?=$arTab["SITE_ID"]?>" type="text" size="45" value="<?=$arTab["PARAMETRS"]["coord_ya"]?>"/>
        </td>
    </tr>
    <tr>
        <td colspan="2">
            <div id="s-gossite-ya-map_<?=$arTab["SITE_ID"]?>" class="s-gossite-ya-map" data-map='<?=json_encode(["key" => $arTab["PARAMETRS"]["api_map_key_ya"], "site_id" => $arTab["SITE_ID"]])?>'></div>   
            <small class="s-gossite-helper"><?=GetMessage("TWIM_GOSSITE_ESLI_KARTA_NE_OTOBRA")?></small>
            <div class="adm-info-message-wrap" align="center">
                <div class="adm-info-message">
                    <?=GetMessage("TWIM_GOSSITE_VOSPOLQZUYTESQ_POISK")?>
                </div>
            </div>
        </td>
    </tr>
    <?endif;?>
    <tr class="heading">
        <td colspan="2"><?=GetMessage("TWIM_GOSSITE_VERSII_DLA_SLABOVIDA")?></td>
    </tr>
    <tr>
        <td width="40%" valign="top">
            <?=GetMessage("GOSSITE_SPEEK_SITTING_TITLE")?>:
        </td>
        <td width="60%">
            <label><input type="radio" name="type_voice_<?=$arTab["SITE_ID"]?>" value="ya" <?if($arTab["PARAMETRS"]["type_voice"] == "ya"):?>checked="checked"<?endif;?>> <?=GetMessage("GOSSITE_YA_TITLE")?></label> <br>
            <label><input type="radio" name="type_voice_<?=$arTab["SITE_ID"]?>"  value="rv" <?if($arTab["PARAMETRS"]["type_voice"] == "rv"):?>checked="checked"<?endif;?>> <?=GetMessage("GOSSITE_SPEEK_RES_VOIS_TITLE")?></label>
        </td>
    </tr>
    <tr class="type-item-voice type-item-voice__ya" <?if($arTab["PARAMETRS"]["type_voice"] != "ya"):?>style="display:none;"<?endif;?>>
        <td width="40%">  
            <?=GetMessage('GOSSITE_KEY_API');?>
        </td>
        <td width="60%">
            <input name="api_voice_key_ya_<?=$arTab["SITE_ID"]?>" type="text" size="45" value="<?=$arTab["PARAMETRS"]["api_voice_key_ya"];?>"/>
        </td>
    </tr>
    <tr class="type-item-voice type-item-voice__ya" <?if($arTab["PARAMETRS"]["type_voice"] != "ya"):?>style="display:none;"<?endif;?>>
        <td colspan="2">
            <div class="adm-info-message-wrap" align="center">
                <div class="adm-info-message">
                    <?=GetMessage("GOSSITE_YA_VOICE_DESC")?>
                </div>
            </div>
        </td>
    </tr>    
    <tr class="type-item-voice type-item-voice__rv" <?if($arTab["PARAMETRS"]["type_voice"] != "rv"):?>style="display:none;"<?endif;?>>
        <td colspan="2">
            <div class="adm-info-message-wrap" align="center">
                <div class="adm-info-message">
                    <?=GetMessage("GOSSITE_TITLE_RES_VOIS_DESC")?>
                </div>
            </div>
        </td>
    </tr>
    
	<?}?>
	<?$tabControl->Buttons(array());?>
    <input type="submit" name="RestoreDefaults" title="<?echo GetMessage("GOSSITE_RESTORE_DEFAULTS")?>" onclick="return confirm('<?echo AddSlashes(GetMessage("GOSSITE_RESTORE_DEFAULTS_HINT"))?>')" value="<?echo GetMessage("GOSSITE_RESTORE_DEFAULTS")?>">
	<?$tabControl->End();?>
</form>
 
