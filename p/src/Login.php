<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Page</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <style>
        /* Custom CSS */
        input[type="text"],
        input[type="password"] {
            border-top: none;
            border-left: none;
            border-right: none;
            border-radius: 0;
            border-bottom: 2px solid black; /* Set bottom border color */
            transition: border-bottom-color 0.3s; /* Add transition effect for bottom border color */
        }

        input:focus,
        input:active {
            border-color: black; /* Set border color when input is focused or active */
            outline: none; /* Remove the outline when input is focused */
        }

        input::placeholder {
            color: #000; /* Set placeholder color to black */
        }

        /* Madelyn font for R.V.M */
        h1 {
            font-family: 'Madelyn', cursive;
            font-style:italic;
        }

        /* White shadow for Cashiering System text */
        .text-shadow-white {
            text-shadow: 0 0 5px #fff;
        }

        /* Style for invalid login message */
        .invalid-login {
            color: #ff0000;
            font-size: 0.8rem;
        }

        /* Remove cursor from email icon */
        .no-cursor {
            pointer-events: none;
        }
    
    </style>
</head>
<body>
<div class="flex h-screen">
        <div class="flex-1 bg-cover bg-center relative" style="background-image: url('background.png')">
            <img src="new logo.png" alt="Logo" class="absolute top-1/2 transform -translate-y-1/2 w-60 left-8 absolute-logo md:w-40 md:left-4 lg:w-60 lg:left-8">
            <div class="text-white text-center absolute top-1/2 transform -translate-y-1/2 mt-9">
                <div class="space-y-9">
                    <h1 class="text-8xl ml-8 md:ml-72 -mt-10"><link href="https://fonts.cdnfonts.com/css/madelyn-2" rel="stylesheet">R.V.M.</h1>
                    <h2 class="text-4xl font-bold text-black ml-8 md:ml-44 text-shadow-white">Cashiering System</h2>
                </div>
            </div>
        </div>
        <div class="flex-1 flex justify-center items-center">
            <div class="w-96 p-10 flex flex-col items-center">
                <h2 class="text-4xl font-semibold mb-6 text-center">LOGIN</h2>
                <?php
                
                // Check if form is submitted
                if ($_SERVER["REQUEST_METHOD"] == "POST") {
                    // Database connection
                    $servername = "localhost";
                    $username = "root"; // Change this to your database username
                    $password = ""; // Change this to your database password
                    $dbname = "admin"; // Change this to your database name

                    // Create connection
                    $conn = new mysqli($servername, $username, $password, $dbname);

                    // Check connection
                    if ($conn->connect_error) {
                        die("Connection failed: " . $conn->connect_error);
                    }

                    // Escape user inputs to prevent SQL injection
                    $email = $conn->real_escape_string($_POST['email']);
                    $password = $conn->real_escape_string($_POST['password']);

                    // Query to check if email and password match in the database
                    $sql = "SELECT * FROM acc WHERE email = '$email' AND password = '$password'";
                    $result = $conn->query($sql);

                   // Check if there is a match
if ($result->num_rows > 0) {
    // Start the session
    session_start();

    // Store email and firstname in session variables
    $_SESSION["email"] = $email;
    $_SESSION["firstname"] = $firstname;

    // Redirect user to Home.php
    header("Location: Home.php");
    exit();
} else {
    // Invalid email or password
    $errorMessage = "Invalid email or password";
}

                    
                    
                }
                ?>
                <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
                    <div class="mb-6 w-full">
                        <h3 class="font-semibold">Email</h3>
                        <div class="relative">
                            <input type="text" name="email" id="email" class="py-1 px-3 w-full" required>
                            <i class="fas fa-user-tie text-black text-lg no-cursor absolute right-2 top-1/2 transform -translate-y-1/2"></i>
                        </div>
                    </div>  
                    <div class="mb-6 w-full">
                        <h3 class="font-semibold">Password</h3>
                        <div class="relative">
                            <input type="password" name="password" id="password" class="py-1 px-3 w-80" required>
                            <i class="fas fa-eye text-black text-lg cursor-pointer absolute right-2 top-1/2 transform -translate-y-1/2" id="togglePassword"></i> 
                        </div>
                    </div> 
                    <?php if(isset($errorMessage)): ?>
                    <div class="mb-6 invalid-login"><?php echo $errorMessage; ?></div>
                    <?php endif; ?>
                    <div class="mb-6 flex items-center space-x-2">
                        <label for="rememberMe" class="text-sm">Remember Me</label>
                        <input type="checkbox" id="rememberMe" name="rememberMe">
                    </div>
                    <div class="mb-6 flex justify-center">
                        <button id="loginButton" class="bg-gradient-to-r from-blue-500 to-black text-white font-semibold py-2 px-8 rounded-full transition duration-300 hover:bg-blue-700">LOG IN</button>
                    </div> 
                </form>
                <div class="flex justify-center">
                    <h3 class="-ml-32 font-semibold">Create account?</h3>
                    <button onclick="window.location.href='Signup1.php'" class="ml-2 underline text-blue-700 font-semibold transition duration-300 hover:text-blue-900">SIGN UP</button>

                </div>
            </div>
        </div>
    </div>
    <script>
    const togglePassword = document.getElementById('togglePassword');
    const password = document.getElementById('password');
    const loginButton = document.getElementById('loginButton');
    const emailInput = document.getElementById('email');
    const passwordInput = document.getElementById('password');
    const rememberMeCheckbox = document.getElementById('rememberMe');
    const errorMessage = document.querySelector('.invalid-login');

    // Check if there's a stored email in local storage
    const storedEmail = localStorage.getItem('rememberedEmail');
    if (storedEmail) {
        emailInput.value = storedEmail; // Set the value of the email input
        rememberMeCheckbox.checked = true; // Check the "Remember Me" checkbox
    }

    togglePassword.addEventListener('click', function () {
        const type = password.getAttribute('type') === 'password' ? 'text' : 'password';
        password.setAttribute('type', type);
        this.classList.toggle('fa-eye-slash');
        // Clear error message when interacting with password field
        errorMessage.textContent = '';
    });

    // Add click animation to login button
    loginButton.addEventListener('click', function () {
        loginButton.classList.add('click-animation');
        setTimeout(() => {
            loginButton.classList.remove('click-animation');
        }, 300);

        // Check for invalid inputs before submitting
        if (emailInput.value.trim() === '' || passwordInput.value.trim() === '') {
            errorMessage.textContent = "Invalid email or password";
            event.preventDefault(); // Prevent form submission
        } else {
            // Save the email in local storage if "Remember Me" is checked
            if (rememberMeCheckbox.checked) {
                localStorage.setItem('rememberedEmail', emailInput.value);
            } else {
                localStorage.removeItem('rememberedEmail'); // Clear stored email if "Remember Me" is unchecked
            }
        }
    });

    // Clear error message when interacting with email or password field
    emailInput.addEventListener('input', function () {
        errorMessage.textContent = '';
    });

    passwordInput.addEventListener('input', function () {
        errorMessage.textContent = '';
    });
    
</script>
</body>
</html>
