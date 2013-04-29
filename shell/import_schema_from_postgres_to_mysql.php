<?php
$PHPUNIT = true;
require (__DIR__.DIRECTORY_SEPARATOR.'..'.DIRECTORY_SEPARATOR.'include'.DIRECTORY_SEPARATOR.'pageboot.php');
$dir = __DIR__.DIRECTORY_SEPARATOR;
require (__DIR__.DIRECTORY_SEPARATOR.'table_order.php');
if(!is_dir($dir.'output'))
    mkdir ($dir.DIRECTORY_SEPARATOR.'output');
if ($argc < 5) {
    echo 'Mysql connection is required';
    exit;
}
$db1 = $argv;
echo exec ('sudo -u '.$DB_CONFIG['username'].' pg_dump --schema-only --format p --inserts '.$DB_CONFIG['dbname'].' > '.$dir.'output'.DIRECTORY_SEPARATOR.'pg_schema.sql;');
$argv[1]=$dir.'output'.DIRECTORY_SEPARATOR.'pg_schema.sql';
$argv[2]=$dir.'output'.DIRECTORY_SEPARATOR.'mysql_schema.sql';    
require $dir.'..'.DIRECTORY_SEPARATOR.'lib'.DIRECTORY_SEPARATOR.'pg2mysql-1.9'.DIRECTORY_SEPARATOR.'pg2mysql_cli.php' ;
$pass = '';
if ($db1[3] != '') $pass = ' -p'.$db1[3];
echo exec ('mysqladmin -h '.$db1[1].' -u '.$db1[2].$pass.' -f DROP '.$db1[4]);
echo exec ('mysqladmin -h '.$db1[1].' -u '.$db1[2].$pass.' CREATE '.$db1[4]);
echo exec ('mysql -h '.$db1[1].' -u '.$db1[2].$pass.' '.$db1[4].' --force < '.$dir.'output'.DIRECTORY_SEPARATOR.'mysql_schema.sql');
unlink ($dir.'output'.DIRECTORY_SEPARATOR.'pg_schema.sql');
unlink ($dir.'output'.DIRECTORY_SEPARATOR.'mysql_schema.sql');
$all_tables = $db->fetchCol('SELECT table_name FROM information_schema.tables WHERE table_schema=\'public\'');
$common_table = array_diff($all_tables, $preserveid);
$all_tables = array_merge($common_table, $preserveid);
foreach ($all_tables as $table) {
    $filename = $dir.'output'.DIRECTORY_SEPARATOR.$table.'.csv';
    exec('sudo -u '.$DB_CONFIG['username'].' psql '.$DB_CONFIG['dbname'].' -c "COPY '.$table.' TO \''.$filename.'\' WITH CSV "');
    echo exec('mysqlimport -h '.$db1[1].' -u '.$db1[2].$pass.' --local --fields-terminated-by="," --fields-enclosed-by="" '.$db1[4].' '.$filename);
    unlink($filename);
}