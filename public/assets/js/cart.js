(function ($) {

    $('.item-qty').on('change', function () {
        let product_id = $(this).data("id");
        let token = $('#x-csrf').val();
        let totalCartPrice = $('.totalCartPrice').val();
        let productPrice = $('.product_price').val();
        $.ajax({
            url: "/cart/" + product_id,
            type: 'put',
            data: {
                product_id: product_id,
                quantity: this.value,
                _token: token,
            },
            success: function () {
                $total = quantity * productPrice;
                $('.totalCartPrice').text(total);
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

})(jQuery);
