<?php
/**
 * Manages Form B2 forest compartment
 * 
 * Manages Form B2 forest compartment
 * 
 * @author Claudio Fior <caiofior@gmail.com>
 * @copyright CRA
 */
namespace forest\form;
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
 * Manages Form B2 forest compartment
 * 
 * Manages Form B2 forest compartment
 * 
 * @author Claudio Fior <caiofior@gmail.com>
 * @copyright CRA
 */
class B2 extends \forest\form\template\Form {
     /**
     * Instantiates the table
     */
    public function __construct() {
        parent::__construct('sched_b2');
    }
    /**
     * Loads form a data
     * @param integer $id
     */
    public function loadFromId($id) {
        $where = $this->table->getAdapter()->quoteInto('objectid = ?', $id);
        $data = $this->table->fetchRow($where);
        if (is_null($data))
            throw new \Exception('Unable to find the cod part',1302081202);
        $this->data = $data->toArray();
        $this->calculatedVariables();
    }
    /**
     * Loads form a data form foreat and parcel code
     * @param string $proprieta Proprietà code
     * @param string $cod_part Forest compartment code
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
        if (!key_exists('proprieta', $this->data) ||
            !key_exists('cod_part', $this->data) ||
            !key_exists('cod_fo', $this->data)
            ) 
            throw new \Exception('Unable to update object without proprieta,cod_part and cod_fo',1301251130);
        foreach($this->data as $key=>$value)
            if ($value=='') $this->data[$key]=null;
        $b = $this->getFormB();
        $b->setData($this->rawData);
        $b->update();
        $where = $this->table->getAdapter()->quoteInto('proprieta = ? AND ', $this->data['proprieta']);
        $where .= $this->table->getAdapter()->quoteInto('cod_part = ? AND ', $this->data['cod_part']);
        $where .= $this->table->getAdapter()->quoteInto('cod_fo = ? ', $this->data['cod_fo']);
        $this->table->update($this->data, $where);
    }
    /**
     * Deletes data
     */
    public function delete() {
            $where = $this->table->getAdapter()->quoteInto('proprieta = ? AND ', $this->data['proprieta']);
            $where .= $this->table->getAdapter()->quoteInto('cod_part = ? AND ', $this->data['cod_part']);
            $where .= $this->table->getAdapter()->quoteInto('cod_fo = ? ', $this->data['cod_fo']);
            $this->table->delete($where);
    }
     /**
     * Return the associated note collection
     * @return \forest\attribute\NoteB2Coll
     */
    public function getNotes () {
        $notes = new \forest\attribute\NoteB2Coll();
        $notes->setForm($this);
        return $notes;
    }
    /**
     * Return the associated B fomr
     * @return \forest\form\B
     */
    private function getFormB() {
        $b = new \forest\form\B();
        if (
                key_exists('proprieta',$this->data) &&
                key_exists('cod_part',$this->data) &&
                key_exists('cod_fo',$this->data)
            )
        $b->loadFromCodePart($this->data['proprieta'],$this->data['cod_part'],$this->data['cod_fo']);
        return $b;
    }
    /**
     * Gets the associated Cork Cover Composition Collection
     * @return \forest\attribute\CorkCoverCompositionColl
     */
    public function getCorkCoverCompositionColl() {
        $corkcovercompositioncoll = new \forest\attribute\CorkCoverCompositionColl();
        $corkcovercompositioncoll->setForm($this);
        return $corkcovercompositioncoll;
    }
        /**
     * Gets the associated rennovation specie
     * @return \forest\attribute\Arboreal
     */
    public function getRennovationSpecie() {
        $rennovationspecie = new \forest\attribute\Arboreal();
        if (key_exists('spe_nov', $this->data))
            $rennovationspecie->loadFromId($this->data['spe_nov']);
        return $rennovationspecie;
    }
         /**
     * Gets the associated Cork Shrub Composition Collection
     * @return \forest\attribute\CorkShrubCompositionColl
     */
    public function getCorkShrubCompositionColl() {
        $shrubcoll = new \forest\attribute\CorkShrubCompositionColl();
        $shrubcoll->setForm($this);
        return $shrubcoll;
    }
    /**
     * Gets the associated Cork Herbaceus Composition Collection
     * @return \forest\attribute\CorkHerbaceusCompositionColl
     */
    public function getCorkHerbaceusCompositionColl() {
        $herbaceuscoll = new \forest\attribute\CorkHerbaceusCompositionColl();
        $herbaceuscoll->setForm($this);
        return $herbaceuscoll;
    }
} 
