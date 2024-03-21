<?php
// Start the session
session_start();

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Assuming you have a connection to the database set up
    $mysqli = new mysqli("localhost", "username", "password", "database");

    // Check the connection
    if ($mysqli->connect_error) {
        die("Connection failed: " . $mysqli->connect_error);
    }

    // Get the username and password from the form
    $username = $mysqli->real_escape_string($_POST['username']);
    $password = $mysqli->real_escape_string($_POST['password']);

    // Query the database for the user
    $query = "SELECT * FROM users WHERE username = '$username'";
    $query->execute();
    
    $result = $mysqli->query($query);

    $hashedPW = password_hash($password, PASSWORD_DEFAULT);

    if ($result->num_rows > 0) {
        // Fetch the user's data
        $user = $result->fetch_assoc();

        // Verify the password (assuming you are storing hashed passwords)

        if (password_verify($hashedPW, $user['hashedPass'])) {
            // Password is correct, so start the session
            $_SESSION['loggedin'] = true;
            $_SESSION['username'] = $username;
            $_SESSION['user_id'] = $user['id']; // Or whatever user identifier you use

            // Redirect to another page or display a success message
            header("Location: welcome.php");
            exit();
        } else {
            // Password is not correct
            echo "Invalid username or password.";
        }
    } else {
        // No user found with the given username
        echo "Invalid username or password.";
    }

    // Close the connection
    $mysqli->close();
}
?>

<form method="post" action="login.php">
    Username: <input type="text" name="username">
    <br><br>
    Password: <input type="password" name="password">
    <br><br>
    <input type="submit" value="Login">
</form>