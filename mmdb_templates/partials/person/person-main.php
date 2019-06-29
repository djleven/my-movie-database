<?php
$birthDay = esc_html($mmdb->getBirthday());
$birthPlace = esc_html($mmdb->getPlaceOfBirth());
$deathDay = esc_html($mmdb->getDeathday());
$movieRoleCount = esc_html($mmdb->getMovieRoleCount());
$tvRoleCount = esc_html($mmdb->getTvRoleCount());
$movieCrewCount = esc_html($mmdb->getMovieCrewCount());
$tvCrewCount = esc_html($mmdb->getTvCrewCount());
$imdbID = esc_attr($mmdb->getImdbID());
$homePage = esc_url($mmdb->getHomePage());

if($show_settings['section_2'] || $show_settings['section_3'] || $show_settings['section_4']) : ?>
    <div class="mmdb-header">
        <h3 class="mmdb-header-title"><?php esc_html_e("Summary", 'my-movie-db');?></h3>
    </div>
<?php endif ?>
<div class="col-md-12 mmdb-body" id="overview">
    <h1 class="mmdb-entry-title">
        <?php echo esc_html($mmdb->getName());?>
    </h1>
    <div class="<?php echo esc_attr($this->get_two_column_css());?>">
        <img class="mmdb-poster"
             src="<?php echo esc_url($this->public_files->mmdbGetProfile($mmdb, $mmdbPosterPath, 'large')); ?>"
        />
    </div><!-- .wrap <h2 class="widget-title">Metadata</h2>	-->
    <div class="outer-meta <?php echo esc_attr($this->get_two_column_css());?>">
        <div class="mmdb-meta">
            <?php if($birthDay) : ?>
                <div><strong><?php echo esc_html__("Birthday", 'my-movie-db') . ': ';?></strong>
                    <?php echo $birthDay;?>
                </div>
            <?php endif ?>

            <?php if($birthPlace) : ?>
                <div><strong><?php echo esc_html__("Birthplace", 'my-movie-db') . ': ';?></strong>
                    <?php echo $birthPlace;?>
                </div>
            <?php endif ?>

            <?php if($deathDay) : ?>
                <div><strong><?php echo esc_html__("Death date", 'my-movie-db') . ': ';?></strong>
                    <?php echo $deathDay;?>
                </div>
            <?php endif ?>

            <?php if($movieRoleCount) : ?>
                <div><strong><?php echo esc_html__("Movie Acting Roles", 'my-movie-db') . ': ';?></strong>
                    <?php echo $movieRoleCount?>
                </div>
            <?php endif ?>

            <?php if($tvRoleCount) : ?>
                <div><strong><?php echo esc_html__("Tv Roles/Appearances", 'my-movie-db') . ': ';?></strong>
                    <?php echo $tvRoleCount; ?>
                </div>
            <?php endif ?>

            <?php if($movieCrewCount) : ?>
                <div><strong><?php echo esc_html__("Movie Crew Credits", 'my-movie-db') . ': ';?></strong>
                    <?php echo $movieCrewCount;?>
                </div>
            <?php endif ?>

            <?php if($tvCrewCount) : ?>
                <div><strong><?php echo esc_html__("Tv Crew Credits", 'my-movie-db') . ': ';?></strong>
                    <?php echo $tvCrewCount;?>
                </div>
            <?php endif ?>
            <?php if($imdbID) : ?>
                <div>
                    <a target="_blank" href="https://www.imdb.com/name/<?php echo $imdbID;?>">
                        <strong><?php echo esc_html__("Imdb Profile", 'my-movie-db');?></strong>
                    </a>
                </div>
            <?php endif ?>
            <?php if($homePage) : ?>
                <div>
                    <a target="_blank" href="<?php echo $homePage;?>">
                        <strong><?php echo esc_html__("Website", 'my-movie-db');?></strong>
                    </a>
                </div>
            <?php endif ?>

        </div><!-- .mmdb-meta -->
    </div><!-- .col -->
    <?php if($show_settings['overview_text']) : ?>
        <div class="col-md-12" style="text-align:left;">
            <?php echo esc_textarea($mmdb->getBiography()) ?>
        </div>
    <?php endif ?>
</div><!-- .md12 -->
