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
     * Text lines composing the description
     * @var array
     */
    private $t=array();
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
        
        $this->t['a']['pf1'] = $this->getValue('a','pf1', $this->a->getData('pf1'));
        if ($this->t['a']['pf1'] != '') $this->t['a']['pf1'] = 'Posta '.$this->t['a']['pf1'].$this->getNote('a', 'pf1');
        else $this->addIssue('a', 'pf1', 'Posizione fisiografica non inserita');
        
        $this->t['a']['ap'] = $this->a->getData('ap');
        if ($this->t['a']['ap'] != '') $this->t['a']['ap'] = ' ad un\'altitudine prevalente di '.$this->t['a']['ap']. ' metri'.$this->getNote('a', 'ap');
        else $this->addIssue('a', 'pf1','Altitudine prevalente non inserita');
        
        $this->t['a']['e1'] = $this->getValue('a','e1', $this->a->getData('e1'));
        if ($this->t['a']['e1'] != '') $this->t['a']['e1'] = ' esposizione prevalente '.$this->t['a']['e1'].$this->getNote('a', 'e1');
        else $this->addIssue('a', 'e1','Esposizione prevalente non inserita');
        
        $this->t['a']['pp'] = $this->a->getData('pp');
        if ($this->t['a']['pp'] != '') $this->t['a']['pp'] = ' pendenza prevalente del '.$this->t['a']['pp'].' % '.$this->getNote('a', 'pp');
        else $this->addIssue('a', 'pp','Pendenza prevalente non inserita');
        
        $this->t['a']['o'] = '';
        switch ($this->a->getData('o')) {
           case 1 :
                $this->t['a']['o'] = ', accidentalità debole'.$this->getNote('a', 'o');
           break;
           case 2 :
                $this->t['a']['o'] = ', accidentalità media'.$this->getNote('a', 'o');
           break;
           case 3:
                $this->t['a']['o'] = ', accidentalità forte'.$this->getNote('a', 'o');
           break;
           case 4:
                $this->t['a']['o'] = ', accidentalità molto forte'.$this->getNote('a', 'o');
           break;
           default:
               $this->addIssue('a', 'o','Ostacoli agli interventi non inseriti');
           break;
        }
        
        
        $terrain_labels = array(
               1 => ' pericolo di peggioramento della situazione di dissesto causato da',
               2 => ' alcuni contenuti problemi di dissesto legati alla presenza di',
               3 => ' grave dissesto dovuto a',
               4 => ' dissesto molto grave imputabile a'
        );
        $terrain_assets = array(
               2 => ' erosione superficiale - incanalata',
               3 => ' erosione catastrofica - calanchiva',
               4 => ' frane superficiali',
               5 => ' frane di profondità - crolli',
               6 => ' rotolamento massi',
               7 => ' '.$this->a->getData('a8')
        );
        foreach ($terrain_assets as $key => $terrain_asset) {
            if (key_exists($this->a->getData('a'.$key),$terrain_labels)) {
                if ($this->t['a']['a'.$key] == '')
                    $this->t['a']['a'.$key] = $terrain_labels[$this->a->getData('a'.$key)];
                $this->t['a']['a'.$key] .= $terrain_asset[$key].', ';
            }
            else
                $this->t['a']['a'.$key] = '';
        }
        $this->t['a']['a'.$key] .= $this->getNote('a', 'a2');
        
        
        $description .= <<<EOT
Particella {$this->a->getData('proprieta')} {$this->a->getData('toponimo')} {$this->a->getData('sup_tot')} ha
Fattori ambientali e di gestione
{$this->t['a']['pf1']}{$this->t['a']['ap']}{$this->t['a']['e1']}{$this->t['a']['pp']}{$this->t['a']['o']}
{$this->t['a']['a2']}{$this->t['a']['a3']}{$this->t['a']['a4']}{$this->t['a']['a5']}{$this->t['a']['a6']}{$this->t['a']['a7']}
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