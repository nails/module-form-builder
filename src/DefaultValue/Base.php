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

class Base
{
    /**
     * The human friendly label to give this field type
     * @var string
     */
    const LABEL = '';

    // --------------------------------------------------------------------------

    /**
     * Return the calculated default value
     * @return mixed
     */
    public function defaultValue()
    {
        return null;
    }
}
