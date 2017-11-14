<?php

/**
 * Template for the admin search form and post meta save input
 *
 * This file is used to markup the admin-facing aspects of the plugin.
 *
 * @link       https://e-leven.net/
 * @since      1.0.0
 *
 * @package    My_movie_database
 * @subpackage My_movie_database/admin/partials
 */
?>
<div class="clearfix"></div>
<div class="panel panel-default">
    <div class="panel-body" style="text-align: center;">
        <input type="hidden" name="MovieDatabaseID" id="MovieDatabaseID" value="<?php
		echo esc_html($mmdb_existing_id); ?>"/>
        <br />
        <p>
            <div class="col-lg-6 col-lg-offset-3">
                <input type="text" name="key_mmdb" id="key_mmdb" value="<?php echo esc_html(get_the_title()) ?>" style="width:100%; margin-bottom:15px;"/>
            </div>
            <div class="col-lg-6 col-lg-offset-3" style="margin-bottom:15px;">
                <div id="search_mmdb" class="button-primary" name="search_mmdb"> <?php esc_html_e('Search Database', 'my-movie-db'); ?></div>
                <?php if($mmdb_existing_id) { ?>
                <div id="remove_mmdb" class="button-secondary" name="remove_mmdb"> <?php esc_html_e('Remove', 'my-movie-db'); ?></div>
                <?php } ;?>
                <div id="loader"><div id="loaderInner" style="background: transparent url(<?php echo plugin_dir_url( dirname(__FILE__)) . 'img/ajax-loader.gif';?>) center center no-repeat;"></div></div>
            </div>
            <div class="clearfix"></div>
            <div id="resultHtml"></div>
        </p>
	</div>
</div>
