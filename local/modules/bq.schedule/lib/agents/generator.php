<?php
namespace Bq\Schedule\Agents;

use Bitrix\Main;
use Bitrix\Main\Localization\Loc;
use Bitrix\Main\Type,
Bitrix\Main\Loader,
Bitrix\Main\Config\Option;

Loc::loadMessages(__FILE__);

class Generator
{
	public static function run()
	{		\Bitrix\Main\Diag\Debug::writeToFile(['test' => 'ok'],'','/schedule_log_0.txt');
        Loader::includeModule('iblock');

        $arSelectScheduleBase = Array("ID", "NAME", "IBLOCK_SECTION_ID", "PROPERTY_SDATE", "PROPERTY_THEME");
        $arFilterScheduleBase = Array("IBLOCK_ID"=>52, "ACTIVE"=>"Y");
        $resScheduleBase = \CIBlockElement::GetList(Array(), $arFilterScheduleBase, false, Array(), $arSelectScheduleBase);
        $resScheduleBaseList = [];
        $scheduleBaseSectionCode = '';
        while($obScheduleBase = $resScheduleBase->GetNextElement())
        {
            $arFieldsScheduleBase = $obScheduleBase->GetFields(); 
            if($arFieldsScheduleBase['PROPERTY_SDATE_VALUE']) {
                $scheduleBaseSDate = \CIBlockELement::GetByID($arFieldsScheduleBase['PROPERTY_SDATE_VALUE']);
                if($scheduleBaseSDateEl = $scheduleBaseSDate->GetNext()) {
                    $arFieldsScheduleBase['PROPERTY_SDATE_TITLE'] = $scheduleBaseSDateEl['NAME'];
                }
            }
            if($arFieldsScheduleBase['PROPERTY_THEME_VALUE']) {
                $scheduleBaseTheme = \CIBlockELement::GetByID($arFieldsScheduleBase['PROPERTY_THEME_VALUE']);
                if($scheduleBaseThemeEl = $scheduleBaseTheme->GetNext()) {
                    $arFieldsScheduleBase['PROPERTY_THEME_TITLE'] = $scheduleBaseThemeEl['NAME'];
                }
            }
            if($arFieldsScheduleBase['IBLOCK_SECTION_ID']) {
                $scheduleBaseSection = \CIBlockSection::GetByID($arFieldsScheduleBase['IBLOCK_SECTION_ID']);
                if($scheduleBaseSectionEl = $scheduleBaseSection->GetNext()) {
                    $resScheduleBaseList[$scheduleBaseSectionEl['CODE']][] =  $arFieldsScheduleBase;
                }
            }   
        }

        \Bitrix\Main\Diag\Debug::writeToFile(['$resScheduleBaseList' => $resScheduleBaseList],'','/local/log/schedule_log_2.txt');

        $currentYear = date('Y');
        $arSelectHdays = Array("ID", "NAME", "PROPERTY_DATE");
        $arFilterHdays = Array("IBLOCK_ID"=>51, "ACTIVE"=>"Y", "SECTION_CODE" => $currentYear);
        $resHdays = \CIBlockElement::GetList(Array(), $arFilterHdays, false, Array(), $arSelectHdays);
        $resHdaysList = [];
        while($obHday = $resHdays->GetNextElement())
        {
            $arFieldsHday = $obHday->GetFields();
            if(isset($arFieldsHday['PROPERTY_DATE_VALUE']) && !empty($arFieldsHday['PROPERTY_DATE_VALUE'])) {
                    $resHdaysList[strtotime($arFieldsHday['PROPERTY_DATE_VALUE'])] = $arFieldsHday; 
            }
         
        }

        \Bitrix\Main\Diag\Debug::writeToFile(['$resHdaysList' => $resHdaysList],'','/local/log/schedule_log_3.txt');

        $periodList = [];
        $period = new \DatePeriod(
             new \DateTime(date('d.m.Y')),
             new \DateInterval('P1D'),
             new \DateTime(date('d.m.Y', strtotime('+1 month'))) 
        );

        foreach ($period as $key => $value) {
            $valueTS = $value->getTimestamp();
            if(isset($resHdaysList[$valueTS])) continue;
            $dateNumber = date('N', $valueTS);
            if($dateNumber < 6) {
                $periodList[] = [
                    'date' => $value->format('d.m.Y'),
                    'name' => strtolower(date('l', $valueTS))
                ];      
            }
        }

        \Bitrix\Main\Diag\Debug::writeToFile(['$periodList' => $periodList],'','/local/log/schedule_log_4.txt');

        foreach($periodList as $period) {
            if(isset($resScheduleBaseList[$period['name']]) && is_array($resScheduleBaseList[$period['name']])) {
                foreach($resScheduleBaseList[$period['name']] as $baseEl) {
                    $currentSchedule = new \CIBlockELement;
                    $csnameEl = $baseEl['PROPERTY_THEME_TITLE'] . '_' . $period['date'] . '_' . $baseEl['PROPERTY_SDATE_TITLE'];
                    $currentScheduleProp = [
                        'IBLOCK_ID' => 41,
                        'NAME' => $csnameEl,
                        'ACTIVE' => 'Y',
                        'CODE' => \CUtil::translit($csnameEl, 'ru', array("max_len"=>200)),
                        'PROPERTY_VALUES' => [
                            'THEME' => $baseEl['PROPERTY_THEME_VALUE'],
                            'HOURS' => $baseEl['PROPERTY_SDATE_VALUE'],
                            'SDATE' => $period['date'],
                            'STATUS' => 28
                        ]
                    ];
                    if(!($currentScheduleEl = $currentSchedule->Add($currentScheduleProp))) \Bitrix\Main\Diag\Debug::writeToFile(['element' => $baseEl, 'error' => $currentSchedule->LAST_ERROR],'','/local/log/schedule_error.txt');
                }
            }
        }

        \Bitrix\Main\Diag\Debug::writeToFile(['$periodList' => $periodList, '$resHdaysList' => $resHdaysList, '$resScheduleBaseList' => $resScheduleBaseList],'','/local/log/schedule_log_1.txt');


		return '\\' . __METHOD__ . '();'; 
	}
}