<?php

/**
 * This class provides the "Timestamp" default value
 *
 * @package     Nails
 * @subpackage  module-form-builder
 * @category    Controller
 * @author      Nails Dev Team
 * @link
 */

namespace Nails\FormBuilder\FormBuilder\DefaultValue;

use Nails\Factory;
use Nails\FormBuilder\DefaultValue\Base;

class Timestamp extends Base
{
    const LABEL = 'The current timestamp';

    // --------------------------------------------------------------------------

    /**
     * Return the calculated default value
     * @return mixed
     */
    public function defaultValue()
    {
        $oNow = Factory::factory('DateTime');
        return $oNow->format('Y-m-d\TH:i:s');
    }
}
