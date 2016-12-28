<?if($arResult["ITEMS"]):?>
    <?//echo "<pre>";print_r($arResult);echo "</pre>";?>
<div class="pull-right" style="margin-bottom: 20px;">
    <button type="button" class="btn btn-success sampleRepeat" data-id="<?= $arResult["ID"] ?>" data-form="custom">Добавить в заказ</button>
</div>
    <div class="clearfix"></div>
<table class="table table-bordered allTable">
    <tr>
        <th>Название</th>
        <th>Количество</th>
    </tr>
    <?foreach ($arResult["ITEMS"] as $items):?>
        <tr>
            <td><?= $items['NAME']; ?>
                <br/><small class="art"><?= $items['ART']; ?></small>
            </td>
            <td><?= $items['QUANTITY']; ?></td>
        </tr>
        <?endforeach;?>

</table>
<?endif;?>
