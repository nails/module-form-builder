<?php

/**
 * This class provides the "Cpatcha" field type
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

class Captcha extends Base
{
    const LABEL = 'Captcha';
    const SUPPORTS_OPTIONS = false;
    const SUPPORTS_DEFAULTS = false;
    const IS_SELECTABLE = false;

    // --------------------------------------------------------------------------

    /**
     * Renders the field's HTML
     *
     * @param  array $aData The field's data
     * @return string
     */
    public function render($aData)
    {
        if (empty($aData['captcha'])) {
            return '';
        }

        $oView = Factory::service('View');
        $sOut  = $oView->load('formbuilder/fields/open', $aData, true);
        $sOut .= $oView->load('formbuilder/fields/body-captcha', $aData, true);
        $sOut .= $oView->load('formbuilder/fields/close', $aData, true);

        return $sOut;
    }
}
