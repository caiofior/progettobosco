<?php
/**
 * @author Claudio Fior <caiofior@gmail.com>
 * @copyright CRA
 * MOnitoring script
 */
ini_set('display_errors', 0);
$script_start_time=  microtime(true);
/**
 * Resource usage monitoring
 */
function server_resource_monitoring()
{
            $error =error_get_last();
            $error_message = '';
            if ( $error['type'] != 2 &&
                 $error['type'] != 8 &&
                 $error['type'] != 32 &&
                 $error['type'] != 2048 &&
                 $error['type'] != 8192 &&   
                 $error['type'] != '') {
                $error_message = "type\t".$error["type"].PHP_EOL;
                $error_message .= "message\t".$error["message"].PHP_EOL;
                $error_message .= "file\t".$error["file"].PHP_EOL;
                $error_message .= "line\t".$error["line"].PHP_EOL;
                $mail = new Zend_Mail('UTF-8');
                $mail->setBodyText($error_message);
                $mail->setFrom($GLOBALS['MAIL_ADMIN_CONFIG']['from'], $GLOBALS['MAIL_ADMIN_CONFIG']['from_name']);
                $mail->addTo($GLOBALS['DEBUG_MAIL'],$GLOBALS['DEBUG_MAIL']);
                $mail->setSubject('Error in '.$_SERVER['SERVER_NAME']);
                $mail->send(new Zend_Mail_Transport_Smtp($GLOBALS['MAIL_ADMIN_CONFIG']['server'], $GLOBALS['MAIL_ADMIN_CONFIG']));
            }
            else $error = '';
            $resource_log_db = new SQLite3(__DIR__.DIRECTORY_SEPARATOR.'..'.DIRECTORY_SEPARATOR.'log'.DIRECTORY_SEPARATOR.'script_performance.db');
            $resource_log_db->exec('CREATE TABLE IF NOT EXISTS  resources (
                url TEXT,
                site TEXT,
                ip TEXT,
                user_agent TEXT,
                datetime NUMERIC,
                total_time NUMERIC,
                execution_time NUMERIC,
                memory NUMERIC,
                error TEXT
                );');
            $resource_log_db->exec('DELETE FROM resources WHERE datetime < DATETIME("now","-1 hour");');
            $resource_log_db->exec('INSERT INTO resources (
                    url,
                    site,
                    ip,
                    user_agent,
                    datetime,
                    total_time,
                    execution_time,
                    memory,
                    error
                    ) VALUES ('.
                    '"'.addslashes('http://'.$_SERVER['SERVER_NAME'].$_SERVER['REQUEST_URI'].'?'.$_SERVER['QUERY_STRING']).'",'.
                    '"'.addslashes($_SERVER['SERVER_NAME']).'",'.
                    '"'.addslashes($_SERVER['REMOTE_ADDR']).'",'.
                    '"'.addslashes($_SERVER['HTTP_USER_AGENT']).'",'.
                    'DATETIME("now"),'.
                    '"'.addslashes(microtime(true)-$_SERVER['REQUEST_TIME']).'",'.
                    '"'.addslashes(microtime(true)-$GLOBALS['script_start_time']).'",'.
                    '"'.addslashes(number_format(memory_get_peak_usage()/(1024*1024),2)).'",'.
                    '"'.addslashes($error_message).'"'.
                    ');');
	if (rand(1, 100) == 100) $resource_log_db->exec('VACUUM;');
        $resource_log_db->close();
			
					
}
register_shutdown_function('server_resource_monitoring');