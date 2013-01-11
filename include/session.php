<?php
/**
 * @author Claudio Fior <caiofior@gmail.com>
 * @copyright CRA
 * Manages session login
 */
$authAdapter = new Zend_Auth_Adapter_DbTable(
    $db,
    'user',
    'username',
    'password',
    'MD5(?)'
);
 $authAdapter->setIdentity('caiofior@gmail.com');
 $authAdapter->setCredential('topolino');
 $auth = Zend_Auth::getInstance();
 $session = $auth->getStorage()->read();
 $user = false;
 if (is_numeric($session['user_id'])) {
     $user = new User();
     $user->loadFromId($session['user_id']);
  }
 else if ($auth->authenticate($authAdapter)->isValid()) {
     $userdata = get_object_vars($authAdapter->getResultRowObject(null, 'password'));
     $authStorage = $auth->getStorage();  
     $authStorage->write(array('user_id'=>$userdata['id']));
     $user = new User();
     $user->loadFromId($user['id']);
 }
 //$auth->clearIdentity();