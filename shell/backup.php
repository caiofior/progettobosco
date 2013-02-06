<?php
require (__DIR__.DIRECTORY_SEPARATOR.'..'.DIRECTORY_SEPARATOR.'config.php');
echo exec ('sudo -u '.$DB_CONFIG['username'].' pg_dump '.$DB_CONFIG['dbname'].' > '.__DIR__.DIRECTORY_SEPARATOR.$DB_CONFIG['dbname'].'.sql;');