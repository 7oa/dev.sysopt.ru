<tr id="tr<?= $arResult['ID'] ?>">
    <td><?= $arResult["PRODUCT_ID"] ?></td>
    <td><?= $arResult["NAME"] ?></td>
    <td class="text-right"><?= number_format($arResult["PRICE"], 2, '.', ' ') ?></td>
    <td class="text-right"><input type="number" data-trid="<?= $arResult['ID'] ?>" class="form-control cnt-basket-changer" value="<?= $quantity ?>" placeholder="<?= $quantity ?>" min="1" max=""></td>
    <td class="b-sum text-right"><?= number_format($sum, 2, '.', ' ') ?></td>
    <td class="text-center">
        <button class="btn btn-xs btn-default delBacketItem" type="button" data-id="<?= $arResult['ID'] ?>"><span class="glyphicon glyphicon-remove"></span></button>
    </td>
</tr>
<?//echo '<pre>'; print_r($result); echo '</pre>';