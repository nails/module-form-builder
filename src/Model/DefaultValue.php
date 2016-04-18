<?php

/**
 * This model manages the available default values.
 *
 * @package     Nails
 * @subpackage  module-form-builder
 * @category    Model
 * @author      Nails Dev Team
 * @link
 */

namespace Nails\FormBuilder\Model;

use Nails\Factory;

class DefaultValue
{
    /**
     * The available DefaultValue definitions
     * @var array
     */
    protected $aAvailable;

    // --------------------------------------------------------------------------

    /**
     * Cosntruct the model, look for available DefaultValue definitions
     */
    public function __construct()
    {
        $this->aAvailable = array(
            'NONE' => (object) array(
                'model'    => 'DefaultValueNone',
                'provider' => 'nailsapp/module-form-builder'
            ),
            'USER_ID' => (object) array(
                'model'    => 'DefaultValueUserId',
                'provider' => 'nailsapp/module-form-builder'
            ),
            'USER_NAME' => (object) array(
                'model'    => 'DefaultValueUserName',
                'provider' => 'nailsapp/module-form-builder'
            ),
            'USER_FIRST_NAME' => (object) array(
                'model'    => 'DefaultValueUserFirstName',
                'provider' => 'nailsapp/module-form-builder'
            ),
            'USER_LAST_NAME' => (object) array(
                'model'    => 'DefaultValueUserLastName',
                'provider' => 'nailsapp/module-form-builder'
            ),
            'USER_EMAIL' => (object) array(
                'model'    => 'DefaultValueUserEmail',
                'provider' => 'nailsapp/module-form-builder'
            ),
            'TIMESTAMP' => (object) array(
                'model'    => 'DefaultValueTimestamp',
                'provider' => 'nailsapp/module-form-builder'
            ),
            'CUSTOM' => (object) array(
                'model'    => 'DefaultValueCustom',
                'provider' => 'nailsapp/module-form-builder'
            ),
        );
    }

    // --------------------------------------------------------------------------

    /**
     * Returns all available DefaultValue definitions
     * @return array
     */
    public function getAll()
    {
        foreach ($this->aAvailable as $oDefault) {
            if (!isset($oDefault->instance)) {
                $oDefault->instance = Factory::model($oDefault->model, $oDefault->provider);
            }
        }

        return $this->aAvailable;
    }

    // --------------------------------------------------------------------------

    /**
     * Returns the various default values which a field can have as a flat array
     * @return array
     */
    public function getAllFlat()
    {
        $aAvailable = $this->getAll();
        $aOut       = array();

        foreach ($aAvailable as $sKey => $oDefault) {
            $oInstance   = $oDefault->instance;
            $aOut[$sKey] = $oInstance::LABEL;
        }

        return $aOut;
    }

    // --------------------------------------------------------------------------

    /**
     * Get an individual default value instance by it's slug
     * @param  string $sSlug The Default Value's slug
     * @return object
     */
    public function getBySlug($sSlug) {

        $aAvailable = $this->getAll();

        foreach ($aAvailable as $sDefaultValueSlug => $oDefaultValue) {
            if ($sDefaultValueSlug == $sSlug) {
                return $oDefaultValue->instance;
            }
        }

        return null;
    }
}
