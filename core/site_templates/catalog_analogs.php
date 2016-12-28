<?php if ($arResult) { ?>
    <table class="table table-bordered tableCatalog allTable">
        <thead>
            <tr>
                <th>Название</th>
                <th width="80">Кол-во</th>
                <th width="100">Цена</th>
                <th width="130">Заказ</th>
            </tr>
        </thead>
        <tbody>
            <?php
                foreach($arResult as $oneAnalogs) {
                    ?>
                    <tr>
                        <td>
                            <a href="#detailCard" data-toggle="modal" class="detailCard" data-id="<?= $oneAnalogs["id"] ?>">
                                <?=$oneAnalogs['name']?>
                            </a>
                            <br/><small class="art"><?= $oneAnalogs["art"] ?></small>
                        </td>
                        <td class="text-right">
                            <a href="#detailCity" class="moreByCity" data-toggle="modal" data-id="<?= $oneAnalogs["id"] ?>">
                                <?= $oneAnalogs["quantity"] ?>
                            </a>
                        </td>
                        <td class="text-right">
                            <?= number_format($oneAnalogs["price"], 2, '.', ''); ?>
                        </td>
                        <td>
                            <div class="input-group">
                                <input type="number" data-id="<?= $oneAnalogs["id"] ?>" class="form-control cnt-basket" value="1" placeholder="1" min="1" max="<?= $oneAnalogs['quantity']; ?>">
                            <span class="input-group-btn">
                                <button data-id="<?= $oneAnalogs["id"] ?>" data-name='<?= $oneAnalogs["name"] ?>' data-price="<?= $oneAnalogs["price"] ?>" data-art="<?= $oneAnalogs["art"] ?>" class="btn btn-default to-basket" type="button"><span class="glyphicon glyphicon-shopping-cart"></span></button>
                            </span>
                            </div>
                        </td>
                    </tr>
                    <?php
                }
            ?>
        </tbody>
    </table>
<?php } ?>
