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

class LikertFrequency extends Likert
{
    const LABEL = 'Likert - Frequency';

    /**
     * The terms to use in this likert question
     *
     * @var array
     */
    protected $aLikertTerms = [
        'Very Frequently',
        'Frequently',
        'Occassionally',
        'Rarely',
        'Never',
    ];
}
