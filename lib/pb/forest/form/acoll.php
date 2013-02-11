<?php
namespace forest\form;
/**
 * @author Claudio Fior <caiofior@gmail.com>
 * @copyright CRA
 * Manages Form A forest compartment
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
 * SELECT 
 * SCHEDE_A.PROPRIETA,
 * SCHEDE_A.COD_PART, 
 * SCHEDE_A.TOPONIMO, 
 * IIf(IsNull([U]),"",IIf(Val([U])=1,"B1",IIf(Val([U])=13,"B4",IIf(Val([U])=2 Or Val([U])>=10,"B2","B3")))) & "-" & [usosuolo]![descriz] AS scheda,
 * SCHEDE_A.CODIOPE
 * FROM SCHEDE_A 
 * LEFT JOIN (SCHEDE_B LEFT JOIN USOSUOLO ON SCHEDE_B.U = USOSUOLO.CODICE) ON (SCHEDE_A.COD_PART = SCHEDE_B.COD_PART) AND (SCHEDE_A.PROPRIETA = SCHEDE_B.PROPRIETA)
 * WHERE (((SCHEDE_A.PROPRIETA)=[forms].[a_maschera1].[prop_scelta]))
 * ORDER BY SCHEDE_A.PROPRIETA, SCHEDE_A.COD_PART, SCHEDE_A.TOPONIMO;
 * 
 * Manages Form A forest compartment
 */
class AColl extends \forest\form\template\FormColl {
    /**
     * Forest object
     * @var \forest\Forest
     */
    private $forest;
    /**
     * Instantiates the table
     */
    public function __construct() {
        parent::__construct(new A());
    }
     /**
     * Customizes the select statement
     * @param Zend_Db_Select $select
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
            parent::countAll();

    }
    /**
     * Adds new item to the form
     * @return \forest\form\A
     */
    public function addItem() {
        $a = parent::addItem();
        $a->setData($this->forest->getData('codice'),'proprieta');
        return $a;
    }

}
