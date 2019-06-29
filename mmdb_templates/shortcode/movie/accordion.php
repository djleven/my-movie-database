<div id="mmdb-content_<?php echo esc_attr($mmdbID); ?>">
    <div class="panel-group" id="<?php echo esc_attr($mmdbID); ?>_mv">
        <div class="panel panel-default">
            <div class="panel-heading">
                <h4 class="panel-title">
                    <a data-toggle="collapse" data-parent="#<?php echo esc_attr($mmdbID); ?>_mv" href="#<?php echo esc_attr($mmdbID); ?>_mv_One"><?php esc_html_e("Overview", 'my-movie-db');?></a>
                </h4>
            </div>
            <div id="<?php echo esc_attr($mmdbID); ?>_mv_One" class="panel-collapse collapse in">
                <div class="panel-body mmdb-body">
                    <?php include $this->mmdb_get_template_part('movie-main'); ?>
                </div>
            </div>
        </div>
        <?php if($show_settings['section_2']) { ?>
        <div class="panel panel-default">
            <div class="panel-heading">
                <h4 class="panel-title">
                    <a data-toggle="collapse" data-parent="#<?php echo esc_attr($mmdbID); ?>_mv" href="#<?php echo esc_attr($mmdbID); ?>_mv_Two"><?php echo esc_html__("View", 'my-movie-db') . '&nbsp;' . esc_html__("Cast", 'my-movie-db');?></a>
                </h4>
            </div>
            <div id="<?php echo esc_attr($mmdbID); ?>_mv_Two" class="panel-collapse collapse">
                <div class="panel-body mmdb-body">
                    <?php include $this->mmdb_get_template_part('movie-cast'); ?>
                </div>
            </div>
        </div>
        <?php } ?>
        <?php if($show_settings['section_3']) { ?>
        <div class="panel panel-default">
            <div class="panel-heading">
                <h4 class="panel-title">
                    <a data-toggle="collapse" data-parent="#<?php echo esc_attr($mmdbID); ?>_mv" href="#<?php echo esc_attr($mmdbID); ?>_mv_Three"><?php echo esc_html__("View", 'my-movie-db') . '&nbsp;' . esc_html__("Crew", 'my-movie-db');?></a>
                </h4>
            </div>
            <div id="<?php echo esc_attr($mmdbID); ?>_mv_Three" class="panel-collapse collapse">
                <div class="panel-body mmdb-body">
                    <?php include $this->mmdb_get_template_part('movie-crew'); ?>
                </div>
            </div>
        </div>
        <?php } ?>
        <?php if($show_settings['section_4']) { ?>
        <div class="panel panel-default">
            <div class="panel-heading">
                <h4 class="panel-title">
                    <a data-toggle="collapse" data-parent="#<?php echo esc_attr($mmdbID); ?>_mv" href="#<?php echo esc_attr($mmdbID); ?>_mv_Four"><?php echo esc_html__("View", 'my-movie-db') . '&nbsp;' . esc_html__("Trailer", 'my-movie-db');?></a>
                </h4>
            </div>
            <div id="<?php echo esc_attr($mmdbID); ?>_mv_Four" class="panel-collapse collapse">
                <div class="panel-body mmdb-body">
                    <?php include $this->mmdb_get_template_part('movie-trailer'); ?></p>
                </div>
            </div>
        </div>
        <?php } ?>
    </div>

</div>
