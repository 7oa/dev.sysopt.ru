<img src="<?= $arResult["img"] ?>" class="img-thumbnail pull-right datailCardImg">
<strong><?= $arResult["name"] ?></strong><br/><br/>
<? if ($arResult["description"]): ?><strong>Описание:</strong><br/><?= nl2br($arResult["description"]) ?><br/><br/><? endif; ?>
<? if ($arResult["id"]): ?><strong>Код:</strong> <?= $arResult["id"] ?><br/> <? endif; ?>
<? if ($arResult["art"]): ?><strong>Аритикул:</strong>    <?= $arResult["art"] ?><br/><? endif; ?>
<? if ($arResult["unit"]): ?><strong>Единицы измерения:</strong>    <?= $arResult["unit"] ?><br/><? endif; ?>
<? if ($arResult["manufacturer"]): ?><strong>Производитель:</strong>    <?= $arResult["manufacturer"] ?><br/> <? endif; ?>

<strong>Цена:</strong>    <?= number_format($arResult["price"], 2, '.', '') ?><br/>
<strong>Общее количество:</strong>    <?= $arResult["quantity"] ?> <?= $arResult["unit"] ?><br/>


<?if($arResult["STOCK"]):?>
    <?
    if (!array_key_exists(0, $arResult["STOCK"]))
        $stock[] = $arResult["STOCK"];
    else
        $stock = $arResult["STOCK"];
    ?>
    <div class="QuantDetailCard">
		<h4>Количество в разрезе по городам:</h4>
		<?foreach($stock as $arStock):?>
			<strong><?=$arStock["group"]?></strong> - <?=$arStock["quantity"]?> <?= $arResult["unit"] ?><br/>
		<?endforeach;?>
	</div>
<?endif;?>

<div class="detailZakaz">
    <strong>Добавить в корзину:</strong>
    <div class="input-group">

        <input type="number" data-id="<?= $arResult["id"] ?>" class="form-control cnt-basket" value="1" placeholder="1" min="1" max="<?= $arResult["quantity"] ?>">
        <span class="input-group-btn">
            <button data-id="<?= $arResult["id"] ?>" data-name='<?= $arResult["name"] ?>' data-price="<?= $arResult["price"] ?>" data-art="<?= $arResult["art"]?>" class="btn btn-default to-basket" type="button"><span class="glyphicon glyphicon-shopping-cart"></span></button>
        </span>
    </div>
</div>
<div class="clearfix"></div>