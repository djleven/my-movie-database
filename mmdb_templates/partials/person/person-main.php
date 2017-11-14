<?php if(isset($show_settings['section_2']) || isset($show_settings['section_3']) || isset($show_settings['section_4'])){ ?>
    <div class="mmdb-header">
        <h3 class="mmdb-header-title"><?php esc_html_e("Summary", 'my-movie-db');?></h3>
    </div>
<?php } ?>
<div class="col-md-12 mmdb-body" id="overview">
    <h1 class="mmdb-entry-title">
        <?php echo esc_html($mmdb->getName());?>
    </h1>
    <div class="<?php echo esc_attr($this->get_two_column_css());?>">
        <img class="mmdb-poster" src="<?php echo esc_url($tmdb->getSecureImageURL('w300'));
        echo esc_url($mmdb->getProfile()); ?>"/>
    </div><!-- .wrap <h2 class="widget-title">Metadata</h2>	-->
    <div class="outer-meta <?php echo esc_attr($this->get_two_column_css());?>">
        <div class="mmdb-meta">
            <?php if($mmdb->getBirthday()) {?>
                <div><strong><?php echo esc_html__("Birthday", 'my-movie-db') . ': ';?></strong>
                    <?php echo esc_html($mmdb->getBirthday());?>
                </div>
            <?php } ?>

            <?php if($mmdb->getPlaceOfBirth()) {?>
                <div><strong><?php echo esc_html__("Birthplace", 'my-movie-db') . ': ';?></strong>
                    <?php echo esc_html($mmdb->getPlaceOfBirth());?>
                </div>
            <?php } ?>

            <?php if($mmdb->getDeathday()) {?>
                <div><strong><?php echo esc_html__("Death date", 'my-movie-db') . ': ';?></strong>
                    <?php echo esc_html($mmdb->getDeathday());?>
                </div>
            <?php } ?>

            <?php if($mmdb->getMovieRoleCount()) {?>
                <div><strong><?php echo esc_html__("Movie Acting Roles", 'my-movie-db') . ': ';?></strong>
                    <?php echo esc_html($mmdb->getMovieRoleCount());?>
                </div>
            <?php } ?>

            <?php if($mmdb->getTvRoleCount()) {?>
                <div><strong><?php echo esc_html__("Tv Roles/Appearances", 'my-movie-db') . ': ';?></strong>
                    <?php echo esc_html($mmdb->getTvRoleCount());?>
                </div>
            <?php } ?>

            <?php if($mmdb->getMovieCrewCount()) {?>
                <div><strong><?php echo esc_html__("Movie Crew Credits", 'my-movie-db') . ': ';?></strong>
                    <?php echo esc_html($mmdb->getMovieCrewCount());?>
                </div>
            <?php } ?>

            <?php if($mmdb->getTvCrewCount()) {?>
                <div><strong><?php echo esc_html__("Tv Crew Credits", 'my-movie-db') . ': ';?></strong>
                    <?php echo esc_html($mmdb->getTvCrewCount());?>
                </div>
            <?php } ?>
            <?php if($mmdb->getImdbID()) {?>
                <div>
                    <a target="_blank" href="http://www.imdb.com/name/<?php echo esc_attr($mmdb->getImdbID());?>"><strong><?php echo esc_html__("Imdb Profile", 'my-movie-db');?></strong></a>

                </div>
            <?php } ?>
            <?php if($mmdb->getHomePage()) {?>
                <div>
                    <a target="_blank" href="<?php echo esc_url($mmdb->getHomePage());?>"><strong><?php echo esc_html__("Website", 'my-movie-db');?></strong></a>

                </div>
            <?php } ?>

        </div><!-- .mmdb-meta -->
    </div><!-- .col -->
    <?php if(isset($show_settings['overview_text'])){ ?>
        <div class="col-md-12" style="text-align:left;">
            <?php echo esc_textarea($mmdb->getΒiography()) ?>
        </div>
    <?php } ?>
</div><!-- .md12 -->
