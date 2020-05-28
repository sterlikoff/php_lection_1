<?php

include_once "GuestbookMessage.php";
include_once "GuestbookRepository.php";
include_once "FileGuestbookRepository.php";
include_once "DatabaseGuestBookRepository.php";

$repository = new DatabaseGuestBookRepository();

for ($i = 0; $i++< 1000;) {

    $model = new GuestbookMessage();
    $model->username = "user #$i";
    $model->message = "message #$i";

    $repository->add($model);

}