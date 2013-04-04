<?php
/**
 * Manages Entity A forest compartment
 * 
 * Manages Entity A forest compartment
 * 
 * @author Claudio Fior <caiofior@gmail.com>
 * @copyright CRA
 */
namespace forest\entity;
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
 * Manages Entity A forest compartment
 * 
 * Manages Entity A forest compartment
 * 
 * @author Claudio Fior <caiofior@gmail.com>
 * @copyright CRA
 */
class AColl extends \forest\template\EntityColl {
    /**
     * Forest object
     * @var \forest\Forest
     */
    private $forest;
    /**
     * Instantiates the table
     */
    public function __construct() {
        parent::__construct(new \forest\entity\A());
    }
     /**
     * Customizes the select statement
     * @param \Zend_Db_Select $select
     * @param array $criteria Filtering criteria
     * @return \Zend_Db_Select
     */
    protected function customSelect(\Zend_Db_Select $select,array $criteria ) {
        $select->setIntegrityCheck(false)
        ->from('schede_a', array(
            '*',
            'usosuolo' =>new \Zend_Db_Expr('( SELECT usosuolo.descriz FROM usosuolo 
            LEFT JOIN schede_b ON schede_b.u=usosuolo.codice
            WHERE schede_b.proprieta=schede_a.proprieta AND schede_b.cod_part=schede_a.cod_part)'),
            'rilevato' => new \Zend_Db_Expr(' (SELECT rilevato.descriz FROM rilevato
             WHERE rilevato.codice=schede_a.codiope) ')
            )
        )
        ;
        if (key_exists('usosuolo', $criteria) && $criteria['usosuolo'] != '') {
           $select->where(new \Zend_Db_Expr('(SELECT schede_b.u FROM schede_b  WHERE schede_b.proprieta=schede_a.proprieta AND schede_b.cod_part=schede_a.cod_part) = \''.$criteria['usosuolo'].'\''));
        }
        if (key_exists('codiope', $criteria) && $criteria['codiope'] != '') {
            $select->where('schede_a.codiope = ? ',$criteria['codiope']);
        }
        if (key_exists('search', $criteria) && $criteria['search'] != '') {
            $select->where('(schede_a.cod_part LIKE ? OR schede_a.toponimo  LIKE ? )','%'.$criteria['search'].'%');
        }
        if ($this->forest instanceof \forest\Forest) {
            $select->where('schede_a.proprieta = ?', $this->forest->getData('codice'));
        }
        $select->order('schede_a.cod_part');
        return $select;
    }
    /**
     * Sets forest compartment forest
     * @param \forest\Forest $forest
     */
    public function setForest(\forest\Forest $forest) {
        $this->forest = $forest;
    }
    /**
     * Returns all contents without any filter
     * @param null|array $criteria Filtering criteria
     */
    public function countAll(array $criteria = null) {
        if ($this->forest instanceof \forest\Forest || is_array($criteria)) {
            $select = $this->content->getTable()->select()->from($this->content->getTable()->info('name'),'COUNT(*)');
             if (key_exists('usosuolo', $criteria) && $criteria['usosuolo'] != '') {
                $select->where(new \Zend_Db_Expr('(SELECT schede_b.u FROM schede_b  WHERE schede_b.proprieta=schede_a.proprieta AND schede_b.cod_part=schede_a.cod_part) = \''.$criteria['usosuolo'].'\''));
             }
             if (key_exists('codiope', $criteria) && $criteria['codiope'] != '') {
                 $select->where('schede_a.codiope = ? ',$criteria['codiope']);
             }
             if (key_exists('search', $criteria) && $criteria['search'] != '') {
                 $select->where('(schede_a.cod_part LIKE ? OR schede_a.toponimo  LIKE ? )','%'.$criteria['search'].'%');
             }
             if ($this->forest instanceof \forest\Forest) {
                 $select->where('schede_a.proprieta = ?', $this->forest->getData('codice'));
             }
            return intval($this->content->getTable()->getAdapter()->fetchOne($select));
        }
        else 
            return parent::countAll();

    }
     /**
     * Adds new item to the form
     * @return \forest\entity\A
     */
    public function addItem() {
        $a = parent::addItem();
        $a->setData($this->forest->getData('codice'),'proprieta');
        return $a;
    }

}
