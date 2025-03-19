<?php 
//dump($arResult);
$sList = [];
if(!empty($arResult['SEARCH'])) { 
    foreach($arResult['SEARCH'] as $sEl) {
        $sList[$sEl['ID']] = strtotime($sEl['FULL_DATE_CHANGE']);
    }
}

$arParams['PAGE_RESULT_COUNT'] = 10;

var_dump(count($sList));
dump($sList);