<?php
if (!empty($arResult["ITEMS"])) {
    ?>
    <table class="table table-bordered tableCatalog allTable" id="catalogSort">
        <thead>
            <tr>
                <th>Название</th>
                <th width="80">Кол-во</th>
                <th width="100">Цена</th>
                <th width="80">Аналоги</th>
                <?if($arResult["DEF_PRICE"]==1):?><th width="100">Розничная</th><?endif;?>
                <th width="130">Заказ</th>
            </tr>
        </thead>
        <tbody>
            <? foreach ($arResult["ITEMS"] as $oneProduct): ?>
                <?php
                $check = $arResult['CHECKED'];
                ob_start();
                ?>
                <tr data-id="<?= $oneProduct["id"] ?>" class="element">
                    <td>
						<div class="pull-right">		
							<button 
								data-id="<?= $oneProduct['id'] ?>" 
								data-price="<?= $oneProduct["price"] ?>" 
								data-name='<?= $oneProduct['name'] ?>' 
								data-quantity="<?= $oneProduct['quantity'] ?>"
								data-art="<?= $oneProduct['art'] ?>" 
								class="btn btn-xs btn-default favoritKey" 
								type="button"
								data-toggle="tooltip"
								data-placement="top"
								title="Добавить в избранное">
								<span 
								<?php if ($oneProduct['favorits'] == 0) { ?>
									class="glyphicon glyphicon-star-empty"
								<?php } else { ?>
									class="glyphicon glyphicon-star"
								<?php } ?>
								></span>
							</button>
						</div>
						
						<a href="#detailCard" data-toggle="modal" class="detailCard" data-id="<?= $oneProduct["id"] ?>"><?= $oneProduct["name"] ?></a>
						<br/><small class="art"><?= $oneProduct["art"] ?></small>
					
                    </td>
                    
                    <td class="text-right"><a href="#detailCity" class="moreByCity" data-toggle="modal" data-id="<?= $oneProduct["id"] ?>"><?= $oneProduct["quantity"] ?></a></td>
                    <td class="text-right"><?= number_format($oneProduct["price"], 2, '.', ''); ?></td>
                    <td class="text-center">
                        <button type="button" class="btn btn-default openAnalogModal" data-id="<?= $oneProduct['id'] ?>" data-toggle="modal" data-target="#analogModal"><span class="glyphicon glyphicon-transfer"></span></button>
                    </td>
                    <?if($arResult["DEF_PRICE"]==1):?><td class="text-right"><?= number_format($oneProduct["priceDefault"], 2, '.', ''); ?></td><?endif;?>
                    <td>
                        <div class="input-group">
                            <input type="number" data-id="<?= $oneProduct["id"] ?>" class="form-control cnt-basket" value="1" placeholder="1" min="1" max="<?= $quantity; ?>">
                            <span class="input-group-btn">
                                <button data-id="<?= $oneProduct["id"] ?>" data-name='<?= $oneProduct["name"] ?>' data-price="<?= $oneProduct["price"] ?>" data-art="<?= $oneProduct["art"] ?>" class="btn btn-default to-basket" type="button"><span class="glyphicon glyphicon-shopping-cart"></span></button>
                            </span>
                        </div>
                    </td>
                </tr>
                <?php
                    $content = ob_get_clean();
                    if ($check == "Y") {
                        if ($oneProduct['quantity'] > 0) {
                            echo $content;
                        }
                    } else {
                        echo $content;
                    }
                ?>
            <? endforeach; ?>
        </tbody>
    </table>
	
    <?
}
else {
	if($arResult["SEARCH"]=="Y") echo '<span>По Вашему запросу ничего не найдено</span>';
    else echo '<span>У выбранного раздела отсутствуют элементы</span>';
}