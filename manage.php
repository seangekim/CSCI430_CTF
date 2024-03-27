<?php
session_start();

include "database.php";
$username = $_SESSION["username"];


$action = $_POST["action"];
$amount = (double) $_POST["amount"];

$stmt = $conn->prepare("SELECT balance FROM users WHERE name=?");
$stmt->bind_param("s", $username); 
$stmt->execute();
$result = $stmt->get_result();
$arr = $result->fetch_assoc();
$current_balance =(double) $arr['balance'];

switch ($action) {
    case "deposit":
        $new_balance = $current_balance + $amount;
        $update_query = "UPDATE users SET balance='$new_balance' WHERE name='$username'";
        mysqli_query($conn, $update_query);
        break;

    case "withdraw":
        if ($amount <= $current_balance) {
            $new_balance = $current_balance - $amount;
            $update_query = "UPDATE users SET balance='$new_balance' WHERE name='$username'";
            mysqli_query($conn, $update_query);

        } else {
            echo "Insufficient fund!";
        }
        break;

    default:
        echo "Error";
        break;
}

header("Location: index.php");
exit();
?>
