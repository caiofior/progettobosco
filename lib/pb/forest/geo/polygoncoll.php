<?php
/**
 * Manages Poligon collection
 * 
 * Manages Poligon collection
 * 
 * @author Claudio Fior <caiofior@gmail.com>
 * @copyright CRA
 */
namespace forest\geo;
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
 * Manages Forest collection
 * 
 * Manages Forest collection
 * 
 * @author Claudio Fior <caiofior@gmail.com>
 * @copyright CRA
 */
class PolygonColl extends \ContentColl {
    /**
     * Referencnce to forest object
     * @var null|\forest\Forest
     */
    private $forest;
    /**
     * Instantiates the table
     * @param string $name Table name
     */
    public function __construct($name) {
        parent::__construct(new Polygon($name));
    }
     /**
     * Customizes the select statement
     * @param \Zend_Db_Select $select
     * @param array $criteria Filtering criteria
     * @return \Zend_Db_Select
     */
    protected function customSelect(\Zend_Db_Select $select,array $criteria ) {
        $select->setIntegrityCheck(false);
        if ($this->forest instanceof \forest\Forest) {
            $select->where(new \Zend_Db_Expr($this->content->getTable()->info('name').'.id_av IN (SELECT schede_a.id_av FROM schede_a  WHERE schede_a.proprieta= '.$select->getAdapter()->quote($this->forest->getData('codice')).')'));
        }
        return $select;
    }
    /**
     * Returns all contents without any filter
     * @param null|array $criteria Filtering criteria
     */
    public function countAll(array $criteria = null) {
            parent::countAll();
    }
    /**
     * Sets the forest Filter
     * @param \forest\Forest $forest
     */
    public function setForest (\forest\Forest $forest) {
        $this->forest = $forest;
    }
}