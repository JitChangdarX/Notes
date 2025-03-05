function show()
{
var password = document.querySelector("#password");
var password2 = document.querySelector("#passwords");
if (password.type === "password") {
    password.type = "text";
} else {
    password.type = "password";
}

if (password2.type === "password") {
    password2.type = "text";
} else {
    password2.type = "password";
}
}

