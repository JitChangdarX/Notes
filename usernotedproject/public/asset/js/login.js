function myFunction() {
    var password = document.getElementById("password");
    var eyeIcon = document.getElementById("eyeIcon");

    if (password.type === "password") {
        password.type = "text"; 
        eyeIcon.classList.remove("ri-eye-off-line");
        eyeIcon.classList.add("ri-eye-line"); // Change icon to open eye
    } else {
        password.type = "password"; 
        eyeIcon.classList.remove("ri-eye-line");
        eyeIcon.classList.add("ri-eye-off-line"); // Change icon to closed eye
    }
}