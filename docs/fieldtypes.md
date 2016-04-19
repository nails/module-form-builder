# Field Types

Field Types represent individual form fields and are responsible for both rendring the field in the browser and validating user input.


## Defining Field Types

Components (or the app) can provide field types at the `FormBuilder\FieldType` namespace, relative to the root namespace for the component. For example, component `MyVendor\Foo` would provide field types at `MyVenfor\Foo\FormBuilder\FieldType`.

Field Types provided by components must be compatible with (or extend) `Nails\FormBuilder\FieldType\Base`.

The `FieldType` model will automatically discover FieldTypes at this namespace and make them available.

```
@todo - improve documentation
```

**Sample Field Type**

```php
<?php

namespace MyVendor\Foo\FormBuilder\FieldType;

use Nails\FormBuilder\FieldType\Base;

class Select extends Base
{
    const LABEL             = 'Dropdown';
    const SUPPORTS_OPTIONS  = true;
    const SUPPORTS_DEFAULTS = false;

    /**
     * Renders the field's HTML
     * @param  $aData The field's data
     * @return string
     */
    public function render($aData)
    {
        return '<The HTML for the field>';
    }
}
```