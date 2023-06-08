<?php
$username = $_POST["username"];
$password = $_POST["password"];
$gender = $_POST["gender"];
$email = $_POST["email"];

if (!empty($username) || !empty($password) || !empty($gender) || !empty($email)) {
    $host = "localhost";
    $dbUsername = "root";
    $dbPassword = "";
    $dbname = "CTF";

    $conn = new mysqli($host, $dbUsername, $dbPassword, $dbname);

    if (mysqli_connect_error()) {
        die('Connect error (' . mysqli_connect_errno() . ')' . mysqli_connect_error());
    } else {
        $SELECT_USERNAME = "SELECT * FROM users WHERE username=? LIMIT 1";
        $SELECT_EMAIL = "SELECT * FROM users WHERE email=? LIMIT 1";
        $INSERT = "INSERT INTO users (username, password, gender, email) VALUES (?,?,?,?)";

        $stmt_username = $conn->prepare($SELECT_USERNAME);
        $stmt_username->bind_param("s", $username);
        $stmt_username->execute();
        $stmt_username->store_result();
        $num_username_rows = $stmt_username->num_rows;

        $stmt_email = $conn->prepare($SELECT_EMAIL);
        $stmt_email->bind_param("s", $email);
        $stmt_email->execute();
        $stmt_email->store_result();
        $num_email_rows = $stmt_email->num_rows;

        if ($num_username_rows == 0 && $num_email_rows == 0) {
            $stmt_username->close();
            $stmt_email->close();
            $stmt_insert = $conn->prepare($INSERT);
            $stmt_insert->bind_param("ssss", $username, $password, $gender, $email);
            $stmt_insert->execute();
            $Message = "Account has been created successfully.";
            echo "<script>alert('$Message'); window.location = 'signin.html';</script>";
        } elseif ($num_username_rows > 0) {
            $stmt_username->close();
            $error_Message = "This username already exists.";
            echo "<script>alert('$error_Message'); window.location = 'signin.html';</script>";
        } else {
            $stmt_email->close();
            $error_Message = "This email already exists.";
            echo "<script>alert('$error_Message'); window.location = 'signin.html';</script>";
        }
        $stmt_username->close();
        $stmt_email->close();
        $conn->close();
    }
} else {
    echo "All fields are required";
    die();
}
?>
