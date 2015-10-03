function fixBlocks(block){
  block = typeof(block) === 'undefined' ? $('.block-preview:not(#block-template)') : block;
  //Setup titles:
  $(block).find('input[name="block-title[]"]').change(function(){
    $(this).parents('.panel').find('.panel-heading').text($(this).val());
  })
  //Setup color selection:
  $(block).find('input[name="block-color[]"]').ColorPicker({
    color: '#584231',
    onSubmit:function(hsb, hex, rgb, element){
      $(element).val('#'+hex);
      $(element).ColorPickerHide();
      $(element).parents('.panel').css({
        borderColor: '#'+hex
      }).children('.panel-heading').css({
        borderColor: '#'+hex,
        backgroundColor:  '#'+hex
      });
    }
  });
  //Setup border color:
  $(block).each(function(index, el) {
    var color = $(el).find('input[name="block-color[]"]').val();
    $(el).find('.panel').css({
      borderColor: color
    }).find('.panel-heading').css({
      borderColor: color,
      backgroundColor:  color
    })
  });

  $(block).find('textarea[name="block-content[]"]').tinymce({
    theme: 'modern',
    plugins : "textcolor colorpicker",
    toolbar: "undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link | forecolor backcolor",
    content_css: baseUrl + 'assets/js/tinymce/custom.css',
    statusbar : false
  });

  $(block).find('.remove-block').click(function(event) {
    event.preventDefault();
    $(this).parents('.block-preview').fadeOut('slow', function() {
      $(this).remove();
    });
  });
}

function fixFullText(){
  $('.fulltext').tinymce({
    theme: 'modern',
    plugins : "textcolor colorpicker",
    toolbar: "undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link | forecolor backcolor",
    content_css: baseUrl + 'assets/js/tinymce/custom.css',
    statusbar : false
  });
}

function fixTextImage(){
  options = {
    keepAspectRatio: true,
    fitContainer:true
  }
  $('#image_text.btn-image-picker').change(function(){
    readURL(this,options);
  });
  $('#text_image-template img').centerImage(options)

}

function fixImages(){
  var options = {
    keepAspectRatio: true,
    fitContainer:true
  }

  function setDeleteLinks(item){
    item = typeof(item) == 'undefined' ? $('.ajax-delete_image') : item;
    $(item).click(function(e){
      e.preventDefault();
      var link = '';
      var button;
      if($(this).tagName == 'A'){
        link  = $(this).attr('href');
        button = $(this).parent();
      }
      else{
        link = $(this).children('a').attr('href');
        button = $(this);
      }
      $(button).children('a').css('visibility','hidden');
      $(button).spin({scale : 0.5});

      $.ajax({
        url: link,
        type: 'post',
        dataType: 'json',
        success: function(response){
          if(response.status === 'success'){
             $(button).closest('.col-xs-4').fadeOut('fast', function() {
               $(this).remove();
             });
          }
          else{
            $(button).spin(false);
            $(button).children('a').css('visibility','visible').text("Error borrando imagen.");
          }
        },
        error: function(response){
          $(button).spin(false);
          $(button).children('a').css('visibility','visible').text("Error borrando imagen.");
        }

      });

    });
  }

  setDeleteLinks();

  $('#dropzone-space').dropzone({
    url:baseUrl + 'site/0/section/ajax_image_upload',
    previewTemplate: $('#dropzone-template').html(),
    previewsContainer:'#image_section-container',
    thumbnailWidth: 500,
    thumbnailHeight: null,
    acceptedFiles: 'image/*',
    addedfile: function(file) {
      file.previewElement = Dropzone.createElement(this.options.previewTemplate.trim());
      $(this.options.previewsContainer).append(file.previewElement);
    },
    thumbnail: function(file, dataUrl) {
      $(file.previewElement).find('.table-image img').attr('src', dataUrl).centerImage(options);
    },
    complete: function(file){
      $(file.previewElement).find('.progress').prop('hidden', 'true');
    },
    success:function(file,response){
      response = JSON.parse(response);

      $(file.previewElement).find('span.btn').removeAttr('hidden');
      if(response.status == 'success'){
        $(file.previewElement).find('span.btn a').attr('href',$('#delete-image-template').text() + '/' + response.id);
      }
    },
    error: function(file){
      $(file.previewElement).find('.alert').removeAttr('hidden');
    },
    dictDefaultMessage : "Utilice este espacio para subir sus imagenes"
  });

  $('.center-image-full-inside').centerImage(options);
}

function readURL(input,options){
  options = typeof(options) == 'undefined' ? {
    inside:true,
    keepAspectRatio:true,
    minFit:false
  } : options;
  if(input.files && input.files[0]){
    var reader = new FileReader();
    $(reader).load(function(e){
      $($(input).data('target')).attr('src', e.target.result).centerImage(options);
    });
    reader.readAsDataURL(input.files[0]);
  }
}

function fixHomepageTab(){
  var homescreen_options = {
    fitContainer:true,
    keepAspectRatio: true,
  };
  $('#homescreen_background_container img').centerImage(homescreen_options);
  $('#homescreen_background_button').change(function(event) {
    readURL(this,homescreen_options);
  });
  var logo_options = {
    inside: true,
    keepAspectRatio: true,
    minFit:false,
    keepParentPadding: true
  };

  $('#homescreen_logo_container img').centerImage(logo_options);

  $('#homescreen_logo_button').change(function(event) {
    readURL(this,logo_options);
  });


  $('.live-edit').click(function(){
    var target = '#' + $(this).data('target');
    if(!$(this).hasClass('is_editing')){
      var text = $(target).text();
      if($(target).hasClass('editable-text')){
        var input = '<input type="text" class="form-control" value ="' + text + '">';
        $(input).attr('id', $(target).attr('id'));
        $(target).html(input);
        $(target).parent().children('.quotation').hide();
      }
      $(this).text("Guardar cambios");
      $(this).addClass('is_editing');
    }
    else{
      var text = $(target).children('input').val();
      $(target).parent().children('.quotation').show();
      $(this).text("Modificar").removeClass('is_editing');
      $(target).html(text);
    }
  });
}

$(function(){
  Dropzone.autoDiscover = false;
  $(window).load(function(){
    fixTextImage();
  });

  $('.templateIcon').click(function(){
    var selected = $(this);
    $('.templateIcon').removeClass('active');
    $(selected).addClass('active');
    $('input[name=section_type]').val($(selected).data('section-type'));
    var selected_type = $(selected).data('section-type');
    var id = $('input[name=is_edit]').val();
    $.ajax({
      url: baseUrl + 'section/ajax_section_type/' + selected_type + '/' + id ,
      type: 'POST',
      dataType: 'html',
      success: function(response){
        $('#section_info').html(response);
        switch (selected_type) {
          case 'block':
            fixBlocks();
            break;
          case 'full_text':
            fixFullText();
            break;
          case 'text_image':
            fixFullText(); //Basically to get WYSIWYG feature.
            fixTextImage();
            break;
          case 'image':
            fixImages();
          default:

        }
      }
    });

  });

  $('input[name=section-color_picker]').ColorPicker({
    color: typeof(sectionInfo) !== 'undefined' ? sectionInfo.color : '#2C3E50',
    onSubmit:function(hsb, hex, rgb, element){
      $(element).val('#'+hex);
      $(element).ColorPickerHide();
      target = $(element).data('target');
      $(target).css({backgroundColor : $(element).val()});
      $(target).children('img').attr('src','').removeAttr('style');
      $('input[name=section-image_upload]').val('');
    }
  });

  $('.btn-image-picker').change(function(){
    readURL(this);
  });
  $('#add-block-btn').click(function(){
    var block = $('#block-template').clone().removeClass('hidden')
                                    .removeAttr('id').appendTo('#blocks-area')
                                    .hide().fadeIn();
    fixBlocks(block);
  });

  $('#submit-form').click(function(event) {
    $('#block-template').remove();
    //Validation:
    var section_type = $('input[name=section_type]').val();
    var modalTitle = '';
    modalTitle = 'Se ha encontrado un problema agregando la seccion.';
    var modalBody = '';
    var showError = false;
    switch (section_type) {
      case "block":
        if($('.block-preview:not(#block-template)').size() == 0){
          modalBody = 'Usted ha seleccionado la opcion <b>"Seccion de Bloque"</b>. No obstante, no ha creado ningun bloque.';
          modalBody+= 'Para crear una seccion de bloques se requiere <b>no menos</b> de un bloque. ';
          showError = true;
        }
        break;
      case "full_text":
        fixFullText();
        break;
      default:
    }
    if(showError){
      $('#error_modal').find('.modal-title').text(modalTitle);
      $('#error_modal').find('.modal-body p').html(modalBody);
      $('#error_modal').modal('show');
      event.preventDefault();
    }
  });

  $('#section_image-color img').centerImage();

  $('a[href="#homescreen"]').one('shown.bs.tab',function(e){
    fixHomepageTab();
  });

  fixBlocks();
  fixFullText();
  fixTextImage();
  fixImages();
  fixHomepageTab();
});
