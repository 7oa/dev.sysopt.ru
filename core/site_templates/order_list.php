<?php
//echo "<pre>";print_r($arResult);echo "</pre>";
if (!empty($arResult)):
    ?>
    <table class="table table-bordered allTable">
        <tr>
            <th>Номер заказа</th>
            <th>Дата заказа</th>
            <th>Сумма</th>
            <th>Статус</th>
			<th>% оплаты</th>
			<th>% отгрузки</th>
			<th>% долга</th>
			<th>Дата отгрузки</th>
        </tr>
        <?
        foreach ($arResult as $arOrders):
            $date = date('d.m.Y', strtotime($arOrders['date']));
            ?>
            <tr>
                <td><a href="#zakazInfo" class="showDetailZakaz" data-guid="<?= $arOrders['guid'] ?>" data-num="<?= $arOrders['number'] ?>" data-date="<?= $date ?>" data-toggle="modal"><?= $arOrders['number'] ?></a></td>
                <td class="text-center"><?= $date ?></td>
                <td class="text-right"><?= number_format($arOrders['sum'], 2, '.', ' ') ?></td>
                <td class="text-right"><?= $arOrders['status'] ?></td>
				<td class="text-right"><?= $arOrders['paymentPerc'] ?></td>
				<td class="text-right"><?= $arOrders['shipmentPerc'] ?></td>
				<td class="text-right"><?= $arOrders['debtPerc'] ?></td>				
				<td class="text-right">
				<?if (is_array($arOrders['shipmentDate'])):?>
					<?foreach ($arOrders['shipmentDate'] as $arDates):?>
						<?=date('d.m.Y', strtotime($arDates))?><br>
					<?endforeach;?>
				<?else:?>
					<?=($arOrders['shipmentDate']!="0001-01-01") ? date('d.m.Y', strtotime($arOrders['shipmentDate'] )) : "" ;?>
				<?endif;?>
				</td>
            </tr>
        <? endforeach; ?>
    </table>
<? else: ?>
    Нет заказов за выбранный период
<? endif; ?>