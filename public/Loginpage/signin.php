<?php
require_once "db_config.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Check if email and password are provided
    if (empty($email) || empty($password)) {
        echo "Please provide both email and password.";
        exit();
    }

    // Check if the user exists
    $sql = "SELECT * FROM users WHERE email = '$email'";
    $result = mysqli_query($conn, $sql);
    if (mysqli_num_rows($result) == 0) {
        echo "User not found.";
        exit();
    }

    // Verify the password
    $row = mysqli_fetch_assoc($result);
    if (!password_verify($password, $row['password'])) {
        echo "Incorrect password.";
        exit();
    }

    // Start a session and store user data
    session_start();
    $_SESSION['user_id'] = $row['id'];
    $_SESSION['user_name'] = $row['name'];
    $_SESSION['user_email'] = $row['email'];

    // Redirect to the user dashboard or homepage
    header("Location: ../Landingpage/Homepage.html");
    exit();
}
?>
