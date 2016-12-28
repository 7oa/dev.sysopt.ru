<?if($arResult["Stocks"]):
	if (!array_key_exists(0, $arResult["Stocks"]))
		$stock[] = $arResult["Stocks"];
	else
		$stock = $arResult["Stocks"];
	?>
	<?foreach($stock as $arStock):?>
		<strong><?=$arStock["group"]?></strong> - <?=$arStock["quantity"]?><br/>
	<?endforeach;?>
<?else:?>
	Нет информации
<?endif;?>

