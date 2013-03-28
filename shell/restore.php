<?php
require (__DIR__.DIRECTORY_SEPARATOR.'..'.DIRECTORY_SEPARATOR.'config.php');
echo exec ('sudo -u '.$DB_CONFIG['username'].' psql -c "DROP DATABASE '.$DB_CONFIG['dbname'].';"');
echo exec ('sudo -u '.$DB_CONFIG['username'].' psql -c "CREATE DATABASE '.$DB_CONFIG['dbname'].';"');
echo exec ('sudo -u '.$DB_CONFIG['username'].' psql '.$DB_CONFIG['dbname'].' < '.__DIR__.DIRECTORY_SEPARATOR.$DB_CONFIG['dbname'].'.sql;');