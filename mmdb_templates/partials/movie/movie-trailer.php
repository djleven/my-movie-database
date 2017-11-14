<div class="mmdb-header">
    <h3 class="mmdb-header-title">
        <?php esc_html_e("Trailer", 'my-movie-db');?>
        <span class="pull-right"><?php echo esc_html($mmdb->getTitle()); ?></span>
    </h3>
</div>
<div class="col-md-12 mmdb-body" id="trailer">
    <p>
        <img class="text-center"
             src="https://img.youtube.com/vi/<?php echo esc_attr($mmdb->getTrailer()); ?>/hqdefault.jpg"/>
    </p>
    <p>
        <a href="#myModal" class="btn btn-lg btn-primary text-center" data-toggle="modal">
            <?php echo esc_html__("Launch", 'my-movie-db') . '&nbsp;' . esc_html__("Trailer", 'my-movie-db');?>
        </a>
    </p>
</div>
<!-- Modal HTML -->

<div id="myModal" class="modal fade">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="mmdb modal-title pull-left"><?php echo esc_html($mmdb->getTitle()); ?> <?php esc_html_e("Trailer", 'my-movie-db');?></h4>
                <button type="button" class="close pull-right" data-dismiss="modal" aria-hidden="true">&times;</button>
            </div>
            <div class="modal-body">
                <div id="trailer-video">
                    <iframe id="trailerVideo" width="560" height="315" frameborder="0"
                            src="https://www.youtube-nocookie.com/embed/<?php echo esc_attr($mmdb->getTrailer()); ?>" allowfullscreen></iframe>
                </div>
            </div>
        </div>
    </div>
</div>
