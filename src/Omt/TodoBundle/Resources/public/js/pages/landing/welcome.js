require(
    ["bundles/omttodo/js/jquery/jquery.validate.min.js"],
    function () {
        var messageBlock = $("#message");

        $.validator.addMethod(
            "regex",
            function(value, element, regexp) {
                var re = new RegExp(regexp);
                return this.optional(element) || re.test(value);
            },
            "check your input."
        );

        // Login form validation and submit
        (function ($) {
            var form = $("#loginForm"),
                messages = {
                    "undefined": "Unknown error occurred.",
                    "invalid_auth_data": "Login failed. Check your email and password."
                },
                focusEmailInput = function () {
                    form.children("[name='email']").select();
                },
                validator = form.validate({
                    submitHandler: function(form) {
                        var me = $(form);
                        messageBlock.hide();
                        $.isLoading({text: "Signing in...", position: "inside"});
                        $.ajax({
                            url: me.attr("action"),
                            method: me.attr("method"),
                            data: me.serialize(),
                            dataType: "json",
                            success: function (data) {
                                var messageBlockText = messageBlock.children(".message-text"),
                                    errorMessage;
                                if (!data.success) {
                                    if (messages[data.message]) {
                                        errorMessage = data.message;
                                        if (messages[errorMessage]) {
                                            errorMessage = messages[errorMessage];
                                        }
                                    } else {
                                        errorMessage = messages["undefined"];
                                    }
                                    messageBlockText.text(errorMessage);
                                    messageBlock.addClass("block-error").show();
                                    focusEmailInput();
                                } else {
                                    document.location.replace($("html").data("userHomeUrl"));
                                }
                            }
                        });
                    },
                    rules: {
                        "email": {
                            required: true,
                            email: true,
                            maxlength: 100
                        },
                        "password": "required"
                    },
                    messages: {
                        "email": {
                            required: "Enter email.",
                            email: "Enter valid email.",
                            maxlength: "Maximum of 100 symbols."
                        },
                        "password": "Enter password."
                    }
                });

            focusEmailInput();
        })(jQuery);

        // Register form validation and submit
        (function ($) {
            var form = $("#registerForm"),
                messages = {
                    "undefined": "Unknown error occurred.",
                    "email_already_taken": "Sorry, this email is already registered."
                },
                focusEmailInput = function () {
                    form.children("[name='register[email]']").select();
                },
                password = form.children("[name='register[password]']"),
                validator = form.validate({
                    submitHandler: function(form) {
                        var me = $(form);
                        messageBlock.hide();
                        $.isLoading({text: "Signing up...", position: "inside"});
                        $.ajax({
                            url: me.attr("action"),
                            method: me.attr("method"),
                            data: me.serialize(),
                            dataType: "json",
                            success: function (data) {
                                var messageBlockText = messageBlock.children(".message-text"),
                                    errorMessage;
                                if (!data.success) {
                                    if (messages[data.message]) {
                                        errorMessage = data.message;
                                        if (messages[errorMessage]) {
                                            errorMessage = messages[errorMessage];
                                        }
                                    } else {
                                        errorMessage = messages["undefined"];
                                    }
                                    messageBlockText.text(errorMessage);
                                    messageBlock.addClass("block-error").show();
                                    focusEmailInput();
                                } else {
                                    document.location.replace($("html").data('userHomeUrl'));
                                }
                            }
                        });
                    },
                    rules: {
                        "register[email]": {
                            required: true,
                            email: true,
                            maxlength: 100
                        },
                        "register[password]": {
                            required: true,
                            minlength: 4,
                            maxlength: 100
                        },
                        "register[confirmPassword]": {
                            required: true,
                            equalTo: password
                        }
                    },
                    messages: {
                        "register[email]": {
                            required: "Enter email.",
                            email: "Enter valid email.",
                            maxlength: "Maximum of 100 symbols."
                        },
                        "register[password]": {
                            required: "Enter password.",
                            minlength: "At least 4 symbols.",
                            maxlength: "Maximum of 100 symbols."
                        },
                        "register[confirmPassword]": {
                            required: "Confirm password",
                            equalTo: "Passwords do not match."
                        }
                    }
                });
        })(jQuery);
    }
);