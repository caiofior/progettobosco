<?php
$PHPUNIT = true;
require (__DIR__.DIRECTORY_SEPARATOR.'..'.DIRECTORY_SEPARATOR.'include'.DIRECTORY_SEPARATOR.'pageboot.php');
$db = Zend_Db_Table::getDefaultAdapter();
$db->query('DELETE FROM propriet');
