<? IncludeTemplateLangFile(__FILE__); ?>
<? //ShowMessage(['TYPE'=>'OK', 'MESSAGE'=>$arResult['RECORD_DELETED']]);?>
<? if (isset($arResult['RECORD_DELETED_Q']) && !empty($arResult['RECORD_DELETED_Q'])) { ?>
<script>
    jQuery(function ($) {
        $('#deleteRecord').modal('show');
        $('body').on('click', '.deleteConf', function () {
            window.location = window.location.href + '&delConf=yes';
        });
    });
</script>
<div class="modal" tabindex="-1" role="dialog" id="deleteRecord">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"><?= GetMessage('RECORD_DEL_TITLE') ?></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <p><?= GetMessage('RECORD_DEL_BODY') ?></p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary deleteConf">Да</button>
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Нет</button>
            </div>
        </div>
    </div>
</div>
<? } elseif (isset($arResult['RECORD_DELETED']) && !empty($arResult['RECORD_DELETED'])) {
?>
<script>
    jQuery(function ($) {
        $('#deleteRecordConf').modal('show');
    });
</script>
<div class="modal" tabindex="-1" role="dialog" id="deleteRecordConf">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <p><?= $arResult['RECORD_DELETED'] ?></p>
            </div>
        </div>
    </div>
</div>
<?
} else { ?>
<div class="appointment_wrap">
    <form name="appointment" action="" method="post">
        <?=bitrix_sessid_post()?>
		<div class="appointment__wrap">
            <input type="hidden" name="action" value="appointment"/>
            <input name="selected_date" id="datetimepicker_appointment" type="text" style="display: none">
        </div>
        <p class="appointment_err_list"></p>
        <div class="theme-list">
        </div>
        <div class="app-fl" style="display:none">
            <div class="field-list">
                <div class="field-list-item form-group">
                    <input type="text" class="user_surname form-control" name="user[surname]">
                    <label class="float-label"><?= GetMessage('USURNAME') ?> *</label>
                </div>
                <div class="field-list-item form-group">
                    <input type="text" class="user_name form-control" name="user[name]">
                    <label class="float-label"><?= GetMessage('UNAME') ?> *</label>
                </div>
                <div class="field-list-item form-group">
                    <input type="text" class="user_patronymic form-control" name="user[patronymic]">
                    <label class="float-label"><?= GetMessage('UPATRONYMIC') ?></label>
                </div>
                <div class="field-list-item form-group">
                    <input type="text" class="user_phone form-control mask" name="user[phone]">
                    <label class="float-label"><?= GetMessage('UPHONE') ?> *</label>
                </div>
                <div class="field-list-item form-group">
                    <input type="text" class="user_email form-control" name="user[email]">
                    <label class="float-label"><?= GetMessage('UEMAIL') ?></label>
                </div>
                <div class="field-list-item form-group">
                    <input type="text" class="user_postaddr form-control" name="user[postaddr]">
                    <label class="float-label"><?= GetMessage('UPOSTADDR') ?></label>
                </div>
                <div class="field-list-item form-group">
                    <textarea class="user_reason form-control" name="user[reason]"></textarea>
                    <label class="float-label"><?= GetMessage('UREASON') ?> *</label>
                </div>
				
				
				<div class="field-list-item form-group">
					<?if($arParams["USE_CAPTCHA"] == "Y"):?>
					<?include_once($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/classes/general/captcha.php");
					$cpt = new CCaptcha();
					$captchaPass = COption::GetOptionString("main", "captcha_password", "");
					if(strlen($captchaPass) <= 0)
					{
					$captchaPass = randString(10);
					COption::SetOptionString("main", "captcha_password", $captchaPass);
					}
					$cpt->SetCodeCrypt($captchaPass);
					?>
					
					<table class="line"><tr>
					<td>
					<input name="captcha_code" value="<?=htmlspecialchars($cpt->GetCodeCrypt());?>" type="hidden">
					<div class="field-list-item form-group">
						<input id="captcha_word" name="captcha_word" type="text" class="form-control">
						<!--label class="float-label">Введите капчу *</label-->
					</div>
					</td>
					<td>
						<div class="field-list-item form-group" style="margin-left: 10px">	
						<img src="/bitrix/tools/captcha.php?captcha_code=<?=htmlspecialchars($cpt->GetCodeCrypt());?>">
						</div>
					</td>
					</tr></table>
					
					
					
					
					<?endif;?>
				</div>
				
				
				
                <div id="userconsent-container">
                    <? $APPLICATION->IncludeComponent(
                        "bitrix:main.userconsent.request",
                        ".default",
                        array(
                            "ID" => "1",
                            "IS_CHECKED" => "Y",
                            "AUTO_SAVE" => "Y",
                            "IS_LOADED" => "N",
                            "SUBMIT_EVENT_NAME" => "userconsent-event",
                            "REPLACE" => array(
                                "button_caption" => "Записаться",
                            ),
                            "INPUT_NAME" => "uconsent",
                            "COMPONENT_TEMPLATE" => ".default"
                        ),
                        false
                    ); ?>
                </div>
				
				
				
				
				
            </div>
            <button type="submit" name="usubmit" class="btn btn-info valid"><?= GetMessage('USUBMIT') ?></button>
        </div>
    </form>
</div>
<? } ?>