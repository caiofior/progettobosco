<?php
/**
 * @author Claudio Fior <caiofior@gmail.com>
 * @copyright CRA
 * Bosco page contoller
 */
require (__DIR__.DIRECTORY_SEPARATOR.'..'.DIRECTORY_SEPARATOR.'include'.DIRECTORY_SEPARATOR.'pageboot.php'); 
$view = new Template(array(
    'basePath' => __DIR__.DIRECTORY_SEPARATOR.'..'.DIRECTORY_SEPARATOR.'views'

));
$view->controler = basename(__FILE__);
$header = 'header'.DIRECTORY_SEPARATOR.'bosco.php';
$content = 'content'.DIRECTORY_SEPARATOR.'bosco.php';
$sidebar = 'general'.DIRECTORY_SEPARATOR.'sidebar.php';
if ($user === false) {
    $header = 'general'.DIRECTORY_SEPARATOR.'header.php';
    $content = 'content'.DIRECTORY_SEPARATOR.'login.php';
    $sidebar = 'sidebar'.DIRECTORY_SEPARATOR.'login.php';
}
else if (key_exists('action', $_REQUEST) && $_REQUEST['action']=='xhr_update') {
            if (key_exists('forest_codice', $_REQUEST)) {
                $forest = new forest\Forest();
                $forest->loadFromCode($_REQUEST['forest_codice']);
            }
            if (key_exists('delete', $_REQUEST)) {
                $forest = new forest\Forest();
                $forest->loadFromId($_REQUEST['id']);
                $forest->delete();
            }
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
} else if (key_exists('task', $_REQUEST)) {
    switch ($_REQUEST['task']) {
        case 'forest_compartment':
            require __DIR__.DIRECTORY_SEPARATOR.'..'.DIRECTORY_SEPARATOR.'controls'.DIRECTORY_SEPARATOR.'bosco'.DIRECTORY_SEPARATOR.'forest_compartment.php';
        break;
        case 'autocomplete':
            require __DIR__.DIRECTORY_SEPARATOR.'..'.DIRECTORY_SEPARATOR.'controls'.DIRECTORY_SEPARATOR.'bosco'.DIRECTORY_SEPARATOR.'autocomplete.php';
        break;
    }
}
else if (key_exists('action', $_REQUEST)) {
    switch ($_REQUEST['action']) {
        case 'manage':
            $view->forest = new forest\Forest();
            if (key_exists('id', $_REQUEST)) {
                $view->forest->loadFromId($_REQUEST['id']);
            }
                    
            $content = 'content'.DIRECTORY_SEPARATOR.'boscoManage.php';
            if (key_exists('update', $_REQUEST)) {
                $is_new = false;
                $new_forest = new forest\Forest();
                try{
                    $new_forest->loadFromCode($_REQUEST['regione'].$_REQUEST['codice']);
                } catch (Exception $e) {$is_new = true;}
                if ($_REQUEST['regione'] == '')
                    $formErrors->addError(FormErrors::required,'regione','la regione','f');
                if ($_REQUEST['descrizion'] == '')
                    $formErrors->addError(FormErrors::required,'descrizion','la descrizione','f');
                else if (strlen($_REQUEST['codice']) > 50)
                    $formErrors->addError(FormErrors::custom,'descrizion','La descrizione deve avere al massimo 50 caratteri');
                if ($_REQUEST['codice'] == '')
                    $formErrors->addError(FormErrors::required,'codice','il codice');
                else if (strlen($_REQUEST['codice']) > 3)
                    $formErrors->addError(FormErrors::custom,'codice','il codice deve avere meno di tre caratteri');
                else if (!$is_new && $view->forest->getData('id') != '')
                    $formErrors->addError(FormErrors::custom,'codice','Il codice è già esistente');
                
                if ($formErrors->count() == 0) {
                    $_REQUEST['codice']=$_REQUEST['regione'].$_REQUEST['codice'];
                    $view->forest->setData($_REQUEST);
                    
                    if ($view->forest->getData('objectid') == '')  {
                        $view->forest->insert();
                            $log->setData(array(
                            'user_id'=>$user->getData('id'),
                            'username'=>$user->getData('username'),
                            'description'=>'Creazione del bosco '.$_REQUEST['descrizion'],
                            'objectid'=>$view->forest->getData('id'),
                        ));
                        }
                    else {
                        $view->forest->update();
                        $log->setData(array(
                            'user_id'=>$user->getData('id'),
                            'username'=>$user->getData('username'),
                            'description'=>'Modificato il bosco '.$_REQUEST['descrizion'],
                            'objectid'=>$view->forest->getData('id'),
                        ));
                        }
                    $view->forest->addOwner($user,1);
                    $formErrors->setOkMessage('Lo modifiche sono state salvate.<script type="text/javascript">window.location.href = "'.$BASE_URL.'bosco.php??action=manage&id='.$view->forest->getData('id').'"</script>');
                    
                    $log->insert();
                    
                }
                
            }
        break;
    }
    if (key_exists('xhr', $_REQUEST)) {
        $formErrors->getJsonError ();
        exit;
    }
}
$view->user = $user;
$view->formErrors = $formErrors;
$view->blocks = array(
      'HEADERS' => $header,
      'CONTENT' => $content,
      'SIDEBAR' => $sidebar,
      'FOOTER' => array(
          'general'.DIRECTORY_SEPARATOR.'footer.php',
          'footer'.DIRECTORY_SEPARATOR.'bosco.php'
      )
    );
echo $view->render('Jungleland10.php');