<div class="mmdb-header">
    <h3 class="mmdb-header-title">
        <?php esc_html_e("Movie Roles", 'my-movie-db');?>
        <span class="pull-right"><?php echo esc_html($mmdb->getName()); ?></span>
    </h3>
</div>
<div class="col-md-12 mmdb-body">
    <?php
    $results = $mmdb->getMovieRoles();

    foreach ($results as $result):?>
        <div class="movie-role-wrapper">
            <div class="col-sm-4 poster-img">
                <img src="<?php echo esc_url($this->public_files->mmdbGetPoster($result, $mmdbImagePath)); ?>"/>
            </div>
            <div class="col-sm-8 outer-180">
                <ul class="movie-role">
                    <li><?php echo esc_html($result->getMovieTitle()); ?></li>
                    <li><?php echo esc_html($result->getMovieReleaseDate()); ?></li>
                    <li><strong><?php echo esc_html($result->getCharacter()); ?></strong></li>
                    <li class="mmdb-desc"><?php echo esc_textarea(mmdb_get_desc($result->getMovieOverview(), '380')) ;?></li>
                </ul>
            </div>
        </div>
        <div class="clearfix"></div>
    <?php endforeach; ?>
</div><!-- .mmdb-body -->
