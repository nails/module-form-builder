<?php

/**
 * This class provides the "Email" field type
 *
 * @package     Nails
 * @subpackage  module-form-builder
 * @category    Controller
 * @author      Nails Dev Team
 * @link
 */

namespace Nails\FormBuilder\FormBuilder\FieldType;

use Nails\FormBuilder\Exception\FieldTypeException;
use Nails\FormBuilder\FieldType\Base;

/**
 * Class Email
 *
 * @package Nails\FormBuilder\FormBuilder\FieldType
 */
class Email extends Base
{
    const LABEL             = 'Email';
    const SUPPORTS_DEFAULTS = true;
    const RENDER_VIEWS      = [
        'formbuilder/fields/open',
        'formbuilder/fields/body-email',
        'formbuilder/fields/close',
    ];

    // --------------------------------------------------------------------------

    /**
     * Validate the user's entry
     *
     * @param mixed     $mInput The form input's value
     * @param \stdClass $oField The complete field object
     *
     * @throws FieldTypeException
     * @return boolean|string   boolean true if valid, string with error if invalid
     */
    public function validate($mInput, $oField)
    {
        $mInput = parent::validate($mInput, $oField);

        if (!valid_email($mInput)) {
            throw new FieldTypeException('This field should be a valid email.', 1);
        }

        return $mInput;
    }
}
