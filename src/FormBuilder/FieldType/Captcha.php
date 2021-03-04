<?php

/**
 * This class provides the "Cpatcha" field type
 *
 * @package     Nails
 * @subpackage  module-form-builder
 * @category    Controller
 * @author      Nails Dev Team
 * @link
 */

namespace Nails\FormBuilder\FormBuilder\FieldType;

use Nails\Common\Exception\FactoryException;
use Nails\Common\Exception\ViewNotFoundException;
use Nails\Factory;
use Nails\FormBuilder\FieldType\Base;

/**
 * Class Captcha
 *
 * @package Nails\FormBuilder\FormBuilder\FieldType
 */
class Captcha extends Base
{
    const LABEL             = 'Captcha';
    const SUPPORTS_OPTIONS  = false;
    const SUPPORTS_DEFAULTS = false;
    const IS_SELECTABLE     = false;
    const RENDER_VIEWS      = [
        'formbuilder/fields/open',
        'formbuilder/fields/body-captcha',
        'formbuilder/fields/close',
    ];

    // --------------------------------------------------------------------------

    /**
     * Renders the field's HTML
     *
     * @param array $aConfig The field's data
     *
     * @return string
     * @throws FactoryException
     * @throws ViewNotFoundException
     */
    public function render(array $aConfig): string
    {
        if (empty($aConfig['captcha'])) {
            return '';
        }

        return parent::render($aConfig);
    }
}
