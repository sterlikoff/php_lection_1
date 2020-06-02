<?php

error_reporting(E_ALL);
session_start();

include_once "GuestbookMessage.php";
include_once "UserRepository.php";
include_once "User.php";

$page = isset($_GET["page"]) ? $_GET["page"] : 1;

include_once "DatabaseGuestbookRepository.php";
$messagesRepository = new DatabaseGuestbookRepository();

$messages = $messagesRepository->getAll($page);

$userRepository = new UserRepository();
$currentUser = $userRepository->getCurrentUser();

$model = new GuestbookMessage($currentUser, "");

if (isset($_POST) && (count($_POST) > 0)) {

    if (isset($_POST["message"])) $model->message = $_POST["message"];

    if ($model->validate()) {
        $messagesRepository->add($model);
    }

}

?>

<html>

<head>

    <style>

        .message {
            border: 1px solid #ddd;
            padding: 20px;
            margin-bottom: 20px;
        }

        .form-line {
            margin-bottom: 20px;
        }

    </style>

</head>

<body>

<h1>Гостевая книга</h1>

<?php if ($currentUser): ?>

    <form method="post">

        <?php if ($model->hasErrors()): ?>
            <div>
                <?= $model->errorSummary(); ?>
            </div>
        <?php endif; ?>

        <div class="form-line">
            <textarea name="message" placeholder="Ваше сообщение"><?= $model->message; ?></textarea>
        </div>

        <input type="submit">

    </form>

<?php else: ?>

    <p><a href="login.php">Авторизуйтесь, </a>чтобы оставить сообщение</p>

<?php endif; ?>

<p>
    Всего сообщений: <?= $messagesRepository->getMessagesCount(); ?>
</p>

<?php if ($currentUser): ?>

    <p>
        Моих сообщений: <?= $messagesRepository->getMessagesCount($currentUser->id); ?>
    </p>

<?php endif; ?>

<p>
    Всего пользователей: <?= $userRepository->getUsersCount(); ?>
</p>

<?php if ($page > 1): ?>
    <a href="?page=<?= --$page; ?>">Предыдущая страница</a>
<?php endif; ?>

<?php if (count($messages) > 0) foreach ($messages as $message): ?>

    <div class="message">

        <p><?= $message->user->name; ?></p>
        <p><?= $message->message; ?></p>
        <p><?= date("d.m.Y H:i", $message->time); ?></p>

    </div>

<?php endforeach; ?>

<a href="?page=<?= ++$page; ?>">Следующая страница</a>

</body>

</html>