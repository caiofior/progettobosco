<?php
/**
 * @author Claudio Fior <caiofior@gmail.com>
 * @copyright CRA
 * Main config file
 */
/**
 * Zend Directory, if not set Zend library is in include path
 */
$ZEND_PATH ='/usr/share/php/libzend-framework-php';
/**
 * Base url of the web site
 */
$BASE_URL ='http://127.0.0.1/progettobosco/public/';
$DB_CONFIG = array(
    'adapter'   => 'Pgsql', 
    'host'      => 'localhost', 
    'port'      => '5432', 
    'username'  => 'postgres', 
    'password'  => 'postgres', 
    'dbname'    => 'progettobosco_0_1'
    );