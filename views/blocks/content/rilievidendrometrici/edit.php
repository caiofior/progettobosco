<?php
if (!key_exists('tipo_ril', $_REQUEST))
   $_REQUEST['tipo_ril']=3;     
switch ($_REQUEST['tipo_ril']) {
    case 3 :
        require __DIR__.DIRECTORY_SEPARATOR.'edit_ird.php';
    break;
}
