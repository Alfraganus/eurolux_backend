$(function () {
    jQuery(document).on("click", "div.switch", function () {
        var el = $(this);
        if (el.hasClass("disable")) {
            return;
        }
        var isActive = el.hasClass("on");
        el.addClass("disable").removeClass("on").removeClass("off");

        $.ajax({
            url: el.data("url"),
            type: "POST",
            dataType: "json"
        })
        .done(function (data) {
            if (data.success) {
                isActive = !isActive;
            }
            el.find('input:checkbox').attr('checked', isActive);
        })
        .fail(function(jqXHR, textStatus) {
            console.log("Request failed: " + textStatus);
        })
        .always(function () {
            el.removeClass("disable");
            if (isActive) {
                el.addClass('on');
            } else {
                el.addClass('off');
            }
        });
    });
});
