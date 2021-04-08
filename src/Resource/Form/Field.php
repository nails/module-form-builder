<?php

namespace Nails\FormBuilder\Resource\Form;

use Nails\Common\Resource\Entity;
use Nails\Common\Resource\ExpandableField;

/**
 * Class Field
 *
 * @package Nails\FormBuilder\Resource\Form
 */
class Field extends Entity
{
    /** @var int */
    public $form_id;

    /** @var string */
    public $type;

    /** @var string */
    public $label;

    /** @var string */
    public $sub_label;

    /** @var string */
    public $placeholder;

    /** @var bool */
    public $is_required;

    /** @var string */
    public $default_value;

    /** @var string */
    public $custom_attributes;

    /** @var int */
    public $order;

    /** @var ExpandableField */
    public $options;

    /** @var bool */
    public $is_deleted;
}
