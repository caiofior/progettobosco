<?php
$PHPUNIT = true;
require (__DIR__.DIRECTORY_SEPARATOR.'..'.DIRECTORY_SEPARATOR.'include'.DIRECTORY_SEPARATOR.'pageboot.php');
$dir = __DIR__.DIRECTORY_SEPARATOR;
$tables = array(
    //Observer,
    //'rilevato',
    //Forest types
   //'diz_tipi',
    //Tables
   //'diz_tavole',
    //'diz_tavole2',
    //'diz_tavole3',
    //'diz_tavole4',
    //'diz_tavole5',
    //Forest
    'propriet',
    //Foms
    'schede_a',
    'schede_b',
    'schede_c',
    'schede_d',
    'schede_e',
    'schede_f',
    'schede_g',
    'schede_g1',
    'schede_n',
    'schede_x',
    'sched_b1',
    'sched_b2',
    'sched_b3',
    'sched_b4',
    'sched_c1',
    'sched_c2',
    'sched_d1',
    'sched_e1',
    'sched_f1',
    'sched_f2',
    'sched_l1',
    'sched_l1b',
    //Cadastral
  'catasto',
  'compresa',
   'partcomp',
    //Forest
    'tipi_for',
  'arboree',
  'arboree2',
  'arboree4a',
  'arboree4b',
    //Shrub
  'arbusti',
  'arbusti2',
  'arbusti3',
  'arb_colt',
    //Herbaceus
   'erbacee',
   'erbacee2',
   'erbacee3',
   'erbacee4',
    //Rennovation
    'rinnovaz',
    //Notes
    'leg_note',
    'note_a',
    'note_b',
    'note_b2',
    'note_b3',
    'note_b4',
    'note_n',
    //problems
    'problemi_a',
    'problemi_b1',
    'problemi_b2',
    'problemi_b3',
    'problemi_b4'
);
$preserveid = array(
    'schede_a',
    'schede_b',
    'sched_b1',
    'sched_b2',
    'sched_b3',
    'sched_b4',
    'schede_x',
    'schede_d',
);
$incrementid = array(
    'note_a',
    'catasto',
    'note_b',
    'arboree',
    'erbacee',
    'arbusti',
    'stime_b1',
    'note_b2',
    'arboree2',
    'arbusti2',
    'erbacee2',
    'note_b3',
    'arbusti3',
    'erbacee3',
    'infestan',
    'comp_arb',
    'rinnovaz',
    'arb_colt',
    'arboree4a',
    'arboree4b',
    'erbacee4',
    );
if ($argc < 1) {
    echo 'postgres origin is required';
    exit;
}
$config = <<<EOL
[pgsql]     
host = '{$DB_CONFIG['host']}'
port = {$DB_CONFIG['port']}        
base = '{$DB_CONFIG['dbname']}'
user = '{$DB_CONFIG['username']}'
pass = '{$DB_CONFIG['password']}'
log_file            = pgloader.log
client_min_messages = ERROR
copy_every      = 100

[tmpl]
template     = True
format       = text
field_sep    = ,


EOL;
if(!is_dir($dir.'output'))
    mkdir ($dir.'output');
$or_config = $DB_CONFIG;
$or_config['dbname']=$argv[1];
$db_or = Zend_Db::factory($DB_CONFIG['adapter'],$or_config);
$db_or->getConnection();

foreach ($tables as $table) {
    $filename = $dir.'output'.DIRECTORY_SEPARATOR.$table.'.txt';
    $filename_t = $dir.'output'.DIRECTORY_SEPARATOR.$table.'_t.txt';
    $logname = $dir.'output'.DIRECTORY_SEPARATOR.$table.'.log';
    $dataname = $dir.'output'.DIRECTORY_SEPARATOR.$table.'.data';
    if (is_file($filename)) unlink($filename);
    if (is_file($logname)) unlink($logname);
    if (is_file($dataname)) unlink($dataname);
    $dest_cols = $db->fetchCol('SELECT column_name FROM information_schema.columns WHERE table_name =\''.$table.'\'');
    $dest_cols = array_reverse($dest_cols);
    $or_cols = $db_or->fetchCol('SELECT column_name FROM information_schema.columns WHERE table_name =\''.$table.'\'');
    $or_cols = array_reverse($or_cols);
    $columns_str='';
    foreach ($dest_cols as $dest_col) {
        $key = array_search($dest_col, $or_cols);
        if ($key === false) continue;
        if ($columns_str != '')
            $columns_str .= ',';
        $columns_str .= $dest_col.':'.($key+1);        
    }
    $max_objectid=0;
    exec('sudo -u '.$DB_CONFIG['username'].' psql '.$argv[1].' -c "COPY '.$table.' TO \''.$filename.'\' WITH CSV "');
    if ( in_array($table, $incrementid) && 
            in_array('objectid', $or_cols)) {
        $file_input = fopen($filename, 'r');
        $file_output = fopen ($filename_t,'w');
        $key_field = array_search('objectid', $or_cols);
        $max_objectid=  $db->fetchOne('SELECT MAX(objectid) FROM '.$table);
        $p=0;
        while ($row = fgets($file_input)) {
            fseek($file_input, $p);
            $row_csv = fgetcsv($file_input,0,',','"');
            $value = $row_csv[$key_field];
            $row = str_replace(','.$value.',', ','.($value+$max_objectid).',', $row);
            $row = preg_replace('/,'.$value.'$/', ','.($value+$max_objectid), $row);
            fputs($file_output,$row);
            $p = ftell($file_input);
        }
        fclose($file_input);
        fclose($file_output);
    } else if ( in_array($table, $preserveid) && 
        in_array('objectid', $or_cols)) {
        $key_field = array_search('objectid', $or_cols);
        $max_objectid=  max(
                $db_or->fetchOne('SELECT MAX(objectid) FROM '.$table),
                $db->fetchOne('SELECT MAX(objectid) FROM '.$table)
                );
        $db->query('UPDATE '.$table.' SET objectid = objectid + '.intval($max_objectid));
        copy($filename,$filename_t);
    }
    else copy($filename,$filename_t);
    file_put_contents('pgloader.conf', $config. <<<EOL

[{$table}]
use_template    = tmpl
table           = {$table}
filename = {$filename_t}
columns = {$columns_str}
reject_log = {$dir}output/{$table}.log
reject_data = {$dir}output/{$table}.data

EOL
);
    exec('pgloader '.$table);
    if ( in_array($table, $incrementid) && 
            in_array('objectid', $or_cols)) {
     $max_objectid=  max(0,$db->fetchOne('SELECT MAX(objectid) FROM '.$table));
     $db->query('UPDATE '.$table.' SET objectid = objectid+'.$max_objectid);
     $db->query('SELECT setval(\''.$table.'_objectid_seq\', 1)');
     $db->query('UPDATE '.$table.' SET objectid = DEFAULT');
     $db->query('VACUUM '.$table);
     $db->query('REINDEX TABLE '.$table);
} else if ( in_array($table, $preserveid) && 
        in_array('objectid', $or_cols)) {
     $max_objectid=  max(0,$db->fetchOne('SELECT MAX(objectid) FROM '.$table));
     $db->query('UPDATE '.$table.' SET objectid = objectid+'.$max_objectid);
     $db->query('SELECT setval(\''.$table.'_objectid_seq\', 1)');
     $db->query('UPDATE '.$table.' SET objectid = DEFAULT');
     $db->query('VACUUM '.$table);
     $db->query('REINDEX TABLE '.$table);
}
if (is_file('pgloader.conf')) unlink('pgloader.conf');
if (is_file($filename)) unlink($filename);
if (is_file($filename_t)) unlink($filename_t);
$error = file_exists($logname) && filesize($logname) > 0;
if (is_file($logname) && !$error) unlink($logname);
if (is_file($dataname) && !$error) unlink($dataname);
}