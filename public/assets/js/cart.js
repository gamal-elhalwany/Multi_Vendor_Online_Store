(function ($) {

    $('.item-qty').on('change', function (e) {
        $.ajax({
            url: "/cart/" + $(this).data('id'),
            method: "put",
            data: {
                quantity: $(this).val(),
                product_id: $('.product_id').val(),
                _token: $('#x-csrf').val(),
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
