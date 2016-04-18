<?php

/**
 * This class provides the "UserFirstName" default value
 *
 * @package     Nails
 * @subpackage  module-form-builder
 * @category    Controller
 * @author      Nails Dev Team
 * @link
 */

namespace Nails\FormBuilder\DefaultValue;

class UserFirstName extends Base
{
    const LABEL = 'User\'s First Name';

    // --------------------------------------------------------------------------

    /**
     * Return the calculated default value
     * @return mixed
     */
    public function defaultValue()
    {
        return activeUser('first_name');
    }
}
