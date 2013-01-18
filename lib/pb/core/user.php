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
class User extends Content {
    /**
     * Instantiates the table
     */
    public function __construct() {
        parent::__construct('user');
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
        parent::loadFromId($id);
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
     * Loads user from its confirmation code
     * @param string $username
     */
    public function loadFromConformationCode($confirmation_code) {
        $where = $this->table->getAdapter()->quoteInto('confirmation_code = ?', $confirmation_code); 
        $updated = $this->table->update(array('lastlogin_datetime'=>'NOW()'), $where);
        if ($updated <> 1)
            throw new Exception('User not found',1301130908);
        $this->data = $this->table->fetchRow($where)->toArray();
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
        $this->data['confirmation_code']=md5(serialize($GLOBALS));
        $this->data['creation_datetime']='NOW()';
        $profile = new Profile();
        $profile->setData($this->data['username'],'email');
        $profile->insert();
        $this->data['profile_id']=$profile->getData('id');
        parent::insert();
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
        parent::update();
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
    /**
     * Creates user auth class
     * @return \Zend_Auth_Adapter_DbTable
     */
    public static function getAuthAdapter()    {
        return new Zend_Auth_Adapter_DbTable(
    Zend_Db_Table::getDefaultAdapter(),
    'user',
    'username',
    'password',
    'MD5(?) AND "active" AND "confirmed"'
);
    }
    /**
     * Check password consistence
     * @param string $new_password
     * @return bool
     */
    public function checkPassword($new_password) {
        return md5($new_password) != $this->data['password'];
    }
    /**
    * Generates a new password
    * @param int $n number of charcaters
    * @return string password
    */
   public function generatePassword ($n=null) {
        if (is_null($n))  $n = 6;
        
        $password = '';
        for ($c  = 0; $c < 6 ; $c++)
                $password .= ((rand(1,4) != 1) ? chr(rand(97, 122)) : rand(0, 9));
        $this->data['password_new']=$password;
        return $password;
   }
}