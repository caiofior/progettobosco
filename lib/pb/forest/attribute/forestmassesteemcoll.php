<?php
/**
 * Manages Forest Mass Esteem collection
 * 
 * Manages Forest Mass Esteem collection
 * 
 * @author Claudio Fior <caiofior@gmail.com>
 * @copyright CRA
 */
namespace forest\attribute;
use forest\attribute\covercomposition\B1;

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
 * Manages Forest Mass Esteem collection
 * 
 * Manages Forest Mass Esteem collection
 * 
 * @author Claudio Fior <caiofior@gmail.com>
 * @copyright CRA
 */
class ForestMassEsteemColl  extends \ContentColl  {
    /**
     * Forest Reference
     * @var \forest\entity\B1
     */
    protected $form_b1=null;
    /**
     * Instantiates the table
     */
    public function __construct() {
        parent::__construct(new ForestMassEsteem());
    }
    /**
     * Sets the form reference
     * @param \forest\entity\B1 $form Entity b1
     */
    public function setForm(\forest\entity\B1 $form) {

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
        ->from('stime_b1',array(
            '*',
            'cod_colt_descriz'=>new \Zend_Db_Expr(
                '( SELECT diz_arbo.nome_itali || \' | \' || diz_arbo.nome_scien FROM diz_arbo WHERE diz_arbo.cod_coltu=stime_b1.cod_coltu) '
             ),
            'objectid'=>new \Zend_Db_Expr(
                ' replace(\'-\' || proprieta || \'-\' || cod_part || \'-\' || cod_fo || \'-\' || cod_coltu, \' \', \'_\') '
             )
        ));
        if ($this->form_b1 instanceof \forest\entity\B1) {
            $select->where(' cod_part = ? ',$this->form_b1->getData('cod_part'))
            ->where(' proprieta = ? ',$this->form_b1->getData('proprieta'))
            ->where(' cod_fo = ? ',$this->form_b1->getData('cod_fo'));
            
        }
        $select->order('cod_coltu');
        return $select;
    }
     /**
     * Returns all contents without any filter
     * @param array $criteria Filtering criteria
     */
    public function countAll(array $criteria = null) {
            return parent::countAll();

    }
    /**
     * Adds new forest composition 
     * @return B1
     */
    public function addItem() {
        $forestcovercomposition = parent::addItem();
        $forestcovercomposition->setData($this->form_b1->getData('cod_fo'),'cod_fo');
        $forestcovercomposition->setData($this->form_b1->getData('cod_part'),'cod_part');
        $forestcovercomposition->setData($this->form_b1->getData('proprieta'),'proprieta');
        return $forestcovercomposition;
    }
 }
