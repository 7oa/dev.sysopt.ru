<?php
require($_SERVER["DOCUMENT_ROOT"] . "/core/header.php");
?>
<div class="container">

    <form class="form-signin avtorization" role="form" action="" method="POST">
        <h2 class="form-signin-heading">Авторизация</h2>
        <?= $GLOBALS['AUTH_RES'] ?>
        <input type="text" name="LOGIN" class="form-control" placeholder="Введите логин" required autofocus>
        <input type="password" name="PASS" class="form-control" placeholder="Пароль" required>
        <input type="hidden" value="Y" name="AUTH_FORM">
        <button class="btn btn-lg btn-primary btn-block" name="login" type="submit">Войти</button>
    </form>
</div>
<?
require($_SERVER["DOCUMENT_ROOT"] . "/core/footer.php");
?>
