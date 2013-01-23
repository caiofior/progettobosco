<?php
/**
 * @author Claudio Fior <caiofior@gmail.com>
 * @copyright CRA
 * Autoloading forest files
 */
namespace forest;
if (!class_exists('Forest')) {
    if (!class_exists('Content'))
        require (__DIR__.DIRECTORY_SEPARATOR.'..'.DIRECTORY_SEPARATOR.'autoloader.php');
    $files = array(
        'forest.php',
        'forestcoll.php',
        'region.php',
        'regioncoll.php'
        );
    if (!isset($file)) $file = array();
    $files = array_diff($files, $file);
    foreach ($files as $file) {
        require (__DIR__.DIRECTORY_SEPARATOR.$file);
    }
}
