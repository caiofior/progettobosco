<?php
/**
 * @author Claudio Fior <caiofior@gmail.com>
 * @copyright CRA
 * Logs user data
 */
/**
 * @author Claudio Fior <caiofior@gmail.com>
 * @copyright CRA
 * Logs user data
 */
class Log {
    const CLEANUP_LOG =  " creation_datetime < NOW() - INTERVAL '1 month'";
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
        $this->table = new Zend_Db_Table('log');
        $this->table->delete(sef::CLEANUP_LOG);
    }
    /**
     * Loads profile from its id
     * @param int $id
     */
    public function loadFromId($id) {
        $data = $this->table->find($id)->toArray();
        $this->data = array_shift($data);
        if (is_null($this->data))
            throw new Exception('Unable to find the log',1301151428);;
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
        $this->data['creation_datetime']='NOW()';
        $this->data['id']=$this->table->insert($this->data);
    }
     /**
     * Deletes user
     */
    public function delete() {
        $where = $this->table->getAdapter()->quoteInto('id = ?', $this->data['id']);
        $this->table->delete($where);
    }

}

