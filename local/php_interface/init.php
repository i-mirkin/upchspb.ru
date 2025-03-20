<?php
use \Bitrix\Main\Loader;

if(file_exists($_SERVER['DOCUMENT_ROOT'].'/local/php_interface/functions.php')) require_once($_SERVER['DOCUMENT_ROOT'].'/local/php_interface/functions.php');
if(file_exists($_SERVER['DOCUMENT_ROOT'].'/local/php_interface/recaptcha.check.php')) require_once($_SERVER['DOCUMENT_ROOT'].'/local/php_interface/recaptcha.check.php');
if(file_exists($_SERVER['DOCUMENT_ROOT'].'/local/php_interface/tag.php'))require_once($_SERVER['DOCUMENT_ROOT'].'/local/php_interface/tag.php');
if(file_exists($_SERVER['DOCUMENT_ROOT'].'/local/php_interface/events.php')) require_once($_SERVER['DOCUMENT_ROOT'].'/local/php_interface/events.php');
if(file_exists($_SERVER['DOCUMENT_ROOT'].'/local/php_interface/constants.php')) require_once($_SERVER['DOCUMENT_ROOT'].'/local/php_interface/constants.php');

Loader::registerAutoLoadClasses(null, array(
    "\Bquadro\DeleteOldFiles" => "/local/tools/class/DeleteOldFiles.php"
));