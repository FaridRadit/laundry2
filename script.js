function toggleForm() {
    var loginForm = document.getElementById('loginForm');
    var registerForm = document.getElementById('registerForm');
    
    if (loginForm.style.display === "none") {
        loginForm.style.display = "block";
        registerForm.style.display = "none";
    } else {
        loginForm.style.display = "none";
        registerForm.style.display = "block";
    }
}

function togglePassword(inputId, iconId) {
    var passwordInput = document.getElementById(inputId);
    var icon = document.getElementById(iconId);
    if (passwordInput.type === "password") {
        passwordInput.type = "text";
        icon.classList.remove('bi-eye');
        icon.classList.add('bi-eye-slash');
    } else {
        passwordInput.type = "password";
        icon.classList.remove('bi-eye-slash');
        icon.classList.add('bi-eye');
    }
}