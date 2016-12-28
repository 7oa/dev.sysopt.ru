<?php
//echo "<pre>";print_r($arResult);echo "</pre>";
if (!empty($arResult)):
    ?>
    <table class="table table-bordered allTable">
        <tr>
            <th width="200">Дата шаблона</th>
            <th>Название шаблона</th>
            <th width="100">Удалить</th>
        </tr>
        <?php
        foreach ($arResult as $arSamples) {
            ?>
            <tr>
                <td class="text-center">
                        <?=date('d.m.Y', strtotime($arSamples["TIMESTAMP_X"]))?>
                </td>
                <td class="text-left"><a href="#detailSampleCard" data-toggle="modal" class="detailSampleCard" data-sname="<?= $arSamples["S_NAME"] ?>" data-id="<?= $arSamples["ID"] ?>"><?= $arSamples["S_NAME"] ?></a></td>
                <td class="text-center">
                    <button class="btn btn-xs btn-default delSampleItem" type="button" data-id="<?= $arSamples["ID"] ?>"><span class="glyphicon glyphicon-remove"></span></button>
                </td>
            </tr>
        <?php } ?>
    </table>
<? else: ?>
    Нет сохраненных шаблонов
<? endif; ?>


