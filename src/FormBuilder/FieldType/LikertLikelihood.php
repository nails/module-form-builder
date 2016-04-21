<?php

/**
 * This class provides the "Likert - Liklihood" field type
 *
 * @package     Nails
 * @subpackage  module-form-builder
 * @category    Controller
 * @author      Nails Dev Team
 * @link
 */

namespace Nails\FormBuilder\FormBuilder\FieldType;

use Nails\Factory;

class LikertLikelihood extends Likert
{
    const LABEL = 'Likert - Liklihood';

    // --------------------------------------------------------------------------

    /**
     * Renders the field's HTML
     * @param  $aData The field's data
     * @return string
     */
    public function render($aData)
    {
        $aData['likertTerms'] = array(
            'Very Likely',
            'Likely',
            'Maybe',
            'Unlikely',
            'Very Unlikely'
        );

        return parent::render($aData);
    }
}
