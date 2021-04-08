<?php

/**
 * This helper brings some convenient functions for interacting with the form builder
 *
 * @package     Nails
 * @subpackage  module-form-builder
 * @category    Helper
 * @author      Nails Dev Team
 */

namespace Nails\FormBuilder\Helper;

use Nails\Captcha;
use Nails\Common\Exception\FactoryException;
use Nails\Common\Exception\ValidationException;
use Nails\Factory;
use Nails\FormBuilder\Constants;
use Nails\FormBuilder\Service\DefaultValue;
use Nails\FormBuilder\Service\FieldType;

/**
 * Class FormBuilder
 *
 * @package Nails\FormBuilder\Helper
 */
class FormBuilder
{
    /**
     * Cleans up post data submitted by the admin form builder
     *
     * @param int   $iFormId     The form ID, if any
     * @param bool  $bHasCaptcha Whether the form should have a captcha
     * @param array $aFields     The fields to parse
     *
     * @return array
     */
    public static function adminNormalizeFormData($iFormId = null, $bHasCaptcha = false, $aFields = [])
    {
        $iFieldOrder = 0;
        $aOut        = [
            'id'          => (int) $iFormId ?: null,
            'has_captcha' => (bool) $bHasCaptcha ?: false,
            'fields'      => [],
        ];

        if (!empty($aFields)) {

            foreach ($aFields as $aField) {

                $aTemp = [
                    'id'                => !empty($aField['id']) ? (int) $aField['id'] : null,
                    'form_id'           => $aOut['id'],
                    'type'              => !empty($aField['type']) ? $aField['type'] : 'TEXT',
                    'label'             => !empty($aField['label']) ? $aField['label'] : '',
                    'sub_label'         => !empty($aField['sub_label']) ? $aField['sub_label'] : '',
                    'placeholder'       => !empty($aField['placeholder']) ? $aField['placeholder'] : '',
                    'is_required'       => !empty($aField['is_required']) ? (bool) $aField['is_required'] : false,
                    'default_value'     => !empty($aField['default_value']) ? $aField['default_value'] : '',
                    'custom_attributes' => !empty($aField['custom_attributes']) ? $aField['custom_attributes'] : '',
                    'order'             => $iFieldOrder,
                    'options'           => [],
                ];

                if (!empty($aField['options'])) {

                    $iOptionOrder = 0;

                    foreach ($aField['options'] as $aOption) {

                        $aTemp['options'][] = [
                            'id'          => !empty($aOption['id']) ? (int) $aOption['id'] : null,
                            'label'       => !empty($aOption['label']) ? $aOption['label'] : '',
                            'is_selected' => !empty($aOption['is_selected']) ? $aOption['is_selected'] : false,
                            'is_disabled' => !empty($aOption['is_disabled']) ? $aOption['is_disabled'] : false,
                            'order'       => $iOptionOrder,
                        ];

                        $iOptionOrder++;
                    }
                }

                $aOut['fields'][] = $aTemp;
                $iFieldOrder++;
            }
        }

        return $aOut;
    }

    // --------------------------------------------------------------------------

    /**
     * Validates post data submitted by the admin form builder
     *
     * @param array $aFormData The form data to validate
     *
     * @return void
     * @throws ValidationException
     */
    public static function adminValidateFormData(array $aFormData): void
    {
        $aNormalized = static::adminNormalizeFormData(null, $aFormData);
        $aErrors     = [];

        //  @todo (Pablo 15/02/2021) - Check fields for errors, and throw ValidationException
    }

    // --------------------------------------------------------------------------

    /**
     * Loads the markup for the form builder
     *
     * @param string $sId     The ID to give the form
     * @param array  $aFields Any existing fields to pre-render
     *
     * @return string
     * @throws FactoryException
     */
    public static function adminLoadView($sId, $sFieldName = 'fields', $aFields = [])
    {
        /** @var FieldType $oFieldTypeService */
        $oFieldTypeService = Factory::service('FieldType', Constants::MODULE_SLUG);
        /** @var DefaultValue $oDefaultValueService */
        $oDefaultValueService = Factory::service('DefaultValue', Constants::MODULE_SLUG);

        return Factory::service('View')
            ->load(
                'formbuilder/admin/fields',
                [
                    'sId'            => $sId,
                    'sFieldName'     => $sFieldName,
                    'aFields'        => $aFields,
                    'aFieldTypes'    => $oFieldTypeService->getAll(true),
                    'aDefaultValues' => ['No Default Value'] + $oDefaultValueService->getAllFlat(true),
                ],
                true
            );
    }

    // --------------------------------------------------------------------------

    /**
     * Renders the markup for a form
     *
     * @param array $aFormData The data to build the form with
     *
     * @return string
     * @throws FactoryException
     */
    public static function render($aFormData)
    {
        /** @var FieldType $oFieldTypeService */
        $oFieldTypeService = Factory::service('FieldType', Constants::MODULE_SLUG);
        /** @var DefaultValue $oDefaultValueService */
        $oDefaultValueService = Factory::service('DefaultValue', Constants::MODULE_SLUG);

        // --------------------------------------------------------------------------

        $sUuid         = getFromArray('form_uuid', $aFormData, md5(microtime(true)));
        $sFormAction   = getFromArray('form_action', $aFormData);
        $sFormMethod   = getFromArray('form_method', $aFormData, 'POST');
        $sFormAttr     = getFromArray('form_attr', $aFormData);
        $sFormHeader   = getFromArray('form_header', $aFormData);
        $sFormFooter   = getFromArray('form_footer', $aFormData);
        $bHasCaptcha   = getFromArray('has_captcha', $aFormData);
        $sCaptchaError = getFromArray('captcha_error', $aFormData);
        $aFields       = getFromArray('fields', $aFormData, []);
        $sButtonClass  = getFromArray('button_class', $aFormData, 'text-center');

        if (!empty($aFormData['buttons'])) {
            $aButtons = $aFormData['buttons'];

        } else {
            $aButtons = [
                [
                    'type'  => 'submit',
                    'class' => 'btn btn-primary',
                    'label' => 'Submit',
                    'attr'  => '',
                ],
            ];
        }

        //  Start building the form
        $sOut = form_open_multipart($sFormAction, 'method="' . $sFormMethod . '" ' . $sFormAttr);
        $sOut .= form_hidden('submitting', true);
        $sOut .= $sFormHeader;

        //  Render the form fields
        $iCounter = 0;

        foreach ($aFields as $oField) {

            $oFieldType = $oFieldTypeService->getBySlug($oField->type);

            $sId   = 'form-' . $sUuid . '-' . $iCounter;
            $aAttr = [
                $sId ? 'id="' . $sId . '"' : '',
                $oField->placeholder ? 'placeholder="' . htmlspecialchars($oField->placeholder) . '"' : '',
                $oField->is_required ? 'required="required"' : '',
                $oField->custom_attributes,
            ];

            if (!empty($oFieldType)) {

                $oDefaultValue = $oDefaultValueService->getBySlug($oField->default_value);
                $sDefaultValue = !empty($oDefaultValue)
                    ? $oDefaultValue->defaultValue()
                    : null;

                $sOut .= $oFieldType->render([
                    'id'          => $sId,
                    'key'         => 'field[' . $oField->id . ']',
                    'label'       => $oField->label,
                    'sub_label'   => $oField->sub_label,
                    'default'     => $sDefaultValue,
                    'value'       => $_POST['field'][$oField->id] ?? $oField->value ?? $sDefaultValue,
                    'data'        => $oField->data ?? null,
                    'required'    => $oField->is_required,
                    'class'       => 'form-control',
                    'placeholder' => $oField->placeholder,
                    'attributes'  => implode(' ', $aAttr),
                    'options'     => $oField->options->data,
                    'error'       => !empty($oField->error) ? $oField->error : null,
                ]);
            }

            $iCounter++;
        }

        //  Render the captcha
        if ($bHasCaptcha) {

            Factory::helper('captcha', Captcha\Constants::MODULE_SLUG);

            $oCaptcha = captchaGenerate();

            if (!empty($oCaptcha)) {

                $oFieldType = $oFieldTypeService->getBySlug(\Nails\FormBuilder\FormBuilder\FieldType\Captcha::class);

                if (!empty($oFieldType)) {

                    $sId   = 'form-' . $sUuid . '-' . $iCounter;
                    $aAttr = [
                        $sId ? 'id="' . $sId . '"' : '',
                    ];

                    $sOut .= $oFieldType->render([
                        'id'         => $sId,
                        'key'        => 'captcha_response',
                        'label'      => '',
                        'sub_label'  => null,
                        'default'    => null,
                        'value'      => null,
                        'required'   => null,
                        'class'      => 'form-control',
                        'attributes' => implode(' ', $aAttr),
                        'options'    => null,
                        'error'      => !empty($sCaptchaError) ? $sCaptchaError : null,
                        'captcha'    => $oCaptcha,
                    ]);
                }
            }
        }

        //  Render any buttons
        if (!empty($aButtons)) {

            $sOut .= '<p class="' . $sButtonClass . '">';
            foreach ($aButtons as $aButton) {

                $sTag   = getFromArray('tag', $aButton) ?: 'button';
                $sType  = getFromArray('type', $aButton) ?: 'submit';
                $sClass = getFromArray('class', $aButton) ?: 'btn btn-primary';
                $sName  = getFromArray('name', $aButton);
                $sValue = getFromArray('value', $aButton);
                $sLabel = getFromArray('label', $aButton) ?: 'Submit';
                $sAttr  = getFromArray('attr', $aButton);

                $aAttr = array_filter([
                    $sType ? 'type="' . $sType . '"' : '',
                    $sClass ? 'class="' . $sClass . '"' : '',
                    $sName ? 'name="' . $sName . '"' : '',
                    $sValue ? 'value="' . $sValue . '"' : '',
                    $sAttr,
                ]);


                $sOut .= '<' . $sTag . ' ' . implode(' ', $aAttr) . '>';
                $sOut .= $sLabel;
                $sOut .= '</' . $sTag . '>';
            }
            $sOut .= '</p>';
        }

        $sOut .= $sFormFooter;
        $sOut .= form_close();

        return $sOut;
    }

    // --------------------------------------------------------------------------

    /**
     * Validates $aUserData against $aFormData
     *
     * @param array $aFormFields The form fields
     * @param array $aUserData   The posted user data
     *
     * @return bool|array
     * @throws FactoryException
     */
    public static function validate($aFormFields, $aUserData)
    {
        $oFieldTypeService = Factory::service('FieldType', Constants::MODULE_SLUG);
        $bIsValid          = true;

        foreach ($aFormFields as &$oField) {

            $oFieldType = $oFieldTypeService->getBySlug($oField->type);

            if (!empty($oFieldType)) {

                try {

                    if (!array_key_exists($oField->id, $aUserData)) {
                        $aUserData[$oField->id] = null;
                    }
                    $aUserData[$oField->id] = $oFieldType->validate($aUserData[$oField->id], $oField);

                } catch (\Exception $e) {

                    $oField->error = $e->getMessage();
                    $bIsValid      = false;
                }
            }
        }

        return $bIsValid;
    }

    // --------------------------------------------------------------------------

    /**
     * Parses a user's response into the various components, designed for then saving to the database
     *
     * @param array $aFormFields The form fields
     * @param array $aUserData   The posted user data
     *
     * @return bool|array
     * @throws FactoryException
     */
    public static function parseResponse($aFormFields, $aUserData)
    {
        $aUserData         = array_filter($aUserData);
        $oFieldTypeService = Factory::service('FieldType', Constants::MODULE_SLUG);
        $aUserDataParsed   = [];
        $aOut              = [];

        foreach ($aUserData as $iFieldId => $mValue) {

            $oField = null;
            foreach ($aFormFields as $oFormField) {
                if ($oFormField->id == $iFieldId) {
                    $oField = $oFormField;
                    break;
                }
            }

            $aUserDataParsed[] = (object) [
                'id'    => $iFieldId,
                'value' => (array) $mValue,
                'field' => $oField,
            ];
        }

        for ($i = 0; $i < count($aUserDataParsed); $i++) {

            $oField     = $aUserDataParsed[$i]->field;
            $oFieldType = $oFieldTypeService->getBySlug($oField->type);

            if (!empty($oFieldType)) {
                foreach ($aUserDataParsed[$i]->value as $sKey => $mValue) {
                    $aOut[] = (object) [
                        'field_id'  => $oField->id,
                        'option_id' => $oFieldType->extractOptionId($sKey, $mValue),
                        'text'      => $oFieldType->extractText($sKey, $mValue),
                        'data'      => $oFieldType->extractData($sKey, $mValue),
                    ];
                }
            }
        }

        return $aOut;
    }
}
