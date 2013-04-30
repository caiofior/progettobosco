<?php
/**
 * Manages Compresa
 * 
 * Manages Compresa
 * 
 * @link https://it.wikipedia.org/wiki/Comprese
 * 
 * @author Claudio Fior <caiofior@gmail.com>
 * @copyright CRA
 */
namespace forest;


if (!class_exists('Content')) {
    $file = 'form'.DIRECTORY_SEPARATOR.array(basename(__FILE__));
    $PHPUNIT=true;
    require (__DIR__.
                DIRECTORY_SEPARATOR.'..'.
                DIRECTORY_SEPARATOR.'..'.
                DIRECTORY_SEPARATOR.'..'.
                DIRECTORY_SEPARATOR.'include'.
                DIRECTORY_SEPARATOR.'pageboot.php');
}
/**
 * Manages Compresa
 * 
 * Manages Compresa
 * 
 * @link https://it.wikipedia.org/wiki/Comprese
 * 
 * @author Claudio Fior <caiofior@gmail.com>
 * @copyright CRA
 */
class Compresa extends \forest\template\Entity {
     /**
     * Instantiates the table
     */
    public function __construct() {
        parent::__construct('compresa');
    }
    /**
     * Loads form a data
     * @param integer $id
     */
    public function loadFromId($id) {
        parent::loadFromId($id);
        $this->calculatedVariables();
    }
    /**
     * Return the forest associate with a form
     * @return \forest\Forest
     */
    public function getForest() {
        $bosco = new \forest\Forest();
        $bosco->loadFromCode($this->data['proprieta']);
        return $bosco;
    }
    /**
     * Sets the calculated variables
     */
    private function calculatedVariables () {
        
    }
    
} 
