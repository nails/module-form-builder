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

class Number extends Base
{
    const LABEL             = 'Number';
    const SUPPORTS_DEFAULTS = true;

    // --------------------------------------------------------------------------

    /**
     * Renders the field's HTML
     *
     * @param  array $aData The field's data
     *
     * @return string
     */
    public function render($aData)
    {
        $oView = Factory::service('View');
        $sOut  = $oView->load('formbuilder/fields/open', $aData, true);
        $sOut  .= $oView->load('formbuilder/fields/body-number', $aData, true);
        $sOut  .= $oView->load('formbuilder/fields/close', $aData, true);

        return $sOut;
    }

    // --------------------------------------------------------------------------

    /**
     * Validate the user's entry
     *
     * @param  mixed     $mInput The form input's value
     * @param  \stdClass $oField The complete field object
     *
     * @throws FieldTypeException
     * @return boolean|string   boolean true if valid, string with error if invalid
     */
    public function validate($mInput, $oField)
    {
        $mInput = parent::validate($mInput, $oField);

        if (!is_numeric($mInput)) {
            throw new FieldTypeException('This field should be numeric.', 1);
        }

        return $mInput;
    }
}
