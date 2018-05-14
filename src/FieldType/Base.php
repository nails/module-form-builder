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

use Nails\FormBuilder\Exception\FieldTypeException;
use Nails\FormBuilder\Exception\FieldTypeExceptionInvalidOption;
use Nails\FormBuilder\Exception\FieldTypeExceptionRequired;

class Base
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
     * @var boolean
     */
    const SUPPORTS_OPTIONS = false;

    /**
     * Whether this field type supports setting an option as selected
     *
     * @var boolean
     */
    const SUPPORTS_OPTIONS_SELECTED = true;

    /**
     * Whether this field type supports setting an option as disabled
     *
     * @var boolean
     */
    const SUPPORTS_OPTIONS_DISABLE = true;

    /**
     * Whether this field type supports a default value
     *
     * @var boolean
     */
    const SUPPORTS_DEFAULTS = false;

    /**
     * Whether the field type can be selected by human users
     *
     * @var boolean
     */
    const IS_SELECTABLE = true;

    // --------------------------------------------------------------------------

    /**
     * Renders the field's HTML
     *
     * @param  array $aConfig The config array
     *
     * @throws FieldTypeException
     * @return string
     */
    public function render($aConfig)
    {
        throw new FieldTypeException('Field Type should define the render() method.', 1);
    }

    // --------------------------------------------------------------------------

    /**
     * Validate and clean the user's entry
     *
     * @param  mixed     $mInput The form input's value
     * @param  \stdClass $oField The complete field object
     *
     * @throws FieldTypeExceptionRequired
     * @throws FieldTypeExceptionInvalidOption
     * @return mixed
     */
    public function validate($mInput, $oField)
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
                if (!in_array($sInput, $aValidValues)) {
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
     * @param  string $sKey   The answer's key
     * @param  string $mValue The answer's value
     *
     * @return integer
     */
    public function extractOptionId($sKey, $mValue)
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
     * @param  string $sKey   The answer's key
     * @param  string $mValue The answer's value
     *
     * @return integer
     */
    public function extractText($sKey, $mValue)
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
     * @param  string $sKey   The answer's key
     * @param  string $mValue The answer's value
     *
     * @return integer
     */
    public function extractData($sKey, $mValue)
    {
        return null;
    }

    // --------------------------------------------------------------------------

    /**
     * Takes responses for this field type and aggregates them into data suitable for stats/charting
     *
     * @param  array $aResponses The array of responses from ResponseAnswer
     *
     * @return array
     */
    public function getStatsChartData($aResponses)
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
     * @param  array $aResponses The array of responses from ResponseAnswer
     *
     * @return array
     */
    public function getStatsTextData($aResponses)
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
