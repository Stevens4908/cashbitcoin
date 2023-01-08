jQuery(document).ready(function ($) {
    $(".ccew-delete-transient").attr("disabled", false); 
    $(".ccew-delete-transient").on("click",function(e){
        $(this).text('Wait...');        
        var ajax_url = $(this).data('ajax-url');
        var send_data = {
            'action': 'ccew_delete_transient'        
        };
        $.ajax({
        type: 'POST',
        url: ajax_url,
        data: send_data,
        success: function (response){
            $(".ccew-delete-transient").text('Cache Deleted');
           // $(".ccew-delete-transient").attr("disabled", true); 
        },
         error:function(error){
            console.log(error);
        }
        });
        return false;
    }); 

});