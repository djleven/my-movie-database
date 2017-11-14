<?php

/**
 * The template when nothing has been selected (admin side)
 *
 * @link       https://e-leven.net/
 * @since      1.0.0
 *
 * @package    My_movie_database
 * @subpackage My_movie_database/admin/partials
 */
?>

<!-- the post type template wrapper -->
<div class="selection-wrapper">
    <div id="selected-status">
	<?php esc_html_e("Nothing has been selected.", 'my-movie-db') ;?>
    </div>
    <div id="selected" style="text-align: center;">
    </div>
</div>

