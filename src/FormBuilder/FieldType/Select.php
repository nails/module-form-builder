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
use Nails\FormBuilder\FieldType\Base;
use Nails\FormBuilder\Exception\FieldTypeException;

class Select extends Base
{
    const LABEL            = 'Dropdown';
    const SUPPORTS_OPTIONS = true;

    // --------------------------------------------------------------------------

    /**
     * Renders the field's HTML
     * @param  $aData The field's data
     * @return string
     */
    public function render($aData)
    {
        $sOut  = get_instance()->load->view('formbuilder/fields/open', $aData, true);
        $sOut .= get_instance()->load->view('formbuilder/fields/body-select', $aData, true);
        $sOut .= get_instance()->load->view('formbuilder/fields/close', $aData, true);

        return $sOut;
    }

    // --------------------------------------------------------------------------

    /**
     * Validate the user's entry
     * @param  mixed    $mInput The form input's value
     * @param  stdClass $oField The complete field object
     * @return boolean|string   boolean true if valid, string with error if invalid
     */
    public function validate($mInput, $oField)
    {
        $bResult = parent::validate($mInput, $oField);

        //  The parent won't catch "empty" fields, i.e the field option has an ID but the label is blank
        //  For a UX perspective, let's assume an empty label is an empty response.

        if ($bResult && $oField->is_required) {
            foreach ($oField->options->data as $oOption) {
                if ((int) $mInput === $oOption->id) {
                    if (empty($oOption->label)) {
                        throw new FieldTypeException('Please choose a valid option.', 1);
                    }
                }
            }
        }

        return $bResult;
    }
}
