$(document).ready(function () {
    $('.item').on('click', '.star', function (e) {
        var productID = $(this).parent().parent().parent().attr('id');
        var rating = $(this).attr('value');
        $.get("index.php?ajax=give_rating&product=" + productID + "&rating=" + rating,
            function (data, status, jqXHR) {
                $('.score#' + productID).replaceWith(data);
            }
        );
    });

    // form submit handling
    $('form').on('click', '.submit-button', function (e) {
        // store clicked object for easy access after ajax request
        var clickedObject = $(this);
        var formType = $(this).parent().find('input[type="hidden"][name="page"]').attr('value');
        var formData = $(this).parent().serialize();
        formData = formData.replace('page', 'ajax');

        switch (formType) {
            case "add_to_cart":
                e.preventDefault(); // prevent the normal form behavior going to new page
                $.get("index.php?" + formData, function (data, status, jqXHR) {
                    buttonPressFeedback(clickedObject, 'Add to Cart', 'Added &#x2713', 1000);
                });
                break;
            case "update_cart_amount":
                e.preventDefault();
                $.get("index.php?" + formData, function (data, status, jqXHR) {
                    // update total price
                    $('.cart-summary').find('p').replaceWith(data);

                    buttonPressFeedback(clickedObject, 'Update', 'Updated &#x2713', 1000);
                });
                break;
        }
    });

    // Temporarily replaces the text on a button and disables it for that duration
    function buttonPressFeedback(clickedObject, origText, feedbackText, duration) {
        clickedObject.html(feedbackText).prop("disabled", true)
            .css({
                "background-color": "gray",
                "border-color": "gray",
                "color": "black"
            });

        // after duration, reset button
        setTimeout(function () {
            clickedObject.html(origText).prop("disabled", false)
                .css({
                    "background-color": "",
                    "border-color": "",
                    "color": ""
                });
        }, duration);
    }
});