<?php

/**
 * This class provides the "Likert - Frequency" field type
 *
 * @package     Nails
 * @subpackage  module-form-builder
 * @category    Controller
 * @author      Nails Dev Team
 * @link
 */

namespace Nails\FormBuilder\FormBuilder\FieldType;

use Nails\Factory;

class LikertFrequency extends Likert
{
    const LABEL = 'Likert - Frequency';

    // --------------------------------------------------------------------------

    /**
     * Renders the field's HTML
     * @param  $aData The field's data
     * @return string
     */
    public function render($aData)
    {
        $aData['likertTerms'] = array(
            'Very Frequently',
            'Frequently',
            'Occassionally',
            'Rarely',
            'Never'
        );

        return parent::render($aData);
    }
}
