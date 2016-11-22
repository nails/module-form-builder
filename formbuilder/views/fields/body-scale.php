<div class="scale">
    <ul>
        <?php

        for ($i = 1; $i <= $num_options; $i++) {
            echo '<label>';
            echo form_radio($key, $i, set_radio($key, $i)) . $i;
            echo '</label>';
        }

        ?>
    </ul>
</div>
