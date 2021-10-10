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

if (isset($_POST['secret'])) {

  $sql = "UPDATE UserSecret SET secret = '" . $_POST['secret'] . "' WHERE userID = " . $_SESSION['uid'];
  $statement = $db->prepare($sql);
  $statement->execute();
}

if (isset($_SESSION['uid'])) {

  $sql = "SELECT username, secret FROM User INNER JOIN UserSecret ON User.id = UserSecret.userID WHERE User.id = " . $_SESSION['uid'];
  $statement = $db->prepare($sql);
  $statement->execute();

  $result = $statement->fetchAll();

  if (count($result) > 0) {
    $username = $result[0]['username'];
    $secret = $result[0]['secret'];
  } else {
    $create = "INSERT INTO UserSecret VALUES (" . $_SESSION['uid'] . ", '')";
    $statement = $db->prepare($create);
    $statement->execute();
    header('Location: ./profile.php');
  }
} else {
  header('Location: ./login.php');
}

?>

<body>

  <div class="outer">
    <div class="inner">
      <div style="height: 100%; width: 100%; padding: 5vw;">
        <h1 class="mb-4">Welcome, <?php echo $username; ?>!</h1>
        <p><strong>Secret Message: </strong><?php echo $secret; ?></p>
        <form action="profile.php" method="post">
          <label for="secret" class="mb-2">New Secret Message: </label>
          <input type="text" class="form-control mb-4" name="secret" placeholder="Enter New Secret" autocomplete="off">
          <button type="submit" class="btn btn-success">Submit</button>
          <a type="submit" class="btn btn-danger" href="./logout.php">Log Out</a>
        </form>
      </div>
    </div>
  </div>

</body>

</html>
