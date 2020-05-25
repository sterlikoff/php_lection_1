<?php

error_reporting(E_ALL);

include_once "GuestbookMessage.php";
include_once "FileGuestbookRepository.php";

$repository = new FileGuestbookRepository();

$messages = $repository->getAll();

$model = new GuestbookMessage();

if (isset($_POST) && (count($_POST) > 0)) {

    if (isset($_POST["username"])) $model->username = $_POST["username"];
    if (isset($_POST["message"])) $model->message = $_POST["message"];

    if ($model->validate()) {
        $repository->add($model);
    }

}

$messages = $repository->getAll();

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

<form method="post">

    <?php if ($model->hasErrors()): ?>
        <div>
            <?= $model->errorSummary(); ?>
        </div>
    <?php endif; ?>

    <div class="form-line">
        <input type="text" name="username" placeholder="Ваше имя:" value="<?= $model->username ?>">
    </div>

    <div class="form-line">
        <textarea name="message" placeholder="Ваше сообщение"><?= $model->message; ?></textarea>
    </div>

    <input type="submit">

</form>

<?php if (count($messages) > 0) foreach ($messages as $message): ?>

    <div class="message">

        <p><?= $message->username; ?></p>
        <p><?= $message->message; ?></p>
        <p><?= date("d.m.Y H:i", $message->time); ?></p>

    </div>

<?php endforeach; ?>

</body>

</html>