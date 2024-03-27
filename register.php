<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css" integrity="sha384-Zenh87qX5JnK2Jl0vWa8Ck2rdkQ2Bzep5IDxbcnCeuOxjzrPF/et3URy9Bv1WTRi" crossorigin="anonymous">
</head>
<body>
    <div class="container">
        <?php
        require_once "database.php";
        if (isset($_POST["submit"])) {
           $name = $_POST["name"];
           $password = $_POST["password"]; 
           $passwordHash = password_hash($password, PASSWORD_DEFAULT);
           $errors = array();
           
           if (empty($name)){
            array_push($errors,"Name is required");
           }  
           if (empty($password)) {
            array_push($errors,"Password is required");
           }
           if (strlen($password)<8) {
            array_push($errors,"Password must be at least 8 charactes long");
           }
           
           $sql = "SELECT * FROM users WHERE name = '$name'";
           $result = mysqli_query($conn, $sql);
           if (mysqli_num_rows($result)>0) {
            array_push($errors,"Name already exists");
           }

           if (count($errors)>0) {
            foreach ($errors as  $error) {
                echo "<div class='alert alert-danger'>$error</div>";
            }
           }
           else{
            $stmt = $conn->prepare("INSERT INTO users (name, password, balance) VALUES ( ?, ?, ?)");
            $balance = 0;
            $stmt->bind_param("ssd",$name, $passwordHash, $balance);
            $stmt->execute();
             
            echo "<div class='alert alert-success'>You are registered successfully.</div>";
            echo $passwordHash;
           }
          

        }
        ?>
        <h1>Registration</h1>
        <form action="register.php" method="post">
            <div class="mb-2">
                <input type="text" class="form-control" name="name" placeholder="name:">
            </div>
            <div class="mb-2">
                <input type="password" class="form-control" name="password" placeholder="password:">
            </div>
            <div class="form-btn">
                <input type="submit" class="btn btn-primary" value="Register" name="submit">
            </div> <br>
        </form>
        <div>
        <div><p>Already Registered? <a href="login.php"> Login Here</a></p></div>
      </div>
    </div>
</body>
</html>
