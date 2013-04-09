<?php
/**
 * Manages Entity D forest compartment Collection
 * 
 * Manages Entity D forest compartment Collection
 * 
 * @author Claudio Fior <caiofior@gmail.com>
 * @copyright CRA
 */
namespace forest\entity\x;
if (!class_exists('Content')) {
    $file = 'form'.DIRECTORY_SEPARATOR.array(basename(__FILE__));
    $PHPUNIT=true;
    require (__DIR__.
                DIRECTORY_SEPARATOR.'..'.
                DIRECTORY_SEPARATOR.'..'.
                DIRECTORY_SEPARATOR.'..'.
                DIRECTORY_SEPARATOR.'..'.
                DIRECTORY_SEPARATOR.'..'.
                DIRECTORY_SEPARATOR.'include'.
                DIRECTORY_SEPARATOR.'pageboot.php');
}
/**
 * Manages Entity D forest compartment Collection
 * 
 * Manages Entity D forest compartment Collection
 * 
 * @author Claudio Fior <caiofior@gmail.com>
 * @copyright CRA
 */
class DColl extends \forest\template\EntityColl {
    /**
     * Reference to the X form
     * @var \forest\entity\x\X
     */
    private $x;
    /**
     * Instantiates the table
     */
    public function __construct() {
        parent::__construct(new \forest\entity\x\D());
    }
    /**
     * Set the form X
     * @param \forest\entity\x\X $x
     */
    public function setFormX(\forest\entity\x\X $x) {
        $this->x = $x;
    }
     /**
     * Customizes the select statement
     * @param \Zend_Db_Select $select
     * @param array $criteria Filtering criteria
     * @return \Zend_Db_Select
     */
    protected function customSelect(\Zend_Db_Select $select,array $criteria ) {
        $select->setIntegrityCheck(false);
        if ($this->x instanceof \forest\entity\x\X) {
            $select->where('schede_d.proprieta = ?', $this->x->getData('proprieta'))
                   ->where('schede_d.cod_part = ?', $this->x->getData('cod_part'))
                   ->where('schede_d.cod_fo = ?', $this->x->getData('cod_fo'));
        }
        return $select;
    }
     /**
     * Returns all contents without any filter
     * @param null|array $criteria Filtering criteria
     */
    public function countAll(array $criteria = null) {
        if ($this->x instanceof \forest\entity\x\X)  {
            $select = $this->content->getTable()->select()->from($this->content->getTable()->info('name'),'COUNT(*)');
            $select->where('schede_d.proprieta = ?', $this->x->getData('proprieta'))
                   ->where('schede_d.cod_part = ?', $this->x->getData('cod_part'))
                   ->where('schede_d.cod_fo = ?', $this->x->getData('cod_fo'));
            return intval($this->content->getTable()->getAdapter()->fetchOne($select));
        }
        else
            return parent::countAll();
    }
    /**
     * Add new item to the collection
     * @return \forest\entity\x\X
     */
    public function addItem() {
        $d = parent::addItem();
        $d->setData($this->x->getData('proprieta'),'proprieta');
        $d->setData($this->x->getData('cod_part'),'cod_part');
        $d->setData($this->x->getData('cod_fo'),'cod_fo');
        return $d;
    }

}
