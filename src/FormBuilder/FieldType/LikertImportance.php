<?php

/**
 * This class provides the "Likert - Importance" field type
 *
 * @package     Nails
 * @subpackage  module-form-builder
 * @category    Controller
 * @author      Nails Dev Team
 * @link
 */

namespace Nails\FormBuilder\FormBuilder\FieldType;

use Nails\Factory;

class LikertImportance extends Likert
{
    const LABEL = 'Likert - Importance';

    // --------------------------------------------------------------------------

    /**
     * Renders the field's HTML
     * @param  $aData The field's data
     * @return string
     */
    public function render($aData)
    {
        $aData['likertTerms'] = array(
            'Very Important',
            'Important',
            'Moderately Important',
            'Of Little Importance',
            'Unimportant'
        );

        return parent::render($aData);
    }
}
