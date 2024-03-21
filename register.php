<!DOCTYPE HTML>  
<html>
<head>
<style>
.error {color: #FF0000;}
</style>
</head>
<body>  

<?php
// Define variables and set to empty values
$userErr = $passErr = "";
$error = FALSE;
$user = $pass = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  if (empty($_POST["user"])) {
    $error = TRUE;
    $userErr = "Username is required"; 
  } else {
    $user = test_input($_POST["user"]);
    // Check if username only contains letters and numbers
    if (!preg_match("/^[a-zA-Z0-9]*$/", $user)) {
      $userErr = "Only letters and numbers allowed";
      $error = TRUE;
    }
  }
  
  if (empty($_POST["pass"])) {
    $passErr = "Password is required";
    $error = TRUE;
  } else {
    $pass = test_input($_POST["pass"]);
    // Check if password is long enough
    if (strlen($pass) < 8) {
      $passErr = "Password too short";
      $error = TRUE;
    }
  }

  if (!$error) {
    // Connect to MySQL database
    $mysqli = new mysqli("localhost", "root", "root", "bank");
    
    // Check connection
    if ($mysqli->connect_errno) {
      echo "Failed to connect to MySQL: " . $mysqli->connect_error;
      exit();
    }
    //password is hashed before the preparation of the sql statement
    // Hash password before storing it
    $hashedPass = password_hash($pass, PASSWORD_DEFAULT);

    // Prepare statement to insert user data
    $stmt = $mysqli->prepare("INSERT INTO users (username, password, some_other_field) VALUES (?, ?, 0)");
    $stmt->bind_param("ss", $user, $hashedPass); // 'ss' denotes two strings

    // Execute the prepared statement
    $stmt->execute();

    // Close statement and connection
    $stmt->close();
    $mysqli->close();
  }
}

// Function to sanitize input data
function test_input($data) {
  $data = trim($data);
  $data = stripslashes($data);
  $data = htmlspecialchars($data);
  return $data;
}
?>

<h2>PHP Form Validation Example</h2>
<p><span class="error">* required field</span></p>
<form method="post" action="index.php">
  Username: <input type="text" name="user" value="<?php echo htmlspecialchars($user); ?>"> <!-- Corrected attribute to 'name' -->
  <span class="error">* <?php echo $userErr; ?></span>
  <br><br>
  Password: <input type="password" name="pass" value="<?php echo htmlspecialchars($pass); ?>"> <!-- Changed to 'password' type -->
  <span class="error">* <?php echo $passErr; ?></span>
  <br><br>
  <input type="submit" name="submit" value="Submit">  
</form>

<?php
// Display sanitized user input
echo "<h2>Your Input:</h2>";
echo htmlspecialchars($user);
echo "<br>";
echo htmlspecialchars($pass);
?>

</body>
</html>
