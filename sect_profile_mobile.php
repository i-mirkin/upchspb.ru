<?if(!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true)?>
<?$APPLICATION->IncludeComponent("bitrix:system.auth.form", ".default-mobile", Array(
        "FORGOT_PASSWORD_URL" => "/auth/",
        "LOGIN_URL" => "/auth/?login=yes",
        "LIST_URL" => "/appeals/internet-reception/personal/list/",
		"PROFILE_URL" => "/appeals/internet-reception/personal/profile/",
		"REGISTER_URL" => "/auth/",	
		"SHOW_ERRORS" => "N",
	),
	false
);?>