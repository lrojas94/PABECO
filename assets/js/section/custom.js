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

function readURL(input){
  if(input.files && input.files[0]){
    var reader = new FileReader();
    $(reader).load(function(e){
      $($(input).data('target')).attr('src', e.target.result).centerImage(
        {
          inside:true,
          keepAspectRatio:true,
          minFit:false
        });
    });
    reader.readAsDataURL(input.files[0]);
  }
}

$(function(){
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

  $('input[name=section-image_upload]').change(function(){
    readURL(this);
  });
  fixBlocks();
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
})
