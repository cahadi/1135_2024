<?php
require_once './vendor/autoload.php';

use App\Controllers\FrontendController;
use Tracy\Debugger;

error_reporting(E_ALL);
ini_set('display_errors', 'on');

Debugger::enable();

$app = new FrontendController();

echo $app->articles();