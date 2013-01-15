<?php
/**
 * @author Claudio Fior <caiofior@gmail.com>
 * @copyright CRA
 * Index page contoller
 */
require (__DIR__.DIRECTORY_SEPARATOR.'..'.DIRECTORY_SEPARATOR.'include'.DIRECTORY_SEPARATOR.'pageboot.php');
$view = new Zend_View(array(
    'basePath' => __DIR__.DIRECTORY_SEPARATOR.'..'.DIRECTORY_SEPARATOR.'views'

));
$content = 'content'.DIRECTORY_SEPARATOR.'index.php';
$sidebar = 'content'.DIRECTORY_SEPARATOR.'sidebar.php';
if ($user === false) {
    $content = 'general'.DIRECTORY_SEPARATOR.'login.php';
    $sidebar = 'general'.DIRECTORY_SEPARATOR.'login_sidebar.php';
    }
$view->controler = basename(__FILE__);
$view->blocks = array(
      'HEADERS' => 'general'.DIRECTORY_SEPARATOR.'header.php',
      'CONTENT' => $content,
      'SIDEBAR' => $sidebar,
      'FOOTER' => array(
          'general'.DIRECTORY_SEPARATOR.'footer.php',
          'footer'.DIRECTORY_SEPARATOR.'login.php'
      )
    );
echo $view->render('Jungleland10.php');