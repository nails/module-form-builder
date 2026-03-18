<?php

namespace Nails\FormBuilder\Resource;

use Nails\Common\Resource\Entity;
use Nails\Common\Resource\ExpandableFieldData;

/**
 * Class Form
 *
 * @package Nails\FormBuilder\Resource
 */
class Form extends Entity
{
    /** @var bool */
    public $has_captcha;

    /** @var ExpandableFieldData */
    public $fields;

    /** @var bool */
    public $is_deleted;
}
