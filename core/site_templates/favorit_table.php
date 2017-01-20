<?if ($arResult):?>
<table class="table table-bordered allTable" id="favoritSort">
	<thead>
		<th>Название</th>
		<th>Цена</th>
		<th>Количество</th>
		<th>Заказ</th>
		<th>Удалить</th>
	</thead>
	<tbody>
		<?php 
		foreach($arResult as $row):
		?>
		<tr>
			<td style="vertical-align: middle;">
				<a href="#detailCard" data-toggle="modal" class="detailCard" data-id="<?= $row["PRODUCT_ID"] ?>"><?=$row['NAME']?></a>
				<br/><small class="art"><?=$row['ART']?></small>
			</td>
			<td style="width: 200px; text-align: right;">
				<?= number_format($row['PRICE'], 2, '.', ''); ?>
			</td>
			<td style="width: 130px; text-align: right;">
				<a href="#detailCity" class="moreByCity" data-toggle="modal" data-id="<?= $row["PRODUCT_ID"] ?>"><?= $row['QUANTITY'] ?></a>
			</td>
			<td style="width: 130px;">
				<div class="input-group">
                    <input type="number" data-id="<?=$row['PRODUCT_ID']?>" class="form-control cnt-basket" value="1" placeholder="1" min="1" max="<?= $row['QUANTITY'] ?>">
                    <span class="input-group-btn">
                        <button data-id="<?= $row["PRODUCT_ID"] ?>" data-name='<?= $row["NAME"] ?>' data-price="<?= $row['PRICE']?>" data-art="<?= $row["ART"] ?>" class="btn btn-default to-basket" type="button"><span class="glyphicon glyphicon-shopping-cart"></span></button>
                    </span>
                </div>
			</td>
			<td style="width: 50px; text-align: center; vertical-align: middle;">
				<button class="btn btn-xs btn-default removeFavorit" type="button" data-id="<?=$row['ID']?>">
					<span class="glyphicon glyphicon-remove"></span>
				</button>
			</td>
		</tr>
		<?endforeach;?>
	</tbody>
</table>
<?else:?>
Не добавленно ни одного товара
<?endif;?>