<?php

/**
 * This class provides the "UserName" default value
 *
 * @package     Nails
 * @subpackage  module-form-builder
 * @category    Controller
 * @author      Nails Dev Team
 * @link
 */

namespace Nails\FormBuilder\DefaultValue;

class UserName extends Base
{
    const LABEL = 'User\'s Name';

    // --------------------------------------------------------------------------

    /**
     * Return the calculated default value
     * @return mixed
     */
    public function defaultValue()
    {
        return activeUser('first_name,last_name');
    }
}
