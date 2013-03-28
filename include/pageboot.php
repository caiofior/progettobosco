<?php
/**
 * @author Claudio Fior <caiofior@gmail.com>
 * @copyright CRA
 * Page boot actions, requirments ad db connection
 */
require (__DIR__.DIRECTORY_SEPARATOR.'..'.DIRECTORY_SEPARATOR.'config.php');
/**
 * Includes monitoring script
 */
if ((!isset($PHPUNIT) || !$PHPUNIT) && (isset($MONITORING) && $MONITORING))
    require (__DIR__.DIRECTORY_SEPARATOR.'monitoring.php');
/**
 * Config debug options
 */
ini_set('session.gc_probability',0);
if (isset($DEBUG) && $DEBUG) {
    error_reporting(E_ALL | E_STRICT);
    ini_set('display_errors', 1);
    ini_set('xdebug.collect_vars', 0);
    ini_set('xdebug.collect_params', 0);
    ini_set('xdebug.dump_globals', 0);
    ini_set('xdebug.show_local_vars', 0);
    if (!(isset($PHPUNIT) && $PHPUNIT)) {
        require_once('FirePHPCore/FirePHP.class.php');
        ini_set('html_errors',1);
        ini_set('xdebug.show_local_vars', 1);
        
    }
}
/**
 * Include paths
 */
if (isset($ZEND_PATH))
    set_include_path(get_include_path().PATH_SEPARATOR.$ZEND_PATH);
if (isset($PEAR_PATH))
    set_include_path(get_include_path().PATH_SEPARATOR.$PEAR_PATH);
set_include_path(get_include_path().PATH_SEPARATOR.__DIR__.DIRECTORY_SEPARATOR.'..'.DIRECTORY_SEPARATOR.'lib');
/**
 * Loads forest progetto bosco module
 */
require(__DIR__.DIRECTORY_SEPARATOR.'..'.DIRECTORY_SEPARATOR.'lib'.DIRECTORY_SEPARATOR.'pb'.DIRECTORY_SEPARATOR.'forest'.DIRECTORY_SEPARATOR.'autoloader.php') ;
if (!function_exists('redirect')) {
    require(__DIR__.DIRECTORY_SEPARATOR.'..'.DIRECTORY_SEPARATOR.'lib'.DIRECTORY_SEPARATOR.'pb_base'.DIRECTORY_SEPARATOR.'functions.php') ;
    require(__DIR__.DIRECTORY_SEPARATOR.'..'.DIRECTORY_SEPARATOR.'lib'.DIRECTORY_SEPARATOR.'pb_base'.DIRECTORY_SEPARATOR.'insert_update.php') ;
}
$db = Zend_Db::factory($DB_CONFIG['adapter'],$DB_CONFIG);
$db->getConnection();
Zend_Db_Table::setDefaultAdapter($db);
$log = new Log();
//Profiler
if (isset($DEBUG) && $DEBUG) {
    $profiler = $db->getProfiler();
    $profiler->setEnabled(true);
    $firephp = FirePHP::getInstance(true);
    function lastQuery(){
        $query_profile = $GLOBALS['profiler']->getLastQueryProfile();
        $GLOBALS['firephp']->log($query_profile);
    }
} else {
    function lastQuery(){}
}
// Manages session
require(__DIR__.DIRECTORY_SEPARATOR.'session.php');