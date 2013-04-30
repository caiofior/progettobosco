<?php
/**
 * Autoloading files
 * 
 * Autoloading files
 * 
 * @author Claudio Fior <caiofior@gmail.com>
 * @copyright CRA
 */
if (!class_exists('Zend_Loader')) {
    require('FirePHPCore'.DIRECTORY_SEPARATOR.'fb.php');
    require('Zend'.DIRECTORY_SEPARATOR.'Loader.php');
    Zend_Loader::loadClass('Zend_View');
    Zend_Loader::loadClass('Zend_Registry');
    Zend_Loader::loadClass('Zend_Db');
    Zend_Loader::loadClass('Zend_Db_Table');
    Zend_Loader::loadClass('Zend_Auth');
    Zend_Loader::loadClass('Zend_Auth_Adapter_DbTable');
    Zend_Loader::loadClass('Zend_Json');
    Zend_Loader::loadClass('Zend_Mail');
    Zend_Loader::loadClass('Zend_Mail_Transport_Smtp');
    Zend_Loader::loadClass('Zend_Cache');
    Zend_Loader::loadClass('Zend_Cache_Core');
    Zend_Loader::loadClass('Zend_Cache_Backend_Apc');
    Zend_Loader::loadClass('Zend_Cache_Backend_File');
    
    if (!key_exists('PHPUNIT',$GLOBALS) || !$GLOBALS['PHPUNIT']) {
        $GLOBALS['CACHE'] = new Zend_Cache_Core(array('automatic_serialization'=>true));
        /*if (in_array('apc',get_loaded_extensions()) || false)
            $GLOBALS['CACHE']->setBackend(new Zend_Cache_Backend_Apc());
        else */
            $GLOBALS['CACHE']->setBackend(new Zend_Cache_Backend_File());
        Zend_Db_Table_Abstract::setDefaultMetadataCache($GLOBALS['CACHE']);
    }
    require (__DIR__.DIRECTORY_SEPARATOR.'core'.DIRECTORY_SEPARATOR.'content.php');
    require (__DIR__.DIRECTORY_SEPARATOR.'core'.DIRECTORY_SEPARATOR.'contentcoll.php');
    require (__DIR__.DIRECTORY_SEPARATOR.'core'.DIRECTORY_SEPARATOR.'formerrors.php');
    require (__DIR__.DIRECTORY_SEPARATOR.'core'.DIRECTORY_SEPARATOR.'template.php');
    require (__DIR__.DIRECTORY_SEPARATOR.'core'.DIRECTORY_SEPARATOR.'user.php');
    require (__DIR__.DIRECTORY_SEPARATOR.'core'.DIRECTORY_SEPARATOR.'usercoll.php');
    require (__DIR__.DIRECTORY_SEPARATOR.'core'.DIRECTORY_SEPARATOR.'profile.php');
    require (__DIR__.DIRECTORY_SEPARATOR.'core'.DIRECTORY_SEPARATOR.'log.php');
}