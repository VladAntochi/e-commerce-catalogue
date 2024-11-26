<?php
// Check if the user is logged in by checking the cookie
if (!isset($_COOKIE['auth_token']) || $_COOKIE['auth_token'] !== 'valid_user') {
    // Redirect to the login page if not authenticated
    header('Location: login.php');
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Assignment1</title>
    <link rel="stylesheet" href="style.css">
    <style>
        body {
            margin: 0;
            height: 100vh;
            display: flex;
            font-family: Arial, sans-serif;
            /* Background image */
            background-image: url('./assets/background.jpg'); /* set background to image */
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
            color: #000;
        }
        /* semi transparent container */
        .container {
            background-color: rgba(255, 255, 255, 0.8);
            border-radius: 10px;
            padding: 20px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
            text-align: center;
            width: 60%;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
        }
        /* pop-up modal close button; initially hidden */
        #close-popup {
            display: none;
            position: fixed;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            background-color: white;
            border: 2px solid #333;
            padding: 20px;
            box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.2);
            z-index: 1000;
        }
        /* pop-up modal; initially hidden */
        #overlay {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.5);
            z-index: 999;
        }

        #api-image {
            cursor: pointer; /* Change the cursor when hovering over the image */
            max-width: 100%;
            height: auto;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Data from API</h1>
        <img id="api-image" src="" alt="API Image" style="display: none; max-width: 100%; height: auto;">
        <h2>Enter the missing digit:</h2>
        <input type="number" id="number-input" value="0" min="0" max="10" step="1">
        <div id="result-message"></div>
        <button id="fetch-button" style="display: none;">New game?</button>

        <!-- Pop-Up Modal -->
        <div id="overlay"></div>
        <div id="close-popup">
            <p>You are close to the correct answer! Try again!</p>
            <button id="close-popup-button">Close</button>
        </div>

        <script>
            let apiData
            // Define a function to fetch data from the API
            async function fetchData() {
                const apiUrl = 'https://marcconrad.com/uob/banana/api.php';
                try {
                    const response = await fetch(apiUrl, {
                        method: 'GET',
                    });

                    // Check if the response is okay
                    if (!response.ok) {
                        throw new Error('Network response was not ok');
                    }

                    apiData = await response.json();
                    displayData(apiData); // Call function to display the data
                } catch (error) {
                    console.error('Error fetching data:', error);
                    document.getElementById('data-container').textContent = 'Error loading data';
                }
            }
            function showPopup() {
                const popup = document.getElementById('close-popup');
                const overlay = document.getElementById('overlay');
                popup.style.display = 'block';
                overlay.style.display = 'block';
            }

            // Function to hide the pop-up
            function hidePopup() {
                const popup = document.getElementById('close-popup');
                const overlay = document.getElementById('overlay');
                popup.style.display = 'none';
                overlay.style.display = 'none';
            }

            // Function to display data in the HTML
            function displayData(data) {
                if (data.question) {
                    const imageElement = document.getElementById('api-image');
                    imageElement.src = data.question; // Set the image URL
                    imageElement.style.display = 'block'; // Make the image visible
                }
            }
            // Function to check if the number input matches the solution
            function checkNumber() {
                const inputNumber = parseInt(document.getElementById('number-input').value, 10);
                const resultMessage = document.getElementById('result-message');
                const fetchButton = document.getElementById('fetch-button');

                // Compare inputNumber with solution
                if (inputNumber === apiData.solution) {
                    resultMessage.textContent = `Correct! The number ${inputNumber} matches the solution.`;
                    fetchButton.style.display = 'inline-block';
                } else {
                    if (inputNumber === apiData.solution - 1 || inputNumber === apiData.solution + 1) {
                        showPopup();
                    }

                    resultMessage.textContent = `Incorrect. The number ${inputNumber} does not match the solution.`;
                    fetchButton.style.display = 'none';

                }
            }

            // Fetch data on page load
            window.onload = fetchData;

            // Fetch data when button is clicked
            document.getElementById('fetch-button').addEventListener('click', fetchData);
            // Check input number when it changes
            document.getElementById('number-input').addEventListener('input', checkNumber);
            // Add event listener to close the pop-up
            document.getElementById('close-popup-button').addEventListener('click', hidePopup);
        </script>
    </div>
</body>
</html>