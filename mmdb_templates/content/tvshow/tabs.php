<div id="mmdb-content_<?php echo esc_attr($mmdbID); ?>">
    <div class="mmdbTabs">
        <?php if(isset($show_settings['section_2']) || isset($show_settings['section_3']) || isset($show_settings['section_4'])){ ?>
            <ul class="nav nav-tabs">
                <li class="active">
                    <a href="#<?php echo esc_attr($mmdbID); ?>_tv_1" id="overview_tab_<?php echo esc_attr($mmdbID); ?>_tv" data-toggle="tab"><?php esc_html_e("Overview", 'my-movie-db');?></a>
                </li>
                <?php if(isset($show_settings['section_2'])) { ?>
                    <li><a href="#<?php echo esc_attr($mmdbID); ?>_tv_2" id="cast_tab_<?php echo esc_attr($mmdbID); ?>_tv" data-toggle="tab"><?php esc_html_e("Cast", 'my-movie-db');?></a>
                    </li>
                <?php } ?>
                <?php if(isset($show_settings['section_3'])) { ?>
                    <li><a href="#<?php echo esc_attr($mmdbID); ?>_tv_3" id="crew_tab_<?php echo esc_attr($mmdbID); ?>_tv" data-toggle="tab"><?php esc_html_e("Crew", 'my-movie-db');?></a>
                    </li>
                <?php } ?>
                <?php if(isset($show_settings['section_4'])) { ?>
                    <li><a href="#<?php echo esc_attr($mmdbID); ?>_tv_4" id="trailer_tab_<?php echo esc_attr($mmdbID); ?>_tv" data-toggle="tab"><?php esc_html_e("Seasons", 'my-movie-db');?></a>
                    </li>
                <?php } ?>
            </ul>
        <?php } ?>
        <div class="tab-content mmdb-header collapse in" id="tab-content_<?php echo esc_attr($mmdbID); ?>_tv" aria-expanded="true">
            <div class="tab-pane active" id="<?php echo esc_attr($mmdbID); ?>_tv_1">
                <?php include $this->mmdb_get_template_part('tv-main'); ?>
            </div><!-- .tab-pane -->
            <?php if(isset($show_settings['section_2'])) { ?>
                <div class="tab-pane" id="<?php echo esc_attr($mmdbID); ?>_tv_2">
                    <?php include $this->mmdb_get_template_part('tv-cast'); ?>
                </div>
            <?php } ?>
            <?php if(isset($show_settings['section_3'])) { ?>
                <div class="tab-pane" id="<?php echo esc_attr($mmdbID); ?>_tv_3">
                    <?php include $this->mmdb_get_template_part('tv-crew'); ?>
                </div>
            <?php } ?>
            <?php if(isset($show_settings['section_4'])) { ?>
                <div class="tab-pane" id="<?php echo esc_attr($mmdbID); ?>_tv_4">
                    <?php include $this->mmdb_get_template_part('tv-seasons'); ?>
                </div>
            <?php } ?>
        </div>
    </div>
    <div class="clearfix"></div>
</div><!-- #main -->