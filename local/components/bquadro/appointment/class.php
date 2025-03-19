<?php
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();

use \Bitrix\Main\Localization\Loc;
use \Bitrix\Main\Context;
use \Bitrix\Main\Mail\Event;
use \Bitrix\Main\Loader;

Loc::loadMessages(__FILE__);

class BquadroAppointment extends CBitrixComponent
{
	public function executeComponent()
	{				
		Loader::includeModule('iblock');
	
		global $APPLICATION;
		
		$request = Context::getCurrent()->getRequest();
		
		$scheduleList = [];
		$arSelectSchedule = Array("ID", "NAME", "PROPERTY_DATE", "PROPERTY_HOURS", "PROPERTY_THEME", "PROPERTY_STATUS", "PROPERTY_SDATE");
		$arFilterSchedule = Array("IBLOCK_ID"=>$this->arParams['IBLOCK_ID_SCHEDULE'], "ACTIVE"=>"Y", "PROPERTY_STATUS"=>SCHEDULE_PROPERTY_STATUS_Y);

		$resSchedule = CIBlockElement::GetList(Array(), $arFilterSchedule, false, Array(), $arSelectSchedule);
		while($obSchedule = $resSchedule->GetNextElement())
		{			
			$arFieldsSchedule = $obSchedule->GetFields();					
			$scheduleList[$arFieldsSchedule['ID']] = [
				'PROPERTY_SDATE_VALUE' => $arFieldsSchedule['PROPERTY_SDATE_VALUE'],
				'PROPERTY_HOURS_VALUE' => $arFieldsSchedule['PROPERTY_HOURS_VALUE'],
				'PROPERTY_THEME_VALUE' => $arFieldsSchedule['PROPERTY_THEME_VALUE'],
				'PROPERTY_STATUS_VALUE' => $arFieldsSchedule['PROPERTY_STATUS_ENUM_ID'],
				'PROPERTY_STATUS' => $arFieldsSchedule['PROPERTY_STATUS_VALUE']
			];
		}		
			
		$scheduleDates = $scheduleHours = $scheduleTheme = [];
		foreach($scheduleList as $scheduleListEl) {			
			$scheduleDates[] = $scheduleListEl['PROPERTY_SDATE_VALUE'];
			$scheduleHours[] = $scheduleListEl['PROPERTY_HOURS_VALUE'];
			$scheduleTheme[] = $scheduleListEl['PROPERTY_THEME_VALUE'];
		}
		
		$dateList = [];
		$now = date('d.m.Y');
		$dtNow = new \DateTime($now);
		foreach($scheduleDates as $scheduleDate) {
			$currDate = new \DateTime($scheduleDate);
			if($currDate > $dtNow) {
				$dateList[] = date('Y-m-d', strtotime($scheduleDate)) ;
			}
		}
				
		
		/*$dateList = [];
		$arSelectDate = Array("ID", "NAME");
		$arFilterDate = Array("IBLOCK_ID"=>$this->arParams['IBLOCK_ID_DATE'], "ACTIVE"=>"Y", "ID" =>$scheduleDates);
		$resDate = CIBlockElement::GetList(Array(), $arFilterDate, false, Array(), $arSelectDate);
		$now = date('d.m.Y');
		$dtNow = new \DateTime($now);
		while($obDate = $resDate->GetNextElement())
		{
			$arFieldsDate = $obDate->GetFields();
			$currDate = new \DateTime($arFieldsDate['NAME']);			
			if($currDate >= $dtNow) {
				$dateList[$arFieldsDate['ID']] = $arFieldsDate['NAME'];
			}
		}*/
		
		$hoursList = [];
		$arSelectHours = Array("ID", "NAME", "SORT");
		$arFilterHours = Array("IBLOCK_ID"=>$this->arParams['IBLOCK_ID_HOURS'], "ACTIVE"=>"Y", "ID" => $scheduleHours);
		$resHours = CIBlockElement::GetList(Array(), $arFilterHours, false, Array(), $arSelectHours);
		while($obHours = $resHours->GetNextElement())
		{
			$arFieldsHours = $obHours->GetFields();
			$hoursList[$arFieldsHours['ID']] = [
				'NAME' => $arFieldsHours['NAME'],
				'SORT' => $arFieldsHours['SORT'] 
			];
		}
		
		$themeList = [];
		$arSelectTheme = Array("ID", "NAME");
		$arFilterTheme = Array("IBLOCK_ID"=>$this->arParams['IBLOCK_ID_THEME'], "ACTIVE"=>"Y", "ID" => $scheduleTheme);
		$resTheme = CIBlockElement::GetList(Array(), $arFilterTheme, false, Array(), $arSelectTheme);
		while($obTheme = $resTheme->GetNextElement())
		{
			$arFieldsTheme = $obTheme->GetFields();
			$themeList[$arFieldsTheme['ID']] = $arFieldsTheme['NAME'];
		}		
		foreach($scheduleList as &$scheduleListEl) {
			$scheduleListEl['DATE'] = $scheduleListEl['PROPERTY_SDATE_VALUE'];
			if(isset($hoursList[$scheduleListEl['PROPERTY_HOURS_VALUE']])) $scheduleListEl['HOURS'] = $hoursList[$scheduleListEl['PROPERTY_HOURS_VALUE']]['NAME'];
			if(isset($themeList[$scheduleListEl['PROPERTY_THEME_VALUE']])) $scheduleListEl['THEME'] = $themeList[$scheduleListEl['PROPERTY_THEME_VALUE']];
		}
		
		
		if($request->isAjaxRequest() && $request->get('action')) {
			switch($request->get('action')) {
				case 'init':
					$APPLICATION->RestartBuffer();
					echo json_encode(['dateList'=>$dateList, 'lang_id'=>LANGUAGE_ID]);
					exit();
				break;
				case 'themeHoursList':					
					if($request->get('dateId')) {
						$APPLICATION->RestartBuffer();
						
						$themeHoursListResp = [];
						$arFieldsThemeHoursList = [];
						$arSelectThemeHours = Array("ID", "NAME", "PROPERTY_DATE", "PROPERTY_HOURS", "PROPERTY_THEME", "PROPERTY_STATUS", "PROPERTY_SDATE", "PROPERTY_HOURS.NAME"); 
						$arFilterThemeHours = Array("IBLOCK_ID"=>$this->arParams['IBLOCK_ID_SCHEDULE'], "ACTIVE"=>"Y", "PROPERTY_STATUS"=>SCHEDULE_PROPERTY_STATUS_Y, "PROPERTY_SDATE" => date($request->get('dateId')));
						
						$resThemeHours = CIBlockElement::GetList(Array(), $arFilterThemeHours, false, Array(), $arSelectThemeHours);
						while($obThemeHours = $resThemeHours->GetNextElement())
						{			
							$arFieldsThemeHoursList[] = $obThemeHours->GetFields();													
						}												
						
						foreach($arFieldsThemeHoursList as &$arFieldsThemeHoursListEl) {
							$curDate = $arFieldsThemeHoursListEl['PROPERTY_SDATE_VALUE'] . ' ' . $hoursList[$arFieldsThemeHoursListEl['PROPERTY_HOURS_VALUE']]['NAME'];
							if(strtotime($curDate) < time()) continue;
							$themeHoursListResp[$arFieldsThemeHoursListEl['ID']]['DATE'] = $arFieldsThemeHoursListEl['PROPERTY_SDATE_VALUE'];
							if(isset($hoursList[$arFieldsThemeHoursListEl['PROPERTY_HOURS_VALUE']])) { 
								$themeHoursListResp[$arFieldsThemeHoursListEl['ID']]['HOURS'] = $hoursList[$arFieldsThemeHoursListEl['PROPERTY_HOURS_VALUE']]['NAME']; 
								$themeHoursListResp[$arFieldsThemeHoursListEl['ID']]['SORT'] = $hoursList[$arFieldsThemeHoursListEl['PROPERTY_HOURS_VALUE']]['SORT'];
								$themeHoursListResp[$arFieldsThemeHoursListEl['ID']]['ID'] = $arFieldsThemeHoursListEl['ID'];
							}
							if(isset($themeList[$arFieldsThemeHoursListEl['PROPERTY_THEME_VALUE']])) $themeHoursListResp[$arFieldsThemeHoursListEl['ID']]['THEME'] = $themeList[$arFieldsThemeHoursListEl['PROPERTY_THEME_VALUE']];							
						}												
						
						function themeHoursSort($a, $b) {
                            if ($a['SORT'] == $b['SORT']) {
                                return ($a['ID'] < $b['ID']) ? -1 : 1;
                            } else {
                                return ($a['SORT'] < $b['SORT']) ? -1 : 1;
                            }
						}
						usort($themeHoursListResp, 'themeHoursSort'); 

						if(empty($themeHoursListResp)) $themeHoursListResp['IS_EMPTY'] = Loc::getMessage('RECORD_TODAY_OVER');

						echo json_encode($themeHoursListResp);
						exit();
					}
				break;
				case 'appointment':
					$APPLICATION->RestartBuffer();
					
					$formResp['ERROR'] = [];
					$reqFields = ['name', 'surname', 'phone',/*'email',*/ 'reason', 'schedule', 'uconsent'/*, 'postaddr'*/];
					
					$userFields = $request->get('user');
					$scheduleId = $request->get('schedule');
					$uconsent = $request->get('uconsent');
					$userDate = $request->get('selected_date');
					$userPhone = $request->get('phone');
					$userReason = $request->get('reason');
					$datePost = new \DateTime($userDate);
					$datePostOut = $datePost->format('d.m.Y');
					$captcha_word = $request->get('captcha_word');
					foreach($userFields as $k => $v) {
						/*if('email' == $k) {
							if(!check_email($v)) $formResp['ERROR'][$k] = Loc::getMessage('ERROR_EMAIL');
						}*/
						if(in_array($k, $reqFields) && empty($v)) {
							$formResp['ERROR'][$k] = Loc::getMessage('EMPTY_MESS');
						}
					}
					//if(!check_bitrix_sessid()) $formResp['ERROR']['capt'] = Loc::getMessage('SPAM_ERROR');
					if(empty($scheduleId)) $formResp['ERROR']['schedule'] = Loc::getMessage('EMPTY_MESS_SCHEDULE');
					if(empty($uconsent)) $formResp['ERROR']['uconsent'] = Loc::getMessage('EMPTY_MESS');
					
					
					
					
					if($this->arParams["USE_CAPTCHA"] == "Y")
					{
						if(empty($captcha_word)) {
							$formResp['ERROR']['captcha_word'] = 'Введите капчу';	
						}
						else {
							if(!$APPLICATION->CaptchaCheckCode($_POST["captcha_word"], $_POST["captcha_code"]))	{
								// Неправильное значение
								$formResp['ERROR']['captcha_word'] = Loc::getMessage('SPAM_ERROR');
							}
							else {
								// Правильное значение
							}
						}
						
						
					}		
				

					if(empty($formResp['ERROR'])) {
						$el = new CIBlockElement; 
						$prop = $userFields;
						$prop['schedule'] = $scheduleId;
						$date = new \DateTime();
						$prop['hash'] = hash('sha256', $date->getTimestamp());


						$shList = [];
                        $iterator = CIBlockElement::GetPropertyValues(41, array('ID' => $scheduleId), true, array('ID' => array(94, 95, 111)));
                        while ($row = $iterator->Fetch())
                        {
                            $shList[94]['CODE'] = $row[94];
                            $shList[95]['CODE'] = $row[95];

                            $prop['hours'] = $row[94];
                            if (strlen($row[111]) > 0) {
                                $prop['date'] = new \Bitrix\Main\Type\DateTime($row[111], "Y-m-d");
                            }
                        }
                        $res = CIBlockElement::GetList(Array(), ['ID' =>array($shList[94]['CODE'],$shList[95]['CODE'])]);
                        while($ar_fields = $res->GetNext())
                        {
	                        foreach($shList as &$sh) {
	                         	if($sh['CODE'] == $ar_fields['ID']) $sh['NAME'] = $ar_fields['NAME'];
	                        }
                        }

						
						$arLoadProductArray = [
							"IBLOCK_ID" => $this->arParams['IBLOCK_ID_RECORD'],
							"NAME" => $shList[95]['NAME'] . '_' . $datePostOut . '_' . $shList[94]['NAME'],  
							"PROPERTY_VALUES" => $prop,
							"PREVIEW_TEXT" => $prop['reason'],
							"ACTIVE" => "Y"
						];
											
						$recordId = $el->Add($arLoadProductArray);
						
						if($recordId) {
							$formResp['SUCCESS']['MSG'] = Loc::getMessage('SUCCESS_APP');
														
							CIBlockElement::SetPropertyValues($scheduleId, $this->arParams['IBLOCK_ID_SCHEDULE'], SCHEDULE_PROPERTY_STATUS_N, 'STATUS');	

							$protocol = (CMain::IsHTTPS()) ? "https://" : "http://";

							$recordType = 'appointment';
							if('en' == SITE_ID) $recordType = 'appointmentEN';

							$recordLink = $protocol . $_SERVER['SERVER_NAME'] . "/bitrix/admin/iblock_element_edit.php?IBLOCK_ID=".$this->arParams['IBLOCK_ID_RECORD']."&type=".$recordType."&ID=".$recordId."&lang=ru&find_section_section=-1&WF=Y";
							$recordLinkEl = '<a href="'.$recordLink.'">'.Loc::getMessage('MORE').'</a>';

							$deleteLink = $protocol . $_SERVER['SERVER_NAME'] . SITE_DIR . "appointment/" . "?deleteRecord=" . $recordId . "&drHash=" . $prop['hash'];
							$deleteLinkEl = '<a href="'.$deleteLink.'">'.$deleteLink.'</a>';

							Event::send(array(
								"EVENT_NAME" => "APPOINTMENT_NEW",
								"LID" => "s1",
								"C_FIELDS" => array(
									"NAME" => $userFields['name'],
									"PATRONYMIC" => $userFields['patronymic'],
									"SURNAME" => $userFields['surname'],   
									"EMAIL" => $userFields['email'],
									"DATE" => $datePostOut,
									"RECORD_LINK" => $recordLinkEl,
									"DELETE_LINK" => $deleteLink,
									"TIME" => $shList[94]['NAME'],
									"THEME" => $shList[95]['NAME'],
									"REASON" => $userFields['reason'],
									"PHONE" => $userFields['phone'],
									"POSTADDR" => $userFields['postaddr'],									 
								),
							)); 
						} else {
                            $formResp['ERROR']['add'] = "Error: ".$el->LAST_ERROR;
                        }
					}
					
					echo json_encode($formResp);
					exit();
					
				break;
			}
		}
		
		if($request->get('deleteRecord') && $request->get('drHash')) {
			if($request->get('delConf') && $request->get('delConf') == 'yes') {
				$arSelectRec = Array("ID", "NAME", "PROPERTY_SCHEDULE", "PROPERTY_NAME", "PROPERTY_SURNAME", "PROPERTY_PATRONYMIC");  
				$arFilterRec = Array("IBLOCK_ID"=>$this->arParams['IBLOCK_ID_RECORD'], "ACTIVE"=>"Y", "ID"=>$request->get('deleteRecord'), "PROPERTY_hash" => $request->get('drHash'));
				$resRec = CIBlockElement::GetList(Array(), $arFilterRec, false, Array(), $arSelectRec);
				while($obRec = $resRec->GetNextElement())
				{
					$arFieldsRec = $obRec->GetFields();				
					if($arFieldsRec['ID']) {
						if(CIBlockElement::Delete($arFieldsRec['ID'])) { 
							$this->arResult['RECORD_DELETED'] = Loc::getMessage('RECORD_DELETED');
							if($arFieldsRec['PROPERTY_SCHEDULE_VALUE']) {
								$resDelSch = CIBlockElement::GetByID($arFieldsRec['PROPERTY_SCHEDULE_VALUE']);
								$resDelSchPropDate = $resDelSchThemeResVal = $resDelSchHoursResVal = '';
								if($resDelSchEl = $resDelSch->GetNextElement()) {
									$resDelSchProp = $resDelSchEl->GetProperties();
									$resDelSchPropDate = $resDelSchProp['SDATE']['VALUE'];									
								}

								if($resDelSchProp['THEME']['VALUE']) {
									$resDelSchTheme = CIBlockElement::GetByID($resDelSchProp['THEME']['VALUE']);									 
									if($resDelSchThemeRes = $resDelSchTheme->GetNext()) $resDelSchThemeResVal = $resDelSchThemeRes['NAME'];
								}

								if($resDelSchProp['HOURS']['VALUE']) {
									$resDelSchHours = CIBlockElement::GetByID($resDelSchProp['HOURS']['VALUE']);									 
									if($resDelSchHoursRes = $resDelSchHours->GetNext()) $resDelSchHoursResVal = $resDelSchHoursRes['NAME'];
								}

								//if($resDelSchEl = $resDelSch->GetNextElement()) \Bitrix\Main\Diag\Debug::writeToFile(['res'=>],'','/rtest2.txt');								
							}
							Event::send(array(
								"EVENT_NAME" => "APPOINTMENT_DELETED",
								"LID" => "s1",
								"C_FIELDS" => array(
									"NAME" => $arFieldsRec['PROPERTY_NAME_VALUE'] . ' ' . $arFieldsRec['PROPERTY_PATRONYMIC_VALUE'],	
									"DATE" => $resDelSchPropDate,
									"THEME" => $resDelSchThemeResVal,
									"HOURS" => $resDelSchHoursResVal  
								),
							)); 
						}
					}
					if($arFieldsRec['PROPERTY_SCHEDULE_VALUE']) {
						CIBlockElement::SetPropertyValues($arFieldsRec['PROPERTY_SCHEDULE_VALUE'], $this->arParams['IBLOCK_ID_SCHEDULE'], SCHEDULE_PROPERTY_STATUS_Y, 'STATUS');
					}
				}
			} else {
				$this->arResult['RECORD_DELETED_Q'] = 1;	
			}
		}
		
		$this->includeComponentTemplate($componentPage);
	}
}