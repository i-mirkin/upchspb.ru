<?php
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();

use \Bitrix\Main\Localization\Loc;

Loc::loadMessages(__FILE__);

class BquadroSmLinks extends CBitrixComponent
{
	public function executeComponent()
	{		
		$this->includeComponentTemplate($componentPage);
	}
}