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

/**
 * Class LikertFrequency
 *
 * @package Nails\FormBuilder\FormBuilder\FieldType
 */
class LikertFrequency extends Likert
{
    const LABEL        = 'Likert - Frequency';
    const LIKERT_TERMS = [
        'Very Frequently',
        'Frequently',
        'Occassionally',
        'Rarely',
        'Never',
    ];
}
