$("#loginBtn").click(function () {
    var email = $("#email").val();
    var password = $("#password").val();
    console.log(email, password);
    if (email == "" || password == "") {
        console.log("holup");
        toastr.error("Email or password is empty!");
        return;
    }
    console.log("no wayeyayeyayeyayyy");
    // stops here
    $.ajax({
        
        url: "?url=admin/handleLogin",
        method: "POST",
        data: {
            email: email,
            password: password,
        },
        dataType: "json",
        success: function (response) {
            console.log(response);
            if (response) {
                console.log("fdasfhdalskjg");
                window.location.href = "?url=dashboard"; 
                toastr.success("Logged in successfully!");
            } else {
                toastr.error("Something went wrong!");
            }
        }/*, error: function (xhr) {
            window.alert("Something went wrong!" + xhr.status + " " + xhr.statusText)
        }*/
    });
});
$(document).on("keypress", function (e) {
    if (e.which == 13) {
        var email = $("#email").val();
        var password = $("#password").val();
        if (email == "" || password == "") {
            toastr.error("Email or password is empty!");
            return;
        }
        console.log("no wayeyayeyayeyayyy");
        $.ajax({
            url: "?url=admin/handleLogin",
            method: "POST",
            data: {
                email: email,
                password: password,
            },
            dataType: "json",
            success: function (response) {
                if (response) {
                    window.location.href = "?url=dashboard";
                    toastr.success("Logged in successfully!");
                }
            },
        });
    }
});
