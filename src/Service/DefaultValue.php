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

use Nails\Common\Exception\FactoryException;
use Nails\Common\Exception\NailsException;
use Nails\Common\Helper\Directory;
use Nails\Components;
use Nails\Factory;
use Nails\FormBuilder\Constants;
use Nails\FormBuilder\Resource;

/**
 * Class DefaultValue
 *
 * @package Nails\FormBuilder\Service
 */
class DefaultValue
{
    /**
     * The available DefaultValue definitions
     *
     * @var Resource\DefaultValue[]
     */
    protected $aAvailable;

    // --------------------------------------------------------------------------

    /**
     * DefaultValue constructor.
     *
     * @throws FactoryException
     * @throws NailsException
     */
    public function __construct()
    {
        $this->discoverDefaultValues();
    }

    // --------------------------------------------------------------------------

    /**
     * Discovers available DefaultValues
     *
     * @return $this
     * @throws FactoryException
     * @throws NailsException
     */
    protected function discoverDefaultValues(): self
    {
        $this->aAvailable = [];

        foreach (Components::available() as $oComponent) {

            $aClasses = $oComponent
                ->findClasses('FormBuilder\\DefaultValue')
                ->whichImplement(\Nails\FormBuilder\Interfaces\DefaultValue::class)
                ->whichCanBeInstantiated();

            /** @var \Nails\FormBuilder\Interfaces\DefaultValue $sClass */
            foreach ($aClasses as $sClass) {
                $this->aAvailable[] = Factory::resource('DefaultValue', Constants::MODULE_SLUG, [
                    'slug'     => $sClass,
                    'label'    => $sClass::getLabel(),
                    'instance' => new $sClass(),
                ]);
            }
        }

        arraySortMulti($this->aAvailable, 'label');

        return $this;
    }
    // --------------------------------------------------------------------------

    /**
     * Returns all available DefaultValue definitions
     *
     * @return Resource\DefaultValue[]
     */
    public function getAll(): array
    {
        return $this->aAvailable;
    }

    // --------------------------------------------------------------------------

    /**
     * Returns the various default values which a field can have as a flat array
     *
     * @return string[]
     */
    public function getAllFlat(): array
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
     * @param string $sSlug The Default Value's slug
     *
     * @return \Nails\FormBuilder\DefaultValue\Base|null
     */
    public function getBySlug($sSlug): ?\Nails\FormBuilder\DefaultValue\Base
    {
        foreach ($this->getAll() as $oDefault) {
            if ($oDefault->slug == $sSlug) {
                return $oDefault->instance;
            }
        }

        return null;
    }
}
