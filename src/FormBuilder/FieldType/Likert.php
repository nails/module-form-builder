<?php

/**
 * This class provides the "Likert" field type base, using default terms for agreement
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

class Likert extends Base
{
    const LABEL             = 'Likert - Agreement';
    const SUPPORTS_DEFAULTS = false;
    const SUPPORTS_OPTIONS  = true;

    // --------------------------------------------------------------------------

    /**
     * Renders the field's HTML
     * @param  $aData The field's data
     * @return string
     */
    public function render($aData)
    {
        if (empty($aData['likertTerms'])) {
            $aData['likertTerms'] = array(
                'Strongly Agree',
                'Agree',
                'Undecided',
                'Disagree',
                'Strongly Disagree'
            );
        }

        $sOut  = get_instance()->load->view('formbuilder/fields/open', $aData, true);
        $sOut .= get_instance()->load->view('formbuilder/fields/body-likert', $aData, true);
        $sOut .= get_instance()->load->view('formbuilder/fields/close', $aData, true);

        return $sOut;
    }
}
