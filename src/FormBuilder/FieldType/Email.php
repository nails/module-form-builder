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

use Nails\Factory;
use Nails\FormBuilder\FieldType\Base;
use Nails\FormBuilder\Exception\FieldTypeException;

class Email extends Base
{
    const LABEL             = 'Email';
    const SUPPORTS_DEFAULTS = true;

    // --------------------------------------------------------------------------

    /**
     * Renders the field's HTML
     * @param  $aData The field's data
     * @return string
     */
    public function render($aData)
    {
        $sOut  = get_instance()->load->view('formbuilder/fields/open', $aData, true);
        $sOut .= get_instance()->load->view('formbuilder/fields/body-email', $aData, true);
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
        $mInput = parent::validate($mInput, $oField);

        if (!valid_email($mInput)) {
            throw new FieldTypeException('This field should be a valid email.', 1);
        }

        return $mInput;
    }
}
