<?php

/**
 * Manage form fields
 *
 * @package     Nails
 * @subpackage  module-form-builder
 * @category    Model
 * @author      Nails Dev Team
 * @link
 */

namespace Nails\FormBuilder\Model\Form;

use Nails\Common\Exception\ModelException;
use Nails\Common\Model\Base;
use Nails\FormBuilder\Constants;

/**
 * Class Field
 *
 * @package Nails\FormBuilder\Model\Form
 */
class Field extends Base
{
    const TABLE               = NAILS_DB_PREFIX . 'formbuilder_form_field';
    const RESOURCE_NAME       = 'FormField';
    const RESOURCE_PROVIDER   = Constants::MODULE_SLUG;
    const DEFAULT_SORT_COLUMN = 'order';

    // --------------------------------------------------------------------------

    /**
     * Field constructor.
     *
     * @throws ModelException
     */
    public function __construct()
    {
        parent::__construct();
        $this->hasMany('options', 'FormFieldOption', 'form_field_id', Constants::MODULE_SLUG);
    }
}
