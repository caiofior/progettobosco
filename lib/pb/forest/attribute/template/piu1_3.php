<?php
/**
 * Manages Piu 1/3 attribute
 * 
 * Manages Piu 1/3 attribute
 * @author Claudio Fior <caiofior@gmail.com>
 * @copyright CRA
 */
namespace forest\attribute\template;
if (!class_exists('Content')) {
    $file = 'attribute'.DIRECTORY_SEPARATOR.array(basename(__FILE__));
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
 * Manages Piu 1/3 attribute
 * 
 * Manages Piu 1/3 attribute
 * @author Claudio Fior <caiofior@gmail.com>
 * @copyright CRA
 */
abstract class Piu1_3 extends \Content implements Attribute {
     /**
     * Instantiates the table
     */
    public function __construct() {
        parent::__construct('piu1_3');
    }

}
