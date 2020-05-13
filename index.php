<?php

error_reporting(E_ALL);
session_start();

include_once "functions.php";

$message = authorization();

?>

<html lang="RU">

<head>
    <title>Изучаем PHP</title>
</head>

<body>

<h1>
    Привет, <?= getCurrentUserName(); ?>
</h1>

<?php if (!empty($message)) echo $message; ?>

<form method="post">

    <input type="text" name="login" placeholder="Введите логин">
    <input type="password" name="password" placeholder="Введите пароль">
    <input type="submit" value="Войти">

</form>

</body>

</html>