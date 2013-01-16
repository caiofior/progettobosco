<?php
/**
 * @author Claudio Fior <caiofior@gmail.com>
 * @copyright CRA
 * Autoloading files
 */
if (!class_exists('Zend_Loader')) {
    require('Zend'.DIRECTORY_SEPARATOR.'Loader.php');
    Zend_Loader::loadClass('Zend_View');
    Zend_Loader::loadClass('Zend_Registry');
    Zend_Loader::loadClass('Zend_Db');
    Zend_Loader::loadClass('Zend_Db_Table');
    Zend_Loader::loadClass('Zend_Auth');
    Zend_Loader::loadClass('Zend_Auth_Adapter_DbTable');
    Zend_Loader::loadClass('Zend_Json');
    require (__DIR__.DIRECTORY_SEPARATOR.'core'.DIRECTORY_SEPARATOR.'utils.php');
    require (__DIR__.DIRECTORY_SEPARATOR.'core'.DIRECTORY_SEPARATOR.'content.php');
    require (__DIR__.DIRECTORY_SEPARATOR.'core'.DIRECTORY_SEPARATOR.'formerrors.php');
    require (__DIR__.DIRECTORY_SEPARATOR.'core'.DIRECTORY_SEPARATOR.'user.php');
    require (__DIR__.DIRECTORY_SEPARATOR.'core'.DIRECTORY_SEPARATOR.'profile.php');
    require (__DIR__.DIRECTORY_SEPARATOR.'core'.DIRECTORY_SEPARATOR.'log.php');
}