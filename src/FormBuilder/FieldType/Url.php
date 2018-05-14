<?php

/**
 * This class provides the "Url" field type
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

class Url extends Base
{
    const LABEL             = 'URL';
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
        $sOut  .= $oView->load('formbuilder/fields/body-url', $aData, true);
        $sOut  .= $oView->load('formbuilder/fields/close', $aData, true);

        return $sOut;
    }

    // --------------------------------------------------------------------------

    /**
     * Validate and clean the user's entry
     *
     * @param  mixed     $mInput The form input's value
     * @param  \stdClass $oField The complete field object
     *
     * @return mixed
     */
    public function validate($mInput, $oField)
    {
        $mInput = parent::validate($mInput, $oField);

        return empty($mInput) ? null : prep_url($mInput);
    }
}
