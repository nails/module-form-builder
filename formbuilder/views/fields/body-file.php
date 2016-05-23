<?php

/**
 * A hidden field is required so that there is a $_POST item, the driver will verify the upload exists
 * in the $_FILES array.
 */
echo form_hidden($key, true);
echo form_upload($key, $value, 'class="' . $class . '" ' . $attributes);