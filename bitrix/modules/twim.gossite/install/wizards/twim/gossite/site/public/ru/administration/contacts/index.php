<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetPageProperty("title", "Контакты");
$APPLICATION->SetTitle("Контакты");
?>
<?$APPLICATION->IncludeFile(
    SITE_DIR."/include/contacts_block.php",
    Array("OPTION_SITE" => $arOptionGosSite),
    Array("MODE"=>"text", "SHOW_BORDER" => false)
);?> 
<br>
<div class="row">
    <div class="col-xs-12">
        <h4 class="text-uppercase">Задать вопрос</h4>
        <p>
            <small class="help">Сообщение не является официальным запросом, для запроса перейдите по <a href="#SITE_DIR#appeals/internet-reception/">ссылке</a></small>
        </p>
        <?$APPLICATION->IncludeComponent(
            "bitrix:main.feedback", 
            "question", 
            array(
                "EMAIL_TO" => $arOptionGosSite["email_form"],
                "EVENT_MESSAGE_ID" => array(
                    0 => "7",
                ),
                "OK_TEXT" => "Спасибо, ваше сообщение принято.",
                "REQUIRED_FIELDS" => array(
                    0 => "NAME",
                    1 => "EMAIL",
                    2 => "MESSAGE",
                ),
                "USE_CAPTCHA" => "Y",
                "COMPONENT_TEMPLATE" => "question"
            ),
            false
        );?>
    </div>
</div>
<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>
