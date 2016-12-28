<?php

include 'print_var.php';

use Core\Main\DbSession,
    Core\Main\User,
    Core\Main\Template;

ini_set("session.cookie_httponly", "1");

DbSession::initHandlers();
session_start();

$_SESSION['SESS_TIME_OLD'] = $_SESSION['SESS_TIME'];

$currTime = time();


if (($_SESSION['SESS_IP'] && (ip2long($_SERVER['REMOTE_ADDR']) != ip2long($_SESSION['SESS_IP']))) || ($currTime - 3600 >= $_SESSION['SESS_TIME'])) {

    User::logOut();
    $_SESSION = array();
    @session_destroy();
    DbSession::initHandlers();
    session_id(md5(uniqid(rand(), true)));
    session_start();
    if (isset($_SERVER['HTTP_X_REQUESTED_WITH']) && $_SERVER['HTTP_X_REQUESTED_WITH'] == 'XMLHttpRequest') {
        Template::includeTemplate('session_expired');
        exit();
    }
}


$_SESSION['SESS_IP'] = $_SERVER['REMOTE_ADDR'];
$_SESSION['SESS_TIME'] = time();

$cookie_login = $_COOKIE['S_LOGIN'];
$cookie_md5pass = $_COOKIE['S_UIDH'];

$bLogout = isset($_REQUEST["logout"]) && (strtolower($_REQUEST["logout"]) == "yes");

// if user try to logout
if ($bLogout) {
    User::logOut();
    header("Location: " . '/auth/');
}

// login user by hash
if (strlen($cookie_login) > 0 && strlen($cookie_md5pass) > 0 && !User::isAuthorized() && !$bLogout) {
    $result = User::loginByHash($cookie_login, $cookie_md5pass);
    if (!$result) {
        header("Location: " . '/auth/');
    }
}

// if user not auth
if (!User::isAuthorized() && strlen($cookie_login) <= 0 && strlen($cookie_md5pass) <= 0 && $_SERVER['REQUEST_URI'] != '/auth/'
) {
    header("Location: " . '/auth/');
}

// user try to auth
if (isset($_POST['AUTH_FORM']) && $_POST['AUTH_FORM'] <> ''):
    $login = filter_input(INPUT_POST, 'LOGIN');
    $password = filter_input(INPUT_POST, 'PASS');

    $res = User::getInstance()->getResult('CheckUserAuth', array('username' => $login, 'password' => md5($password)));

    if ($res !== 'false') {
        $result = User::login($login, md5($password), $res);
        if ($result) {
            header("Location: " . '/');
        }
    } else {
        $GLOBALS['AUTH_RES'] = 'Неверный логин или пароль';
    }
endif;


define('TEMPLATE_PATH', '/core/templates/main');
