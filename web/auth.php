<?php

$username = 'developer';
$password = 'develop';
/*// split user/pass parts
if (isset($_SERVER["REDIRECT_QUERY_STRING"]) && $_SERVER["REDIRECT_QUERY_STRING"]!='') {
    $d = base64_decode($_SERVER["REDIRECT_QUERY_STRING"]);
    list($_SERVER['PHP_AUTH_USER'], $_SERVER['PHP_AUTH_PW']) = explode(':', $d);
}*/
if (!isset($_SERVER['PHP_AUTH_USER']) || !isset($_SERVER['PHP_AUTH_PW']) ||
    ($_SERVER['PHP_AUTH_USER'] != $username) || ($_SERVER['PHP_AUTH_PW'] != $password)) {
    header('HTTP/1.1 401 Unauthorized');
    header('WWW-Authenticate: Basic realm="Сижу-вяжу.рф"');
    exit('<h2>Сижу-Вяжу.рф</h2>Извините, вы должны ввести правильные данные');
}