$(document).ready(function() {
    $('#ship-method-select').change(function() {
        var option = $(this).val(); 
        var shipcost = $('#ship-cost').val();
        var final = [option, shipcost];
        console.log(final);
        console.log(`?url=shipping/shipCost/${final}`)
        $.ajax({
            url: `?url=shipping/shipCost/${final}`,
            type: 'GET',
            success: function (response) {
                var response = response;
                console.log(response);
                response = response.slice(430);
                console.log(response);
                response = JSON.parse(response);
                
                if (response.status == 200) {
                    response.cost = Number(response.cost).toFixed(2);
                    var html = '';
                    html += `$${response.cost}`;
                    var html2 = '';
                    
                    var total = $('#total').val();
                    var ogtotal = $('#ogtotal').val();
                    total = (ogtotal-shipcost)+Number(response.cost);
                    total = Number(total).toFixed(2);
                    html2 += `$${total}`;
                    var ogtime = $('#time').val();
                    var time = $('#time')
                    if (response.option == 0) {
                        time.val(ogtime*1.5);
                    } else if (response.option == 1) {
                        time.val(ogtime);
                    } else if (response.option == 2) {
                        time.val(ogtime*0.5);
                    }
                    
                    $('#shipcostdisplay').html(html);
                    $('#finalshipcost').val(response.cost);
                    $('#total').val(total);
                    $('#total-cart').html(html2);
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