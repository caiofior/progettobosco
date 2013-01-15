<?php
/**
 * @author Claudio Fior <caiofior@gmail.com>
 * @copyright CRA
 * Manages session login
 */
 $authAdapter = User::getAuthAdapter();

 $auth = Zend_Auth::getInstance();
 $session = $auth->getStorage()->read();
 $user = false;
 if (is_numeric($session['user_id'])) {
     $user = new User();
     $user->loadFromId($session['user_id']);
  }
 else if (key_exists('login', $_REQUEST) && $auth->authenticate($authAdapter)->isValid()) {
     $authAdapter->setIdentity($_REQUEST['username']);
     $authAdapter->setCredential($_REQUEST['password']);
     $userdata = get_object_vars($authAdapter->getResultRowObject(null, 'password'));
     $authStorage = $auth->getStorage();  
     $authStorage->write(array('user_id'=>$userdata['id']));
     $user = new User();
     $user->loadFromId($userdata['id']);
 }
 else if (key_exists('logout', $_REQUEST)) {
    $auth->clearIdentity();
 }