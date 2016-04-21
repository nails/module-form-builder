<div class="likert-scale">
    <table>
        <thead>
            <tr>
                <th>&nbsp;</th>
                <th><?=$likertTerms[0]?></th>
                <th><?=$likertTerms[1]?></th>
                <th><?=$likertTerms[2]?></th>
                <th><?=$likertTerms[3]?></th>
                <th><?=$likertTerms[4]?></th>
            </tr>
        </thead>
        <tbody>
            <?php

            $aOptions = array();
            foreach ($options as $oOption) {

                $sDisabled = $oOption->is_disabled ? 'disabled="disabled"' : '';

                if (!empty($value)) {

                    $bSelected = $value == $oOption->id;

                } else {

                    $bSelected = $oOption->is_selected;
                }

                ?>
                <tr>
                    <td class="likert-scale__label">
                        <?=$oOption->label?>
                    </td>
                    <td class="likert-scale__option text-center">
                        <label>
                            <?=form_radio($key . '[' . $oOption->id . ']', 0, $bSelected, $sDisabled)?>
                        </label>
                    </td>
                    <td class="likert-scale__option text-center">
                        <label>
                            <?=form_radio($key . '[' . $oOption->id . ']', 1, $bSelected, $sDisabled)?>
                        </label>
                    </td>
                    <td class="likert-scale__option text-center">
                        <label>
                            <?=form_radio($key . '[' . $oOption->id . ']', 2, $bSelected, $sDisabled)?>
                        </label>
                    </td>
                    <td class="likert-scale__option text-center">
                        <label>
                            <?=form_radio($key . '[' . $oOption->id . ']', 3, $bSelected, $sDisabled)?>
                        </label>
                    </td>
                    <td class="likert-scale__option text-center">
                        <label>
                            <?=form_radio($key . '[' . $oOption->id . ']', 4, $bSelected, $sDisabled)?>
                        </label>
                    </td>
                </tr>
                <?php
            }

            ?>
        </tbody>
    </table>
</div>