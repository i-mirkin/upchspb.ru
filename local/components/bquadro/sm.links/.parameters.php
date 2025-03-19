<?php
	if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();
	$arComponentParameters = array(
		"GROUPS" => array(),
		"PARAMETERS" => array(
			"youtube" => array(
				"PARENT" => "BASE",
				"NAME" => "Youtube",
				"TYPE" => "STRING"
			),
			"facebook"	=>	array(
				"PARENT" => "BASE",
				"NAME"	=>	"Facebook",
				"TYPE"	=>	"STRING",
			),
			"vkontakte" => array(
				"PARENT" => "BASE",
				"NAME" => "Вконтакте",
				"TYPE" => "STRING",
			),
			"instagram" => array(
				"PARENT" => "BASE",
				"NAME" => "Instagram",
				"TYPE" => "STRING",
			),
			"telegram" => array(
				"PARENT" => "BASE",
				"NAME" => "Telegram",
				"TYPE" => "STRING"
			)
		),
	);

