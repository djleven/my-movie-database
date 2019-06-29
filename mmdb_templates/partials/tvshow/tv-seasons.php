<div class="mmdb-header">
    <h3 class="mmdb-header-title">
        <?php esc_html_e("Seasons", 'my-movie-db');?>
        <span class="pull-right"><?php echo esc_html($mmdb->getName()); ?></span>
    </h3>
</div>
<div class="col-md-12 mmdb-body seasons">
    <?php
    $results = $mmdb->getSeasons();
    foreach ($results as $result):
        if($result->getSeasonNumber() > 0) :?>
            <div class="col-lg-6 col-md-6 col-sm-6 credits">
                <ul class="seasons">
                    <li><?php echo esc_html__("Season", 'my-movie-db') . '&nbsp;' . esc_html($result->getSeasonNumber()) ?></li>

                    <li><?php echo esc_html__("Air date", 'my-movie-db') . ':&nbsp;' . esc_html($result->getAirDate()) ?></li>

                    <li><?php echo esc_html__("Episodes", 'my-movie-db') . ':&nbsp;' . esc_html($result->get('episode_count')) ?></li>
                </ul>
                <img class="mmdb-poster" src="<?php echo esc_url($this->public_files->mmdbGetPoster($result, $mmdbImagePath)); ?>"/>
            </div>
        <?php endif; endforeach; ?>
</div><!-- .mmdb-body -->
