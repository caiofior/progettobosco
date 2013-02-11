<?php
/**
 * Autoloading forest files
 * 
 * Autoloading forest files
 * @author Claudio Fior <caiofior@gmail.com>
 * @copyright CRA
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
        'attribute'.DIRECTORY_SEPARATOR.'notea.php',
        'attribute'.DIRECTORY_SEPARATOR.'noteacoll.php',
        'attribute'.DIRECTORY_SEPARATOR.'notetemplate.php',
        'attribute'.DIRECTORY_SEPARATOR.'notetemplatecoll.php',
        'attribute'.DIRECTORY_SEPARATOR.'cadastral.php',
        'attribute'.DIRECTORY_SEPARATOR.'cadastralcoll.php',
        'attribute'.DIRECTORY_SEPARATOR.'foresttype.php',
        'attribute'.DIRECTORY_SEPARATOR.'foresttypecoll.php',
        'attribute'.DIRECTORY_SEPARATOR.'structure.php',
        'attribute'.DIRECTORY_SEPARATOR.'structurecoll.php',
        'form'.DIRECTORY_SEPARATOR.'template'.DIRECTORY_SEPARATOR.'form.php',
        'form'.DIRECTORY_SEPARATOR.'template'.DIRECTORY_SEPARATOR.'formcoll.php',
        'form'.DIRECTORY_SEPARATOR.'control'.DIRECTORY_SEPARATOR.'item.php',
        'form'.DIRECTORY_SEPARATOR.'control'.DIRECTORY_SEPARATOR.'itemcoll.php',
        'form'.DIRECTORY_SEPARATOR.'a.php',
        'form'.DIRECTORY_SEPARATOR.'acoll.php',
        'form'.DIRECTORY_SEPARATOR.'b.php',
        'form'.DIRECTORY_SEPARATOR.'bcoll.php',
        'form'.DIRECTORY_SEPARATOR.'b1.php',
        'form'.DIRECTORY_SEPARATOR.'b1coll.php'
        );
    if (!isset($file)) $file = array();
    $files = array_diff($files, $file);
    foreach ($files as $file) {
        require (__DIR__.DIRECTORY_SEPARATOR.$file);
    }
}
