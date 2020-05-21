<?php

include_once "GuestbookMessage.php";
include_once "GuestbookRepository.php";
include_once "FileGuestbookRepository.php";

$repository = new DatabaseGuestBookRepository();

$messages = $repository->getAll();

if (isset($_POST)) {

    // validate data

    $repository->add(new GuestbookMessage($_POST["username"], $_POST["message"]));

}

?>

<html>



</html>