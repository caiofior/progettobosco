<?php
/**
 * Manages Entity B3 forest compartment collection
 * 
 * Manages Entity B3 forest compartment collection
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
 * Manages Entity B3 forest compartment collection
 * 
 * Manages Entity B3 forest compartment collection
 * 
 * @author Claudio Fior <caiofior@gmail.com>
 * @copyright CRA
 */
class B3Coll extends \forest\template\EntityColl {
     /**
     * Reference to form B
     * @var \forest\form\B
     */
    private $b;
    /**
     * Instantiates the table
     */
    public function __construct() {
        parent::__construct(new B3());
    }
     /**
     * Customizes the select statement
     * @param \Zend_Db_Select $select
     * @param array $criteria Filtering criteria
     * @return \Zend_Db_Select
     */
    protected function customSelect(\Zend_Db_Select $select,array $criteria ) {
        $select->setIntegrityCheck(false)->from('sched_b3', array(
            '*'
        ));
        if ($this->b instanceof \forest\form\B) {
            $select->where('sched_b3.proprieta = ?', $this->b->getData('proprieta'))
                   ->where('sched_b3.cod_part = ?', $this->b->getData('cod_part'))
                   ->where('sched_b3.cod_fo = ?', $this->b->getData('cod_fo'));
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
            if ($this->b instanceof \forest\form\B) {
                $select = $this->content->getTable()->select()->from($this->content->getTable()->info('name'),'COUNT(*)');
                $select->where('sched_b3.proprieta = ?', $this->b->getData('proprieta'))
                       ->where('sched_b3.cod_part = ?', $this->b->getData('cod_part'))
                       ->where('sched_b3.cod_fo = ?', $this->b->getData('cod_fo'));
                return intval($this->content->getTable()->getAdapter()->fetchOne($select));
            }
            else
                return parent::countAll();

    }
    /**
     * Add new item to the collection
     * @return \forest\form\B3
     */
    public function addItem() {
        $b3 = parent::addItem();
        $b3->setData($this->b->getData('proprieta'),'proprieta');
        $b3->setData($this->b->getData('cod_part'),'cod_part');
        $b3->setData($this->b->getData('cod_fo'),'cod_fo');
        return $b3;
    }

}
