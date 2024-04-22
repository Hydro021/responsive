<?php 
session_start();
// Retrieve email and firstname from session variables
$email = $_SESSION["email"];
$firstname = $_SESSION["first_name"];

?>

    <!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Welcome</title>
        <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
        <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
        <style>
            @import url('https://fonts.googleapis.com/css2?family=Madelyn&display=swap');

            .admin-btn {
                background-color: white;
            }
            h1 {
                font-family: 'Madelyn', cursive;
                font-style: italic;
            }
            .welcome-text {
                color: black;
                font-size: 2rem;
                text-align: center;
            }

            .center-logo {
                width: 200px; /* Set the width of the logo */
                display: flex;
                justify-content: center;
                align-items: center;
                margin-bottom: 20px; /* Add margin for spacing */
            }

            /* Modal styles */
            .modal {
                display: none;
                position: absolute;
                z-index: 999;
                top: calc(100% + 10px); /* Adjust the distance from the top of the button */
                left: 50%; /* Center horizontally */
                transform: translateX(-50%);
                background-color:#d3d3d3;
                padding: 20px;
                border: 1px solid #888;
                border-radius: 20px;
                text-align: center;
               
            }

            /* Style for the email */
            #userEmail {
                border-bottom: 2px solid none;
            }
            #logoutBtn {
                border-top: 2px solid none; 
                color:red;
            }
            .border-line {
                border-bottom: 1px solid black; /* Add a bottom border */
                margin: 20px 0; /* Adjust margin for spacing */
            }

            /* Style for the greeting and logout button */
            #greeting,
            #logoutBtn {
                margin-top: 16px;
            }

            /* Style for the admin icon */
            #adminIcon {
                font-size: 40px;
                color: #333;
                margin-bottom: 20px;
            }
            .confirmation-modal {
    position: fixed;
    background-color: #ffffff;
    border: 1px solid #ccc;
    border-radius: 8px;
    box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
    padding: 20px;
    z-index: 9999;
}

.confirmation-content {
    text-align: center;
}

.btn-container {
    display: flex;
    justify-content: center;
    margin-top: 20px;
}

.confirmation-modal button {
    padding: 10px 20px;
    margin: 0 10px;
    cursor: pointer;
    border: none;
    border-radius: 4px;
}

#confirmLogout {
    background-color: #4CAF50; /* Green */
    color: white;
}

#cancelLogout {
    background-color: #f44336; /* Red */
    color: white;
}
.border_line{
    padding:4px;
    border-bottom:5px solid blue;
    width:95%;
}
        </style>
    </head>
    <body>
        <nav class="bg-cover bg-center bg-no-repeat bg-opacity-80 border-b-4 border-gray-700 flex justify-between items-center p-4" style="background-image: url('background.png');">
            <div class="flex items-center text-white mx-4">
                <img src="new logo.png" alt="logo" class="w-16 mr-2">
                <h1 class="text-2xl text-white">R.V.M</h1>
            </div>
            <div class="flex items-center relative mx-10"> <!-- Make the container relative -->
                <h2 id="adminBtn" class="flex items-center text-black font-semibold py-2 px-7 transition duration-300 rounded-full admin-btn">
                    <i class="fas fa-user-tie mr-2"></i>
                    Administrator
                    <button id="toggleModalBtn" class="flex items-center justify-center bg-transparent border-none"><i id="caretIcon" class="fas fa-caret-down ml-2"></i></button>

                </h2>
                <!-- Administrator Modal -->
                <div id="adminModal" class="modal -ml-0">
                    <!-- User's email -->
                    <p id="userEmail" class="text-bold mb-2"><?php echo $email; ?></p>

                    <div class="border-line"></div>  
                    <!-- Greeting message -->
                    <div class="bg-white pt-3 pb-3">
                    <i id="adminIcon" class="fas fa-user-tie"></i> <!-- Admin icon -->
                    <h2 id="greeting" class="text-2xl mb-4">Hello, <?php echo $firstname; ?></h2>
                    <!-- Manage account button -->
                    <button class="bg-blue-500 text-white text-bold py-2 px-4 rounded-full hover:bg-blue-600">Manage Account</button>
        </div>
                    <div class="border-line"></div>
                    <!-- Logout button -->
                    <button id="logoutBtn" class="text-bold py-2 px-4 float-right">Log Out</button>
                </div>
            </div>
        </nav>
        <div class="flex flex-col items-center justify-center h-96 mt-10">
            <div class="center-logo">
                <img src="new logo.png" alt="New Logo" class="w-full">
            </div>
            <p class="welcome-text text-bold">Welcome to R.V.M Cashiering System</p>
            <button id="getStartedBtn" class="bg-gradient-to-r from-blue-500 to-black mt-8 px-6 py-3 text-white rounded-full hover:bg-blue-700 transition duration-300">Get Started</button>
            <div class="border_line"></div>
        </div>

        <script>
         const adminBtn = document.getElementById('adminBtn');
const adminModal = document.getElementById('adminModal');
const caretButton = document.querySelector('#adminBtn button'); // Select the button with the caret icon

// Function to toggle modal visibility and caret icon
function toggleModal() {
    if (adminModal.style.display === 'block') {
        adminModal.style.display = 'none';
        caretButton.querySelector('i').classList.remove('fa-caret-up'); // Remove caret-up class
        caretButton.querySelector('i').classList.add('fa-caret-down'); // Add caret-down class
    } else {
        adminModal.style.display = 'block';
        caretButton.querySelector('i').classList.remove('fa-caret-down'); // Remove caret-down class
        caretButton.querySelector('i').classList.add('fa-caret-up'); // Add caret-up class
    }
}

// Open or close modal when caret button is clicked
caretButton.addEventListener('click', toggleModal);


// Logout action
logoutBtn.addEventListener('click', () => {
    // Create the confirmation dialog
    const confirmationDiv = document.createElement('div');
    confirmationDiv.classList.add('confirmation-modal');
    confirmationDiv.innerHTML = `
        <div class="confirmation-content">
            <p>Are you sure you want to log out?</p>
            <div class="btn-container">
                <button id="confirmLogout">OK</button>
                <button id="cancelLogout">Cancel</button>
            </div>
        </div>
    `;

    // Append the confirmation dialog to the body
    document.body.appendChild(confirmationDiv);

    // Center the confirmation dialog
    confirmationDiv.style.top = `${(window.innerHeight - confirmationDiv.offsetHeight) / 2}px`;
    confirmationDiv.style.left = `${(window.innerWidth - confirmationDiv.offsetWidth) / 2}px`;

    // Event listener for confirm logout button
    const confirmLogoutBtn = document.getElementById('confirmLogout');
    confirmLogoutBtn.addEventListener('click', () => {
        // Redirect to Login.php after logout
        window.location.href = 'Login.php';
    });

    // Event listener for cancel logout button
    const cancelLogoutBtn = document.getElementById('cancelLogout');
    cancelLogoutBtn.addEventListener('click', () => {
        // Remove the confirmation dialog from the DOM
        confirmationDiv.remove();
    });
});
const getStartedBtn = document.getElementById('getStartedBtn');

// Add a click event listener to the button
getStartedBtn.addEventListener('click', () => {
    // Redirect to Home.php when the button is clicked
    window.location.href = 'Home.php';
});
        </script>
    </body>
    </html>