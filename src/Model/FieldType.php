<?php

/**
 * This model manages the available field types.
 *
 * @package     Nails
 * @subpackage  module-form-builder
 * @category    Model
 * @author      Nails Dev Team
 * @link
 */

namespace Nails\FormBuilder\Model;

use Nails\Factory;

class FieldType
{
    /**
     * The available Field definitions
     * @var array
     */
    protected $aAvailable;

    // --------------------------------------------------------------------------

    /**
     * Cosntruct the model, look for available Field definitions
     */
    public function __construct()
    {
        $this->aAvailable = array(
            'TEXT' => (object) array(
                'model'    => 'FieldTypeText',
                'provider' => 'nailsapp/module-form-builder'
            ),
            'PASSWORD' => (object) array(
                'model'    => 'FieldTypePassword',
                'provider' => 'nailsapp/module-form-builder'
            ),
            'NUMBER' => (object) array(
                'model'    => 'FieldTypeNumber',
                'provider' => 'nailsapp/module-form-builder'
            ),
            'EMAIL' => (object) array(
                'model'    => 'FieldTypeEmail',
                'provider' => 'nailsapp/module-form-builder'
            ),
            'TEL' => (object) array(
                'model'    => 'FieldTypeTel',
                'provider' => 'nailsapp/module-form-builder'
            ),
            'URL' => (object) array(
                'model'    => 'FieldTypeUrl',
                'provider' => 'nailsapp/module-form-builder'
            ),
            'TEXTAREA' => (object) array(
                'model'    => 'FieldTypeTextarea',
                'provider' => 'nailsapp/module-form-builder'
            ),
            'SELECT' => (object) array(
                'model'    => 'FieldTypeSelect',
                'provider' => 'nailsapp/module-form-builder'
            ),
            'CHECKBOX' => (object) array(
                'model'    => 'FieldTypeCheckbox',
                'provider' => 'nailsapp/module-form-builder'
            ),
            'RADIO' => (object) array(
                'model'    => 'FieldTypeRadio',
                'provider' => 'nailsapp/module-form-builder'
            ),
            'DATE' => (object) array(
                'model'    => 'FieldTypeDate',
                'provider' => 'nailsapp/module-form-builder'
            ),
            'TIME' => (object) array(
                'model'    => 'FieldTypeTime',
                'provider' => 'nailsapp/module-form-builder'
            ),
            'DATETIME' => (object) array(
                'model'    => 'FieldTypeDateTime',
                'provider' => 'nailsapp/module-form-builder'
            ),
            'FILE' => (object) array(
                'model'    => 'FieldTypeFile',
                'provider' => 'nailsapp/module-form-builder'
            ),
            'HIDDEN' => (object) array(
                'model'    => 'FieldTypeHidden',
                'provider' => 'nailsapp/module-form-builder'
            )
        );
    }

    // --------------------------------------------------------------------------

    /**
     * Returns all available Field definitions
     * @return array
     */
    public function getAll()
    {
        foreach ($this->aAvailable as $oType) {
            if (!isset($oType->instance)) {
                $oType->instance = Factory::model($oType->model, $oType->provider);
            }
        }

        return $this->aAvailable;
    }

    // --------------------------------------------------------------------------

    /**
     * Return all the available types of field which can be created as a flat array
     * @return array
     */
    public function getAllFlat()
    {
        $aAvailable = $this->getAll();
        $aOut       = array();

        foreach ($aAvailable as $sKey => $oType) {

            $oInstance   = $oType->instance;
            $aOut[$sKey] = $oInstance::LABEL;
        }

        return $aOut;
    }

    // --------------------------------------------------------------------------

    /**
     * Returns the types which support defining multiple options
     * @return array
     */
    public function getAllWithOptions()
    {
        $aAvailable = $this->getAll();
        $aOut       = array();

        foreach ($aAvailable as $sKey => $oType) {

            $oInstance = $oType->instance;

            if ($oInstance::SUPPORTS_OPTIONS) {
                $aOut[] = $sKey;
            }
        }

        return $aOut;
    }

    // --------------------------------------------------------------------------

    /**
     * Returns the types which support a default value
     * @return array
     */
    public function getAllWithDefaultValue()
    {
        $aAvailable = $this->getAll();
        $aOut       = array();

        foreach ($aAvailable as $sKey => $oType) {

            $oInstance = $oType->instance;

            if ($oInstance::SUPPORTS_DEFAULTS) {
                $aOut[] = $sKey;
            }
        }

        return $aOut;
    }

    // --------------------------------------------------------------------------

    /**
     * Get an individual field type instance by it's slug
     * @param  string $sSlug The Field Type's slug
     * @return object
     */
    public function getBySlug($sSlug)
    {
        $aAvailable = $this->getAll();

        foreach ($aAvailable as $sTypeSlug => $oType) {
            if ($sTypeSlug == $sSlug) {
                return $oType->instance;
            }
        }

        return null;
    }
}
