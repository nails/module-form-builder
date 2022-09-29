<?php

/**
 * This class provides the "Radio" field type
 *
 * @package     Nails
 * @subpackage  module-form-builder
 * @category    Controller
 * @author      Nails Dev Team
 * @link
 */

namespace Nails\FormBuilder\FormBuilder\FieldType;

use Nails\Factory;
use Nails\FormBuilder\FieldType\Base;

/**
 * Class Radio
 *
 * @package Nails\FormBuilder\FormBuilder\FieldType
 */
class Radio extends Base
{
    const LABEL                = 'Radio';
    const SUPPORTS_OPTIONS     = true;
    const SUPPORTS_PLACEHOLDER = false;
    const RENDER_VIEWS         = [
        'formbuilder/fields/open',
        'formbuilder/fields/body-radio',
        'formbuilder/fields/close',
    ];
}
