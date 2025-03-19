<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();

use Bitrix\Main\Localization\Loc,
	Bitrix\Main\Context;

// sort
$obRequest = Context::getCurrent()->getRequest();

$getSort = $obRequest->getQuery("sort");
$getOrder = $obRequest->getQuery("order");
$getState = $obRequest->getQuery("state");

$state_p = $getState;

switch ($getSort)
{
	case "date":
		$sort_p = "date";
		break;
		
	case "region":
		$sort_p = "region";	
		break;
		
	case "price":
		$sort_p = "price";	
		break;
		
	default:
		$sort_p = null;	
}

switch ($getOrder )
{
	case "asc":
		$order = "asc";
		break;
		
	case "desc":
		$order = "desc";
		break;
		
	default:
		$order = "desc";
}

if($order == "desc") {
	$order_p = null;
} elseif ($order == "asc") {
	$order_p = "desc";
}

if ($getState != $sort_p)
	$order_p = "asc";
?>

<th class="lk-table__head lk-table__head--number"><?= Loc::getMessage("TH_TABLE_NUMBER")?></th>
<th class="lk-table__head lk-table__head--comments"></th>
<th class="lk-table__head lk-table__head--date
	<? if (($getState == "date") && ($sort_p == "date") && ($order == "asc")) { echo "sorting-up"; } if (($getState == "date") && ($sort_p == "date") && ($order == "desc")) { echo "sorting-down"; } ?>">
	
	<?if ($getState == "date" && !$order_p):?>
		<a rel="nofollow" href="<?=$APPLICATION->GetCurPageParam('', array("sort", "order", "state", "PAGEN_1", "PAGEN_2"), false);?>">
			<?= Loc::getMessage("TH_TABLE_DATE")?>
		</a>
	<?else:?>
		<a rel="nofollow" href="<?=$APPLICATION->GetCurPageParam('sort=date&order='.($getState == "date" ? $order_p : "asc").'&state=date', array("sort", "order", "state", "PAGEN_1", "PAGEN_2"), false);?>">
			<?= Loc::getMessage("TH_TABLE_DATE")?>
		</a>
	<?endif;?>
</th>
<th class="lk-table__head lk-table__head--region
	<? if (($getState == "region") && ($sort_p == "region") && ($order == "asc")) { echo "sorting-up"; } if (($getState == "region") && ($sort_p == "region") && ($order == "desc")) { echo "sorting-down"; } ?>">
	
	<?if ($getState == "region" && !$order_p):?>
		<a rel="nofollow" href="<?=$APPLICATION->GetCurPageParam('', array("sort", "order", "state", "PAGEN_1", "PAGEN_2"), false);?>">
			<?= Loc::getMessage("TH_TABLE_LOCATION")?>
		</a>
	<?else:?>
		<a rel="nofollow" href="<?=$APPLICATION->GetCurPageParam('sort=region&order='.($getState == "region" ? $order_p : "asc").'&state=region', array("sort", "order", "state", "PAGEN_1", "PAGEN_2"), false);?>">
			<?= Loc::getMessage("TH_TABLE_LOCATION")?>
		</a>
	<?endif;?>
</th>
<th class="lk-table__head lk-table__head--project"><?= Loc::getMessage("TH_TABLE_PROJECT")?></th>
<th class="lk-table__head lk-table__head--sum
	<? if (($getState == "price") && ($sort_p == "price") && ($order == "asc")) { echo "sorting-up"; } if (($getState == "price") && ($sort_p == "price") && ($order == "desc")) { echo "sorting-down"; } ?>">
	
	<?if ($getState == "price" && !$order_p):?>
		<a rel="nofollow" href="<?=$APPLICATION->GetCurPageParam('', array("sort", "order", "state", "PAGEN_1", "PAGEN_2"), false);?>">
			<?= Loc::getMessage("TH_TABLE_COST")?>
		</a>
	<?else:?>
		<a rel="nofollow" href="<?=$APPLICATION->GetCurPageParam('sort=price&order='.($getState == "price" ? $order_p : "asc").'&state=price', array("sort", "order", "state", "PAGEN_1", "PAGEN_2"), false);?>">
			<?= Loc::getMessage("TH_TABLE_COST")?>
		</a>
	<?endif;?>
</th>
<th class="lk-table__head lk-table__head--contacts"><?= Loc::getMessage("TH_TABLE_CONTACTS")?></th>
<th class="lk-table__head lk-table__head--status"><?= Loc::getMessage("TH_TABLE_STATUS")?></th>