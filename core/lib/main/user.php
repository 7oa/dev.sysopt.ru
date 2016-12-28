<?php

namespace Core\Main;

use Core\Main\Visits;

class User extends DataManager {

    const NAME = 'User';

    public static function getTable() {
        return 'user';
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
            'LOGIN' => array(
                'data_type' => 'string',
                'required' => true,
                'title' => 'Логин'
            ),
            'PASSWORD' => array(
                'data_type' => 'string',
                'required' => true,
                'title' => 'Пароль'
            ),
            'HASH' => array(
                'data_type' => 'string',
                'required' => true,
                'title' => 'Хэш'
            ),
            'EXTERNAL' => array(
                'data_type' => 'integer',
                'required' => true,
                'title' => 'Внешний идентификатор'
            ),
            'NAME' => array(
                'data_type' => 'string',
                'required' => true,
                'title' => 'Имя'
            ),
            'LAST_NAME' => array(
                'data_type' => 'string',
                'required' => true,
                'title' => 'Фамилия'
            ),
            'EMAIL' => array(
                'data_type' => 'string',
                'required' => true,
                'title' => 'Email'
            ),
            'ORGANIZATION' => array(
                'data_type' => 'string',
                'required' => true,
                'title' => 'Организация'
            ),
            'INN' => array(
                'data_type' => 'string',
                'required' => true,
                'title' => 'ИНН'
            ),
            'WAREHOUSE' => array(
                'data_type' => 'string',
                'required' => true,
                'title' => 'Склад'
            ),
            'PAYMENT' => array(
                'data_type' => 'string',
                'required' => true,
                'title' => 'Платежи'
            ),
            'CREDIT' => array(
                'data_type' => 'integer',
                'required' => true,
                'title' => 'Кредитный лимит'
            ),
            'AVAIL' => array(
                'data_type' => 'integer',
                'required' => true,
                'title' => 'Идентификатор'
            ),
            'PHONE' => array(
                'data_type' => 'string',
                'required' => true,
                'title' => 'Телефон'
            ),
            'MANAGER' => array(
                'data_type' => 'string',
                'required' => true,
                'title' => 'Менеджер'
            ),
            'MANAGEREMAIL' => array(
                'data_type' => 'string',
                'required' => true,
                'title' => 'Email менеджера'
            ),
            'MANAGERPHONE' => array(
                'data_type' => 'string',
                'required' => true,
                'title' => 'Телефон менеджера'
            ),
            'PRICE' => array(
                'data_type' => 'string',
                'required' => true,
                'title' => 'Прайс'
            ),
            'SHOWDEFAULTPRICE' => array(
                'data_type' => 'string',
                'required' => true,
                'title' => 'Розничные цены'
            ),
            'CONTACTPERSON' => array(
                'data_type' => 'string',
                'required' => true,
                'title' => 'Контактное лицо'
            ),
            'PRICEGROUPDETAL' => array(
                'data_type' => 'string',
                'required' => true,
                'title' => 'уточнения по цен группам'
            ),
            'AGREEMENT' => array(
                'data_type' => 'string',
                'required' => true,
                'title' => 'Соглашение'
            ),
            'NOTICE_TYPE' => array(
                'data_type' => 'integer',
                'primary' => true,
                'autocomplete' => true
            )
        );
    }

    public static function isAuthorized() {
        return ($_SESSION["SESS_AUTH"]["AUTHORIZED"] == "Y");
    }

    public static function getID() {
        if (isset($_SESSION["SESS_AUTH"]["USER_ID"]))
            return $_SESSION["SESS_AUTH"]["USER_ID"];
        else
            return null;
    }

    public static function getByID($id) {
        return static::getByPrimary($id);
    }

    public static function getByExID($id) {
        return static::getByExternal($id);
    }

    public static function setPasswordHash($id, $login, $password) {

        $time = time() + 60 * 60 * 24 * 30 * 12;
        setcookie('S_LOGIN', $login, $time, '/');
        setcookie('S_UIDH', $password, $time, '/');
        $hash = md5($login . '|' . $password);
        $res = static::update($id, array('HASH' => $hash));
        // if ($res->getAffectedRowsCount() > 0)
        return true;
//        else
//            return false;
    }

    public static function logOut() {
        unset($_SESSION);
        session_regenerate_id(true);
        setcookie('S_LOGIN', "", 0, '/');
        setcookie('S_UIDH', "", 0, '/');
        unset($_COOKIE);
    }

    public static function login($login, $password, $ext_id) {

        $parameters['filter'] = array('LOGIN' => $login, 'PASSWORD' => $password, 'EXTERNAL' => $ext_id);
        $parameters['select'] = array('ID');

        $res = static::getList($parameters);
        if ($res->rowsCount() <= 0)
            $id = static::add($parameters['filter']);
        else {
            $arUser = $res->fetchRaw();
            $id = $arUser['ID'];
        }

        if ((int) $id <= 0)
            return false;

        $userInfo = static::getInstance()->getResult('GetUserById', array('id' => $ext_id));

        $today=date("Y-m-d");
        $params = array('user_id' => $ext_id, 'date1' => $today, 'date2' => $today);
        $docs = Payment::getInstance()->getResult('GetMutualPayments', $params);
        if($docs["ClosingBalance"]<0) $avail=$userInfo['Credit']+$docs["ClosingBalance"];
        else $avail=$userInfo['Credit'];
        $updateDate["AVAIL"] = $avail;
       
        unset($userInfo['id']);

        foreach ($userInfo as $k => $value):
            //if (empty($value)) //проверка на пустое значение
                //continue;
            $updateDate[strtoupper($k)] = $value;
        endforeach;
        static::update($id, $updateDate);

        static::setPasswordHash($id, $login, $password);
        $_SESSION["SESS_AUTH"]["USER_ID"] = $id;
        $_SESSION["SESS_AUTH"]['AUTHORIZED'] = 'Y';
        return true;
    }

    public static function loginByHash($login, $password) {
        $hash = md5($login . '|' . $password);

        $parameters['filter'] = array('HASH' => $hash);
        $parameters['select'] = array('ID', 'EXTERNAL');
        $res = self::getList($parameters);
        $db_res = $res->fetchRaw();

        if (intval($db_res['ID']) > 0) {
            static::setPasswordHash($db_res['ID'], $login, $password);
            $_SESSION["SESS_AUTH"]["USER_ID"] = $db_res['ID'];
            $_SESSION["SESS_AUTH"]['AUTHORIZED'] = 'Y';
            
            $userInfo = static::getInstance()->getResult('GetUserById', array('id' => $db_res['EXTERNAL']));
			Visits::addVisitStat($db_res['ID']);
			
            unset($userInfo['id']);
            foreach ($userInfo as $k => $value):
                //if (empty($value)) //проверка на пустое значение
                    //continue;
                $updateDate[strtoupper($k)] = $value;
            endforeach;
            static::update($db_res['ID'], $updateDate);

            return true;
        } else {
            return false;
        }
    }

    public static function add($data) {
        return parent::add($data);
    }

    public static function sendEmail($data, $products, $num, $result = false) {

        foreach ($products as $arProducts) {
            $mailTextBody.="<tr><td>" . $arProducts["PRODUCT_ID"] . "</td><td>" . $arProducts["NAME"] . "</td><td>" . $arProducts["QUANTITY"] . "</td><td>" . $arProducts["PRICE"] . "</td><td>" . $arProducts["PRICE"] * $arProducts["QUANTITY"] . "</td></tr>";
            $price+=($arProducts["PRICE"] * $arProducts["QUANTITY"]);
        }

        if ($data['NOTICE_TYPE'] == 2 || $data['NOTICE_TYPE'] == 3) {
            $phone = $data['PHONE'];
            $text = "Ваш менеджер " . $data['MANAGER'] . " получил заказ";
            $smstext = "https://smsc.ru/sys/send.php?login=".$GLOBALS['config']['smsLogin']."&psw=".$GLOBALS['config']['smsPassword']."&phones=" . $phone . "&mes=" . $text . "&charset=utf-8";
            $sms_address = file_get_contents($smstext);
        }

        $mailTextTop = "<html><body>";
        $mailTextTop.="Заказ №". $num ." от ";
        $mailTextTop.= date('d.m.Y')." ";
		$mailTextTop.= $data["ORGANIZATION"];
        $mailTextTop.="</br></br>";
        $mailTextTop.="<table border='1' cellspacing='0' cellpadding='5' style='padding:10px 0'><tr><th>Код</th><th>Название</th><th>Количество</th><th>Цена</th><th>Сумма</th></tr>";
        $mailTextBottom = "</table></br></br>";
        $mailTextBottom.="Сумма заказа ";
        $mailTextBottom.=$price;
        $mailTextBottom.=" руб.";
        $mailTextBottom.="</body></html>";
        $subject = $_SERVER["SERVER_NAME"].": новый заказ";
        $headers = "Content-type: text/html; charset=utf-8 \r\n";
        $headers.="From: ".$data["MANAGEREMAIL"]." \r\n";
        $mailText = $mailTextTop . $mailTextBody . $mailTextBottom;

        $to = $data['MANAGEREMAIL'];
        if ($data['NOTICE_TYPE'] == 1 || $data['NOTICE_TYPE'] == 3)
            $to = $to.",".$data['EMAIL'];


        if ($result) {
            mail($to, $subject, $mailText, $headers);
        }
    }

    public static function sendEmailChangeStatus($email, $order_id, $event, $param, $value, $result = false) {
        $mailText="Заказ № ";
        $mailText.=$order_id." изменил статус:";
        $mailText.=$value;
        $subject = "Изменен статус заказа";
        $headers = "Content-type: text/html; charset=utf-8 \r\n";
        $headers.="From: АВТОМАСТЕР СИСОПТ <code@webax.org>\r\n";
        $to=$email;

        if ($result) {
            mail($to, $subject, $mailText, $headers);
        }
    }

}
