(function ($) {

    $('.item-qty').on('change', function () {
        let cartID = $(this).data('id');
        let product_id = $('#product_id').val();
        let token = $('#x-csrf').val();
        let totalCartPrice = $('.totalCartPrice');
        let productPrice = $('.product_price').val();
        $.ajax({
            url: "/cart/" + cartID,
            type: 'put',
            data: {
                product_id: product_id,
                quantity: this.value,
                _token: token,
            },
            success: function () {
                let priceNumber = productPrice * $('.item-qty').val();
                let options = { minimumFractionDigits: 2, maximumFractionDigits: 2 };
                totalCartPrice.text(priceNumber.toLocaleString(undefined, options));
                console.log($('.item-qty').val());
            }
        });
    });


    $('.remove-item').on('click', function (e) {
        let id = $(this).data('id');
        $.ajax({
            url: "/cart/" + id,
            method: "delete",
            data: {
                _token: $('#d-csrf').val(),
            },
            success: response => {
                $('#' + id).remove();
            }
        });
    });

    $('#apply_coupon').on('click', function () {
        $.ajax({
            url: '{{ route("apply.discount") }}',
            method: 'POST',
            data: {
                coupon_code: $('#coupon_code').val(),
            },
            success: function () {
                console.log('Coupon Applied Successfully!');
            }
        });
    });

})(jQuery);
