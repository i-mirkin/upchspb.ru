<?
if(!defined("B_PROLOG_INCLUDED")||B_PROLOG_INCLUDED!==true)die();
/**
 * Bitrix vars
 *
 * @var array $arParams
 * @var array $arResult
 * @var CBitrixComponentTemplate $this
 * @global CMain $APPLICATION
 * @global CUser $USER
 */
?>
<div class="ir-new-statement">
    <p>
        <?=GetMessage("IR_PERSONAL_DATA_DESC")?> 
    </p>
    <?if(!empty($arResult["ERROR_MESSAGE"])){?>
     <?ShowError(implode("<br>", $arResult["ERROR_MESSAGE"]));?>
    <?}?>
    <?if(strlen($arResult["OK_MESSAGE"]) > 0){?>
    <div class="ir-popup ir-popup_success">
        <div class="ir-popup__body">
            <h3 class="ir-title"><?=GetMessage('IR_TITLE_THANKS')?></h3>
            <p>
                <?=$arResult['OK_MESSAGE']?> <br>
                <?if(strlen($arResult["REG_MESSAGE"]) > 0){?>
                    <?=$arResult["REG_MESSAGE"]?>
                <?}?>       
            </p>
            <div>
                <a href="<?=$arResult["BACK_URL"]?>" class="ir-popup__close"><?=GetMessage('IR_BTN_LINK_BACK')?></a>
            </div>    
        </div>
    </div>
    <?}?>           
    <p><span class="require">*</span> <?=getMessage("IR_REQUARE_DESC");?></p>
    <form id="ir-feedback-form" class="ir-statement-form" action="<?=POST_FORM_ACTION_URI?>" method="POST" enctype="multipart/form-data">
        <?=bitrix_sessid_post()?>     
        <div class="form-group">
            <label><?=getMessage("IR_AGANCY");?>: <span class="require">*</span></label>
            <br>
            <?foreach ($arResult["FEILDS"]["agancy"] as $id => $arCategory):?>
                <div class="group-control">
                    <div class="wrap-label">
                        <label class="radio-button">
                            <input class="radio-button__input" 
                                type="radio" 
                                name="category_agancy" 
                                value="<?=$arCategory["ID"]?>" 
                                <?if($arCategory["SELECTED"] == "Y"):?>checked="checked"<?endif;?>
                                data-category="<?=$arCategory["ID"]?>"
                            >
                            <span class="radio-button__custom-input"><?=$arCategory["NAME"]?></span>
                        </label>
                    </div>
                    <?if(!empty($arCategory["ITEMS"])):?>
                    <div class="wrap-select<?if($arCategory["SELECTED"] !== "Y"):?> hidden<?endif;?>" data-category-toggle="<?=$arCategory["ID"]?>">
                        <select name="agancy" <?if($arCategory["SELECTED"] !== "Y"):?>disabled="disabled"<?endif;?> class="form-control">
                            <?foreach ($arCategory["ITEMS"] as $id => $arAgancy):?>
                            <option value="<?=$arAgancy["ID"]?>" <?if($arAgancy["SELECTED"] == "Y"):?>selected="selected"<?endif;?>><?=$arAgancy["NAME"]?></option>
                            <?endforeach;?>
                        </select>
                    </div>
                    <?endif;?>
                </div>
            <?endforeach;?>
        </div>
        <div class="form-group">
            <label><?=GetMessage("IR_THEME")?>:<?if(empty($arParams["REQUIRED_FIELDS"]) || in_array("THEME", $arParams["REQUIRED_FIELDS"])):?><span class="require">*</span><?endif?></label>
            <br>
            <input type="text" name="theme"  class="form-control" value="<?=$arResult["FEILDS"]["theme"]?>" />
        </div>
        <div class="form-group">
            <label><?=GetMessage("IR_SURNAME")?>:<?if(empty($arParams["REQUIRED_FIELDS"]) || in_array("SURNAME", $arParams["REQUIRED_FIELDS"])):?><span class="require">*</span><?endif?></label>
            <br>
            <input type="text" name="user_surname" class="form-control" value="<?=$arResult["FEILDS"]["user_surname"]?>">
        </div>
        <div class="form-group">
            <label><?=GetMessage("IR_NAME")?>:<?if(empty($arParams["REQUIRED_FIELDS"]) || in_array("NAME", $arParams["REQUIRED_FIELDS"])):?><span class="require">*</span><?endif?></label>
            <br>
            <input type="text" name="user_name" class="form-control" value="<?=$arResult["FEILDS"]["user_name"]?>">
        </div>
        <div class="form-group">
            <label><?=GetMessage("IR_SECOND_NAME")?>:<?if(empty($arParams["REQUIRED_FIELDS"]) || in_array("SECOND_NAME", $arParams["REQUIRED_FIELDS"])):?><span class="require">*</span><?endif?></label>
            <br>
            <input id="in-second-name" type="text" name="user_second_name" class="form-control" value="<?=$arResult["FEILDS"]["user_second_name"]?>" <?if($arResult["FEILDS"]["disabled_user_second_name"] == "Y"):?>disabled="disabled"<?endif?>>
        </div>
        <p>
            <label class="checkbox-button">
                <input class="checkbox-button__input" type="checkbox" name="disabled_user_second_name" value="y" data-disabled-input="#in-second-name" <?if($arResult["FEILDS"]["disabled_user_second_name"] == "Y"):?>checked="checked"<?endif?>>
                <span class="checkbox-button__custom-input"><?=GetMessage("IR_DIS_SECOND_NAME")?></span>
            </label>
        </p>
        <div class="form-group">
            <label><?=GetMessage("IR_USER_COMPANY")?>:<?if(empty($arParams["REQUIRED_FIELDS"]) || in_array("COMPANY", $arParams["REQUIRED_FIELDS"])):?><span class="require">*</span><?endif?></label>
            <br>
            <input type="text" name="user_company" class="form-control" value="<?=$arResult["FEILDS"]["user_company"]?>">
        </div>
        <div class="form-group">
            <label><?=GetMessage("IR_EMAIL")?>:<?if(empty($arParams["REQUIRED_FIELDS"]) || in_array("EMAIL", $arParams["REQUIRED_FIELDS"])):?><span class="require">*</span><?endif?></label>
            <br>
            <input type="text" name="user_email" class="form-control" value="<?=$arResult["FEILDS"]["user_email"]?>">
        </div>
        <div class="form-group">
            <label><?=GetMessage("IR_PHONE")?>:<?if(empty($arParams["REQUIRED_FIELDS"]) || in_array("PHONE", $arParams["REQUIRED_FIELDS"])):?><span class="require">*</span><?endif?></label>
            <br>
            <input type="text" name="user_phone" class="form-control" value="<?=$arResult["FEILDS"]["user_phone"]?>">
        </div>
        
        <?if ($arParams['COLLECTIVE_APPEAL'] == 'Y'):?>
        <h3 class="ir-title"><?=getMessage("IR_COUATHOR_DESC")?>:</h3>
        <div class="ir-coauthors-include">
            <?foreach ($arResult["FEILDS"]["coauthors"] as $key => $arCoauthor):?>
            <div id="ir-coauthor-<?=$key?>" class="ir-coauthor">
                <div class="ir-coauthor__wrap-close">
                    <button type="button" class="btn btn-info btm-sm ir-coauthor_btn"><i class="fa fa-times"></i></button>
                </div>
                <div class="form-group">
                    <label><?=GetMessage("IR_NAME")?>:<span class="require">*</span></label>
                    <br>
                    <input type="text" class="form-control" name="coauthor_name[]" value="<?=$arCoauthor["coauthor_name"]?>"/>
                </div>
                <div class="form-group">
                    <label><?=GetMessage("IR_SURNAME")?>:<span class="require">*</span></label>
                    <br>
                    <input type="text" class="form-control" name="coauthor_surname[]" value="<?=$arCoauthor["coauthor_surname"]?>"/>
                </div>
                <div class="form-group">
                    <label><?=GetMessage("IR_SECOND_NAME")?>:</label>
                    <br>
                    <input type="text" class="form-control" name="coauthor_second_name[]" value="<?=$arCoauthor["coauthor_second_name"]?>" />
                </div>
                <div class="form-group">
                    <label><?=GetMessage("IR_EMAIL_COAUTHOR")?>:<span class="require">*</span></label>
                    <br>
                    <input type="text" class="form-control" name="coauthor_email[]" value="<?=$arCoauthor["coauthor_email"]?>" />
                </div>
            </div><!--.ir-coauthor--> 
            <?endforeach;?>
        </div><!--.ir-coauthors-include-->
        <div class="form-group">
            <button id="add-coauthor" type="button" class="btn btn-icon btn-info">
                <span class="btn-icon__icon">
                    <i class="fa fa-user-plus"></i>
                </span>
                <?=GetMessage("IR_BTN_ADD_COUATHOR_DESC")?>
            </button>
        </div>
        <?endif?>
        <div class="info">
            <?=GetMessage("IR_TEXT_MESSAGE_DESC")?>
        </div>
        <label><?=GetMessage("IR_MESSAGE")?>:<?if(empty($arParams["REQUIRED_FIELDS"]) || in_array("MESSAGE", $arParams["REQUIRED_FIELDS"])):?><span class="require">*</span><?endif?></label>
        <div class="form-group">
            <textarea name="message" rows="5" cols="40" class="form-control"><?=$arResult["FEILDS"]["message"]?></textarea>
        </div>
        <?if($arParams["INCLUDE_FILE"] == "Y"):?>
        <div class="info">
            <?=GetMessage("IR_FILE_UPLOAD_DESC")?>
            <p>
                <?=GetMessage("IR_FILE_SUPPOTS_SIZE", array("#SIZE#" => $arParams["FILE_SIZE"]))?> <br />
                <?=GetMessage("IR_FILE_SUPPOTS_EXT", array("#EXT#" => $arParams["FILE_EXT"]))?>
            </p>
        </div>
        <div class="ir-wrapper-files">
            <div class="form-group">
                <label class="file-upload">
                    <span class="file-upload__icon">
                        <i class="fa fa-paperclip"></i>
                    </span>
                    <span class="file-upload__button" data-text="<?=GetMessage("IR_FILE")?>"><?=GetMessage("IR_FILE")?></span>
                    <input class="file-upload__input-file" multiple type="file" name="file_message[]">
                </label>
                <span class="file-upload-clear hidden"><i class="fa fa-times"></i><span class="sr-only"><?=GetMessage("IR_BTN_CLEAR_DESC")?></span></span>
            </div>
        </div>
        <?endif?>
        <?if ($arParams['USER_REGISTER'] == 'Y'):?>
        <div class="form-group">
            <label class="checkbox-button">
                <input id="ir-toggle-reg" class="checkbox-button__input" type="checkbox" name="registration" value="y" <?if($arResult["FEILDS"]["registration"]=="Y"):?>checked="checked"<?endif;?>>
                <span class="checkbox-button__custom-input"><?=GetMessage("IR_NEW_LK_DESC")?></span>
            </label>

            <div class="ir-wrapper-password-inputs<?if($arResult["FEILDS"]["registration"]!=="Y"):?> hidden<?endif;?>">
                <?if($arResult["REG_EMAIL_CONFIRM"] == "Y"):?>
                <p><?=GetMessage("IR_CONFIRM_REG_DESC")?></p>
                <?endif;?>
				<p><?echo $arResult["GROUP_POLICY"]["PASSWORD_REQUIREMENTS"];?></p>
                <div class="form-group">
                    <label><?=GetMessage("IR_PASSWORD")?>:<span class="require">*</span></label>
                    <br>
                    <input type="password" class="form-control" name="password" autocomplete="false" />
                </div>
                <div class="form-group">
                    <label><?=GetMessage("IR_CONFIRM_PASSWORD")?>:<span class="require">*</span></label>
                    <br>
                    <input type="password" class="form-control" name="confirm_password" autocomplete="false" />
                </div>
            </div> 
        </div>
        <?endif?>
        <?if ($arParams['USER_CONSENT'] == 'Y'):?>
         <?$APPLICATION->IncludeComponent(
          "bitrix:main.userconsent.request",
          "",
          array(
              "ID" => $arParams["USER_CONSENT_ID"],
              "IS_CHECKED" => $arParams["USER_CONSENT_IS_CHECKED"],
              "AUTO_SAVE" => "Y",
              "IS_LOADED" => $arParams["USER_CONSENT_IS_LOADED"],
              "REPLACE" => array(
               'button_caption' => GetMessage("IR_SUBMIT"),
               'fields' => array(GetMessage("IR_EMAIL"), GetMessage("IR_PHONE"), GetMessage("IR_NAME"), GetMessage("IR_SURNAME"), GetMessage("IR_SECOND_NAME"))
              ),
          )
         );?>
        <?else:?>
            <?if($arParams["PROCESS_PERSONAL_DATA"] == "Y"):?>
            <div class="form-group">
                <label class="checkbox-button">
                    <input class="checkbox-button__input" type="checkbox" name="agreement" <?if($arResult["FEILDS"]["PROCESS_PERSONAL_DATA"] == "Y"):?>checked="checked"<?endif;?> value="y">
                    <span class="checkbox-button__custom-input"><?=GetMessage("IR_PROCESS_PERSONAL_DATA")?> <span class="require">*</span></span>
                </label>
            </div>    
            <?endif?>
        <?endif;?>
        <?if($arParams["USE_CAPTCHA"] == "Y"):?>
        <div class="form-group">
            <label><?=GetMessage("IR_CAPTCHA")?> <sup>[2]</sup></label> 
            <input type="hidden" name="captcha_sid" value="<?=$arResult["capCode"]?>">
            <div>
                <img src="/bitrix/tools/captcha.php?captcha_sid=<?=$arResult["capCode"]?>" width="180" height="40" alt="CAPTCHA">
            </div>
            <div>
                <br>
                <input type="text" name="captcha_word" size="30" maxlength="50" value="" class="form-control" style="max-width: 180px"/>
            </div>
        </div>
        <?endif;?>
        <div class="form-group">
            <input type="hidden" name="PARAMS_HASH"  value="<?=$arResult["PARAMS_HASH"]?>">
            <input type="hidden" name="submit" value="y">
            <button type="submit" class="btn btn-info btn-sm" value="<?=GetMessage("IR_SUBMIT")?>"><?=GetMessage("IR_SUBMIT")?></button>
        </div>
    </form>
    <small>
        <?=GetMessage("IR_SEND_ANSWER_DESC")?><br />
        <?if($arParams["USE_CAPTCHA"] == "Y"):?>
        <?=GetMessage("IR_CAPTCHA_DESCRIPTION")?><br />
        <?endif;?>
    </small>
</div>

<script id="coauthor-template" type="text/template">
<div id="ir-coauthor-#ID#" class="ir-coauthor">
    <div class="ir-coauthor__wrap-close">
        <button type="button" class="btn btn-info btm-sm ir-coauthor_btn"><i class="fa fa-times"></i></button>
    </div>
    <div class="form-group">
        <label><?=GetMessage("IR_NAME")?>:<span class="require">*</span></label>
        <br>
        <input type="text" class="form-control" name="coauthor_name[]" value=""/>
    </div>
    <div class="form-group">
        <label><?=GetMessage("IR_SURNAME")?>:<span class="require">*</span></label>
        <br>
        <input type="text" class="form-control" name="coauthor_surname[]" value=""/>
    </div>
    <div class="form-group">
        <label><?=GetMessage("IR_SECOND_NAME")?>:</label>
        <br>
        <input type="text" class="form-control" name="coauthor_second_name[]" value="" />
    </div>
    <div class="form-group">
        <label><?=GetMessage("IR_EMAIL_COAUTHOR")?>:<span class="require">*</span></label>
        <br>
        <input type="text" class="form-control" name="coauthor_email[]" value="" />
    </div>
</div>
</script>

