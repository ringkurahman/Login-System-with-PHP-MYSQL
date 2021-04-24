<?php

if (isset($_POST['submit'])) {
  # Add database connection
  require 'database.php';

  # Grab the data from input
  $username = $_POST['username'];
  $email = $_POST['email'];
  $password = $_POST['password'];
  $confirmPass = $_POST['confirmPassword'];

  # Check empty input fields
  if (empty($username) || empty($email) || empty($password) || empty($confirmPass)) {
    header("Location: ../register.php?error=emptyfields&username=".$username."&email=".$email);
    exit();

    # Check Existing username
  } elseif(!preg_match("/^[a-zA-Z0-9]*/", $username)) {
    header("Location: ../register.php?error=invalidusername&username=".$username."&email=".$email);
    exit();

    # Check email format
  } elseif(!filter_var($_POST["email"], FILTER_VALIDATE_EMAIL)) {
    header("Location: ../register.php?error=wrongemailformat&username=".$username."&email=".$email);
    exit();

    # Check match password
  } elseif($password !== $confirmPass) {
    header("Location: ../register.php?error=passwordsdonotmatch&username=".$username."&email=".$email);
    exit();

    # Check error server connection
  } else {
    $sql = "SELECT username FROM users WHERE username = ?";
    $stmt = mysqli_stmt_init($conn);

    if (!mysqli_stmt_prepare($stmt, $sql)) {
      header("Location: ../register.php?error=sqlerror");
      exit();
    }else {
      mysqli_stmt_bind_param($stmt, "ss", $username, $email);
      mysqli_stmt_execute($stmt);
      mysqli_stmt_store_result($stmt);
      $rowCount = mysqli_stmt_num_rows($stmt);

      if ($rowCount > 0) {
        header("Location: ../register.php?error=usernametaken");
        exit();

        # Store data into database
      }else {
        $sql = "INSERT INTO users (username, email, password) VALUES (?,?,?)";
        $stmt = mysqli_stmt_init($conn);
          if (!mysqli_stmt_prepare($stmt, $sql)) {
            header("Location: ../register.php?error=sqlerror");
            exit();
          } else {
            $hashedPass = password_hash($password, PASSWORD_DEFAULT);
            mysqli_stmt_bind_param($stmt, "sss", $username, $email, $hashedPass);
            mysqli_stmt_execute($stmt);

            header("Location: ../register.php?success=registered");
            exit();
          }
      }

    }
  }
  mysqli_stmt_close($stmt);
  mysqli_close($conn);
}
