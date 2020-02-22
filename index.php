<?php
/**
 * @author Shayna Jamieson, Bridget Black
 * @version 1.0
 * URL: http://sjamieson.greenriverdev.com/328/pets2/index.php
 * Date: January 24, 2020
 */

// Turn on error reporting
ini_set('display_errors', 1);
error_reporting(E_ALL);

require("vendor/autoload.php");
require_once('model/validations.php');

// start a session - ONLY ever need to put this in our controller (all other pages get by transference)
session_start();

// instantiate F3
$f3 = Base::instance(); // invoke static

//instantiate controller
$controller = new PetController($f3);
$db = new Database();

//set the debug level
$f3->set('DEBUG',3);
$f3->set('colors',array('pink','green','blue'));

// define a default route
// when the user navigates to the route directory of the project
// this is what they should see
$f3->route('GET /', function() {
    $GLOBALS['controller']->defaultRoute();
});


//define a route accepts animal type parameter
$f3->route('GET /@item', function($f3, $params) {
    $item = $params['item'];
    //use a switch to reroute user OR give them an informed error
    switch ($item){
        case 'chicken':
            echo "<p>Cluck!</p>";
            break;
        case 'dog':
            echo "<p>Woof!</p>";
            break;
        case 'cat':
            echo "<p>Meow!</p>";
            break;
        case 'Goat':
            echo "<p>WHOAAAAAAAAA</p>";
            break;
        case 'Lion':
            echo "<p>Roar</p>";
            break;
        default:
            //no route to send them to, give error
            $f3->error(404);
    }
});

// route to our first page of our order form
// define another route called order that displays a form
$f3->route('GET|POST /order', function() {
    $GLOBALS['controller']->home();
});

// route to our second page of our order form
// define another route called order that displays a form
$f3->route('GET|POST /order2', function() {
    $GLOBALS['controller']->form2();
});

// route to our results page of our order form
// define another route called order that displays a form
$f3->route('GET|POST /results', function() {
    $GLOBALS['controller']->results();
});

// route show that will display all of the pets
$f3->route('GET /show', function() {
    $GLOBALS['controller']->show();
});

// fun Fat-Free
$f3->run();