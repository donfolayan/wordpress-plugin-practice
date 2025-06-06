jQuery(Document).ready(function(){
    jQuery('#frm-csv').on('submit', function(event){
        event.preventDefault();

        var formData = new FormData(this);

        jQuery.ajax({
            url: cdu_ajax_obj.ajax_url,
            data: formData,
            dataType: 'json',
            method: 'POST',
            processData: false,
            contentType: false,
            success: function(response) {
                if(response.status){
                    jQuery('#show_upload_message').text(response.message).css({
                        color: 'green',
                    });
                }
            }
        });
    });
});