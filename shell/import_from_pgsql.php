<?php
$PHPUNIT = true;
require (__DIR__.DIRECTORY_SEPARATOR.'..'.DIRECTORY_SEPARATOR.'include'.DIRECTORY_SEPARATOR.'pageboot.php');
$tables = array(
    //Observer,
    'rilevato',
    //Forest types
   'diz_tipi',
    //Tables
   'diz_tavole',
    'diz_tavole2',
    'diz_tavole3',
    'diz_tavole4',
    'diz_tavole5',
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
if ($argc < 1) {
    echo 'MDB path is required';
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
log_min_messages    = INFO
client_min_messages = WARNING
copy_every      = 100

[tmpl]
template     = True
format       = text
datestyle    = dmy
field_sep    = ,
trailing_sep = True

EOL;
if(!is_dir(__DIR__.DIRECTORY_SEPARATOR.'output'))
    mkdir (__DIR__.DIRECTORY_SEPARATOR.'output');

foreach ($tables as $table) {
    $filename = __DIR__.DIRECTORY_SEPARATOR.'output'.DIRECTORY_SEPARATOR.$table.'.txt';
    $logname = __DIR__.DIRECTORY_SEPARATOR.'output'.DIRECTORY_SEPARATOR.$table.'.log';
    $dataname = __DIR__.DIRECTORY_SEPARATOR.'output'.DIRECTORY_SEPARATOR.$table.'.data';
    if (is_file($filename)) unlink($filename);
    if (is_file($logname)) unlink($logname);
    if (is_file($dataname)) unlink($dataname);
    exec('sudo -u '.$DB_CONFIG['username'].' psql '.$argv[1].' -c "COPY '.$table.' TO \''.$filename.'\'  " ');
    $config .= <<<EOL

[{$table}]
use_template    = tmpl
table           = '{$table}'
filename = {$filename}
reject_log = output/{$table}.log
reject_data = output/{$table}.data

EOL;
}
file_put_contents('pgloader.conf', $config);
exec('pgloader');
unlink('pgloader.conf');