<?php

/**
 * This class provides the "Tel" field type
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
 * Class Tel
 *
 * @package Nails\FormBuilder\FormBuilder\FieldType
 */
class Tel extends Base
{
    const LABEL             = 'Telephone';
    const SUPPORTS_DEFAULTS = true;
    const RENDER_VIEWS      = [
        'formbuilder/fields/open',
        'formbuilder/fields/body-tel',
        'formbuilder/fields/close',
    ];
}
