<?php
/**
 * Manages B4 Shrub Composition collection
 * 
 * Manages B4 Shrub Composition collection
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
 * Manages B4 Shrub Composition collection
 * 
 * Manages B4 Shrub Composition collection
 * 
 * @author Claudio Fior <caiofior@gmail.com>
 * @copyright CRA
 */
class B4ShrubCompositionColl  extends \ContentColl  {
    /**
     * Forest Reference
     * @var \forest\form\B4
     */
    protected $form_b4=null;
    /**
     * Instantiates the table
     */
    public function __construct() {
        parent::__construct(new B4ShrubComposition());
    }
    /**
     * Sets the form reference
     * @param \forest\form\B4 $form Form b4
     */
    public function setForm(\forest\form\B4 $form) {

        $this->form_b4 = $form;
    }
     /**
     * Customizes the select statement
     * @param \Zend_Db_Select $select
     * @param array $criteria Filtering criteria
     * @return \Zend_Db_Select
     */
    protected function customSelect(\Zend_Db_Select $select,array $criteria ) {
        $select->setIntegrityCheck(false)
        ->from('arboree4a',array(
            '*',
            'cod_colt_descriz'=>new \Zend_Db_Expr(
                '( SELECT diz_arbo.nome_itali || \' | \' || diz_arbo.nome_scien FROM diz_arbo WHERE diz_arbo.cod_coltu=arboree4a.cod_coltu) '
             )
        ));
        if ($this->form_b4 instanceof \forest\form\B4) {
            $select->where(' cod_part = ? ',$this->form_b4->getData('cod_part'))
            ->where(' proprieta = ? ',$this->form_b4->getData('proprieta'))
            ->where(' cod_fo = ? ',$this->form_b4->getData('cod_fo'));
            
        }
        $select->order('cod_coltu');
        return $select;
    }
     /**
     * Returns all contents without any filter
     * @param array $criteria Filtering criteria
     */
    public function countAll(array $criteria = null) {
        if ($this->form_b4 instanceof \forest\form\B4) {
            $select = $this->content->getTable()->select()->from($this->content->getTable()->info('name'),'COUNT(*)');
            $select->where(' cod_part = ? ',$this->form_b4->getData('cod_part'))
            ->where(' proprieta = ? ',$this->form_b4->getData('proprieta'))
            ->where(' cod_fo = ? ',$this->form_b4->getData('cod_fo'))
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
        $forestcovercomposition->setData($this->form_b4->getData('cod_fo'),'cod_fo');
        $forestcovercomposition->setData($this->form_b4->getData('cod_part'),'cod_part');
        $forestcovercomposition->setData($this->form_b4->getData('proprieta'),'proprieta');
        return $forestcovercomposition;
    }
 }
