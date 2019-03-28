<?php

/**
 * This class manages the available default values.
 *
 * @package     Nails
 * @subpackage  module-form-builder
 * @category    Factory
 * @author      Nails Dev Team
 * @link
 */

namespace Nails\FormBuilder\Service;

use Nails\Components;
use Nails\Factory;

class DefaultValue
{
    /**
     * The available DefaultValue definitions
     *
     * @var array
     */
    protected $aAvailable;

    // --------------------------------------------------------------------------

    /**
     * Construct the model, look for available DefaultValue definitions
     */
    public function __construct()
    {
        //  Look for available FieldTypes
        $this->aAvailable = [];

        foreach (Components::available() as $oComponent) {
            if (!empty($oComponent->namespace)) {
                $this->autoLoadDefaults(
                    $oComponent->namespace,
                    $oComponent->path,
                    $oComponent->slug
                );
            }
        }

        //  Any subscriptions for the app?
        $this->autoLoadDefaults(
            'App\\',
            NAILS_APP_PATH,
            'app'
        );
    }

    // --------------------------------------------------------------------------

    /**
     * Looks for FieldTypes provided by components
     *
     * @param  string $sNamespace The namespace to check
     * @param  string $sPath      The path to search
     * @param  string $sComponent The component being queried
     *
     * @return void
     */
    protected function autoLoadDefaults($sNamespace, $sPath, $sComponent)
    {
        $sClassNamespace = '\\' . $sNamespace . 'FormBuilder\\DefaultValue\\';
        $sPath           = $sPath . 'src/FormBuilder/DefaultValue/';

        if (is_dir($sPath)) {

            $aFiles = directory_map($sPath);
            foreach ($aFiles as $sFile) {
                $sClassName = $sClassNamespace . basename($sFile, '.php');
                if (class_exists($sClassName)) {
                    $this->aAvailable[] = (object) [
                        'slug'      => $sClassName,
                        'label'     => $sClassName::LABEL,
                        'component' => 'DefaultValue' . basename($sFile, '.php'),
                        'provider'  => $sComponent,
                        'instance'  => null,
                    ];
                }
            }
        }
    }

    // --------------------------------------------------------------------------

    /**
     * Returns all available DefaultValue definitions
     *
     * @return array
     */
    public function getAll()
    {
        return $this->aAvailable;
    }

    // --------------------------------------------------------------------------

    /**
     * Returns the various default values which a field can have as a flat array
     *
     * @return array
     */
    public function getAllFlat()
    {
        $aAvailable = $this->getAll();
        $aOut       = [];

        foreach ($aAvailable as $oDefault) {
            $aOut[$oDefault->slug] = $oDefault->label;
        }

        return $aOut;
    }

    // --------------------------------------------------------------------------

    /**
     * Get an individual default value instance by it's slug
     *
     * @param  string $sSlug The Default Value's slug
     *
     * @return object
     */
    public function getBySlug($sSlug)
    {
        $aAvailable = $this->getAll();

        foreach ($aAvailable as $oDefault) {

            if ($oDefault->slug == $sSlug) {

                if (!isset($oDefault->instance)) {
                    $oDefault->instance = Factory::factory(
                        $oDefault->component,
                        $oDefault->provider
                    );
                }

                return $oDefault->instance;
            }
        }

        return null;
    }
}
