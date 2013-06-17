<?php
/**
 * @author Claudio Fior <caiofior@gmail.com>
 * @copyright CRA
 * Descrizione page contoller
 */
$a = new \forest\entity\A();
$a->loadFromId($_REQUEST['id']);
if (key_exists('action', $_REQUEST)) {
    switch ($_REQUEST['action']) {
        case 'generate':
            echo $a->generateDescription();
            die('Generate');
        break;
    }
}
die('HI');
