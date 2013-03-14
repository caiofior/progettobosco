<?php
/**
 * Manages B4 Shrub Composition attribute
 * 
 * Manages B4 Shrub Composition attribute
 * 
 * @author Claudio Fior <caiofior@gmail.com>
 * @copyright CRA
 */
namespace forest\attribute;
if (!class_exists('Content')) {
    $file = 'attribute'.DIRECTORY_SEPARATOR.array(basename(__FILE__));
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
 * Manages B4 Shrub Composition attribute
 * 
 * Manages B4 Shrub Composition attribute
 * 
 * @author Claudio Fior <caiofior@gmail.com>
 * @copyright CRA
 */
class B4ShrubComposition  extends \forest\form\template\Form {
    /**
     * Instantiates the table
     */
    public function __construct() {
        parent::__construct('arboree4a');
    }
     /**
     * Loads form a data
     * @param integer $id
     */
    public function loadFromId($id) {
        $where = $this->table->getAdapter()->quoteInto('objectid = ?', $id);
        $data = $this->table->fetchRow($where);
        if (is_null($data))
            throw new \Exception('Unable to find the cod part',1302081202);
        $this->data = $data->toArray();
    }
     /**
     * Updates data
     */
    public function update() {
        if (!key_exists('objectid', $this->data)) 
            throw new Exception('Unable to update object without objectid',1302061037);
        $where = $this->table->getAdapter()->quoteInto('proprieta = ? AND ', $this->data['proprieta']);
        $where .= $this->table->getAdapter()->quoteInto('cod_part = ? AND ', $this->data['cod_part']);
        $where .= $this->table->getAdapter()->quoteInto('cod_fo = ? AND ', $this->data['cod_fo']);
        $where .= $this->table->getAdapter()->quoteInto('cod_coltu = ?', $this->data['cod_coltu']);
        $this->table->update($this->data, $where);
    }
    /**
     * Deletes data
     */
    public function delete() {
        if (key_exists('objectid', $this->data)) {
            $where = $this->table->getAdapter()->quoteInto('objectid = ?', $this->data['objectid']);
            $this->table->delete($where);
        }
    }
    /**
     * Returns the associated control
     * @param string $attribute
     * @param null|array $criteria
     * @return boolean
     */
    public function getControl($attribute,$criteria=null) {
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

