<?php
/**
 * @author Claudio Fior <caiofior@gmail.com>
 * @copyright CRA
 * Manages User profile
 */
/**
 * @author Claudio Fior <caiofior@gmail.com>
 * @copyright CRA
 * Manages User profile
 */
class Profile {
    /**
     * Zend Data table
     * @var Zend_Db_Table 
     */
    private $table;
    /**
     * Data associated
     * @var array
     */
    private $data=array();
    /**
     * Instantiates the table
     */
    public function __construct() {
        $this->table = new Zend_Db_Table('profile');
    }
    /**
     * Loads profile from its id
     * @param int $id
     */
    public function loadFromId($id) {
        $this->data = array_shift($this->table->find($id)->toArray());
        if (is_null($this->data))
            throw new Exception('Unable to find the profile',1301141428);;
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
        if (is_array($data))
            $this->data = $data;
        else if (!is_null($field) )
            $this->data[$field] = $data;
    }
    /**
     * Adds a new user, please save the password in clear in password_new
     */
    public function insert() {
        $this->data['lastupdate_datetime']='NOW()';
        $this->data['id']=$this->table->insert($this->data);
    }
     /**
     * Deletes user
     */
    public function delete() {
        $where = $this->table->getAdapter()->quoteInto('id = ?', $this->data['id']);
        $this->table->delete($where);
    }
    /**
     * Updates user data
     */
    public function update() {
        $this->data['lastupdate_datetime']='NOW()';
        $where = $this->table->getAdapter()->quoteInto('id = ?', $this->data['id']);
        $this->table->update($this->data, $where);
    }
}

