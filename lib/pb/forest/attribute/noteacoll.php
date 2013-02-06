<?php
namespace forest\attribute;
/**
 * @author Claudio Fior <caiofior@gmail.com>
 * @copyright CRA
 * Manages Note collection
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
 * Manages Note collection
 */
class NoteAColl  extends \ContentColl  {
    /**
     * Forest Reference
     * @var \forest\Forest 
     */
    protected $form_a=null;
    /**
     * Instantiates the table
     */
    public function __construct() {
        parent::__construct(new NoteA());
    }
    /**
     * Sets the forest reference
     * @param \forest\Forest $forest
     */
    public function setForm(\forest\form\A $form) {

        $this->form_a = $form;
    }
    /**
     * Customizes the select statement
     * @param Zend_Db_Select $select
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
                            )->where('leg_note.nomecampo = note_a.cod_nota').
                    ')')
            ,
            'nota_objectid'=>new \Zend_Db_Expr(
                    '('.
                    $select->getAdapter()->select()->from('leg_note',
                            'objectid'
                            )->where('leg_note.nomecampo = note_a.cod_nota').
                    ')')
            )   
            );
        if ($this->form_a instanceof \forest\form\A) {
            $select->where(' cod_part = ? ',$this->form_a->getData('cod_part'))
            ->where(' proprieta = ? ',$this->form_a->getData('proprieta'));
        }
        $select->order('cod_nota');
        return $select;
    }
     /**
     * Returns all contents without any filter
     */
    public function countAll(array $criteria = null) {
        if ($this->form_a instanceof \forest\form\A) {
            $select = $this->content->getTable()->select()->from($this->content->getTable()->info('name'),'COUNT(*)');
            $select->where(' cod_part = ? ',$this->form_a->getData('cod_part'))
            ->where(' proprieta = ? ',$this->form_a->getData('proprieta'));
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
        $note->setData($this->form_a->getData('cod_part'),'cod_part');
        $note->setData($this->form_a->getData('proprieta'),'proprieta');
        return $note;
    }
}
