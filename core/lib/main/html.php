<?php

namespace Core\Main;

/**
 * @deprecated old class no use
 */
class Html {

    static function orderListHtml($type, $items = array()) {
        switch ($type):
            case "table":
                $html = '<table class="table table-bordered allTable"><tr><th>Номер заказа</th><th>Дата заказа</th><th>Сумма</th><th>Статус</th></tr>#ITEMS#</table>';
                break;
            case "items":
                foreach ($items as $arOrders):
                    $formatePrice = number_format($arOrders['sum'], 2, '.', ' ');
                    $date = date('d.m.Y', strtotime($arOrders['date']));
                    $html .= <<<EOF
            <tr>
                <td><a href="#zakazInfo" class="showDetailZakaz" data-num="{$arOrders['number']}" data-date="{$date}" data-toggle="modal">{$arOrders['number']}</a></td>
                <td class="text-center">{$date}</td>
                <td class="text-right">{$formatePrice}</td>
                <td class="text-right">{$arOrders['status']}</td>
            </tr>
EOF;
                endforeach;
                break;
        endswitch;

        return $html;
    }

    static function orderDetailHtml($type, $items = array()) {
        switch ($type):
            case "table":
                $html = '<table class="table table-bordered allTable"><tr><th>Код</th><th>Название</th><th>Количество</th><th width="100">Цена за шт.</th><th width="100">Сумма</th></tr>#ITEMS#</table><div class="text-right"><div>Итого: <span class="zakazItog">#PRICE#</span> руб.</div></div>';
                break;
            case "items":
                foreach ($items['strings'] as $option):
                    $formatePrice = number_format($option['price'], 2, '.', ' ');
                    $formateSumm = number_format($option['sum'], 2, '.', ' ');
                    $html .= <<<EOF
                        <tr>
                            <td>{$option['id']}</td>
                            <td>{$option['name']}</td>
                            <td class="text-right">{$option['quantity']}</td>
                            <td class="text-right">{$formatePrice}</td>
                            <td class="text-right">{$formateSumm}</td>
                        </tr>
EOF;
                endforeach;
                break;
        endswitch;

        return $html;
    }

    static function orderDetailButtons($id, $date) {
        $html.= "<button type='button' class='btn btn-success zakazRepeat' data-number='{$id}' data-date='{$date}' data-form='custom'>Повторить заказ</button> &nbsp;";
        $html.= "<button type='button' class='btn btn-primary zakazPrint' data-number='{$id}' data-date='{$date}' data-form=''><span class='glyphicon glyphicon-print' aria-hidden='true'></span>Форма без печати</button>&nbsp;";
        $html.= "<button type='button' class='btn btn-primary zakazPrint' data-number='{$id}' data-date='{$date}' data-form='custom'><span class='glyphicon glyphicon-print' aria-hidden='true'></span>Форма с печатью</button>";
        return $html;
    }

    static function basketItem() {
        $html = <<<EOF
               <tr id="tr#RESULT#">
                   <td>#PRODUCT_ID#</td>
                   <td>#NAME#</td>
                   <td class="text-right">#FORMATED_PRICE#</td>
                   <td class="text-right"><input type="number" data-trid="#RESULT#" class="form-control cnt-basket-changer" value="#QUANTITY#" placeholder="#QUANTITY#" min="1" max=""></td><td class="b-sum text-right" id="price-#RESULT#">#FORMATED_SUM#</td>
               <td class="text-center">
                   <button class="btn btn-xs btn-default delBacketItem" type="button" data-id="#RESULT#"><span class="glyphicon glyphicon-remove"></span></button>
               </td>
              </tr>
EOF;

        return $html;
    }

    static function catalogItems($type, $oneProduct = array()) {
        switch ($type):
            case "table":
                $html = '<table class="table table-bordered tableCatalog allTable" id="catalogSort"><thead>
			<tr>
				<th>Код</th>
				<th>Название</th>
				<th width="80">Кол-во</th>
				<th width="100">Цена</th>
				<th width="130">Заказ</th>
			</tr>
		</thead>
		<tbody>#ITEMS#</tbody>
                </table>';
                break;
            case 'items':
                $html = <<<EOF
                    <tr data-id="{$oneProduct["id"]}" class="element">
                <td><a href="#detailCard" data-toggle="modal" class="detailCard" data-id="{$oneProduct["id"]}">{$oneProduct["id"]}</a></td>
                <td>{$oneProduct["name"]}</td>
                <td class="text-right">{$oneProduct["quantity"]}</td>
                <td class="text-right">{$oneProduct["FORMATED_PRICE"]}</td>
                <td>
                    <div class="input-group">
                        <input type="number" data-id="{$oneProduct["id"]}" class="form-control cnt-basket" value="1" placeholder="1" min="1" max="{$quantity}">
                        <span class="input-group-btn">
                            <button data-id="{$oneProduct["id"]}" data-name="{$oneProduct["name"]}" data-price="{$oneProduct["price"]}" class="btn btn-default to-basket" type="button"><span class="glyphicon glyphicon-shopping-cart"></span></button>
                        </span>
                    </div>
                </td>
            </tr>
EOF;

                break;
        endswitch;

        return $html;
    }

    static function catalogDetail($product) {
        $formatedPrice = number_format($product["price"], 2, '.', '');
        $html .= <<<EOF
                <strong>{$product["name"]}</strong><br/><br/>
                <img src="{$product['img']}" class="img-thumbnail pull-left datailCardImg">       
EOF;
        if (!empty($product['description']))
            $html .= "<strong>Описание:</strong> {$product["description"]}<br/>";
        if (!empty($product['id']))
            $html .= "<strong>Код:</strong> {$product["id"]}<br/>";
        if (!empty($product['art']))
            $html .= "<strong>Артикул:</strong> {$product["art"]}<br/>";
        if (!empty($product['unit']))
            $html .= "<strong>Единицы измерения:</strong> {$product["unit"]}<br/>";
        if (!empty($product['manufacturer']))
            $html .= "<strong>Производитель:</strong> {$product["manufacturer"]}<br/>";

        $html .= "<strong>Количество:</strong> {$product["quantity"]}<br/>";
        $html .= "<strong>Цена:</strong> {$formatedPrice}<br/>";

        $html .= <<<EOF
                <div class="detailZakaz">
                    <strong>Добавить в корзину:</strong>
                    <div class="input-group">
                        <input type="number" data-id="{$product["id"]}" class="form-control cnt-basket" value="1" placeholder="1" min="1">
                        <span class="input-group-btn">
                            <button data-id="{$product["id"]}" data-name="{$product["name"]}" data-price="{$product["price"]}" class="btn btn-default to-basket" type="button"><span class="glyphicon glyphicon-shopping-cart"></span></button>
                        </span>
                    </div>
                </div>
                <div class="clearfix"></div>
EOF;

        return $html;
    }

}
