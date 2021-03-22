<?php

$sId             = !empty($sId) ? 'id="' . $sId . '"' : null;
$sFieldName      = !empty($sFieldName) ? $sFieldName : 'fields';
$aFieldTypeNames = array_combine(
    [''] + arrayExtractProperty($aFieldTypes, 'slug'),
    ['Please select...'] + arrayExtractProperty($aFieldTypes, 'label'),
);

if (!empty($_POST[$sFieldName])) {

    $aFields = $_POST[$sFieldName];

    //  Cast as objects to match database output
    foreach ($aFields as &$aField) {

        if (!empty($aField['options'])) {

            $aField['options'] = (object) [
                'count' => count($aField['options']),
                'data'  => $aField['options'],
            ];

        } else {

            $aField['options'] = (object) [
                'count' => 0,
                'data'  => [],
            ];
        }

        foreach ($aField['options']->data as &$aOption) {
            $aOption = (object) $aOption;
        }
        unset($aOption);

        $aField = (object) $aField;
    }
    unset($aField);
}

?>
<div class="form-builder" <?=$sId?> data-field-types="<?=htmlspecialchars(json_encode($aFieldTypes))?>">
    <div class="table-responsive">
        <table class="form-builder__header">
            <thead>
                <tr>
                    <th class="order">
                    </th>
                    <th class="type">
                        Type
                    </th>
                    <th class="field-label">
                        Label &amp; Sub-label
                    </th>
                    <th class="placeholder">
                        Placeholder
                    </th>
                    <th class="required">
                        Required
                    </th>
                    <th class="default">
                        Default Value
                    </th>
                    <th class="attributes">
                        Custom Attributes
                    </th>
                    <th class="remove">
                        &nbsp;
                    </th>
                </tr>
            </thead>
        </table>
        <table class="form-builder__fields">
            <?php

            $i = 0;

            foreach ($aFields as $oField) {

                ?>
                <tbody class="form-builder__field">
                    <tr>
                        <td class="order handle" rowspan="2">
                            <b class="fa fa-bars"></b>
                            <input
                                type="hidden"
                                name="<?=$sFieldName . '[' . $i . '][id]'?>"
                                value="<?=!empty($oField->id) ? $oField->id : ''?>"
                                class="form-builder__field__id"
                            >
                            <input
                                type="hidden"
                                name="<?=$sFieldName . '[' . $i . '][fieldNumber]'?>"
                                value="<?=$oField->fieldNumber ?? $i?>"
                                class="form-builder__field__field-number"
                            >
                        </td>
                        <td class="type">
                            <?php

                            echo form_dropdown(
                                $sFieldName . '[' . $i . '][type]',
                                $aFieldTypeNames,
                                $oField->type,
                                'class="select2 field-type form-builder__field__type"'
                            );

                            ?>
                            <a href="#" class="js-manage-option btn btn-xs btn-warning" data-field-number="<?=$i?>">
                                Toggle Options
                            </a>
                        </td>
                        <td class="field-label">
                            <?php

                            echo form_input(
                                $sFieldName . '[' . $i . '][label]',
                                $oField->label,
                                'placeholder="The field\'s label" class="form-builder__field__label"'
                            );

                            echo form_input(
                                $sFieldName . '[' . $i . '][sub_label]',
                                $oField->sub_label,
                                'placeholder="The field\'s sub-label" class="form-builder__field__sublabel"'
                            );

                            ?>
                        </td>
                        <td class="placeholder">
                            <div class="supports-placeholder js-supports-placeholder">
                                <?php

                                echo form_input(
                                    $sFieldName . '[' . $i . '][placeholder]',
                                    $oField->placeholder,
                                    'placeholder="The field\'s placeholder" class="form-builder__field__placeholder"'
                                );

                                ?>
                            </div>
                            <div class="no-placeholder js-no-placeholder text-muted">
                                &mdash;
                            </div>
                        </td>
                        <td class="required">
                            <div class="supports-required js-supports-required">
                                <?php

                                echo form_checkbox(
                                    $sFieldName . '[' . $i . '][is_required]',
                                    true,
                                    !empty($oField->is_required),
                                    'class="form-builder__field__required"'
                                );

                                ?>
                            </div>
                            <div class="no-required js-no-required text-muted">
                                &mdash;
                            </div>
                        </td>
                        <td class="default">
                            <div class="supports-default-value js-supports-default-value">
                                <?php

                                echo form_dropdown(
                                    $sFieldName . '[' . $i . '][default_value]',
                                    $aDefaultValues,
                                    $oField->default_value,
                                    'class="select2 field-default form-builder__field__default"'
                                );
                                ?>
                            </div>
                            <div class="no-default-value js-no-default-value text-muted">
                                &mdash;
                            </div>
                        </td>
                        <td class="attributes">
                            <div class="supports-attributes js-supports-attributes">
                                <?php

                                echo form_input(
                                    $sFieldName . '[' . $i . '][custom_attributes]',
                                    $oField->custom_attributes,
                                    'placeholder="Any custom attributes" class="form-builder__field__attributes"'
                                );

                                ?>
                            </div>
                            <div class="no-attributes js-no-attributes text-muted">
                                &mdash;
                            </div>
                        </td>
                        <td class="remove" rowspan="2">
                            <a href="#" class="js-remove-field" data-field-number="<?=$i?>">
                                <b class="fa fa-times-circle fa-lg"></b>
                            </a>
                        </td>
                    </tr>
                    <tr class="options">
                        <td colspan="6">
                            <?php

                            $iOptionCount = !empty($oField->options) ? $oField->options->count : 0;

                            ?>
                            <div class="form-field-options">
                                <div class="form-field-options-padder">
                                    <table data-option-count="<?=$iOptionCount?>">
                                        <thead>
                                            <tr>
                                                <th class="option-label">
                                                    Label
                                                </th>
                                                <th class="option-selected">
                                                    Selected
                                                </th>
                                                <th class="option-disabled">
                                                    Disabled
                                                </th>
                                                <th class="option-remove">
                                                    &nbsp;
                                                </th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php

                                            if (!empty($oField->options)) {

                                                $x = 0;

                                                foreach ($oField->options->data as $oOption) {

                                                    ?>
                                                    <tr>
                                                        <td class="option-label">
                                                            <?php

                                                            echo form_input(
                                                                $sFieldName . '[' . $i . '][options][' . $x . '][label]',
                                                                $oOption->label
                                                            );

                                                            echo form_hidden(
                                                                $sFieldName . '[' . $i . '][options][' . $x . '][id]',
                                                                !empty($oOption->id) ? $oOption->id : ''
                                                            );

                                                            ?>
                                                        </td>
                                                        <td class="option-selected">
                                                            <?php

                                                            echo form_checkbox(
                                                                $sFieldName . '[' . $i . '][options][' . $x . '][is_selected]',
                                                                true,
                                                                !empty($oOption->is_selected)
                                                            );

                                                            ?>
                                                        </td>
                                                        <td class="option-disabled">
                                                            <?php

                                                            echo form_checkbox(
                                                                $sFieldName . '[' . $i . '][options][' . $x . '][is_disabled]',
                                                                true,
                                                                !empty($oOption->is_disabled)
                                                            );

                                                            ?>
                                                        </td>
                                                        <td class="option-remove">
                                                            <a href="#" class="js-remove-option" data-field-number="<?=$i?>">
                                                                <b class="fa fa-times-circle fa-lg"></b>
                                                            </a>
                                                        </td>
                                                    </tr>
                                                    <?php

                                                    $x++;
                                                }
                                            }

                                            ?>
                                        </tbody>
                                        <tfoot>
                                            <tr>
                                                <td colspan="4">
                                                    <button type="button" class="btn btn-xs btn-success js-add-option" data-field-number="<?=$i?>">
                                                        Add Option
                                                    </button>
                                                </td>
                                            </tr>
                                        </tfoot>
                                    </table>
                                </div>
                            </div>
                            <?php

                            ?>
                        </td>
                    </tr>
                </tbody>
                <?php

                $i++;
            }

            ?>
            <tfoot>
                <tr>
                    <td colspan="8">
                        <a href="#" class="js-add-field btn btn-xs btn-success">
                            Add Field
                        </a>
                    </td>
                </tr>
            </tfoot>
        </table>
    </div>
    <script type="template/mustache" class="js-template-field">
    <tbody class="form-builder__field">
        <tr>
            <td class="order handle" rowspan="2">
                <b class="fa fa-bars"></b>
                <input
                    type="hidden"
                    name="<?=$sFieldName . '[{{fieldNumber}}][fieldNumber]'?>"
                    value="{{fieldNumber}}"
                    class="form-builder__field__field-number"
                >
            </td>
            <td class="type">
                <?=form_dropdown($sFieldName . '[{{fieldNumber}}][type]', $aFieldTypeNames, null, 'class="select2 field-type"')?>
                <a href="#" class="js-manage-option btn btn-xs btn-warning" data-field-number="{{fieldNumber}}">
                    Toggle Options
                </a>
            </td>
            <td class="field-label">
                <?php

                echo form_input(
                    $sFieldName . '[{{fieldNumber}}][label]',
                    null,
                    'placeholder="The field\'s label" class="form-builder__field__label"'
                );

                echo form_input(
                    $sFieldName . '[{{fieldNumber}}][sub_label]',
                    null,
                    'placeholder="The field\'s sub-label" class="form-builder__field__sublabel"'
                );

                ?>
            </td>
            <td class="placeholder">
                <div class="supports-placeholder js-supports-placeholder">
                    <?=form_input(
                        $sFieldName . '[{{fieldNumber}}][placeholder]',
                        null,
                        'placeholder="The field\'s placeholder" class="form-builder__field__placeholder"'
                    )?>
                </div>
                <div class="no-placeholder js-no-placeholder text-muted">
                    &mdash;
                </div>
            </td>
            <td class="required">
                <div class="supports-required js-supports-required">
                    <?=form_checkbox(
                        $sFieldName . '[{{fieldNumber}}][is_required]',
                        true,
                        false,
                        'class="form-builder__field__required"'
                    )?>
                </div>
                <div class="no-required js-no-required text-muted">
                    &mdash;
                </div>
            </td>
            <td class="default">
                <div class="supports-default-value js-supports-default-value">
                    <?=form_dropdown(
                        $sFieldName . '[{{fieldNumber}}][default_value]',
                        $aDefaultValues,
                        null,
                        'class="select2 field-default form-builder__field__default"'
                    )?>
                </div>
                <div class="no-default-value js-no-default-value text-muted">
                    &mdash;
                </div>
            </td>
            <td class="attributes">
                <div class="supports-attributes js-supports-attributes">
                    <?=form_input(
                        $sFieldName . '[{{fieldNumber}}][custom_attributes]',
                        null,
                        'placeholder="Any custom attributes" class="form-builder__field__attributes"'
                    )?>
                </div>
                <div class="no-attributes js-no-attributes text-muted">
                    &mdash;
                </div>
            </td>
            <td class="remove" rowspan="2">
                <a href="#" class="js-remove-field" data-field-number="{{fieldNumber}}">
                    <b class="fa fa-times-circle fa-lg"></b>
                </a>
            </td>
        </tr>
        <tr class="options">
            <td colspan="6">
                <div class="form-field-options">
                    <div class="form-field-options-padder">
                        <table data-option-count="0">
                            <thead>
                                <tr>
                                    <th class="option-label">
                                        Label
                                    </th>
                                    <th class="option-selected">
                                        Selected
                                    </th>
                                    <th class="option-disabled">
                                        Disabled
                                    </th>
                                    <th class="option-remove">
                                        &nbsp;
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                            </tbody>
                            <tfoot>
                                <tr>
                                    <td colspan="4">
                                        <button type="button" class="btn btn-xs btn-success js-add-option" data-field-number="{{fieldNumber}}">
                                            Add Option
                                        </button>
                                    </td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </td>
        </tr>
    </tbody>
    </script>
    <script type="template/mustache" class="js-template-field-option">
    <tr>
        <td class="option-label">
            <?=form_input(
                $sFieldName . '[{{fieldNumber}}][options][{{optionNumber}}][label]',
                null,
                'placeholder="Option Label"'
            )?>
        </td>
        <td class="option-selected">
            <?=form_checkbox(
                $sFieldName . '[{{fieldNumber}}][options][{{optionNumber}}][is_selected]',
                true
            )?>
        </td>
        <td class="option-disabled">
            <?=form_checkbox(
                $sFieldName . '[{{fieldNumber}}][options][{{optionNumber}}][is_disabled]',
                true
            )?>
        </td>
        <td class="option-remove">
            <a href="#" class="js-remove-option" data-field-number="{{fieldNumber}}">
                <b class="fa fa-times-circle fa-lg"></b>
            </a>
        </td>
    </tr>
    </script>
</div>
