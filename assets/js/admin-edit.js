jQuery( function ( $ ) {
    let adminEdit = {
        deleteCacheWrapperId: "mmodb_delete_cache",
        shouldDeleteCachedInputId: "mmodb_should_delete_cached",
        deleteCachedButtonId: "mmodb_delete_cache_submit",
        tmdbLinkId: "mmodb_tmdb_link",
        tmdbInputId: "MovieDatabaseID",
        init: function() {
            this.onChangeTMDbId()
            this.onSubmit()
        },
        onChangeTMDbId: function() {
            $('#' + this.tmdbInputId).on('change', function () {
                const deleteCacheWrapperEl = document.getElementById(adminEdit.deleteCacheWrapperId)
                    if(deleteCacheWrapperEl) {
                        deleteCacheWrapperEl.style.display = "none"
                    }

                adminEdit.updateTMDbLink(this.value)
            })
        },
        onSubmit: function() {
            $('#' + this.deleteCachedButtonId).on('click', function () {
                document.getElementById(adminEdit.shouldDeleteCachedInputId).value = "1"
                document.getElementById("post").submit()
            })
        },
        updateTMDbLink: function(newId) {
            const linkEl = document.getElementById(this.tmdbLinkId)
            linkEl.href = this.getNewLink(newId, linkEl.href)
        },
        getNewLink: function(newId, oldUrl) {
            const oldId = oldUrl.substring(oldUrl.lastIndexOf('/') + 1);
            if(oldId) {
                return oldUrl.replace(oldId, newId)
            }
            return oldUrl + newId
        },
    }

    $(document).ready(function() {
        adminEdit.init()
    })
});
