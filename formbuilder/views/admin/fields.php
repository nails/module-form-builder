<?php

$sId        = !empty($sId) ? 'id="' . $sId . '"' : null;
$sFieldName = !empty($sFieldName) ? $sFieldName : 'fields';

if (!empty($_POST[$sFieldName])) {

    $aFields = $_POST[$sFieldName];

    //  Cast as objects to match database output
    foreach ($aFields as &$aField) {

        if (empty($aField['options'])) {
            $aField['options'] = array();
        }

        foreach ($aField['options'] as &$aOption) {
            $aOption = (object) $aOption;
        }

        $aField = (object) $aField;
    }

}

?>
<div class="form-builder" <?=$sId?>>
    <div class="table-responsive">
        <table class="form-builder__fields">
            <thead>
                <tr>
                    <th class="order">
                        Order
                    </th>
                    <th class="type">
                        Type
                    </th>
                    <th class="field-label">
                        Label
                    </th>
                    <th class="field-sub-label">
                        Sub Label
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
                        Custom Field Attributes
                    </th>
                    <th class="remove">
                        &nbsp;
                    </th>
                </tr>
            </thead>
            <?php

            $i = 0;

            foreach ($aFields as $oField) {

                ?>
                <tbody>
                    <tr>
                        <td class="order" rowspan="2">
                            <b class="fa fa-bars handle"></b>
                            <?php

                            echo form_hidden(
                                $sFieldName . '[' . $i . '][id]',
                                !empty($oField->id) ? $oField->id : ''
                            );

                            ?>
                        </td>
                        <td class="type">
                            <?php

                            echo form_dropdown(
                                $sFieldName . '[' . $i . '][type]',
                                $aFieldTypes,
                                set_value($sFieldName . '[' . $i . '][type]', $oField->type),
                                'class="select2 field-type"'
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
                                set_value($sFieldName . '[' . $i . '][label]', $oField->label),
                                'placeholder="The field\'s label"'
                            );

                            ?>
                        </td>
                        <td class="field-sub-label">
                            <?php

                            echo form_input(
                                $sFieldName . '[' . $i . '][sub_label]',
                                set_value($sFieldName . '[' . $i . '][sub_label]', $oField->sub_label),
                                'placeholder="The field\'s sub-label"'
                            );

                            ?>
                        </td>
                        <td class="placeholder">
                            <?php

                            echo form_input(
                                $sFieldName . '[' . $i . '][placeholder]',
                                set_value($sFieldName . '[' . $i . '][placeholder]', $oField->placeholder),
                                'placeholder="The field\'s placeholder"'
                            );

                            ?>
                        </td>
                        <td class="required">
                            <?php

                            echo form_checkbox(
                                $sFieldName . '[' . $i . '][is_required]',
                                true,
                                !empty($oField->is_required)
                            );

                            ?>
                        </td>
                        <td class="default">
                            <div class="supports-default-value js-supports-default-value">
                                <?php

                                echo form_dropdown(
                                    $sFieldName . '[' . $i . '][default_value]',
                                    $aDefaultValues,
                                    set_value($sFieldName . '[' . $i . '][default_value]', $oField->default_value),
                                    'class="select2 field-default"'
                                );

                                echo form_input(
                                    $sFieldName . '[' . $i . '][default_value_custom]',
                                    set_value(
                                        $sFieldName . '[' . $i . '][default_value_custom]',
                                        $oField->default_value_custom
                                    ),
                                    'placeholder="The default value"'
                                );
                            ?>
                            </div>
                            <div class="no-default-value js-no-default-value text-muted">
                                Field type does not support default values
                            </div>
                        </td>
                        <td class="attributes">
                            <?php

                            echo form_input(
                                $sFieldName . '[' . $i . '][custom_attributes]',
                                set_value(
                                    $sFieldName . '[' . $i . '][custom_attributes]',
                                    $oField->custom_attributes
                                ),
                                'placeholder="Any custom attributes"'
                            );

                            ?>
                        </td>
                        <td class="remove" rowspan="2">
                            <a href="#" class="js-remove-field" data-field-number="<?=$i?>">
                                <b class="fa fa-times-circle fa-lg"></b>
                            </a>
                        </td>
                    </tr>
                    <tr class="options">
                        <td colspan="7">
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
                                                                $sFieldName . $sFieldName . '[' . $i . '][options][' . $x . '][is_disabled]',
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
                    <td colspan="9">
                        <a href="#" class="js-add-field btn btn-xs btn-success">
                            Add Field
                        </a>
                    </td>
                </tr>
            </tfoot>
        </table>
    </div>
    <script type="template/mustache" class="js-template-field">
        <tbody>
            <tr>
                <td class="order" rowspan="2">
                    <b class="fa fa-bars handle"></b>
                </td>
                <td class="type">
                    <?=form_dropdown($sFieldName . '[{{fieldNumber}}][type]', $aFieldTypes, null, 'class="select2 field-type"')?>
                    <a href="#" class="js-manage-option btn btn-xs btn-warning" data-field-number="{{fieldNumber}}">
                        Toggle Options
                    </a>
                </td>
                <td class="field-label">
                    <?=form_input(
                        $sFieldName . '[{{fieldNumber}}][label]',
                        null,
                        'placeholder="The field\'s label"'
                    )?>
                </td>
                <td class="field-sub-label">
                    <?=form_input(
                        $sFieldName . '[{{fieldNumber}}][sub_label]',
                        null,
                        'placeholder="The field\'s sub-label"'
                    )?>
                </td>
                <td class="placeholder">
                    <?=form_input(
                        $sFieldName . '[{{fieldNumber}}][placeholder]',
                        null,
                        'placeholder="The field\'s placeholder"'
                    )?>
                </td>
                <td class="required">
                    <?=form_checkbox(
                        $sFieldName . '[{{fieldNumber}}][is_required]',
                        true
                    )?>
                </td>
                <td class="default">
                    <div class="supports-defualt-value js-supports-default-value">
                        <?=form_dropdown(
                            $sFieldName . '[{{fieldNumber}}][default_value]',
                            $aDefaultValues,
                            null,
                            'class="select2 field-default"'
                        )?>
                        <?=form_input(
                            $sFieldName . '[{{fieldNumber}}][default_value_custom]',
                            null,
                            'placeholder="The default value"'
                        )?>
                    </div>
                    <div class="no-default-value js-no-default-value text-muted">
                        Field type does not support default values
                    </div>
                </td>
                <td class="attributes">
                    <?=form_input(
                        $sFieldName . '[{{fieldNumber}}][custom_attributes]',
                        null,
                        'placeholder="Any custom attributes"'
                    )?>
                </td>
                <td class="remove" rowspan="2">
                    <a href="#" class="js-remove-field" data-field-number="{{fieldNumber}}">
                        <b class="fa fa-times-circle fa-lg"></b>
                    </a>
                </td>
            </tr>
            <tr class="options">
                <td colspan="7">
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