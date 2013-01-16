<?php
/**
 * @author Claudio Fior <caiofior@gmail.com>
 * @copyright CRA
 * Util functions
 */
/**
 * @author Claudio Fior <caiofior@gmail.com>
 * @copyright CRA
 * Replaces special chard with ASCII codes
 * @param string $string original string
 * @param bool $not_tags id true the tags are not encoded
 * @return string encoded string
 */
function xml__specialchars($string,$not_tags=false){
    if (function_exists('mb_convert_encoding'))
        $string = mb_convert_encoding($string, 'ISO-8859-1', 'UTF-8');
    $xml_entities = array(
        128 => '&#8364;',
        129 => '',
        130 => '&#8218;',
        131 => '&#402;',
        132 => '&#8222;',
        133 => '&#8230;',
        134 => '&#8224;',
        135 => '&#8225;',
        136 => '&#94;',
        137 => '&#8240;',
        138 => '&#352;',
        139 => '&#60;',
        140 => '&#338;',
        141 => '',
        142 => 'Z',
        143 => '',
        144 => '',
        145 => '&#8216;',
        146 => '&#8220;',
        147 => '&#8220;',
        148 => '&#8221;',
        149 => '&#8226;',
        150 => '&#8211;',
        151 => '&#8212;',
        152 => '&#126;',
        153 => '&#8482;',
        154 => '&#352;',
        155 => '&#62;',
        156 => '&#339;',
        157 => '',
        158 => 'Z',
        159 => '&#376;'
    );
    $encoded = '';
    for ($n = 0; $n < strlen($string); $n++) {
        $ord = ord($string[$n]);
        if ($ord == 13 || $ord == 9 || $ord == 10)
            continue;
        if (
                ($ord >= 32 && $ord <= 122) &&
                (($ord != 34 && $ord != 38 && $ord != 39 && $ord != 60 && $ord != 62) || $not_tags)
        )
            $encoded .= $string[$n];
        elseif (key_exists($ord, $xml_entities))
            $encoded .= $xml_entities[$ord];
        else
            $encoded .= "&#" . $ord . ";";
    }
    return $encoded;
}