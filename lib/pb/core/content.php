<?php
/**
 * @author Claudio Fior <caiofior@gmail.com>
 * @copyright CRA
 * Content object
 */
/**
 * @author Claudio Fior <caiofior@gmail.com>
 * @copyright CRA
 * Content object
 */
abstract class Content {
     /**
     * Zend Data table
     * @var Zend_Db_Table 
     */
    protected $table;
    /**
     * Data associated
     * @var array
     */
    protected $data=array();
     /**
     * Instantiates the table
     */
    public function __construct($table) {
        $this->table = new Zend_Db_Table($table);
    }
    /**
     * Loads data from its id
     * @param int $id
     */
    public function loadFromId($id) {
        $data = $this->table->find($id)->toArray();
        $this->data = array_shift($data);
    }
     /**
     * Gets the data
     * @return array
     */
    public function getData($field = null) {
        if (is_null($field))
            return $this->data;
        if (key_exists($field, $this->data))
            return $this->data[$field];
    }
    /**
     * Sets the data
     * @param variant $data
     * @param string|null $field
     */
    public function setData($data,$field=null){
        if (is_array($data)) {
            $this->data = array_merge($this->data,  array_intersect_key($data,$this->data));
         }
        else if (!is_null($field) )
            $this->data[$field] = $data;
    }
    /**
     * Adds a data
     */
    public function insert() {
        $this->data['id']=$this->table->insert($this->data);
    }
     /**
     * Deletes data
     */
    public function delete() {
        $where = $this->table->getAdapter()->quoteInto('id = ?', $this->data['id']);
        $this->table->delete($where);
    }
     /**
     * Updates data
     */
    public function update() {
        $where = $this->table->getAdapter()->quoteInto('id = ?', $this->data['id']);
        $this->table->update($this->data, $where);
    }
}
