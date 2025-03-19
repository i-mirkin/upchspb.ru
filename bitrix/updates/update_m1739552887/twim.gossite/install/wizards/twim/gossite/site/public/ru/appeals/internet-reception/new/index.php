<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetTitle("����� ���������");
?>
<?$APPLICATION->IncludeComponent(
	"twim:ir.feedback", 
	".default", 
	array(
		"COMPONENT_TEMPLATE" => ".default",
		"USE_CAPTCHA" => "Y",
		"OK_TEXT" => "���� ������ ���������� � �������� ������������ ����������� � ������� ���� ���� � ������� ����������� � [������������ ������]",
		"EMAIL_TO" => $arOptionGosSite["email_form"],
		"PROCESS_PERSONAL_DATA" => "Y",
		"EVENT_MESSAGE_ID" => array(
			0 => "#IR_FEEDBACK_FORM_MESSAGE_ID#",
			1 => "#IR_FEEDBACK_FORM_USER_MESSAGE_ID#",
		),
		"INCLUDE_FILE" => "Y",
		"FILE_EXT" => "doc, txt, rtf, docx, pdf, odt, zip, 7z, jpg, jpeg, png",
		"FILE_SIZE" => "10485760",
		"ADD_IBLOCK_MESSAGE" => "Y",
		"IBLOCK_TYPE" => "internet_reception",
		"USER_CONSENT" => "Y",
		"USER_CONSENT_ID" => "0",
		"USER_CONSENT_IS_CHECKED" => "Y",
		"USER_CONSENT_IS_LOADED" => "N",
		"COLLECTIVE_APPEAL" => "Y",
		"IBLOCK_AGANCY_ID" => "#AGENCY_TREATMENTS_IBLOCK_ID#",
		"IBLOCK_ADD_ID" => "#INTERNET_RESEPTION_LIST_IBLOCK_ID#",
		"IBLOCK_ID_COAUTHORS" => "#COAUTHORS_IBLOCK_ID#",
		"REQUIRED_FIELDS" => array(
			0 => "THEME",
			1 => "NAME",
			2 => "SURNAME",
			3 => "SECOND_NAME",
			4 => "EMAIL",
			5 => "MESSAGE",
		),
		"USER_REGISTER" => "Y",
		"CACHE_TYPE" => "A",
		"CACHE_TIME" => "360000"
	),
	false
);?> 
<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>