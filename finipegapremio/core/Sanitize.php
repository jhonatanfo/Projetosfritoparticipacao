<?php
/**
 * Classe que contem os métodos que iram
 * filtrar as entradas enviadas via GET e POST
 *
 * @filesource
 * @author      Pedro Elsner <pedro.elsner@gmail.com>
 * @license     http://creativecommons.org/licenses/by/3.0/br/ Creative Commons 3.0
 * @abstract
 * @version     1.0
 */
abstract class Sanitize {
 
/**
 * Filter
 * 
 * @param  mixed $value
 * @param  array $modes
 * @return mixed
 * @static
 * @since  1.0
 */
    static public function filter($value, $modes = array('sql', 'html')) {
 
        if (!is_array($modes)) {
            $modes = array($modes);
        }
 
        if (is_string($value)) {
            foreach ($modes as &$type) {
              $value = self::_doFilter($value, $type);
            }
            return $value;
        }
 
        foreach ($value as $key => &$toSanatize) {
            if (is_array($toSanatize)) {
                $value[$key]= self::filter($toSanatize, $modes,$key);
            } else {
                foreach ($modes as &$type) {
                  $value[$key] = self::_doFilter($toSanatize, $type,$key);
                }
            }
        }
        return $value;
    }
 
/**
 * DoFilter
 * 
 * @param  mixed $value
 * @param  array $modes
 * @return mixed
 * @static
 * @since  1.0
 */
    static protected function _doFilter($value, $mode,$key) {
 
        switch ($mode) {
            case 'html':
                $value = strip_tags($value,'<br><b>');
                $value = addslashes($value);
                $value = htmlspecialchars($value, ENT_QUOTES);
                break;

            case 'sql':
                $value = preg_replace('/(from|select|insert|database|delete|where|drop table|show tables|#|\*|\\\\)/i','',$value);
                $value = trim($value);
                break;
        }
        //var_dump($key,$mode);
        return $value;
    }
    
}