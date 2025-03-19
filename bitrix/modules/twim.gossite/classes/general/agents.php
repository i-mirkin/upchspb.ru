<?
namespace TwimGossite\Helpers;

class Agents{

    public static function updateEvents(){
        if (\Bitrix\Main\Loader::includeModule('iblock')) {
                $arSites = [];
                $rsSites = \CSite::GetList($by="sort", $order="desc", Array("ACTIVE" => "Y"));
                while ($arSite = $rsSites->Fetch())
                {
                    $arSites[] = $arSite["ID"];
                }
                foreach($arSites as $idSite){
                    $res = \CIBlock::GetList(
                        Array(), 
                        Array(
                            'ACTIVE'=>'Y', 
                            "CNT_ACTIVE"=>"Y", 
                            "CODE"=> 'events_' . $idSite,
                            "CHECK_PERMISSIONS" => "N"
                        ), true
                    );
                    $oldMonth = date('d.m.Y', strtotime('-1 month')) . ' 00:00:00';
                    $el = new \CIBlockElement;
                    while($arIblock = $res->Fetch())
                    {
                        if($arIblock['ELEMENT_CNT'] > 0){
                            $arSelect = Array("ID", "NAME", "DATE_ACTIVE_FROM");
                            $arFilter = Array("IBLOCK_ID"=>IntVal($arIblock["ID"]), "ACTIVE"=>"Y", '<DATE_ACTIVE_FROM' => $oldMonth);
                            $resEvent = \CIBlockElement::GetList(Array(), $arFilter, false, false, $arSelect);
                            while($arEvent = $resEvent->fetch())
                            {
                                $dateEvent = date('d.m.', strtotime($arEvent["DATE_ACTIVE_FROM"]));
                                $timeEvent = date(' H:i:s', strtotime($arEvent["DATE_ACTIVE_FROM"]));
                                $el->Update($arEvent["ID"], [
                                    "DATE_ACTIVE_FROM" => date("d.m.Y H:i:s", strtotime($dateEvent . (date("Y") + 1) . $timeEvent)),
                                ]); 
                            }
                        }
                    }
                }
        }
        return __METHOD__ . '();';
    }
}