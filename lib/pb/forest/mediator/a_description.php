<?php
/**
 * Manages Entity A Description
 * 
 * Manages Entity A Description
 * 
 * @author Claudio Fior <caiofior@gmail.com>
 * @copyright CRA
 */
namespace forest\mediator;


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
 * Manages Entity A Description
 * 
 * Manages Entity A Description
 * 
 * @author Claudio Fior <caiofior@gmail.com>
 * @copyright CRA
 */
class ADescription  {
    /**
     * Reference to Form a Object
     * @var \forest\entity\A
     */
    private $a;
    /**
     * Intantiates the Decsription
     * @param \forest\entity\A $a
     */
    public function __construct(\forest\entity\A $a) {
        $this->a = $a;
    }
    /**
     * Generates description
     * @return string
     */
    public function generateDescription() {
        $description = '';
        if (!$this->a instanceof \forest\entity\A )
            return $description;
        $description .= <<<EOT
Particella {$this->a->getData('proprieta')} {$this->a->getData('toponimo')} {$this->a->getData('sup_tot')} ha
Fattori ambientali e di gestione
Posta {$this->getValue('posfisio', $this->a->getData('pf1'))}
EOT;
                
        
        return $description;
    }
    /**
     * Gets the associated label of a control
     * @param string $table table name
     * @param mixed $codice code value
     * @return string associated label
     */
    private function getValue ($table,$codice) {
        $control = new \forest\template\ControlColl($table);
        $control->loadAll(array('codice'=>$codice));
        $control = $control->getFirst();
        return $control->getData('descriz');
    }
 }