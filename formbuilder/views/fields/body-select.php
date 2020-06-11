<select name="<?=$key?>" class="<?=$class?>" <?=$attributes?>>
    <?php

    if ($placeholder) {
        ?>
        <option value="">
            <?=$placeholder?>
        </option>
        <?php
    }

    foreach ($options as $oOption) {

        $sDisabled = $oOption->is_disabled ? 'disabled="disabled"' : '';

        if (!empty($value)) {

            $sSelected = $value == $oOption->id ? 'selected="selected"' : '';

        } else {

            $sSelected = $oOption->is_selected ? 'selected="selected"' : '';
        }

        ?>
        <option value="<?=$oOption->id?>" <?=$sSelected?> <?=$sDisabled?>>
            <?=$oOption->label?>
        </option>
        <?php
    }

    ?>
</select>
