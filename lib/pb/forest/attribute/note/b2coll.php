<?php
/**
 * Manages Note B2 collection
 * 
 * Manages Note B2 collection
 * 
 * @author Claudio Fior <caiofior@gmail.com>
 * @copyright CRA
 */
namespace forest\attribute\note;

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
 * Manages Note B2 collection
 * 
 * Manages Note B2 collection
 * 
 * @author Claudio Fior <caiofior@gmail.com>
 * @copyright CRA
 */
class B2Coll  extends \ContentColl  {
    /**
     * Entity B2 Reference
     * @var \forest\form\B2 
     */
    protected $form_b2=null;
    /**
     * Instantiates the table
     */
    public function __construct() {
        parent::__construct(new \forest\attribute\note\B2());
    }
    /**
     * Sets the form reference
     * @param \forest\form\B2 $form
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
        ->from($this->content->getTable()->info('name'),array(
            '*',
            'nota_descr'=>new \Zend_Db_Expr(
                    '('.
                    $select->getAdapter()->select()->from('leg_note',
                            'intesta'
                            )->where('leg_note.nomecampo = note_b2.cod_nota').
                    ')')
            ,
            'nota_objectid'=>new \Zend_Db_Expr(
                    '('.
                    $select->getAdapter()->select()->from('leg_note',
                            'objectid'
                            )->where('leg_note.nomecampo = note_b2.cod_nota').
                    ')')
            )   
            );
        if ($this->form_b2 instanceof \forest\form\B2) {
            $select->where(' cod_part = ? ',$this->form_b2->getData('cod_part'))
            ->where(' proprieta = ? ',$this->form_b2->getData('proprieta'))
            ->where(' cod_fo = ? ',$this->form_b2->getData('cod_fo'))
            ;
        }
        $select->order('cod_nota');
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
            return parent::countAll();

    }
    /**
     * Adds new note to form a
     * @return A
     */
    public function addItem() {
        $note = parent::addItem();
        $note->setData($this->form_b2->getData('cod_part'),'cod_part');
        $note->setData($this->form_b2->getData('proprieta'),'proprieta');
        $note->setData($this->form_b2->getData('cod_fo'),'cod_fo');
        return $note;
    }
}
