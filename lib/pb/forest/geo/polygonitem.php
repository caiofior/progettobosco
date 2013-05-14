<?php
/**
 * Manages Geographic Polygon Item
 * 
 * Manages Geographic Polygon Item
 * 
 * @author Claudio Fior <caiofior@gmail.com>
 * @copyright CRA
 */
namespace forest\geo;
if (!class_exists('Content')) {
    $file = 'geo'.DIRECTORY_SEPARATOR.array(basename(__FILE__));
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
 * Manages Geographic Polygon Item
 * 
 * Manages Geographic Polygon Item
 * 
 * @author Claudio Fior <caiofior@gmail.com>
 * @copyright CRA
 */
class PolygonItem  extends \Content {
    /**
     * Instantiates the table
     * @param string $name table name
     */
    public function __construct($name) {
        parent::__construct($name);
    }
}
