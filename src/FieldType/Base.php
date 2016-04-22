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

use Nails\FormBuilder\Exception\FieldTypeExceptionRequired;
use Nails\FormBuilder\Exception\FieldTypeExceptionInvalidOption;

class Base
{
    /**
     * The human friendly label to give this field type
     * @var string
     */
    const LABEL = '';

    /**
     * Whether this field type supports multiple options (i.e like a dropdown list)
     * @var boolean
     */
    const SUPPORTS_OPTIONS = false;

    /**
     * Whether this field type supports setting an option as selected
     * @var boolean
     */
    const SUPPORTS_OPTIONS_SELECTED = true;

    /**
     * Whether this field type supports setting an option as disabled
     * @var boolean
     */
    const SUPPORTS_OPTIONS_DISABLE = true;

    /**
     * Whether this field type supports a default value
     * @var boolean
     */
    const SUPPORTS_DEFAULTS = false;

    /**
     * Whether the field type can be selected by human users
     * @var boolean
     */
    const IS_SELECTABLE = true;

    /**
     * Any custom validation rules for this field type
     * @var string
     */
    const VALIDATION_RULES = '';

    // --------------------------------------------------------------------------

    /**
     * Renders the field's HTML
     * @param  $aConfig The config array
     * @return string
     */
    public function render($aConfig)
    {
        throw new FieldTypeException('Field Type should define the render() method.', 1);
    }

    // --------------------------------------------------------------------------

    /**
     * Validate the user's entry
     * @param  mixed    $mInput The form input's value
     * @param  stdClass $oField The complete field object
     * @return boolean
     */
    public function validate($mInput, $oField)
    {
        //  Test for required fields
        if (!empty($oField->is_required) && empty($mInput)) {
            throw new FieldTypeExceptionRequired('This field is required.', 1);
        }

        //  If the field accepts options then ensure that the value is a valid option for the field
        if (static::SUPPORTS_OPTIONS) {

            $bIsValid     = true;
            $aValidValues = array();

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

        return true;
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
            return $mValue;
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
        if (!static::SUPPORTS_OPTIONS) {
            return trim($mValue);
        }

        return null;
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
        return null;
    }
}
