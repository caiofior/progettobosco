<?php
namespace forest\attribute;
/**
 * @author Claudio Fior <caiofior@gmail.com>
 * @copyright CRA
 * Manages Surface Erosion collection
 */
if (!class_exists('Content')) {
    $file = 'form'.DIRECTORY_SEPARATOR.array(basename(__FILE__));
    $PHPUNIT=true;
    require (__DIR__.
                DIRECTORY_SEPARATOR.'..'.
                DIRECTORY_SEPARATOR.'..'.
                DIRECTORY_SEPARATOR.'..'.
                DIRECTORY_SEPARATOR.'..'.
                DIRECTORY_SEPARATOR.'include'.
                DIRECTORY_SEPARATOR.'pageboot.php');
}
/**
 * @author Claudio Fior <caiofior@gmail.com>
 * @copyright CRA
 *
 * Manages Surface Erosion collection
 */
class SurfaceErosionColl  extends template\Piu1_3Coll {
    /**
     * Instantiates the table
     */
    public function __construct() {
        parent::__construct(new SurfaceErosion());
    }
}