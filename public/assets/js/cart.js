(function ($) {

    $('.item-qty').on('change', function () {
        let cartID = $(this).data('id');
        let product_id = $(this).closest('.count-input').find('.product_id').val();
        let token = $('#x-csrf').val();
        let totalCartPrice = $('.totalCartPrice');
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
                // let totalPrice = productPrice * this.value;
                // let options = { minimumFractionDigits: 2, maximumFractionDigits: 2 };
                // alert(productPrice);
                // totalCartPrice.text(totalPrice.toLocaleString(undefined, options));
            }
        });
    });


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
                    $('.discount_amount').html(response.currencyFormat);
                    $('.discount_amount').html(response.percent_amount);
                    console.log(response.percent_amount);
                } else {
                    $(".err-msg").text(response.message);
                }
            }
        });
    });

})(jQuery);
