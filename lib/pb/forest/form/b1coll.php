<?php
/**
 * Manages Form B1 forest compartment collection
 * 
 * Manages Form B1 forest compartment collection
 * 
 * @author Claudio Fior <caiofior@gmail.com>
 * @copyright CRA
 */
namespace forest\form;
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
 * Manages Form B1 forest compartment collection
 * 
 * Manages Form B1 forest compartment collection
 * 
 * @author Claudio Fior <caiofior@gmail.com>
 * @copyright CRA
 */
class B1Coll extends \forest\form\template\FormColl {
     /**
     * Reference to form B
     * @var \forest\form\B
     */
    private $b;
    /**
     * Instantiates the table
     */
    public function __construct() {
        parent::__construct(new B1());
    }
     /**
     * Customizes the select statement
     * @param \Zend_Db_Select $select
     * @param array $criteria Filtering criteria
     * @return \Zend_Db_Select
     */
    protected function customSelect(\Zend_Db_Select $select,array $criteria ) {
        $select->setIntegrityCheck(false);
        if ($this->b instanceof \forest\form\B) {
            $select->where('sched_b1.proprieta = ?', $this->b->getData('proprieta'))
                   ->where('sched_b1.cod_part = ?', $this->b->getData('cod_part'))
                   ->where('sched_b1.cod_fo = ?', $this->b->getData('cod_fo'));
        }
        return $select;
    }
    /**
     * Set the form a
     * @param \forest\form\B $b
     */
    public function setFormB(\forest\form\B $b) {
        $this->b = $b;
    }
     /**
     * Returns all contents without any filter
     * @param null|array $criteria Filtering criteria
     */
    public function countAll(array $criteria = null) {
            parent::countAll();

    }
    /**
     * Add new item to the collection
     * @return \forest\form\B1
     */
    public function addItem() {
        $b1 = parent::addItem();
        $b1->setData($this->forest->getData('codice'),'proprieta');
        return $b1;
    }

}
