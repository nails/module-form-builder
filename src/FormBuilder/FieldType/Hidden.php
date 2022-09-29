<?php

/**
 * This class provides the "Hidden" field type
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
 * Class Hidden
 *
 * @package Nails\FormBuilder\FormBuilder\FieldType
 */
class Hidden extends Base
{
    const LABEL                = 'Hidden';
    const SUPPORTS_DEFAULTS    = true;
    const SUPPORTS_PLACEHOLDER = false;
    const RENDER_VIEWS         = [
        'formbuilder/fields/body-hidden',
    ];
}
