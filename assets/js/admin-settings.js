jQuery( function ( $ ) {
    let conditionalSettingFields = {
        widthSelectFieldsEl: "select[id^='mmdb_opt_'][name$='_width]']",
        customWidthSelectFieldsEl: "input[id^='mmdb_opt_'][name$='_custom_width]']",
        submitButtonsEl: "div[id^='mmdb_opt_'] .submit input[name='submit']",
        toggleEl: function(targetTrEl, shouldShow) {
            let shouldDisable = null
            if(shouldShow === true) {
                targetTrEl.show()
            } else {
                targetTrEl.hide()
                shouldDisable = false
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
            this.onChangeWidth()
            this.onChangeCustomWidth()
        },
        onRender: function() {
            $(this.widthSelectFieldsEl).each(function (index, selector) {
                conditionalSettingFields.toggleEl(
                    conditionalSettingFields.getTargetSiblingTrEl(selector),
                    $(selector).find(":selected").val() === 'custom'
                )
            })
        },
        onChangeWidth: function() {
            $(this.widthSelectFieldsEl).on('change', function () {
                conditionalSettingFields.toggleEl(
                    conditionalSettingFields.getTargetSiblingTrEl(this),
                    this.value === 'custom'
                )
            })
        },
        onChangeCustomWidth: function() {
            $(this.customWidthSelectFieldsEl).on('input', function () {
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
