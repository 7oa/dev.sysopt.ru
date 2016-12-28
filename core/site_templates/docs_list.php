<?//echo"<pre>"; print_r($arResult); echo"</pre>";?>
<div><strong>Сальдо конечное: <?= number_format($arResult["ClosingBalance"], 2, '.', ' ') ?></strong></div><br/>
<?
if (!empty($arResult["Documents"])):
    ?>
    <table class="table table-bordered allTable">
        <tbody>
        <tr>
            <th>Документы</th>
            <th>Приход</th>
            <th>Расход</th>
        </tr>
        <?
        if (!array_key_exists(0, $arResult["Documents"]))
            $docs[] = $arResult["Documents"];
        else
            $docs = $arResult["Documents"];

        ?>
        <? foreach ($docs as $arPay): ?>
            <tr>
                <td>
                    <?php if (($arPay["Name"] == "РеализацияТоваровУслуг") || ($arPay["Name"] == "ПриходныйКассовыйОрдер") || ($arPay["Name"] == "ПоступлениеБезналичныхДенежныхСредств") || ($arPay["Name"] == "ОперацияПоПлатежнойКарте")) {?>
                        <a href="#paymentsInfo" class="paymentsInfo" data-toggle="modal" data-name="<?= $arPay["Name"] ?>" data-guid="<?= $arPay["GUID"] ?>">
                            <?= $arPay["Representation"] ?>
                        </a>
                    <?php } else echo $arPay['Representation']; ?>
                </td>
                <td class="text-right"><?= number_format($arPay["SumIn"], 2, '.', ' ') ?></td>
                <td class="text-right"><?= number_format($arPay["SumOut"], 2, '.', ' ') ?></td>
            </tr>
        <? endforeach; ?>

        </tbody>
    </table>
<? else: ?>
    Нет документов за выбранный период<br><br>
<? endif; ?>

<div><strong>Сальдо начальное: <?= number_format($arResult["BeginningBalance"], 2, '.', ' ') ?></strong></div><br/>
</tr>
