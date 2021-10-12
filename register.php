<?php session_start(); ?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="styles.css">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/css/bootstrap.min.css" integrity="sha384-F3w7mX95PdgyTmZZMECAngseQB83DfGTowi0iMjiWaeVhAn4FJkqJByhZMI3AhiU" crossorigin="anonymous">
  <title>SQL Injection Demo</title>
</head>

<?php

include 'db-connect.php';

if (isset($_POST['username']) && isset($_POST['password'])) {

  $sql = "INSERT INTO `User` VALUES (NULL, '" . $_POST['username'] . "', '" . $_POST['password'] . "');";
  $statement = $db->prepare($sql);
  $result = $statement->execute();

  if ($result) {
    header('Location: ./login.php?success=User%20created!');
  } else {
    $error_message = 'Error registering user';
  }
} else {
}

?>

<body>

  <div class="outer">
    <div class="inner">
      <form id="form" action="register.php" method="post">
        <h1 class="mb-4">Sign Up</h1>
        <div class="form-group mb-4">
          <label for="username">Username</label>
          <input type="text" class="form-control" name="username" placeholder="Enter Username" required autocomplete="off" autofocus>
        </div>
        <div class="form-group mb-4">
          <label for="password">Password</label>
          <input type="text" class="form-control" name="password" placeholder="Enter Password" required autocomplete="off">
        </div>
        <div class="mb-4" style="color: var(--bs-danger);">
          <h6><?php if (isset($error_message)) {
                echo $error_message;
              } ?></h6>
        </div>
        <div style="display: flex; justify-content: space-between;">
          <button type="submit" class="btn btn-success">Submit</button>
          <a style="text-decoration: none;" href="./login.php">Sign In</a>
        </div>
      </form>
    </div>
  </div>

</body>

</html>
