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

/**
 * Class LikertImportance
 *
 * @package Nails\FormBuilder\FormBuilder\FieldType
 */
class LikertImportance extends Likert
{
    const LABEL        = 'Likert - Importance';
    const LIKERT_TERMS = [
        'Very Important',
        'Important',
        'Moderately Important',
        'Of Little Importance',
        'Unimportant',
    ];
}
