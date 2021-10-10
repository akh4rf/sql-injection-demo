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

  $sql = "SELECT * FROM `User` WHERE username='" . $_POST['username'] . "' AND password ='" . $_POST['password'] . "';";
  $statement = $db->prepare($sql);
  $statement->execute();

  $result = $statement->fetchAll();

  if (count($result) > 0) {
    $_SESSION['uid'] = $result[0]['id'];
    header('Location: ./profile.php');
  } else {
    $error_message = 'Invalid username or password';
  }
} else {
}

?>

<body>

  <div class="outer">
    <div class="inner">
      <form id="form" action="login.php" method="post">
        <h1 class="mb-4">Log In</h1>
        <div class="form-group mb-4">
          <label for="username">Username</label>
          <input type="text" class="form-control" name="username" placeholder="Enter Username" required autocomplete="off">
        </div>
        <div class="form-group mb-4">
          <label for="password">Password</label>
          <input type="text" class="form-control" name="password" placeholder="Enter Password" required autocomplete="off">
        </div>
        <?php if (isset($error_message)) : ?>
          <div class="mb-4" style="color: var(--bs-danger);">
            <h6><?php echo $error_message; ?></h6>
          </div>
        <? endif ?>
        <?php if (isset($_GET['success'])) : ?>
          <div class="mb-4" style="color: var(--bs-success);">
            <h6><?php echo $_GET['success']; ?></h6>
          </div>
        <? endif ?>
        <div style="display: flex; justify-content: space-between;">
          <button type="submit" class="btn btn-success">Submit</button>
          <a style="text-decoration: none;" href="./register.php">Sign Up</a>
        </div>
      </form>
    </div>
  </div>

</body>

</html>
