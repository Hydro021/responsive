<?php
session_start(); // Start the session

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve form data
    $first_name = $_POST["first_name"];
    $last_name = $_POST["last_name"];
    $gender = $_POST["gender"];

    // Store form data in session variables
    $_SESSION["first_name"] = $first_name;
    $_SESSION["last_name"] = $last_name;
    $_SESSION["gender"] = $gender;

    // Redirect to the next page
    header("Location: Signup2.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SignUp1</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <style>
        /* Custom CSS */
        input[type="text"],
        input[type="password"] {
            border: none;
            border-bottom: 2px solid black;
            border-radius: 0;
            transition: border-bottom-color 0.3s;
            background-color: transparent; /* Set background color to transparent */
            color:; /* Set input text color to black */
        }

        input:focus,
        input:active {
            border-color: black;
            outline: none;
        }

        input::placeholder {
            color: #000;
        }

        /* Madelyn font for R.V.M */
        h1 {
            font-family: 'Madelyn', cursive;
            font-style: italic;
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

        /* Add a white line under input boxes */
        input[type="text"].with-border-bottom {
            border-bottom-color: white;
        }

        /* Clicking animation for icon buttons */
        .icon-button {
            transition: transform 0.2s ease;
        }

        .icon-button.clicked {
            transform: scale(1.1);
        }
    </style>

<script>
        // JavaScript for handling gender selection with animation
        function selectGender(gender) {
            document.getElementById("gender").value = gender;
            document.getElementById(gender.toLowerCase() + "-icon").classList.add("clicked");
            setTimeout(function(){
                document.getElementById(gender.toLowerCase() + "-icon").classList.remove("clicked");
            }, 300);
        }
    </script>

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
                <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
                    <div class="mb-6 w-full">
                        <h3 class="font-semibold">First Name</h3>
                        <input type="text" name="first_name" id="first_name" class="py-1 px-3 w-full with-border-bottom bg-black" required>
                    </div>
                    <div class="mb-6 w-full">
                        <h3 class="font-semibold">Last Name</h3>
                        <input type="text" name="last_name" id="last_name" class="py-1 px-3 w-full with-border-bottom bg-black" required>
                    </div>
                    <div class="mb-6 w-full space-y-4">
                        <h3 class="font-semibold">Gender</h3>
                        <div class="flex items-center space-x-9 ">
                            <button id="male-icon" class="flex items-center justify-center bg-blue-500 text-white py-2 px-4 rounded-full icon-button" type="button" onclick="selectGender('Male')">
                                <i class="fa-solid fa-mars fa-2x mr-2"></i>
                            </button>
                            <h2>Male</h2>
                            <button id="female-icon" class="flex items-center justify-center bg-red-500 text-white py-2 px-4 rounded-full icon-button" type="button" onclick="selectGender('Female')">
                                <i class="fa-solid fa-venus fa-2x mr-2"></i>
                            </button>
                            <h2>Female</h2>
                        </div>
                        <input type="hidden" name="gender" id="gender">
                    </div>
                    <div class="mb-6 flex justify-center">
                    <button id="nextButton" class="border-2 w-32 h-10 border-blue-600 bg-white text-blue-700 rounded-full icon-button" type="submit">NEXT</button>
                    </div> 
                </form>
            </div>
        </div>
    </div>
    <script>
    const nextButton = document.getElementById('nextButton');

    // Function to add clicking animation to the "NEXT" button
    function addClickAnimationToNextButton() {
        nextButton.classList.add('clicked');
        setTimeout(() => {
            nextButton.classList.remove('clicked');
        }, 300);
    }

    // Event listener for the "NEXT" button click
    nextButton.addEventListener('click', function(event) {
        addClickAnimationToNextButton();
    });
</script>

</body>
</html>
