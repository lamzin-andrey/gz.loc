<?php
file_put_contents( __DIR__ . '/rkfail.log', print_r($_POST, 1) . "\n", FILE_APPEND );
