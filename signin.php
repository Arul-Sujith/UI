<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $host = "localhost";
    $dbUsername = "root";
    $dbPassword = "";
    $dbName = "CTF";

    $username = $_POST["username"];
    $password = $_POST["password"];

    $conn = new mysqli($host, $dbUsername, $dbPassword, $dbName);

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $stmt = $conn->prepare("SELECT * FROM users WHERE username = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows == 0) {
        $errorMessage = "No such user exists";
        echo "<script>alert('$errorMessage'); window.location = 'signin.html';</script>";
    } else {
        $matchingUsernames = array();

        while ($row = $result->fetch_assoc()) {
            if ($row['password'] === $password) {
                echo "Correct Credentials";
                session_start();
                $_SESSION['auth'] = 'true';
                header("Location: signup_success.html");
                exit();
            } else if ($row['password'] !== $password) {
                $matchingUsernames[] = $row['username'];
            }
        }

        if (!empty($matchingUsernames)) {
            $errorMessage = "Wrong password, this password is currently being used by " . implode(", ", $matchingUsernames) . " 😂😂";
            echo "<script>alert('$errorMessage'); window.location = 'signin.html';</script>";
        } else {
            $errorMessage = "Wrong password";
            echo "<script>alert('$errorMessage'); window.location = 'signin.html';</script>";
        }
    }

    $stmt->close();
    $conn->close();
} else {
    $errorMessage = "Invalid request";
    echo "<script>alert('$errorMessage'); window.location = 'signin.html';</script>";
}
?>
