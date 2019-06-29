<?php
$relDate = esc_html($mmdb->getRelDate());
$relDateYear = esc_html($mmdb->getRelDate("Y"));
$starring = esc_html(mmdb_get_cast_list($mmdb, '4'));
$genres = esc_html(mmdb_get_name_list($mmdb, 'genre'));
$runtime = esc_html($mmdb->getRuntime());
$originalTitle = esc_html($mmdb->getOrigTitle());
$companies = esc_html(mmdb_get_name_list($mmdb, 'companies'));
$languages = $mmdb->getLanguages();
$originalLanguage = null;
if($languages) {
    foreach ($languages as $result) {
        if ($mmdb->getOrigLang() == $result['iso_639_1']) {
            $originalLanguage = esc_html($result['name']);
        }
    }
}

if($show_settings['section_2'] || $show_settings['section_3'] || $show_settings['section_4']) : ?>
    <div class="mmdb-header">
        <h3 class="mmdb-header-title"><?php esc_html_e("Summary", 'my-movie-db');?></h3>
    </div>
<?php endif ?>
<div class="col-md-12 mmdb-body overview">
    <h1 class="mmdb-entry-title">
        <?php if($relDate) :
            echo esc_html($mmdb->getTitle()) . ' (' . $relDate . ')';
        else :
            echo esc_html($mmdb->getTitle());
        endif ?>
    </h1>
    <div class="<?php echo esc_attr($this->get_two_column_css());?>">
        <img class="mmdb-poster"
             src="<?php echo esc_url($this->public_files->mmdbGetPoster($mmdb, $mmdbPosterPath, 'large')) ?>"
        />
    </div><!-- .wrap <h2 class="widget-title">Metadata</h2>	-->
    <div class="outer-meta <?php echo esc_attr($this->get_two_column_css());?>">
        <div class="mmdb-meta">
            <?php if($relDate) : ?>
            <div><strong><?php echo esc_html__("Release Date", 'my-movie-db') . ': ';?></strong>
                <?php echo $relDate; ?>
            </div>
            <?php endif ?>
            <?php if($starring) : ?>
            <div><strong><?php echo esc_html__("Starring", 'my-movie-db') . ': ';?></strong>
                <?php echo $starring; ?>
            </div>
            <?php endif ?>
            <?php if($genres) : ?>
            <div><strong><?php echo esc_html__("Genres", 'my-movie-db') . ': ';?></strong>
                <?php echo $genres; ?>
            </div>
            <?php endif ?>
            <?php if($runtime) : ?>
            <div><strong><?php echo esc_html__("Runtime", 'my-movie-db') . ': ';?></strong>
                <?php echo $runtime; ?> min
            </div>
            <?php endif ?>
            <?php if($originalTitle) : ?>
            <div><strong><?php echo esc_html__("Original Title", 'my-movie-db') . ': ';?></strong>
                <?php echo $originalTitle; ?>
            </div>
            <?php endif ?>
            <?php if($originalLanguage) : ?>
            <div><strong><?php echo esc_html__("Original Film Language", 'my-movie-db') . ': ';?></strong>
                <?php echo $originalLanguage;?>
            </div>
            <?php endif ?>
            <?php if($companies) : ?>
            <div><strong><?php echo esc_html__("Production Companies", 'my-movie-db') . ': ';?></strong>
                <?php echo $companies;?>
            </div>
            <?php endif ?>
        </div><!-- .mmdbmeta -->
    </div><!-- .col7 -->
    <?php if($show_settings['overview_text']) :?>
        <div class="col-md-12" style="text-align:left;">
            <?php echo esc_textarea($mmdb->getOverview()); ?>
        </div>
    <?php endif ?>
</div><!-- .md12 -->
