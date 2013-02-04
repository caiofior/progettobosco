<?php
namespace forest\form\template;
/**
 * @author Claudio Fior <caiofior@gmail.com>
 * @copyright CRA
 * Manages Form forest compartment
 */
if (!class_exists('Content')) {
    $file = 'form'.DIRECTORY_SEPARATOR.array(basename(__FILE__));
    $PHPUNIT=true;
    require (__DIR__.
                DIRECTORY_SEPARATOR.'..'.
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
 * Manages Form forest compartment
 */
abstract class Form extends \Content {
    /**
     * All atrivute data
     * @var array
     */
    protected $all_attributes_data=array();
     /**
     * Instantiates the table
     */
    public function __construct($table = null) {
        parent::__construct($table);
        $all_attributes_data = $GLOBALS['CACHE']->load('archivi');
        if (is_array($all_attributes_data)) {
            $this->all_attributes_data=$all_attributes_data;
        } else {
            $attibutes = new \Zend_Db_Table('archivi');
            $all_attributes_data = $attibutes->fetchAll()->toArray();
            foreach ($all_attributes_data as $attribute_data) {
                if (!key_exists($attribute_data['archivio'],$this->all_attributes_data))
                    $this->all_attributes_data[$attribute_data['archivio']] =array();
                $this->all_attributes_data[$attribute_data['archivio']][$attribute_data['nomecampo']]=$attribute_data;
            }
            $GLOBALS['CACHE']->save($this->all_attributes_data,'archivi');
        }
    }
    /**
     * Returns the associated control
     * @param string $attribute
     * @return boolean
     */
    public function getControl($attribute) {
        if (!key_exists($this->table->info('name'),$this->all_attributes_data))
                return false;
        if (!key_exists($attribute, $this->all_attributes_data[$this->table->info('name')]))
                return false;
        $attribute = $this->all_attributes_data[$this->table->info('name')][$attribute];
        if (key_exists('dizionario', $attribute)) {
            $itemcoll = new \forest\form\control\Itemcoll( $attribute['dizionario']);
            $itemcoll->loadAll();
            return $itemcoll;
        }
    }
}