<?php

/**
 * The template for the person post type selected (admin side)
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
            <img src=<?php echo esc_url($this->public_files->mmdbGetProfile($mmdb, $tmdb->getSecureImageURL('w185'))); ?> />
            <div class="info">
                <h2><?php echo esc_html($mmdb->getName()) ?> </h2>
                <p></p>
                <?php if($mmdb->getBirthday()) { ?>
                    <p><?php echo esc_html__("Birthday", 'my-movie-db') . ':&nbsp;' . esc_html($mmdb->getBirthday()); ?></p>
                <?php } ?>
                <?php if($mmdb->getPlaceOfBirth()) { ?>
                    <p><?php echo esc_html__("Birthplace", 'my-movie-db') . ':&nbsp;' . esc_html($mmdb->getPlaceOfBirth()); ?></p>
                <?php } ?>
                <?php if($mmdb->getDeathday()) { ?>
                    <p><?php echo esc_html__("Death date", 'my-movie-db') . ':&nbsp;' . esc_html($mmdb->getDeathday()); ?></p>
                <?php } ?>
            </div>
            <div class="description">
                <?php echo esc_textarea($mmdb->getBiography()) ?></div>
        </div>

    </div>
</div>
