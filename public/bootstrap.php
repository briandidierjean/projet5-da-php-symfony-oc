<?php
const DEFAULT_APP = 'FrontOffice';

if (!isset($_GET['app']) || !file_exists(__DIR__.'/../App/'.$_GET['app'])) {
    return $_GET['app'] = DEFAULT_APP;
}

$applicationClass = 'App\\'.$_GET['app'].'\\'.$_GET['app'].'Application';

$app = new $applicationClass;
$app->run();