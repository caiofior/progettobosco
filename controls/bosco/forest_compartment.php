<?php
$header = 'header'.DIRECTORY_SEPARATOR.'particella.php';
$content = 'content'.DIRECTORY_SEPARATOR.'particella.php';
$sidebar = 'general'.DIRECTORY_SEPARATOR.'sidebar.php';
$a = new forest\form\A();
$a->loadFromId($_REQUEST['id']);
$view->a = $a;
$view->user = $user;
$view->formErrors = $formErrors;
$view->blocks = array(
      'HEADERS' => $header,
      'CONTENT' => $content,
      'SIDEBAR' => $sidebar,
      'FOOTER' => array(
          'general'.DIRECTORY_SEPARATOR.'footer.php',
          'footer'.DIRECTORY_SEPARATOR.'particella.php'
      )
    );
echo $view->render('Jungleland10_1col.php');
exit;
