$(function () {
    $("#toggle_pwd").click(function () {
        $(this).toggleClass("fa-eye fa-eye-slash");
        var type = $(this).hasClass("fa-eye-slash") ? "text" : "password";
        $("#password").attr("type", type);
        $("#reset_password").attr("type", type);

        if (type === "text") {
            $(this).attr("xlink:href", eyeSvgUrl);
        } else {
            $(this).attr("xlink:href", eyeSvgSlashUrl);

        }
    });

    $("#toggle_conf_pwd").click(function () {
        $(this).toggleClass("fa-eye fa-eye-slash");
        var type = $(this).hasClass("fa-eye-slash") ? "text" : "password";
        $("#password_confirm").attr("type", type);
        $("#reset_password_confirm").attr("type", type);

        if (type === "text") {
            $(this).attr("xlink:href", eyeSvgUrl);
        } else {
            $(this).attr("xlink:href", eyeSvgSlashUrl);

        }
    });
});
$("input[id='reset_password_confirm']").on("change", function () {
    if (
      $("input[id='reset_password_confirm']").val() !=
      $("input[id='reset_password']").val()
    ) {
      $("input[id='reset_password_confirm']").addClass("error");
      $("input[id='reset_password']").addClass("error");
    } else {
      $("input[id='reset_password_confirm']").removeClass("error");
      $("input[id='reset_password']").removeClass("error");
    }
  });

  $("#resetPasswordForm").validate({
    rules: {
      password: {
        required: true,
      },
      password_confirmation: {
        required: true,
        equalToTrimmed: "#reset_password",
      },
    },
    messages: {
      password: {
        required: "Password required.",
      },
      password_confirmation: {
        required: "Password required.",
        equalTo: "Password does not match.",
      },
    },
    submitHandler: function (form) {
      // Trim the password values before submitting
      $("#reset_password").val($.trim($("#reset_password").val()));
      $("#reset_password_confirm").val($.trim($("#reset_password_confirm").val()));

      form.submit();
    },
    errorPlacement: function (error, element) {
      if (element.attr("name") == "password") {
        error.appendTo("#passwordError");
      } else if (element.attr("name") == "password_confirmation") {
        error.appendTo("#passwordConfirmationError");
      } else {
        error.insertAfter(element);
      }
    },
    highlight: function(element, errorClass, validClass) {
        // Add 'is-invalid' class to show the red border
        $(element).addClass('is-invalid');
    },
    unhighlight: function(element, errorClass, validClass) {
        // Remove 'is-invalid' class when valid
        $(element).removeClass('is-invalid');
    }
  });

  $.validator.addMethod(
    "regex",
    function (value, element, regexp) {
      var re = new RegExp(regexp);
      return this.optional(element) || re.test(value);
    },
    "A password must consists of 8 characters, one upper case, one lower case, one special case, and one numerical case."
  );

      $.validator.addMethod(
      "equalToTrimmed",
      function (value, element, params) {
          var target = $(params);
          return this.optional(element) || $.trim(value) === $.trim(target.val());
      },
      "Passwords do not match."
      );

  $("#reset_password").rules("add", {
    regex: /^(?=.*[A-Z])(?=.*[a-z])(?=.*[0-9])(?=.*[~`!@#$%^&*()--+={}\[\]|\\:;"'<>,.?/_₹]).{8,30}$/,
  });

  $("#reset_password_confirm").rules("add", {
    regex: /^(?=.*[A-Z])(?=.*[a-z])(?=.*[0-9])(?=.*[~`!@#$%^&*()--+={}\[\]|\\:;"'<>,.?/_₹]).{8,30}$/,
  });
