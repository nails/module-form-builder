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

/**
 * Class LikertUsefulness
 *
 * @package Nails\FormBuilder\FormBuilder\FieldType
 */
class LikertUsefulness extends Likert
{
    const LABEL        = 'Likert - Usefulness';
    const LIKERT_TERMS = [
        'Very Useful',
        'Useful',
        'Neither',
        'Not Useful',
        'Not at all Useful',
    ];
}
