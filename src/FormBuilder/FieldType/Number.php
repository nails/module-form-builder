<?php

/**
 * This class provides the "Number" field type
 *
 * @package     Nails
 * @subpackage  module-form-builder
 * @category    Controller
 * @author      Nails Dev Team
 * @link
 */

namespace Nails\FormBuilder\FormBuilder\FieldType;

use Nails\Factory;
use Nails\FormBuilder\Exception\FieldTypeException;
use Nails\FormBuilder\FieldType\Base;
use Nails\FormBuilder\Resource\Form\Field;

/**
 * Class Number
 *
 * @package Nails\FormBuilder\FormBuilder\FieldType
 */
class Number extends Base
{
    const LABEL                = 'Number';
    const SUPPORTS_DEFAULTS    = true;
    const SUPPORTS_PLACEHOLDER = false;
    const RENDER_VIEWS         = [
        'formbuilder/fields/open',
        'formbuilder/fields/body-number',
        'formbuilder/fields/close',
    ];

    // --------------------------------------------------------------------------

    /**
     * Validate the user's entry
     *
     * @param mixed $mInput The form input's value
     * @param Field $oField The complete field object
     *
     * @throws FieldTypeException
     * @return boolean|string   boolean true if valid, string with error if invalid
     */
    public function validate($mInput, Field $oField)
    {
        $mInput = parent::validate($mInput, $oField);

        if (!is_numeric($mInput)) {
            throw new FieldTypeException('This field should be numeric.', 1);
        }

        return $mInput;
    }
}
