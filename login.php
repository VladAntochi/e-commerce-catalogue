<?php
// Example of setting an authentication cookie upon successful login
if (isset($_POST['username'])) {
    if ($_POST['username'] == 'admin' && $_POST['password'] == 'password123') {
        setcookie("auth_token", "valid_user", time() + 3600, "/");  // Set cookie for 1 hour
        header('Location: index.php'); // Redirect to index.php after login
        exit();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <style>
        body {
            margin: 0;
            height: 100vh;
            display: flex;
            justify-content: center; /* Horizontally center */
            align-items: center; /* Vertically center */
            font-family: Arial, sans-serif;
            background-image: url('./assets/background.jpg'); /* Set background to image */
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
            color: #000;
        }

        /* Semi-transparent container */
        .container {
            background-color: rgba(255, 255, 255, 0.8);
            border-radius: 10px;
            padding: 20px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
            text-align: center;
            width: 30%; /* Adjust width to fit form */
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
        }

        /* Styling for form elements */
        form {
            width: 100%; /* Ensure the form takes up all of the container's width */
        }

        label {
            margin: 10px 0 5px;
            display: block;
            font-weight: bold;
        }

        input {
            width: 90%;
            padding: 10px;
            margin: 10px 0;
            border-radius: 5px;
            border: 1px solid #ccc;
        }

        button {
            width: 100%;
            padding: 10px;
            background-color: #4CAF50;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 16px;
        }

            button:hover {
                background-color: #45a049;
            }
    </style>
</head>
<body>
    <div class="container">
        <form method="POST" action="login.php">
            <h2>Login</h2>
            <label for="username">Username: </label>
            <input type="text" id="username" name="username" required>
            <label for="password">Password: </label>
            <input type="password" id="password" name="password" required>
            <button type="submit">Login</button>
        </form>
    </div>
</body>
</html>
