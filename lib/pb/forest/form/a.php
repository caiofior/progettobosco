<?php
/**
 * Manages Form A forest compartment
 * 
 * Manages Form A forest compartment
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
 * Manages Form A forest compartment
 * 
 * Manages Form A forest compartment
 * 
 * @author Claudio Fior <caiofior@gmail.com>
 * @copyright CRA
 */
class A extends \forest\form\template\Form {
     /**
     * Instantiates the table
     */
    public function __construct() {
        parent::__construct('schede_a');
    }
    /**
     * Loads form a data
     * @param integer $id
     */
    public function loadFromId($id) {
        parent::loadFromId($id);
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
     * Return the forest associate with a form
     * @return \forest\Forest
     */
    public function getForest() {
        $bosco = new \forest\Forest();
        $bosco->loadFromCode($this->data['proprieta']);
        return $bosco;
    }
    /**
     * Sets the calculated variables
     */
    private function calculatedVariables () {
        /**
         * calcolo improduttivi
         */
        $this->rawData['improduttivi_calcolo']=0;
        if ($this->data['i1'] > 0 )
            $this->rawData['improduttivi_calcolo']=$this->data['i1'];
        else if ($this->data['i2'] > 0 )
            $this->rawData['improduttivi_calcolo']=$this->data['sup_tot']*$this->data['i2']/100;
        /**
         * calcolo produttivi non boscati
         */
        $this->rawData['prod_non_bosc_calcolo']=0;
        if ($this->data['i21'] > 0 )
            $this->rawData['prod_non_bosc_calcolo']=$this->data['i21'];
        else if ($this->data['i22'] > 0 )
            $this->rawData['prod_non_bosc_calcolo']=$this->data['sup_tot']*$this->data['i22']/100;
        /**
         * calcolo superficie boscata
         */
        $this->rawData['boscata_calcolo']=$this->data['sup_tot']-$this->rawData['improduttivi_calcolo']-$this->rawData['prod_non_bosc_calcolo'];
    }
    /**
     * Gets the associated municipality
     * @return \forest\attribute\Municipality
     */
    public function getMunicipality () {
        $municipality = new \forest\attribute\Municipality();
        $municipality->loadFromCode($this->data['comune']);
        return $municipality;
    }
    /**
     * Gets teh associated colelctor
     * @return \forest\attribute\Collector
     */
    public function getCollector() {
        $collector = new \forest\attribute\Collector();
        $collector->loadFromId($this->data['codiope']);
        return $collector;
    }
    /**
     * Return the associated note collection
     * @return \forest\attribute\NoteAColl
     */
    public function getNotes () {
        $notes = new \forest\attribute\NoteAColl();
        $notes->setForm($this);
        return $notes;
    }
    /**
     * Return a collection of cadastral parcel associated with the forest parcel
     * @return \forest\attribute\CadastralColl
     */
    public function getCadastalColl () {
        $cadastralcoll = new \forest\attribute\CadastralColl();
        $cadastralcoll->setForm($this);
        return $cadastralcoll;
    }
     /**
     * Updates data
     */
    public function update() {
        if (!key_exists('objectid', $this->data)) 
            throw new Exception('Unable to update object without objectid',1301251130);
        foreach($this->data as $key=>$value)
            if ($value=='') $this->data[$key]=null;
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
     * Return the associated B Collection
     * @return \forest\form\BColl
     */
    public function getBColl () {
        $bcoll = new \forest\form\BColl();
        $bcoll->setFormA($this);
        $bcoll->loadAll();
        return $bcoll;
    }
} 
