<?php

session_start();

include_once "UserRepository.php";
include_once "User.php";

$repository = new UserRepository();

$registrationOver = false;
if (isset($_POST["registration"])) {
    $registrationOver = $repository->add(new User($_POST["registration"]["name"], $_POST["registration"]["password"]));
}

if (isset($_POST["login"])) {
    $repository->login($_POST["login"]["name"], $_POST["login"]["password"]);
}

$currentUser = $repository->getCurrentUser();

?>

<html>

<head></head>

<body>

<?php if (!$currentUser): ?>

    <?php if ($registrationOver): ?>

        <h1>Регистрация прошла успешно!</h1>

    <?php else: ?>

        <h1>Регистрация</h1>
        <form method="post">

            <input type="text" name="registration[name]" placeholder="Ваше имя">
            <br>
            <input type="password" name="registration[password]" placeholder="Пароль">
            <br>
            <input type="submit">

        </form>

    <?php endif; ?>

    <h1>Авторизация</h1>

    <form method="post">

        <input type="text" name="login[name]" placeholder="Ваше имя">
        <br>
        <input type="password" name="login[password]" placeholder="Пароль">
        <br>
        <input type="submit">

    </form>

<?php else: ?>

    <h1>Привет, <?= $currentUser->name; ?></h1>

    <a href="index.php">Гостевая книга</a>

<?php endif; ?>

</body>

</html>