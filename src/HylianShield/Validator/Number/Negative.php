<?php
/**
 * Validate negative numbers.
 *
 * @package HylianShield
 * @subpackage Validator
 * @copyright 2013 Jan-Marten "Joh Man X" de Boer
 */

namespace HylianShield\Validator\Number;

/**
 * Negative.
 */
class Negative extends \HylianShield\Validator\Number
{
    /**
     * The type.
     *
     * @var string $type
     */
    protected $type = 'number_negative';

    /**
     * The minimum length of the value.
     *
     * @var integer|float $minLength
     */
    protected $minLength = 0;

    /**
     * The maximum length of the value.
     *
     * PHP normally uses a precision of the IEEE 754 double precision format.
     * @see http://php.net/manual/en/language.types.float.php
     *
     * @var integer|float $maxLength
     */
    protected $maxLength = -1e-16;

    /**
     * Define the ability to overload the range while constucting the object.
     *
     * @var boolean $canOverloadRange
     */
    protected $canOverloadRange = false;
}
