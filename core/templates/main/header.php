<!DOCTYPE html>
<?
use Core\Main\User,
    Core\Main\Basket;

$isAuthPage = $_SERVER['REQUEST_URI'] != '/auth/';
if ($isAuthPage) {
    $USER_ID = User::getID();
    $userInfo = User::getByID($USER_ID);
    $basket = Basket::getInstance(false);
}
?>
<html>
    <head>
        <meta http-equiv="content-type" content="text/html; charset=utf-8" />
        <title>Система самообслуживания оптовых клиентов</title>
        <link rel="icon" type="image/png" href="<?= TEMPLATE_PATH ?>/images/favicon.png" />
        <link rel="stylesheet" href="<?= TEMPLATE_PATH ?>/css/bootstrap.min.css">
        <link rel="stylesheet" href="<?= TEMPLATE_PATH ?>/css/bootstrap-theme.min.css">
        <link rel="stylesheet" href="<?= TEMPLATE_PATH ?>/css/bootstrap-datetimepicker.min.css">
        <link rel="stylesheet" href="<?= TEMPLATE_PATH ?>/template_styles.css">
        <script src="<?= TEMPLATE_PATH ?>/js/jquery-1.10.1.min.js"></script>
        <script src="<?= TEMPLATE_PATH ?>/js/bootstrap.min.js"></script>
        <script src="<?= TEMPLATE_PATH ?>/js/moment-with-locales.min.js"></script>
        <script src="<?= TEMPLATE_PATH ?>/js/bootstrap-datetimepicker.min.js"></script>
        <script src="<?= TEMPLATE_PATH ?>/js/jquery.tablesorter.min.js"></script>
        <script src="<?= TEMPLATE_PATH ?>/js/jquery.tablesorter.pager.js"></script>
        <script src="<?= TEMPLATE_PATH ?>/js/bootstrap-checkbox.min.js"></script>
        <script src="<?= TEMPLATE_PATH ?>/js/functions.js"></script>
        <script src="<?= TEMPLATE_PATH ?>/js/scrollup.js"></script>
        <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
        <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
        <!--[if lt IE 9]>
          <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
          <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
        <![endif]-->
    </head>
    <body>
        <? if ($isAuthPage) { ?>
            <? if ($_GET["session"] == "Y"): ?>
                <h1>Сессия</h1>
                <div class="alert alert-info" role="alert">
                    <?
                    echo 'curTime-' . $currTime . PHP_EOL . 'sessTime-' . $_SESSION['SESS_TIME'] . PHP_EOL . 'sessTimeOld-' . $_SESSION['SESS_TIME_OLD'];
                    ?></div>
            <? endif; ?>
            <div class="wrapper">
                <div class="container fix" id="header">
                    <div class="firstHeadLine">
                        <div class="logo"><a href="/"><img src="<?= TEMPLATE_PATH ?><?= $GLOBALS['config']['logoDir'] ?>"></a></div>
                        <div class="text-right topInfo">
                            <div class="login"><?= $userInfo['ORGANIZATION'] ?> <br/><?= $userInfo['CONTACTPERSON'] ?>, <a href="?logout=yes">Выйти</a></div>

                        </div>
                    </div>
                    <button type="button" class="btn btn-default btn-xs btnInfo" data-toggle="modal" data-target="#userInfo"><span class="glyphicon glyphicon-user"></span> Инфо</button>
                    <?if (!isset($_GET['stat'])):?>
                    <div class="menuLine">
                        <div id="top_menu">
                            <ul class="nav navbar-nav topmenu">
                                <li class="active"><a href="#catalog" data-toggle="tab">Каталог</a></li>
                                <li><a href="#basket" data-toggle="tab" class="backetLink">Текущий заказ <span class="badge countCol"><?= $basket->getItemsCount() ?></span></a></li>
                                <li><a href="#orders" class="tab-orders" data-toggle="tab">Заказы</a></li>
                                <li><a href="#payments" data-toggle="tab">Взаиморасчеты</a></li>
                                <li><a href="#samples" data-toggle="tab" class="tab-samples">Шаблоны</a></li>
                                <li><a href="#favorits" class="tab-favorits" data-toggle="tab">Избранное</a></li>
                            </ul>

                        </div>
                    </div>
                    <?endif;?>
                </div>
                
                <div class="modal fade" id="userInfo" tabindex="-1" role="dialog" aria-labelledby="userModalLabel" aria-hidden="true">
                    <div class="modal-dialog modal-lg">
                        <div class="modal-content">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                <h4 class="modal-title" id="userModalLabel"><?= $userInfo['ORGANIZATION'] ?></h4>
                            </div>
                            <div class="modal-body">
                                <div class="row">
                                    <div class="col-xs-6">
                                        <div class="panel panel-primary">
                                            <div class="panel-heading">
                                                <h3 class="panel-title">Данные об организациия</h3>
                                            </div>
                                            <div class="panel-body">
                                                <strong>Организация:</strong> <?= $userInfo["ORGANIZATION"] ?><br/>
                                                <strong>ИНН:</strong> <?= $userInfo["INN"] ?><br/>
                                            </div>
                                        </div>

                                        <div class="panel panel-primary">
                                            <div class="panel-heading">
                                                <h3 class="panel-title">Данные по соглашению</h3>
                                            </div>
                                            <div class="panel-body">
                                                <strong>Склад:</strong> <?= $userInfo["WAREHOUSE"] ?><br/>
                                                <strong>Платежи:</strong> <?= $userInfo["PAYMENT"] ?><br/>
                                            </div>
                                        </div>

                                        <div class="panel panel-primary">
                                            <div class="panel-heading">
                                                <h3 class="panel-title">Настройки уведомлений</h3>
                                            </div>
                                            <div class="panel-body">
                                                <?php
                                                    $notice = $userInfo['NOTICE_TYPE'];
                                                    $e_notice = "checked";
                                                    $p_notice = "checked";
                                                    if ($notice === "0") {
                                                        $p_notice = "";
                                                        $e_notice = "";
                                                    }
                                                    if ($notice == "1") $p_notice = "";
                                                    if ($notice == "2") $e_notice = "";
                                                    if ($GLOBALS['config']['demo'] == "1") $demo = "disabled";
                                                ?>
                                                <strong>Получать уведомления на E-mail:</strong>
                                                    <div class="pull-right">
                                                        <input <?= $demo ?> data-group-cls="btn-group-sm" id="changeContactNoticeEmail" class="changeContactNotice" type="checkbox" value="Y" <?= $e_notice ?> />
                                                    </div>
                                                <div class="clearfix"></div>
                                                <br />
                                                <div style="<?php if ($GLOBALS['config']['demo'] != 0) {?>display: none <?php } ?>">
                                                    <strong>Получать уведомления по SMS:</strong>
                                                    <div class="pull-right">
                                                        <input <?= $demo ?> data-group-cls="btn-group-sm" id="changeContactNoticePhone" class="changeContactNotice" type="checkbox" value="Y" <?= $p_notice ?> /> 
                                                    </div>
                                                    <br />
                                                </div>

                                                <br /><br />

                                                <button type="submit" <?= $demo ?> class="btn btn-default pull-right changeContactNoticeSave">Сохранить изменения</button>
                                                <div class="clearfix"></div>

                                                <br />

                                                <div class="alert alert-success notice-alert" style="display: none">
                                                    Изменения сохранены
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-xs-6">
                                        <div class="panel panel-primary">
                                            <div class="panel-heading">
                                                <h3 class="panel-title">Личные данные</h3>
                                            </div>
                                            <div class="panel-body">
                                                <strong>Контактное лицо:</strong> <?= $userInfo["CONTACTPERSON"] ?><br/>
                                                <strong>Логин:</strong> <?= $userInfo["NAME"] ?><br/><br/>

                                                    <strong>E-mail:</strong>
                                                    <input type="text" <?= $demo ?> class="form-control" id="changeContactEmail" value="<?= $userInfo["EMAIL"] ?>" placeholder="Введите e-mail"><br/>
                                                    <strong>Телефон:</strong>
                                                    <input type="text" <?= $demo ?>  class="form-control" id="changeContactPhone" value="<?= $userInfo["PHONE"] ?>" placeholder="Введите номер телефона"><br/>

                                                    <button type="submit" <?= $demo ?> class="btn btn-default pull-right changeContactInfo">Сохранить изменения</button>
                                                    <div class="clearfix" style="margin-bottom:20px;"></div>

                                                    <div class="alert alert-success changeOkMess infoMess"></div>
                                                    <div class="alert alert-danger changeErrorMess infoMess"></div>

                                            </div>
                                        </div>

                                        <div class="panel panel-primary">
                                            <div class="panel-heading">
                                                <h3 class="panel-title">Смена пароля</h3>
                                            </div>
                                            <div class="panel-body">
                                                <strong>Сменить пароль:</strong>
                                                <input type="text" <?= $demo ?> class="form-control" id="changePass" value="" placeholder="Введите новый пароль"><br/>

                                                <button type="submit" <?= $demo ?> class="btn btn-default pull-right changeContactPass">Сохранить изменения</button>
                                                <div class="clearfix" style="margin-bottom:20px;"></div>

                                                <div class="alert alert-success passOkMess infoMess"></div>
                                                <div class="alert alert-danger passErrorMess infoMess"></div>

                                            </div>
                                        </div>

                                    </div>

                                </div>

                                
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-default" data-dismiss="modal">Закрыть</button>
                            </div>
                        </div>
                    </div>
                </div>
            <?
        }?>