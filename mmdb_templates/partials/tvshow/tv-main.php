<?php
$genres = esc_html(mmdb_get_object_csv_list($mmdb->getGenres(), 'getName', '5'));
$creators = esc_html(mmdb_get_csv_list($mmdb->getCreators(), 'name', '5'));
$starring = esc_html(mmdb_get_cast_list($mmdb, '4'));
$countEpisodes = esc_html($mmdb->getNumEpisodes());
$countSeasons = esc_html($mmdb->getNumSeasons());
$firstAirDate = esc_html($mmdb->getFirstAirDate());
$lastAirDate = esc_html($mmdb->getLastAirDate());
$homePage = esc_url($mmdb->getHomePage());
$runtime = esc_html($mmdb->getRuntime());
$networks = esc_html(mmdb_get_csv_list($mmdb->getNetworks(), 'name', '5'));
$companies = esc_html(mmdb_get_name_list($mmdb, 'networks'));

if($show_settings['section_2'] || $show_settings['section_3'] || $show_settings['section_4']) : ?>
    <div class="mmdb-header">
        <h3 class="mmdb-header-title"><?php esc_html_e("Summary", 'my-movie-db');?></h3>
    </div>
<?php endif ?>
<div class="col-md-12 mmdb-body overview">
    <h1 class="entry-title">
        <?php if($firstAirDate) : ?>
            <?php echo esc_html($mmdb->getName()) . ' (' . esc_html($mmdb->getFirstAirDate("Y")) . ')';?>
        <?php else : ?>
            <?php echo esc_html($mmdb->getName());?>
        <?php endif ?>
    </h1>
    <div class="<?php echo esc_attr($this->get_two_column_css());?>">
        <img class="mmdb-poster"
             src="<?php echo esc_url($this->public_files->mmdbGetPoster($mmdb, $mmdbPosterPath, 'large')) ?>"
        />
    </div>
    <div class="outer-meta <?php echo esc_attr($this->get_two_column_css());?>">

        <div class="mmdb-meta">
            <?php if($genres) : ?>
            <div><strong><?php echo esc_html__("Genres", 'my-movie-db') . ': ';?></strong>
                <?php echo $genres;?>
            </div>
            <?php endif ?>
            <?php if($creators) : ?>
            <div><strong><?php echo esc_html__("Created by", 'my-movie-db') . ': ';?></strong>
                <?php echo $creators;?>
            </div>
            <?php endif ?>
            <?php if($starring) : ?>
                <div><strong><?php echo esc_html__("Starring", 'my-movie-db') . ': ';?></strong>
                    <?php echo $starring; ?>
                </div>
            <?php endif ?>
            <?php if($countEpisodes && $countEpisodes) : ?>
            <div><strong><?php echo esc_html__("Episodes / Seasons", 'my-movie-db') . ': ';?></strong>
                <?php echo $countEpisodes . ' / ' . $countSeasons;?>
            </div>
            <?php endif ?>
            <?php if($firstAirDate) : ?>
                <div><strong><?php echo esc_html__("First aired", 'my-movie-db') . ': ';?></strong>
                    <?php echo $firstAirDate;?>
                </div>
            <?php endif ?>
            <?php if((!($mmdb->getInProduction())) && $lastAirDate) : ?>
                <div><strong><?php echo esc_html__("Last air date", 'my-movie-db') . ': ';?></strong>
                    <?php echo $lastAirDate;?>
                </div>
            <?php endif;
            if($homePage) : ?>
                <div>
                    <a target="_blank" href="<?php echo $homePage;?>">
                        <strong><?php echo esc_html__("Website", 'my-movie-db');?></strong>
                    </a>
                </div>
            <?php endif ?>
            <?php if($runtime) : ?>
            <div><strong><?php echo esc_html__("Runtime", 'my-movie-db') . ': ';?></strong>
                <?php echo $runtime . esc_html__("min", 'my-movie-db') ;?>
            </div>
            <?php endif ?>
        </div><!-- .mmdb-meta -->

    </div><!-- .col -->
    <?php if($show_settings['overview_text']) : ?>
        <div class="col-md-12"  id="overview-text">
            <?php echo esc_textarea($mmdb->getOverview()) ?>
        </div>
    <?php endif ?>
    <div class="col-md-12">
        <?php if($networks) : ?>
        <div><strong><?php echo esc_html__("Networks", 'my-movie-db') . ': ';?></strong>
            <?php echo $networks;?>
        </div>
        <?php endif ?>
        <?php if($companies) : ?>
        <div><strong><?php echo esc_html__("Production Companies", 'my-movie-db') . ': ';?></strong>
            <?php echo $companies;?>
        </div>
        <?php endif ?>
    </div>

</div><!-- .md12 mmdb-body-->
