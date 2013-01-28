<?php
namespace forest;
/**
 * @author Claudio Fior <caiofior@gmail.com>
 * @copyright CRA
 * Manages Forest collection
 */
if (!class_exists('Content')) {
    $file = array(basename(__FILE__));
    $PHPUNIT=true;
    require (__DIR__.
                DIRECTORY_SEPARATOR.'..'.
                DIRECTORY_SEPARATOR.'..'.
                DIRECTORY_SEPARATOR.'..'.
                DIRECTORY_SEPARATOR.'include'.
                DIRECTORY_SEPARATOR.'pageboot.php');
}
/**
 * @author Claudio Fior <caiofior@gmail.com>
 * @copyright CRA
 * Manages Forest collection
 */
class ForestColl extends \ContentColl {
    /**
     * User reference
     * @var \User
     */
    private $user;
    /**
     * Filters or not the forest by teh user
     * @var bool
     */
    private $filterByUser=false;
    /**
     * Instantiates the table
     */
    public function __construct() {
        parent::__construct(new Forest());
    }
    /**
     * Customizes the select statement
     * @param Zend_Db_Select $select
     * @return \Zend_Db_Select
     */
    protected function customSelect(\Zend_Db_Select $select,array $criteria ) {
        $select->setIntegrityCheck(false)
        ->from('propriet',array(
            '*',
            'propriet_codice_raw'=>'codice',
            'propriet_objectid_raw'=>'objectid',
            'read_users'=>new \Zend_Db_Expr(
                    '('.
                    $select->getAdapter()->select()->from('user_propriet',
                            new \Zend_Db_Expr('STRING_AGG(CAST("user_propriet"."user_id" AS TEXT),\'|\')')
                            )->where('user_propriet.propriet_codice = propriet.codice').
                    ')'),
            'write_users'=>new \Zend_Db_Expr(
                    '('.
                    $select->getAdapter()->select()->from('user_propriet',
                            new \Zend_Db_Expr('STRING_AGG(CAST("user_propriet"."user_id" AS TEXT),\'|\')')
                            )->where('user_propriet.propriet_codice = propriet.codice AND user_propriet.write=\'1\'').
                    ')')
            ))
        ->join('diz_regioni','diz_regioni.codice = propriet.regione');
        
        if ($this->filterByUser) {
            $select->where(
                    new \Zend_Db_Expr(
                    ' ? IN ('.
                    $select->getAdapter()->select()->from('user_propriet',
                            new \Zend_Db_Expr('"user_propriet"."user_id"')
                            )->where('user_propriet.propriet_codice = propriet.codice').
                    ')')
                    , $this->user->getData('id'));
        }
        
        if (key_exists('search', $criteria) && $criteria['search'] != '') {
            $select->where('descrizion LIKE ?', $criteria['search'].'%');   
        }
        if (key_exists('regione', $criteria) && $criteria['regione'] != '') {
            $select->where('regione = ?', $criteria['regione']); 
        }
        if ($this->user instanceof \User && !$this->filterByUser) {
            $select->order(array(
                    new \Zend_Db_Expr(
                    $this->user->getData('id').' IN ('.
                    $select->getAdapter()->select()->from('user_propriet',
                            new \Zend_Db_Expr('"user_propriet"."user_id"')
                            )->where('user_propriet.propriet_codice = propriet.codice').
                    ') DESC')
                    ,'descrizion')
                    );
        }
        else
            $select->order('descrizion');
        return $select;
    }
     /**
     * Returns all contents without any filter
     */
    public function countAll(array $criteria = null) {
        if ($this->filterByUser || is_array($criteria)) {
            $select = $this->content->getTable()->select()->from($this->content->getTable()->info('name'),'COUNT(*)');
            if (key_exists('search', $criteria))
                $select->where('descrizion LIKE ?', $criteria['search'].'%');
            if ($this->filterByUser)
                $select->where(new \Zend_Db_Expr($this->user->getData('id').' IN ( SELECT "user_id" FROM "user_propriet" WHERE "user_propriet"."propriet_codice" = "propriet"."codice" ) '));
            return intval($this->content->getTable()->getAdapter()->fetchOne($select));
        }
        else 
            parent::countAll();

    }
    /**
     * Return a collection of regions
     * @return \forest\RegionColl
     */
    public function getRegionColl() {
        $regioncoll = new RegionColl();
        $regioncoll->loadAll(array(
            'filter_forest'=>1
        ));
        return $regioncoll;
    }
    /**
     * Set the user forest owner
     * @param \User $user
     */
    public function setUserForests(\User $user) {
       $this->user = $user;
    }
    /**
     * Filters or not the forest by the user
     * @param bool $filtered
     */
    public function setFilterByUser ($filtered) {
        $this->filterByUser = $filtered;
    }
}