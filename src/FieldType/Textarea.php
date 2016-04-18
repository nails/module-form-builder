<?php

/**
 * This class provides the "Textarea" field type
 *
 * @package     Nails
 * @subpackage  module-form-builder
 * @category    Controller
 * @author      Nails Dev Team
 * @link
 */

namespace Nails\FormBuilder\FieldType;

use Nails\Factory;

class Textarea extends Base
{
    const LABEL             = 'Textarea';
    const SUPPORTS_DEFAULTS = true;

    // --------------------------------------------------------------------------

    /**
     * Renders the field's HTML
     * @param  $aData The field's data
     * @return string
     */
    public function render($aData)
    {
        $sOut  = get_instance()->load->view('formbuilder/fields/open', $aData);
        $sOut .= get_instance()->load->view('formbuilder/fields/body-textarea', $aData);
        $sOut .= get_instance()->load->view('formbuilder/fields/close', $aData);

        return $sOut;
    }

    // --------------------------------------------------------------------------

    /**
     * Clean the user's input into a string (or array of strings) suitable for humans browsing in admin
     * @param  mixed    $mInput The form input's value
     * @param  stdClass $oField The complete field object
     * @return mixed
     */
    public function clean($mInput, $oField)
    {
        return auto_typography($mInput);
    }
}
