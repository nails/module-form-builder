<?php

/**
 * This class provides the "Time" field type
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

class Time extends Base
{
    const LABEL             = 'Time';
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
        $sOut .= get_instance()->load->view('formbuilder/fields/body-time', $aData, true);
        $sOut .= get_instance()->load->view('formbuilder/fields/close', $aData, true);

        return $sOut;
    }

    // --------------------------------------------------------------------------

    /**
     * Validate and clean the user's entry
     * @param  mixed    $mInput The form input's value
     * @param  stdClass $oField The complete field object
     * @return mixed
     */
    public function validate($mInput, $oField)
    {
        $mInput = parent::validate($mInput, $oField);

        try {

            $oDate = new \DateTime($mInput);

            if (empty($oDate)) {
                throw new FieldTypeException('This field should be a valid time.', 1);
            }

        } catch (\Exception $e) {
            throw new FieldTypeException('This field should be a valid time.', 1);
        }

        return empty($oDate) ? null : $oDate->format('H:i:s');
    }
}
