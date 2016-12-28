<? $arBacket = $arResult->getBasketItems(); ?>
<?//echo "<pre>";print_r($arBacket);echo "</pre>";?>
<table class="table table-bordered tableBasket allTable">
    <thead>
    <tr>
        <th>Название</th>
        <th>Цена</th>
        <th width="100">Количество</th>
        <th>Сумма</th>
        <th width="70">Удалить</th>
    </tr>
    </thead>
    <tbody>
    <?
    if ($arResult->getItemsCount() > 0):
        foreach ($arBacket as $bItems):
            ?>
            <tr id="tr<?= $bItems["ID"] ?>">
				<td>
					<a href="#detailCard" data-toggle="modal" class="detailCard" data-id="<?= $bItems["PRODUCT_ID"] ?>"><?= $bItems["NAME"] ?></a>
					<br/><small class="art"><?= $bItems["ART"] ?></small>
				</td>
                <td class="text-right"><?= $arResult->formatePrice($bItems['PRICE']) ?></td>
                <td class="text-right"><input type="number" data-trid="<?= $bItems["ID"] ?>" class="form-control cnt-basket-changer" value="<?= $bItems["QUANTITY"] ?>" placeholder="<?= $bItems["QUANTITY"] ?>" min="1" max=""></td>
                <td class="b-sum text-right" id="price-<?= $bItems["ID"] ?>"><?= $arResult->formatePrice($bItems['FULL_PRICE']) ?></td>
                <td class="text-center">
                    <button class="btn btn-xs btn-default delBacketItem" type="button" data-id="<?= $bItems["ID"] ?>"><span class="glyphicon glyphicon-remove"></span></button>
                </td>
            </tr>
            <?
        endforeach;
    endif;
    ?>
    </tbody>
</table>

<div class="text-right">
    <div>Итого: <span class="basketItog" id="full-cart-price"><?= $arResult->getPrice() ?></span> руб.</div>
</div>