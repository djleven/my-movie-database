<!-- don't change these unless you know exactly what you're doing!! -->
<div class="choice-buttons">
    <input type="hidden" name="id_mmdb" id="id_mmdb" value="<?php echo esc_attr($mmdb_result->getID()) ?>" />
    <button class="button-primary" id="mmdb_id_add"><?php esc_html_e("Yes, this what I was looking for!", 'my-movie-db');?></button>
    <button class="button-secondary" id="tb_remove"><?php esc_html_e("No, I want to keep on looking!", 'my-movie-db' );?></button>
</div>
<!-- oof!! -->