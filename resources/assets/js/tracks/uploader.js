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
            var project_slug = response.project.slug;
            var track_slug = response.track.slug;
            var file_url = response.file.filename;

            // Get track content and add to track list
            $.ajax({
                url: '/projects/' + project_slug + '/tracks/' + track_slug,
                type: 'GET',
                success: function(data) {
                    var fileItem = $('<div/>').html(data).contents();
                    var trackElem = fileItem.first('.track-item');
                    $(trackElem).data('src', '/files/' + file_url);
                    signalsharePlayer.addTrack(trackElem, true);
                }
            });
        }
    },
};
