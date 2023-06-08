<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST["username"];
    $email = $_POST["email"];
    $currentPassword = $_POST["password"];
    $new_Password = $_POST["new_password"];
    $confirm_Password = $_POST["confirm_password"];

    // Perform password reset and update logic here
    // Replace this code with your database update logic

    if ($new_Password !== $confirm_Password) {
        $errorMessage = "Passwords do not match.";
        echo "<script>alert('$errorMessage'); window.location = 'forgot.html';</script>";
        exit();
    }

    // TODO: Check the user's credentials in the database and update the password
    // For this example, we'll assume the credentials are correct and update the password directly

    // Database connection details
    $host = "localhost";
    $dbUsername = "root";
    $dbPassword = "";
    $dbname = "CTF";

    // Create a new MySQLi instance
    $conn = new mysqli($host, $dbUsername, $dbPassword, $dbname);

    // Check for connection errors
    if (mysqli_connect_error()) {
        die('Connect error (' . mysqli_connect_errno() . ') ' . mysqli_connect_error());
    }

    // var_dump($username, $email, $currentPassword, $new_Password, $confirm_Password); // Check the values

    // Check if the email and current password match in the database
    $SELECT = "SELECT username FROM users WHERE username = ? AND email = ? AND password = ?";
    $stmt = $conn->prepare($SELECT);
    $stmt->bind_param("sss", $username, $email, $currentPassword);
    $stmt->execute();
    $stmt->store_result();
    $rnum = $stmt->num_rows;

    if ($rnum == 1) {
        // Update the user's password
        $UPDATE = "UPDATE users SET password = ? WHERE username = ?";
        $stmt = $conn->prepare($UPDATE);
        $stmt->bind_param("ss", $new_Password, $username);
        $stmt->execute();

        $successMessage = "Password reset successful. You can now sign in with your new password.";
        echo "<script>alert('$successMessage'); window.location = 'signin.html';</script>";
        exit();
    } else {
        $errorMessage = "Invalid credentials. Please try again.";
        echo "<script>alert('$errorMessage'); window.location = 'forgot.html';</script>";
        exit();
    }

    // Close the database connection
    $stmt->close();
    $conn->close();
}
?>
