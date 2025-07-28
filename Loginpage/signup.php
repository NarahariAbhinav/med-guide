<?php
require_once "db_config.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $confirmPassword = $_POST['confirmPassword'];

    // Check if passwords match
    if ($password !== $confirmPassword) {
        echo "Passwords do not match.";
        exit();
    }

    // Hash the password
    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

    // Check if user already exists
    $check_sql = "SELECT * FROM users WHERE email = '$email'";
    $result = mysqli_query($conn, $check_sql);
    if (mysqli_num_rows($result) > 0) {
        echo "User already exists.";
        exit();
    }

    // Insert the user into the database
    $insert_sql = "INSERT INTO users (name, email, password) VALUES ('$name', '$email', '$hashedPassword')";
    if (mysqli_query($conn, $insert_sql)) {
        // Store user details in session
        session_start();
        $_SESSION['email'] = $email;
        $_SESSION['name'] = $name;
        
        // Redirect to homepage
        header("Location: ../index.php");
        exit();
    } else {
        echo "Error: " . $insert_sql . "<br>" . mysqli_error($conn);
    }
} else {
    echo "Invalid request method.";
}
?>
