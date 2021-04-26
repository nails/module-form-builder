<?php

$sRequired = !empty($label) && !empty($required) ? '*' : '';

echo sprintf(
    '<div class="form-group%s">',
    !empty($error) ? ' has-error' : ''
);

if ($label) {
    echo sprintf(
        '<label for="%s" class="label">%s</label>',
        $id,
        $label . $sRequired
    );
}

if ($sub_label) {
    echo sprintf(
        '<p class="sub-label">%s</p>',
        $sub_label
    );
}
