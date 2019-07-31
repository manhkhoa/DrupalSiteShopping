  jQuery(function($){

  jQuery.fn.outerHTML = function() {
    return jQuery('<div />').append(this.eq(0).clone()).html();
  };

  $(document).ready(function() {

    $('.form-select').each(function() {
      $(this).click();
      $(this).mouseup();
      $(this).keyup();
      $(this).change();
    });

    var active_layout = $('.layouts .active').attr('id');

    function update_layout(op) {
      // Going throught active layout to save all settings
      $this = $('.layout.active');
      var settings = Drupal.settings.nikadevs_cms.layouts[active_layout];
      var layout = {'name' : $('a[href="#' + $this.attr('id') + '"]').text(), 'pages' : settings['pages'], 'settings' : settings['settings'], 'rows': {}, 'regions' : {}};

      // Save rows settings
      $this.find('.row').each(function() {
        var id = $(this).attr('id');
        layout['rows'][$(this).attr('id')] = {
          'name' : $(this).find('h2 span').text(),
          'attributes' : attributes($(this)),
          'settings': typeof(settings['rows'][id]['settings']) != 'undefined' ? settings['rows'][id]['settings'] : {}
        };
      });

      // Save regions settings
      $this.find('.col').each(function() {
        if($(this).closest('.row').attr('id') != 'id-0') {
          var id = $(this).attr('id');
          layout['regions'][id] = {
            'row_id' : $(this).closest('.row').attr('id'),
            'name' : $(this).find('h3').text(),
            'attributes' : attributes($(this)),
            'settings': typeof(settings['regions'][id]['settings']) != 'undefined' ? settings['regions'][id]['settings'] : {}
          };
        }
      });

      // Send settings to server for saving
      $('#layout-settings').addClass('fa-spin');
      $.post(Drupal.settings.basePath + '?q=nikadevs_cms/layout_builder/update', {'layout' : layout, 'id' : active_layout, 'op' : op}, function() {
        $('#layout-settings').removeClass('fa-spin').after('<span class = "saving-info btn btn-xs btn-success">Saved.</span>');
        setTimeout(function() {
          $('.saving-info').animate({opacity: 0}, 500, function() {
            $(this).remove();
          });
        }, 1000);
      });
    }

    function attributes($this) {
      // Collect all attributes and remove not required
      var attrs = {};
      $.each($this[0].attributes, function() {
        if(!this.specified || this.name == 'style') {
          return;
        }
        attr = this.value;
        if(this.name == 'class') {
          if($.trim(attr)) {
            classes = $.trim(attr).split(' ');
            add_class = {};
            for(i in classes) {
              if(classes[i] != 'col' && classes[i] != 'sortable' && classes[i] != 'ui-sortable' && classes[i] != 'settings-open' && classes[i] != 'dragged') {
                add_class[i] = classes[i]
              }
            }
          }
          attrs[this.name] = add_class;
        }
        else {
          attrs[this.name] = $.trim(attr);
        }
      });
      return attrs;
    }

    function attach_handlers() {

      $('.layout').sortable({
        itemSelector: '.sortable',
        delay: 150,
        placeholder: '<div class = "layout-builder-row-placeholder"></div>',
        isValidTarget: function  (item, container) {
          if(item.is(".row") && container.el.is('.layout') || item.is(".col") && container.el.is('.sortable-parent')) {
            return true;
          }
          else {
            return false;
          }
        },
        onDrop: function ($item, container, _super, event) {
          update_layout();
          $item.removeClass("dragged").removeAttr("style");
          $("body").removeClass("dragging");
        }
      });

      // Row settings form
      $('.settings-row').click(row_settings_form);

      // Switch between layouts
      $('.layouts-links a').click(layout_switch);

      // Col Settings Form
      $('.settings-col').click(col_settings_form);
    }

    function layout_switch() {
      $('.layouts-links a, .layout').removeClass('active');
      $(this).addClass('active');
      $($(this).attr('href')).addClass('active');
      // Update global active layout
      active_layout = $(this).attr('href').substr(1);
      return false;
    }

    $("#col-settings").dialog({
      autoOpen: false,
      width: 700,
      modal: true,
      buttons: {
        "Save": function() {
          col_settings_save();
          $('.col').removeClass('settings-open');
          update_layout();
          $(this).dialog( "close" );
          return false;
        },
        Cancel: function() {
          $('.col').removeClass('settings-open');
          $(this).dialog( "close" );
        }
      },
    });

    function col_settings_form($col) {
      $col = $(this).parents('.col');
      // Set default option to AUTO
      $('.col-settings select').val(0);
      $('.vissible-settings input').attr('checked', false);
      var classes = $col.attr('class').split(' ');
      var col_class = '';
      var old_classes = {};
      // Setup form values and save current classes
      for(i in classes) {
        col_class = classes[i].split('-');
        if(col_class[0] == 'col' && typeof(col_class[3]) != 'undefined') {
          $('select[name="col-' + col_class[1] + '-' + col_class[2] + '"]').val(col_class[3]);
          old_classes[classes[i]] = classes[i];
        }
        else if(col_class[0] == 'col' && typeof(col_class[1]) != 'undefined') {
          $('select[name="col-' + col_class[1] + '"]').val(col_class[2]);
          old_classes[classes[i]] = classes[i];
        }
        if((col_class[0] == 'visible' || col_class[0] == 'hidden') && typeof(col_class[1]) != 'undefined') {
          $('input[name="showing-' + col_class[1] + '"]').filter('[value="' + classes[i] + '"]').attr('checked', true);
          old_classes[classes[i]] = classes[i];   
        }
      }

      // Load settings to the Form
      _settings_to_form('#col-settings', Drupal.settings.nikadevs_cms.layouts[active_layout]['regions'][$col.attr('id')]['settings']);

      $('.col').removeClass('settings-open');
      $col.addClass('settings-open').data('old_classes', old_classes);

      // Open first tab settings
      $('.settings-tabs a:first').click();

      // Open dialog form
      $("#col-settings").dialog('open');
    }

    $('.settings-tabs a').click(function() {
      $('.settings-tabs a.active').removeClass('active');
      $(this).addClass('active');
      $('.settings-tab-form.active').hide();
      $(this).parent().parent().find($(this).attr('href')).show(200).addClass('active');
      if($(this).hasClass('show-devices')) {
        $('.device-icons-wrap').show(200);
      }
      else {
        $('.device-icons-wrap').hide();
      }
      return false;
    });

    function _settings_to_form(target_form, settings) {
      $(target_form + ' .input-setting').val('').attr('checked', false);
      for(setting in settings) {
        // Exception for the checkboxes
        if($(target_form + ' [name="' + setting + '"]').attr('type') == 'checkbox') {
          $(target_form + ' [name="' + setting + '"]').attr('checked', parseInt(settings[setting]));
        }
        else {
          $(target_form + ' [name="' + setting + '"]').val(settings[setting]);
        }
      }
    }

    function _form_to_settings(target_form, settings) {
      if(typeof(settings) != 'object') {
        settings = {'settings' : {}};
      } else if(typeof(settings['settings']) != 'object') {
        settings['settings'] = {};
      }   
      $(target_form + ' .input-setting').each(function() {
        var value = $(this).attr('type') == 'checkbox' ? ($(this).is(':checked') ? 1 : 0) : $(this).val();
        if(value) {
          settings['settings'][$(this).attr('name')] = value;
        } else if(typeof(settings['settings'][$(this).attr('name')]) != 'undefined') {
          delete settings['settings'][$(this).attr('name')];
        }
      });
      return settings;
    }

    function col_settings_save() {
      // Remove old classes
      var old_classes = $('.settings-open').data('old_classes');
      for(old_class in old_classes) {
        $('.settings-open').removeClass(old_class);
      }
      // Setting up new row classes
      $('.col-settings select').each(function() {
        if ($(this).val() > 0) {
          $('.settings-open').addClass($(this).attr('name') + '-' + $(this).val());
        }
        else {
          var prefix = $(this).attr('name');
          var classes =  $('.settings-open').attr("class").split(" ").filter(function(c) {
            return c.lastIndexOf(prefix, 0) !== 0;
          });
          $('.settings-open').attr("class", classes.join(" "));
        }
      });
      var id = $('.settings-open').attr('id');
      // Save settings from Form to variables
      Drupal.settings.nikadevs_cms.layouts[active_layout]['regions'][id] = _form_to_settings('#col-settings', Drupal.settings.nikadevs_cms.layouts[active_layout]['regions'][id]);
      // Setup new visibility classes
      $('.vissible-settings input:checked').each(function() {
        $('.settings-open').addClass($(this).val());
      });

    }

    function layout_settings() {
      // Load current layout settings
      $('#layout-settings-form .name').val($('.layouts-links a.active').text());
      if(typeof(Drupal.settings.nikadevs_cms.layouts[active_layout]) != 'undefined') {
        var pages = Drupal.settings.nikadevs_cms.layouts[active_layout]['pages'];
        $('#layout-settings-form .layout-visible').val(pages);
        _settings_to_form('#layout-settings-form', Drupal.settings.nikadevs_cms.layouts[active_layout]['settings']);
      }
      $("#layout-settings-form").dialog( "open" );
      return false;
    }

    attach_handlers();

    // Add new Layout
    $('#nd_layout').click(function() {
      $("#layout-add").dialog( "open" );
      return false;
    });

    $("#layout-add").dialog({
      autoOpen: false,
      width: 700,
      modal: true,
      buttons: {
        "Add": function() {
          if($('#layout-add .name').val() != '') {
            var prev_active = active_layout;
            active_layout = 'layout-' + $('#layout-add .name').val().replace(/[^\w\s]/gi, '').toLowerCase().replace(/ /g, '-');
            Drupal.settings.nikadevs_cms.layouts[active_layout] = jQuery.extend(true, {}, Drupal.settings.nikadevs_cms.layouts[prev_active]);
            Drupal.settings.nikadevs_cms.layouts[active_layout]['pages'] = $('#layout-add .layout-visible').val();
            Drupal.settings.nikadevs_cms.layouts[active_layout] = _form_to_settings('#layout-add', Drupal.settings.nikadevs_cms.layouts[active_layout]);

            $('.layouts-links a, .layout').removeClass('active');
            $('.layouts-links').append('<a href = "#' + active_layout + '" class = "btn btn-default btn-sm active">' + $('#layout-add .name').val() + '</a>');
            var clone_layout = '<div id = "' + active_layout + '" class = "layout active">' + $('#' + prev_active).html() + '</div>';
            $('#layout-default').removeClass('active');
            $('.layouts').append(clone_layout);
            attach_handlers();
            update_layout();
            $(this).dialog( "close" );
          }
        },
        Cancel: function() {
          $(this).dialog( "close" );
        }
      },
    });

    // Layout Settings
    $('#layout-settings').click(layout_settings);

    $("#layout-settings-form").dialog({
      autoOpen: false,
      width: 700,
      modal: true,
      buttons: {
        "Save": function() {
          if($('#layout-settings-form .name').val() != '') {
            $('.layouts-links a.active').text($('#layout-settings-form .name').val());
            Drupal.settings.nikadevs_cms.layouts[active_layout]['pages'] = $('#layout-settings-form .layout-visible').val();
            Drupal.settings.nikadevs_cms.layouts[active_layout] = _form_to_settings('#layout-settings-form', Drupal.settings.nikadevs_cms.layouts[active_layout]);
            update_layout();
            $(this).dialog( "close" );
            return false;
          }
        },
        "Delete": function() {
          if (active_layout != 'layout-default') {
            update_layout('delete');
            $('.layouts-links a.active, #' + active_layout).remove();
            $('.layouts-links a:last').click();
          }
          $(this).dialog( "close" );
        },
        Cancel: function() {
          $(this).dialog( "close" );
        }
      },
    });

    // Add new Row
    $('#nd_row').click(function() {
      $("#row-add .input-setting, #row-add input").val('').attr('checked', false);
      $('.dropdown-menu-links-wrap').hide();
      render_row_onepage_settings('');
      $('#row-add select[name="bg_image_type"]').change();
      $('.bg-image-preview').html('');
      $('.remove_bg_image').hide();
      $("#row-add").dialog( "open" );
      // Open first tab settings
      $('#row-add .settings-tabs a:first').click();
      return false;
    });

    $("#row-add").dialog({
      autoOpen: false,
      width: 700,
      modal: true,
      buttons: {
        "Add": function() {
          add_row($(this));
        },
        Cancel: function() {
          $(this).dialog( "close" );
        }
      },
    });

    function add_row($this) {
      var new_id = 0, id;
      $('.layout.active .row').each(function() {
        id = parseInt($(this).attr('id').replace('id-', ''));
        new_id = id > new_id ? id : new_id;
      });
      new_id = 'id-' + (parseInt(new_id) + 1);
      $('.layout.active').append('<li id = "' + new_id + '" class = "row sortable"><h2><i class="fa fa-arrows"></i><span>' + $this.find('.name').val() + '</span><i class="fa fa-cog settings-row"></i></h2><ol class = "sortable-parent"></ol></li>');
      Drupal.settings.nikadevs_cms.layouts[active_layout]['rows'][new_id] = _form_to_settings('#row-add', Drupal.settings.nikadevs_cms.layouts[active_layout]['rows'][new_id]);
      attach_handlers();
      update_layout();
      $this.dialog( "close" );
    }

    // Add new Block
    $('#add-block').click(function() {
      $("#add-block-form .input-setting").val('').attr('checked', false);
      $("#add-block-form").dialog( "open" );
      return false;
    });

    $("#add-block-form").dialog({
      autoOpen: false,
      width: 700,
      modal: true,
      buttons: {
        "Add": function() {
          add_block($(this));
        },
        Cancel: function() {
          $(this).dialog( "close" );
        }
      },
    });

    function get_unique_id(id, context) {
      var i = 0;
      id = id.replace('|', '-');
      var saved_id = id;
      while($('#' + id, context).length > 0) {
        id = saved_id + '-' + (i++);
      }
      return id;
    }

    function add_block($this) {
      var id = get_unique_id($this.find('.name').val(), $('.layout.active'));
      $('.layout.active #id-0 .sortable-parent').append('<li class = "col col-md-12 sortable" id = "' + id + '"><h3><i class="fa fa-arrows"></i><span>' + $this.find('.name').find(':selected').text() + '</span><i class="fa fa-cog settings-col"></i></h3></li>');
      Drupal.settings.nikadevs_cms.layouts[active_layout]['regions'][id] = _form_to_settings('#add-block-form', Drupal.settings.nikadevs_cms.layouts[active_layout]['regions'][id]);
      attach_handlers();
      update_layout();
      $this.dialog( "close" );
    }

    function _get_rows_id() {
      var ids = '';
      $('#' + active_layout + ' .row h2 span').each(function() {
        ids += $(this).text() != 'Hidden' ? '#' + $(this).text().replace(/[^a-zA-Z0-9]/g, '-') + ' ' : '';
      });
      return ids;
    }

    $('input[name="dropdown_links"]').click(function() {
      if($(this).attr('checked')) {
        $('.available_id span').text(_get_rows_id());
        $('.available_id').show();
        $('.dropdown-menu-links-wrap').show();
      }else {
        $('.dropdown-menu-links-wrap').hide()
        $('.available_id').hide();
      }
    });

    $('#add_dropdown_menu').click(_add_dropdown_menu);

    $('.upload_bg_image').click(upload_bg_image);

    $('.remove_bg_image').click(function() { remove_bg_image($(this)); });

    $('select[name="bg_image_type"]').change(function() {
      $('.bg-tabs .settings-tab-form').hide();
      $('.bg-tabs .' + $(this).val() + '-tab').show();
    });

    function remove_bg_image($this) {
      var fid = $this.parent().find('input[name="bg_image_fid"]').val();
      $.post(Drupal.settings.basePath + '?q=nikadevs_cms/file_delete/' + fid, function() {
        $('.bg-image-preview').html('');
        $('input[name="bg_image_fid"], input[name="bg_image_preview"]').val(0);
        $('.remove_bg_image').hide();
      });
    }

    function upload_bg_image() {
      globalOptions = {};
      Drupal.media.popups.mediaBrowser(function (mediaFiles) {
        if (mediaFiles.length < 0) {
          return;
        }
        var mediaFile = mediaFiles[0];
        // Set the value of the filefield fid (hidden).
        $('input[name="bg_image_fid"]').val(mediaFile.fid);
        $('input[name="bg_image_preview"]').val($(mediaFile.preview).find('.media-thumbnail').html());
        // Set the preview field HTML.
        $('.bg-image-preview').html(mediaFile.preview);
        $('.remove_bg_image').show();
      }, globalOptions);
      return false;
    }

    function row_settings_form() {
      // Show which row is setting up now
      $(this).parents('.row').addClass('row-setting-open');
      // Clear form input
      $('#row-settings select, #row-settings input').val('').attr('checked', false);
      // Set row option on the form
      $('#row-settings .name').val($(this).parent().find('span').text());
      // Load settings to the Form
      var active_row = $(this).parents('.row').attr('id');
      $('.dropdown_menu:gt(1)').remove();
      render_row_onepage_settings(active_row);
      var settings = Drupal.settings.nikadevs_cms.layouts[active_layout]['rows'][active_row]['settings'];
      _settings_to_form('#row-settings', settings);
      $('#row-settings select[name="bg_image_type"]').change();
      // Set the background image
      if($('#row-settings input[name="bg_image_preview"]').val()) {
        $('.bg-image-preview').html('<div class = "media-item">' + $('#row-settings input[name="bg_image_preview"]').val() + '</div>');
        $('.remove_bg_image').show();
      }
      else {
        $('.bg-image-preview').html('');
      }
      // Open first tab settings
      $('#row-settings .settings-tabs a:first').click();
      $("#row-settings").dialog( "open" );
      return false;
    }

    function render_row_onepage_settings(active_row) {
      // If One page view enabled, show specified fields
      if(typeof(Drupal.settings.nikadevs_cms.layouts[active_layout]['settings']) != 'undefined' && typeof(Drupal.settings.nikadevs_cms.layouts[active_layout]['settings']['one_page']) != 'undefined' && Drupal.settings.nikadevs_cms.layouts[active_layout]['settings']['one_page']) {
        // Show Sections anchors
        $('.available_id span').text(_get_rows_id());
        $('.available_id').show();
        $('#row-settings .one-page-option').show();
        if(typeof(Drupal.settings.nikadevs_cms.layouts[active_layout]['rows'][active_row]) != 'undefined' && typeof(Drupal.settings.nikadevs_cms.layouts[active_layout]['rows'][active_row]['settings']['dropdown_links']) != 'undefined' && Drupal.settings.nikadevs_cms.layouts[active_layout]['rows'][active_row]['settings']['dropdown_links']) {
          $('#row-settings .dropdown-menu-links-wrap').show();
          for(name in Drupal.settings.nikadevs_cms.layouts[active_layout]['rows'][active_row]['settings']) {
            if(name.indexOf('menu_link_url_') > -1 && name != 'menu_link_url_1') {
              _add_dropdown_menu();
            }
          }
        }
        else {
          $('.available_id, .dropdown-menu-links-wrap').hide(); 
        }
      }
      else {
        $('.one-page-option, .available_id, .dropdown-menu-links-wrap').hide();
      }      
    }

    function _add_dropdown_menu() {
      var $menu = $('.dropdown_menu:last').clone();
      var id = parseInt($menu.find('.menu_link').attr('name').replace('menu_link_', '')) + 1;
      $menu.find('.menu_link').attr('name', 'menu_link_' + id);
      $menu.find('.menu_link_url').attr('name', 'menu_link_url_' + id);
      $('.dropdown_menu:last').after($menu.outerHTML());
      return false;
    }

    $("#row-settings").dialog({
      autoOpen: false,
      width: 700,
      modal: true,
      buttons: {
        "Save": function() {
          var id = $('.row-setting-open').attr('id');
          // If Dropdown Menu Links disabled - remove links
          if(!$('input[name="dropdown_links"]').is(':checked')) {
            $('input[name^="menu_link"]').val('');
          }
          Drupal.settings.nikadevs_cms.layouts[active_layout]['rows'][id] = _form_to_settings('#row-settings', Drupal.settings.nikadevs_cms.layouts[active_layout]['rows'][id]);
          $('.row-setting-open h2 span').text($('#row-settings .name').val());
          // Settings are done
          $('.row-setting-open').removeClass('row-setting-open');
          update_layout();
          $(this).dialog( "close" );
          return false;
        },
        "Delete": function() {
          $('.row-setting-open h2').remove();
          var regions = $('#' + active_layout + ' .row-setting-open').html();
          $('#' + active_layout + ' #id-0').append(regions);
          $('.row-setting-open').remove();
          update_layout();
          attach_handlers();
          $(this).dialog( "close" );
          return false;
        },
        Cancel: function() {
          $('.row-setting-open').removeClass('row-setting-open');
          $(this).dialog( "close" );
          return false;
        }
      },
    });

    $('.expandable h4').click(function() {
      $(this).parent().toggleClass('expanded');
    });

  }); // end doc ready 

}); // end no conflict
