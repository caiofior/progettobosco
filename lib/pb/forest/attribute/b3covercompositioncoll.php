<?php
/**
 * Manages B3 Cover Composition collection
 * 
 * Manages B3 Cover Composition collection
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
 * Manages B3 Cover Composition collection
 * 
 * Manages B3 Cover Composition collection
 * 
 * @author Claudio Fior <caiofior@gmail.com>
 * @copyright CRA
 */
class B3CoverCompositionColl  extends \ContentColl  {
    /**
     * Forest Reference
     * @var \forest\form\B3
     */
    protected $form_b3=null;
    /**
     * Instantiates the table
     */
    public function __construct() {
        parent::__construct(new B3CoverComposition());
    }
    /**
     * Sets the form reference
     * @param \forest\form\B3 $form Form b3
     */
    public function setForm(\forest\form\B3 $form) {

        $this->form_b3 = $form;
    }
     /**
     * Customizes the select statement
     * @param \Zend_Db_Select $select
     * @param array $criteria Filtering criteria
     * @return \Zend_Db_Select
     */
    protected function customSelect(\Zend_Db_Select $select,array $criteria ) {
        $select->setIntegrityCheck(false)
        ->from('comp_arb',array(
            '*',
            'cod_colt_descriz'=>new \Zend_Db_Expr(
                '( SELECT diz_arbo.nome_itali || \' | \' || diz_arbo.nome_scien FROM diz_arbo WHERE diz_arbo.cod_coltu=comp_arb.cod_coltu) '
             )
        ));
        if ($this->form_b3 instanceof \forest\form\B3) {
            $select->where(' cod_part = ? ',$this->form_b3->getData('cod_part'))
            ->where(' proprieta = ? ',$this->form_b3->getData('proprieta'))
            ->where(' cod_fo = ? ',$this->form_b3->getData('cod_fo'));
        }
        $select->order('cod_coltu');
        return $select;
    }
     /**
     * Returns all contents without any filter
     * @param array $criteria Filtering criteria
     */
    public function countAll(array $criteria = null) {
        if ($this->form_b3 instanceof \forest\form\B3) {
            $select = $this->content->getTable()->select()->from($this->content->getTable()->info('name'),'COUNT(*)');
            $select->where(' cod_part = ? ',$this->form_b3->getData('cod_part'))
            ->where(' proprieta = ? ',$this->form_b3->getData('proprieta'))
            ->where(' cod_fo = ? ',$this->form_b3->getData('cod_fo'))
            ;
            return intval($this->content->getTable()->getAdapter()->fetchOne($select));
        }
        else 
            return parent::countAll();

    }
    /**
     * Adds new forest composition 
     * @return B1CoverComposition
     */
    public function addItem() {
        $forestcovercomposition = parent::addItem();
        $forestcovercomposition->setData($this->form_b3->getData('cod_fo'),'cod_fo');
        $forestcovercomposition->setData($this->form_b3->getData('cod_part'),'cod_part');
        $forestcovercomposition->setData($this->form_b3->getData('proprieta'),'proprieta');
        return $forestcovercomposition;
    }
 }
