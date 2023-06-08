<?php
	
    $email = $_POST["email"];
		$new_password = $_POST["new_password"];
		$confirm_password = $_POST["confirm_password"];


		if (!empty($email) || !empty($new_password) || !empty($confirm_password)){
			$host = "localhost";
			$dbUsername = "root";
			$dbPassword = "";
			$dbname = "CTF";
			
			$conn = new mysqli($host, $dbUsername, $dbPassword, $dbname);


			if($new_password !== $confirm_password){
				$errorMessage = ""Passwords does not match;
	            echo "<script>alert('$errorMessage'); window.location ='forgot_password.php';</script>";
				die();
			} else {
				if(mysqli_connect_error()){
					die('Connect error ('.mysql_connect_error().')'.mysqli_connect_error());
				} else {
					$SELECT = "SELECT email From users Where email=? Limit 1";
		
					$UPDATE = "UPDATE users SET password = ? WHERE email = ?";
					$stmt = $conn->prepare($SELECT);
					$stmt->bind_param("s", $email);
					$stmt->execute();
					$stmt->bind_result($email);
					$stmt->store_result();
					$rnum = $stmt->num_rows;
					
					if ($rnum == 1){
						$stmt->close();
						$stmt = $conn->prepare($UPDATE);
						$stmt->bind_param("ss",  $new_password, $username);
						$stmt->execute();
						$Message = "Reset Succesfull";
						echo "<script>alert('$Message'); window.location = 'signin.html';</script>";
					} else{
						$error_Message = "This email id does not exist";
						echo "<script>alert('$error_Message'); window.location = 'signin.html';</script>";
					}
					$stmt->close();
					$conn->close();
				}
			}	
		} else {
			echo "All fields are required";
			die();
		}
	
?>