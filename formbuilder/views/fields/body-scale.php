<div class="scale">
    <ul>
        <?php

        for ($i = 1; $i <= $num_options; $i++) {

            $sId = $id . '-' . $i;
            echo '<li>';
            echo form_radio($key, $i, set_radio($key, $i), 'id="' . $sId . '"');
            echo '<label for="' . $sId . '">' . $i . '</label>';
            echo '</li>';
        }

        ?>
    </ul>
</div>
