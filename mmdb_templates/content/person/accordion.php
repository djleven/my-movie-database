<div id="mmdb-content_<?php echo esc_attr($mmdbID); ?>">
    <div class="panel-group" id="<?php echo esc_attr($mmdbID); ?>_ps">
        <div class="panel panel-default">
            <div class="panel-heading">
                <h4 class="panel-title">
                    <a data-toggle="collapse" data-parent="#<?php echo esc_attr($mmdbID); ?>_ps" href="#<?php echo esc_attr($mmdbID); ?>_ps_One"><?php esc_html_e("Overview", 'my-movie-db');?></a>
                </h4>
            </div>
            <div id="<?php echo esc_attr($mmdbID); ?>_ps_One" class="panel-collapse collapse in">
                <div class="panel-body mmdb-body">
                    <?php include $this->mmdb_get_template_part('person-main'); ?>
                </div>
            </div>
        </div>
        <?php if($show_settings['section_2']) { ?>
        <div class="panel panel-default">
            <div class="panel-heading">
                <h4 class="panel-title">
                    <a data-toggle="collapse" data-parent="#<?php echo esc_attr($mmdbID); ?>_ps" href="#<?php echo esc_attr($mmdbID); ?>_ps_Two"><?php echo esc_html__("View", 'my-movie-db') . '&nbsp;' . esc_html__("Movie Roles", 'my-movie-db');?></a>
                </h4>
            </div>
            <div id="<?php echo esc_attr($mmdbID); ?>_ps_Two" class="panel-collapse collapse">
                <div class="panel-body mmdb-body">
                    <?php include $this->mmdb_get_template_part('person-movie'); ?>
                </div>
            </div>
        </div>
        <?php } ?>
        <?php if($show_settings['section_3']) { ?>
        <div class="panel panel-default">
            <div class="panel-heading">
                <h4 class="panel-title">
                    <a data-toggle="collapse" data-parent="#<?php echo esc_attr($mmdbID); ?>_ps" href="#<?php echo esc_attr($mmdbID); ?>_ps_Three"><?php echo esc_html__("View", 'my-movie-db') . '&nbsp;' . esc_html__("Tv Roles and Appearances", 'my-movie-db');?></a>
                </h4>
            </div>
            <div id="<?php echo esc_attr($mmdbID); ?>_ps_Three" class="panel-collapse collapse">
                <div class="panel-body mmdb-body">
                    <?php include $this->mmdb_get_template_part('person-tv'); ?>
                </div>
            </div>
        </div>
        <?php } ?>
        <?php if($show_settings['section_4']) { ?>
        <div class="panel panel-default">
            <div class="panel-heading">
                <h4 class="panel-title">
                    <a data-toggle="collapse" data-parent="#<?php echo esc_attr($mmdbID); ?>_ps" href="#<?php echo esc_attr($mmdbID); ?>_ps_Four"><?php echo esc_html__("View", 'my-movie-db') . '&nbsp;' . esc_html__("Crew Credits", 'my-movie-db');?></a>
                </h4>
            </div>
            <div id="<?php echo esc_attr($mmdbID); ?>_ps_Four" class="panel-collapse collapse">
                <div class="panel-body mmdb-body">
                    <?php include $this->mmdb_get_template_part('person-jobs'); ?></p>
                </div>
            </div>
        </div>
        <?php } ?>
    </div>

</div>
