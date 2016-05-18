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

    /**
     * The terms to use in this likert question
     * @var array
     */
    protected $aLikertTerms = array(
        'Very Likely',
        'Likely',
        'Maybe',
        'Unlikely',
        'Very Unlikely'
    );
}
