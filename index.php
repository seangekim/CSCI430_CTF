<?php
$username = "Eason";
$balance = 0;
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
    <title>User Dashboard</title>
</head>
<body>
    <div class="container">
        <br>
        <h1>Welcome, <?php echo $username; ?></h1>
        <h2>Your current balance is: $<?php echo $balance; ?></h2>
        <br>

        <h3>Manage Your Bank:</h3>
        <form action="manage.php" method="post">
            <div class="mb-1">
                <label for="action" class="form-label">Action:</label>
                <select name="action" id="action" class="form-select">
                    <option value="deposit">Deposit</option>
                    <option value="withdraw">Withdraw</option>
                </select>
            </div>
            <div class="mb-1">
                <label for="amount" class="form-label">Amount:</label>
                <input type="number" name="amount" id="amount" class="form-control">
            </div>
            <button type="submit" class="btn btn-primary mt-3">Submit</button>
            &nbsp&nbsp&nbsp
            <a href="logout.php" class="btn btn-danger mt-3">Logout</a>
        </form>
    </div>
</body>
</html>
