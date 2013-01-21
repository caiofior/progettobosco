<?php
/**
 * @author Claudio Fior <caiofior@gmail.com>
 * @copyright CRA
 * Index page contoller
 */
require (__DIR__.DIRECTORY_SEPARATOR.'..'.DIRECTORY_SEPARATOR.'include'.DIRECTORY_SEPARATOR.'pageboot.php');
if (key_exists('sEcho', $_REQUEST)) {
    $usercoll = new UserColl();
    $usercoll->loadAll($_REQUEST);
    $response =array(
        'sEcho'=>  intval($_REQUEST['sEcho']),
        'iTotalRecords'=>$usercoll->countAll(),
        'iTotalDisplayRecords'=>$usercoll->count(),
        'aaData'=>array()
    );
    foreach($usercoll->getItems() as $user) {
        $datarow = array();
        
        $datarow[]=intval($user->getData('id'));
        $datarow[]=$user->getData('username');
        $datarow[]=$user->getRawData('first_name').' '.$user->getRawData('last_name');
        $datarow[]=$user->getRawData('phone');
        $datarow[]=$user->getRawData('address_city');
        $datarow[]=$user->getRawData('organization');
        $datarow[]=$user->getRawData('creation_datetime');
        $datarow[]='';
        $response['aaData'][]=$datarow;
    }
    header('Content-type: application/json');
    echo Zend_Json::encode($response);
    exit;
}
$view = new Template(array(
    'basePath' => __DIR__.DIRECTORY_SEPARATOR.'..'.DIRECTORY_SEPARATOR.'views'

));
$header = 'header'.DIRECTORY_SEPARATOR.'user.php';
$content = 'content'.DIRECTORY_SEPARATOR.'user.php';
$sidebar = 'general'.DIRECTORY_SEPARATOR.'sidebar.php';
if ($user === false) {
    $header = 'general'.DIRECTORY_SEPARATOR.'header.php';
    $content = 'content'.DIRECTORY_SEPARATOR.'login.php';
    $sidebar = 'sidebar'.DIRECTORY_SEPARATOR.'login.php';
}
$view->controler = basename(__FILE__);
$view->user = $user;
$view->formErrors = $formErrors;
$view->blocks = array(
      'HEADERS' => $header,
      'CONTENT' => $content,
      'SIDEBAR' => $sidebar,
      'FOOTER' => array(
          'general'.DIRECTORY_SEPARATOR.'footer.php',
          'footer'.DIRECTORY_SEPARATOR.'user.php'
      )
    );
echo $view->render('Jungleland10.php');