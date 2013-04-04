<?php
$PHPUNIT = true;
require (__DIR__.DIRECTORY_SEPARATOR.'..'.DIRECTORY_SEPARATOR.'include'.DIRECTORY_SEPARATOR.'pageboot.php');
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
    'sched_b1',
    'sched_b2',
    'sched_b3',
    'sched_b4',
    'schede_x',
    'schede_c',
    'schede_d',
    'schede_e',
    'schede_f',
    'schede_g',
    'schede_g1',
    'schede_n',
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
    );
if ($argc < 1) {
    echo 'MDB path is required';
    exit;
} else if ($argc > 2) {
    foreach ($argv as $key=>$value) {
        if ($key == 0) continue;
        else $argv[1].='\\ '.$value;
        
    }
}
$config = <<<EOL
[pgsql]     
host = '{$DB_CONFIG['host']}'
port = {$DB_CONFIG['port']}        
base = '{$DB_CONFIG['dbname']}'
user = '{$DB_CONFIG['username']}'
pass = '{$DB_CONFIG['password']}'
log_file            = pgloader.log
log_min_messages    = INFO
client_min_messages = ERROR
copy_every      = 100

[tmpl]
template     = True
format       = csv
field_sep    = ,
trailing_sep = True

EOL;
if(!is_dir(__DIR__.DIRECTORY_SEPARATOR.'output'))
    mkdir (__DIR__.DIRECTORY_SEPARATOR.'output');

foreach ($tables as $table) {
    $filename = __DIR__.DIRECTORY_SEPARATOR.'output'.DIRECTORY_SEPARATOR.$table.'.txt';
    $filename_t = __DIR__.DIRECTORY_SEPARATOR.'output'.DIRECTORY_SEPARATOR.$table.'_t.txt';
    $logname = __DIR__.DIRECTORY_SEPARATOR.'output'.DIRECTORY_SEPARATOR.$table.'.log';
    $dataname = __DIR__.DIRECTORY_SEPARATOR.'output'.DIRECTORY_SEPARATOR.$table.'.data';
    if (is_file($filename)) unlink($filename);
    if (is_file($filename_t)) unlink($filename_t);
    if (is_file($logname)) unlink($logname);
    if (is_file($dataname)) unlink($dataname);
    exec('mdb-export -D "%Y-%m-%d %H:%M:%S" '.$argv[1].' '.$table.' > '.$filename);
    
    $file_input = fopen ($filename,'r');
    $file_output = fopen ($filename_t,'w');
    $p = ftell($file_input);
    $columns_str = '';
    $key_field = null;
    $max_objectid=0;
    if (is_resource($file_input)) {
        while ($row = fgets($file_input)) {
            if ($p == 0) {
                $db_cols = $db->fetchCol('SELECT column_name FROM information_schema.columns WHERE table_name =\''.$table.'\'');
                $db_cols = array_reverse($db_cols);
                $columns = str_replace("\n",'',strtolower($row));
                $columns = explode(',',$columns);
                foreach ($db_cols as $db_col) {
                    $key = array_search($db_col, $columns);
                    if ($key === false) continue;
                    if ($columns_str != '')
                        $columns_str .= ',';
                    $columns_str .= $db_col.':'.($key+1);        
                }
                if ( in_array($table, $incrementid) && 
                        in_array('objectid', $columns)) {
                    $key_field = array_search('objectid', $columns);
                    $max_objectid=  $db->fetchOne('SELECT MAX(objectid) FROM '.$table);
                }
                else if ( in_array($table, $preserveid) && 
                        in_array('objectid', $columns)) {
                    $key_field = array_search('objectid', $columns);
                }

            }
            else {
                preg_match_all('/[0-9]\.[0-9]*e\+[0-9]{2}/', $row,$e_matches);
                if (key_exists(0, $e_matches)) {
                    foreach($e_matches[0] as $e_match) {
                        $row = str_replace($e_match, floatval($e_match), $row);
                    }
                }
                if ( in_array($table, $incrementid)
                        && in_array('objectid', $columns)) {
                    fseek($file_input, $p);
                    $row_csv = fgetcsv($file_input,0,',','"');
                    $value = $row_csv[$key_field];
                    $row = str_replace(','.$value.',', ','.($value+$max_objectid).',', $row);
                    $row = preg_replace('/,'.$value.'$/', ','.($value+$max_objectid), $row);
                }
                else if ( in_array($table, $preserveid) && 
                        in_array('objectid', $columns)) {
                    fseek($file_input, $p);
                    $row_csv = fgetcsv($file_input,0,',','"');
                    $value = $row_csv[$key_field];
                    $max_objectid = max($max_objectid,$value);
                }
                fputs($file_output,$row);
            }
            $p = ftell($file_input);
        }
        fclose($file_input);
        fclose($file_output);
    }
file_put_contents('pgloader.conf', $config. <<<EOL

[{$table}]
use_template    = tmpl
table           = {$table}
filename = {$filename_t}
columns = {$columns_str}
reject_log = output/{$table}.log
reject_data = output/{$table}.data

EOL
);
if ( in_array($table, $preserveid) && 
    in_array('objectid', $columns)) {
    $max_objectid=  max(0,$db->fetchOne('SELECT MAX(objectid) FROM '.$table));
    $db->query('UPDATE '.$table.' SET objectid = objectid + '.intval($max_objectid));
 }
exec('pgloader '.$table);
if ( in_array($table, $incrementid)
    && in_array('objectid', $columns)) {
     $max_objectid=  max(0,$db->fetchOne('SELECT MAX(objectid) FROM '.$table));
     $db->query('UPDATE '.$table.' SET objectid = objectid+'.$max_objectid);
     $db->query('SELECT setval(\''.$table.'_objectid_seq\', 1)');
     $db->query('UPDATE '.$table.' SET objectid = DEFAULT');
     $db->query('VACUUM '.$table);
} else if ( in_array($table, $preserveid)
    && in_array('objectid', $columns)) {
     $max_objectid=  max(0,$db->fetchOne('SELECT MAX(objectid) FROM '.$table));
     $db->query('UPDATE '.$table.' SET objectid = objectid+'.$max_objectid);
     $db->query('SELECT setval(\''.$table.'_objectid_seq\', 1)');
     $db->query('UPDATE '.$table.' SET objectid = DEFAULT');
     $db->query('VACUUM '.$table);
} 
if (is_file('pgloader.conf')) unlink('pgloader.conf');
if (is_file($filename)) unlink($filename);
if (is_file($filename_t)) unlink($filename_t);
$error = file_exists($logname) && filesize($logname) > 0;
if (is_file($logname) && !$error) unlink($logname);
if (is_file($dataname) && !$error) unlink($dataname);
}
