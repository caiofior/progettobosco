<?php
/**
 * @author Claudio Fior <caiofior@gmail.com>
 * @copyright CRA
 * Manages session login
 */
$formErrors = new FormErrors();
 $authAdapter = User::getAuthAdapter();
 $auth = Zend_Auth::getInstance();
 $session = $auth->getStorage()->read();
 $user = false;
 if (key_exists('login', $_REQUEST) ) {
     $authAdapter->setIdentity($_REQUEST['username']);
     $authAdapter->setCredential($_REQUEST['password']);
     if ($auth->authenticate($authAdapter)->isValid()) { 
        $userdata = get_object_vars($authAdapter->getResultRowObject(null, 'password'));
        $authStorage = $auth->getStorage();  
        $authStorage->write(array('user_id'=>$userdata['id']));
        $user = new User();
        $user->loadFromId($userdata['id']);
     }
     else
         $formErrors->add_error(FormErrors::custom,'username','Nome utente o password errati');
     if (key_exists('xhr', $_REQUEST)) {
         $formErrors->get_json_error();
     }
 }
 else if (key_exists('logout', $_REQUEST)) {
    $auth->clearIdentity();
    header('Location: '.$BASE_URL);
    exit;
 }
 else   if (is_numeric($session['user_id'])) {
     $user = new User();
     $user->loadFromId($session['user_id']);
  }
  