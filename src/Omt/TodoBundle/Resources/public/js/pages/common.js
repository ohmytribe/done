(function ($) {
    $(document).bind("ajaxSuccess", function (event, xhr, request, data) {
        if (!data.success) {
            if (data.message == "auth_failed") {
                document.location.replace($("html").data("guestHomeUrl"));
            }
        }
    }).bind("ajaxComplete", function () {
        $.isLoading("hide");
    }).bind("ajaxError", function () {
        var message = $("#message");
        message.removeClass("block-success").addClass("block-error")
            .children(".-message-text").text('Unknown error occurred.');
        message.show();
    });
    $(document).on("click", ".-panel-hide-button", function () {
        $(this).closest(".-panel").hide();
        return false;
    });
    $(document).on("click", ".-panel-remove-button", function () {
        $(this).closest(".-panel").remove();
        return false;
    });
})(jQuery);