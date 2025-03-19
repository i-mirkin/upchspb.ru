<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetTitle("Сообщить о коррупции");
?>
<div class="bs-callout bs-callout-info">
    <p>В соответствии с Уголовным кодексом Российской Федерации:</p>
    <ul>
        <li>дача взятки представителю власти карается штрафом до 500 тысяч рублей или лишением свободы на срок до 8 лет (ст. 291 УК РФ);</li>
        <li>получение взятки должностным лицом карается штрафом от 100 до 500 тысяч рублей или лишением свободы до 7 лет (ч. 1, 2 ст . 290 УК РФ);</li>
        <li>вымогательство взятки карается лишением свободы сроком от 7 до 12 лет со штрафом в размере до 1 млн. рублей (ч. 4 ст. 290 УК РФ);</li>
        <li>помните об ответственности за заведомо ложный донос о совершенном преступлении (ст.306 УК РФ).</li>
    </ul>
</div>    
<?$APPLICATION->IncludeComponent(
	"bitrix:main.feedback", 
	"question", 
	array(
		"EMAIL_TO" => $arOptionGosSite["email_form"],
		"EVENT_MESSAGE_ID" => array(
			0 => "#ANTICOR_EVENT_MESSAGE_ID#",
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
<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>
