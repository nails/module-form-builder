<?php

/**
 * This class provides the "Text" field type
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
 * Class Section
 *
 * @package Nails\FormBuilder\FormBuilder\FieldType
 */
class Section extends Base
{
    const LABEL                      = 'Section';
    const RENDER_VIEWS               = [
        'formbuilder/fields/body-section',
    ];
    const SUPPORTS_OPTIONS           = false;
    const SUPPORTS_OPTIONS_SELECTED  = false;
    const SUPPORTS_OPTIONS_DISABLE   = false;
    const SUPPORTS_DEFAULTS          = false;
    const SUPPORTS_PLACEHOLDER       = false;
    const SUPPORTS_REQUIRED          = false;
    const SUPPORTS_CUSTOM_ATTRIBUTES = false;
}
