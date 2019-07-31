jQuery(function($){

  $(document).ready(function() {

    $('td.block').append('<i class="fa fa-cog fa-lg block-settings"></i>');

    var block_settings = {}

    $('.block-settings').click(function() {
      $('.block-settings.active').removeClass('fa-spin').removeClass('active');
      if($(this).parent('.block-single-setting').length) {
        block_settings['theme'] = $(this).parent().attr('data-theme');
        block_settings['block_id'] = $(this).parent().attr('data-id');
      }
      else {
        block_settings['theme'] = $(this).parent().next().find('input[type="hidden"]').attr('value');
        block_settings['block_id'] = $(this).parent().next().find('input[type="hidden"]').attr('name').replace('blocks[', '').replace('][theme]', '');
      }
      // Open form and load block settings
      $("#block-settings").dialog( "open" );
      // Clear all settings
      $('#block-settings .input-setting').val('');
      // Load block settings to form
      var settings = Drupal.settings.nikadevs_cms.block_settings;
      if(typeof(Drupal.settings.nikadevs_cms.block_settings[block_settings['block_id']]) != 'undefined') {
        for(setting in settings[block_settings['block_id']]) {
          $('#block-settings [name="' + setting + '"]').val(settings[block_settings['block_id']][setting]);
        }
      }
      $(this).addClass('active');
      return false;
    });

    $("#block-settings").dialog({
      autoOpen: false,
      width: 700,
      modal: true,
      buttons: {
        "Save": function() {
          // Save settings from Form to variable
          $('#block-settings .input-setting').each(function() {
            block_settings[$(this).attr('name')] = $(this).val();
          });
          $('.block-settings.active').addClass('fa-spin');
          // Save block settings
          $.getJSON(Drupal.settings.basePath + '?q=nikadevs_cms/block_settings/update', {'block_settings' : block_settings}, function(settings) {
            // Update global settings
            Drupal.settings.nikadevs_cms.block_settings = settings;
            // Show user what's happened
            $('.block-settings.active').removeClass('fa-spin active').after('<span class = "saving-info btn btn-xs btn-success">Saved.</span>');
            // Hide notice message
            setTimeout(function() {
              $('.saving-info').animate({opacity: 0}, 500, function() {
                $(this).remove();
              });
            }, 1000);
          });
          $(this).dialog( "close" );
        },
        Cancel: function() {
          $(this).dialog( "close" );
        }
      },
    });

  }); // end doc ready 

}); // end no conflict
