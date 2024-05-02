<?php
// 328/quiz/index.php

// Turn on error reporting
ini_set('display_errors', 1);
error_reporting(E_ALL);

// Require the autoload file
require_once ('vendor/autoload.php');

require_once('model/data.php');

// Instantiate the F3 Base class
$f3 = Base::instance();

// Define a default route
$f3->route('GET /', function() {
    // Render a view page
    $view = new Template();
    echo $view->render('views/survey-home.html');
});

// Survey reroute page
$f3->route('GET|POST /survey', function($f3) {

    $name = "";
    $surveyOptions = null;

    $surveyOptions = getSurveyOptions();
    $f3 -> set('surveyoptions', $surveyOptions);

    if ($_SERVER['REQUEST_METHOD'] == "POST") {
        $name = $_POST['name'];
        $surveyOptions = $_POST['option'];
    }

    $f3->set('SESSION.name', $name);
    $f3->set('SESSION.options', $surveyOptions);

    if (isset($_POST['name'])) {
        $f3 -> reroute('summary');
    }

    // Render a view page
    $view = new Template();
    echo $view->render('views/survey.html');
});

$f3->route('GET|POST /summary', function() {
    // Render a view page
    $view = new Template();
    echo $view->render('views/summary.html');
});

// Run Fat-Free
$f3->run();

?>