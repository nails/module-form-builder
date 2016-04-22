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
        //  Look for available FieldTypes
        $this->aAvailable = array();

        $aComponents = _NAILS_GET_COMPONENTS();
        foreach ($aComponents as $oComponent) {
            if (!empty($oComponent->namespace)) {
                $this->autoLoadTypes(
                    $oComponent->namespace,
                    $oComponent->path,
                    $oComponent->slug
                );
            }
        }

        //  Any subscriptions for the app?
        $this->autoLoadTypes(
            'App\\',
            FCPATH,
            'app'
        );
    }

    // --------------------------------------------------------------------------

    /**
     * Looks for FieldTypes provided by components
     * @param  string $sNamespace The namespace to check
     * @param  string $sPath      The path to search
     * @param  string $sComponent The component being queried
     * @return void
     */
    protected function autoLoadTypes($sNamespace, $sPath, $sComponent)
    {
        $sClassNamespace = '\\' . $sNamespace . 'FormBuilder\\FieldType\\';
        $sPath           = $sPath . 'src/FormBuilder/FieldType/';

        if (is_dir($sPath)) {

            $aFiles = directory_map($sPath);
            foreach ($aFiles as $sFile) {
                $sClassName = $sClassNamespace . basename($sFile, '.php');
                if (class_exists($sClassName)) {
                    $this->aAvailable[] = (object) array(
                        'slug'               => $sClassName,
                        'label'              => $sClassName::LABEL,
                        'model'              => 'FieldType' . basename($sFile, '.php'),
                        'provider'           => $sComponent,
                        'instance'           => null,
                        'is_selectable'      => $sClassName::IS_SELECTABLE,
                        'can_option_select'  => $sClassName::SUPPORTS_OPTIONS_SELECTED,
                        'can_option_disable' => $sClassName::SUPPORTS_OPTIONS_DISABLE
                    );
                }
            }
        }
    }

    // --------------------------------------------------------------------------

    /**
     * Returns all available Field definitions
     * @param  boolean $bOnlySelectedble Filter out field types which are not selectable by the user
     * @return array
     */
    public function getAll($bOnlySelectable = false)
    {
        $aOut = array();

        foreach ($this->aAvailable as $oType) {
            $sClassName = $oType->slug;
            if (!$bOnlySelectable || $sClassName::IS_SELECTABLE) {
                $aOut[] = $oType;
            }
        }

        return $aOut;
    }

    // --------------------------------------------------------------------------

    /**
     * Return all the available types of field which can be created as a flat array
     * @param  boolean $bOnlySelectedble Filter out field types which are not selectable by the user
     * @return array
     */
    public function getAllFlat($bOnlySelectable = false)
    {
        $aAvailable = $this->getAll($bOnlySelectable);
        $aOut       = array();

        foreach ($aAvailable as $oType) {
            $aOut[$oType->slug] = $oType->label;
        }

        return $aOut;
    }

    // --------------------------------------------------------------------------

    /**
     * Returns the types which support defining multiple options
     * @param  boolean $bOnlySelectedble Filter out field types which are not selectable by the user
     * @return array
     */
    public function getAllWithOptions($bOnlySelectable = false)
    {
        $aAvailable = $this->getAll($bOnlySelectable);
        $aOut       = array();

        foreach ($aAvailable as $oType) {
            $sClassName = $oType->slug;
            if ($sClassName::SUPPORTS_OPTIONS) {
                $aOut[] = $oType;
            }
        }

        return $aOut;
    }

    // --------------------------------------------------------------------------

    /**
     * Returns the types which support a default value
     * @param  boolean $bOnlySelectedble Filter out field types which are not selectable by the user
     * @return array
     */
    public function getAllWithDefaultValue($bOnlySelectable = false)
    {
        $aAvailable = $this->getAll($bOnlySelectable);
        $aOut       = array();

        foreach ($aAvailable as $oType) {
            $sClassName = $oType->slug;
            if ($sClassName::SUPPORTS_DEFAULTS) {
                $aOut[] = $oType;
            }
        }

        return $aOut;
    }

    // --------------------------------------------------------------------------

    /**
     * Get an individual field type instance by it's slug
     * @param  string  $sSlug            The Field Type's slug
     * @param  boolean $bOnlySelectedble Filter out field types which are not selectable by the user
     * @return object
     */
    public function getBySlug($sSlug, $bOnlySelectable = false)
    {
        $aAvailable = $this->getAll($bOnlySelectable);

        foreach ($aAvailable as $oType) {

            if ($oType->slug == $sSlug) {

                if (!isset($oType->instance)) {
                    $oType->instance = Factory::model($oType->model, $oType->provider);
                }

                return $oType->instance;
            }
        }

        return null;
    }
}
