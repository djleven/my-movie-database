<div class="mmdb-header">
    <h3 class="mmdb-header-title">
        <?php esc_html_e("Crew", 'my-movie-db');?>
        <span class="pull-right"><?php echo esc_html($mmdb->getName()); ?></span>
    </h3>
</div>
<div class="col-md-12 mmdb-body crew">
    <?php
    $results = $mmdb->getCrew();

    foreach ($results as $result):?>
        <div class="<?php echo esc_attr($this->get_multiple_column_css());?> credits">
            <img class="img-circle" src="<?php echo esc_url($this->public_files->mmdb_get_profile_image($result, $tmdb)); ?>"/>
            <ul class="people">
                <li><?php echo esc_html($result['name']); ?></li>
                <li><?php echo esc_html($result['job']); ?></li>
            </ul>
        </div>
    <?php endforeach; ?>
</div><!-- .mmdb-body -->
