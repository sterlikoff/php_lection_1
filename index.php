<?php

error_reporting(E_ALL);
session_start();

include_once "functions.php";

$message = authorization();
$user = getCurrentUser();

?>

<html lang="RU">

<head>
  <meta charset="UTF-8">
    <title>Изучаем PHP</title>
</head>

<body>

<?php if (!empty($message)) echo $message; ?>

<?php if (isset($user)): ?>

    <h1>
        Привет, <?= $user->login; ?>
    </h1>

    <h2>
        Дата регистрации: <?= $user->getRegistrationDate(); ?>
    </h2>

<?php else: ?>

    <form method="post">

        <input type="text" name="login" placeholder="Введите логин">
        <input type="password" name="password" placeholder="Введите пароль">
        <input type="submit" value="Войти">

    </form>

<?php endif; ?>

</body>

</html>