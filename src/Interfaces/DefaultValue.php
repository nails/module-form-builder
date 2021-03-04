<?php

namespace Nails\FormBuilder\Interfaces;

/**
 * Interface DefaultValue
 *
 * @package Nails\FormBuilder\Interfaces
 */
interface DefaultValue
{
    /**
     * Returns the default value's label
     *
     * @return string
     */
    public static function getLabel(): string;

    // --------------------------------------------------------------------------

    /**
     * Return the calculated default value
     *
     * @return mixed
     */
    public function defaultValue();
}
