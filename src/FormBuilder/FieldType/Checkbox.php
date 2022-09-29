<?php

/**
 * This class provides the "Checkbox" field type
 *
 * @package     Nails
 * @subpackage  module-form-builder
 * @category    Controller
 * @author      Nails Dev Team
 * @link
 */

namespace Nails\FormBuilder\FormBuilder\FieldType;

use Nails\FormBuilder\FieldType\Base;

/**
 * Class Checkbox
 *
 * @package Nails\FormBuilder\FormBuilder\FieldType
 */
class Checkbox extends Base
{
    const LABEL                = 'Checkbox';
    const SUPPORTS_OPTIONS     = true;
    const SUPPORTS_PLACEHOLDER = false;
    const RENDER_VIEWS         = [
        'formbuilder/fields/open',
        'formbuilder/fields/body-checkbox',
        'formbuilder/fields/close',
    ];
}
