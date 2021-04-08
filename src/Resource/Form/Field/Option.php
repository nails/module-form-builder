<?php

namespace Nails\FormBuilder\Resource\Form\Field;

use Nails\Common\Resource\Entity;

/**
 * Class Option
 *
 * @package Nails\FormBuilder\Resource\Form\Field
 */
class Option extends Entity
{
    /** @var int */
    public $form_field_id;

    /** @var string */
    public $label;

    /** @var bool */
    public $is_disabled;

    /** @var bool */
    public $is_selected;

    /** @var int */
    public $order;

    /** @var bool */
    public $is_deleted;

}
