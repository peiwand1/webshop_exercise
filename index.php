<?php
$isAjax = (isset($_SERVER["HTTP_X_REQUESTED_WITH"]) && $_SERVER["HTTP_X_REQUESTED_WITH"] == "XMLHttpRequest");
$isAPI = (isset($_GET['action']) && $_GET['action'] === 'api');

session_start();
require_once 'php/DatabaseCrud.php';

// set up DB connection
$file = file_get_contents('config/local_db.json');
$dbConfig = json_decode($file, true);
$servername = $dbConfig['servername'];
$username = $dbConfig['username'];
$password = $dbConfig['password'];
$dbname = $dbConfig['dbname'];

DatabaseCrud::getInstance()->connectToDB($servername, $username, $password, $dbname);

// handle request
if ($isAjax) {
    require_once 'php/AjaxController.php';

    $ajaxController = new AjaxController();
    $ajaxController->handleRequest();
} else if ($isAPI) {
    require_once 'php/APIController.php';
    
    $apiController = new APIController();
    $apiController->handleRequest();
} else {
    require_once 'php/PageController.php';

    $dirName = basename(__DIR__);
    $pageTitle = "Webshop";

    $pageController = new PageController($pageTitle, $dirName);
    $pageController->handleRequest();
    $pageController->showCurrentPage();
}
