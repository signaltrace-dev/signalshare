Dropzone.options.fileupload = {
    acceptedFiles: ".mp3,.wav,.ogg",
    sending: function(file, xhr, formData) {
        $('.dz-message').hide();
        formData.append("_token", $('[name=_token').val());
    },
    queuecomplete: function(event) {
        $('.dz-complete').fadeOut(function() {
            $('.dz-message').fadeIn();
        });
    },
    success: function(event, response) {
        if (response.status && response.status == 1) {
            signalsharePlayer.processUpload(response);
        }
    },
};
