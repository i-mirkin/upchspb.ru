<?if(!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true)?>
<?$APPLICATION->IncludeComponent("bitrix:system.auth.form", ".default-mobile", Array(
        "FORGOT_PASSWORD_URL" => "#SITE_DIR#auth/",
        "LOGIN_URL" => "#SITE_DIR#auth/?login=yes",
        "LIST_URL" => "#SITE_DIR#appeals/internet-reception/personal/list/",
		"PROFILE_URL" => "#SITE_DIR#appeals/internet-reception/personal/profile/",
		"REGISTER_URL" => "#SITE_DIR#auth/",	
		"SHOW_ERRORS" => "N",
	),
	false
);?>