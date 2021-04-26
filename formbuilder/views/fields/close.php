<?php

if (!empty($error)) {
    echo sprintf(
        '<p class="help-block error-message">%s</p>',
        $error
    );
}

echo '</div>';
