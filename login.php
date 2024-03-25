<?php
// Start the session
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $mysqli = new mysqli("localhost", "username", "password", "database");

    if ($mysqli->connect_error) {
        die("Connection failed: " . $mysqli->connect_error);
    }

    $stmt = $mysqli->prepare("SELECT * FROM users WHERE name = ?");
    
    $stmt->bind_param("s", $_POST['username']);
    
    $stmt->execute();
    
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();

        if (password_verify($_POST['password'], $user['pass'])) {
            $_SESSION['loggedin'] = true;
            $_SESSION['username'] = $_POST['username'];

            header("Location: welcome.php");
            exit();
        } else {
            echo "Invalid username or password.";
        }
    } else {
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
