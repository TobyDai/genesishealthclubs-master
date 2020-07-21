jQuery(document).ready(function () {


    jQuery('.sortable-list').sortable({
        items: 'li'
    });

    jQuery('[type="date"]').datepicker();


    jQuery('[data-check-all]').on('click', function () {
        jQuery( '[name="' + jQuery(this).attr('data-check-all') + '"]' ).attr('checked', true);
    });

    jQuery('[data-uncheck-all]').on('click', function () {
        jQuery( '[name="' + jQuery(this).attr('data-uncheck-all') + '"]' ).attr('checked', false);
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
