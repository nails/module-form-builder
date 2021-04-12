<?php

/**
 * This class provides the "Select" field type
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
 * Class Select
 *
 * @package Nails\FormBuilder\FormBuilder\FieldType
 */
class Select extends Base
{
    const LABEL            = 'Dropdown';
    const SUPPORTS_OPTIONS = true;
    const RENDER_VIEWS      = [
        'formbuilder/fields/open',
        'formbuilder/fields/body-select',
        'formbuilder/fields/close',
    ];

    // --------------------------------------------------------------------------

    /**
     * Validate the user's entry
     *
     * @param  mixed $mInput The form input's value
     * @param  Field $oField The complete field object
     *
     * @throws FieldTypeException
     * @return boolean|string   boolean true if valid, string with error if invalid
     */
    public function validate($mInput, Field $oField)
    {
        $mInput = parent::validate($mInput, $oField);

        //  The parent won't catch "empty" fields, i.e the field option has an ID but the label is blank
        //  For a UX perspective, let's assume an empty label is an empty response.

        if ($mInput && $oField->is_required) {
            foreach ($oField->options->data as $oOption) {
                if ((int) $mInput === $oOption->id) {
                    if (empty($oOption->label)) {
                        throw new FieldTypeException('Please choose a valid option.', 1);
                    }
                }
            }
        }

        return $mInput;
    }
}
