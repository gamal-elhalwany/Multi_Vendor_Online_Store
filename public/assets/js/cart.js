(function ($) {

        // Update Cart Qty & Price.
        $('.item-qty').on('change', function () {
        let cartID = $(this).data('id');
        let product_id = $(this).closest('.count-input').find('.product_id').val();
        let token = $('#x-csrf').val();
        let productPrice = $('.product_price').val();
        $.ajax({
            url: "/cart/" + cartID,
            type: 'put',
            data: {
                cart_id: cartID,
                product_id: product_id,
                quantity: this.value,
                _token: token,
            },
            success: function () {
                
            }
        });
    });


    // Delete Cart Item.
    $('.remove-item').on('click', function () {
        let id = $(this).data('id');
        $.ajax({
            url: "/cart/"+id,
            method: "delete",
            data: {
                _token: $('#d-csrf').val(),
            },
            success: response => {
                $('#cart_id').remove();
            }
        });
    });

    // Apply Coupon
    $('#apply_coupon').on('click', function () {
        $.ajax({
            url: "/apply-coupon",
            method: 'POST',
            data: {
                coupon_code: $('#coupon_code').val(),
                _token: $('#hidden-token').val(),
            },
            success: function (response) {
                if (response.status == true) {
                    $("#coupon_wrapper").html(response.message);
                    $('.remove_wrapper').prop('hidden', true);
                    $('.item-qty').prop('disabled', true);
                    if (response.currencyFormat) {
                        $('.discount_amount').html(response.currencyFormat);
                    } else {
                        $('.discount_amount').html(response.percent_amount + '%');
                    }

                    if (response.coupon_code.type === 'fixed') {
                        $('.you_save').html(response.fixedTotalSave);
                    } else {
                        $('.you_save').html(response.percentTotalSave);
                    }
                    
                    if (response.coupon_code.type === 'fixed') {
                        $('.you_pay').html(response.fixedTotalPay);
                    } else {
                        $('.you_pay').html(response.percentTotalPay);
                    }
                } else {
                    $(".err-msg").text(response.message);
                }
            }
        });
    });
 
})(jQuery);
