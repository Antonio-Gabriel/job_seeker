<?php

session_start();
session_regenerate_id();

error_reporting(E_ALL);
ini_set("display_error", 1);

require_once "./vendor/autoload.php";
require_once "./src/Utils/Redirect.php";
require_once "./env.php";

$appClient = require_once "./src/Routes/AppRoutes.php";
$appAdmin = require_once "./src/Routes/AdminRoutes.php";
$categoryRoute = require_once "./src/Modules/Category/Routes/CategoryRoutes.php";
$projectRoute = require_once "./src/Modules/Project/Routes/ProjectRoute.php";
$userRoute = require_once "./src/Modules/User/Routes/UserRoutes.php";
$enrollmentRoute = require_once "./src/Modules/Enrollment/Routes/EnrollmentRoute.php";

use Slim\App;

$app = new App([
    "settings" => [
        "displayErrorDetails" => true
    ]
]);

$appClient($app);
$appAdmin($app);
$categoryRoute($app);
$projectRoute($app);
$userRoute($app);
$enrollmentRoute($app);

$app->run();
