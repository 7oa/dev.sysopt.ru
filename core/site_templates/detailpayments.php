<strong>Номер:</strong> <?= $arResult["number"] ?> <strong>от</strong> <?= date('d.m.Y', strtotime($arResult["date"])) ?><br/>
<? if ($arResult["order"]): ?><strong>Реализация по заказу:</strong> <?= $arResult["order"] ?><br/><? endif; ?>
<? if ($arResult["sf"]): ?><strong>Счет-фактура:</strong> <?= $arResult["sf"] ?> <br/><? endif; ?>
<? if ($arResult["warehouse"]): ?><strong>Склад:</strong> <?= $arResult["warehouse"] ?><br/><? endif; ?>
<? if ($arResult["organization"]): ?><strong>Организация:</strong> <?= $arResult["organization"] ?><br/><? endif; ?>
<? if ($arResult["manager"]): ?><strong>Менеджер:</strong> <?= $arResult["manager"] ?> <br/><? endif; ?>
<? if ($arResult["comment"]): ?><strong>Комментарий:</strong> <?= $arResult["comment"] ?> <br/><? endif; ?>
<? if ($arResult["account_bank"]): ?><strong>Банк:</strong> <?= $arResult["account_bank"] ?> <br/><? endif; ?>
<? if ($arResult["account_number"]): ?><strong>Банковский счет:</strong> <?= $arResult["account_number"] ?> <br/><? endif; ?>
<? if (!empty($arResult["strings"])): ?>
    <br/>
    <table class="table table-bordered allTable">
        <tr>
            <?if($arResult["name"] == "РеализацияТоваровУслуг"):?><th>Название</th><?endif;?>
            <?if($arResult["name"] == "РеализацияТоваровУслуг"):?><th>Количество</th><?endif;?>
            <?if($arResult["name"] == "РеализацияТоваровУслуг"):?><th width="100">Цена</th><?endif;?>
            <?if($arResult["name"] == "РеализацияТоваровУслуг"):?><th>Скидка</th><?endif;?>
            <?if($arResult["name"] != "РеализацияТоваровУслуг"):?><th>Основание платежа</th><?endif;?>
            <th width="100">Сумма</th>
        </tr>
        <? foreach ($arResult["strings"] as $arPosition): ?>
            <?if($arResult["name"] == "РеализацияТоваровУслуг"):?>
                <tr>
                    <td><?= $arPosition["name"] ?><br/>
                    <small class="art"><?= $arPosition["art"] ?></small></td>
                    <td class="text-right"><?= $arPosition["quantity"] ?></td>
                    <td class="text-right"><?= number_format($arPosition["price"], 2, '.', ' ') ?></td>
                    <td class="text-right"><?= number_format($arPosition["discount"], 2, '.', ' ') ?></td>
                    <td class="text-right"><?= number_format($arPosition["sum"], 2, '.', ' ') ?></td>
                </tr>
            <?else:?>
                <tr>
                    <td><?=$arPosition["name"]?></td>
                    <td><?= number_format($arPosition["sum"], 2, '.', ' ') ?></td>
                </tr>
            <?endif;?>
        <? endforeach; ?>
    </table>
<? endif; ?>
<strong>Сумма:</strong> <?= number_format($arResult["sum"], 2, '.', ' ') ?><br/>
<br/>
<? if ($arResult["name"] == "РеализацияТоваровУслуг"): ?>
    <button type="button" class="btn btn-primary paymentsPrint" data-name="<?= $arResult["name"] ?>" data-guid="<?= $arResult["GUID"] ?>" data-type="torg12"><span class="glyphicon glyphicon-print" aria-hidden="true"></span> ТОРГ-12 </button>
<? endif; ?>
<? if (($arResult["name"] == "РеализацияТоваровУслуг") && (!empty($arResult["sf"]))): ?>
    <button type="button" class="btn btn-primary paymentsPrint" data-name="<?= $arResult["name"] ?>" data-guid="<?= $arResult["GUID"] ?>" data-type="sf"><span class="glyphicon glyphicon-print" aria-hidden="true"></span> Счет-фактура </button>
<? endif; ?>