<?php

$sRequired = !empty($required) ? '*' : '';

?>
<div class="form-group <?=!empty($error) ? 'has-error' : ''?>">
    <label for="<?=$id?>" class="form-group__label">
        <?=$label . $sRequired?>
    </label>
    <?=$sub_label ? '<p class="form-group__sub-label">' . $sub_label . '</p>' : ''?>