$("#categoryListBtn").click(function () {
    $.ajax({
        url: "?url=admin/categorylist",
        method: "POST",
        data: {
            email: email,
            password: password,
        },
        dataType: "json",
        success: function (response) {
            if (response) {
                window.location.href = "?url=admin/categories/list";
                toastr.success("Logged in successfully!");
            }
        },
    });
});