<?php
/**
 * Manages Form B1 forest compartment
 * 
 * Manages Form B1 forest compartment
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
 * Manages Form B1 forest compartment
 * 
 * Manages Form B1 forest compartment
 * 
 * @author Claudio Fior <caiofior@gmail.com>
 * @copyright CRA
 */
class B1 extends \forest\form\template\Form implements \forest\form\template\getCoverCompositionColl {
     /**
     * Instantiates the table
     */
    public function __construct() {
        parent::__construct('sched_b1');
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
     * Gets associated Structure
     * @return \forest\attribute\ForestType
     */
    public function getStructure () {
        $structure = new \forest\attribute\Structure();
        if (key_exists('s', $this->data))
            $structure->loadFromCode($this->data['s']);
        return $structure;
    }
    /**
     * Gets the associated Forest Cover Composition Collection
     * @return \forest\attribute\B1CoverCompositionColl
     */
    public function getCoverCompositionColl() {
        $forestcovercompositioncoll = new \forest\attribute\B1CoverCompositionColl();
        $forestcovercompositioncoll->setForm($this);
        return $forestcovercompositioncoll;
    }
     /**
     * Gets the associated Shrub Composition Collection
     * @return \forest\attribute\B1CompositionColl
     */
    public function getShrubCompositionColl() {
        $shrubcoll = new \forest\attribute\B1CompositionColl();
        $shrubcoll->setForm($this);
        return $shrubcoll;
    }
     /**
     * Gets the associated Herbaceus Composition Collection
     * @return \forest\attribute\B1HerbaceusCompositionColl
     */
    public function getHerbaceusCompositionColl() {
        $herbaceuscoll = new \forest\attribute\B1HerbaceusCompositionColl();
        $herbaceuscoll->setForm($this);
        return $herbaceuscoll;
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
     * Gets the associated Forest Mass Esteem Collection
     * @return \forest\attribute\ForestMassEsteemColl
     */
    public function getForestMassEsteemColl() {
        $forestmassesteemcoll = new \forest\attribute\ForestMassEsteemColl();
        $forestmassesteemcoll->setForm($this);
        return $forestmassesteemcoll;
    }
     /**
     * Return the associated note collection
     * @return \forest\attribute\NoteBColl
     */
    public function getNotes () {
        $notes = new \forest\attribute\NoteBColl();
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
} 
