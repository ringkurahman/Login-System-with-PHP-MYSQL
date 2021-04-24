<?php
 require_once 'includes/header.php';
?>

<div>
  <h1>Register</h1>
  <p>Already have an account?<a href="login.php">Login</a></p>

  <form action="includes/register-inc.php" method="post">
      <input type="text" name="username" placeholder="Username">
      <input type="email" name="email" placeholder="Email">
      <input type="password" name="password" placeholder="Password">
      <input type="password" name="confirmPassword" placeholder="confirmPassword">
      <button type="submit" name="submit">Submit</button>
  </form>
</div>

<?php
 require_once 'includes/footer.php';
?>