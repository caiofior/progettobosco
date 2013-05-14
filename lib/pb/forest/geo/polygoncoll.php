<?php
/**
 * Manages Geographic Polygon collection
 * 
 * Manages Geographic Polygon collection
 * 
 * @author Claudio Fior <caiofior@gmail.com>
 * @copyright CRA
 */
namespace forest\geo;
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
 * Manages Geographic Polygon collection
 * 
 * Manages Geographic Polygon collection
 * 
 * @author Claudio Fior <caiofior@gmail.com>
 * @copyright CRA
 */
class PolygonColl  extends \ContentColl  {
    /**
     * Id av reference
     * @var string
     */
    private $id_av;
    /**
     * Instantiates the table
     */
    public function __construct($nome) {
        parent::__construct(new Polygon($nome));
    }
     /**
     * Customizes the select statement
     * @param \Zend_Db_Select $select
     * @param array $criteria Filtering criteria
     * @return \Zend_Db_Select
     */
    protected function customSelect(\Zend_Db_Select $select,array $criteria ) {
        return $select;
    }
    /**
     * Sets the object id av
     * @param type $id_av
     */
    public function setIdAv($id_av) {
        $this->id_av = $id_av;
    }
    /**
     * Deletes all item with a specific ID
     */
    public function emptyColl() {
        $this->content->getTable()->getAdapter()->query('DELETE FROM '.$this->content->getTable()->info('name').' WHERE id_av = '.$this->content->getTable()->getAdapter()->quote($this->id_av));
    }
    /**
     * Returns a new polygon vertex
     * @return \forest\geo\Polygon
     */
    public function addItem() {
        $polygon = parent::addItem();
        $polygon->setData($this->id_av, 'id_av');
        return $polygon;
    }
}
