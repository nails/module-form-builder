<?php

/**
 * This class provides the "Password" field type
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
 * Class Password
 *
 * @package Nails\FormBuilder\FormBuilder\FieldType
 */
class Password extends Base
{
    const LABEL             = 'Password';
    const SUPPORTS_DEFAULTS = true;
    const RENDER_VIEWS      = [
        'formbuilder/fields/open',
        'formbuilder/fields/body-password',
        'formbuilder/fields/close',
    ];
}
