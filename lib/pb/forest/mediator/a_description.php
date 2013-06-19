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
     * Issues during description elaboration
     * @var array
     */
    private $issues=array();
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
        $issues =array();
        if (!$this->a instanceof \forest\entity\A )
            return $description;
        
        $pf1 = $this->getValue('a','pf1', $this->a->getData('pf1'));
        if ($pf1 != '') $pf1 = 'Posta '.$pf1.$this->getNote('a', 'pf1');
        else $this->addIssue('a', 'pf1', 'Posizione fisiografica non inserita');
        
        $ap = $this->a->getData('ap');
        if ($ap != '') $ap = ' ad un\'altitudine prevalente di '.$ap. ' metri'.$this->getNote('a', 'ap');
        else $this->addIssue('a', 'pf1','Altitudine prevalente non inserita');
        
        $e1 = $this->getValue('a','e1', $this->a->getData('e1'));
        if ($e1 != '') $e1 = ' esposizione prevalente '.$e1.$this->getNote('a', 'e1');
        else $this->addIssue('a', 'e1','Esposizione prevalente non inserita');
        
        $pp = $this->getValue('a','pp', $this->a->getData('pp'));
        if ($pp != '') $pp = ' pendenza prevalente '.$e1.$this->getNote('a', 'pp');
        else $this->addIssue('a', 'pp','Pendenza prevalente non inserita');
        
        $description .= <<<EOT
Particella {$this->a->getData('proprieta')} {$this->a->getData('toponimo')} {$this->a->getData('sup_tot')} ha
Fattori ambientali e di gestione
{$pf1}{$ap}{$e1}{$pp}
EOT;
                
        
        return nl2br($description);
    }
    /**
     * Gets the associated label of a control
     * @param string $form form name
     * @param string $field field name
     * @param mixed $codice code value
     * @return string associated label
     */
    private function getValue ($form,$field,$codice) {
        $table = \forest\template\ControlColl::getTable($form,$field);
        $control = new \forest\template\ControlColl($table);
        try {
        $control->loadAll(array('codice'=>$codice));
        } catch (\Exception $e) {
            if ($e->getCode() != 1303041646) throw $e;
        }
        $control = $control->getFirst();
        return $control->getData('descriz');
    }
    /**
     * Adds a new issue
     * @param string $form
     * @param string $field
     * @param string $text
     */
    private function addIssue ($form, $field, $text) {
        $this->issues[$form][$field]=$text;
    }
    /**
     * get the note associated with a field
     * @param string $form
     * @param string $field
     * @return string
     */
    private function getNote($form, $field) {
         $note = new \forest\attribute\note\AColl();
         $note->setForm($this->a);
         $note->loadAll(array('field'=>$field));
         $note = $note->getFirst();      
         return $note->getData('nota');
    }
 }