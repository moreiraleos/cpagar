<?php

use Source\Support\Email;

require __DIR__ . "/../vendor/autoload.php";

// SEND QUEUE

$emailQueue = new Email;
$emailQueue->sendQueue();
