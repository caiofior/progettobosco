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
        'attribute'.DIRECTORY_SEPARATOR.'soiluse.php',
        'attribute'.DIRECTORY_SEPARATOR.'soilusecoll.php',
        'attribute'.DIRECTORY_SEPARATOR.'collector.php',
        'attribute'.DIRECTORY_SEPARATOR.'collectorcoll.php',
        'attribute'.DIRECTORY_SEPARATOR.'municipality.php',
        'attribute'.DIRECTORY_SEPARATOR.'municipalitycoll.php',
        'attribute'.DIRECTORY_SEPARATOR.'province.php',
        'attribute'.DIRECTORY_SEPARATOR.'provincecoll.php',
        'attribute'.DIRECTORY_SEPARATOR.'physiographicposition.php',
        'attribute'.DIRECTORY_SEPARATOR.'physiographicpositioncoll.php',
        'attribute'.DIRECTORY_SEPARATOR.'aspect.php',
        'attribute'.DIRECTORY_SEPARATOR.'aspectcoll.php',
        'attribute'.DIRECTORY_SEPARATOR.'surfaceerosion.php',
        'attribute'.DIRECTORY_SEPARATOR.'surfaceerosioncoll.php',
        'attribute'.DIRECTORY_SEPARATOR.'catastrophicerosion.php',
        'attribute'.DIRECTORY_SEPARATOR.'catastrophicerosioncoll.php',
        'attribute'.DIRECTORY_SEPARATOR.'surfacelandslide.php',
        'attribute'.DIRECTORY_SEPARATOR.'surfacelandslidecoll.php',
        'attribute'.DIRECTORY_SEPARATOR.'stonerolling.php',
        'attribute'.DIRECTORY_SEPARATOR.'stonerollingcoll.php',
        'attribute'.DIRECTORY_SEPARATOR.'otherinstability.php',
        'attribute'.DIRECTORY_SEPARATOR.'otherinstabilitycoll.php',
        'attribute'.DIRECTORY_SEPARATOR.'superficialsoil.php',
        'attribute'.DIRECTORY_SEPARATOR.'superficialsoilcoll.php',
        'attribute'.DIRECTORY_SEPARATOR.'superficialrock.php',
        'attribute'.DIRECTORY_SEPARATOR.'superficialrockcoll.php',
        'attribute'.DIRECTORY_SEPARATOR.'rockiness.php',
        'attribute'.DIRECTORY_SEPARATOR.'rockinesscoll.php',
        'attribute'.DIRECTORY_SEPARATOR.'waterstasis.php',
        'attribute'.DIRECTORY_SEPARATOR.'waterstasiscoll.php',
        'attribute'.DIRECTORY_SEPARATOR.'otherrootlimitingfactor.php',
        'attribute'.DIRECTORY_SEPARATOR.'otherrootlimitingfactorcoll.php',
        'attribute'.DIRECTORY_SEPARATOR.'livestock.php',
        'attribute'.DIRECTORY_SEPARATOR.'livestockcoll.php',
        'attribute'.DIRECTORY_SEPARATOR.'wildanimal.php',
        'attribute'.DIRECTORY_SEPARATOR.'wildanimalcoll.php',
        'form'.DIRECTORY_SEPARATOR.'a.php',
        'form'.DIRECTORY_SEPARATOR.'acoll.php'
        );
    if (!isset($file)) $file = array();
    $files = array_diff($files, $file);
    foreach ($files as $file) {
        require (__DIR__.DIRECTORY_SEPARATOR.$file);
    }
}
