<?php
/**
 * The template for the movie post type selected (admin side)
 *
 * @link       https://e-leven.net/
 * @since      1.0.0
 *
 * @package    My_movie_database
 * @subpackage My_movie_database/mmdb_templates/admin/movie
 */
?>

<!-- the post type template wrapper -->
<div class="selection-wrapper">

    <?php echo esc_html_e( "You have selected : ", 'my-movie-db') . '<br />';?>

    <div id="selected" style="text-align: center;">

        <div id="<?php echo esc_attr($mmdb->getID()) ?>" class="movie-container" style="margin-bottom:40px">
            <img src=<?php echo esc_url($this->public_files->mmdbGetPoster($mmdb, $tmdb->getSecureImageURL('w185'))); ?> />
            <div class="info">
                <h2><?php echo esc_html($mmdb->getTitle()); ?> </h2>
                <p><strong><?php echo esc_html($mmdb->getRelDate("Y")); ?></strong>
                    <?php echo '(' . esc_html($mmdb->getVoteAverage()); ?>/10) </p>
            </div>
            <div class="description">
                <?php echo esc_textarea($mmdb->getOverview()) ?></div>
        </div>

    </div>
</div>
