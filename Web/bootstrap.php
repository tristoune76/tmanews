<?php

const DEFAULT_APP = 'Frontend';

//we verifiy if there's a parameter in the url ($_GET['app'] parameter)
//we also verify that the app exists
//if not in both case => application will be set as Frontend so it can generate an erro 404 page

if(isset($_GET['app']) || !file_exists(__DIR__.'/../App'.$_GET['app'])) $_GET['app'] = DEFAULT_APP;

//loading the SPLClassLoader which load engine
require __DIR__.'/../lib/OCFram/SplClassLoader.php';

//loading all classes from all the vendor and framework namespaces
//loading all files containing all classes from the OCFram namespace
$OCFramLoader = new SplClassLoader ('OCFram', __DIR__.'/../lib');
$OCFramLoader->register();

//loading all files containing all classes from the Entity namespace
$entityLoader = new SplClassLoader ('Entity', __DIR__.'/../vendors');
$entityLoader->register();

//loading all files containing all classes from the Model namespace
$modelLoader = new SplClassLoader ('Model', __DIR__.'/../vendors');
$modelLoader->register();

//loading all files containing all classes from the Frontend namespace
$appLoader = new SplClassLoader ('App', __DIR__.'/..');
$appLoader->register();

//loading the class from the app in the $_GET variable
//at first we retrieve the name of the class corresponding to the app
$appClass = 'App\\'.$_GET['app'].'\\'.$_GET['app'].'Application';

//then we create the object from the class
$app = new $appClass;

//we launch the application
$app->run();











