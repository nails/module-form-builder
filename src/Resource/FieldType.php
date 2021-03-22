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
    public $is_selectable;

    /** @var bool */
    public $can_option_select;

    /** @var bool */
    public $can_option_disable;
}
