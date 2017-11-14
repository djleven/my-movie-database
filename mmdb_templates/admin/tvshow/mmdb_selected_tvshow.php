<?php
/**
 * The template for the tvshow post type selected (admin side)
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

    <?php echo esc_html_e( "You have selected : ", 'my-movie-db') . '<br />';?>

    <div id="selected" style="text-align: center;">

        <div id="<?php echo esc_attr($mmdb->getID()) ?>" class="movie-container" style="margin-bottom:40px">
            <img src=<?php echo esc_url($this->public_files->mmdb_get_poster($mmdb)); ?> />
            <div class="info">
                <h2><?php esc_html($mmdb->getName()) ?> </h2>
                <p><strong><?php esc_html_e("First Aired: ", 'my-movie-db');  echo esc_html($mmdb->getFirstAirDate("Y")) ?></strong>
                    <?php echo '(' . esc_html($mmdb->getVoteAverage()) ?>/10) </p>
            </div>
            <div class="description">
                <?php echo esc_textarea($mmdb->getOverview()) ?>
            </div>
        </div>
    </div>
