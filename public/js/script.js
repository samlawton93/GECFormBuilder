const select = function(a) {
    return document.querySelector(a)
    },
    selectAll = function(a) {
        return document.querySelectorAll(a)
    },
    submit = function(a, b) {
		const c = new XMLHttpRequest;
		let d = "string" == typeof a.data ? a.data : Object.keys(a.data).map(function(b) {
			return (encodeURIComponent(b) + "=" + encodeURIComponent(a.data[b])).replace(/%20/g, "+")
		}).join("&");
		return c.open("POST", a.url, !0), c.responseType = "json", c.onreadystatechange = function() {
			4 == c.readyState && 200 == c.status && b(c.response)
		}, c.setRequestHeader("X-Requested-With", "XMLHttpRequest"), c.setRequestHeader("Content-Type", "application/x-www-form-urlencoded; charset=UTF-8"), c.send(d), c
	}

select("#contactForm") && select("#contactForm").addEventListener("submit", function(a) {
    a.preventDefault();
    const b = select("#contact_submit");
    let c = !1;
    return (b.setAttribute("disabled", "disabled"), "" !== select("#contact_honeypot").value) ? void this.remove() : (selectAll("#contactForm .form_field_wrap input:not(#contact_honeypot), #contactForm .form_field_wrap textarea").forEach(function(a) {
        if ("" === a.value) {
            const d = a.parentNode;
            c = !0, d.classList.add("has-errors"), setTimeout(function() {
                d.classList.remove("has-errors")
            }, 3e3), b.removeAttribute("disabled")
        }
    }), c || submit({
        url: "/gec/gec-contact-submit.php",
        data: {
            "contact_name": select("#contact_name").value,
            "contact_email": select("#contact_email").value,
            "contact_phone": select("#contact_phone").value,
            "contact_enquiry": select("#contact_enquiry").value,
            "contact_message": select("#contact_message").value
        }
    }, function(a) {
        a.error ? (alert(a.error), b.removeAttribute("disabled")) : window.location = "/thank-you-contact/"
    }), !1)
});

select("#enquiryForm") && select("#enquiryForm").addEventListener("submit", function(a) {
    a.preventDefault();
    const b = select("#enquiry_submit");
    let c = !1;
    return (b.setAttribute("disabled", "disabled"), "" !== select("#enquiry_honeypot").value) ? void this.remove() : (selectAll("#enquiryForm .form_field_wrap input:not(#enquiry_honeypot), #enquiryForm .form_field_wrap textarea").forEach(function(a) {
        if ("" === a.value) {
            const d = a.parentNode;
            c = !0, d.classList.add("has-errors"), setTimeout(function() {
                d.classList.remove("has-errors")
            }, 3e3), b.removeAttribute("disabled")
        }
    }), c || submit({
        url: "/gec/gec-quote-submit.php",
        data: {
            "enquiry_name": select("#enquiry_name").value,
            "enquiry_email": select("#enquiry_email").value,
            "enquiry_telephone": select("#enquiry_telephone").value,
            "enquiry_postcode": select("#enquiry_postcode").value,
            "enquiry_service": select("#enquiry_service").value
        }
    }, function(a) {
        a.error ? (alert(a.error), b.removeAttribute("disabled")) : window.location = "/thank-you/"
    }), !1)
});
