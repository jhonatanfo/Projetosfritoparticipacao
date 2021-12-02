<?php
/**
 * Facilitador de acesso as funções matemáticas
 * Para programadores que vierem de outras linguagens
 * 
 * @author jasiel Macedo <jasielmacedo@gmail.com>
 * @version 1.0
 * 
 */

defined("SSX") or die;

class Math
{
	/**
	 * Rounds a float
	 * @link http://php.net/manual/en/function.round.php
	 * @param val float The value to round
	 * @param precision int[optional]
	 * @param mode int[optional] One of PHP_ROUND_HALF_UP,PHP_ROUND_HALF_DOWN,PHP_ROUND_HALF_EVEN, or PHP_ROUND_HALF_ODD.
	 * @return float The rounded value
	 */
	public static function Round($float, $precision=null, $mode=null){ return round($float, $precision, $mode); }
	
	/**
	 * Round fractions up
	 * @link http://php.net/manual/en/function.ceil.php
	 * @param float float <p>
	 * The value to round
	 * </p>
	 * @return float value rounded up to the next highest
	 * integer.
	 * The return value of ceil is still of type
	 * float as the value range of float is 
	 * usually bigger than that of integer.
	 */
	public static function Ceil($float){ return ceil($float); }
	
	/**
	 * Round fractions down
	 * @link http://php.net/manual/en/function.floor.php
	 * @param float float <p>
	 * The numeric value to round
	 * </p>
	 * @return float value rounded to the next lowest integer.
	 * The return value of floor is still of type
	 * float because the value range of float is 
	 * usually bigger than that of integer.
	 */
	public static function Floor($float){ return floor($float); }
	
	/**
	 * Absolute value
	 * @link http://php.net/manual/en/function.abs.php
	 * @param number mixed <p>
	 * The numeric value to process
	 * </p>
	 * @return number The absolute value of number. If the
	 * argument number is
	 * of type float, the return type is also float,
	 * otherwise it is integer (as float usually has a
	 * bigger value range than integer).
	 */
	public static function Abs($number){ return abs($number); }
	
	/**
	 * Arc tangent
	 * @link http://php.net/manual/en/function.atan.php
	 * @param arg float <p>
	 * The argument to process
	 * </p>
	 * @return float The arc tangent of arg in radians.
	 */
	public static function Atan($arg){ return atan($arg); }
	
	/**
	 * Arc tangent of two variables
	 * @link http://php.net/manual/en/function.atan2.php
	 * @param y float <p>
	 * Dividend parameter
	 * </p>
	 * @param x float <p>
	 * Divisor parameter
	 * </p>
	 * @return float The arc tangent of y/x 
	 * in radians.
	 */
	public static function Atan2($x, $y){ return atan2($x,$y); }
	
	/**
	 * Tangent
	 * @link http://php.net/manual/en/function.tan.php
	 * @param arg float <p>
	 * The argument to process in radians 
	 * </p>
	 * @return float The tangent of arg
	 */
	public static function Tan($arg){ return tan($arg); }
	
	/**
	 * Cosine
	 * @link http://php.net/manual/en/function.cos.php
	 * @param radius float <p>
	 * An angle in radians 
	 * </p>
	 * @return float The cosine of arg
	 */
	public static function Cos($radius){ return cos($radius); }
	
	/**
	 * Arc cosine
	 * @link http://php.net/manual/en/function.acos.php
	 * @param arg float <p>
	 * The argument to process
	 * </p>
	 * @return float The arc cosine of arg in radians.
	 */
	public static function ACos($arg){ return acos($arg); }
	
	/**
	 * Sine
	 * @link http://php.net/manual/en/function.sin.php
	 * @param radius float <p>
	 * A value in radians
	 * </p>
	 * @return float The sine of arg
	 */
	public static function Sin($radius){ return sin($radius); }
}