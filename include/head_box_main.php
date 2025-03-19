<?if(!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true);
$head = $arParams["OPTION_SITE"];?>
<?if($head["img_boss"]):?>
<div class="box hidden-xs">
	<div class="first-person">
 		<img src="<?=$head["img_boss"]?>" alt="<?=$head["fio_boss"]?>"  title="<?=$head["fio_boss"]?>" class="img-responsive">
		<div class="wrap-text">
			<?if($head["fio_boss"]):?>
			<p class="name"><?=$head["fio_boss"] ?></p>
			<?endif;?>
			<?if($head["post_boss"]):?>
			<p class="post"><?=$head["post_boss"] ?></p>
			<?endif;?>
		</div>
	</div>
</div>
<?endif;?>
