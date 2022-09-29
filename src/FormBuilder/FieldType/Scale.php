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
use Nails\FormBuilder\Resource\Form\Field;

/**
 * Class Scale
 *
 * @package Nails\FormBuilder\FormBuilder\FieldType
 */
class Scale extends Base
{
    const LABEL                = 'Scale (1-10)';
    const NUM_OPTIONS          = 10;
    const SUPPORTS_PLACEHOLDER = false;
    const RENDER_VIEWS         = [
        'formbuilder/fields/open',
        'formbuilder/fields/body-scale',
        'formbuilder/fields/close',
    ];

    // --------------------------------------------------------------------------

    /**
     * Renders the field's HTML
     *
     * @param array $aConfig The field's data
     *
     * @return string
     */
    public function render(array $aConfig): string
    {
        $aConfig['num_options'] = static::NUM_OPTIONS;

        return parent::render($aConfig);
    }

    // --------------------------------------------------------------------------

    /**
     * Override the parent method to check options are valid and within range
     *
     * @param mixed $mInput The form input's value
     * @param Field $oField The complete field object
     *
     * @throws FieldTypeExceptionInvalidOption
     * @throws FieldTypeException
     * @return boolean
     */
    public function validate($mInput, Field $oField)
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
     * @param array $aResponses The array of responses from ResponseAnswer
     *
     * @return array
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
     * @param array $aResponses The array of responses from ResponseAnswer
     *
     * @return array
     */
    public function getStatsTextData(array $aResponses): array
    {
        return [];
    }
}
