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
 * Pear indtall directory
 */
$PEAR_PATH ='/usr/share/php/';
/**
 * Sets debug options
 */
$DEBUG=true;
/**
 * Monitoring enabled
 */
$MONITORING=true;
/**
 * Base url of the web site
 */
if (key_exists('SERVER_NAME', $_SERVER))
    $BASE_URL ='http://'.$_SERVER['SERVER_NAME'].'/progettobosco/public/';
else
    $BASE_URL ='http://127.0.0.1/progettobosco/public/';
/**
 * Site name
 */
$SITE_NAME='Progettobosco';
/**
 * Database configuration
 */
$DB_CONFIG = array(
    'adapter'   => 'Mysqli', 
    'host'      => 'localhost', 
    'port'      => '3306', 
    'username'  => 'root', 
    'password'  => '', 
    'dbname'    => 'progettobosco_master'
    );
/*$DB_CONFIG = array(
    'adapter'   => 'Pgsql', 
    'host'      => 'localhost', 
    'port'      => '5432', 
    'username'  => 'postgres', 
    'password'  => 'postgres', 
    'dbname'    => 'progettobosco_master'
    );
/**
 * Administrator mail configuration
 */
$MAIL_ADMIN_CONFIG = array(
    'server' => 'smtp.entecra.it',
    'auth' => 'login',
    'username' => 'claudio.fior@entecra.it',
    'password' => 'topolino',
    'from' => 'claudio.fior@entecra.it',
    'from_name' => 'Claudio Fior'
    
);
/**
 * Debug mail for server maitenance
 */
//$DEBUG_MAIL='caiofior@gmail.com';
/**
 * Test forest
 */
$TEST_FOREST = '14003';