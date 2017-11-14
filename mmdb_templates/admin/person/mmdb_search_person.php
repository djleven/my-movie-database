<?php
/**
 * The person post type template for the admin search results
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
        <?php foreach($mmdb_results as $mmdb_result) {
            ?>

            <!-- the post type template - for each - of the admin search results -->
            <div class="col-lg-4 col-md-6 col-sm-6">
                <div id="<?php echo esc_attr($mmdb_result->getID()) ?>" class="movie-container" style="margin-bottom:40px">
                    <img src=<?php echo esc_url($this->public_files->mmdb_get_profile($mmdb_result))?> />
                    <div class="info">
                        <h2><?php echo esc_html($mmdb_result->getName()) ?> </h2>
                        <p><strong><?php esc_html_e("TMDb ID: ", 'my-movie-db');?></strong><?php echo esc_html($mmdb_result->getID());?></p>
                        <?php if($mmdb_result->get('known_for')) { ?>
                            <div style="line-height: 15px; padding-top: 5px;"><strong><?php echo esc_html__("Known for", 'my-movie-db') . ': </strong>' . esc_html(mmdb_get_csv_list($mmdb_result->get('known_for'), 'title', '30'));?>
                            </div>
                        <?php } ?>

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

