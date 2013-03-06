<?php
/**
 * Manages Cork Cover Composition collection
 * 
 * Manages Cork Cover Composition collection
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
 * Manages Cork Cover Composition collection
 * 
 * Manages Cork Cover Composition collection
 * 
 * @author Claudio Fior <caiofior@gmail.com>
 * @copyright CRA
 */
class CorkCoverCompositionColl  extends \ContentColl  {
    /**
     * Forest Reference
     * @var \forest\form\B2
     */
    protected $form_b2=null;
    /**
     * Instantiates the table
     */
    public function __construct() {
        parent::__construct(new CorkCoverComposition());
    }
    /**
     * Sets the form reference
     * @param \forest\form\B2 $form Form b1
     */
    public function setForm(\forest\form\B2 $form) {

        $this->form_b2 = $form;
    }
     /**
     * Customizes the select statement
     * @param \Zend_Db_Select $select
     * @param array $criteria Filtering criteria
     * @return \Zend_Db_Select
     */
    protected function customSelect(\Zend_Db_Select $select,array $criteria ) {
        $select->setIntegrityCheck(false)
        ->from('arboree2',array(
            '*',
            'cod_colt_descriz'=>new \Zend_Db_Expr(
                '( SELECT diz_arbo.nome_itali || \' | \' || diz_arbo.nome_scien FROM diz_arbo WHERE diz_arbo.cod_coltu=arboree2.cod_coltu) '
             )
        ));
        if ($this->form_b2 instanceof \forest\form\B2) {
            $select->where(' cod_part = ? ',$this->form_b2->getData('cod_part'))
            ->where(' proprieta = ? ',$this->form_b2->getData('proprieta'))
            ->where(' cod_fo = ? ',$this->form_b2->getData('cod_fo'));
        }
        $select->order('ordine_inser')->order('cod_coltu');
        return $select;
    }
     /**
     * Returns all contents without any filter
     * @param array $criteria Filtering criteria
     */
    public function countAll(array $criteria = null) {
        if ($this->form_b2 instanceof \forest\form\B2) {
            $select = $this->content->getTable()->select()->from($this->content->getTable()->info('name'),'COUNT(*)');
            $select->where(' cod_part = ? ',$this->form_b2->getData('cod_part'))
            ->where(' proprieta = ? ',$this->form_b2->getData('proprieta'))
            ->where(' cod_fo = ? ',$this->form_b2->getData('cod_fo'))
            ;
            return intval($this->content->getTable()->getAdapter()->fetchOne($select));
        }
        else 
            parent::countAll();

    }
    /**
     * Adds new forest composition 
     * @return ForestCoverComposition
     */
    public function addItem() {
        $forestcovercomposition = parent::addItem();
        $forestcovercomposition->setData($this->form_b2->getData('cod_fo'),'cod_fo');
        $forestcovercomposition->setData($this->form_b2->getData('cod_part'),'cod_part');
        $forestcovercomposition->setData($this->form_b2->getData('proprieta'),'proprieta');
        return $forestcovercomposition;
    }
 }
