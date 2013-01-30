<?php
namespace forest\form;
/**
 * @author Claudio Fior <caiofior@gmail.com>
 * @copyright CRA
 * Manages Form A forest compartment
 */
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
 * @author Claudio Fior <caiofior@gmail.com>
 * @copyright CRA
 * Manages Form A forest compartment
 */
class A extends \Content {
     /**
     * Instantiates the table
     */
    public function __construct() {
        parent::__construct('schede_a');
    }
    /**
     * Loads fora a data
     * @param integer $id
     */
    public function loadFromId($id) {
        parent::loadFromId($id);
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
}
