<?php

/**
 * This class provides the "Scale" field type
 *
 * @package     Nails
 * @subpackage  module-form-builder
 * @category    Controller
 * @author      Nails Dev Team
 * @link
 */

namespace Nails\FormBuilder\FormBuilder\FieldType;

use Nails\Factory;
use Nails\FormBuilder\Exception\FieldTypeException;
use Nails\FormBuilder\Exception\FieldTypeExceptionInvalidOption;
use Nails\FormBuilder\FieldType\Base;

class Scale extends Base
{
    const LABEL       = 'Scale (1-10)';
    const NUM_OPTIONS = 10;

    // --------------------------------------------------------------------------

    /**
     * Renders the field's HTML
     *
     * @param  array $aData The field's data
     *
     * @return string
     */
    public function render($aData)
    {
        $aData['num_options'] = static::NUM_OPTIONS;

        $oView = Factory::service('View');
        $sOut  = $oView->load('formbuilder/fields/open', $aData, true);
        $sOut  .= $oView->load('formbuilder/fields/body-scale', $aData, true);
        $sOut  .= $oView->load('formbuilder/fields/close', $aData, true);

        return $sOut;
    }

    // --------------------------------------------------------------------------

    /**
     * Override the parent method to check options are valid and within range
     *
     * @param  mixed     $mInput The form input's value
     * @param  \stdClass $oField The complete field object
     *
     * @throws FieldTypeExceptionInvalidOption
     * @throws FieldTypeException
     * @return boolean
     */
    public function validate($mInput, $oField)
    {
        $iInput = (int) $mInput;
        parent::validate($iInput, $oField);

        //  Ensure that the value is within a given range
        if (!empty($iInput)) {
            if ($iInput < 1 || $iInput > static::NUM_OPTIONS) {
                throw new FieldTypeExceptionInvalidOption('"' . $iInput . '" is not a valid response.', 1);
            }
        }

        return $iInput;
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

        foreach ($aResponses as $oResponse) {

            if (!isset($aOut['rows'][$oResponse->text])) {
                $aOut['rows'][$oResponse->text] = [$oResponse->text, 0];
            }

            $aOut['rows'][$oResponse->text][1]++;
        }

        $aOut['rows'] = array_values($aOut['rows']);

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
        return array();
    }
}
