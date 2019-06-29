<div class="mmdb-header">
    <h3 class="mmdb-header-title">
        <?php esc_html_e("Cast", 'my-movie-db');?>
        <span class="pull-right"><?php echo esc_html($mmdb->getTitle()); ?></span>
    </h3>
</div>
<div class="col-md-12 mmdb-body actors">
    <?php
    $results = $mmdb->getCast() ;

    foreach ($results as $result): ?>
        <div class="<?php echo esc_attr($this->get_multiple_column_css());?> credits">
            <img class="img-circle" src="<?php echo esc_url($this->public_files->mmdbGetCreditProfileImage($result, $mmdbProfilePath)); ?>"/>
            <ul class="people">
                <li><?php echo esc_html($result['name']); ?></li>
                <li><?php echo esc_html__("Role", 'my-movie-db') . ':&nbsp;' . esc_html($result['character']); ?></li>
            </ul>
        </div>
    <?php endforeach; ?>
</div><!-- .mmdb-body -->
