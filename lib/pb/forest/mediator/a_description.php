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
        $this->t['a']['a'] = '';
        foreach ($terrain_assets as $key => $terrain_asset) {
            if (key_exists($this->a->getData('a'.$key),$terrain_labels)) {
                $this->t['a']['a'.$key] .= $terrain_labels[$this->a->getData('a'.$key)];
                $this->t['a']['a'.$key] .= $terrain_asset.', ';
            }
        }
        $this->t['a']['a'] .= $this->getNote('a', 'a2');
        
        $water_remain_labels = array(
                  1 => ' su meno del 30% della superficie',
                  2 => ' su di una superficie compresa fra il 30 e il 60% del totale',
                  3 => ' su più del 60% della superficie'
        );
        $water_remain_assets = array(
                  2 => ' terreno superficiale',
                  3 => ' rocce affioranti',
                  4 => ' pietrosità',
                  5 => ' ristagni d\'acqua'
        );
        $this->t['a']['r'] = '';
        foreach ($water_remain_assets as $key => $water_asset) {
            if (key_exists($this->a->getData('r'.$key),$water_remain_labels)) {
                if ($this->t['a']['r'] == '')
                    $this->t['a']['r'] = 'Possibili limitazioni allo sviluppo dell\'apparato radicale per la presenza di ';
                $this->t['a']['r'] .= $water_asset.$water_remain_labels[$this->a->getData('r'.$key)].', ';
            }
        }
        
        $phitosanitary_labels = array(
            1 => ' pericolo di peggioramento della situazione fitosanitaria dovuto a',
            2 => ' danni lievi causati da',
            3 => 'danni gravi causati da',
            4 => ' danni molto gravi causati da'
        );
        $phitosanitary_assets = array(
           2 => ' sovrapascolamento',
           3 => ' selvatici',
           4 => ' agenti fitopatogeni e parassiti',
           5 => ' agenti meteorici',
           6 => ' movimenti di neve',
           7 => ' incendio',
           8 => ' utilizzazioni',
           9 => ' movimenti di terra',
          10 => ' attività turistico-ricreative',
          11 =>''
        );
        $this->t['a']['f'] = '';
        foreach ($phitosanitary_assets as $key => $phitosanitary_asset) {
            if (key_exists($this->a->getData('f'.$key),$phitosanitary_labels)) {
                $this->t['a']['f'] .= $phitosanitary_asset.$phitosanitary_labels[$this->a->getData('f'.$key)].', ';
            }
        }
        $this->t['a']['f'] .= $this->getNote('a', 'f2');
        
        $particular_assets = array(
               2 => ' pascolo in bosco',
               3 => ' emergenze storico-naturalistiche',
               4 => ' sorgenti, fonti',
               5 => ' sottoposta a usi civici',
               6 =>''
        );
        $this->t['a']['p'] = '';
        foreach ($particular_assets as $key => $particular_asset) {
            if ($key == 2) {
                switch ($this->a->getData('p'.$key)) {
                     case 1 :
                          $this->t['a']['p'] .= $particular_asset.' di bovini';
                     break;
                     case 2 :
                          $this->t['a']['p'] .= $particular_asset.' di ovini';
                     break;
                     case 3:
                          $this->t['a']['p'] .= $particular_asset.' di equini';
                     break;
                     case 4:
                          $this->t['a']['p'] .= $particular_asset.' di caprini';
                     break;
                     case 5:
                          $this->t['a']['p'] .= $particular_asset.$this->a->getData('p9');
                     break;
                }
            }
            else if ($this->a->getData('p'.$key) == 1) {
                $this->t['a']['p'] .= $particular_asset.', ';
            }
        }
        if ($this->t['a']['p'] == '')
            $this->t['a']['p'] = 'Assenza di fatti particlolari';
        else {
            $this->t['a']['p'] = 'Fatti particlolari: '.$this->t['a']['p'];
            $this->t['a']['p'] .= $this->getNote('a', 'p2');
        }
        

        $manufacts_assets = array(
            2  => ' strade camionabili',
            3  => ' strade trattorabili',
            4  => ' piste forestali',
            5  => ' edifici',
            6  => ' sistemazioni',
            7  => ' gradonamenti',
            8  => ' muri - recinzioni',
            9  => ' paravalanghe',
            10 => ' elettrodotti',
            11 => ' cesse parafuoco',
            12 => ' tracciati teleferiche',
            13 => ' condotte idriche',
            14 => ' parcheggi',
            15 => ' cave',
            16 => ' sentieri guidati',
            17 => ' piste-impianti sciistici',
            18 => '',
            20 => ' piazzali-buche di carico',
            21 => ' strade camionabili',
            22 => ' tracciati per mezzi agricoli minori',
            23 => ' aree sosta'
        );
        $this->t['a']['m'] = '';
        foreach ($manufacts_assets as $key => $manufacts_asset) {
            if (key_exists($this->a->getData('m'.$key),$phitosanitary_labels)) {
                $this->t['a']['m'] .= $manufacts_asset.', ';
            }
        }
        if ($this->t['a']['m'] != '') {
            $this->t['a']['m'] = 'Presenti '.$this->t['a']['m'];
            $this->t['a']['m'] .= $this->getNote('a', 'm2');
        }
        
        
        $description .= <<<EOT
Particella {$this->a->getData('proprieta')} {$this->a->getData('toponimo')} {$this->a->getData('sup_tot')} ha
Fattori ambientali e di gestione
{$this->t['a']['pf1']}{$this->t['a']['ap']}{$this->t['a']['e1']}{$this->t['a']['pp']}{$this->t['a']['o']}
{$this->t['a']['a']}{$this->t['a']['r']}{$this->t['a']['f']}{$this->t['a']['p']}{$this->t['a']['m']}
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