<?php

/**
 * This helper brings some convinient functions for interacting with the form builder
 *
 * @package     Nails
 * @subpackage  module-form-builder
 * @category    Helper
 * @author      Nails Dev Team
 * @link
 */

use Nails\Factory;
use Nails\FormBuilder\Exceptions\ValidationException;

if (!function_exists('adminNormalizeFormData')) {

    /**
     * Cleans up post data submitted by the admin form builder
     * @param  integer $iFormId The form ID, if any
     * @param  array   $aFields The fields to parse
     * @return array
     */
    function adminNormalizeFormData($iFormId = null, $aFields = array())
    {
        $iFieldOrder = 0;
        $aOut        = array(
            'id'     => (int) $iFormId ?: null,
            'fields' => array()
        );

        if (!empty($aFields)) {

            foreach ($aFields as $aField) {

                $aTemp = array(
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
                    'options'           => array()
                );

                if (!empty($aField['options'])) {

                    $iOptionOrder = 0;

                    foreach ($aField['options'] as $aOption) {

                        $aTemp['options'][] = array(
                            'id'          => !empty($aOption['id']) ? (int) $aOption['id'] : null,
                            'label'       => !empty($aOption['label']) ? $aOption['label'] : '',
                            'is_selected' => !empty($aOption['is_selected']) ? $aOption['is_selected'] : false,
                            'is_disabled' => !empty($aOption['is_disabled']) ? $aOption['is_disabled'] : false,
                            'order'       => $iOptionOrder
                        );

                        $iOptionOrder++;
                    }
                }

                $aOut['fields'][] = $aTemp;
                $iFieldOrder++;
            }
        }

        return $aOut;
    }
}

if (!function_exists('adminValidateFormData')) {

    /**
     * Validates post data submitted by the admin form builder
     * @param  string $aFormData The form data to validate
     * @return boolean|array
     */
    function adminValidateFormData($aFormData)
    {
        $aNormalized = adminNormalizeFormData(null, $aFormData);
        $aErrors     = array();

        try {

            //  @todo
            return true;

        } catch (ValidationException $e) {

            return $aErrors;
        }
    }
}

if (!function_exists('adminLoadFormBuilderAssets')) {

    /**
     * Loads up all the assets required for the form builder
     * @param  string $sSelector The selector for the element(s) to which the JS should bind
     * @return array
     */
    function adminLoadFormBuilderAssets($sSelector)
    {
        $oFieldTypeModel = Factory::model('FieldType', 'nailsapp/module-form-builder');
        $oAsset          = Factory::service('Asset');

        $oAsset->load('admin.css', 'nailsapp/module-form-builder');
        $oAsset->load('admin.form.edit.min.js', 'nailsapp/module-form-builder');
        $oAsset->inline(
            '
                window.NAILS.FORMBUILDER = [];
                $("' . $sSelector . '").each(function() {
                    window.NAILS.FORMBUILDER.push(
                        new _ADMIN_FORM_EDIT(
                            this,
                            ' . json_encode($oFieldTypeModel->getAllWithOptions(true)) . ',
                            ' . json_encode($oFieldTypeModel->getAllWithDefaultValue(true)) . '
                        )
                    );
                });
            ',
            'JS'
        );
    }
}

if (!function_exists('adminLoadFormBuilderView')) {

    /**
     * Loads the markup for the form builder
     * @param  string $sId     The ID to give the form
     * @param  array  $aFields Any existing fields to pre-render
     * @return string
     */
    function adminLoadFormBuilderView($sId, $sFieldName = 'fields', $aFields = array())
    {
        $oFieldTypeModel    = Factory::model('FieldType', 'nailsapp/module-form-builder');
        $oDefaultValueModel = Factory::model('DefaultValue', 'nailsapp/module-form-builder');

        return get_instance()->load->view(
            'formbuilder/admin/fields',
            array(
                'sId'            => $sId,
                'sFieldName'     => $sFieldName,
                'aFields'        => $aFields,
                'aFieldTypes'    => array('Select...') + $oFieldTypeModel->getAllFlat(true),
                'aDefaultValues' => array('No Default Value') + $oDefaultValueModel->getAllFlat(true),
            )
        );
    }
}

if (!function_exists('formBuilderRender')) {

    /**
     * Renders the markup for a form
     * @param  array $aFormData The data to build the form with
     * @return string
     */
    function formBuilderRender($aFormData)
    {
        $sUuid       = !empty($aFormData['form_uuid']) ? $aFormData['form_uuid'] : md5(microtime(true));
        $sFormAction = !empty($aFormData['form_action']) ? $aFormData['form_action'] : null;
        $sFormMethod = !empty($aFormData['form_method']) ? strtoupper($aFormData['form_method']) : 'POST';
        $sFormAttr   = !empty($aFormData['form_attr']) ? strtoupper($aFormData['form_attr']) : '';
        $sFieldKey   = !empty($aFormData['field_key']) ? strtoupper($aFormData['field_key']) : '';
        $aFields     = !empty($aFormData['fields']) ? $aFormData['fields'] : array();

        if (!empty($aFormData['buttons'])) {

            $aButtons = $aFormData['buttons'];

        } else {

            $aButtons = array(
                (object) array(
                    'type'  => 'submit',
                    'class' => 'btn btn-primary',
                    'label' => 'Submit',
                    'attr'  => ''
                )
            );
        }

        //  Start building the form
        $sOut = form_open_multipart($sFormAction, 'method="' . $sFormMethod . '" ' . $sFormAttr);

        //  Render the form fields
        $oFieldTypeModel    = Factory::model('FieldType', 'nailsapp/module-form-builder');
        $oDefaultValueModel = Factory::model('DefaultValue', 'nailsapp/module-form-builder');
        $iCounter           = 0;

        foreach ($aFields as $oField) {

            $oFieldType = $oFieldTypeModel->getBySlug($oField->type);

            $sId   = 'form-' . $sUuid . '-' . $iCounter;
            $aAttr = array(
                $sId ? 'id="' . $sId . '"' : '',
                $oField->placeholder ? 'placeholder="' . $oField->placeholder . '"' : '',
                $oField->is_required ? 'required="required"' : '',
                $oField->custom_attributes
            );

            if (!empty($oFieldType)) {

                $oDefaultValue = $oDefaultValueModel->getBySlug($oField->default_value);
                if (!empty($oDefaultValue)) {

                    $sDefaultValue = $oDefaultValue->defaultValue();

                } else {

                    $sDefaultValue = null;
                }

                $sOut .= $oFieldType->render(
                    array(
                        'id'          => $sId,
                        'key'         => 'field[' . $oField->id . ']',
                        'label'       => $oField->label,
                        'sub_label'   => $oField->sub_label,
                        'default'     => $sDefaultValue,
                        'value'       => isset($_POST['field'][$oField->id]) ? $_POST['field'][$oField->id] : $sDefaultValue,
                        'required'    => $oField->is_required,
                        'class'       => 'form-control',
                        'attributes'  => implode(' ', $aAttr),
                        'options'     => $oField->options->data,
                        'error'       => !empty($oField->error) ? $oField->error : null
                    )
                );
            }

            $iCounter++;
        }

        //  Render any buttons
        if (!empty($aButtons)) {

            $sOut .= '<p class="text-center">';
            foreach ($aButtons as $oButton) {

                $sType  = !empty($oButton['type']) ? $oButton['type'] : 'submit';
                $sClass = !empty($oButton['class']) ? $oButton['class'] : 'btn btn-primary';
                $sLabel = !empty($oButton['label']) ? $oButton['label'] : 'Submit';
                $sAttr  = !empty($oButton['attr']) ? $oButton['attr'] : '';

                $sOut .= '<button type="' . $sType . '" class="' . $sClass . '" ' . $sAttr . '>';
                $sOut .= $sLabel;
                $sOut .= '</button>';
            }
            $sOut .= '</p>';
        }

        $sOut .= form_close();

        return $sOut;
    }
}