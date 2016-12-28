<?php

namespace Core\Main;

class OrderStatus extends DataManager {

    public static function getTable() {
        return 'order_status';
    }

    public static function getFieldMap() {
        return array(
            'ID' => array(
                'data_type' => 'integer',
                'primary' => true,
                'autocomplete' => true,
                'title' => 'Идентификатор'
            ),
            'TIMESTAMP_X' => array(
                'data_type' => 'datetime',
                'required' => true,
                'title' => 'Время изменения'
            ),
            'USER_ID' => array(
                'data_type' => 'string',
                'required' => true,
                'title' => 'Пользователь'
            ),
            'ORDER_ID' => array(
                'data_type' => 'string',
                'required' => true,
                'title' => 'Заказ'
            ),
            'STATUS' => array(
                'data_type' => 'string',
                'required' => true,
                'title' => 'Статус'
            )
        );
    }
    
    
}
