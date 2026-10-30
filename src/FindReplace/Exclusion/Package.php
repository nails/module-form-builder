<?php

namespace Nails\FormBuilder\FindReplace\Exclusion;

use Nails\FindReplace\Interfaces\Exclusion;

class Package implements Exclusion
{
    public function hidden(): array
    {
        return [];
    }

    public function readOnly(): array
    {
        return [
            NAILS_DB_PREFIX . 'formbuilder_form_field.type',
            NAILS_DB_PREFIX . 'formbuilder_form_field.default_value',
            NAILS_DB_PREFIX . 'formbuilder_form_field.custom_attributes',
        ];
    }
}
