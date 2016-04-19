# Default Values

Default Values provide the ability to generate dynamic values for fields which support them.


## Defining Field Types

Components (or the app) can provide default values types at the `FormBuilder\DefaultValue` namespace, relative to the root namespace for the component. For example, component `MyVendor\Foo` would provide field types at `MyVenfor\Foo\FormBuilder\DefaultValue`.

Default Values provided by components must be compatible with (or extend) `Nails\FormBuilder\DefaultValue\Base`.

The `DefaultValue` model will automatically discover Default Values at this namespace and make them available.

```
@todo - improve documentation
```

**Sample Default Value**

```php
<?php

namespace Nails\FormBuilder\FormBuilder\DefaultValue;

use Nails\FormBuilder\DefaultValue\Base;

class UserId extends Base
{
    const LABEL = 'User\'s ID';

    /**
     * Return the calculated default value
     * @return mixed
     */
    public function defaultValue()
    {
        return activeUser('id');
    }
}

```