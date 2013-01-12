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
        $where = $this->table->getAdapter()->quoteInto('id = ?', $id); 
        $this->table->update(array('lastlogin_datetime'=>'NOW()'), $where);
        $this->data = array_shift($this->table->find($id)->toArray());
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
    public function setdata($data,$field=null){
        if (is_array($data))
            $this->data = $data;
        else if (!is_null($field) && key_exists($field, $this->data))
            $this->data[$field] = $data;
    }
    /**
     * Adds a new user, please save the password in clear in password_new
     */
    public function insert() {
        $this->data['creation_datetime']='NOW()';
        $this->data['password']=md5($this->data['password_new']);
        $this->table->insert($this->data);
    }
     /**
     * Deletes user
     */
    public function delete() {
        $where = $this->table->getAdapter()->quoteInto('id = ?', $this->data['id']);
        $this->table->insert($where);
    }
    /**
     * Updates user data
     */
    public function update() {
        $where = $this->table->getAdapter()->quoteInto('id = ?', $this->data['id']);
        $this->table->update($this->data, $where);
    }
}

