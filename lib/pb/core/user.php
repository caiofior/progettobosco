<?php
/**
 * @author Claudio Fior <caiofior@gmail.com>
 * @copyright CRA
 * Manages User account
 */
/**
 * @author Claudio Fior <caiofior@gmail.com>
 * @copyright CRA
 * Manages User account
 */
class User {
    /**
     * Zend Data table
     * @var Zend_Db_Table 
     */
    private $table;
    /**
     * Data associated
     * @var array
     */
    private $data;
    /**
     * Instantiates the table
     */
    public function __construct() {
        $this->table = new Zend_Db_Table('user');
    }
    /**
     * Loads user from its id
     * @param int $id
     */
    public function loadFromId($id) {
        $this->data = array_shift($this->table->find($id)->toArray());
        $where = $this->table->getAdapter()->quoteInto('id = ?', $id); 
        $this->data['lastlogin_datetime']='NOW()';
        $this->table->update($this->data, $where);
    }
    /**
     * return teh data
     * @return array
     */
    public function getData() {
        return $this->data;
    }
}

