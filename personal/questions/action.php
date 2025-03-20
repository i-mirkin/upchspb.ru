<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_before.php");
CModule::IncludeModule('iblock');

//$ID = 17081;
$ID = $_POST['id'];


// получаем данные для ответа
$rsItems = CIBlockElement::GetList(
    array('ID' => 'DESC'),
    array('IBLOCK_ID' => 22, 'ID' => $ID),
    false,
    false,
    array('ID', 'NAME', 'PROPERTY_EMAIL', 'PROPERTY_otvet', 'PROPERTY_COMPLETE')
);
$arItem = $rsItems->GetNext();


$to = $arItem['PROPERTY_EMAIL_VALUE'];
$sender = "mail@".$_SERVER["SERVER_NAME"];
$subject = "Ответ с сайта Уполномоченного по правам человека в Санкт-Петербурге";
$headers = "MIME-Version: 1.0\r\n";
$headers .= "From: " . $sender . "\r\n";
$headers .= "Reply-To: " . $sender . "\r\n";
$message = $arItem['PROPERTY_OTVET_VALUE']['TEXT'];

//echo $to;
//echo $sender;
//echo $sender;
//echo $message;


use Bitrix\Main\Mail\Event;
Event::sendImmediate(array(
    "EVENT_NAME" => "QA_SEND_RESPONSE",
    "LID" => "s1",
    "C_FIELDS" => array(
        "EMAIL" => $to,
        "QUESTION" => $arItem['NAME'],
        "ANSWER" => $arItem['PROPERTY_OTVET_VALUE']['TEXT']
    ),
));
// обновляем поле DONE
CIBlockElement::SetPropertyValuesEx($ID, 22, ['COMPLETE' => 85]);



//if(mail($to, $subject, $message, $headers, "-f info@".$_SERVER["SERVER_NAME"])){
//    // обновляем поле DONE
//    CIBlockElement::SetPropertyValuesEx($ID, 22, ['COMPLETE' => 85]);
//}



?>