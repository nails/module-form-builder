<?php

/**
 * This class provides a base for the different default values available
 *
 * @package     Nails
 * @subpackage  module-form-builder
 * @category    Controller
 * @author      Nails Dev Team
 * @link
 */

namespace Nails\FormBuilder\DefaultValue;

use Nails\FormBuilder\Interfaces\DefaultValue;

/**
 * Class Base
 *
 * @package Nails\FormBuilder\DefaultValue
 */
abstract class Base implements DefaultValue
{
    /**
     * The human friendly label to give this default value
     *
     * @var string
     */
    const LABEL = '';

    // --------------------------------------------------------------------------

    /**
     * Returns the default value's label
     *
     * @return string
     */
    public static function getLabel(): string
    {
        return static::LABEL;
    }
}
