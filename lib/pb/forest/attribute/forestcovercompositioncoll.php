<?php
/**
 * Manages Forest Cover Composition collection
 * 
 * Manages Forest Cover Composition collection
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
 * Manages Forest Cover Composition collection
 * 
 * Manages Forest Cover Composition collection
 * 
 * @author Claudio Fior <caiofior@gmail.com>
 * @copyright CRA
 */
class ForestCoverCompositionColl  extends \ContentColl  {
    /**
     * Forest Reference
     * @var \forest\form\B1
     */
    protected $form_b1=null;
    /**
     * Instantiates the table
     */
    public function __construct() {
        parent::__construct(new ForestCoverComposition());
    }
    /**
     * Sets the form reference
     * @param \forest\form\B1 $form Form b1
     */
    public function setForm(\forest\form\B1 $form) {

        $this->form_b1 = $form;
    }
     /**
     * Customizes the select statement
     * @param \Zend_Db_Select $select
     * @param array $criteria Filtering criteria
     * @return \Zend_Db_Select
     */
    protected function customSelect(\Zend_Db_Select $select,array $criteria ) {
        $select->setIntegrityCheck(false)
        ->from('arboree',array(
            '*',
            'cod_colt_descriz'=>new \Zend_Db_Expr(
                '( SELECT diz_arbo.nome_itali || \' | \' || diz_arbo.nome_scien FROM diz_arbo WHERE diz_arbo.cod_coltu=arboree.cod_coltu) '
             ),
            'cod_coper_descriz'=>new \Zend_Db_Expr(
                '( SELECT per_arbo.descriz FROM per_arbo WHERE per_arbo.codice=arboree.cod_coper) '
             )
        ));
        if ($this->form_b1 instanceof \forest\form\B1) {
            $select->where(' cod_part = ? ',$this->form_b1->getData('cod_part'))
            ->where(' proprieta = ? ',$this->form_b1->getData('proprieta'))
            ->where(' cod_fo = ? ',$this->form_b1->getData('cod_fo'));
            
        }
        if (key_exists('search', $criteria) && $criteria['search'] != '') {
            $select->where(' particella LIKE ? OR foglio LIKE ?', '%'.$criteria['search'].'%');   
        }
        $select->order('ordine_inser')->order('cod_coltu');
        return $select;
    }
     /**
     * Returns all contents without any filter
     * @param array $criteria Filtering criteria
     */
    public function countAll(array $criteria = null) {
        if ($this->form_b1 instanceof \forest\form\B1) {
            $select = $this->content->getTable()->select()->from($this->content->getTable()->info('name'),'COUNT(*)');
            $select->where(' cod_part = ? ',$this->form_b1->getData('cod_part'))
            ->where(' proprieta = ? ',$this->form_b1->getData('proprieta'))
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
