<?php

include_once "GuestbookMessage.php";
include_once "GuestbookRepository.php";
include_once "FileGuestbookRepository.php";

$repository = new FileGuestbookRepository();
$repository->add(new GuestbookMessage("admin", "new message"));