<?php

/**
 * This class provides the "Password" field type
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

class Password extends Base
{
    const LABEL             = 'Password';
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
        $sOut  .= $oView->load('formbuilder/fields/body-password', $aData, true);
        $sOut  .= $oView->load('formbuilder/fields/close', $aData, true);

        return $sOut;
    }
}
