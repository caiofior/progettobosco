<?php
/**
 * Manages Cadastral collection
 * 
 * Manages Cadastral collection
 * 
 * @author Claudio Fior <caiofior@gmail.com>
 * @copyright CRA
 */
namespace forest\attribute;
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
 * Manages Cadastral collection
 * 
 * Manages Cadastral collection
 * 
 * @author Claudio Fior <caiofior@gmail.com>
 * @copyright CRA
 */
class CadastralColl  extends \ContentColl  {
    /**
     * Forest Reference
     * @var \forest\form\A 
     */
    protected $form_a=null;
    /**
     * Instantiates the table
     */
    public function __construct() {
        parent::__construct(new Cadastral());
    }
    /**
     * Sets the form reference
     * @param \forest\form\A $form Form a
     */
    public function setForm(\forest\form\A $form) {

        $this->form_a = $form;
    }
     /**
     * Customizes the select statement
     * @param \Zend_Db_Select $select
     * @param array $criteria Filtering criteria
     * @return \Zend_Db_Select
     */
    protected function customSelect(\Zend_Db_Select $select,array $criteria ) {
        $select->setIntegrityCheck(false)
        ->from($this->content->getTable()->info('name'));
        if ($this->form_a instanceof \forest\form\A) {
            $select->where(' cod_part = ? ',$this->form_a->getData('cod_part'))
            ->where(' proprieta = ? ',$this->form_a->getData('proprieta'))
            ->where(' cod_fo = ? ',$this->form_b1->getData('cod_fo'))
            ;
            
        }
        if (key_exists('search', $criteria) && $criteria['search'] != '') {
            $select->where(' particella LIKE ? OR foglio LIKE ?', '%'.$criteria['search'].'%');   
        }
        $select->order('foglio')->order('particella');
        return $select;
    }
     /**
     * Returns all contents without any filter
     * @param array $criteria Filtering criteria
     */
    public function countAll(array $criteria = null) {
        if ($this->form_a instanceof \forest\form\A) {
            $select = $this->content->getTable()->select()->from($this->content->getTable()->info('name'),'COUNT(*)');
            $select->where(' cod_part = ? ',$this->form_a->getData('cod_part'))
            ->where(' proprieta = ? ',$this->form_a->getData('proprieta'))
            ->where(' cod_fo = ? ',$this->form_b1->getData('cod_fo'))
            ;
            return intval($this->content->getTable()->getAdapter()->fetchOne($select));
        }
        else 
            parent::countAll();

    }
    /**
     * Adds new cadastra to form a
     * @return Cadastral
     */
    public function addItem() {
        $cadastral = parent::addItem();
        $cadastral->setData($this->form_a->getData('cod_part'),'cod_part');
        $cadastral->setData($this->form_a->getData('proprieta'),'proprieta');
        $cadastral->setData(0,'foglio');
        $cadastral->setData(0,'particella');
        return $cadastral;
    }
    /**
     * Returns a cummary of cadastral data
     * @return array
     */
    public function getSummary() {
         $select = $this->content->getTable()->select()
                 ->from($this->content->getTable()->info('name'),array(
                     'sum_sup_tot_cat'=>'SUM(sup_tot_cat)',
                     'sum_sup_tot'=>'SUM(sup_tot)',
                     'sum_sup_bosc'=>'SUM(sup_bosc)'
                     ));
         if ($this->form_a instanceof \forest\form\A) {
            $select->where(' cod_part = ? ',$this->form_a->getData('cod_part'))
            ->where(' proprieta = ? ',$this->form_a->getData('proprieta'));
        }
        return $this->content->getTable()->getAdapter()->fetchRow($select);
        
    }
}
