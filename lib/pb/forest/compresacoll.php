<?php
/**
 * Manages Compresa collection
 * 
 * Manages Compresa collection
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
 * Manages Compresa collection
 * 
 * Manages Compresa collection
 * 
 * @author Claudio Fior <caiofior@gmail.com>
 * @copyright CRA
 */
class CompresaColl extends \forest\template\EntityColl {
    /**
     * Forest object
     * @var \forest\Forest
     */
    private $forest;
    /**
     * Instantiates the table
     */
    public function __construct() {
        parent::__construct(new \forest\Compresa());
    }
     /**
     * Customizes the select statement
     * @param \Zend_Db_Select $select
     * @param array $criteria Filtering criteria
     * @return \Zend_Db_Select
     */
    protected function customSelect(\Zend_Db_Select $select,array $criteria ) {
        if ($this->forest instanceof \forest\Forest) {
            $select->where('compresa.proprieta = ?', $this->forest->getData('codice'));
        }
        return $select;
    }
    /**
     * Sets forest compartment forest
     * @param \forest\Forest $forest
     */
    public function setForest(\forest\Forest $forest) {
        $this->forest = $forest;
    }
    /**
     * Returns all contents without any filter
     * @param null|array $criteria Filtering criteria
     */
    public function countAll(array $criteria = null) {
            return parent::countAll();

    }
     /**
     * Adds new item to the form
     * @return \forest\Compresa
     */
    public function addItem() {
        $compresa = parent::addItem();
        $compresa->setData($this->forest->getData('codice'),'proprieta');
        return $compresa;
    }

}
