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

/**
 * Class LikertInterest
 *
 * @package Nails\FormBuilder\FormBuilder\FieldType
 */
class LikertInterest extends Likert
{
    const LABEL        = 'Likert - Interest';
    const LIKERT_TERMS = [
        'Very interested',
        'Interested',
        'Neither',
        'Not Interested',
        'Not at all Interested',
    ];
}
