<?php
namespace forest\form;
/**
 * @author Claudio Fior <caiofior@gmail.com>
 * @copyright CRA
 * Manages Form B forest compartment
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
 * Manages Form B forest compartment
 */
class BColl extends \forest\form\template\FormColl {
    /**
     * Reference to the A form
     * @var \forest\form\A
     */
    private $a;
    /**
     * Instantiates the table
     */
    public function __construct() {
        parent::__construct(new B());
    }
    /**
     * Set the form a
     * @param \forest\form\A $a
     */
    public function setFormA(\forest\form\A $a) {
        $this->a = $a;
    }
     /**
     * Customizes the select statement
     * @param Zend_Db_Select $select
     * @return \Zend_Db_Select
     */
    protected function customSelect(\Zend_Db_Select $select,array $criteria ) {
        $select->setIntegrityCheck(false);
        if ($this->a instanceof \forest\form\A) {
            $select->where('schede_b.proprieta = ?', $this->a->getData('proprieta'))
                   ->where('schede_b.cod_part = ?', $this->a->getData('cod_part'))
                   ->where('schede_b.cod_fo = ?', $this->a->getData('cod_fo'));
        }
        return $select;
    }
     /**
     * Returns all contents without any filter
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
