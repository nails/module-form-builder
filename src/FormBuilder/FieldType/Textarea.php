<?php

/**
 * This class provides the "Textarea" field type
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
 * Class Textarea
 *
 * @package Nails\FormBuilder\FormBuilder\FieldType
 */
class Textarea extends Base
{
    const LABEL             = 'Textarea';
    const SUPPORTS_DEFAULTS = true;
    const RENDER_VIEWS      = [
        'formbuilder/fields/open',
        'formbuilder/fields/body-textarea',
        'formbuilder/fields/close',
    ];
}
