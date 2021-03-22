<?php

namespace Nails\FormBuilder\Resource;

use Nails\Common\Resource;

/**
 * Class FieldType
 *
 * @package Nails\FormBuilder\Resource
 */
class FieldType extends Resource
{
    /** @var string */
    public $slug;

    /** @var string */
    public $label;

    /** @var \Nails\FormBuilder\Interfaces\FieldType */
    public $instance;

    /** @var bool */
    public $supports_options;

    /** @var bool */
    public $supports_options_selected;

    /** @var bool */
    public $supports_options_disabled;

    /** @var bool */
    public $supports_default_values;

    /** @var bool */
    public $supports_placeholder;

    /** @var bool */
    public $supports_required;

    /** @var bool */
    public $supports_custom_attributes;

    /** @var bool */
    public $is_selectable;
}
