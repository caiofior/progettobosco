<?php
/**
 * Manages Forest
 * 
 * Manages Forest
 * 
 * @author Claudio Fior <caiofior@gmail.com>
 * @copyright CRA
 */
namespace forest;

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
 * Manages Forest
 * 
 * Manages Forest
 * 
 * @author Claudio Fior <caiofior@gmail.com>
 * @copyright CRA
 */
class Forest extends template\Entity {
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
        $where = $this->table->getAdapter()->quoteInto('objectid = ?', $id);
        $data = $this->table->fetchRow($where);
        if (is_null($data))
            throw new \Exception('Unable to find the forest',1301251115);
        $this->data = $this->table->fetchRow($where)->toArray();
        $this->addForestCompartmentCount();
    }
     /**
     * Loads forest from its code
     * @param string $code
     */
    public function loadFromCode($code) {
        $where = $this->table->getAdapter()->quoteInto('codice = ?', $code);
        $data = $this->table->fetchRow($where);
        if (is_null($data))
            throw new \Exception('Unable to find the forest',1301251056);
        $this->data = $data->toArray();
        $this->addForestCompartmentCount();
    }
    /**
     * Remaps propriet codice
     * @param variant $data
     * @param string|null $field
     */
   public function setData($data, $field = null) {
       if (is_array($data) && key_exists('propriet_codice_raw', $data))
               $data['codice']=$data['propriet_codice_raw'];
       if (is_array($data) && key_exists('propriet_objectid_raw', $data))
               $data['objectid']=$data['propriet_objectid_raw'];
       parent::setData($data, $field);
       if (key_exists('read_users', $this->rawData) && $this->rawData['read_users'] != '')
           $this->rawData['read_users']= explode('|', $this->rawData['read_users']);
       if (key_exists('write_users', $this->rawData) &&$this->rawData['write_users'] != '')
           $this->rawData['write_users']= explode('|', $this->rawData['write_users']);
   }
   /**
    * Adds user owner
    * @param \User $user
    * @param int $write Write support enabled or not
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
    /**
     * Updates data
     */
    public function update() {
        if (!key_exists('objectid', $this->data)) 
            throw new Exception('Unable to update object without objectid',1301251130);
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
     * Add the count of forest compartments
     */
    private function addForestCompartmentCount() {
        $select = $this->table->getAdapter()->select()->from('schede_a','COUNT(*)')->where('proprieta = ? ',$this->data['codice']);
        $this->rawData['forest_compartment_cont']=intval($this->table->getAdapter()->fetchOne($select));
    }
    /**
     * Gets the form a collection of the forest
     * @return \forest\entity\AColl
     */
    public function getForestCompartmentColl () {
        $acoll = new entity\AColl();
        $acoll->setForest($this);
        return $acoll;
    }
    /**
     * Returns attribute collection available in this forest
     * @param \forest\attribute\template\AttributeColl $attributecoll
     * @return \forest\attribute\template\AttributeColl
     */
    public function getAttributeColl (\forest\attribute\template\AttributeColl $attributecoll) {
        $attributecoll->setForest($this);
        return $attributecoll;
    }
    /**
     * Returns an array of forest types present in the forest
     * @return array
     */
    public function getTColl () {
        $data = array_flip($this->getTable()->getAdapter()->fetchAssoc('SELECT DISTINCT usosuolo.codice,usosuolo.descriz FROM schede_b 
LEFT JOIN usosuolo ON usosuolo.codice=schede_b.u
WHERE usosuolo.codice <> \'\' AND proprieta=\''.$this->data['codice'].'\''));
        return $data;
    }
    
    /**
     * get the associated region
     * @return \forest\Region
     */
    public function getRegion () {
        $region = new \forest\Region();
        $region->loadFromId($this->data['regione']);
        return $region;
    }
    /**
     * Recalculates surface of forest compartments
     */
    public function surfaceRecalc() {
        $this->table->getAdapter()->query("
            UPDATE schede_a SET sup_tot = (
	SELECT SUM(catasto.sup_tot) FROM catasto WHERE 
	catasto.cod_part=schede_a.cod_part AND
	catasto.proprieta=schede_a.proprieta
	) WHERE schede_a.proprieta= ?
            ",$this->data['codice']
        );
    }
    /**
     * Cechs the cadastral data
     * @param int $method
     * @return array
     */
    public function surfaceVerifyCalc($method) {
        $messages = array();
        $this->table->getAdapter()->query("
            UPDATE catasto SET 
            porz_perc = (
	SELECT c1.sup_tot / c1.sup_tot_cat *100 FROM catasto AS c1 WHERE 
	c1.objectid=catasto.objectid
	) WHERE 
        ( porz_perc = 0 OR porz_perc IS NULL ) AND
        ( catasto.sup_tot > 0 ) AND
        ( catasto.sup_tot_cat > 0 ) AND
        catasto.proprieta= ?
            ",$this->data['codice']
        );
        if ($method == 1)
        $this->table->getAdapter()->query("
            UPDATE catasto SET 
            sup_tot_cat = (
	SELECT c1.sup_tot / c1.porz_perc * 100 FROM catasto AS c1 WHERE 
	c1.objectid=catasto.objectid
	) WHERE 
        ( porz_perc > 0 ) AND
        ( catasto.sup_tot > 0 ) AND
        ( catasto.sup_tot_cat = 0 OR catasto.sup_tot_cat IS NULL ) AND
        catasto.proprieta= ?
            ",$this->data['codice']
        );
        else if ($method == 2)
        $this->table->getAdapter()->query("
            UPDATE catasto SET 
            sup_tot_cat = (
	SELECT c1.sup_tot FROM catasto as c1 WHERE 
	c1.objectid=catasto.objectid
	),
            sup_tot =(
	SELECT c2.sup_tot_cat / c2.porz_perc * 100 FROM catasto as c2 WHERE 
	c2.objectid=catasto.objectid
	) WHERE 
        ( porz_perc > 0 ) AND
        ( catasto.sup_tot > 0 ) AND
        ( catasto.sup_tot_cat = 0 OR catasto.sup_tot_cat IS NULL ) AND
        catasto.proprieta= ?
            ",$this->data['codice']
        );
        $res = $this->table->getAdapter()->query("
        SELECT cod_part,foglio,particella FROM catasto 
        WHERE sup_tot = 0 OR sup_tot IS NULL AND catasto.proprieta= ?
        ",$this->data['codice']);
        while($row = $res->fetch() )
            $messages[$row['cod_part']][] = 'Per i dati catastali non è stata inserita la SUPERFICIE TOTALE: foglio'.$row['foglio'].' particella catastale '.$row['particella'].' particella forestale'.$row['cod_part'];
        
        $res = $this->table->getAdapter()->query("
        SELECT cod_part,foglio,particella FROM catasto 
        WHERE sup_tot_cat = 0 OR sup_tot_cat IS NULL AND catasto.proprieta= ?
        ",$this->data['codice']);
        while($row = $res->fetch() )
            $messages[$row['cod_part']][] = 'Per i dati catastali non è stata inserita la SUPERFICIE AFFERENTE: foglio'.$row['foglio'].' particella catastale '.$row['particella'].' particella forestale'.$row['cod_part'];
        
        $res = $this->table->getAdapter()->query("
        SELECT cod_part,foglio,particella FROM catasto WHERE
        sup_bosc = 0 OR sup_bosc IS NULL AND catasto.proprieta= ?
        ",$this->data['codice']);
        while($row = $res->fetch() )
            $messages[$row['cod_part']][] = 'Per i dati catastali non è stata inserita la SUPERFICIE BOSCATA: foglio'.$row['foglio'].' particella catastale '.$row['particella'].' particella forestale'.$row['cod_part'];
        
        $res = $this->table->getAdapter()->query("
            SELECT cod_part FROM schede_a WHERE 
            schede_a.sup_tot IS NULL OR schede_a.sup_tot=0
             AND schede_a.proprieta= ?
        ",$this->data['codice']);
        
        while($row = $res->fetch() )
            $messages[$row['cod_part']][] = 'In Scheda A non è stata inserita la superficie per le seguenti particelle: particella forestale'.$row['cod_part'];
        
        $res = $this->table->getAdapter()->query("
            SELECT cod_part FROM schede_a WHERE 
            ROUND(CAST(schede_a.sup_tot AS numeric),4) <> (SELECT ROUND(CAST (SUM(catasto.sup_tot) AS numeric),4) FROM catasto
                WHERE catasto.proprieta=schede_a.proprieta AND
                catasto.cod_part=schede_a.cod_part
            ) AND schede_a.proprieta= ?
        ",$this->data['codice']);
        
        while($row = $res->fetch() )
            $messages[$row['cod_part']][] = 'In Scheda A non è stata inserita la superficie per le seguenti particelle: particella forestale'.$row['cod_part'];

        $res = $this->table->getAdapter()->query("
        SELECT cod_part,foglio,particella FROM catasto WHERE
        sup_tot IS NOT NULL AND
        sup_tot_cat IS NOT NULL AND
        sup_tot > sup_tot_cat AND
        catasto.proprieta= ?
        ",$this->data['codice']);
        while($row = $res->fetch() )
            $messages[$row['cod_part']][] = 'Per i dati catastali è stata inserita una superficie afferente maggiore della superficie totale per la seguente particella: foglio'.$row['foglio'].' particella catastale '.$row['particella'].' particella forestale'.$row['cod_part'];
        
        $res = $this->table->getAdapter()->query("
        SELECT cod_part,foglio,particella FROM catasto WHERE
        sup_tot IS NOT NULL AND
        sup_bosc IS NOT NULL AND
        sup_bosc > sup_tot AND
        catasto.proprieta= ?
        ",$this->data['codice']);
        while($row = $res->fetch() )
            $messages[$row['cod_part']][] = 'Per i dati catastali è stata inserita una superficie boscata maggiore della superficie afferente per la seguente particella: foglio'.$row['foglio'].' particella catastale '.$row['particella'].' particella forestale'.$row['cod_part'];
        
        $this->table->getAdapter()->query("
        UPDATE catasto SET 
            sum_sup_non_bosc = (
	SELECT c1.sup_tot - c1.sup_bosc FROM catasto as c1 WHERE 
	c1.objectid=catasto.objectid
	) WHERE 
        sup_tot IS NOT NULL AND
        sup_bosc IS NOT NULL AND
        catasto.proprieta= ?
            ",$this->data['codice']
        );
        
        return $messages;

    }
}
