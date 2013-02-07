<?php
require (__DIR__.DIRECTORY_SEPARATOR.'..'.DIRECTORY_SEPARATOR.'config.php');
echo exec ('sudo -u '.$DB_CONFIG['username'].' psql -c "
SELECT  \'SELECT SETVAL(\' ||quote_literal(S.relname)|| \', MAX(\' ||quote_ident(C.attname)|| \') ) FROM \' ||quote_ident(T.relname)|| \';\'
FROM pg_class AS S, pg_depend AS D, pg_class AS T, pg_attribute AS C
WHERE S.relkind = \'S\'
    AND S.oid = D.objid
    AND D.refobjid = T.oid
    AND D.refobjid = C.attrelid
    AND D.refobjsubid = C.attnum
ORDER BY S.relname;    
"');
echo exec ('sudo -u '.$DB_CONFIG['username'].' pg_dump '.$DB_CONFIG['dbname'].' > '.__DIR__.DIRECTORY_SEPARATOR.$DB_CONFIG['dbname'].'.sql;');


