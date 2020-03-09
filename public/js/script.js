var $form = $('.GECenquiryForm')

$form.on("submit", function(a) {
    a.preventDefault();
    var name     = $("#enquiry_name").val(),
        email    = $("#enquiry_email").val(),
        tel      = $("#enquiry_telephone").val(),
        postcode = $("#enquiry_postcode").val(),
        service  = $("#enquiry_service").val(),
        submit   = $("#enquiry_submit");

        return name && email && tel && postcode && service ? ($(submit).val("Processing...").attr("disabled", "disabled"),
        email.match(/^[a-zA-Z0-9!#$%&'*+\-\/=?^_`{|}~.]+@[a-zA-Z0-9.-]+\.[a-zA-Z\.]{2,7}$/) ? tel.match(/^\+?[0-9 ]+$/) ? postcode.match(/^([A-Z]{1,2}[0-9]{1,2}[A-Z]?) ?([0-9][A-Z]{1,2})$/i) ? $.ajax({
            type: "post",
            url: "/gec/gec-submit.php",
            data: $(this).serialize(),
            dataType: "json"
        }).done(function(a) {
            a.success ? window.location = "/thank-you" : (alert(a.error),
            $(submit).val("Submit").removeAttr("disabled"))
        }).fail(function() {
            console.error("AJAX error."),
            $(submit).val("Submit").removeAttr("disabled")
        }) : alert("Please enter a valid UK postcode.") : alert("Please enter a valid phone number.") : alert("Please enter a valid email address.")) : $(this).find('[id*="enquiry_"]').each(function(a, b) {
            $(b).val() || ($(this).addClass("has-errors"),
            setTimeout(function() {
                $(".has-errors").removeClass("has-errors")
            }, 1e3))
        }),
        !1
});
