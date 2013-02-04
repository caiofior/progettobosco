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
        'regioncoll.php',
        'attribute'.DIRECTORY_SEPARATOR.'template'.DIRECTORY_SEPARATOR.'attribute.php',
        'attribute'.DIRECTORY_SEPARATOR.'template'.DIRECTORY_SEPARATOR.'attributecoll.php',
        'attribute'.DIRECTORY_SEPARATOR.'template'.DIRECTORY_SEPARATOR.'piu1_3.php',
        'attribute'.DIRECTORY_SEPARATOR.'template'.DIRECTORY_SEPARATOR.'piu1_3coll.php',
        'attribute'.DIRECTORY_SEPARATOR.'template'.DIRECTORY_SEPARATOR.'piu2_3.php',
        'attribute'.DIRECTORY_SEPARATOR.'template'.DIRECTORY_SEPARATOR.'piu2_3coll.php',
        'attribute'.DIRECTORY_SEPARATOR.'soiluse.php',
        'attribute'.DIRECTORY_SEPARATOR.'soilusecoll.php',
        'attribute'.DIRECTORY_SEPARATOR.'collector.php',
        'attribute'.DIRECTORY_SEPARATOR.'collectorcoll.php',
        'attribute'.DIRECTORY_SEPARATOR.'municipality.php',
        'attribute'.DIRECTORY_SEPARATOR.'municipalitycoll.php',
        'attribute'.DIRECTORY_SEPARATOR.'province.php',
        'attribute'.DIRECTORY_SEPARATOR.'provincecoll.php',
        'form'.DIRECTORY_SEPARATOR.'template'.DIRECTORY_SEPARATOR.'form.php',
        'form'.DIRECTORY_SEPARATOR.'template'.DIRECTORY_SEPARATOR.'formcoll.php',
        'form'.DIRECTORY_SEPARATOR.'control'.DIRECTORY_SEPARATOR.'item.php',
        'form'.DIRECTORY_SEPARATOR.'control'.DIRECTORY_SEPARATOR.'itemcoll.php',
        'form'.DIRECTORY_SEPARATOR.'a.php',
        'form'.DIRECTORY_SEPARATOR.'acoll.php'
        );
    if (!isset($file)) $file = array();
    $files = array_diff($files, $file);
    foreach ($files as $file) {
        require (__DIR__.DIRECTORY_SEPARATOR.$file);
    }
}
