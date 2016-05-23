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

use Nails\Factory;
use Nails\FormBuilder\FieldType\Base;
use Nails\FormBuilder\Exception\FieldTypeException;
use Nails\FormBuilder\Exception\FieldTypeExceptionInvalidOption;

class Likert extends Base
{
    const LABEL                     = 'Likert - Agreement';
    const SUPPORTS_DEFAULTS         = false;
    const SUPPORTS_OPTIONS          = true;
    const SUPPORTS_OPTIONS_SELECTED = false;

    // --------------------------------------------------------------------------

    /**
     * The terms to use in this likert question
     * @var array
     */
    protected $aLikertTerms = array(
        'Strongly Agree',
        'Agree',
        'Undecided',
        'Disagree',
        'Strongly Disagree'
    );

    // --------------------------------------------------------------------------

    /**
     * Renders the field's HTML
     * @param  $aData The field's data
     * @return string
     */
    public function render($aData)
    {
        if (empty($aData['likertTerms'])) {
            $aData['likertTerms'] = $this->aLikertTerms;
        }

        $sOut  = get_instance()->load->view('formbuilder/fields/open', $aData, true);
        $sOut .= get_instance()->load->view('formbuilder/fields/body-likert', $aData, true);
        $sOut .= get_instance()->load->view('formbuilder/fields/close', $aData, true);

        return $sOut;
    }

    // --------------------------------------------------------------------------

    /**
     * Override the parent method to check options are valid and within range
     * @param  mixed    $mInput The form input's value
     * @param  stdClass $oField The complete field object
     * @return boolean
     */
    public function validate($mInput, $oField)
    {
        try {

            parent::validate($mInput, $oField);

        //  This field will throw FieldTypeExceptionInvalidOption exception as the
        //  form is build using the option value as the key rather than the value.
        } catch (FieldTypeExceptionInvalidOption $e) {

            $bIsValid     = true;
            $aValidValues = array();

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
                    'Please provide a response for each item.',
                    1
                );
            }

            foreach ($aInput as $iOptionId => $iLikertValue) {

                if (!array_key_exists($iOptionId, $aValidValues)) {
                    throw new FieldTypeExceptionInvalidOption(
                        'You gave an answer for an invalid row.',
                        1
                    );
                }

                if ($iLikertValue < 0 || $iLikertValue > 4) {
                    throw new FieldTypeException(
                        'Invalid response for "' . $aValidValues[$iOptionId] . '".',
                        1
                    );
                }
            }
        }

        return $mInput;
    }

    // --------------------------------------------------------------------------

    /**
     * Extracts the OPTION component of the response
     * @param  string $sKey   The answer's key
     * @param  string $mValue The answer's value
     * @return integer
     */
    public function extractOptionId($sKey, $mValue)
    {
        if (static::SUPPORTS_OPTIONS) {
            return $sKey;
        }

        return null;
    }

    // --------------------------------------------------------------------------

    /**
     * Extracts the TEXT component of the response
     * @param  string $sKey   The answer's key
     * @param  string $mValue The answer's value
     * @return integer
     */
    public function extractText($sKey, $mValue)
    {
        return array_key_exists($mValue, $this->aLikertTerms) ? $this->aLikertTerms[$mValue] : '';
    }

    // --------------------------------------------------------------------------

    /**
     * Extracts any DATA which the Field Type might want to store
     * @param  string $sKey   The answer's key
     * @param  string $mValue The answer's value
     * @return integer
     */
    public function extractData($sKey, $mValue)
    {
        return $mValue;
    }

    // --------------------------------------------------------------------------

    /**
     * Takes responses for this field type and aggregates them into data suitable for stats/charting
     * @param  array $aResponses The array of responses from ResponseAnswer
     * @return array
     */
    public function getStatsChartData($aResponses)
    {
        //  Work out all the options and assign a value
        $aCharts = array();
        foreach ($aResponses as $oResponse) {
            if (!empty($oResponse->option)) {
                if (!array_key_exists($oResponse->option->label, $aCharts)) {
                    $aCharts[$oResponse->option->label] = array(0, 0, 0, 0, 0);
                }
                $aCharts[$oResponse->option->label][$oResponse->data]++;
            }
        }

        $aOut = array();

        foreach ($aCharts as $sLabel => $aRows) {

            $aOut[] = array(
                'title'   => $sLabel,
                'columns' => array(
                    array('string', 'Label'),
                    array('number', 'Responses')
                ),
                'rows'    => array(
                    array($this->aLikertTerms[0], $aRows[0]),
                    array($this->aLikertTerms[1], $aRows[1]),
                    array($this->aLikertTerms[2], $aRows[2]),
                    array($this->aLikertTerms[3], $aRows[3]),
                    array($this->aLikertTerms[4], $aRows[4])
                )
            );
        }

        return $aOut;
    }

    // --------------------------------------------------------------------------

    /**
     * Takes responses for this field type and extracts all the text components
     * @param  array $aResponses The array of responses from ResponseAnswer
     * @return array
     */
    public function getstatsTextData($aResponses)
    {
        return array();
    }
}
