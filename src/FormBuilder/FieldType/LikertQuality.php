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

/**
 * Class LikertQuality
 *
 * @package Nails\FormBuilder\FormBuilder\FieldType
 */
class LikertQuality extends Likert
{
    const LABEL        = 'Likert - Quality';
    const LIKERT_TERMS = [
        'Excellent',
        'Good',
        'Acceptable',
        'Poor',
        'Very Poor',
    ];
}
