<?php

namespace Core\Main;

class Events extends DataManager {

    public static function getTable() {
        return 'events';
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
            'TYPE' => array(
                'data_type' => 'string',
                'required' => true,
                'title' => 'Тип события'
            ),
            'EXECUTE' => array(
                'data_type' => 'string',
                'required' => true,
                'title' => 'Отправлено'
            )
        );
    }

    public function send() {

    }

}
