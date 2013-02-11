<?php
namespace forest\form;
/**
 * @author Claudio Fior <caiofior@gmail.com>
 * @copyright CRA
 * Manages Form B1 forest compartment
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
 * Manages Form B1 forest compartment
 */
class B1 extends \forest\form\template\Form {
     /**
     * Instantiates the table
     */
    public function __construct() {
        parent::__construct('sched_b1');
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
     * @param integer $id
     */
    public function loadFromCodePart($proprieta,$cod_part) {
        $where = $this->table->getAdapter()->quoteInto('proprieta = ?', $proprieta).' AND ';
        $where .= $this->table->getAdapter()->quoteInto('cod_part = ?', $cod_part);
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
        $where = $this->table->getAdapter()->quoteInto('objectid = ?', $this->data['objectid']);
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
     * Gets associated Structure
     * @return \forest\attribute\ForestType
     */
    public function getStructure () {
        $structure = new \forest\attribute\Structure();
        $structure->loadFromCode($this->data['s']);
        return $structure;
    }
} 
