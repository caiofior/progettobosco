<?php
/**
 * Manages Note B collection
 * 
 * Manages Note B collection
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
 * Manages Note B collection
 * 
 * Manages Note B collection
 * 
 * @author Claudio Fior <caiofior@gmail.com>
 * @copyright CRA
 */
class NoteBColl  extends \ContentColl  {
    /**
     * Form B1 Reference
     * @var \forest\form\B1 
     */
    protected $form_b1=null;
    /**
     * Instantiates the table
     */
    public function __construct() {
        parent::__construct(new NoteB());
    }
    /**
     * Sets the form reference
     * @param \forest\form\B1 $form
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
        ->from($this->content->getTable()->info('name'),array(
            '*',
            'nota_descr'=>new \Zend_Db_Expr(
                    '('.
                    $select->getAdapter()->select()->from('leg_note',
                            'intesta'
                            )->where('leg_note.nomecampo = note_b.cod_nota').
                    ')')
            ,
            'nota_objectid'=>new \Zend_Db_Expr(
                    '('.
                    $select->getAdapter()->select()->from('leg_note',
                            'objectid'
                            )->where('leg_note.nomecampo = note_b.cod_nota').
                    ')')
            )   
            );
        if ($this->form_b1 instanceof \forest\form\B1) {
            $select->where(' cod_part = ? ',$this->form_b1->getData('cod_part'))
            ->where(' proprieta = ? ',$this->form_b1->getData('proprieta'))
            ->where(' cod_fo = ? ',$this->form_b1->getData('cod_fo'))
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
     * Adds new note to form a
     * @return NoteA
     */
    public function addItem() {
        $note = parent::addItem();
        $note->setData($this->form_b1->getData('cod_part'),'cod_part');
        $note->setData($this->form_b1->getData('proprieta'),'proprieta');
        $note->setData($this->form_b1->getData('cod_fo'),'cod_fo');
        return $note;
    }
}
