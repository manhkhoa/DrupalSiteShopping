(function ($) {

var i = 0;
  Drupal.behaviors.nikadevs_background = {
    attach: function (context, settings) {

        $('.upload_bg_image', context).click(function() {
          if($('body > .ui-dialog.media-wrapper').length) {
            return;
          }
          $this = $(this);
          globalOptions = {};
          Drupal.media.popups.mediaBrowser(function (mediaFiles) {
            if (mediaFiles.length < 0) {
              return;
            }
            var mediaFile = mediaFiles[0];
            // Set the value of the filefield fid (hidden).
            $this.parent().prev().find('input').val(mediaFile.fid);
            // Set the preview field HTML.
            $this.parent().prev().find('.bg-image-preview').html(mediaFile.preview);
          }, globalOptions);
          return false;
        });

    }
  };

})(jQuery);