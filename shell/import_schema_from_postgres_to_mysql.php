<?php
$PHPUNIT = true;
require (__DIR__.DIRECTORY_SEPARATOR.'..'.DIRECTORY_SEPARATOR.'include'.DIRECTORY_SEPARATOR.'pageboot.php');
$dir = __DIR__.DIRECTORY_SEPARATOR;
require (__DIR__.DIRECTORY_SEPARATOR.'table_order.php');
/*if ($argc < 1) {
    echo 'MDB path is required';
    exit;
} else if ($argc > 2) {
    foreach ($argv as $key=>$value) {
        if ($key == 0) continue;
        else $argv[1].='\\ '.$value;
        
    }
}*/
$db1 = $argv;
echo exec ('sudo -u '.$DB_CONFIG['username'].' pg_dump --schema-only --format p --inserts '.$DB_CONFIG['dbname'].' > '.$dir.'pg_schema.sql;');
$argv[1]=$dir.'pg_schema.sql';
$argv[2]=$dir.'mysql_schema.sql';    
require $dir.'..'.DIRECTORY_SEPARATOR.'lib'.DIRECTORY_SEPARATOR.'pg2mysql-1.9'.DIRECTORY_SEPARATOR.'pg2mysql_cli.php' ;
$pass = '';
if ($db1[3] != '') $pass = ' -p'.$db1[3];
echo exec ('mysqladmin -h '.$db1[1].' -u '.$db1[2].$pass.' -f DROP '.$db1[4]);
echo exec ('mysqladmin -h '.$db1[1].' -u '.$db1[2].$pass.' CREATE '.$db1[4]);
echo exec ('mysql -h '.$db1[1].' -u '.$db1[2].$pass.' '.$db1[4].' --force < '.$dir.'mysql_schema.sql');
