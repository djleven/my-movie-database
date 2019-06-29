<div class="mmdb-header">
    <h3 class="mmdb-header-title">
        <?php esc_html_e("Tv Roles and Appearances", 'my-movie-db');?>
        <span class="pull-right"><?php echo esc_html($mmdb->getName()); ?></span>
    </h3>
</div>
<div class="col-md-12 mmdb-body" id="tv_appearances">
    <div>
        <?php $guest = false;
        $results = $mmdb->getTVShowRoles();
        if($results) :
            foreach ($results as $result):
                if($result->getTVShowEpisodeCount() < 3) { $guest = true;}
                if($result->getTVShowEpisodeCount() > 2) : ?>

                    <div class="<?php echo esc_attr($this->get_two_column_css());?> credits">
                        <img src="<?php echo esc_url($this->public_files->mmdbGetBackdropPoster($result, $mmdbImagePath)); ?>"/>
                        <ul class="people">
                            <li><?php echo esc_html($result->getTVShowName()); ?></li>
                            <li><?php echo esc_html($result->getCharacter()); ?></li>
                        </ul>
                    </div>

                <?php endif;

            endforeach;
         endif; ?>
    </div>
    <?php if($guest) { ?>
        <div>
            <h4><?php esc_html_e("Guest Appearances", 'my-movie-db');?></h4>
        </div>
    <?php }?>
    <div>
        <?php if($results) :
            foreach ($results as $result):
                if($result->getTVShowEpisodeCount() < 3) : ?>

                    <div class="<?php echo esc_attr($this->get_two_column_css());?> credits">
                        <img src="<?php echo esc_url($this->public_files->mmdbGetBackdropPoster($result, $mmdbImagePath)); ?>"/>
                        <ul class="people">
                            <li><?php echo esc_html($result->getTVShowName()); ?></li>
                            <li><?php echo esc_html($result->getCharacter()); ?></li>
                        </ul>
                    </div>

                <?php endif;
            endforeach;
        endif;?>
    </div>
</div><!-- .mmdb-body -->
