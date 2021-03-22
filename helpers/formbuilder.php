<?php

use \Nails\FormBuilder\Helper\FormBuilder;

if (!function_exists('adminNormalizeFormData')) {
    function adminNormalizeFormData($iFormId = null, $bHasCaptcha = false, $aFields = [])
    {
        return FormBuilder::adminNormalizeFormData($iFormId, $bHasCaptcha, $aFields);
    }
}

if (!function_exists('adminValidateFormData')) {
    function adminValidateFormData(array $aFormData)
    {
        FormBuilder::adminValidateFormData($aFormData);
    }
}

if (!function_exists('formBuilderRender')) {
    function formBuilderRender($aFormData)
    {
        return FormBuilder::render($aFormData);
    }
}

if (!function_exists('formBuilderValidate')) {
    function formBuilderValidate($aFormFields, $aUserData)
    {
        return FormBuilder::validate($aFormFields, $aUserData);
    }
}

if (!function_exists('formBuilderParseResponse')) {
    function formBuilderParseResponse($aFormFields, $aUserData)
    {
        return FormBuilder::parseResponse($aFormFields, $aUserData);
    }
}
