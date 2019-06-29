<?php
/**
 * The movie post type template for the admin search results
 *
 * @link       https://e-leven.net/
 * @since      1.0.0
 *
 * @package    My_movie_database
 * @subpackage My_movie_database/admin/partials
 */
?>
<!-- the post type template wrapper -->
<div class="panel panel-default">
    <div class="panel-body" style="text-align: center;">
        <?php
        $imagePath = $tmdb->getSecureImageURL('w185');
        foreach($mmdb_results as $mmdb_result) {
            ?>

            <!-- the post type template - for each - of the admin search results -->
            <div class="col-lg-4 col-md-6 col-sm-6">
                <div id="<?php echo esc_attr($mmdb_result->getID()) ?>" class="movie-container" style="margin-bottom:40px">
                    <img src=<?php echo esc_url($this->public_files->mmdbGetPoster($mmdb_result, $imagePath))?> />
                    <div class="info">
                        <h2><?php echo esc_html($mmdb_result->getTitle()) ?> </h2>
                        <p><strong><?php echo esc_html(substr($mmdb_result->getRelDate() , 0, 4)) ?></strong> (
                            <?php echo esc_html($mmdb_result->getVoteAverage()) ?>/10) </p>
                        <p><strong><?php esc_html_e("TMDb ID: ", 'my-movie-db');?></strong><?php echo esc_html($mmdb_result->getID());?></p>
                    </div>
                    <div class="description">
                        <?php echo esc_textarea($mmdb_result->getOverview()) ?>
                    </div>
                    <!-- don't change this unless you know exactly what you're doing!! -->
                    <?php include __DIR__ . '/../partials/buttons.php'; ?>
                    <!-- oof!! -->
                </div>
            </div>

        <?php }?>
    </div>
</div>
<!-- don't change this unless you know exactly what you're doing!! -->
<?php include __DIR__ . '/../partials/modal.php'; ?>
<!-- oof!! -->

