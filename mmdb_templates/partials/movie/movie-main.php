<?php if(isset($show_settings['section_2']) || isset($show_settings['section_3']) || isset($show_settings['section_4'])){ ?>
    <div class="mmdb-header">
        <h3 class="mmdb-header-title"><?php esc_html_e("Summary", 'my-movie-db');?></h3>
    </div>
<?php } ?>
<div class="col-md-12 mmdb-body overview">
    <h1 class="mmdb-entry-title">
        <?php echo esc_html($mmdb->getTitle()) . ' (' . esc_html($mmdb->getRelDate("Y")) . ')';?>
    </h1>
    <div class="<?php echo esc_attr($this->get_two_column_css());?>">
        <img class="mmdb-poster" src="<?php echo esc_url($tmdb->getSecureImageURL('w300'));
        echo esc_url($mmdb->getPoster()); ?>"/>
    </div><!-- .wrap <h2 class="widget-title">Metadata</h2>	-->
    <div class="outer-meta <?php echo esc_attr($this->get_two_column_css());?>">
        <div class="mmdb-meta">
            <div><strong><?php echo esc_html__("Release Date", 'my-movie-db') . ': ';?></strong>
                <?php echo esc_html($mmdb->getRelDate()); ?>
            </div>
            <div><strong><?php echo esc_html__("Starring", 'my-movie-db') . ': ';?></strong>
                <?php echo esc_html(mmdb_get_cast_list($mmdb, '4')); ?>
            </div>
            <div><strong><?php echo esc_html__("Genres", 'my-movie-db') . ': ';?></strong>
                <?php echo esc_html(mmdb_get_name_list($mmdb, 'genre')); ?>
            </div>
            <div><strong><?php echo esc_html__("Runtime", 'my-movie-db') . ': ';?></strong>
                <?php echo esc_html($mmdb->getRuntime()); ?> min
            </div>
            <div><strong><?php echo esc_html__("Original Title", 'my-movie-db') . ': ';?></strong>
                <?php echo esc_html($mmdb->getOrigTitle()); ?>
            </div>
            <div><strong><?php echo esc_html__("Original Film Language", 'my-movie-db') . ': ';?></strong>
                <?php $results = $mmdb->getLanguages();
                foreach ($results as $result) {
                    if ($mmdb->getOrigLang() == $result['iso_639_1']) {
                        echo esc_html($result['name']);
                    }
                }
                ?>
            </div>
            <div><strong><?php echo esc_html__("Production Companies", 'my-movie-db') . ': ';?></strong>
                <?php echo esc_html(mmdb_get_name_list($mmdb, 'companies'));?>
            </div>
        </div><!-- .mmdbmeta -->
    </div><!-- .col7 -->
    <?php if(isset($show_settings['overview_text'])){ ?>
        <div class="col-md-12" style="text-align:left;">
            <?php echo esc_textarea($mmdb->getOverview()); ?>
        </div>
    <?php } ?>
</div><!-- .md12 -->
