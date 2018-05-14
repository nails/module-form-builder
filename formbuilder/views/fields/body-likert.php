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

            $aOptions = [];
            foreach ($options as $oOption) {

                if (!$oOption->is_disabled) {

                    ?>
                    <tr>
                        <td class="likert-scale__label">
                            <?=$oOption->label?>
                        </td>
                        <td class="likert-scale__option text-center">
                            <label>
                                <?php

                                if (!empty($value)) {

                                    $bSelected = array_key_exists($oOption->id, $value) && $value[$oOption->id] == 0;

                                } else {

                                    $bSelected = false;
                                }

                                echo form_radio($key . '[' . $oOption->id . ']', 0, $bSelected);

                                ?>
                            </label>
                        </td>
                        <td class="likert-scale__option text-center">
                            <label>
                                <?php

                                if (!empty($value)) {

                                    $bSelected = array_key_exists($oOption->id, $value) && $value[$oOption->id] == 1;

                                } else {

                                    $bSelected = false;
                                }

                                echo form_radio($key . '[' . $oOption->id . ']', 1, $bSelected);

                                ?>
                            </label>
                        </td>
                        <td class="likert-scale__option text-center">
                            <label>
                                <?php

                                if (!empty($value)) {

                                    $bSelected = array_key_exists($oOption->id, $value) && $value[$oOption->id] == 2;

                                } else {

                                    $bSelected = false;
                                }

                                echo form_radio($key . '[' . $oOption->id . ']', 2, $bSelected);

                                ?>
                            </label>
                        </td>
                        <td class="likert-scale__option text-center">
                            <label>
                                <?php

                                if (!empty($value)) {

                                    $bSelected = array_key_exists($oOption->id, $value) && $value[$oOption->id] == 3;

                                } else {

                                    $bSelected = false;
                                }

                                echo form_radio($key . '[' . $oOption->id . ']', 3, $bSelected);

                                ?>
                            </label>
                        </td>
                        <td class="likert-scale__option text-center">
                            <label>
                                <?php

                                if (!empty($value)) {

                                    $bSelected = array_key_exists($oOption->id, $value) && $value[$oOption->id] == 4;

                                } else {

                                    $bSelected = false;
                                }

                                echo form_radio($key . '[' . $oOption->id . ']', 4, $bSelected);

                                ?>
                            </label>
                        </td>
                    </tr>
                    <?php
                }
            }

            ?>
        </tbody>
    </table>
</div>
