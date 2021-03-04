<?php

namespace Nails\FormBuilder\Resource;

use Nails\Common\Resource;

/**
 * Class DefaultValue
 *
 * @package Nails\FormBuilder\Resource
 */
class DefaultValue extends Resource
{
    /** @var string */
    public $slug;

    /** @var string */
    public $label;

    /** @var \Nails\FormBuilder\DefaultValue\Base */
    public $instance;
}
