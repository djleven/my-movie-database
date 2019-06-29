<div class="mmdb-header">
    <h3 class="mmdb-header-title">
        <?php esc_html_e("Crew Credits", 'my-movie-db');?>
        <span class="pull-right"><?php echo esc_html($mmdb->getName()); ?></span>
    </h3>
</div>
<div class="col-md-12 mmdb-body crew_credits">
    <?php
    $mvresults = $mmdb->getMovieJobs();
    $tvresults = $mmdb->getTVShowJobs();

    if($mvresults) : ?>
        <div>
            <h4><?php esc_html_e("Movie Credits", 'my-movie-db');?></h4>
        </div>

        <div>
            <?php foreach ($mvresults as $result): ?>

                <div class="<?php echo esc_attr($this->get_two_column_css());?> movie credits">
                    <img src="<?php echo esc_url($this->public_files->mmdbGetPoster($result, $mmdbImagePath)); ?>"/>
                    <ul class="people">
                        <li><?php echo esc_html($result->getMovieTitle()); ?></li>
                        <li><?php echo esc_html($result->getMovieJob()); ?></li>
                        <li><?php echo esc_html($result->getMovieReleaseDate()); ?></li>
                    </ul>
                </div>

            <?php endforeach; ?>
        </div>
    <?php endif ?>

    <?php if($tvresults) : ?>
        <div>
            <h4><?php esc_html_e("TvShow Credits", 'my-movie-db');?></h4>
        </div>
        <div>
            <?php foreach ($tvresults as $result): ?>

                <div class="<?php echo esc_attr($this->get_two_column_css());?> tv credits">
                    <img src="<?php echo esc_url($this->public_files->mmdbGetBackdropPoster($result, $mmdbImagePath)); ?>"/>
                    <ul class="people">
                        <li><?php echo esc_html($result->getTVShowName()); ?></li>
                        <li><?php echo esc_html($result->getTVShowJob()); ?></li>
                    </ul>
                </div>

            <?php endforeach; ?>
        </div>
    <?php endif ?>
</div><!-- .mmdb-body -->
