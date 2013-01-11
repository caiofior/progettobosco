<?php
/**
 * @author Claudio Fior <caiofior@gmail.com>
 * @copyright CRA
 * Page boot actions, requirments ad db connection
 */
require (__DIR__.DIRECTORY_SEPARATOR.'..'.DIRECTORY_SEPARATOR.'config.php');
if (isset($ZEND_PATH))
    set_include_path(get_include_path().PATH_SEPARATOR.$ZEND_PATH);
set_include_path(get_include_path().PATH_SEPARATOR.__DIR__.DIRECTORY_SEPARATOR.'..'.DIRECTORY_SEPARATOR.'lib');
require('Zend'.DIRECTORY_SEPARATOR.'Loader.php');
require(__DIR__.DIRECTORY_SEPARATOR.'..'.DIRECTORY_SEPARATOR.'lib'.DIRECTORY_SEPARATOR.'pb'.DIRECTORY_SEPARATOR.'autoloader.php') ;
require(__DIR__.DIRECTORY_SEPARATOR.'..'.DIRECTORY_SEPARATOR.'lib'.DIRECTORY_SEPARATOR.'pb_base'.DIRECTORY_SEPARATOR.'functions.php') ;
require(__DIR__.DIRECTORY_SEPARATOR.'..'.DIRECTORY_SEPARATOR.'lib'.DIRECTORY_SEPARATOR.'pb_base'.DIRECTORY_SEPARATOR.'insert_update.php') ;
Zend_Loader::loadClass('Zend_View');
Zend_Loader::loadClass('Zend_Registry');
Zend_Loader::loadClass('Zend_Db');
Zend_Loader::loadClass('Zend_Db_Table');
Zend_Loader::loadClass('Zend_Auth');
Zend_Loader::loadClass('Zend_Auth_Adapter_DbTable');

$db = Zend_Db::factory($DB_CONFIG['adapter'],$DB_CONFIG);
$db->getConnection();
Zend_Db_Table::setDefaultAdapter($db);
// Manages session
require(__DIR__.DIRECTORY_SEPARATOR.'session.php');
