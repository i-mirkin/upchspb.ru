<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();?>
<?$arEntries = array();
$arDepthLast = array();
foreach ($arResult['ENTRIES'] as $key=>$value):?>
	<?
		$arDepthLast[$value['DEPTH_LEVEL']]=$value['ID'];
		$arEntries[] = $value;
	?>
<?endforeach;?>


<ul class="structure">
		<?$depth=1;?>
		<?foreach ($arEntries as $key=>$value):?>
			<?if ($value['DEPTH_LEVEL']>$depth):?>
				<ul>
			<?endif;?>
			<?
				$tempKey = $key;
				$maxDepth = $value['DEPTH_LEVEL'];
				while(array_key_exists($tempKey+1,$arEntries) && $arEntries[$tempKey+1]['DEPTH_LEVEL']>$value['DEPTH_LEVEL']) {
					$tempKey++;
					$maxDepth = $arEntries[$tempKey]['DEPTH_LEVEL'];
				}
				if ($arEntries[$tempKey+1]['DEPTH_LEVEL']==$value['DEPTH_LEVEL']|| $arEntries[$tempKey+1]['DEPTH_LEVEL']>$value['DEPTH_LEVEL']) {
					$dif = 1;
				} else {
					$dif = $maxDepth-$arEntries[$tempKey+1]['DEPTH_LEVEL'];
				}
			?>
			
			<?if($arEntries[$key+1]['DEPTH_LEVEL']<$value['DEPTH_LEVEL'] || $value['ID']==$arDepthLast[$value['DEPTH_LEVEL']] || $dif>1):?>
				<li class="last">
			<?else:?>
				<li>
			<?endif;?>
			<span><?=$value['NAME']?></span>
			
			<?if ($arEntries[$key+1]['DEPTH_LEVEL']<$value['DEPTH_LEVEL']):?>
				<?$d = $value['DEPTH_LEVEL'];
					while($arEntries[$key+1]['DEPTH_LEVEL']<$d):
						$d--;
				?>
						</ul>
						</li>
				<?	endwhile;
				?>
			<?endif;?>
					
			<?//echo "</li>";
			$depth = $value['DEPTH_LEVEL'];?>
			
		<? endforeach; ?>
</ul>
