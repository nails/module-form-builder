<?php

/**
 * This class provides the "Hidden" field type
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

class Hidden extends Base
{
    const LABEL = 'Hidden';
    const SUPPORTS_DEFAULTS = true;

    // --------------------------------------------------------------------------

    /**
     * Renders the field's HTML
     *
     * @param  array $aData The field's data
     * @return string
     */
    public function render($aData)
    {
        $oView = Factory::service('View');

        return $oView->load('formbuilder/fields/body-hidden', $aData, true);
    }
}
