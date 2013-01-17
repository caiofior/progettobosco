<?php
/**
 * @author Claudio Fior <caiofior@gmail.com>
 * @copyright CRA
 * Index page controller
 */
require (__DIR__.DIRECTORY_SEPARATOR.'..'.DIRECTORY_SEPARATOR.'include'.DIRECTORY_SEPARATOR.'pageboot.php');
if (key_exists('action', $_REQUEST) && $_REQUEST['action']='xhr_update') {
    $response = array();
    $request = new RegexIterator(new ArrayIterator($_REQUEST), '/^[0-9]+$/',  RegexIterator::MATCH,  RegexIterator::USE_KEY); 
    foreach ($request as  $value) {
        $file_path = __DIR__.DIRECTORY_SEPARATOR.'..'.DIRECTORY_SEPARATOR.'views'.DIRECTORY_SEPARATOR.'blocks'.DIRECTORY_SEPARATOR;
        $file_path .= str_replace('_', DIRECTORY_SEPARATOR, $value).'.php';
        if (is_file($file_path)) {
            ob_start();
            require $file_path;
            $response[ $value]=  ob_get_clean();
            }
    }
    header('Content-type: application/json');
    echo Zend_Json::encode($response);
    exit;
} else if (key_exists('register', $_REQUEST) ) {
    
}
$view = new Template(array(
    'basePath' => __DIR__.DIRECTORY_SEPARATOR.'..'.DIRECTORY_SEPARATOR.'views'

));
$header = 'header'.DIRECTORY_SEPARATOR.'index.php';
$content = 'content'.DIRECTORY_SEPARATOR.'index.php';
$sidebar = 'general'.DIRECTORY_SEPARATOR.'sidebar.php';
if ($user === false) {
    $header = 'general'.DIRECTORY_SEPARATOR.'header.php';
    $content = 'content'.DIRECTORY_SEPARATOR.'login.php';
    $sidebar = 'sidebar'.DIRECTORY_SEPARATOR.'login.php';
}
$view->controler = basename(__FILE__);
$view->user = $user;
$view->blocks = array(
      'HEADERS' => $header,
      'CONTENT' => $content,
      'SIDEBAR' => $sidebar,
      'FOOTER' => array(
          'general'.DIRECTORY_SEPARATOR.'footer.php',
          'footer'.DIRECTORY_SEPARATOR.'login.php'
      )
    );
echo $view->render('Jungleland10.php');