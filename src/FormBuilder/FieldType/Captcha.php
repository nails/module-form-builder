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
use Nails\Common\Service\View;
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

        $aViews = $aConfig['captcha']->isInvisible()
            ? [
                'formbuilder/fields/body-captcha',
            ]
            : [
                'formbuilder/fields/open',
                'formbuilder/fields/body-captcha',
                'formbuilder/fields/close',
            ];

        /** @var View $oView */
        $oView = Factory::service('View');
        return $oView
            ->load($aViews, $aConfig, true);
    }
}
