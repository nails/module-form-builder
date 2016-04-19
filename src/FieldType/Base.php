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
     * @return boolean|string   boolean true if valid, string with error if invalid
     */
    public function validate($mInput, $oField)
    {
        //  Test for required fields
        if (!empty($oField->is_required) && empty($mInput)) {
            throw new FieldTypeException('This field is required.', 1);
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
                    throw new FieldTypeException('Please choose a valid option.', 1);
                }
            }
        }

        return true;
    }

    // --------------------------------------------------------------------------

    /**
     * Clean the user's input into a string (or array of strings) suitable for humans browsing in admin
     * @param  mixed    $mInput The form input's value
     * @param  stdClass $oField The complete field object
     * @return mixed
     */
    public function clean($mInput, $oField)
    {
        return $mInput;
    }
}
