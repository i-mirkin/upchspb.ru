<?php
	if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();
	$arComponentParameters = array(
		"GROUPS" => array(),
		"PARAMETERS" => array(
			"prop_code" => array(
				"PARENT" => "BASE",
				"NAME" => "Коды свойств (через запятую)",
				"TYPE" => "STRING"
			),
			"box_title" => array(
				"PARENT" => "BASE",
				"NAME" => "Название блока",
				"TYPE" => "STRING"
			)
		),
	);

