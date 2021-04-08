<?php

/**
 * This class provides a base for the different field types available
 *
 * @package     Nails
 * @subpackage  module-form-builder
 * @category    Controller
 * @author      Nails Dev Team
 * @link
 */

namespace Nails\FormBuilder\FieldType;

use Nails\Common\Exception\FactoryException;
use Nails\Common\Exception\ViewNotFoundException;
use Nails\Common\Service\View;
use Nails\Factory;
use Nails\FormBuilder\Exception\FieldTypeException;
use Nails\FormBuilder\Exception\FieldTypeExceptionInvalidOption;
use Nails\FormBuilder\Exception\FieldTypeExceptionRequired;
use Nails\FormBuilder\Interfaces\FieldType;
use Nails\FormBuilder\Resource\Form\Field;

/**
 * Class Base
 *
 * @package Nails\FormBuilder\FieldType
 */
abstract class Base implements FieldType
{
    /**
     * The human friendly label to give this field type
     *
     * @var string
     */
    const LABEL = '';

    /**
     * Whether this field type supports multiple options (i.e like a dropdown list)
     *
     * @var bool
     */
    const SUPPORTS_OPTIONS = false;

    /**
     * Whether this field type supports setting an option as selected
     *
     * @var bool
     */
    const SUPPORTS_OPTIONS_SELECTED = true;

    /**
     * Whether this field type supports setting an option as disabled
     *
     * @var bool
     */
    const SUPPORTS_OPTIONS_DISABLE = true;

    /**
     * Whether this field type supports a default value
     *
     * @var bool
     */
    const SUPPORTS_DEFAULTS = false;

    /**
     * Whether this field type supports placeholder values
     *
     * @var bool
     */
    const SUPPORTS_PLACEHOLDER = true;

    /**
     * Whether this field type supports being marked as required
     *
     * @var bool
     */
    const SUPPORTS_REQUIRED = true;

    /**
     * Whether this field type supports custom attributes values
     *
     * @var bool
     */
    const SUPPORTS_CUSTOM_ATTRIBUTES = true;

    /**
     * Whether the field type can be selected by human users
     *
     * @var bool
     */
    const IS_SELECTABLE = true;

    /**
     * which views should be used to render the field
     */
    const RENDER_VIEWS = [];

    // --------------------------------------------------------------------------

    /**
     * Returns the field type's label
     *
     * @return string
     */
    public static function getLabel(): string
    {
        return static::LABEL;
    }

    // --------------------------------------------------------------------------

    /**
     * Renders the field's HTML
     *
     * @param array $aConfig The field's data
     *
     * @return string
     * @throws FactoryException
     * @throws ViewNotFoundException
     */
    public function render(array $aConfig): string
    {
        if (empty(static::RENDER_VIEWS)) {
            throw new FieldTypeException(
                sprintf(
                    '%s must define static::RENDER_VIEWS, or override render()',
                    static::class
                )
            );
        }

        /** @var View $oView */
        $oView = Factory::service('View');
        return $oView
            ->load(static::RENDER_VIEWS, $aConfig, true);
    }

    // --------------------------------------------------------------------------

    /**
     * Returns whether the field type supports options
     *
     * @return bool
     */
    public static function supportsOptions(): bool
    {
        return static::SUPPORTS_OPTIONS;
    }

    // --------------------------------------------------------------------------

    /**
     * Returns whether the field type supports setting an option as selected
     *
     * @return bool
     */
    public static function supportsOptionsSelected(): bool
    {
        return static::SUPPORTS_OPTIONS_SELECTED;
    }

    // --------------------------------------------------------------------------

    /**
     * Returns whether the field type supports setting an option as disabled
     *
     * @return bool
     */
    public static function supportsOptionsDisabled(): bool
    {
        return static::SUPPORTS_OPTIONS_DISABLE;
    }

    // --------------------------------------------------------------------------

    /**
     * Returns whether the field type supports default values
     *
     * @return bool
     */
    public static function supportsDefaultValues(): bool
    {
        return static::SUPPORTS_DEFAULTS;
    }

    // --------------------------------------------------------------------------

    /**
     * Returns whether the field type supports placeholder values
     *
     * @return bool
     */
    public static function supportsPlaceholder(): bool
    {
        return static::SUPPORTS_PLACEHOLDER;
    }

    // --------------------------------------------------------------------------

    /**
     * Returns whether the field type supports being marked as required
     *
     * @return bool
     */
    public static function supportsRequired(): bool
    {
        return static::SUPPORTS_REQUIRED;
    }

    // --------------------------------------------------------------------------

    /**
     * Returns whether the field type supports custom attributes values
     *
     * @return bool
     */
    public static function supportsCustomAttributes(): bool
    {
        return static::SUPPORTS_CUSTOM_ATTRIBUTES;
    }

    // --------------------------------------------------------------------------

    /**
     * Returns whether the field type can be selected by human users
     *
     * @return bool
     */
    public static function isSelectable(): bool
    {
        return static::IS_SELECTABLE;
    }

    // --------------------------------------------------------------------------

    /**
     * Validate and clean the user's entry
     *
     * @param mixed $mInput The form input's value
     * @param Field $oField The complete field object
     *
     * @throws FieldTypeExceptionRequired
     * @throws FieldTypeExceptionInvalidOption
     * @return mixed
     */
    public function validate($mInput, Field $oField)
    {
        //  Test for required fields
        if (!empty($oField->is_required) && empty($mInput)) {
            throw new FieldTypeExceptionRequired('This field is required.', 1);
        }

        //  If the field accepts options then ensure that the value is a valid option for the field
        if (static::SUPPORTS_OPTIONS) {

            $aValidValues = [];

            foreach ($oField->options->data as $oOption) {
                $aValidValues[] = $oOption->id;
            }

            /**
             * Cast the field to an array so that fields which accept multiple values
             * (e.g checkboxes) validate in the same way.
             */

            $aInput = (array) $mInput;

            foreach ($aInput as $sInput) {
                if (empty($sInput) && $oField->is_required) {
                    throw new FieldTypeExceptionInvalidOption('This field is required.', 1);
                } elseif (!empty($mInput) && !in_array($sInput, $aValidValues)) {
                    throw new FieldTypeExceptionInvalidOption('Please choose a valid option.', 1);
                }
            }
        }

        return $mInput;
    }

    // --------------------------------------------------------------------------

    /**
     * Extracts the OPTION component of the response
     *
     * @param string $sKey   The answer's key
     * @param string $mValue The answer's value
     *
     * @return int|null
     */
    public function extractOptionId(string $sKey, $mValue): ?int
    {
        if (static::SUPPORTS_OPTIONS) {
            return $mValue;
        }

        return null;
    }

    // --------------------------------------------------------------------------

    /**
     * Extracts the TEXT component of the response
     *
     * @param string $sKey       The answer's key
     * @param string $mValue     The answer's value
     * @param bool   $bPlainText Whether to force plaintext
     *
     * @return string
     */
    public function extractText(string $sKey, $mValue, bool $bPlainText = false): ?string
    {
        if (!static::SUPPORTS_OPTIONS) {
            return trim(strip_tags($mValue));
        }

        return null;
    }

    // --------------------------------------------------------------------------

    /**
     * Extracts any DATA which the Field Type might want to store
     *
     * @param string $sKey   The answer's key
     * @param string $mValue The answer's value
     *
     * @return mixed
     */
    public function extractData(string $sKey, $mValue)
    {
        return null;
    }

    // --------------------------------------------------------------------------

    /**
     * Takes responses for this field type and aggregates them into data suitable for stats/charting
     *
     * @param array $aResponses The array of responses from ResponseAnswer
     *
     * @return array[]
     */
    public function getStatsChartData(array $aResponses): array
    {
        $aOut = [
            'columns' => [
                ['string', 'Label'],
                ['number', 'Responses'],
            ],
            'rows'    => [],
        ];

        if (!static::SUPPORTS_OPTIONS) {
            return $aOut;
        }

        //  Work out all the options and assign a value
        $aRows = [];
        foreach ($aResponses as $oResponse) {
            if (!empty($oResponse->option)) {
                if (!array_key_exists($oResponse->option->label, $aRows)) {
                    $aRows[$oResponse->option->label] = 0;
                }
                $aRows[$oResponse->option->label]++;
            }
        }

        foreach ($aRows as $sLabel => $iValue) {
            $aOut['rows'][] = [
                $sLabel,
                $iValue,
            ];
        }

        //  Return the details for a single chart (i.e only 1 item in this array)
        return [$aOut];
    }

    // --------------------------------------------------------------------------

    /**
     * Takes responses for this field type and extracts all the text components
     *
     * @param array $aResponses The array of responses from ResponseAnswer
     *
     * @return string[]
     */
    public function getStatsTextData(array $aResponses): array
    {
        $aOut     = [];
        $aStrings = [];

        foreach ($aResponses as $oResponse) {
            if (!empty($oResponse->text)) {
                if (!array_key_exists($oResponse->text, $aStrings)) {
                    $aStrings[$oResponse->text] = 0;
                }
                $aStrings[$oResponse->text]++;
            }
        }

        foreach ($aStrings as $sString => $iCount) {
            if ($iCount > 1) {
                $sString .= ' <span class="count" title="This item repeats ' . $iCount . ' times">' . $iCount . '</span>';
            }
            $aOut[] = $sString;
        }

        return $aOut;
    }
}
