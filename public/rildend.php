<?php 
require (__DIR__.DIRECTORY_SEPARATOR.'..'.DIRECTORY_SEPARATOR.'include'.DIRECTORY_SEPARATOR.'pageboot.php');
$message = '';
$view = new Zend_View(array(
    'basePath' => __DIR__.DIRECTORY_SEPARATOR.'..'.DIRECTORY_SEPARATOR.'views'

));
$view->message = $message;
$view->blocks = array(
      'HEADERS' => 'general'.DIRECTORY_SEPARATOR.'header.php',
      'CONTENT' => array(
          'general'.DIRECTORY_SEPARATOR.'menu.php',
          'content'.DIRECTORY_SEPARATOR.'rildend.php'
      )
    );
echo $view->render('main.php');