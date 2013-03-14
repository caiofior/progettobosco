<?php
/**
 * @author Claudio Fior <caiofior@gmail.com>
 * @copyright CRA
 * Dati catastali page contoller
 */
require (__DIR__.DIRECTORY_SEPARATOR.'..'.DIRECTORY_SEPARATOR.'include'.DIRECTORY_SEPARATOR.'pageboot.php');
$message = '';
$forest = new forest\Forest();
$forest->loadFromId($_REQUEST['id']);
$view = new Template(array(
    'basePath' => __DIR__.DIRECTORY_SEPARATOR.'..'.DIRECTORY_SEPARATOR.'views'

));
$view->user = $user;
$view->formErrors = $formErrors;
$view->controler = basename(__FILE__);
$view->message = $message;
$view->forest = $forest;
$view->blocks = array(
      'HEADERS' => 'header'.DIRECTORY_SEPARATOR.'bosco.php',
      'CONTENT' => array(
          'content'.DIRECTORY_SEPARATOR.'daticat.php'
      ),
      'FOOTER' => array(
          'general'.DIRECTORY_SEPARATOR.'footer.php',
          'footer'.DIRECTORY_SEPARATOR.'bosco.php'
      )
    );
echo $view->render('Jungleland10.php');