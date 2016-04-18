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

class Field
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
                'provider' => 'nailsapp/module-custom-forms'
            ),
            'PASSWORD' => (object) array(
                'model'    => 'FieldTypePassword',
                'provider' => 'nailsapp/module-custom-forms'
            ),
            'NUMBER' => (object) array(
                'model'    => 'FieldTypeNumber',
                'provider' => 'nailsapp/module-custom-forms'
            ),
            'EMAIL' => (object) array(
                'model'    => 'FieldTypeEmail',
                'provider' => 'nailsapp/module-custom-forms'
            ),
            'TEL' => (object) array(
                'model'    => 'FieldTypeTel',
                'provider' => 'nailsapp/module-custom-forms'
            ),
            'URL' => (object) array(
                'model'    => 'FieldTypeUrl',
                'provider' => 'nailsapp/module-custom-forms'
            ),
            'TEXTAREA' => (object) array(
                'model'    => 'FieldTypeTextarea',
                'provider' => 'nailsapp/module-custom-forms'
            ),
            'SELECT' => (object) array(
                'model'    => 'FieldTypeSelect',
                'provider' => 'nailsapp/module-custom-forms'
            ),
            'CHECKBOX' => (object) array(
                'model'    => 'FieldTypeCheckbox',
                'provider' => 'nailsapp/module-custom-forms'
            ),
            'RADIO' => (object) array(
                'model'    => 'FieldTypeRadio',
                'provider' => 'nailsapp/module-custom-forms'
            ),
            'DATE' => (object) array(
                'model'    => 'FieldTypeDate',
                'provider' => 'nailsapp/module-custom-forms'
            ),
            'TIME' => (object) array(
                'model'    => 'FieldTypeTime',
                'provider' => 'nailsapp/module-custom-forms'
            ),
            'DATETIME' => (object) array(
                'model'    => 'FieldTypeDateTime',
                'provider' => 'nailsapp/module-custom-forms'
            ),
            'FILE' => (object) array(
                'model'    => 'FieldTypeFile',
                'provider' => 'nailsapp/module-custom-forms'
            ),
            'HIDDEN' => (object) array(
                'model'    => 'FieldTypeHidden',
                'provider' => 'nailsapp/module-custom-forms'
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
     * Get an individual field type instance by it's slug
     * @param  string $sSlug The Field Type's slug
     * @return object
     */
    public function getBySlug($sSlug)
    {
        $aAvailable = $this->getTypes();

        foreach ($aAvailable as $sTypeSlug => $oType) {
            if ($sTypeSlug == $sSlug) {
                return $oType->instance;
            }
        }

        return null;
    }
}
