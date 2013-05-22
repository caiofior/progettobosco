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
 * Data are stored in database in UTM format using Ellipsoid WGS 84
 * {@link http://www.phpclasses.org/browse/file/10671.html gPoint Tool} was user for transformation  for transforming Latitude and Longitude to UTM
 * 
 * 
 * @author Claudio Fior <caiofior@gmail.com>
 * @copyright CRA
 */
class Polygon  extends \Content  {
    /**
     * Collection of poligon items
     * @var array
     */
    private $items =array();
    /**
     * SQL reference
     * @var string
     */
    private static $sql;
    /**
     * Instantiates the table
     * @param string $name table name
     */
    public function __construct($name) {
        parent::__construct($name);
    }
    /**
     * Sets the reference to the vector
     * @param type $id
     */
    public function loadFromId($id) {
        $this->data['id_av'] = $id;
    }

    /**
     * Returns a new polygon vertex
     * @return \forest\geo\PolygonItem
     */
    public function appendItem() {
        $polygon = new \forest\geo\PolygonItem();
        $polygon->setData($this->id_av, 'id_av');
        $this->items[] = $polygon;
        return $polygon;
    }
    /**
     * Insert a polygon to db
     */
    public function insert() {
        $this->table->getAdapter()->query('DELETE FROM '.$this->table->info('name').' WHERE id_av = '.$this->table->getAdapter()->quote($this->id_av));
        $gpoint = new \gPoint();
        switch (get_class($this->table->getAdapter())) {
            case 'Zend_Db_Adapter_Mysqli':
            self::$sql = 'INSERT INTO '.$this->table->info('name').' (id_av, forest_compartment) '.
                   ' VALUES ('.$this->table->getAdapter()->quote($this->id_av).' ,  GeomFromText(\'POLYGON ((';
            foreach ($this->items as $key=>$point) {
                $gpoint->setLongLat($point->getRawData('longitude'),$point->getRawData('latitude'));
                $gpoint->convertLLtoTM();
                if ($key > 0 ) self::$sql .= ', ';
                 self::$sql .= $gpoint->N().' '.$gpoint->E();
            }
            self::$sql .= '))\'))';
            $db = $this->table->getAdapter()->getConnection();
            set_error_handler(get_class($this).'::error_handler');
            mysqli_query($db, self::$sql);
            restore_error_handler();
            break;
            case 'Zend_Db_Adapter_Pgsql':
        
            self::$sql = 'INSERT INTO '.$this->table->info('name').' (id_av, forest_compartment) '.
                   ' VALUES ('.$this->table->getAdapter()->quote($this->id_av).' , ST_GeomFromText(\'POLYGON((';
            $first = null;    
            foreach ($this->items as $key=>$point) {
                $gpoint->setLongLat($point->getRawData('longitude'),$point->getRawData('latitude'));
                $gpoint->convertLLtoTM();
                if ($key == 0)
                    $first = clone $gpoint;
                self::$sql .= $gpoint->N().' '.$gpoint->E().', ';
            }
            self::$sql .= $first->N().' '.$first->E();
            self::$sql .= '))\',4326))';

            $db = $this->table->getAdapter()->getConnection();
            set_error_handler(get_class($this).'::error_handler');
            pg_query($db, self::$sql);
            restore_error_handler();
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
    public static function error_handler ($num,$err,$file, $line) {
        trigger_error('Error on insert '.$file.' '.$line.' '.$err);
        file_put_contents($GLOBALS['BASE_DIR'].'log'.DIRECTORY_SEPARATOR.'last_wrong_query.sql', self::$sql);
    }
    /**
     * get Centroid Point
     * @return \gPoint
     */
    public function getCentroid () {
        if (!key_exists('centroid',$this->data)) {
            switch (get_class($this->table->getAdapter())) {
                case 'Zend_Db_Adapter_Mysqli':
                    self::$sql = 'SELECT X(Centroid(forest_compartment)) as X, Y(Centroid(forest_compartment)) as Y  FROM geo_particellare WHERE id_av = "'.$this->data['id_av'].'"';
                    $point = $this->table->getAdapter()->fetchRow(self::$sql);
                    $gpoint = new \gPoint();
                    $gpoint->setUTM($point['X'], $point['Y']);
                    $gpoint->convertTMtoLL();
                    $this->data['centroid']=$gpoint;
                break;
                case 'Zend_Db_Adapter_Pgsql':
                    self::$sql = 'SELECT ST_AsGeoJson(ST_Centroid(forest_compartment)) FROM geo_particellare WHERE id_av = \''.$this->data['id_av'].'\'';
                    set_error_handler(get_class($this).'::error_handler');
                    $point = $this->table->getAdapter()->fetchOne(self::$sql);
                    restore_error_handler();
                    $point = json_decode($point);
                    $gpoint = new \gPoint();
                    $gpoint->setUTM($point->coordinates[0], $point->coordinates[1]);
                    $gpoint->convertTMtoLL();
                    $this->data['centroid']=$gpoint;
                break;

            }
        }
        return $this->data['centroid'];
    }
}
