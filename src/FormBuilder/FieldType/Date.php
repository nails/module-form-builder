<?php

/**
 * This class provides the "Date" field type
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
use Nails\FormBuilder\Resource\Form\Field;

/**
 * Class Date
 *
 * @package Nails\FormBuilder\FormBuilder\FieldType
 */
class Date extends Base
{
    const LABEL                = 'Date';
    const SUPPORTS_DEFAULTS    = true;
    const SUPPORTS_PLACEHOLDER = false;
    const RENDER_VIEWS         = [
        'formbuilder/fields/open',
        'formbuilder/fields/body-date',
        'formbuilder/fields/close',
    ];

    // --------------------------------------------------------------------------

    /**
     * Validate and clean the user's entry
     *
     * @param mixed $mInput The form input's value
     * @param Field $oField The complete field object
     *
     * @throws FieldTypeException
     * @return mixed
     */
    public function validate($mInput, Field $oField)
    {
        $mInput = parent::validate($mInput, $oField);

        try {

            $oDate = new \DateTime($mInput);

            if (empty($oDate)) {
                throw new FieldTypeException('This field should be a valid date.', 1);
            }

        } catch (\Exception $e) {
            throw new FieldTypeException('This field should be a valid date.', 1);
        }

        return empty($oDate) ? null : $oDate->format('Y-m-d');
    }
}
