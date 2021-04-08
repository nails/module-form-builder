<?php

/**
 * Manage form fields' options
 *
 * @package     Nails
 * @subpackage  module-form-builder
 * @category    Model
 * @author      Nails Dev Team
 * @link
 */

namespace Nails\FormBuilder\Model\Form\Field;

use Nails\Common\Model\Base;
use Nails\FormBuilder\Constants;

/**
 * Class Option
 *
 * @package Nails\FormBuilder\Model\Form\Field
 */
class Option extends Base
{
    const TABLE               = NAILS_DB_PREFIX . 'formbuilder_form_field_option';
    const RESOURCE_NAME       = 'FormFieldOption';
    const RESOURCE_PROVIDER   = Constants::MODULE_SLUG;
    const DEFAULT_SORT_COLUMN = 'order';
}
