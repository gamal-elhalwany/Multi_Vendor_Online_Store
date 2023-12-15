(function ($) {

    $('.item-qty').on('change', function (e) {
        var $parentDiv = $(this).closest('.count-input');

        $.ajax({
            url: "/cart/" + $(this).data('id'),
            method: "put",
            data: {
                quantity: $(this).val(),
                product_id: $parentDiv.find('.product_id').val(),
                _token: $parentDiv.find('#x-csrf').val(),
            },
            success: function(response) {
                let totalCartPrice =  $('.item-qty').val() * $('.product_price').val();
                // var cartId = $('.totalCartPrice').data('id');
                // let elementWithDataId = $('p.totalCartPrice[data-id="' + cartId + '"]');

                $('.totalCartPrice').data('id').text(
                    Math.round(totalCartPrice, 2),
                );
            },
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
