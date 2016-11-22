<?php

/**
 * This class provides the "Likert - Usefulness" field type
 *
 * @package     Nails
 * @subpackage  module-form-builder
 * @category    Controller
 * @author      Nails Dev Team
 * @link
 */

namespace Nails\FormBuilder\FormBuilder\FieldType;

class LikertUsefulness extends Likert
{
    const LABEL = 'Likert - Usefulness';

    /**
     * The terms to use in this likert question
     *
     * @var array
     */
    protected $aLikertTerms = array(
        'Very Useful',
        'Useful',
        'Neither',
        'Not Useful',
        'Not at all Useful'
    );
}
