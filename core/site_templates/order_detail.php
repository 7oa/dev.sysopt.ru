<div class="pull-right text-right">
    <button type="button" class="btn btn-default saveSampleBlockByOrder" data-toggle="modal" data-target="#save_order_template">
        Сохранить заказ как шаблон
    </button>
    <button type="button" class="btn btn-default zakazRepeat" data-number="<?= $arResult["number"] ?>" data-date="<?= $arResult["date"] ?>" data-form="custom">Повторить заказ</button>
	<br/><br/>
	<button type="button" class="btn btn-primary zakazPrint" data-number="<?= $arResult["number"] ?>" data-date="<?= $arResult["date"] ?>" data-form=""><span class="glyphicon glyphicon-print" aria-hidden="true"></span> Счет на оплату </button>
    <?if($arResult["DEF_PRICE"]=="1"):?>
        <button type="button" class="btn btn-primary zakazPrint" data-number="<?= $arResult["number"] ?>" data-date="<?= $arResult["date"] ?>" data-form="custom_prices"><span class="glyphicon glyphicon-print" aria-hidden="true"></span> Счет на оплату с розничными ценами </button>
    <?endif;?>
</div>
<strong>Доставка:</strong> <?=$arResult["shipmentType"]?><br/>
<strong>Адрес доставки:</strong> <?=$arResult["shipmentAddress"]?><br/>
<?if($arResult["comment"]):?><strong>Комментарий:</strong> <?=$arResult["comment"]?><br/><?endif;?>
<div class="clearfix"></div>

<?if($arResult["DOCS"]):?>
<?//echo"<pre>";print_r($arResult["DOCS"]);echo"</pre>";?>
<?
if (!array_key_exists(0, $arResult["DOCS"]))
    $docs[] = $arResult["DOCS"];
else
    $docs = $arResult["DOCS"];

?>
<div>
    <h4>Документы, связанные с заказом</h4>
    <ul>
        <?php foreach($docs as $arDocs) { ?>
            <li>
                <?php if (($arDocs["name"] == "РеализацияТоваровУслуг") || ($arDocs["name"] == "ПриходныйКассовыйОрдер") || ($arDocs["name"] == "ПоступлениеБезналичныхДенежныхСредств") || ($arDocs["name"] == "ОперацияПоПлатежнойКарте")) { ?>
                <a href="#paymentsInfo" class="paymentsInfo" data-toggle="modal" data-name="<?=$arDocs["name"]?>" data-guid="<?=$arDocs["GUID"]?>">
                    <?=$arDocs["representation"]?> <?=$arDocs["number"]?> от <?=date('d.m.Y', strtotime($arDocs["date"]))?> на сумму <?= number_format($arDocs["sum"], 2, '.', ' '); ?>
                </a>
                <?php } else { ?>
                    <?=$arDocs["representation"]?> <?=$arDocs["number"]?> от <?=date('d.m.Y', strtotime($arDocs["date"]))?> на сумму <?= number_format($arDocs["sum"], 2, '.', ' '); ?>
                <?php } ?>
            </li>
        <?php } ?>
    </ul>
</div>

<?endif;?>
<br/>



<table class="table table-bordered allTable">
    <tr>
        <th>Название</th>
        <th>Количество</th>
        <th width="100">Цена за шт.</th>
        <th width="100">Сумма</th>
    </tr>
    <?
    $sum = 0;
    foreach ($arResult['strings'] as $option):
        ?>
        <tr>
            <td>
				<div class="pull-right">		
					<button 
						data-id="<?= $option['id'] ?>" 
						data-price="<?= $option["price"] ?>" 
						data-name="<?= $option['name'] ?>" 
						data-quantity="<?= $option['quantity'] ?>"
						data-art="<?= $option['art'] ?>" 
						class="btn btn-xs btn-default favoritKey" 
						type="button"
						title="Добавить в избранное">
						<span 
						<?php if ($option['favorits'] == 0) { ?>
							class="glyphicon glyphicon-star-empty"
						<?php } else { ?>
							class="glyphicon glyphicon-star"
						<?php } ?>
						></span>
					</button>
				</div>
				<?= $option['name']; ?>
				<br/><small class="art"><?= $option['art']; ?></small>
            </td>
            <td class="text-right"><?= $option['quantity']; ?></td>
            <td class="text-right"><?= number_format($option['price'], 2, '.', ' '); ?></td>
            <td class="text-right"><?= number_format($option['sum'], 2, '.', ' '); ?></td>
        </tr>
        <?
        $sum+=$option['sum'];
    endforeach;
    ?>

</table>
<div class="text-right">
    <div>Итого: <span class="zakazItog"><?= number_format($sum, 2, '.', ' ') ?></span> руб.</div>
</div>


<div class="modal fade" id="save_order_template" tabindex="-1" role="dialog" aria-labelledby="userModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-sm">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" id="userModalLabel">Добавить шаблон</h4>
            </div>
            <div class="modal-body">
                <div id="sampleStatusOrder" class="alert alert-warning sampleWarningOrder"></div>
                <input type="text" class="form-control sample-name-by-order" placeholder="Введите название шаблона" >
                <div class="alert alert-success samplesSuccessOrder"></div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default to-samples-by-order" data-number="<?= $arResult["number"] ?>" data-date="<?= $arResult["date"] ?>">Сохранить</button>
                <button type="button" class="btn btn-default sampleCloseOrder" data-dismiss="modal">Закрыть</button>
            </div>
        </div>
    </div>
</div>