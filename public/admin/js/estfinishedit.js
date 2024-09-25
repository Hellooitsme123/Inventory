$(document).ready(function() {
    $('#time-input').change(function() {
        var time = $(this).val(); 
        var estfinish = $('#estfinish');
        var created_at = $('#created_at').val();
        var final = [time,created_at];
        console.log(final);
        console.log(`?url=shipping/estFinishTime/${final}`)
        $.ajax({
            url: `?url=shipping/estFinishTime/${final}`,
            type: 'GET',
            success: function (response) {
                var response = response;
                console.log(response);
                response = response.slice(430);
                console.log(response);
                response = JSON.parse(response);
                
                if (response.status == 200) {
                    var html = '';
                    html += response.result;
                    estfinish.val(html);
                    //$('#count_product').html(response.products.length);
                    /*$('.set-bg').each(function () {
                        var bg = $(this).data('setbg');
                        $(this).css('background-image','url(' + bg + ')');
                    });*/
                }
                
            }
        });
    });
});