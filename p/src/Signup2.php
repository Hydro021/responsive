<?php
session_start(); // Start the session

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve form data
    $email = $_POST["email"];
    $password = $_POST["password"];
    $confirm_password = $_POST["confirm_password"];
    $firstname = $_POST["firstname"]; // Add this line to retrieve firstname from the form

    // Additional form data retrieval
    $_SESSION["email"] = $email; // Store email in session variable
    $_SESSION["firstname"] = $firstname; // Store firstname in session variable
    
    // Database connection parameters
    $servername = "localhost";
    $username = "root"; // Replace with your database username
    $db_password = ""; // Replace with your database password
    $dbname = "admin";

    // Create connection
    $conn = new mysqli($servername, $username, $db_password, $dbname);

    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Check if email already exists
    $sql_check_email = "SELECT * FROM acc WHERE email='$email'";
    $result_check_email = $conn->query($sql_check_email);
    if ($result_check_email->num_rows > 0) {
        $errorMessage = "Email already exists.";
    } else {
        // Check if passwords match
        if ($password === $confirm_password) {
            // Retrieve additional form data from session
            $firstname = $_SESSION["first_name"];
            $lastname = $_SESSION["last_name"];
            $gender = $_SESSION["gender"];

            // Prepare SQL statement for inserting data
            $sql = "INSERT INTO acc (email, password, firstname, lastname, gender) VALUES ('$email', '$password', '$firstname', '$lastname', '$gender')";

            // Execute SQL statement
            if ($conn->query($sql) === TRUE) {
                // Redirect user to welcome page
                header("Location: Welcome.php");
                exit();
            } else {
                // Error inserting record
                $errorMessage = "Error: " . $sql . "<br>" . $conn->error;
            }
        } else {
            // Passwords do not match
            $errorMessage = "Passwords do not match.";
        }
    }

    // Close connection
    $conn->close();
    header("Location: Welcome.php");
    exit();

}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Signup2</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <style>
         .border-red-500::placeholder {
        color: #ff0000; /* Set placeholder text color to red */
    }
    .clicked {
        animation: clickAnimation 0.3s ease;
    }

    @keyframes clickAnimation {
        0% { transform: scale(1); }
        50% { transform: scale(0.95); }
        100% { transform: scale(1); }
    }
          /* Custom CSS */
          input[type="text"],
        input[type="password"],
        input[type="email"] {
            border-top: none;
            border-left: none;
            border-right: none;
            border-radius: 0;
            border-bottom: 2px solid white; /* Set bottom border color */
            transition: border-bottom-color 0.3s; /* Add transition effect for bottom border color */
            background-color: transparent; /* Set background color to transparent */
            color: white; /* Set text color to white */
            position: relative; /* Set position to relative */
        }

        input:focus,
        input:active {
            border-color: white; /* Set border color when input is focused or active */
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

        /* Password strength indicator */
        .password-strength {
            display: flex;
            align-items: center;
            margin-top: 5px;
            font-size: 14px;
        }

        .weak {
            color: red;
        }

        .medium {
            color: orange;
        }

        .strong {
            color: green;
        }

        /* Positioning for eye icon */
        .eye-icon {
            position: absolute;
            right: 10px;
            top: 50%;
            transform: translateY(-50%);
            cursor: pointer;
        }
    </style>
</head>
<body>
    <div class="flex h-screen">
        <div class="flex-1 bg-cover bg-center relative" style="background-image: url('background.png')">
            <img src="new logo.png" alt="Logo" class="absolute top-1/2 transform -translate-y-1/2 w-60 left-8">
            <div class="text-white text-center absolute top-1/2 transform -translate-y-1/2 mt-9">
                <div class="space-y-9">
                    <h1 class="text-8xl ml-72 -mt-10"><link href="https://fonts.cdnfonts.com/css/madelyn-2" rel="stylesheet">R.V.M.</h1>
                    <h2 class="text-4xl font-bold text-black ml-44 text-shadow-white">Cashiering System</h2>
                </div>
            </div>
        </div>
        <div class="flex-1 flex justify-center items-center bg-black text-white">
            <div class="w-96 p-10 flex flex-col items-center">
                <h2 class="text-4xl font-semibold mb-6 text-center">SIGN UP</h2>
                <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
                <div class="mb-6 w-full">
    <h3 class="font-semibold">Email</h3>
    <div class="relative">
        <input type="email" name="email" id="email" class="bg-black py-1 px-3 w-full" required>
        <i class="-mt-2 text-white fas fa-user-tie text-black text-lg no-cursor absolute right-0 top-1/2 transform -translate-y-1/2"></i>
    </div>
</div>
 
                    <div class="mb-6 w-full">
                        <h3 class="font-semibold">Password</h3>
                        <div class="relative">
                            <input type="password" name="password" id="password" class="bg-black py-1 px-3 w-80" required>
                            <i class="-mt-3 text-white fas fa-eye text-black text-lg cursor-pointer eye-icon" id="togglePassword"></i> 
                            <div id="password-strength" class="password-strength"></div>
                        </div>
                    </div> 
                    <div class="mb-6 w-full">
                        <h3 class="font-semibold">Confirm Password</h3>
                        <div class="relative">
                            <input type="password" name="confirm_password" id="confirm_password" class="bg-black py-1 px-3 w-80" required>
                            <i class="-mt-3 text-white fas fa-eye text-black text-lg cursor-pointer eye-icon" id="toggleConfirmPassword"></i> 
                            <div id="confirm-password-strength" class="password-strength"></div>
                        </div>
                    </div> 
                    <div class="mb-6 flex justify-center">
                        <button id="submitButton" class="bg-white text-blue-700 border-blue-700 text-white font-semibold py-2 px-8 rounded-full transition duration-300" type="submit">SIGN UP</button>
                    </div> 
                </form>
                <div class="flex justify-center">
                    <h3 class="-ml-28 pl-9 font-semibold">Already have an account?</h3>
                    <button onclick="window.location.href='Login.php'" class="ml-2 underline text-blue-500 font-semibold ml-1 transition duration-300">LOG IN</button>
                </div>
            </div>
        </div>
    </div>

    <script>
    const emailInput = document.getElementById('email');
    const passwordInput = document.getElementById('password');
    const confirmPasswordInput = document.getElementById('confirm_password');
    const passwordStrength = document.getElementById('password-strength');
    const confirmStrength = document.getElementById('confirm-password-strength');
    const errorMessage = "<?php echo isset($errorMessage) ? $errorMessage : ''; ?>";

    // Function to calculate password strength
    function calculatePasswordStrength(password) {
        let strength = 0;

        if (password.match(/[a-z]+/)) {
            strength += 1;
        }
        if (password.match(/[A-Z]+/)) {
            strength += 1;
        }
        if (password.match(/[0-9]+/)) {
            strength += 1;
        }
        if (password.match(/[$&+,:;=?@#|'<>.^*()%!-]+/)) {
            strength += 1;
        }

        return strength;
    }

    // Function to update password strength indicator
    function updatePasswordStrengthIndicator(password, strengthElement) {
        const strength = calculatePasswordStrength(password);

        if (password.length < 8) {
            strengthElement.textContent = 'Weak';
            strengthElement.className = 'password-strength weak';
            return false; // Password is weak
        } else if (strength === 1 || strength === 2) {
            strengthElement.textContent = 'Medium';
            strengthElement.className = 'password-strength medium';
        } else if (strength >= 3) {
            strengthElement.textContent = 'Strong';
            strengthElement.className = 'password-strength strong';
        }
        return true; // Password is medium or strong
    }

    // Event listener for password input
    passwordInput.addEventListener('input', function () {
        updatePasswordStrengthIndicator(passwordInput.value, passwordStrength);
        // Check if passwords match when typing
        checkPasswordsMatch();
    });

    // Event listener for confirm password input
    confirmPasswordInput.addEventListener('input', function () {
        updatePasswordStrengthIndicator(confirmPasswordInput.value, confirmStrength);
        // Check if passwords match when typing
        checkPasswordsMatch();
    });

    // Function to check if passwords match
    function checkPasswordsMatch() {
        if (passwordInput.value !== confirmPasswordInput.value) {
            confirmPasswordInput.setCustomValidity('Passwords do not match.');
        } else {
            confirmPasswordInput.setCustomValidity('');
        }
    }

    // Event listener for toggle password visibility
    document.getElementById('togglePassword').addEventListener('click', function () {
        const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
        passwordInput.setAttribute('type', type);
        this.classList.toggle('fa-eye-slash');
    });

    // Event listener for toggle confirm password visibility
    document.getElementById('toggleConfirmPassword').addEventListener('click', function () {
        const type = confirmPasswordInput.getAttribute('type') === 'password' ? 'text' : 'password';
        confirmPasswordInput.setAttribute('type', type);
        this.classList.toggle('fa-eye-slash');
    });

    // Set placeholder-like error message inside the input fields
    if (errorMessage.includes('Email already exists')) {
        emailInput.placeholder = "Email already exists";
        emailInput.classList.add('border-red-500');
    }

    if (errorMessage.includes('Passwords do not match')) {
        confirmPasswordInput.placeholder = "Passwords do not match";
        confirmPasswordInput.classList.add('border-red-500');
    }

    // Validate email format using JavaScript
    emailInput.addEventListener('input', function() {
        emailInput.setCustomValidity(''); // Clear any previous custom validation message
    });

    // Validate password format using JavaScript
    document.getElementById('submitButton').addEventListener('click', function() {
        const passwordValid = updatePasswordStrengthIndicator(passwordInput.value, passwordStrength);
        if (!passwordValid) {
            passwordInput.setCustomValidity('Please enter a medium or strong password.');
        } else {
            passwordInput.setCustomValidity('');
        }
    });

    // Validate confirm password format using JavaScript
    document.getElementById('submitButton').addEventListener('click', function() {
        const confirmPasswordValid = updatePasswordStrengthIndicator(confirmPasswordInput.value, confirmStrength);
        if (!confirmPasswordValid) {
            confirmPasswordInput.setCustomValidity('Please enter a medium or strong password.');
        } else {
            confirmPasswordInput.setCustomValidity('');
        }
    });

    const submitButton = document.getElementById('submitButton');

// Function to add clicking animation
function addClickAnimation() {
    submitButton.classList.add('clicked');
    setTimeout(() => {
        submitButton.classList.remove('clicked');
    }, 300);
}

// Event listener for submit button click
submitButton.addEventListener('click', function(event) {
    addClickAnimation();
});
</script>

</body>
</html>