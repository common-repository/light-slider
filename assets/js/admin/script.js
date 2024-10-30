jQuery(document).ready(function ($) {
    $('#btn-create-new-slider').on('click', function (evt) {
        evt.preventDefault();

        var createSliderDialog = $('#dialog-create-new-slider').dialog({
            autoOpen: true,
            width: '80%',
            height: 600,
            modal: true
        });
    });

    $('.sls-preview-slider').on('click', function (evt) {
        evt.preventDefault();

        $('#sls-dialog-preview-slider').find('iframe').attr('src', this.href);

        $('#sls-dialog-preview-slider').dialog({
            autoOpen: true,
            width: '90%',
            height: 600,
            modal: true
        });
    });

    $('.sls-delete-slider').on('click', function (evt) {
        if (!confirm(sls_admin_params.i18n_confirm_delete_slide)) {
            evt.preventDefault();
        }
    });

});