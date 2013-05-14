<?php
/**
 * Manages Geographic Polygon
 * 
 * Manages Geographic Polygon
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
 * Manages Geographic Polygon
 * 
 * Manages Geographic Polygon
 * 
 * @author Claudio Fior <caiofior@gmail.com>
 * @copyright CRA
 */
class Polygon  extends \ContentColl  {
    /**
     * SQL reference
     * @var string
     */
    private $sql;
    /**
     * Id av reference
     * @var string
     */
    private $id_av;
    /**
     * Instantiates the table
     * @param string $name table name
     */
    public function __construct($name) {
        parent::__construct(new PolygonItem($name));
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
     * @return \forest\geo\PolygonItem
     */
    public function appendItem() {
        $polygon = parent::addItem();
        $polygon->setData($this->id_av, 'id_av');
        $this->items[] = $polygon;
        return $polygon;
    }
    /**
     * Insert a polygon to db
     */
    public function insert() {
        switch (get_class($this->content->getTable()->getAdapter())) {
            case 'Zend_Db_Adapter_Mysqli':
            $this->sql = 'INSERT INTO '.$this->content->getTable()->info('name').' (id_av, forest_compartment) '.
                   ' VALUES ('.$this->content->getTable()->getAdapter()->quote($this->id_av).' ,  GeomFromText(\'POLYGON (';
            foreach ($this->items as $key=>$point) {
                if ($key > 0 ) $this->sql .= ', ';
                 $this->sql .= $point->getRawData('latitude').' '.$point->getRawData('longitude');
            }
            $this->sql .= ')\')';

            $db = $this->content->getTable()->getAdapter()->getConnection();
            $old_eh = \set_error_handler(array(get_class($this),'error_handler'));
            mysqli_query($db, $this->sql);
            set_error_handler($old_eh);
            break;
            case 'Zend_Db_Adapter_Pgsql':
        
            $this->sql = 'INSERT INTO '.$this->content->getTable()->info('name').' (id_av, forest_compartment) '.
                   ' VALUES ('.$this->content->getTable()->getAdapter()->quote($this->id_av).' , \'';
            foreach ($this->items as $key=>$point) {
                if ($key > 0 ) $this->sql .= ', ';
                $this->sql .= '('.$point->getRawData('latitude').','.$point->getRawData('longitude').')';
            }
            $this->sql .= '\')';

            $db = $this->content->getTable()->getAdapter()->getConnection();
            $old_eh = \set_error_handler(array(get_class($this),'error_handler'));
            pg_query($db, $this->sql);
            set_error_handler($old_eh);
            break;
        }
    }
    /**
     * Manages errors in polygon
     * @param int $num
     * @param string $err
     * @param string $file
     * @param int $line
     */
    public  function error_handler ($num,$err,$file,$line) {
        file_put_contents($GLOBALS['BASE_DIR'].'log'.DIRECTORY_SEPARATOR.'last_wrong_query.sql', $this->sql);
    }
}
