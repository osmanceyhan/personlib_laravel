$(".form-label-group input").focus(function() {
    $(this).parent().addClass("focused");
});
$(".form-label-group input").focusout(function() {
    if ($(this).val() === "") {
        $(this).parent().removeClass("focused");
    }
});

$("[data-password-toggle] i").click(function() {
    var input = $(this).parent().find("input");
    if (input.attr("type") === "password") {
        input.attr("type", "text");
        $(this).removeClass("fa-eye-slash");
        $(this).addClass("fa-eye");
    } else {
        input.attr("type", "password");

        $(this).removeClass("fa-eye");
        $(this).addClass("fa-eye-slash");
    }
});