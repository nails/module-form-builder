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

namespace Nails\FormBuilder\FieldType;

use Nails\Factory;

class Url extends Base
{
    const LABEL             = 'URL';
    const SUPPORTS_DEFAULTS = true;
    const VALIDATION_RULES  = 'prep_url';

    // --------------------------------------------------------------------------

    /**
     * Renders the field's HTML
     * @param  $aData The field's data
     * @return string
     */
    public function render($aData)
    {
        $sOut  = get_instance()->load->view('formbuilder/fields/open', $aData);
        $sOut .= get_instance()->load->view('formbuilder/fields/body-url', $aData);
        $sOut .= get_instance()->load->view('formbuilder/fields/close', $aData);

        return $sOut;
    }
}
