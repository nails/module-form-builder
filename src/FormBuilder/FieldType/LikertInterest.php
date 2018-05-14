<?php

/**
 * This class provides the "Likert - Interest" field type
 *
 * @package     Nails
 * @subpackage  module-form-builder
 * @category    Controller
 * @author      Nails Dev Team
 * @link
 */

namespace Nails\FormBuilder\FormBuilder\FieldType;

class LikertInterest extends Likert
{
    const LABEL = 'Likert - Interest';
    /**
     * The terms to use in this likert question
     *
     * @var array
     */
    protected $aLikertTerms = [
        'Very interested',
        'Interested',
        'Neither',
        'Not Interested',
        'Not at all Interested',
    ];
}
