<?php

include $_SERVER['DOCUMENT_ROOT'] . '/core/loader/prolog_before.php';

use Core\Main\User,
    Core\Main\Visits,
    Core\Main\Template;

$data = $_POST;
$USER_ID = User::getID();
$userInfo = User::getByID($USER_ID);
$user=User::getInstance();

switch ($data['TYPE']) {
    case 'update':
        $params=array(
            'id' => $userInfo["EXTERNAL"],
            'email'=>$data["email"],
            'phone'=>$data["phone"]
        );
        $update=$user->getResult('EditContacts', $params);
        $uUpdate = $user->update($USER_ID, array('PHONE'=>$data['phone'], 'EMAIL'=>$data['email']));
        echo $update;
        break;
    case 'notice':
        $email = $data['email'];
        $phone = $data['phone'];
        $notice = 0;
        if ($email == "Y" && $phone == "Y") $notice = 3;
        elseif ($email == "Y" && $phone == "N") $notice = 1;
        elseif ($phone == "Y" && $email == "N") $notice = 2;
        elseif ($phone == "N" && $email == "N") $notice = 0;
        $update = $user->update($USER_ID, array("NOTICE_TYPE"=>$notice));
        break;
    case 'supportMail':
        ob_start();
            Template::includeTemplate('support_mail', $data);
        $mail = ob_get_clean();

        $to = $GLOBALS['config']['dmail'];
        $subject = "СИСОПТ ".$_SERVER['SERVER_NAME'].": Вопрос в техподдержку";
        $headers = "Content-type: text/html; charset=utf-8 \r\n From: ".$GLOBALS['config']['dmail']." \r\n";

        mail($to, $subject, $mail, $headers);
        break;
    case 'changePass':
        $params=array(
            'id' => $userInfo["EXTERNAL"],
            'password'=>$data["pass"]
        );
        $update=$user->getResult('ChangePassword', $params);
        $pass = md5($data['pass']);
        $uUpdate = $user->update($USER_ID, array('PASSWORD'=>$pass));
        echo $update;
        break;
    case 'statList':
        $from = strtotime($data["dfrom"]);
        $to = strtotime($data["dto"]);
        if (isset($to)) $to = $to + 86400;
        $visits = new Visits($from, $to);
        Template::includeTemplate("stat_table", $visits);
        break;
}