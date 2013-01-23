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
        'sColumns'=>  implode(',',$usercoll->getColumns()),
        'aaData'=>array()
    );
    foreach($usercoll->getItems() as $user_item) :
        $datarow = array();
        
        $datarow[]=intval($user_item->getData('id'));
        $datarow[]=$user_item->getData('username');
        $datarow[]=$user_item->getRawData('first_name').' '.$user_item->getRawData('last_name');
        $datarow[]=$user_item->getRawData('phone');
        $datarow[]=$user_item->getRawData('address_city');
        $datarow[]=$user_item->getRawData('organization');
        $date = new DateTime($user_item->getRawData('creation_datetime'));
        $datarow[]=$date->format('Y-m-d');
        ob_start();
        ?>
<div class="table_actions">
    <a href="user.php?action=show&id=<?php echo intval($user_item->getData('id'));?>"><img class="actions show" src="images/empty.png" title="Visualizza"/></a>
    <?php
     $value = 0;
     $label = 'Attivo';
     $class= 'active';
     if ($user_item->getData('active')=='f') {
         $value = 1;
         $class= 'not_active';
         $label = 'Non attivo';
     }
     if ($user_item->getData('id') == $user->getData('id'))
         $value = 1;
    ?>
    <a href="user.php?action=edit&id=<?php echo intval($user_item->getData('id'));?>&field=active&value=<?php echo $value; ?>"><img class="actions edit <?php echo $class; ?>" src="images/empty.png" title="<?php echo $label; ?>"/></a>
    <?php
     $value = 0;
     $class= 'administrator';
     $label = 'Amministratore';
     if ($user_item->getData('is_admin')=='f') {
        $value = 1;
        $label = 'Utente';
        $class= 'user';
     }
     if ($user_item->getData('id') == $user->getData('id'))
         $value = 1;
    ?>
    <a href="user.php?action=edit&id=<?php echo intval($user_item->getData('id'));?>&field=is_admin&value=<?php echo $value; ?>"><img class="actions edit <?php echo $class; ?>" src="images/empty.png" title="<?php echo $label; ?>"/></a>
    <?php if (!$user_item->getData('is_admin')) : ?>
    <a href="user.php?action=manage&id=<?php echo intval($user_item->getData('id'));?>"><img class="actions manage" src="images/empty.png" title="Associa boschi"/></a>
    <?php endif; ?>
    <?php if ($user_item->getData('id') != $user->getData('id')) : ?>
    <a href="user.php?action=delete&id=<?php echo intval($user_item->getData('id'));?>"><img class="actions delete" src="images/empty.png" title="Cancella"/></a>
    <?php endif; ?>
</div>
        <?php $datarow[]=  ob_get_clean();
        $response['aaData'][]=$datarow;
    endforeach;
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
else if (key_exists('action', $_REQUEST)) {
    switch ($_REQUEST['action']) {
        case 'show':
            $view->user_detail = new User();
            $view->user_detail->loadFromId($_REQUEST['id']);
            $content = 'content'.DIRECTORY_SEPARATOR.'user_show.php';
        break;
        case 'manage':
            $view->user_detail = new User();
            $view->user_detail->loadFromId($_REQUEST['id']);
            $content = 'content'.DIRECTORY_SEPARATOR.'user_manage.php';
        break;
        case 'edit' :
            $user_edit = new User();
            $user_edit->loadFromId($_REQUEST['id']);
            $user_edit->setData($_REQUEST['value'], $_REQUEST['field']);
            $user_edit->update();
        break;
        case 'delete':
            if (key_exists('confirm', $_REQUEST)) {
                $user_deleted = new User();
                try {
                    $user_deleted->loadFromId($_REQUEST['id']);
                    $log->setData(array(
                        'user_id'=>$user_deleted->getData('id'),
                        'username'=>$user_deleted->getData('username'),
                        'description'=>'Cancellazione utente',
                    ));
                    $user_deleted->delete();
        $log->insert();
                } catch (Exception $e) {
                    $formErrors->addError(FormErrors::custom,'username','Utente non trovato');
                }
            }
            else
                $formErrors->addError(FormErrors::custom,'confirm','Vuoi cancellare l\'utente selezionato');
        break;
    }
    if (key_exists('xhr', $_REQUEST))
         $formErrors->getJsonError();
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