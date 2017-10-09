<?php
$date = now();
file_put_contents( __DIR__ . '/rkres.log', "\n\n===date = {$date}===\n\n" . print_r($_POST, 1) . "\n", FILE_APPEND );
