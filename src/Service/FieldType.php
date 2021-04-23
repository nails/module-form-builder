<?php

/**
 * This class manages the available field types.
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
use Nails\Components;
use Nails\Factory;
use Nails\FormBuilder\Constants;
use Nails\FormBuilder\Resource;

/**
 * Class FieldType
 *
 * @package Nails\FormBuilder\Service
 */
class FieldType
{
    /**
     * The available Field definitions
     *
     * @var Resource\FieldType[]
     */
    protected $aAvailable;

    // --------------------------------------------------------------------------

    /**
     * FieldType constructor.
     *
     * @throws FactoryException
     * @throws NailsException
     */
    public function __construct()
    {
        $this->discoverFieldTypes();
    }

    // --------------------------------------------------------------------------

    /**
     * Discovers available FieldTypes
     *
     * @return $this
     * @throws FactoryException
     * @throws NailsException
     */
    protected function discoverFieldTypes(): self
    {
        $this->aAvailable = [];

        foreach (Components::available() as $oComponent) {

            $aClasses = $oComponent
                ->findClasses('FormBuilder\\FieldType')
                ->whichImplement(\Nails\FormBuilder\Interfaces\FieldType::class)
                ->whichCanBeInstantiated();

            /** @var \Nails\FormBuilder\Interfaces\FieldType $sClass */
            foreach ($aClasses as $sClass) {
                $this->aAvailable[] = Factory::resource('FieldType', Constants::MODULE_SLUG, [
                    'slug'                       => $sClass,
                    'label'                      => $sClass::getLabel(),
                    'instance'                   => new $sClass(),
                    'supports_options'           => $sClass::supportsOptions(),
                    'supports_options_selected'  => $sClass::supportsOptionsSelected(),
                    'supports_options_disabled'  => $sClass::supportsOptionsDisabled(),
                    'supports_default_values'    => $sClass::supportsDefaultValues(),
                    'supports_placeholder'       => $sClass::supportsPlaceholder(),
                    'supports_required'          => $sClass::supportsRequired(),
                    'supports_custom_attributes' => $sClass::supportsCustomAttributes(),
                    'is_selectable'              => $sClass::isSelectable(),
                ]);
            }
        }

        arraySortMulti($this->aAvailable, 'label');

        return $this;
    }

    // --------------------------------------------------------------------------

    /**
     * Filter available FieldTypes
     *
     * @param callable $cFilter The callable to filter by
     *
     * @return Resource\FieldType[]
     */
    public function filter(callable $cFilter): array
    {
        return array_values(array_filter($this->aAvailable, $cFilter));
    }

    // --------------------------------------------------------------------------

    /**
     * Returns all available Field definitions
     *
     * @param bool $bOnlySelectable Filter out field types which are not selectable by the user
     *
     * @return Resource\FieldType[]
     */
    public function getAll($bOnlySelectable = false): array
    {
        return $bOnlySelectable
            ? $this->filter(function ($oType) {
                return $oType->instance::IS_SELECTABLE;
            })
            : $this->aAvailable;
    }

    // --------------------------------------------------------------------------

    /**
     * Return all the available types of field which can be created as a flat array
     *
     * @param bool $bOnlySelectable Filter out field types which are not selectable by the user
     *
     * @return string[]
     */
    public function getAllFlat($bOnlySelectable = false): array
    {
        $aAvailable = $this->getAll($bOnlySelectable);
        $aOut       = [];

        foreach ($aAvailable as $oType) {
            $aOut[$oType->slug] = $oType->label;
        }

        return $aOut;
    }

    // --------------------------------------------------------------------------

    /**
     * Returns the types which support defining multiple options
     *
     * @param bool $bOnlySelectable Filter out field types which are not selectable by the user
     *
     * @return Resource\FieldType[]
     */
    public function getAllWithOptions($bOnlySelectable = false): array
    {
        return $this->filter(function ($oType) {
            return $oType->instance::SUPPORTS_OPTIONS;
        });
    }

    // --------------------------------------------------------------------------

    /**
     * Returns the types which support a default value
     *
     * @param bool $bOnlySelectable Filter out field types which are not selectable by the user
     *
     * @return Resource\FieldType[]
     */
    public function getAllWithDefaultValue($bOnlySelectable = false): array
    {
        return $this->filter(function ($oType) {
            return $oType->instance::SUPPORTS_DEFAULTS;
        });
    }

    // --------------------------------------------------------------------------

    /**
     * Get an individual field type instance by it's slug
     *
     * @param string $sSlug           The Field Type's slug
     * @param bool   $bOnlySelectable Filter out field types which are not selectable by the user
     *
     * @return \Nails\FormBuilder\Interfaces\FieldType|null
     */
    public function getBySlug($sSlug, $bOnlySelectable = false): ?\Nails\FormBuilder\Interfaces\FieldType
    {
        //  Ensure leading slash
        $sSlug = substr($sSlug, 0, 1) === '\\' ? $sSlug : '\\' . $sSlug;
        foreach ($this->getAll($bOnlySelectable) as $oType) {
            if ($oType->slug == $sSlug) {
                return $oType->instance;
            }
        }

        return null;
    }
}
