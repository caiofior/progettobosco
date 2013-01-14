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

require_once('FirePHPCore/FirePHP.class.php');
$firephp = FirePHP::getInstance(true);
 
$var = array('i'=>10, 'j'=>20);
 
$firephp->log($var, 'Iterators');
require(__DIR__.DIRECTORY_SEPARATOR.'..'.DIRECTORY_SEPARATOR.'lib'.DIRECTORY_SEPARATOR.'pb'.DIRECTORY_SEPARATOR.'autoloader.php') ;
if (!function_exists('redirect')) {
    require(__DIR__.DIRECTORY_SEPARATOR.'..'.DIRECTORY_SEPARATOR.'lib'.DIRECTORY_SEPARATOR.'pb_base'.DIRECTORY_SEPARATOR.'functions.php') ;
    require(__DIR__.DIRECTORY_SEPARATOR.'..'.DIRECTORY_SEPARATOR.'lib'.DIRECTORY_SEPARATOR.'pb_base'.DIRECTORY_SEPARATOR.'insert_update.php') ;
}

$db = Zend_Db::factory($DB_CONFIG['adapter'],$DB_CONFIG);
$db->getConnection();
Zend_Db_Table::setDefaultAdapter($db);
// Manages session
require(__DIR__.DIRECTORY_SEPARATOR.'session.php');