<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST["username"];
    $email = $_POST["email"];
    $current_password = $_POST["current_password"];
   }  
?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8">
    <title>CTF Team - Forgot Password</title>
    <link rel="stylesheet" href="forgot_password.css">
  </head>
  <body>
    <header>
      <img src="2.png" alt="Your Logo">
      <h1>CTF Team - Forgot Password</h1>
      <nav>
        <ul>
          <li><a href="index.php">Home</a></li>
          <li><a href="signin.html">Sign In</a></li>
          <li><a href="signup.html">Sign Up</a></li>
        </ul>
      </nav>
    </header>

    <main>
      <section>
        <?php if (isset($success_message)): ?>
          <p class="success-message"><?= $success_message ?></p>
          <form method="POST" action="reset_password.php">
            <div class="form-group">

              <label for="email">Email:</label>
              <input type="email" id="email" name="email" required>
              <br><br>

              <label for="new_password">New Password:</label>
              <input type="password" id="new_password" name="new_password" required>
              <br><br>

              <label for="confrim_password">Confrim Password:</label>
              <input type="password" id="confrim_password" name="confrim_password" required>
              <br><br>

            </div>
            <button type="submit">Reset Password</button>
          </form>
        <?php elseif (isset($error_message)): ?>
          <p class="error-message"> <?= $error_message ?></p>
        <?php else: ?>
          <h2>Forgot Password? You Noob..!</h2>
          <p>Enter your username and email to reset your password.</p>
          <form method="POST" action="forgot_password.php">
            <div class="form-group">

              <label for="username">Username:</label>
              <input type="text" id="username" name="username" required>
              <br><br>
            
              <label for="email">Email:</label>
              <input type="text" id="email" name="email" required>
              <br><br>

            </div>
            <?php if (isset($verified)): ?>
              <button type="button" disabled>Verified</button>
            <?php else: ?>
              <button type="submit" name="verify">Verify</button>
            <?php endif; ?>
          </form>
        <?php endif; ?>
      </section>
    </main>

    <footer>
      <p>&copy; 2023 CTF Team</p>
    </footer>

  </body>
</html>
