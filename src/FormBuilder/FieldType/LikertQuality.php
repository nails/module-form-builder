<?php

/**
 * This class provides the "Likert - Quality" field type
 *
 * @package     Nails
 * @subpackage  module-form-builder
 * @category    Controller
 * @author      Nails Dev Team
 * @link
 */

namespace Nails\FormBuilder\FormBuilder\FieldType;

class LikertQuality extends Likert
{
    const LABEL = 'Likert - Quality';

    /**
     * The terms to use in this likert question
     *
     * @var array
     */
    protected $aLikertTerms = [
        'Excellent',
        'Good',
        'Acceptable',
        'Poor',
        'Very Poor',
    ];
}
