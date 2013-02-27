<?php
/**
 * Manages Form B forest compartment
 * 
 * Manages Form B forest compartment
 * 
 * @author Claudio Fior <caiofior@gmail.com>
 * @copyright CRA
 */
namespace forest\form;
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
 * Manages Form B forest compartment
 * 
 * Manages Form B forest compartment
 * 
 * @author Claudio Fior <caiofior@gmail.com>
 * @copyright CRA
 */
class B extends \forest\form\template\Form {
     /**
     * Instantiates the table
     */
    public function __construct() {
        parent::__construct('schede_b');
    }
    /**
     * Loads form a data
     * @param integer $id
     */
    public function loadFromId($id) {
        parent::loadFromId($id);
        $this->calculatedVariables();
    }
    /**
     * Loads form a data form foreat and parcel code
     * @param string $proprieta Proprietà code
     * @param string $cod_part Forest compartment code
     * @param string $cod_fo Forest compartment code
     */
    public function loadFromCodePart($proprieta,$cod_part,$cod_fo) {
        $where = $this->table->getAdapter()->quoteInto('proprieta = ? AND ', $proprieta);
        $where .= $this->table->getAdapter()->quoteInto('cod_part = ? AND ', $cod_part);
        $where .= $this->table->getAdapter()->quoteInto('cod_fo = ?', $cod_fo);
        $data = $this->table->fetchRow($where);
        if (is_null($data))
            throw new \Exception('Unable to find the cod part',1302081202);
        $this->data = $data->toArray();
        $this->calculatedVariables();
    }
    /**
     * Sets the calculated variables
     */
    private function calculatedVariables () {
       
    }
     /**
     * Updates data
     */
    public function update() {
        if (!key_exists('objectid', $this->data)) 
            throw new Exception('Unable to update object without objectid',1301251130);
        foreach($this->data as $key=>$value)
            if ($value=='') $this->data[$key]=null;
        unset($this->data['objectid']);
        $where = $this->table->getAdapter()->quoteInto('proprieta = ? AND ', $this->data['proprieta']);
        $where .= $this->table->getAdapter()->quoteInto('cod_part = ? AND ', $this->data['cod_part']);
        $where .= $this->table->getAdapter()->quoteInto('cod_fo = ? ', $this->data['cod_fo']);
        $this->table->update($this->data, $where);
    }
    /**
     * Deletes data
     */
    public function delete() {
        if (key_exists('objectid', $this->data)) {
            $where = $this->table->getAdapter()->quoteInto('proprieta = ? AND ', $this->data['proprieta']);
            $where .= $this->table->getAdapter()->quoteInto('cod_part = ? AND ', $this->data['cod_part']);
            $where .= $this->table->getAdapter()->quoteInto('cod_fo = ? ', $this->data['cod_fo']);
            $this->table->delete($where);
        }
    }
    /**
     * Return the associated B1 Collection
     * @return \forest\form\B1Coll
     */
    public function getB1Coll () {
        $b1coll = new \forest\form\B1Coll();
        $b1coll->setFormB($this);
        $b1coll->loadAll();
        return $b1coll;
    }
    /**
     * Gets associated Forest Type
     * @return \forest\attribute\ForestType
     */
    public function getForestType () {
        $foresttype = new \forest\attribute\ForestType();
        if (key_exists('t', $this->data))
            $foresttype->loadFromCode($this->data['t']);
        return $foresttype;
    }
} 
