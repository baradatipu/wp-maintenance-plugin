(function($) {
    'use strict';
    
    $(document).ready(function() {
        // Initialize color picker
        $('.color-picker').wpColorPicker();

        // Media uploader for logo
        var mediaUploader;

        $('#upload-logo').on('click', function(e) {
            e.preventDefault();

            if (mediaUploader) {
                mediaUploader.open();
                return;
            }

            mediaUploader = wp.media({
                title: 'Choose Logo',
                button: {
                    text: 'Use this image'
                },
                multiple: false
            });

            mediaUploader.on('select', function() {
                var attachment = mediaUploader.state().get('selection').first().toJSON();
                $('#construction_mode_logo').val(attachment.url);
                $('#logo-preview').attr('src', attachment.url).show();
                $('#remove-logo').show();
            });

            mediaUploader.open();
        });

        $('#remove-logo').on('click', function(e) {
            e.preventDefault();
            $('#construction_mode_logo').val('');
            $('#logo-preview').attr('src', '').hide();
            $(this).hide();
        });
    });
})(jQuery);
