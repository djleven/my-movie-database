jQuery( function ( $ ) {
    let conditionalSettingFields = {
        cacheTypeToDeleteSelector: "select[id='mmdb_opt_cache_manager[mmdb_delete_cache_type]']",
        cacheIDToDeleteSelector: "input[id='mmdb_opt_cache_manager[mmdb_delete_cache_id]']",
        toggleEl: function(targetTrEl, shouldShow) {
            let shouldDisable = null
            if(shouldShow === true) {
                targetTrEl.show()
            } else {
                targetTrEl.hide()
                shouldDisable = true
            }

            this.toggleDisableSubmitEl(targetTrEl, shouldDisable)
        },
        toggleDisableSubmitEl: function(sourceCustomWidthTrEl, isDisabled = null) {
            if(isDisabled === null) {
                isDisabled = Boolean(!$(
                    $(sourceCustomWidthTrEl.children([0]).next()).children()[0]
                ).val())
            }
            $(this.getTargetSubmitElFromTrEl(sourceCustomWidthTrEl)).prop('disabled', isDisabled)
        },
        init: function() {
            this.onRender()
            this.onChangeCacheTypeValue()
            this.onChangeCacheIdValue()
        },
        onRender: function() {
            conditionalSettingFields.toggleEl(
                conditionalSettingFields.getTargetSiblingTrEl(this.cacheTypeToDeleteSelector),
                $(this.cacheTypeToDeleteSelector).find(":selected").val() !== ''
            )
        },
        onChangeCacheTypeValue: function() {
            $(this.cacheTypeToDeleteSelector).on('change', function () {
                conditionalSettingFields.toggleEl(
                    conditionalSettingFields.getTargetSiblingTrEl(this),
                    this.value !== ''
                )
            })
        },
        onChangeCacheIdValue: function() {
            $(this.cacheIDToDeleteSelector).on('input', function () {
                conditionalSettingFields.toggleDisableSubmitEl(
                    $(this).parent().parent(),
                    this.value === ''
                )
            })
        },
        getTargetSiblingTrEl: function (sourceWidthEl){
            return $(sourceWidthEl).parent().parent().next()
        },
        getTargetSubmitElFromTrEl: function (sourceCustomWidthEl){
            return $($(sourceCustomWidthEl.parents()[1]).next().children()[0]).children()[0]
        },
    }

    $(document).ready(function() {
        conditionalSettingFields.init()
    })
});
