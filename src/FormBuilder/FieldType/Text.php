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
 * Class Text
 *
 * @package Nails\FormBuilder\FormBuilder\FieldType
 */
class Text extends Base
{
    const LABEL             = 'Text';
    const SUPPORTS_DEFAULTS = true;
    const RENDER_VIEWS      = [
        'formbuilder/fields/open',
        'formbuilder/fields/body-text',
        'formbuilder/fields/close',
    ];
}
