<?php
// include functions
        require (__DIR__.DIRECTORY_SEPARATOR.'..'.DIRECTORY_SEPARATOR.'config.php');
        if (isset($ZEND_PATH))
            set_include_path(get_include_path().PATH_SEPARATOR.'/usr/share/php/libzend-framework-php');
        require('Zend'.DIRECTORY_SEPARATOR.'Loader.php');
        require(__DIR__.DIRECTORY_SEPARATOR.'..'.DIRECTORY_SEPARATOR.'lib'.DIRECTORY_SEPARATOR.'pb'.DIRECTORY_SEPARATOR.'autoloader.php') ;
	require(__DIR__.DIRECTORY_SEPARATOR.'..'.DIRECTORY_SEPARATOR.'lib'.DIRECTORY_SEPARATOR.'pb_base'.DIRECTORY_SEPARATOR.'functions.php') ;
        require(__DIR__.DIRECTORY_SEPARATOR.'..'.DIRECTORY_SEPARATOR.'lib'.DIRECTORY_SEPARATOR.'pb_base'.DIRECTORY_SEPARATOR.'insert_update.php') ;

// connession pg
	  $dbname="progettobosco15-05-11"; //progettobosco28-09-10 dumpSboarina  pietrabbondante
	  $conn=pg_Connect( "host=localhost user=postgres password=postgres dbname=$dbname" ) or die("Impossibile collegarsi al server");
	  if(!$conn){die("Impossibile connettersi al database $dbname");}
          Zend_Loader::loadClass('Zend_View');

