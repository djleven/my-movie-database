<?php if(isset($show_settings['section_2']) || isset($show_settings['section_3']) || isset($show_settings['section_4'])){ ?>
    <div class="mmdb-header">
        <h3 class="mmdb-header-title"><?php esc_html_e("Summary", 'my-movie-db');?></h3>
    </div>
<?php } ?>
<div class="col-md-12 mmdb-body overview">
    <h1 class="entry-title">
        <?php echo esc_html($mmdb->getName()) . ' (' . esc_html($mmdb->getFirstAirDate("Y")) . ')';?>
    </h1>
    <div class="<?php echo esc_attr($this->get_two_column_css());?>">
        <img class="mmdb-poster" src="<?php echo esc_url($tmdb->getSecureImageURL('w300'));
        echo esc_url($mmdb->getPoster()); ?>"/>
    </div>
    <div class="outer-meta <?php echo esc_attr($this->get_two_column_css());?>">

        <div class="mmdb-meta">
            <div><strong><?php echo esc_html__("Genres", 'my-movie-db') . ': ';?></strong>
                <?php echo esc_html(mmdb_get_object_csv_list($mmdb->getGenres(), 'getName', '5'));?>
            </div>
            <div><strong><?php echo esc_html__("Created by", 'my-movie-db') . ': ';?></strong>
                <?php echo esc_html(mmdb_get_csv_list($mmdb->getCreators(), 'name', '5'));?>
            </div>
            <?php if($mmdb->getCast()) {?>
                <div><strong><?php echo esc_html__("Starring", 'my-movie-db') . ': ';?></strong>
                    <?php echo esc_html(mmdb_get_cast_list($mmdb, '4')); ?>
                </div>
            <?php } ?>
            <div><strong><?php echo esc_html__("Episodes / Seasons", 'my-movie-db') . ': ';?></strong>
                <?php echo esc_html($mmdb->getNumEpisodes()) . ' / ' . esc_html($mmdb->getNumSeasons());?>
            </div>
            <?php if($mmdb->getFirstAirDate()) {?>
                <div><strong><?php echo esc_html__("First aired", 'my-movie-db') . ': ';?></strong>
                    <?php echo esc_html($mmdb->getFirstAirDate());?>
                </div>
            <?php } ?>
            <?php if((!($mmdb->getInProduction())) && $mmdb->getLastAirDate()) {?>
                <div><strong><?php echo esc_html__("Last air date", 'my-movie-db') . ': ';?></strong>
                    <?php echo esc_html($mmdb->getLastAirDate());?>
                </div>
            <?php } ?>
            <?php if($mmdb->getHomePage()) {?>
                <div>
                    <a target="_blank" href="<?php echo esc_url($mmdb->getHomePage());?>">
                        <strong><?php echo esc_html__("Website", 'my-movie-db');?></strong>
                    </a>
                </div>
            <?php } ?>
            <div><strong><?php echo esc_html__("Runtime", 'my-movie-db') . ': ';?></strong>
                <?php echo esc_html($mmdb->getRuntime()); ?> min
            </div>
        </div><!-- .mmdb-meta -->

    </div><!-- .col -->
    <?php if(isset($show_settings['overview_text'])){ ?>
        <div class="col-md-12"  id="overview-text">
            <?php echo esc_textarea($mmdb->getOverview()) ?>
        </div>
    <?php } ?>
    <div class="col-md-12">
        <div><strong><?php echo esc_html__("Networks", 'my-movie-db') . ': ';?></strong>
            <?php echo esc_html(mmdb_get_csv_list($mmdb->getNetworks(), 'name', '5'));?>
        </div>
        <div><strong><?php echo esc_html__("Production Companies", 'my-movie-db') . ': ';?></strong>
            <?php echo esc_html(mmdb_get_name_list($mmdb, 'networks'));?>
        </div>
    </div>

</div><!-- .md12 mmdb-body-->
