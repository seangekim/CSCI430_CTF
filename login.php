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

    // Prepare the SQL statement
    $stmt = $mysqli->prepare("SELECT * FROM users WHERE username = ?");
    
    // Bind parameters to the SQL statement
    $stmt->bind_param("s", $_POST['username']);
    
    // Execute the statement
    $stmt->execute();
    
    // Get the result of the query
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        // Fetch the user's data
        $user = $result->fetch_assoc();

        // Since you're using password_hash(), you should compare the submitted password directly using password_verify()
        if (password_verify($_POST['password'], $user['hashedPass'])) {
            // Password is correct, so start the session
            $_SESSION['loggedin'] = true;
            $_SESSION['username'] = $_POST['username'];
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

    // Close the statement
    $stmt->close();

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
