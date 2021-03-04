<?php

/**
 * This class provides the "Likert" field type base, using default terms for agreement
 *
 * @package     Nails
 * @subpackage  module-form-builder
 * @category    Controller
 * @author      Nails Dev Team
 * @link
 */

namespace Nails\FormBuilder\FormBuilder\FieldType;

use Nails\Common\Exception\FactoryException;
use Nails\Common\Exception\ViewNotFoundException;
use Nails\Factory;
use Nails\FormBuilder\Exception\FieldTypeException;
use Nails\FormBuilder\Exception\FieldTypeExceptionInvalidOption;
use Nails\FormBuilder\FieldType\Base;

/**
 * Class Likert
 *
 * @package Nails\FormBuilder\FormBuilder\FieldType
 */
class Likert extends Base
{
    const LABEL                     = 'Likert - Agreement';
    const SUPPORTS_DEFAULTS         = false;
    const SUPPORTS_OPTIONS          = true;
    const SUPPORTS_OPTIONS_SELECTED = false;
    const RENDER_VIEWS              = [
        'formbuilder/fields/open',
        'formbuilder/fields/body-likert',
        'formbuilder/fields/close',
    ];

    /**
     * The terms to use in this likert question
     *
     * @var string[]
     */
    const LIKERT_TERMS = [
        'Strongly Agree',
        'Agree',
        'Undecided',
        'Disagree',
        'Strongly Disagree',
    ];

    // --------------------------------------------------------------------------

    /**
     * @inheritDoc
     */
    public function render(array $aConfig): string
    {
        $aConfig['aLikertTerms'] = static::LIKERT_TERMS;
        return parent::render($aConfig);
    }

    // --------------------------------------------------------------------------

    /**
     * Override the parent method to check options are valid and within range
     *
     * @param mixed     $mInput The form input's value
     * @param \stdClass $oField The complete field object
     *
     * @throws FieldTypeExceptionInvalidOption
     * @throws FieldTypeException
     * @return boolean
     */
    public function validate($mInput, $oField)
    {
        try {

            //  This field will throw FieldTypeExceptionInvalidOption exception as the
            //  form is built using the option value as the key rather than the value.
            parent::validate($mInput, $oField);

        } catch (FieldTypeExceptionInvalidOption $e) {

            $aValidValues = [];

            foreach ($oField->options->data as $oOption) {
                if (!$oOption->is_disabled) {
                    $aValidValues[$oOption->id] = $oOption->label;
                }
            }

            /**
             * Cast the field to an array so that fields which accept multiple values
             * (e.g checkboxes) validate in the same way.
             */

            $aInput = (array) $mInput;

            if (!empty($oField->is_required) && count($aInput) !== count($aValidValues)) {
                throw new FieldTypeException(
                    'Please provide a response for each item.'
                );
            }

            foreach ($aInput as $iOptionId => $iLikertValue) {

                if (!array_key_exists($iOptionId, $aValidValues)) {
                    throw new FieldTypeExceptionInvalidOption(
                        'You gave an answer for an invalid row.'
                    );
                }

                if ($iLikertValue < 0 || $iLikertValue > (count(static::LIKERT_TERMS) - 1)) {
                    throw new FieldTypeException(
                        'Invalid response for "' . $aValidValues[$iOptionId] . '".'
                    );
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
     * @param mixed  $mValue The answer's value
     *
     * @return int|null
     */
    public function extractOptionId(string $sKey, $mValue): ?int
    {
        if (static::SUPPORTS_OPTIONS) {
            return $sKey;
        }

        return null;
    }

    // --------------------------------------------------------------------------

    /**
     * Extracts the TEXT component of the response
     *
     * @param string $sKey       The answer's key
     * @param mixed  $mValue     The answer's value
     * @param bool   $bPlainText Whether to force plaintext
     *
     * @return string
     */
    public function extractText(string $sKey, $mValue, bool $bPlainText = false): ?string
    {
        return array_key_exists($mValue, static::LIKERT_TERMS)
            ? static::LIKERT_TERMS[$mValue]
            : '';
    }

    // --------------------------------------------------------------------------

    /**
     * Extracts any DATA which the Field Type might want to store
     *
     * @param string $sKey   The answer's key
     * @param mixed  $mValue The answer's value
     *
     * @return mixed
     */
    public function extractData(string $sKey, $mValue)
    {
        return $mValue;
    }

    // --------------------------------------------------------------------------

    /**
     * Takes responses for this field type and aggregates them into data suitable for stats/charting
     *
     * @param array $aResponses The array of responses from ResponseAnswer
     *
     * @return array
     */
    public function getStatsChartData(array $aResponses): array
    {
        //  Work out all the options and assign a value
        $aCharts = [];
        foreach ($aResponses as $oResponse) {
            if (!empty($oResponse->option)) {
                if (!array_key_exists($oResponse->option->label, $aCharts)) {
                    $aCharts[$oResponse->option->label] = [0, 0, 0, 0, 0];
                }
                $aCharts[$oResponse->option->label][$oResponse->data]++;
            }
        }

        $aOut = [];

        foreach ($aCharts as $sLabel => $aRows) {

            $aOut[] = [
                'title'   => $sLabel,
                'columns' => [
                    ['string', 'Label'],
                    ['number', 'Responses'],
                ],
                'rows'    => [
                    [static::LIKERT_TERMS[0], $aRows[0]],
                    [static::LIKERT_TERMS[1], $aRows[1]],
                    [static::LIKERT_TERMS[2], $aRows[2]],
                    [static::LIKERT_TERMS[3], $aRows[3]],
                    [static::LIKERT_TERMS[4], $aRows[4]],
                ],
            ];
        }

        return $aOut;
    }

    // --------------------------------------------------------------------------

    /**
     * Takes responses for this field type and extracts all the text components
     *
     * @param array $aResponses The array of responses from ResponseAnswer
     *
     * @return array
     */
    public function getStatsTextData(array $aResponses): array
    {
        return [];
    }
}
