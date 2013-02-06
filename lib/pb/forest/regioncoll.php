<?php
namespace forest;
/**
 * @author Claudio Fior <caiofior@gmail.com>
 * @copyright CRA
 * Manages Region collection
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
 * Manages Region collection
 */
class RegionColl extends \ContentColl {
    /**
     * Instantiates the table
     */
    public function __construct() {
        parent::__construct(new Region());
    }
    /**
     * Customizes the select statement
     * @param Zend_Db_Select $select
     * @return \Zend_Db_Select
     */
    protected function customSelect(\Zend_Db_Select $select,array $criteria ) {
        if (key_exists('filter_forest', $criteria)) {
                $select->setIntegrityCheck(false)
                ->from($this->content->getTable()->info('name'),array('*','regione_codice'=>'codice'))
                ->join('propriet','diz_regioni.codice = propriet.regione');
        }
        $select->order('descriz');
        return $select;
    }
}