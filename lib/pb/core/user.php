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
    private $data=array();
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
        $updated = $this->table->update(array('lastlogin_datetime'=>'NOW()'), $where);
        if ($updated <> 1)
            throw new Exception('User not found',1301130904);
        $this->data = array_shift($this->table->find($id)->toArray());
    }
     /**
     * Loads user from its username
     * @param string $username
     */
    public function loadFromUsername($username) {
        $where = $this->table->getAdapter()->quoteInto('username = ?', $username); 
        $updated = $this->table->update(array('lastlogin_datetime'=>'NOW()'), $where);
        if ($updated <> 1)
            throw new Exception('User not found',1301130908);
        $this->data = $this->table->fetchRow($where)->toArray();
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
        if (!key_exists('username', $this->data) || $this->data['username'] == '')
          throw new Exception ('username is required ',130113906);
        if (!key_exists('password_new', $this->data) || $this->data['password_new'] == '')
          throw new Exception ('password_new is required ',130113907);
        $rows = $this->table->fetchAll($this->table->select()->where('username = ?', $this->data['username']));
        if (sizeof($rows) <> 0)
            throw new Exception ('User with username '.$this->data['username'].' already present',130113905);
        $this->data['password']=md5($this->data['password_new']);
        unset($this->data['password_new']);
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
    /**
     * Updates user data
     */
    public function update() {
        $rows = $this->table->fetchAll($this->table->select()->where('username = ?', $this->data['username']));
        if (sizeof($rows) <> 1)
            throw new Exception ('User with username '.$this->data['username'].' not present',130113905);
        if (key_exists('password_new', $this->data)) {
            $this->data['password']=md5($this->data['password_new']);
            unset($this->data['password_new']);
        }
        $where = $this->table->getAdapter()->quoteInto('id = ?', $this->data['id']);
        $this->table->update($this->data, $where);
    }
    /**
     * Gets associated profile to the user
     * @return Profile
     */
    public function getProfile() {
        $profile = new Profile();
        try{
            $profile->loadFromId($this->data['id']);
        } catch (Exception $e) {
            $profile->insert();
            $this->data['profile_id']=$profile->getData('id');
            $this->update();
        }
        return $profile;
    }
}

