<?php
/**
 * @author Claudio Fior <caiofior@gmail.com>
 * @copyright CRA
 * Manages form errors
 */
/**
 * @author Claudio Fior <caiofior@gmail.com>
 * @copyright CRA
 * Manages form errors
 */
class FormErrors {
    /**
     *Errors
     * @var array
     */
    private $errors = array();
    /**
     * Custom error
     */
    const custom=0;
    /**
     * The variable is required
     */
    const required =1;
    /**
     * The email is invalid
     */
    const valid_email = 2;
    /**
     * The data is wrong
     */
    const wrong = 3;
    /**
     * The url is invalid
     */
    const valid_url = 4;
    /**
     * The url is invalid
     */
    const valid_int = 5;
    /**
     * The url is invalid
     */
    const valid_float = 6;
    /**
     * The url is invalid
     */
    const valid_bool = 7;
    /**
     * Default error assertions
     * @var array
     */
    private $default_messages = array(
        1 => array(
            1=> array('m'=>' è richiesto','f'=>' è richiesta'),
            2=> array('m'=>' sono richiesti','f'=>' sono richieste'),
        ),
        2 => array(
            1=> array('m'=>' deve essere una mail valida','f'=>' deve essere una mail valida'),
            2=> array('m'=>' devono essere delle mail valide','f'=>' devono essere delle mail valide'),
        ),
        3 => array(
            1=> array('m'=>' è errato','f'=>' è errata'),
            2=> array('m'=>' sono errati','f'=>' sono errate')
        ),
        4 => array(
            1=> array('m'=>' deve essere un indirizzo valido','f'=>' deve essere un indirizzo valido'),
            2=> array('m'=>' devono essere indirizzi validi','f'=>' devono essere indirizzi validi')
        ),
        5 => array(
            1=> array('m'=>' deve essere un numero intero','f'=>' deve essere un numero intero'),
            2=> array('m'=>' devono essere numeri interi','f'=>' devono essere numeri interi')
        ),
        6 => array(
            1=> array('m'=>' deve essere un numero con punto','f'=>' deve essere un numero con punto'),
            2=> array('m'=>' devono essere un numero con punto','f'=>' devono essere un numero con punto')
        ),
        7 => array(
            1=> array('m'=>' deve essere vero o falso','f'=>' deve essere vero o falso'),
            2=> array('m'=>' devono essere vero o falso','f'=>' devono essere vero o falso')
        ),
    );

    /**
     * Adds an error to le list
     * @param int $kind is a constant of this class
     * @param string $name field control name
     * @param string $message message, if custom all the message must be set
     * @param string $sex sex of the word (m or f)
     */
    public function add_error($kind, $name,$message=null,$sex='m') {
        if ($sex != 'f') $sex != 'm';
        if (!key_exists($kind, $this->errors) || !is_array($this->errors[$kind])) $this->errors[$kind] = array();
        $this->errors[$kind][]=array('name'=>$name,'message'=>$message,'sex'=>$sex);
    }

    /**
     * Counts all errors;
     * @return int
     */
    public function count() {
        $count = 0;
        foreach ($this->errors as $error_kind) {
            $count += sizeof($error_kind);
        }
        return $count;
    }

    /**
     * Return control field name and messages
     * @return array[]
     */
    public function get_messages() {
        if ($this->count() == 0) return true;
        $messages = array();
        $names= array();
        for ($c = 1; $c < 8; $c++) {
            if (!key_exists($c,$this->errors) || !is_array($this->errors[$c])) continue;

            if (sizeof($this->errors[$c]) == 1) $plu = 1;
            else $plu = 2;
            $sex = 'f';

            $message = '';
            foreach($this->errors[$c] as $prog=>$error_item) {
                if ($prog == 0) $error_item['message'] = ucfirst ($error_item['message']);
                $names[] =$error_item['name'];
                $message .= $error_item['message'];
                if (sizeof($this->errors[$c])-2 == $prog) $message.=' e ';
                elseif (sizeof($this->errors[$c])-2 > $prog) $message.=', ';
                if ($error_item['sex'] == 'm') $sex = 'm';
            }
            $messages[] = xml__specialchars($message.$this->default_messages[$c][$plu][$sex].'.',true);
        }
        if (key_exists(0,$this->errors) && is_array($this->errors[0])) {
            foreach($this->errors[0] as $error_item) {
                $names[] =$error_item['name'];
                if (!is_null($error_item['message']))
                    $messages[] = xml__specialchars($error_item['message'],true);
            }
        }
        array_unique($names);
        return array(
                'names'=>$names,
                'messages'=>$messages
            );
    }
    /**
     * Creates a json error message
     */
    public function get_json_error () {
        header('Content-type: application/json');
        $response = true;
        if ($this->count()>0)
            $response = $this->get_messages();
        echo Zend_Json::encode($response);
        exit;
    }

    public function get_html_error () {
        $messages = $this->get_messages();
        if (is_array($messages))
                foreach($messages['messages'] as $error_item) echo '<p>'.$error_item.'</p>';
    }

}

