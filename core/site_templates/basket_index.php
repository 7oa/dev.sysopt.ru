<?
use Core\Main\User;
$arBacket = $arResult->getBasketItems();
$USER_ID = User::getID();
$userInfo = User::getByID($USER_ID);
$address=User::getInstance()->getResult('GetAddressesById', array('id' => $userInfo["EXTERNAL"]));
if ($address){
    if (!is_array($address["Strings"]))
        $arAddr[] = $address["Strings"];
    else
        $arAddr = $address["Strings"];
}
?>
<h1>Текущий заказ</h1>
<div class="orderStatus"></div>
<div class="emptyBasket"></div>

<div class="blackBack"></div>

<div class="backetDiv">
    <div class="basketTableAjax">
        <table class="table table-bordered tableBasket allTable">
            <thead>
            <tr>
                <th>Название</th>
                <th>Цена</th>
                <th width="100">Количество</th>
                <th>Сумма</th>
                <th width="70">Удалить</th>
            </tr>
            </thead>
            <tbody>
            <?
            if ($arResult->getItemsCount() > 0):
                foreach ($arBacket as $bItems):
                    ?>
                    <tr id="tr<?= $bItems["ID"] ?>">
                        <td>
							<a href="#detailCard" data-toggle="modal" class="detailCard" data-id="<?= $bItems["PRODUCT_ID"] ?>"><?= $bItems["NAME"] ?></a>
							<br/><small class="art"><?= $bItems["ART"] ?></small>
						</td>
                        <td class="text-right"><?= $arResult->formatePrice($bItems['PRICE']) ?></td>
                        <td class="text-right"><input type="number" data-trid="<?= $bItems["ID"] ?>" class="form-control cnt-basket-changer" value="<?= $bItems["QUANTITY"] ?>" placeholder="<?= $bItems["QUANTITY"] ?>" min="1" max=""></td>
                        <td class="b-sum text-right" id="price-<?= $bItems["ID"] ?>"><?= $arResult->formatePrice($bItems['FULL_PRICE']) ?></td>
                        <td class="text-center">
                            <button class="btn btn-xs btn-default delBacketItem" type="button" data-id="<?= $bItems["ID"] ?>"><span class="glyphicon glyphicon-remove"></span></button>
                        </td>
                    </tr>
                    <?
                endforeach;
            endif;
            ?>
            </tbody>
        </table>

        <div class="text-right">
            <div>Итого: <span class="basketItog" id="full-cart-price"><?= $arResult->getPrice() ?></span> руб.</div>
        </div>
    </div>



    <div class="row shipBlock text-right">
        <div class="col-sm-12">
            <h3>Выберите вариант доставки:</h3>
        </div>

        <div class="col-sm-12">
            <div class="radio deliveryRadio">
                <label>
                    <input type="radio" class="deliveryRadioOne" name="deliveryRadios" id="deliveryOptR1" value="0" data-id="0" checked>
                    Самовывоз
                </label>
                <label>
                    <input type="radio" class="deliveryRadioOne" name="deliveryRadios" id="deliveryOptR2" value="1" data-id="1">
                    До клиента
                </label>
                <label>
                    <input type="radio" class="deliveryRadioOne" name="deliveryRadios" id="deliveryOptR3" value="2" data-id="2">
                    Силами перевозчика
                </label>
            </div>
        </div>



        <div class="col-sm-12">
            <label for="shipAddress" class="text-left">Адрес доставки:</label><br/>

            <?if($arAddr):?>
            <select class="form-control input600" id="shipAddress">
                <?foreach($arAddr as $addr):?>
                <option><?=$addr?></option>
                <?endforeach;?>
            </select>
            <?else:?>
                <input type="text" name="shipAddress" id="shipAddress" class="input600 form-control" placeholder="Введите адрес доставки">
            <?endif;?>
        </div>

        <div class="col-sm-12 margin20 shipmentCompanyBlock">
            <label for="shipmentCompany" class="text-left">Транспортная компания:</label><br/>
            <input type="text" name="shipmentCompany" id="shipmentCompany" class="input600 form-control" placeholder="Впишите желаемую транспортную компанию для осуществления доставки">
        </div>
    </div>

    <div class="row commentBlock text-right">
        <div class="col-sm-12">
            <h3>Комментарий:</h3>
        </div>

        <div class="col-sm-12">
            <textarea name="commentOrder" id="commentOrder" class="input600 form-control" placeholder="Ваш комментарий"></textarea>
        </div>
    </div>



    <div class="text-right">
        <button type="button" class="btn btn-default saveSampleBlock" data-toggle="modal" data-target="#save_template">
            Сохранить заказ как шаблон
        </button>
        <button type="button" class="btn btn-primary checkout">
            <span class="glyphicon glyphicon-ok-sign" aria-hidden="true"></span> Оформить заказ
        </button>
    </div>

    <div class="modal fade" id="save_template" tabindex="-1" role="dialog" aria-labelledby="userModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-sm">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="modal-title" id="userModalLabel">Добавить шаблон</h4>
                </div>
                <div class="modal-body">
                    <div id="sampleStatus" class="alert alert-warning sampleWarning"></div>
                    <input type="text" class="form-control sample-name" placeholder="Введите название шаблона" >
                    <div class="alert alert-success samplesSuccess"></div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default to-samples">Сохранить</button>
                    <button type="button" class="btn btn-default sampleClose" data-dismiss="modal">Закрыть</button>
                </div>
            </div>
        </div>
    </div>


</div>