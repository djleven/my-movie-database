(function($) {
    $(document).ready(function() {
        let body = 'body';
        let posttype;
        $('#search_mmdb').click(function() {
            $('#loader').css('display', 'block');
            let key = $('#key_mmdb').val();
            $.each($(body).attr('class').split(' '), function(index, className) {
                if (className.indexOf('post-type') === 0) {
                    posttype = className;
                }
            });
            $.ajax({
                type: "POST",
                url: ajaxurl,
                data: {
                    action: 'search_mmdb',
                    posttype: posttype,
                    key: key
                }
            }).done(function(msg) {
                $("#resultHtml").html(msg);
                $('#loader').css('display', 'none');
            });
        });

        $('#remove_mmdb').click(function() {
            $(".selection-wrapper").html('');
            $("input#MovieDatabaseID").val(0);
        });

        $("#resultHtml").on("click", ".movie-container", function() {
            let duplicate = $(this).clone();
            $("#modal-window-id").html(duplicate);
            $("#movie-modal").trigger("click");
        });

        function mmdb_id_add() {
            let id_mmdb = $('#TB_ajaxContent #id_mmdb').val();
            let mmdb_title = $('#TB_ajaxContent .info h2').text();
            let duplicate = $('#modal-window-id').clone();
            $("#selected-status").html('');
            $("#selected").html(duplicate);
            $("#selected #modal-window-id").fadeIn();
            $("input#MovieDatabaseID").val(id_mmdb);
            $("#key_mmdb").val(mmdb_title);
            if($("#title").val() == '') {
                $("#title").val(mmdb_title);
            }
            tb_remove();
        }
        $(body).on("click", "#mmdb_id_add", function() {
            mmdb_id_add();
        });
        $(body).on("click", "#tb_remove", function() {
            tb_remove();
        });
    });
})(jQuery);
