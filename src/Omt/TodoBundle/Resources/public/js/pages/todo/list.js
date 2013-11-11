require(
    ["bundles/omttodo/js/jquery/jquery.validate.min.js"],
    function () {
        var messageBlock = $("#message"),
            baseUrl = $("html").data("baseUrl"),
            reloadList = function () {
                var todoContainer = $("#todoContainer");
                todoContainer.empty();
                $.isLoading({text: "Loading list of todos...", position: "inside"});
                $.getJSON(baseUrl + "/todo/list", function (data) {
                    var todoTemplate = $("#todoTemplate").html();
                    $.each(data.data.todos, function (index, todo) {
                        var cssClass, text, prefix,
                            todoPanel = $(todoTemplate);
                        switch (todo.priority) {
                            case "high":
                                cssClass = "todo-high-priority";
                                break;
                            case "medium":
                                cssClass = "todo-medium-priority";
                                break;
                            case "low":
                                cssClass = "todo-low-priority";
                                break;
                        }
                        todoPanel.addClass(cssClass);
                        todoPanel.attr('data-id', todo.id);
                        todoPanel.attr('data-priority', todo.priority);
                        todoPanel.attr('data-task', todo.task);
                        text = todo.task;
                        if (todo.isDone) {
                            todoPanel.addClass('todo-done');
                            text = "(done) " + todo.task;
                        }
                        todoPanel.children(".todo-text").text(text);
                        todoContainer.append(todoPanel);
                    });
                });
            };

        $(document).on("click", ".-todo-edit-button", function () {
            var todoContainer = $("#todoContainer"),
                todoPanel = $(this).closest(".-todo-panel"),
                todoEditTemplate = $("#todoEditTemplate").html(),
                todoEditPanel = $(todoEditTemplate),
                form = todoEditPanel.children("form"),
                focusTaskInput = function () {
                    todoEditPanel.find("input[name='task']").select();
                },
                validator = form.validate({
                    submitHandler: function(form) {
                        var me = $(form),
                            baseUrl = $("html").data("baseUrl");
                        messageBlock.hide();
                        $.isLoading({text: "Saving...", position: "inside"});
                        $.ajax({
                            url: baseUrl + "/todo/modify/" + todoPanel.data("id"),
                            method: me.attr("method"),
                            data: me.serialize(),
                            dataType: "json",
                            success: function (data) {
                                var messageBlockText = messageBlock.children(".-message-text"),
                                    errorMessage;
                                if (!data.success) {
                                    errorMessage = 'Unknown error occurred.';
                                    messageBlockText.text(errorMessage);
                                    messageBlock.addClass("block-error").show();
                                    focusTaskInput();
                                } else {
                                    reloadList();
                                }
                            }
                        });
                    },
                    rules: {
                        "task": {
                            required: true,
                            maxlength: 200
                        }
                    },
                    errorPlacement: function() {
                        return true;
                    }
                });

            todoContainer.children('.-todo-edit-panel').remove();

            todoEditPanel.find("input[name='task']").val(todoPanel.data('task'));
            todoEditPanel.find("select[name='priority']").val(todoPanel.data('priority'));

            todoPanel.after(todoEditPanel);

            focusTaskInput();

            return false;
        });

        $(document).on("click", ".-todo-mark-done-button", function () {
            var todoPanel = $(this).closest(".-todo-panel");
            $.ajax({
                url: baseUrl + "/todo/done/" + todoPanel.data("id"),
                dataType: "json",
                success: function (data) {
                    var messageBlockText = messageBlock.children(".-message-text"),
                        messages = {
                            'not_found': 'Todo not found'
                        },
                        errorMessage;
                    if (!data.success) {
                        if (messages[data.message]) {
                            errorMessage = messages[data].message;
                        } else {
                            errorMessage = 'Unknown error occurred.';
                        }
                        messageBlockText.text(errorMessage);
                        messageBlock.addClass("block-error").show();
                    } else {
                        reloadList();
                    }
                }
            });
            return false;
        });

        $(document).on("click", ".-todo-remove-button", function () {
            var todoPanel = $(this).closest(".-todo-panel");
            $.ajax({
                url: baseUrl + "/todo/remove/" + todoPanel.data("id"),
                dataType: "json",
                success: function (data) {
                    var messageBlockText = messageBlock.children(".-message-text"),
                        messages = {
                            'not_found': 'Todo not found'
                        },
                        errorMessage;
                    if (!data.success) {
                        if (messages[data.message]) {
                            errorMessage = messages[data].message;
                        } else {
                            errorMessage = 'Unknown error occurred.';
                        }
                        messageBlockText.text(errorMessage);
                        messageBlock.addClass("block-error").show();
                    } else {
                        todoPanel.remove();
                    }
                }
            });
            return false;
        });

        (function ($) {
            var form = $("#createTodoForm"),
                focusTaskInput = function () {
                    form.find("input[name='task']").select();
                },
                validator = form.validate({
                    submitHandler: function(form) {
                        var me = $(form);
                        messageBlock.hide();
                        $.isLoading({text: "Creating...", position: "inside"});
                        $.ajax({
                            url: me.attr("action"),
                            method: me.attr("method"),
                            data: me.serialize(),
                            dataType: "json",
                            success: function (data) {
                                var messageBlockText = messageBlock.children(".-message-text"),
                                    errorMessage;
                                if (!data.success) {
                                    errorMessage = 'Unknown error occurred.';
                                    messageBlockText.text(errorMessage);
                                    messageBlock.addClass("block-error").show();
                                    focusTaskInput();
                                } else {
                                    reloadList();
                                }
                            }
                        });
                    },
                    rules: {
                        "task": {
                            required: true,
                            maxlength: 200
                        }
                    },
                    errorPlacement: function() {
                        return true;
                    }
                });

            focusTaskInput();

        })(jQuery);

        reloadList();
    }
);