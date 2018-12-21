<?php

$username = 'developer';
$password = 'develop';

if (!isset($_SERVER['PHP_AUTH_USER']) || !isset($_SERVER['PHP_AUTH_PW']) ||
    ($_SERVER['PHP_AUTH_USER'] != $username) || ($_SERVER['PHP_AUTH_PW'] != $password)) {
    header('HTTP/1.1 401 Unauthorized');
    header('WWW-Authenticate: Basic realm="Сижу-вяжу.рф"');
    exit('<h2>Сижу-Вяжу.рф</h2>Извините, вы должны ввести правильные данные');
}