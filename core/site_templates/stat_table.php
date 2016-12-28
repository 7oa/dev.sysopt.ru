<table class="table table-bordered allTable">
    <tr>
        <th rowspan="2" style="vertical-align: middle;">
            Организация
        </th>
        <th colspan="2">
            Посещений / Дней / Заказов
        </th>
        <th rowspan="2" style="vertical-align: middle;">
            Сессии
        </th>
    </tr>
    <tr>
        <th>
            Всего
        </th>
        <th>
            За выбранный период
        </th>
    </tr>
    <?php if (count($arResult->data) > 0) { ?>
        <?php foreach($arResult->data as $ID => $data) { ?>
        <tr>
            <td rowspan="<?=count($data['rows'])?>" style="width: 20%">
                <?=$data['rows'][0]['ORGANIZATION']?> (<?=$data['rows'][0]['LOGIN']?>)
            </td>
            <td rowspan="<?=count($data['rows'])?>" style="width: 20%; text-align: left;">
                <strong>Посещений:</strong> <?=$data['info']['all_visits']?> <br/>
                <strong>Дней:</strong> <?=$data['info']['all_days']?><br/>
                <strong>Заказов:</strong> <?=$data['info']['all_orders']?>
            </td>
            <td rowspan="<?=count($data['rows'])?>" style="width: 20%; text-align: left">
                <strong>Посещений:</strong> <?=$data['info']['this_visits']?><br/>
                <strong>Дней:</strong> <?=$data['info']['this_days']?><br/>
                <strong>Заказов:</strong> <?=$data['info']['this_orders']?>
            </td>
            <td>
                <?php 
                    echo date("d.m.Y H:i:s", strtotime($data['rows'][0]['TIMESTAMP_X']));
                    if ($data['rows'][0]['TYPE'] == 1) echo " ( Активен ) ";
                ?>
            </td>
        </tr>
        <?php
                if (count($data['rows']) > 1) {
                    for ($i = 1; $i < count($data['rows']); $i++) {

                        $row = $data['rows'][$i];

                        ?>
                        <tr>
                            <td>
                                <?php 
                                    echo date("d.m.Y H:i:s", strtotime($row['TIMESTAMP_X']));
                                ?>
                            </td>
                        </tr>
                        <?php

                    }
                }
            } 
        ?>
    <?php } else { ?>
    <tr>
        <td colspan="4">
            За выбранный период посещений не найдено!
        </td>
    </tr>
    <?php } ?>
</table>