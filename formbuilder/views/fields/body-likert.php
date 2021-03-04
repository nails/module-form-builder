<?php
/**
 * @var string[] $aLikertTerms
 */

if (!$_POST && !empty($value)) {
    $value = array_combine($value, $data);
}

?>
<div class="likert-scale">
    <table>
        <thead>
            <tr>
                <th>&nbsp;</th>
                <?php
                for ($i = 0; $i < count($aLikertTerms); $i++) {
                    ?>
                    <th><?=$aLikertTerms[$i]?></th>
                    <?php
                }
                ?>
            </tr>
        </thead>
        <tbody>
            <?php

            foreach ($options as $oOption) {

                if (!$oOption->is_disabled) {

                    ?>
                    <tr>
                        <td class="likert-scale__label">
                            <?=$oOption->label?>
                        </td>
                        <?php

                        for ($i = 0; $i < count($aLikertTerms); $i++) {
                            ?>
                            <td class="likert-scale__option text-center">
                                <label>
                                    <?php

                                    $bSelected = !empty($value) && array_key_exists($oOption->id, $value)
                                        ? $value[$oOption->id] == $i
                                        : null;

                                    echo form_radio($key . '[' . $oOption->id . ']', $i, $bSelected);

                                    ?>
                                </label>
                            </td>
                            <?php
                        }

                        ?>
                    </tr>
                    <?php
                }
            }

            ?>
        </tbody>
    </table>
</div>
