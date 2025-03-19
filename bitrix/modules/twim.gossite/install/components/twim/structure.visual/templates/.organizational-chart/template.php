<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();
/** @var array $arParams */
/** @var array $arResult */
/** @global CMain $APPLICATION */
/** @global CUser $USER */
/** @global CDatabase $DB */
/** @var CBitrixComponentTemplate $this */
/** @var string $templateName */
/** @var string $templateFile */
/** @var string $templateFolder */
/** @var string $componentPath */
/** @var CBitrixComponent $component */
$this->setFrameMode(true);
$arEntries = array();
$arDepthLast = array();
foreach ($arResult['ENTRIES'] as $key=>$value){
$arDepthLast[$value['DEPTH_LEVEL']]=$value['ID'];
$arEntries[] = $value;
}?>
<div class="wrap-organizational-chart">
    <ol class="organizational-chart">
       <?$depth=1;?>
       <?foreach ($arEntries as $key=>$value):?>
           <?if ($value['DEPTH_LEVEL']>$depth):?>
            <ol>
           <?endif;?>
           <?$tempKey = $key;
               $maxDepth = $value['DEPTH_LEVEL'];
               while(array_key_exists($tempKey+1,$arEntries) && $arEntries[$tempKey+1]['DEPTH_LEVEL']>$value['DEPTH_LEVEL']) {
                   $tempKey++;
                   $maxDepth = $arEntries[$tempKey]['DEPTH_LEVEL'];
               }
               if ($arEntries[$tempKey+1]['DEPTH_LEVEL']==$value['DEPTH_LEVEL']|| $arEntries[$tempKey+1]['DEPTH_LEVEL']>$value['DEPTH_LEVEL']) {
                   $dif = 1;
               } else {
                   $dif = $maxDepth-$arEntries[$tempKey+1]['DEPTH_LEVEL'];
               }?>
                <li>
                    <div>
                        <?if(!empty($value['DESCRIPTION'])):?>
                            <a href="<?=$value['SECTION_PAGE_URL']?>"><div><?=$value['NAME']?></div></a>
                        <?else:?>
                            <div><?=$value['NAME']?></div>
                        <?endif;?>
                    </div>
            <?if($arEntries[$key+1]['DEPTH_LEVEL']<$value['DEPTH_LEVEL']):?>
                <?if(is_null($arEntries[$key+1]['DEPTH_LEVEL'])) {
                    $arEntries[$key+1]['DEPTH_LEVEL'] = 1;
                }
               $d = $value['DEPTH_LEVEL'];
                while($arEntries[$key+1]['DEPTH_LEVEL']<$d):
                    $d--;?>
                    </ol>
                </li>
               <?endwhile;?>
           <?endif;?>	
           <?$depth = $value['DEPTH_LEVEL'];?>
       <?endforeach;?> 
   </ol>
</div>