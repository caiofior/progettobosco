<?php
namespace forest;
/**
 * @author Claudio Fior <caiofior@gmail.com>
 * @copyright CRA
 * Manages Forest
 */
if (!class_exists('Content')) {
    $file = array(basename(__FILE__));
    $PHPUNIT=true;
    require (__DIR__.
                DIRECTORY_SEPARATOR.'..'.
                DIRECTORY_SEPARATOR.'..'.
                DIRECTORY_SEPARATOR.'..'.
                DIRECTORY_SEPARATOR.'include'.
                DIRECTORY_SEPARATOR.'pageboot.php');
}
/**
 * @author Claudio Fior <caiofior@gmail.com>
 * @copyright CRA
 * Manages Forest
 */
class Forest extends \Content {
     /**
     * Instantiates the table
     */
    public function __construct() {
        parent::__construct('propriet');
    }
    /**
     * Loads forest from its id
     * @param int $id
     */
    public function loadFromId($id) {
        parent::loadFromId($id);
        if (is_null($this->data))
            throw new \Exception('Unable to find the forest',1301221541);
    }
    /*
    * Remaps propriet codice 
    */
   public function setData($data, $field = null) {
       if (is_array($data) && key_exists('propriet_codice_raw', $data))
               $data['codice']=$data['propriet_codice_raw'];
       parent::setData($data, $field);
       if ($this->rawData['read_users'] != '')
           $this->rawData['read_users']= explode('|', $this->rawData['read_users']);
       if ($this->rawData['write_users'] != '')
           $this->rawData['write_users']= explode('|', $this->rawData['write_users']);
   }
   /**
    * Adds user owner
    * @param \User $user
    */
   public function addOwner (\User $user,$write = 0) {
    $table = new \Zend_Db_Table('user_propriet');
    $this->removeOwner($user);
    $data = array(
        'user_id' => $user->getData('id'),
        'propriet_codice' => $this->data['codice'],
        'write' => $write
    );
    $table->insert($data);
   }
   /**
    * Removes a forest user
    * @param \User $user
    */
   public function removeOwner (\User $user) {
        $table = new \Zend_Db_Table('user_propriet');
        $where = $table->getAdapter()->quoteInto('user_id = ?', $user->getData('id')).
        $table->getAdapter()->quoteInto(' AND propriet_codice = ?', $this->data['codice']);
        $table->delete($where); 
   }
}
