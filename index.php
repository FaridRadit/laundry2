<?php
include("connectdb.php");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login and Registration Form</title>
    <link rel="stylesheet" href="styles.css">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
</head>
<body>

    <div class="container">
        <div class="form-container">
    
            <!-- Login Form -->
            <div id="loginForm">
                <h2>Get's Started</h2>
                <p>Don't have Account? <a href="#" onclick="toggleForm()">Sign Up</a></p>
                <form method="POST" action="login.php">
                    <div class="input-group">
                        <span class="input-group-text"><i class="fas fa-user"></i></span>
                        <input type="text" name="loginUsername" id="loginUsername" placeholder="Insert Username" required>
                    </div>
                    <div class="input-group">
                        <span class="input-group-text"><i class="fas fa-lock"></i></span>
                        <input type="password" name="loginPassword" id="loginPassword" placeholder="Insert Password" required>
                        <button type="button" onclick="togglePassword('loginPassword', 'loginToggleIcon')">
                            <i class="fas fa-eye" id="loginToggleIcon"></i>
                        </button>
                    </div>
                    <div class="posisi">
                        <button type="submit" class="btn">Login</button>
                    </div>
                </form>
            </div>
            <!-- Registration Form -->
            <div id="registerForm" style="display: none;">
                <h2>Get's Started</h2>
                <p>Already have Account? <a href="#" onclick="toggleForm()">Log In</a></p>
                <form method="POST" action="register.php">
                    <div class="input-group">
                        <span class="input-group-text"><i class="fas fa-user"></i></span>
                        <input type="text" name="registerUsername" id="registerUsername" placeholder="Insert Username" required>
                    </div>
                    <div class="input-group">
                        <span class="input-group-text"><i class="fas fa-lock"></i></span>
                        <input type="password" name="registerPassword" id="registerPassword" placeholder="Password length (10-52)" required>
                        <button type="button" onclick="togglePassword('registerPassword', 'registerToggleIcon')">
                            <i class="fas fa-eye" id="registerToggleIcon"></i>
                        </button>
                    </div>
                    <div class="posisi">
                        <button type="submit" class="btn">Sign Up</button>
                    </div>
                </form>
            </div>
        </div>

    </div>
    <div class="side-design">
        
    </div>
    

    <script>
        function toggleForm() {
            var loginForm = document.getElementById('loginForm');
            var registerForm = document.getElementById('registerForm');
            if (loginForm.style.display === 'none') {
                loginForm.style.display = 'block';
                registerForm.style.display = 'none';
            } else {
                loginForm.style.display = 'none';
                registerForm.style.display = 'block';
            }
        }

        function togglePassword(inputId, iconId) {
            var passwordInput = document.getElementById(inputId);
            var icon = document.getElementById(iconId);
            if (passwordInput.type === "password") {
                passwordInput.type = "text";
                icon.classList.remove('fa-eye');
                icon.classList.add('fa-eye-slash');
            } else {
                passwordInput.type = "password";
                icon.classList.remove('fa-eye-slash');
                icon.classList.add('fa-eye');
            }
        }
    </script>
</body>
</html>
