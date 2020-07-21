jQuery(document).ready(function () {


    jQuery('.sortable-list').sortable({
        items: 'li'
    });

    jQuery('[type="date"]').datepicker();


    jQuery('[data-check-all]').on('click', function () {
        jQuery( '[data-name="' + jQuery(this).attr('data-check-all') + '"]' ).attr('checked', true);
    });

    jQuery('[data-uncheck-all]').on('click', function () {
        jQuery( '[data-name="' + jQuery(this).attr('data-uncheck-all') + '"]' ).attr('checked', false);
    });





    // Set all variables to be used in scope
    var frame,
        customImageControls = jQuery('.custom-image-controls'),
        addImgLink = customImageControls.find('.upload-custom-img'),
        delImgLink = customImageControls.find( '.delete-custom-img'),
        imgContainer = customImageControls.find( '.custom-img-container'),
        imgIdInput = customImageControls.find( '.custom-img-id' );

    customImageControls.on( 'click', '.upload-custom-img', function( event ) {
        event.preventDefault();

        if ( frame ) {
            frame.open();
            return;
        }

        var controlParent = jQuery(this).closest('.custom-image-controls');

        frame = wp.media({
            title: 'Select or Upload Media Of Your Chosen Persuasion',
            button: {
                text: 'Use this media'
            },
            multiple: false
        });

        frame.on( 'select', function() {
            var attachment = frame.state().get('selection').first().toJSON();
            controlParent.find('.custom-img-container').append( '<img src="' + attachment.url + '" alt="" style="max-width:100%;"/>' );
            controlParent.find('.custom-img-id').val( attachment.id );
            controlParent.find('.upload-custom-img').addClass( 'hidden' );
            controlParent.find('.delete-custom-img').removeClass( 'hidden' );
        });

        frame.open();
    });

    customImageControls.on( 'click', '.delete-custom-img', function( event ) {
        event.preventDefault();
        var controlParent = jQuery(this).closest('.custom-image-controls');
        controlParent.find('.custom-img-container').html( '' );
        controlParent.find('.upload-custom-img').removeClass( 'hidden' );
        controlParent.find('.delete-custom-img').addClass( 'hidden' );
        controlParent.find('.custom-img-id').val( '' );
    });

});


jQuery(document).ready(function($) {
    function ct_media_upload(button_class) {
        var _custom_media = true,
            _orig_send_attachment = wp.media.editor.send.attachment;
        $('body').on('click', button_class, function(e) {
            var button_id = '#' + $(this).attr('id');
            var send_attachment_bkp = wp.media.editor.send.attachment;
            var button = $(button_id);
            _custom_media = true;
            wp.media.editor.send.attachment = function(props, attachment) {
                if (_custom_media) {
                    $('#category-image-id').val(attachment.id);
                    $('#category-image-wrapper').html('<img class="custom_media_image" src="" style="margin:0;padding:0;max-height:100px;float:none;" />');
                    $('#category-image-wrapper .custom_media_image').attr('src', attachment.url).css('display', 'block');
                } else {
                    return _orig_send_attachment.apply(button_id, [props, attachment]);
                }
            }
            wp.media.editor.open(button);
            return false;
        });
    }
    ct_media_upload('.ct_tax_media_button.button');
    $('body').on('click', '.ct_tax_media_remove', function() {
        $('#category-image-id').val('');
        $('#category-image-wrapper').html('<img class="custom_media_image" src="" style="margin:0;padding:0;max-height:100px;float:none;" />');
    });
    // Thanks: http://stackoverflow.com/questions/15281995/wordpress-create-category-ajax-response
    $(document).ajaxComplete(function(event, xhr, settings) {
        var queryStringArr = settings.data.split('&');
        if ($.inArray('action=add-tag', queryStringArr) !== -1) {
            var xml = xhr.responseXML;
            $response = $(xml).find('term_id').text();
            if ($response != "") {
                // Clear the thumb image
                $('#category-image-wrapper').html('');
            }
        }
    });
});
